<?php
include("db_config.php");
header('Content-Type: application/json');

/*** GET THE INPUT FROM JSON ***/
$data = json_decode(file_get_contents('php://input'));

$item_name = $data->item_name ?? '';
$quantity = $data->quantity ?? '';
$location = $data->location ?? '';
$description = $data->description ?? '';
$status = $data->status ?? '';

/*** INPUT VALIDATION ***/
if (empty($item_name) || empty($quantity) || !is_numeric($quantity) || empty($location) || empty($description) || empty($status)) {
  http_response_code(400);
  echo json_encode([
    "status" => "error",
    "message" => "Invalid input data.",
  ]);
  exit();
}

/*** SANITIZE INPUT ***/
$item_name = $conn->real_escape_string($item_name);
$quantity = $conn->real_escape_string($quantity);
$location = $conn->real_escape_string($location);
$description = $conn->real_escape_string($description);
$status = $conn->real_escape_string($status);

/*** TRY TO INSERT IN THE TABLE items IN dcs_db ***/
try {
  $sql = "INSERT INTO items (item_name, quantity, location, description, status) VALUES (?,?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sisss", $item_name, $quantity, $location, $description, $status);
  if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode([
      "status" => "success",
      "message" => "Successfully added: " . $item_name,
    ]);
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "error",
      "message" => "Failed to insert data: " . $stmt->error,
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
