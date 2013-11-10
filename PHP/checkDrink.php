<?php

// this will return -1 if the order is invalid 
// and will return the time when it was ordered

function returnFailed(){
// return 0 for failed.  
   exitWithBarcodeAndTime();
}

function exitWithBarcodeAndTime($barcode = -1, $timeRemaining = -1) {
	$arr = array('barcode'=>$barcode, 'time'=>$timeRemaining);
	echo json_encode($arr);
	die();
}

// ini_set('display_errors', 'On');
// error_reporting(E_ALL);

	header('Content-Type: application/json');

	 if (!isset($_POST["barcode"])) {
		returnFailed();
	}

	$barcode = $_POST["barcode"];
	// echo $barcode;
	// $barcode = "15BFB983B4D9DF5AE8C9B0F0786ACACCD1";

	$dbHost="localhost"; // Host name 
	$dbUsername="root"; // Mysql username 
	$dbPassword="password"; // Mysql password 
	$dbName="SD"; // Database name 

	// Connect to server and select databse.
	$dbCon = mysqli_connect("$dbHost", "$dbUsername", "$dbPassword", "$dbName");

	if (mysqli_connect_errno($dbCon)) {
		// echo "Failed to connect to MySQL: " . mysqli_connect_error();
		returnFailed();
	} 

	if (!mysqli_set_charset($dbCon, "utf8")) {
		// echo "Failed to set charset";
		returnFailed();
	}

	// select orderTIme and subtract 600s (10 Mins) update orderTime
	// a drink that is expired or picked up can not be canceld, so only get barcodes that are valid
	$query = "SELECT orderTime  FROM orderTable WHERE expired=\"false\" AND pickedUp=\"false\" AND orderID=\"" . $barcode . "\"";

	$result = mysqli_query($dbCon, $query);
	$row = mysqli_fetch_array($result);
	if (!$row) {
		// echo "unable to fetch order";
		returnFailed();
	}

	$orderTime = intval($row['orderTime']);

	// fetch current Time
	date_default_timezone_set("America/New_York");
	$date = date_create();
	$currentTime = date_timestamp_get($date);

	$remainingTime = $currentTime - $orderTime + 600;
	if ($remainingTime < 0) {
		$remainingTime = -1;
	}

	exitWithBarcodeAndTime($barcode, $remainingTime);
?>
