<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if (isset($_GET['temp']) && isset($_GET['hum'])) {
 
    $temp = $_GET['temp'];
    $hum = $_GET['hum'];
 
    // Include data base connect class
    $filepath = realpath (dirname(__FILE__));
	require_once($filepath."/config/dbconnect.php");
 
    // Connecting to database 
    //$db = new DB_CONNECT();
	$filepath = realpath (dirname(__FILE__));
    require_once($filepath."/config/dbconfig.php");
	$con = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
 
    // Fire SQL query to insert data in weather
	$sql = "INSERT INTO weather(temperature, humidity) VALUES ('$temp','$hum')";
	echo "\$sql = $sql\n\r";
	
    // Check for succesfull execution of query
    if ($con->query($sql) === TRUE) {
        // successfully inserted 
        $response["success"] = 1;
        $response["message"] = "Weather successfully created.";
 
        // Show JSON response
        echo json_encode($response);
    } else {
        // Failed to insert data in database
        $response["success"] = 0;
        $response["message"] = "Something has gone wrong";
 
        // Show JSON response
        echo json_encode($response);
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
}
?>