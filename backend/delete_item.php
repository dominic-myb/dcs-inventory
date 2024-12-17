<?php
header("Content-Type: application/json");
session_start();
$data = json_decode(file_get_contents('php://input'));
include("db_config.php");
$delete_id = $conn->real_escape_string($data->delete_id ?? '');

try {
  $sql = "DELETE * FROM items WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $delete_id);
  if ($stmt->execute()) {
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
  echo json_encode(["status" => "error", "message" => "Something went wrong.",]);
}
$conn->close();
