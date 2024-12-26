<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'));
$item_id = $data->item_id ?? '';
if (!is_numeric($item_id)) {
  exit();
}
try {
  include("db_config.php");
  $sql = "SELECT * FROM items WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $item_id);
  $stmt->execute();
  $res = $stmt->get_result();

  $data = [];
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
  }

  echo json_encode([
    "item_id" => $row['id'],
    "item_name" => $row['item_name'],
    "quantity" => $row['quantity'],
    "location" => $row['location'],
    "description" => $row['description'],
    "item_status" => $row['status'],
    "status" => "success",
    "message" => "Success getting data.",
  ]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode([
    "status" => "error",
    "message" => $e->getMessage(),
  ]);
}
$stmt->close();
$conn->close();
