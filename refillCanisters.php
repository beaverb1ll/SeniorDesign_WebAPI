<?php

function returnFailed(){
// return 0 for failed.  
        $arr = array ('success'=>0);
    echo json_encode($arr);
    die();

}
ini_set('display_errors', 'On');
error_reporting(E_ALL);


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

    $count = 0;
// echo "Initialized count";
   
    $query = "UPDATE orderTable SET ";
    if ($_POST["rIngred0"] == 1) {
        $count++;
        $query .= "ing0=100, "; 
    }
    if ($_POST["rIngred1"] == 1) {
        $query .= "ing1=100, ";
        $count++;
    }
    if ($_POST["rIngred2"] == 1) {
        $query .= "ing2=100, ";
        $count++;
    }
    if ($_POST["rIngred3"] == 1) {
        $query .= "ing3=100, ";
        $count++;
    }
    if ($_POST["rIngred4"] == 1) {
        $query .= "ing4=100, ";
        $count++;
    }
    if ($_POST["rIngred5"] == 1) {
        $query .= "ing5=100, ";
        $count++;
    }
    
    if ($count == 0) {
        // echo "No ingred marked to update"
        returnFailed();
    }
 
    $query = chop($query,", ");
    $query .= " WHERE orderID=\"0\"";

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
            returnFailedAllocate();
    }

    $result = mysqli_query($dbCon, $query);
    // $row = mysqli_fetch_array($result);
    if (!$result) {
//            echo "unable to update orderTable";
            returnFailed();
    }

    $arr = array ('success'=>1);
    echo json_encode($arr);
?>
