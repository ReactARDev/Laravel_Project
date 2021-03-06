<?php
/** DO NOT MODIFY OPTIONS BELOW. YOU CAN MODIFY THEM VIA ADMIN PANEL. */
define('VERSION', '1.60');
define('RECORDS_PER_PAGE', '50');
define('DEMO_MODE', false);
define('TABLE_PREFIX', 'udb_');
define('STATUS_DRAFT', 0);
define('STATUS_ACTIVE', 1);
define('STATUS_PENDING', 7);

$options = array (
	"version" => VERSION,
	"owner_email" => "alerts@".str_replace("www.", "", $_SERVER["SERVER_NAME"]),
	"mail_method" => "mail",
	"mail_from_name" => "Universal Donation Box",
	"mail_from_email" => "noreply@".str_replace("www.", "", $_SERVER["SERVER_NAME"]),
	"smtp_server" => '',
	"smtp_port" => '',
	"smtp_secure" => 'none',
	"smtp_username" => '',
	"smtp_password" => '',
	"success_email_subject" => "Thank you for donation",
	"success_email_body" => "Dear {payer_name},".PHP_EOL.PHP_EOL."Thank you for your donation. We appreciate it.".PHP_EOL.PHP_EOL."Thanks,".PHP_EOL."Universal Donation Box",
	"failed_email_subject" => "Donation was not completed",
	"failed_email_body" => "Dear {payer_name},".PHP_EOL.PHP_EOL."Thank you for your donation. Unfortunately, it was not completed.".PHP_EOL."Donation status: {payment_status}.".PHP_EOL."We will review your donation shortly.".PHP_EOL.PHP_EOL."Thanks,".PHP_EOL."Universal Donation Box",
	"csv_separator" => ";",
	"enable_paypal" => "off",
	"paypal_id" => "",
	"enable_payza" => "off",
	"payza_id" => "",
	"payza_sandbox" => "off",
	"enable_interkassa" =>"off",
	"interkassa_checkout_id" => "",
	"interkassa_secret_key" => "",
	"enable_authnet" => "off",
	"authnet_login" => "",
	"authnet_sandbox" => "off",
	"authnet_key" => "",
	"authnet_md5hash" => "",
	"enable_skrill" => "off",
	"skrill_id" => "",
	"skrill_secret_word" => "",
	"enable_egopay" => "off",
	"egopay_store_id" => "",
	"egopay_store_pass" => "",
	"enable_perfect" => "off",
	"perfect_account_id" => "",
	"perfect_payee_name" => "",
	"perfect_passphrase" => "",
	"enable_bitpay" => "off",
	"bitpay_key" => "",
	"bitpay_speed" => "medium",
	"enable_stripe" => "off",
	"stripe_secret" => "",
	"stripe_publishable" => "",
	"enable_bitcoin" => "off",
	"bitcoin_public" => "",
	"bitcoin_private" => "",
	"login" => "admin",
	"password" => "21232f297a57a5a743894a0e4a801fc3"
);
$paypal_currency_list = array("USD", "AUD", "BRL", "CAD", "CHF", "CZK", "DKK", "EUR", "GBP", "HKD", "HUF", "ILS", "JPY", "MXN", "MYR", "NOK", "NZD", "PHP", "PLN", "RUB", "SEK", "SGD", "THB", "TRY", "TWD");
$payza_currency_list = array("AUD", "BGN", "CAD", "CHF", "CZK", "DKK", "EEK", "EUR", "GBP", "HKD", "HUF", "INR", "LTL", "MYR", "MKD", "NOK", "NZD", "PLN", "RON", "SEK", "SGD", "USD", "ZAR");
$skrill_currency_list = array("EUR","TWD","USD","THB","GBP","CZK","HKD","HUF","SGD","SKK","JPY","EEK","CAD","BGN","AUD","PLN","CHF","ISK","DKK","INR","SEK","LVL","NOK","KRW","ILS","ZAR","MYR","RON","NZD","HRK","TRY","LTL","AED","JOD","MAD","OMR","QAR","RSD","SAR","TND");
$interkassa_currency_list = array("USD", "EUR", "RUB", "UAH");
$egopay_currency_list = array("USD", "EUR");
$perfect_currency_list = array("USD", "EUR");
$bitpay_currency_list = array("USD", "EUR", "GBP", "AUD", "CAD", "CHF", "CNY", "RUB", "DKK", "HKD", "PLN", "SGD", "THB", "BTC");
$stripe_currency_list = array("AED", "AFN", "ALL", "AMD", "ANG", "AOA", "ARS", "AUD", "AWG", "AZN", "BAM", "BBD", "BDT", "BGN", "BIF", "BMD", "BND", "BOB", "BRL", "BSD", "BWP", "BZD", "CAD", "CDF", "CHF", "CLP", "CNY", "COP", "CRC", "CVE", "CZK", "DJF", "DKK", "DOP", "DZD", "EEK", "EGP", "ETB", "EUR", "FJD", "FKP", "GBP", "GEL", "GIP", "GMD", "GNF", "GTQ", "GYD", "HKD", "HNL", "HRK", "HTG", "HUF", "IDR", "ILS", "INR", "ISK", "JMD", "JPY", "KES", "KGS", "KHR", "KMF", "KRW", "KYD", "KZT", "LAK", "LBP", "LKR", "LRD", "LSL", "LTL", "LVL", "MAD", "MDL", "MGA", "MKD", "MNT", "MOP", "MRO", "MUR", "MVR", "MWK", "MXN", "MYR", "MZN", "NAD", "NGN", "NIO", "NOK", "NPR", "NZD", "PAB", "PEN", "PGK", "PHP", "PKR", "PLN", "PYG", "QAR", "RON", "RSD", "RUB", "RWF", "SAR", "SBD", "SCR", "SEK", "SGD", "SHP", "SLL", "SOS", "SRD", "STD", "SVC", "SZL", "THB", "TJS", "TOP", "TRY", "TTD", "TWD", "TZS", "UAH", "UGX", "USD", "UYU", "UZS", "VND", "VUV", "WST", "XAF", "XCD", "XOF", "XPF", "YER", "ZAR", "ZMW");
$bitcoin_currency_list = array("USD");

$mail_methods = array('mail' => 'PHP Mail() function', 'smtp' => 'SMTP');
$smtp_secures = array('none' => 'None', 'ssl' => 'SSL', 'tls' => 'TLS');

?>