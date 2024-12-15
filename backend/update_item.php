<?php
header('Content-Type: application/json');
session_start();
include("db_config.php");
$data = json_decode(file_get_contents('php://input'));
$item_id = $conn->real_escape_string($data->item_id ?? '');
$item_name = $conn->real_escape_string($data->item_name ?? '');
$quantity = $conn->real_escape_string($data->quantity ?? '');
$location = $conn->real_escape_string($data->location ?? '');
$description = $conn->real_escape_string($data->description ?? '');
$item_status = $conn->real_escape_string($data->item_status ?? '');

try {
  $sql = "UPDATE items SET item_name=?, quantity=?, location=?, description=?, status=? WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sisssi", $item_name, $quantity, $location, $description, $item_status, $item_id);
  if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
      echo json_encode([
        "status" => "success",
        "message" => "Success! Rows updated: " . $stmt->affected_rows,
      ]);
    } else {
      echo json_encode([
        "status" => "error",
        "message" => "No rows were affected.",
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
    "message" => "Internal Server Error",
  ]);
}
$conn->close();
