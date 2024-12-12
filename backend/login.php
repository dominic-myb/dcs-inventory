<?php
session_start();
header('Content-Type: application/json');

// VALIDATE JSON
$data = json_decode(file_get_contents('php://input'));
if ($data === null) {
  http_response_code(400);
  echo json_encode([
    "status" => "error",
    "message" => "Invalid JSON input.",
  ]);
  exit();
}

// VALIDATE CSRF TOKEN
include("db_config.php");
$submittedToken = $conn->real_escape_string($data->csrf_token ?? '');
$sessionToken = $conn->real_escape_string($_SESSION['csrf_token'] ?? '');

if (empty($sessionToken) || $submittedToken !== $sessionToken) {
  http_response_code(403); // Forbidden
  echo json_encode([
    'status' => 'error',
    'message' => 'Invalid or missing CSRF token.',
  ]);
  exit();
}

// NOW GET THE USER AND PASS INPUT
$username = $conn->real_escape_string($data->username ?? '');
$password = $data->password ?? '';

try {
  $sql = "SELECT username, hashed_password FROM accounts WHERE username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $res = $stmt->get_result();

  // CHECK USERNAME IF IN DB
  if ($res->num_rows === 1) {
    $row = $res->fetch_assoc();

    // CHECK PASSWORD OF THAT USERNAME 
    if (password_verify($password, $row['hashed_password'])) {
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      http_response_code(200);
      echo json_encode([
        "status" => "success",
        "message" => "Login Successful!",
      ]);
    } else {
      http_response_code(401);
      echo json_encode([
        "status" => "error",
        "message" => "Invalid Username or Password",
      ]);
    }
  } else {
    http_response_code(401);
    echo json_encode([
      "status" => "error",
      "message" => "Invalid Username or Password",
    ]);
  }
  $stmt->close();
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode([
    "status" => "error",
    "message" => $e->getMessage(),
  ]);
}
$conn->close();
