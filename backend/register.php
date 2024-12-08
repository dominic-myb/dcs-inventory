<?php
header('Content-Type: application/json');
session_start();
include("db_config.php");

$data = json_decode(file_get_contents('php://input'));
$firstname = $data->firstname ?? '';
$lastname = $data->lastname ?? '';
$username = $data->username ?? '';
$password = $data->password ?? '';
$password = hash('sha256', $password);
$is_admin = 0;

$sql = "SELECT username FROM accounts WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
  echo json_encode([
    "status" => "error",
    "message" => "Username Unavailable!"
  ]);
  $stmt->close();
  exit();
}

$sql = "INSERT INTO accounts (username, hashed_password, first_name, last_name, is_admin) VALUES (?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $username, $password, $firstname, $lastname, $is_admin);

if (!$stmt->execute()) {
  echo json_encode([
    "status" => "error",
    "message" => "Account not Registered!"
  ]);
  $stmt->close();
  $conn->close();
}
echo json_encode([
  "status" => "success",
  "message" => "Account Registered!"
]);

$stmt->close();
$conn->close();
