<?php

function returnFailedAllocate(){
	$arr = array ('barcode'=>-1);
    echo json_encode($arr);
	die();

}

// ini_set('display_errors', 'On');
// error_reporting(E_ALL);

	$dbHost="localhost"; // Host name 
	$dbUsername="root"; // Mysql username 
	$dbPassword="password"; // Mysql password 
	$dbName="SD"; // Database name 

	header('Content-Type: application/json');

	// Connect to server and select databse.
	$dbCon = mysqli_connect("$dbHost", "$dbUsername", "$dbPassword", "$dbName");
	if (mysqli_connect_errno($dbCon)) {
    	// echo "Failed to connect to MySQL: " . mysqli_connect_error();
    	returnFailedAllocate();
	} 

	if (!mysqli_set_charset($dbCon, "utf8")) {
		// echo 'unable to change charset';
    	returnFailedAllocate();
	}

	// $columnName = mysqli_real_escape_string($columnName);
	// $searchInput = mysqli_real_escape_string($searchInput);

	$query = "SELECT ing0, ing1, ing2, ing3, ing4, ing5 FROM orderTable WHERE orderID=\"0\"";
	$result = mysqli_query($dbCon, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	echo $row;
	if (!$row) {
		// echo 'unable to fetch row';
	 	returnFailedAllocate();		
	}

    echo json_encode($row);

?>