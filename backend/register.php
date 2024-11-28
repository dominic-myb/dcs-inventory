<?php
header('Content-Type: application/json');

include("db_config.php");

$data = json_decode(file_get_contents('php://input'));
$firstname = $data->firstname ?? '';
$lastname = $data->lastname ?? '';
$username = $data->username ?? '';
$password = $data->password ?? '';
$password = hash('sha256', $password);

// Query the database
$sql = "SELECT * FROM accounts WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  echo json_encode([
    "status" => "error",
    "message" => "Username unavailable!"
  ]);
} else {
  $sql = "INSERT INTO accounts (username, hashed_password, first_name, last_name, is_admin) VALUES (?,?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssi", $username, $password, $firstname, $lastname, 0);

  if($stmt->execute()) {
    echo json_encode([
      "status" => "error",
      "message" => "Account Not Registered!"
    ]);
    exit();
  }
  echo json_encode([
    "status" => "success",
    "message" => "Account Registered!"
  ]);
}

$stmt->close();
$conn->close();
