<?php

function returnFailed(){
// return 0 for failed.  
    $arr = array ('success'=>0);
    echo json_encode($arr);
    die();
}

function updateSQL($aConnection, $aQuery) {
    $result = mysqli_query($aConnection, $aQuery);
    // $row = mysqli_fetch_array($result);
    if (!$result) {
//        echo "unable to update orderTable";
        returnFailed();
    }
}

function getReservedAmount($aConnection, $aIngred) {
    $aQuery = "SELECT SUM(".$aIngred.") AS total FROM orderTable WHERE pickedUp=\"false\" AND expired=\"false\"";
    
    $result = mysqli_query($aConnection, $aQuery);
    $row = mysqli_fetch_array($result);
    if (!$row) {
//        echo "unable to fetch ordertime";
        returnFailed();
    }
//    echo "total: ".intval($row['total']);
    return intval($row['total']);
            
}

// ini_set('display_errors', 'On');
// error_reporting(E_ALL);

    header('Content-Type: application/json');


    if (!isset($_POST["rIngred0"])) {
            returnFailed();
    }
    if (!isset($_POST["rIngred1"])) {
            returnFailed();
    }
    if (!isset($_POST["rIngred2"])) {
            returnFailed();
    }
    if (!isset($_POST["rIngred3"])) {
            returnFailed();
    }
    if (!isset($_POST["rIngred4"])) {
            returnFailed();
    }
    if (!isset($_POST["rIngred5"])) {
            returnFailed();
    }

    if (!is_numeric($_POST["rIngred0"])) {
        // echo "ingred0 is NOT numeric", PHP_EOL;
        returnFailed();
    }
    if (!is_numeric($_POST["rIngred1"])) {
        // echo "ingred1 is NOT numeric", PHP_EOL;
        returnFailed();
    }
    if (!is_numeric($_POST["rIngred2"])) {
        // echo "ingred2 is NOT numeric", PHP_EOL;
        returnFailed();
    }
    if (!is_numeric($_POST["rIngred3"])) {
        // echo "ingred3 is NOT numeric", PHP_EOL;
        returnFailed();
    }
    if (!is_numeric($_POST["rIngred4"])) {
        // echo "ingred4 is NOT numeric", PHP_EOL;
        returnFailed();
    }
    if (!is_numeric($_POST["rIngred5"])) {
        // echo "ingred5 is NOT numeric", PHP_EOL;
        returnFailed();
    }


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

    $count = 0;
    $baseAmount = 68;
// echo "Initialized count";
   
    $query = "UPDATE orderTable SET ";
    if ($_POST["rIngred0"] == 1) {
        
        $temp = $baseAmount - getReservedAmount($dbCon, "ing0");
        $count++;
        $query .= "ing0=".$temp.", ";
    }
    if ($_POST["rIngred1"] == 1) {
        $temp = $baseAmount - getReservedAmount($dbCon, "ing1");
        $count++;
        $query .= "ing1=".$temp.", ";
    }
    if ($_POST["rIngred2"] == 1) {
        $temp = $baseAmount - getReservedAmount($dbCon, "ing2");
        $count++;
        $query .= "ing2=".$temp.", ";
    }
    if ($_POST["rIngred3"] == 1) {
        $temp = $baseAmount - getReservedAmount($dbCon, "ing3");
        $count++;
        $query .= "ing3=".$temp.", ";
    }
    if ($_POST["rIngred4"] == 1) {
        $temp = $baseAmount - getReservedAmount($dbCon, "ing4");
        $count++;
        $query .= "ing4=".$temp.", ";
    }
    if ($_POST["rIngred5"] == 1) {
        $temp = $baseAmount - getReservedAmount($dbCon, "ing5");
        $count++;
        $query .= "ing5=".$temp.", ";
    }
    
    if ($count == 0) {
        // echo "No ingred marked to update"
        returnFailed();
    }
 
    $query = chop($query,", ");
// echo "Query: " . $query;    
    $query .= " WHERE orderID=\"0\"";
    updateSQL($dbCon, $query);

    $arr = array ('success'=>1);
    echo json_encode($arr);
?>

