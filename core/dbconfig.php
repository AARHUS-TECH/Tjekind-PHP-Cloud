<?php
/**
 * @file   dbconfig.h
 * @brief  Configueation for connection to database
 * @author Karsten Reitan Sørensen <krs@aarhustech.dk>
 * @bug    No known bugs
 */


define('DB_USER',     "ats_skpdatait_dk_tjekind");   // Your database user name
define('DB_PASSWORD', "Datait2022!@one.com");	     // Your database password (mention your db password here)
define('DB_DATABASE', "ats_skpdatait_dk_tjekind");   // Your database name
define('DB_SERVER',   "localhost");			         // db server (Mostly will be 'local' host)

$ip_whitelist    = [
	'10.254.254.25'
	];

$token_whitelist = [
	1 => "cj>!pQLMseLRx}oqM/8'3Q~{nP(R;W", 
	2 => "VtI0mwKqd.hj(ws%HQzm|q(qIn-uHt",
	3 => "X.#h9h87/J*{1`d5LaV@SMH/g?*BBc",
	4 => "3Lw~7|Xw8'qq#xQ?AQZ+L85x3Ko|&0"
	];
	
$region_mail = [
	0 => "krs@aarhustech.dk",
	1 => "krs@aarhustech.dk",
	2 => "krs@aarhustech.dk",
	];
?>