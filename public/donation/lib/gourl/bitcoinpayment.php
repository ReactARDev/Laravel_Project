<?php

	$url_base = ((empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] == 'off') ? 'http://' : 'https://').$_SERVER["HTTP_HOST"];
    $donate_page_url = $url_base.'/donate';

	$is_valid = isset($_POST["user_id"]) &&
				isset($_POST["order_id"]) &&
				is_numeric($_POST["order_id"]) &&
				isset($_POST["currency_code"]) &&
				isset($_POST["public_key"]) &&
				isset($_POST["private_key"]) &&
				isset($_POST["amount"]) &&
				is_numeric($_POST["amount"]) &&
				$_POST["amount"] > 0;

	if ($is_valid) {
		require_once( "BitcoinPayment/cryptobox.class.php" );
		
		/**** CONFIGURATION VARIABLES ****/ 
		$userID 		= $_REQUEST['user_id'];
		$userFormat		= "COOKIE";
		$orderID 		= $_REQUEST['order_id'];
		$currency       = $_REQUEST['currency_code'];
		$amountUSD		= $_REQUEST['amount'];	
		$period			= "NOEXPIRY";		
		$def_language	= "en";
		$public_key		= $_REQUEST['public_key'];
		$private_key	= $_REQUEST['private_key'];

		// IMPORTANT: Please read description of options here - https://gourl.io/api-php.html#options  
		
		// *** For convert Euro/GBP/etc. to USD/Bitcoin, use function convert_currency_live() with Google Finance
		// *** examples: convert_currency_live("EUR", "BTC", 22.37) - convert 22.37 Euro to Bitcoin
		// *** convert_currency_live("EUR", "USD", 22.37) - convert 22.37 Euro to USD

		/********************************/
		
		/** PAYMENT BOX **/
		$options = array(
				"public_key"  => $public_key, 	// your public key from gourl.io
				"private_key" => $private_key, 	// your private key from gourl.io
				"webdev_key"  => "", 		// optional, gourl affiliate key
				"orderID"     => $orderID, 		// order id or product name
				"userID"      => $userID, 		// unique identifier for every user
				"userFormat"  => $userFormat, 	// save userID in COOKIE, IPADDRESS or SESSION
				"amount"   	  => 0,				// product price in coins OR in USD below
				"amountUSD"   => $amountUSD,	// we use product price in USD
				"period"      => $period, 		// payment valid period
				"language"	  => $def_language  // text on EN - english, FR - french, etc
		);


		// Initialise Payment Class
		$box = new Cryptobox ($options);
		
		// coin name
		$coinName = $box->coin_name();
		
		// Successful Cryptocoin Payment received
		if ($box->is_paid()) 
		{
			if (!$box->is_confirmed()) {
				$message =  "Thank you for order (order #".$orderID.", payment #".$box->payment_id()."). Awaiting transaction/payment confirmation";
			}											
			else 
			{ // payment confirmed (6+ confirmations)

				// one time action
				if (!$box->is_processed())
				{
					// One time action after payment has been made/confirmed
					// !!For update db records, please use function cryptobox_new_payment()!!
					
					$message = "Thank you for order (order #".$orderID.", payment #".$box->payment_id()."). Payment Confirmed. <br>(User will see this message one time after payment has been made)"; 
					
					// Set Payment Status to Processed
					$box->set_status_processed();  
				}
				else $message = "Thank you for order (order #".$orderID.", payment #".$box->payment_id()."). Payment Confirmed. <br>(User will see this message during ".$period." period after payment has been made)"; // General message
			}
		}
		else $message = "This invoice has not been paid yet";
		
		
		// Optional - Language selection list for payment box (html code)
		$languages_list = display_language_box($def_language);

		// ...
		// Also you need to use IPN function cryptobox_new_payment($paymentID = 0, $payment_details = array(), $box_status = "") 
		// for send confirmation email, update database, update user membership, etc.
		// You need to modify file - cryptobox.newpayment.php, read more - https://gourl.io/api-php.html#ipn
		// ...
			
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Donate with <?php echo $coinName; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='Expires' content='-1'>
<meta name='robots' content='all'>
<?php
	if (!$is_valid) {
		echo '<script>window.location.url="'.$donate_page_url.'"</script>';
	}
?>

<script src='cryptobox.min.js' type='text/javascript'></script>
</head>
<body style='font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#666;margin:0'>
<div align='center'>
<div style='width:100%;height:auto;line-height:50px;background-color:#f1f1f1;border-bottom:1px solid #ddd;color:#49abe9;font-size:18px;'>
</div>

<br><br>
<div style='margin:30px 0 5px 300px'>Language: &#160; <?php echo $languages_list; ?></div>
<?php echo $box->display_cryptobox(true, 580, 230); ?>


</div>
</body>
</html>