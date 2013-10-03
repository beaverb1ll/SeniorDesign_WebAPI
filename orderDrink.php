<?php


function getGUID(){

        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = "1"// "{"
            .substr($charid, 0, 8)
            .substr($charid, 8, 4)
            .substr($charid,12, 4)
            .substr($charid,16, 4)
            .substr($charid,20,12)
            ."1";// "}"
        return $uuid;
    
}

function returnFailedAllocate(){

	echo "{\"barcode\":\"-1\"}";
	die();

}
ini_set('display_errors', 'On');
error_reporting(E_ALL);
	
	$rIngred0 = 10;
	$rIngred1 = 11;
	$rIngred2 = 12;
	$rIngred3 = 13;
	$rIngred4 = 14;
	$rIngred5 = 15;

	$dbHost="localhost"; // Host name 
	$dbUsername="root"; // Mysql username 
	$dbPassword="password"; // Mysql password 
	$dbName="SD"; // Database name 
	// $tbl_name="customers"; // Table name 

	// Connect to server and select databse.
	$dbCon = mysqli_connect("$dbHost", "$dbUsername", "$dbPassword", "$dbName");

	if (mysqli_connect_errno($dbCon)) {
    	// echo "Failed to connect to MySQL: " . mysqli_connect_error();
    	returnFailedAllocate();
	} 

	if (!mysqli_set_charset($dbCon, "utf8")) {
    	returnFailedAllocate();
	}

	// $columnName = mysqli_real_escape_string($columnName);
	// $searchInput = mysqli_real_escape_string($searchInput);

	$query = "SELECT ing0, ing1, ing2, ing3, ing4, ing5 FROM orderTable WHERE orderID=\"0\"";

	$safeQuery = mysqli_real_escape_string($dbCon, $query);

	$result = mysqli_query($dbCon, $safeQuery);

	$row = mysqli_fetch_array($result);

	if (!$row) {
	 	returnFailedAllocate();		
	}

	$cIngred0 = intval($row['ing0']);
	$cIngred1 = intval($row['ing1']);
	$cIngred2 = intval($row['ing2']);
	$cIngred3 = intval($row['ing3']);
	$cIngred4 = intval($row['ing4']);
	$cIngred5 = intval($row['ing5']);

	// echo $cIngred0;
	if ($rIngred0 > 0) {
		if ($cIngred0 - $rIngred0 < 0) {
			// echo "error ingredient 0";
			returnFailedAllocate();
		}
		$cIngred0 = $cIngred0 - $rIngred0;
	}

	if ($rIngred0 > 0) {
		if ($cIngred1 - $rIngred1 < 0) {
			// echo "error ingredient 1";
			returnFailedAllocate();
		}
		$cIngred1 = $cIngred1 - $rIngred1;
	}

	if ($rIngred2 > 0) {
		if ($cIngred2 - $rIngred2 < 0) {
			// echo "error ingredient 2";
			returnFailedAllocate();
		}
		$cIngred2 = $cIngred2 - $rIngred2;
	}

	if ($rIngred3 > 0) {
		if ($cIngred3 - $rIngred3 < 0) {
			// echo "error ingredient 3";
			returnFailedAllocate();
		}
		$cIngred3 = $cIngred3 - $rIngred3;
	}

	if ($rIngred4 > 0) {
		if ($cIngred4 - $rIngred4 < 0) {
			// echo "error ingredient 4";
			returnFailedAllocate();
		}
		$cIngred4 = $cIngred4 - $rIngred4;
	}

	if ($rIngred5 > 0) {
		if ($cIngred5 - $rIngred5 < 0) {
			// echo "error ingredient 5";
			returnFailedAllocate();
		}
		$cIngred5 = $cIngred5 - $rIngred5;
	}

	// echo "got past ingred compares\n";

	$query = "UPDATE orderTable SET ing0=" . $cIngred0 . ", ing1=" . $cIngred1 . ", ing2=" . $cIngred2 . ", ing3=" . $cIngred3 . ", ing4=" . $cIngred4 . ", ing5=" . $cIngred5 . " WHERE orderID=\"0\"";
	
	// echo $query;
	$safeQuery = mysqli_real_escape_string($dbCon, $query);

	$result = mysqli_query($dbCon, $safeQuery);

	if (!$result) {
		// echo "Error updating reserved ingredients\n";
		// echo mysqli_error($dbCon);
		returnFailedAllocate();
	}

	
	date_default_timezone_set("America/New_York");
	$date = date_create();
	$time = date_timestamp_get($date);
	$barcode = getGUID();

	$query = 'INSERT INTO orderTable (orderID, ing0, ing1, ing2, ing3, ing4, ing5, orderTime) VALUES ("' . $barcode.'", '.$rIngred0.', '.$rIngred1.', '.$rIngred2.', '.$rIngred3.', '.$rIngred4.', '.$rIngred5.', '.$time.')';
	// echo $query;
	$safeQuery = mysqli_real_escape_string($dbCon, $query);

	$result = mysqli_query($dbCon, $safeQuery);

	if (!$result) {
		// echo "Error inserting new drink order\n";
		// echo mysqli_error($dbCon);
		returnFailedAllocate();
	}

	// sucess, return barcode
	echo "\n{\"barcode\":\"".$barcode."\"}\n";


?>