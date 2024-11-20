<?php include("./includes/components/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Inventory Management System";
$BOOTSTRAP_CSS_PATH = "./assets/css/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css";
$MAIN_CSS_PATH = "./assets/css/main.css";
$BOOTSTRAP_JS_PATH = "./assets/css/vendor/bootstrap-5.2.3-dist/js/bootstrap.min.js";
$MAIN_JS_PATH = "./assets/js/main.js";
include("./layouts/index/head.php");
?>

<body>
  <main>
    <?php include("./layouts/index/page_header.php"); ?>
    <div id="search-result"></div>
    <?php include("./layouts/index/table.php") ?>
    <?php include("./layouts/index/modals.php") ?>
  </main>
  <?php include("./layouts/index/scripts.php"); ?>
</body>

</html>