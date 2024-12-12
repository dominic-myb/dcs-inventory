<?php
header('Content-Type: application/json');
include("db_config.php");

$data = json_decode(file_get_contents('php://input'));
$username = $conn->real_escape_string($data->username ?? '');

try {
  $sql = "SELECT username FROM accounts WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode([
      "status" => "error",
      "message" => "Username is unavailable!"
    ]);
    exit();
  } else {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Username is valid!"
    ]);
  }
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode([
    "status" => "error",
    "message" => $e->getMessage(),
  ]);
}

$stmt->close();
$conn->close();
