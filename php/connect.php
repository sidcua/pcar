<?php
@session_start();
error_reporting(0);
date_default_timezone_set('Asia/Manila');

// localhost
$host = 'localhost';
$user = "root";
$pass = "";
$db = "pcar";

// server
// $host = 'localhost';
// $user = "misplanning";
// $pass = "misplanning";
// $db = "pcar";

	@$con = mysql_connect($host,$user,$pass);
		@mysql_select_db($db);
?>
