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


	if (!isset($_POST["rIngred0"])) {
		returnFailedAllocate();
	}
	if (!isset($_POST["rIngred1"])) {
		returnFailedAllocate();
	}
	if (!isset($_POST["rIngred2"])) {
		returnFailedAllocate();
	}
	if (!isset($_POST["rIngred3"])) {
		returnFailedAllocate();
	}
	if (!isset($_POST["rIngred4"])) {
		returnFailedAllocate();
	}
	if (!isset($_POST["rIngred5"])) {
		returnFailedAllocate();
	}

	if (!is_numeric($_POST["rIngred0"])) {
        // echo "ingred0 is NOT numeric", PHP_EOL;
        returnFailedAllocate();
    }
    if (!is_numeric($_POST["rIngred1"])) {
        // echo "ingred1 is NOT numeric", PHP_EOL;
        returnFailedAllocate();
    }
    if (!is_numeric($_POST["rIngred2"])) {
        // echo "ingred2 is NOT numeric", PHP_EOL;
        returnFailedAllocate();
    }
    if (!is_numeric($_POST["rIngred3"])) {
        // echo "ingred3 is NOT numeric", PHP_EOL;
        returnFailedAllocate();
    }
    if (!is_numeric($_POST["rIngred4"])) {
        // echo "ingred4 is NOT numeric", PHP_EOL;
        returnFailedAllocate();
    }
    if (!is_numeric($_POST["rIngred5"])) {
        // echo "ingred5 is NOT numeric", PHP_EOL;
        returnFailedAllocate();
    }

    // convert strings to integers
	$rIngred0 = intval($_POST["rIngred0"]);
	$rIngred1 = intval($_POST["rIngred1"]);
	$rIngred2 = intval($_POST["rIngred2"]);
	$rIngred3 = intval($_POST["rIngred3"]);
	$rIngred4 = intval($_POST["rIngred4"]);
	$rIngred5 = intval($_POST["rIngred5"]);

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
	$row = mysqli_fetch_array($result);
	if (!$row) {
		// echo 'unable to fetch row';
	 	returnFailedAllocate();		
	}

	$cIngred0 = intval($row['ing0']);
	$cIngred1 = intval($row['ing1']);
	$cIngred2 = intval($row['ing2']);
	$cIngred3 = intval($row['ing3']);
	$cIngred4 = intval($row['ing4']);
	$cIngred5 = intval($row['ing5']);

	$numValid = 0;

	// echo $cIngred0;
	if ($rIngred0 > 0) {
		if ($cIngred0 - $rIngred0 < 0) {
			// echo "error ingredient 0";
			returnFailedAllocate();
		}
		$cIngred0 = $cIngred0 - $rIngred0;
		$numValid++;
	}

	if ($rIngred0 > 0) {
		if ($cIngred1 - $rIngred1 < 0) {
			// echo "error ingredient 1";
			returnFailedAllocate();
		}
		$cIngred1 = $cIngred1 - $rIngred1;
		$numValid++;
	}

	if ($rIngred2 > 0) {
		if ($cIngred2 - $rIngred2 < 0) {
			// echo "error ingredient 2";
			returnFailedAllocate();
		}
		$cIngred2 = $cIngred2 - $rIngred2;
		$numValid++;
	}

	if ($rIngred3 > 0) {
		if ($cIngred3 - $rIngred3 < 0) {
			// echo "error ingredient 3";
			returnFailedAllocate();
		}
		$cIngred3 = $cIngred3 - $rIngred3;
		$numValid++;
	}

	if ($rIngred4 > 0) {
		if ($cIngred4 - $rIngred4 < 0) {
			// echo "error ingredient 4";
			returnFailedAllocate();
		}
		$cIngred4 = $cIngred4 - $rIngred4;
		$numValid++;
	}

	if ($rIngred5 > 0) {
		if ($cIngred5 - $rIngred5 < 0) {
			// echo "error ingredient 5";
			returnFailedAllocate();
		}
		$cIngred5 = $cIngred5 - $rIngred5;
		$numValid++;
	}

	if ($numValid < 1 ) {
		returnFailedAllocate();
	}
	// echo "got past ingred compares\n";

	$query = "UPDATE orderTable SET ing0=" . $cIngred0 . ", ing1=" . $cIngred1 . ", ing2=" . $cIngred2 . ", ing3=" . $cIngred3 . ", ing4=" . $cIngred4 . ", ing5=" . $cIngred5 . " WHERE orderID=\"0\"";

	$result = mysqli_query($dbCon, $query);
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

	$result = mysqli_query($dbCon, $query);
	if (!$result) {
		// echo "Error inserting new drink order\n";
		// echo mysqli_error($dbCon);
		returnFailedAllocate();
	}

	$arr = array ('barcode'=>$barcode);
    echo json_encode($arr);

?>