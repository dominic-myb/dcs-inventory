<?php
include("../backend/db_config.php");
$PAGE_TITLE = "LOGIN";
$ICON_IMG_PATH = "../assets/imgs/dcs-logo-round.png";
$BOOTSTRAP_CSS_PATH = "../assets/vendors/css/bootstrap.min.css";
$BOOTSTRAP_JS_PATH = "../assets/vendors/js/bootstrap.min.js";
$JQUERY_PATH = "../assets/vendors/jquery-3.7.1.min.js";
$LOGIN_CSS = "../assets/css/login.css";
$LOGIN_JS = "../assets/js/login.js";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="<?= $ICON_IMG_PATH ?>" type="image/x-icon" />
  <link rel="stylesheet" href="<?= $BOOTSTRAP_CSS_PATH ?>" />
  <link rel="stylesheet" href="<?= $LOGIN_CSS ?>" />
  <title>DCS - <?= $PAGE_TITLE ?></title>
</head>

<body>
  <main>
    <div class="content d-flex">
      <div class="wrapper">

        <h1>LOGIN</h1>

        <form id="login-form" class="login-form">

          <div class="user-container">
            <label for="userInput">Username:</label>
            <input type="text" id="userInput" autocomplete="off" required />
          </div>

          <div class="pass-container">
            <label for="passInput">Password:</label>
            <input type="password" id="passInput" autocomplete="off" required />
            <input type="button" id="passToggle" value="Show" />

            <div id="errorMsg" class="error-msg">
              <!-- password errors here! -->
              <!-- "The username or password you entered is incorrect." -->
              <!-- "Something went wrong. Unable to log in. Please refresh and try again." -->
              <!-- "We couldn't find an account with those credentials. Please sign up if you're new." add link of register -->
            </div>
          </div>

          <div class="sign-up-container">
            <a href="./register.php">Signup</a>
          </div>

          <div class="btn-container">
            <input type="submit" id="submitBtn" class="submit-btn" value="Submit"/>
          </div>

        </form>

      </div>
    </div>
  </main>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.1/purify.min.js"></script>
  <script src="<?= $BOOTSTRAP_JS_PATH ?>"></script>
  <script src="<?= $JQUERY_PATH ?>"></script>
  <script src="<?= $LOGIN_JS ?>"></script>
</body>

</html>