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
	$unreserved_row = mysqli_fetch_array($result, MYSQLI_NUM);
	if (!$unreserved_row) {
		// echo 'unable to fetch row';
	 	returnFailedAllocate();		
	}

	// remaining is the addition of non picked up and non expired drinks to unreserved.
	$query = 'SELECT SUM(Ing0), SUM(Ing1), SUM(Ing2), SUM(Ing3), SUM(Ing4), SUM(Ing5) from orderTable WHERE expired="false" AND pickedUp="false"';
	$result = mysqli_query($dbCon, $query);
	$remaining_row = mysqli_fetch_array($result, MYSQLI_NUM);
	if (!$remaining_row) {
		// echo 'unable to fetch row';
	 	returnFailedAllocate();		
	}

	$remaining_row[0] += $unreserved_row[0];
	$remaining_row[1] += $unreserved_row[1];
	$remaining_row[2] += $unreserved_row[2];
	$remaining_row[3] += $unreserved_row[3];
	$remaining_row[4] += $unreserved_row[4];
	$remaining_row[5] += $unreserved_row[5];

	echo '{"remaining": ["';
    echo json_encode($remaining_row);
    echo '],"unreserved": [';
    echo json_encode($unreserved_row);
    echo ']}';

?>