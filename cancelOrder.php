<?php

function returnFailed(){
// return 0 for failed.
	$arr = array ('success'=>0);
    echo json_encode($arr);
	die();

}
ini_set('display_errors', 'On');
error_reporting(E_ALL);


	if (!isset($_POST["barcode"])) {
		returnFailedAllocate();
	}

	$barcode = $_POST["barcode"];

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
    	returnFailedAllocate();
	}

	// select orderTIme and subtract 600s (10 Mins) update orderTime
	$query = "SELECT orderTime FROM orderTable WHERE orderID=\"" .$barcode . "\"";

	$safeQuery = mysqli_real_escape_string($dbCon, $query);

	$result = mysqli_query($dbCon, $safeQuery);

	$row = mysqli_fetch_array($result);

	if (!$row) {
	 	returnFailed();		
	}

	$orderTime = intval($row['orderTime']);
	$orderTime = $orderTime - 600;

	$query = 'UPDATE orderTable SET orderTime="' . $orderTime . '" WHERE orderID="' . $barcode .'"';
	
	$safeQuery = mysqli_real_escape_string($dbCon, $query);
	$result = mysqli_query($dbCon, $safeQuery);

	$row = mysqli_fetch_array($result);
	if (!$row) {
	 	returnFailed();		
	}

	echo "{\"Success\":\"1\"}";


?>