<?php
include("../backend/db-config.php");
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
          <form id="registrationForm">

            <label for="fnameInput">Firstname:</label>
            <input type="text" id="fnameInput" name="fname" autocomplete="off" required>

            <label for="lnameInput">Lastname:</label>
            <input type="text" id="lnameInput" name="lname" autocomplete="off" required>

            <label for="userInput">Username:</label>
            <input type="text" id="userInput" name="user" autocomplete="off" required>

            <label for="passInput">Password:</label>
            <input type="password" id="passInput" name="pass" autocomplete="off" required>

            <label for="passInputConfirm">Confirm Password:</label>
            <input type="password" id="passInputConfirm" name="passConfirm" autocomplete="off" required>

            <div class="pass-strength-container">
              <label for="passStrength">Password Strength:</label>
              <meter id="passStrength" min="0" max="5" value="0"></meter>
              <p id="passStrengthText">Weak</p>
            </div>

            <div id="errorMsg" class="error-message">
            </div>

            <div class="submit-btn-container">
              <input type="submit" value="Submit" id="submitBtn" class="btn btn-info">
            </div>

          </form>
          <hr>
          <div class="login-container">
            <a href="./login.php" class="btn btn-warning">Login</a>
          </div>
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