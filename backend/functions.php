<?php
function authenticateAccount($username, $password)
{
  include("./db_config.php");
  $password = hash('sha256', $password);
  $sql = "SELECT username, hashed_password FROM accounts WHERE username='$username' and hashed_password='$password'";
  $res = $conn->query($sql);
  if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    // echo json_encode
  }
}
