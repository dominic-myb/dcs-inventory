<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'));
if ($data === null) {
  http_response_code(400);
  echo json_encode([
    "status" => "error",
    "message" => "Invalid JSON input.",
  ]);
  exit();
}

include("db_config.php");
$firstname = $data->firstname ?? '';
$lastname = $data->lastname ?? '';
$username = $data->username ?? '';
$password = password_hash($data->password ?? '', PASSWORD_DEFAULT);
$is_admin = 0;

if (empty($firstname) || empty($lastname) || empty($username) || empty($password)) {
  http_response_code(400);
  echo json_encode([
    "status" => "error",
    "message" => "All fields are required.",
  ]);
  exit();
}

try {
  $sql = "SELECT username FROM accounts WHERE username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode([
      "status" => "error",
      "message" => "Username Unavailable!"
    ]);
  } else {
    $sql = "INSERT INTO accounts (username, hashed_password, first_name, last_name, is_admin) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $password, $firstname, $lastname, $is_admin);

    if ($stmt->execute()) {
      http_response_code(201);
      echo json_encode([
        "status" => "success",
        "message" => "Account Registered!"
      ]);
    } else {
      http_response_code(500);
      echo json_encode([
        "status" => "error",
        "message" => "Account not Registered!"
      ]);
    }
  }
  $stmt->close();
} catch (Exception $e) {
  if (isset($stmt)) {
    $stmt->close();
  }
  http_response_code(500);
  echo json_encode([
    "status" => "error",
    "message" => $e->getMessage(),
  ]);
}
$conn->close();
