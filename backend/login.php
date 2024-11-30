<?php
header('Content-Type: application/json');

include("db_config.php");

$data = json_decode(file_get_contents('php://input'));
$username = $data->username ?? '';
$password = $data->password ?? '';
$password = hash('sha256', $password);

include("functions.php");
authenticateAccount($conn, $username, $password);

$stmt->close();
$conn->close();
