<?php
header('Content-Type: application/json');

include("db_config.php");

$data = json_decode(file_get_contents('php://input'));
$username = $data->username ?? '';
$password = $data->password ?? '';
$password = hash('sha256', $password);

// Query the database
$sql = "SELECT * FROM accounts WHERE username = ? AND hashed_password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  echo json_encode([
    "status" => "success",
    "message" => "Login successful"
  ]);
} else {
  echo json_encode([
    "status" => "error",
    "message" => "Invalid username or password"
  ]);
}

$stmt->close();
$conn->close();
