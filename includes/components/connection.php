<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "";

if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
	die("Connection Failed!");
}