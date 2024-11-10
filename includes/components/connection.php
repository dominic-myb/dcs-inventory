<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "dcs_db";

if (!$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
	die("Connection Failed!");
}
