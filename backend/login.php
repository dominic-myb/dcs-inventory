<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'));
$username = $data->username;
$password = $data->password;
$password = hash('sha256', $password);

include("db_config");
$sql = "SELECT * FROM accounts WHERE username = '$username' and hashed_password = '$password'";
$res = $conn->query($sql);
if (mysqli_num_rows($res) > 0) {
}
