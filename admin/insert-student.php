<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
// Ex. GET url to the API
// https://cloud.ats-skpdatait.dk/insert-student.php?userID=2&groupID=0&fornavn=er&efternavn=erer&status=status&tjekind_timestamp=89r8t&iSKP=1&bemning=Syg

if ( isset($_REQUEST['userID']) ) {
 
	// Getting all the http vars
	$userID            = ( isset($_REQUEST['userID']) )           ?trim( $_REQUEST['userID']    )        :NULL;
	$groupID           = ( isset($_REQUEST['groupID']) )          ?trim( $_REQUEST['groupID']   )        :NULL;
	$fornavn           = ( isset($_REQUEST['fornavn']) )          ?trim( $_REQUEST['fornavn']   )        :NULL;
	$efternavn         = ( isset($_REQUEST['efternavn']) )        ?trim( $_REQUEST['efternavn'] )        :NULL;
	$status            = ( isset($_REQUEST['status']) )           ?trim( $_REQUEST['status']    )        :NULL; // enum '0', '1', '2'
	$tjekind_timestamp = ( isset($_REQUEST['tjekind_timestamp']) )?trim( $_REQUEST['tjekind_timestamp']) :NULL; // MySQL current_timestamp()
	$iSKP              = ( isset($_REQUEST['iSKP']) )             ?trim( $_REQUEST['iSKP']      )        :NULL; // enum '0', '1'
	$bemning           = ( isset($_REQUEST['bemning']) )          ?trim( $_REQUEST['bemning']   )        :NULL; // enum 'Syg','Ekstern Opgave','Job Samtale','Forsinket','Ikke Godkendt','Andet','Datastue','Ulovlig fravær','Ferie / Fridag','?','Corona'
	$action			   = ( isset($_REQUEST['action']) )           ?trim( $_REQUEST['action']    )        :NULL;
	$token             = ( isset($_REQUEST['token']) )            ?trim( urldecode( $_REQUEST['token'] )):NULL; echo ($action == "debug")?"\$token = $token\n\r":"";
    
    // Include data base connect class
    $filepath = realpath (dirname(__FILE__));
	require_once($filepath."/config/dbconnect.php");
 
    // Connecting to database 
    //$db = new DB_CONNECT();
	$filepath = realpath (dirname(__FILE__));
    require_once($filepath."/config/dbconfig.php");
	$con = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
 
	$sql = "SELECT * FROM tjekind_brugere WHERE userID = $userID;";
	$result = $con->query($sql);
	
    // Fire SQL query to insert data in weather
	echo ($action == "debug")?"\$sql = $sql\n\r":"";
	
    // Check for succesfull execution of query
	$response["success"] = 0;
	$response["message"] = "Something has gone wrong";

    if ( $result !== false && $result->num_rows > 0 ) {
		while($row = $result->fetch_assoc()) {
			$_id                = $row["userID"];
			$_group_id          = $row["groupID"];
			$_firstname         = $row["fornavn"];
			$_lastname          = $row["efternavn"];
			$_status            = $row["status"];
			$_tjekind_timestamp = $row["tjekind_timestamp"];
			$_iSKP              = $row["iSKP"];
			$_bemning           = $row["bemning"];
		}
		
		if ( ($userID == $_id) && ($_firstname == $fornavn) && ($_lastname == $efternavn) ) {
			$sql_update = "UPDATE 
								tjekind_brugere 
						   SET
								groupID = $groupID, 
								status = $status,
								tjekind_timestamp = \"$tjekind_timestamp\", 
								iSKP = $iSKP, 
								bemning = \"$bemning\" 
						   WHERE 
								userID = $userID;";
								
			echo ($action == "debug")?"\$sql_update = $sql_update\n\r":"";
			$update_result = $con->query($sql_update);
			
			if($update_result) {
				$response["success"] = 1;
				$response["message"] = "Student updated successfully!";
			} else {
				$response["success"] = 0;
				$response["message"] = "Student was not updated!";				
			}

		}
		else 
		{
			$response["success"] = 0;
			$response["message"] = "ID and names mismatch!";						
		}
    } 
	else 
	{
		if( array_search( strval($token), $token_whitelist) ) {
			$sql_insert = "INSERT INTO tjekind_brugere ( userID, groupID, fornavn, efternavn, status, tjekind_timestamp, iSKP, bemning ) VALUES ( $userID, $groupID, '$fornavn', '$efternavn', $status, '$tjekind_timestamp', $iSKP, '$bemning' );";
			echo ($action == "debug")?"\$sql_insert = $sql_insert\n\r":"";
			$result = $con->query($sql_insert);
			
			$response["success"] = 1;
			$response["message"] = "User inserted into database!";								
		}
    }

	$response['userID']            = $userID;
	$response['groupID']           = $groupID;
	$response['fornavn']           = $fornavn;
	$response['efternavn']         = $efternavn;
	$response['status']            = $status;            // enum '0', '1', '2'
	$response['tjekind_timestamp'] = $tjekind_timestamp; // MySQL current_timestamp()
	$response['iSKP']              = $iSKP;              // enum '0', '1'
	$response['bemning']           = $bemning;           // enum 'Syg','Ekstern Opgave','Job Samtale','Forsinket','Ikke Godkendt','Andet','Datastue','Ulovlig frav?r','Ferie / Fridag','?','Corona'
	
	// Show JSON response
    echo json_encode($response);
	
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
}
?>