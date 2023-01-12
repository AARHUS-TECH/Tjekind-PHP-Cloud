<?php
/************************************//*
 * @filename: ajaxResponse.php
 * @author:   Karsten Reitan Sørensen
 ***************************************/

require_once('../core/init.php');

$user = new User();

if(Session::exists('userID')) {
	if(!$user->isAdmin(Session::get('userID'))) {
		Session::delete('userID');
		Redirect::to('/');
	}
} else {
	Redirect::to('/');
}

$returnMsg = "";
$userdata  = $user->getInfo(Session::get('userID'));
$cardData  = htmlspecialchars($_GET["card"]);

$returnMsg .= $user->ajaxGetData($cardData);

echo($returnMsg);
?>