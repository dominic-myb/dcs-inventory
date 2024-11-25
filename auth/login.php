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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= $ICON_IMG_PATH ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?= $BOOTSTRAP_CSS_PATH ?>">
  <link rel="stylesheet" href="<?= $LOGIN_CSS ?>">
  <title>DCS - <?= $PAGE_TITLE ?></title>
</head>

<body>
  <main>
    <div class="content d-flex">
      <div class="wrapper">
        <h1>LOGIN</h1>
        <form method="post" id="login-form" class="login-form">
          <label for="username">Username:</label>
          <input type="text" id="username" autocomplete="off" required>
          <label for="pass-input">Password:</label>
          <div class="pass-container">
            <input type="password" id="pass-input" autocomplete="off" required>
            <input type="button" id="pass-toggle" value="Show">
          </div>
          <div id="pass-incorrect">
            <p>Incorrect Username or Password!</p>
          </div>
          <div class="btn-container">
            <input type="submit" id="submit-btn" class="submit-btn">
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