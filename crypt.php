<?php
/*
    require_once("core/init.php");
	$_db = new Database();//_db = new Database();

	$sql = "SELECT magnetstribe, userID FROM tjekind_brugere";
	$result = $_db->custom_query($sql);
	if (isset($result))
		echo "result set";
	else
		echo "result unset";
	
	foreach($result as $row){
		$data = hash('sha256', $row->magnetstribe);
		$sqlUpdate = "UPDATE tjekind_brugere SET magnet_crypt='".$data."' WHERE userID='".$row->userID."'";
		echo "sqlUpdate: $sqlUpdate <br>";
		$_db->custom_query($sqlUpdate);
		echo "$sqlUpdate <br>";
		echo "<script> console.log('crypt complete!'); </script>";
	}
*/
?>