<?php
include("./includes/components/connection.php");
$PAGE_TITLE = "Inventory Management System";
$BOOTSTRAP_CSS_PATH = "./assets/css/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css";
$DATA_TABLES_CSS_PATH = "//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css";
$MAIN_CSS_PATH = "./assets/css/main.css";
$JQUERY_PATH = "./assets/js/vendor/jquery-3.7.1.min.js";
$BOOTSTRAP_JS_PATH = "./assets/css/vendor/bootstrap-5.2.3-dist/js/bootstrap.min.js";
$DATA_TABLES_JS_PATH = "//cdn.datatables.net/2.1.8/js/dataTables.min.js";
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