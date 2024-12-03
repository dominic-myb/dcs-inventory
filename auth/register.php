<?php
include("../backend/db_config.php");
$PAGE_TITLE = "REGISTER";
$ICON_IMG_PATH = "../assets/imgs/dcs-logo-round.png";
$BOOTSTRAP_CSS_PATH = "../assets/vendors/css/bootstrap.min.css";
$BOOTSTRAP_JS_PATH = "../assets/vendors/js/bootstrap.min.js";
$JQUERY_PATH = "../assets/vendors/jquery-3.7.1.min.js";

$REGISTER_CSS_PATH = "../assets/css/register.css";
$REGISTER_JS_PATH = "../assets/js/register.js";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $BOOTSTRAP_CSS_PATH ?>">
  <link rel="stylesheet" href="<?= $REGISTER_CSS_PATH ?>">
  <link rel="shortcut icon" href="<?= $ICON_IMG_PATH ?>" type="image/x-icon">
  <title>DCS - <?= $PAGE_TITLE ?></title>
</head>

<body>
  <main>
    <div class="content d-flex">
      <div class="wrapper">

        <div class="heading-container">
          <h1>REGISTER</h1>
        </div>

        <div class="form-container">
          <form id="registration-form">
            
            <label for="fnameInput">Firstname:</label>
            <input type="text" id="fnameInput" name="fname" autocomplete="off" required>

            <label for="lnameInput">Lastname:</label>
            <input type="text" id="lnameInput" name="lname" autocomplete="off" required>

            <label for="userInput">Username:</label>
            <input type="text" id="userInput" name="user" autocomplete="off" required>
            <div id="userErrorMsg">
              <!-- // FIXME: -->
              <!-- Display here the error for usernames: -->
              <!-- "Oops! That username is already in use." -->
              <!-- "Usernames can only contain letters, numbers, and underscores." -->
              <!-- "Username cannot be empty." -->
            </div>

            <label for="passInput">Password:</label> 
            <input type="password" id="passInput" name="pass" autocomplete="off" required>

            <label for="passInputConfirm">Confirm Password:</label>
            <input type="password" id="passInputConfirm" name="passConfirm" autocomplete="off" required>

            <div id="passErrorMsg">
              <!-- // FIXME: -->
              <!-- Display password Error: -->
              <!-- "Password must include at least one uppercase letter, one number, and one special character." -->
              <!-- "Password must be at least 8 characters long." -->
              <!-- "Passwords do not match. Please try again." -->
              <!-- "Avoid using commonly used passwords for better security." -->
              <!-- "Password cannot be empty." -->
              <!-- "Use only letters, numbers, and symbols in your password." -->
            </div>

            <div id="errorMsg" class="error-message">
              <p>Username Unavailable</p>
            </div>

            <div class="submit-btn-container">
              <input type="submit" value="Submit">
            </div>
            
          </form>
        </div>

      </div>
    </div>
  </main>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.1/purify.min.js"></script>
  <script src="<?= $BOOTSTRAP_JS_PATH ?>"></script>
  <script src="<?= $JQUERY_PATH ?>"></script>
  <script src="<?= $REGISTER_JS_PATH ?>"></script>
</body>

</html>