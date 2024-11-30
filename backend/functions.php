<?php
function authenticateAccount($conn, $username, $password) {

  $password = hash('sha256', $password);
  $sql = "SELECT username, hashed_password FROM accounts WHERE username=? and hashed_password=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $username, $password);

  if (!$stmt->execute()) {
    return jsonResponse("error", "An Error Occured!");
  }

  if (!$res = $stmt->get_result()) {
    return jsonResponse("error", "Invalid Username or Password");
  }

  return jsonResponse("success", "Login Successful!");
}

function addNewAccount($conn, $username, $password, $firstname, $lastname, $is_admin) {

  if (!isUsernameAvailable($conn, $username)) {
    return jsonResponse("error", "Username Unavailable");
  }

  $sql = "INSERT INTO accounts (username, hashed_password, first_name, last_name, is_admin) VALUES (?,?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssi", $username, $password, $firstname, $lastname, $is_admin);

  if (!$stmt->execute()) {
    return jsonResponse("error", "Account Not Registered!");
  }
  return jsonResponse("success", "Account Registered!");
}

function isUsernameAvailable($conn, $username) {

  $sql = "SELECT username FROM accounts WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  return $result->num_rows === 0;
}

function jsonResponse($status, $message) {
  return json_encode([
      "status" => $status,
      "message" => $message
  ]);
}