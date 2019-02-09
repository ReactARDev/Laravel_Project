<?php
class ICDB {
	var $server = "";
	var $port = "";
	var $db = "";
	var $user = "";
	var $password = "";
	var $prefix = "";
	var $insert_id;
	var $link;
	var $use_mysqli = false;

	function __construct($_server, $_port, $_db, $_user, $_password, $_prefix) {
		$this->server = $_server;
		$this->port = $_port;
		$this->db = $_db;
		$this->user = $_user;
		$this->password = $_password;
		$this->prefix = $_prefix;
		$host = $this->server;
		if (!empty($this->port)) $host .= ':'.$this->port;
		if (function_exists('mysqli_connect')) {
			$this->use_mysqli = true;
			$this->link = mysqli_connect($host, $this->user, $this->password);
			if (!$this->link) throw new Exception('Could not connect: '.mysqli_connect_error());
			if (!mysqli_select_db($this->link, $this->db)) throw new Exception('Can not use database: '.mysqli_error($this->link));
			if (!mysqli_query($this->link, 'SET NAMES utf8')) throw new Exception('Invalid query: '.mysqli_error($this->link));
		} else {
			$this->link = mysql_connect($host, $this->user, $this->password);
			if (!$this->link) throw new Exception('Could not connect: '.mysql_error());
			if (!mysql_select_db($this->db, $this->link)) throw new Exception('Can not use database: '.mysql_error($this->link));
			if (!mysql_query('SET NAMES utf8', $this->link)) throw new Exception('Invalid query: '.mysql_error($this->link));
		}
	}
	
	function get_row($_sql) {
		$result = $this->query($_sql);
		$row = null;
		if ($this->use_mysqli) {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			mysqli_free_result($result);
		} else {
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			mysql_free_result($result);
		}
		return $row;
	}
	
	function get_rows($_sql) {
		$result = $this->query($_sql);
		$rows = array();
		if ($this->use_mysqli) {
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$rows[] = $row;
			}
			mysqli_free_result($result);
		} else {
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$rows[] = $row;
			}
			mysql_free_result($result);
		}
		return $rows;
	}
	

	function get_var($_sql) {
		$result = $this->query($_sql);
		if ($this->use_mysqli) {
			$row = mysqli_fetch_array($result, MYSQLI_NUM);
			mysqli_free_result($result);
		} else {
			$row = mysql_fetch_array($result, MYSQL_NUM);
			mysql_free_result($result);
		}
		if ($row && is_array($row)) return $row[0];
		return false;
	}
	
	function query($_sql) {
		if ($this->use_mysqli) {
			$result = mysqli_query($this->link, $_sql);
			if (!$result) throw new Exception('Invalid query: ' . mysqli_error($this->link));
		} else {
			$result = mysql_query($_sql, $this->link);
			if (!$result) throw new Exception('Invalid query: ' . mysql_error($this->link));
		}
		if (preg_match('/^\s*(insert|replace)\s/i', $_sql)) {
			if ($this->use_mysqli) {
				$this->insert_id = mysqli_insert_id($this->link);
			} else {
				$this->insert_id = mysql_insert_id($this->link);
			}
		}
		return $result;
	}
	
	function escape_string($_string) {
		if ($this->use_mysqli) {
			return mysqli_real_escape_string($this->link, $_string);
		}
		return mysql_real_escape_string($_string, $this->link);
	}
}
?>