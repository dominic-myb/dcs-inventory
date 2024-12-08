<?php
session_start();

// Require login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  http_response_code(401);
  echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
  exit();
}

// CSRF Token Validation
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
  http_response_code(403);
  echo json_encode(["status" => "error", "message" => "Invalid CSRF token"]);
  exit();
}

$search = $_POST['q'] ?? '';
$search = mysqli_real_escape_string($conn, $search);
$sql = "SELECT * FROM items WHERE item_name LIKE '%$search%' OR quantity LIKE '%$search%' OR location LIKE '%$search%' OR status LIKE '%$search%'";
$res = mysqli_query($conn, $sql);

$data = [];
if (mysqli_num_rows($res) > 0) {
  while ($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
  }
}

header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
