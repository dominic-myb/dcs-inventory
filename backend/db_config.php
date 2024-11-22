<?php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "dcs_db";

if (!$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME)) {
  die("Connection Failed: " . mysqli_connect_error());
}
