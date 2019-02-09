<?php
/**
 *  ... Please MODIFY this file ... 
 *
 *
 *  YOUR MYSQL DATABASE DETAILS
 *
 */

 define("DB_HOST", 	"173.212.204.179");				// hostname
 define("DB_USER", 	"forge");		// database username
 define("DB_PASSWORD", 	"OAkpd4BPI9B0hh4Ue8pe");		// database password
 define("DB_NAME", 	"donation");	// database name



/**
 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
 *  Place values from your gourl.io signup page
 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional), etc...");
 */
 
 $cryptobox_private_keys = array("11839AA2328vBitcoin77BTCPRVE0bmy2J3gls6vOlBBm1YOY3", "11796AA9UR2aBitcoin77BTCPRVYYRe0eD3JKPEwvWEcbYadsd");




 define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
 unset($cryptobox_private_keys); 

?>