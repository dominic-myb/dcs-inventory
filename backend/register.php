<?php
header('Content-Type: application/json');

include("db_config.php");

$data = json_decode(file_get_contents('php://input'));
$firstname = $data->firstname ?? '';
$lastname = $data->lastname ?? '';
$username = $data->username ?? '';
$password = $data->password ?? '';
$password = hash('sha256', $password);
$is_admin = 0;

include("functions.php");
addNewAccount($conn, $username, $password, $firstname, $lastname, $is_admin);

$stmt->close();
$conn->close();
