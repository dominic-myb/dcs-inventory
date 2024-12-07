<?php
header('Content-Type: application/json');
include("db_config.php");

$data = json_decode(file_get_contents('php://input'));

$username = $data->username ?? '';

$sql = "SELECT username FROM accounts WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
if (!$result = $stmt->get_result()){
  echo json_encode([
    "status" => "success",
    "message" => "Username is valid!"
  ]);
  exit();
}
echo json_encode([
  "status" => "error",
  "message" => "Username is unavailable!"
]);

$stmt->close();
$conn->close();
