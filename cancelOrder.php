<?php

function returnFailed(){
// return 0 for failed.
	echo "{\"Success\":\"0\"}";
	die();

}
ini_set('display_errors', 'On');
error_reporting(E_ALL);


$barcode = "15BFB983B4D9DF5AE8C9B0F0786ACACCD1";

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

	// $columnName = mysqli_real_escape_string($columnName);
	// $searchInput = mysqli_real_escape_string($searchInput);

	// echo "got past ingred compares\n";

	// select orderTIme and subtract 600s (10 Mins) update orderTime

	// $query = 'UPDATE orderTable SET expired="true" WHERE orderID="' . $barcode .'"';
	
	$query = "SELECT orderTime FROM orderTable WHERE orderID=\"" .$barcode . "\"";

	$result = mysqli_query($dbCon, $query);

	$row = mysqli_fetch_array($result);

	if (!$row) {
	 	returnFailed();		
	}



	$orderTime = intval($row['orderTime']);
	$orderTime = $orderTime - 600;



	$query = 'UPDATE orderTable SET orderTime="' . $orderTime . '" WHERE orderID="' . $barcode .'"';
	$result = mysqli_query($dbCon, $query);
	$row = mysqli_fetch_array($result);
	if (!$row) {
	 	returnFailed();		
	}

	echo "{\"Success\":\"1\"}";


?>