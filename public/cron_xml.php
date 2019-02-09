<?php



define( 'IS_DEV', true );

if( IS_DEV ) {
	 define( 'URL_MAIN_TEST', 'https://theathletic.com/feed/' );
}


// set timezone
date_default_timezone_set("UTC");

//DB Connection- Using PDO
//$db = new PDO('mysql:host=localhost;dbname=forge;charset=utf8mb4', 'root', 'root');

$data_xml = simplexml_load_file(URL_MAIN_TEST) or die("Error: Cannot create object");


//return;

foreach ($data_xml->channel[0]->item as $record)
{
	$ns_media = $record->children('http://www.uefa.com/rssfeed/news/rss.xml');


	$title 		= $record->title;
	$link 		= $record->link;
	$descr 		= $record->description;
	//$thumb		= $record->image;
	//$image_url	= $ns_media->content->attributes()['url'];// displays "<media:content>"

	echo ("--------------------\n");
	echo "<br>";
	echo ("Title =     :".$title);
	echo "<br>";
	
	echo "Feed_Link=   :".$link;
	echo "<br>";
	echo "Description= :".$descr;
	echo "<br>";
	//echo "thmbnail= :".$thumb;
	echo "<br>";
	echo "--------------------\n";
	echo "<br>";
	echo "<br>";
	
	//funcInsertDB($title, $link, $descr, $image_url);
}



?>
