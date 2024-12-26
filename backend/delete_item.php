<?php
header("Content-Type: application/json");
session_start();
include("db_config.php");
$data = json_decode(file_get_contents('php://input'));
$item_id = $conn->real_escape_string($data->item_id ?? '');

try {
  $sql = "DELETE FROM items WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $item_id);
  if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Deleted Successfully!",
    ]);
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
