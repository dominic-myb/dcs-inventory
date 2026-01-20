<?php
header('Content-Type: application/json');

// VALIDATE INPUT
$data = json_decode(file_get_contents('php://input'));
if ($data === null) {
  http_response_code(400);
  echo json_encode([
    "status" => "error",
    "message" => "Invalid JSON input.",
  ]);
  exit();
}

/*** GET AND SANITIZE INPUT ***/
include("db-config.php");
$item_name = $conn->real_escape_string($data->item_name ?? '');
$quantity = $conn->real_escape_string($data->quantity ?? '');
$location = $conn->real_escape_string($data->location ?? '');
$description = $conn->real_escape_string($data->description ?? '');
$status = $conn->real_escape_string($data->status ?? '');

/*** INPUT VALIDATION ***/
if (empty($item_name) || empty($quantity) || empty($location) || empty($description) || empty($status) || !is_numeric($quantity)) {
  http_response_code(400);
  echo json_encode([
    "status" => "error",
    "message" => "Invalid input data.",
  ]);
  exit();
}

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
