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
    <div class="content d-flex col-sm-11 col-md-10 col-lg-9 col-xl-9 col-xxl-8">
      <div class="wrapper">
        <h1>LOGIN</h1>
        <form method="post" class="form">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
          <div id="incorrect-pass">
            <p>incorrect Password!</p>
          </div>
          <div class="btn-container">
            <input type="submit" class="submit-btn">
          </div>
        </form>
      </div>
    </div>
  </main>
  <script src="<?= $BOOTSTRAP_JS_PATH ?>"></script>
  <script src="<?= $JQUERY_PATH ?>"></script>
  <script src="<?= $LOGIN_JS ?>"></script>
</body>

</html>