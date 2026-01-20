<?php
session_start();
// Require login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  http_response_code(401);
  echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
  header("Location: ../errors/401.html");
  exit();
}
$data = json_decode(file_get_contents('php://input'));
$token = $data->token ?? '';

// CSRF Token Validation
if ($token !== $_SESSION['csrf_token']) {
  http_response_code(403);
  echo json_encode(["status" => "error", "message" => "Invalid CSRF token"]);
  header("Location: ../errors/403.html");
  exit();
}

include("db-config.php");
$search = $data->q ?? '';
$search = '%' . $search . '%';
$search = $conn->real_escape_string($search);
$sql = "SELECT * FROM items WHERE item_name LIKE ? OR quantity LIKE ? OR location LIKE ? OR status LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $search, $search, $search, $search);
$stmt->execute();
$res = $stmt->get_result();

$data = [];
if ($res->num_rows > 0) {
  while ($row = $res->fetch_array()) {
    $data[] = $row;
  }
}

header('Content-Type: application/json');
echo json_encode($data);
$stmt->close();
$conn->close();
