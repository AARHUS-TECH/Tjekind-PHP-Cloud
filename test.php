<?php
exit;
ini_set('display_errors', 1);
error_reporting(E_ERROR|E_NOTICE|E_WARNING);

require_once('core/init.php');

Session::ajaxResp('success', 'muuh');