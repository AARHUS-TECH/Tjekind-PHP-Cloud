<?php
/**
 * Methods for database connection and queries
 * 
 * @package     Tjekind Cloud
 * @file        remoteRequest.php "remoteRequest.php"
 * @version     0.0.0 - prototype
 *
 * @author      Karsten Reitan Sørensen <krs@aarhustech.dk>
 * @copyright   Aarhus Tech SKP 2023
 */


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once('../config/init.php');

$remote = new RemoteAccess;
$user   = new User;
exit();
// Getting all the http vars or set empty string
$userID            = ( isset($_REQUEST['userID']) )           ?trim( $_REQUEST['userID']    )        :'';
$groupID           = ( isset($_REQUEST['groupID']) )          ?trim( $_REQUEST['groupID']   )        :'';
$fornavn           = ( isset($_REQUEST['fornavn']) )          ?trim( $_REQUEST['fornavn']   )        :'';
$efternavn         = ( isset($_REQUEST['efternavn']) )        ?trim( $_REQUEST['efternavn'] )        :'';
$status            = ( isset($_REQUEST['status']) )           ?trim( $_REQUEST['status']    )        :''; // enum '0', '1', '2'
$tjekind_timestamp = ( isset($_REQUEST['tjekind_timestamp']) )?trim( $_REQUEST['tjekind_timestamp']) :''; // MySQL current_timestamp()
$iSKP              = ( isset($_REQUEST['iSKP']) )             ?trim( $_REQUEST['iSKP']      )        :''; // enum '0', '1'
$bemning           = ( isset($_REQUEST['bemning']) )          ?trim( $_REQUEST['bemning']   )        :''; // enum 'Syg','Ekstern Opgave','Job Samtale','Forsinket','Ikke Godkendt','Andet','Datastue','Ulovlig fravær','Ferie / Fridag','?','Corona'
$action			   = ( isset($_REQUEST['action']) )           ?trim( $_REQUEST['action']    )        :'';
$token             = ( isset($_REQUEST['token']) )            ?trim( urldecode( $_REQUEST['token'] )):''; echo ($action == "debug")?"\$token = $token\n\r":"";

//Creating Array for JSON response
$response = array();

// Check if we got the field from the user
// Ex. GET url to the API
// https://cloud.ats-skpdatait.dk/insert-student.php?userID=2&groupID=0&fornavn=er&efternavn=erer&status=status&tjekind_timestamp=89r8t&iSKP=1&bemning=Syg

if ( $userID && $groupID && $fornavn && $efternavn && $status && $tjekind_timestamp && $iSKP && $bemning ) 
{
	if ( RemoteAccess::checkToken($token) ) {
		// Token is valid
		if ( $userID && $fornavn && $efternavn )
		{
			// User is valid
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
			/*$update_result = */
			//$user->update( $userID, $fornavn, $efternavn, $brugernavn, $adgangskode, $magnetstribe, $iSKP, $bemning );
			
			if($update_result) {
				$response["success"] = 1;
				$response["message"] = "Student updated successfully!";
			} else {
				$response["success"] = 0;
				$response["message"] = "Student was not updated!";				
			}
		} else {
			$response["success"] = 0;
			$response["message"] = "Missing parameters!";				
		}
	} else {
		// Token is invalid
		$response["success"] = 0;
		$response["message"] = "Token invalid!";				
	} 
	
	
} else {
	// Required field is missing
	$response["success"] = 0;
	$response["message"] = "Something has gone wrong";
	
}
//	$sql = "SELECT * FROM tjekind_brugere WHERE userID = $userID;";
	
// Show JSON response
echo json_encode($response);
	
?>