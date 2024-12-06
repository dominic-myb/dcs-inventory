<?php
header('Content-Type: application/json');

include("db_config.php");

$data = json_decode(file_get_contents('php://input'));
$username = $data->username ?? '';
$password = $data->password ?? '';
$password = hash('sha256', $password);

$sql = "SELECT username, hashed_password FROM accounts WHERE username=? and hashed_password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows === 0){
  echo json_encode([
    "status" => "error",
    "message" => "Invalid Username or Password"
  ]);
  exit();
}
echo json_encode([
  "status" => "success",
  "message" => "Login Successful!"
]);


$stmt->close();
$conn->close();
