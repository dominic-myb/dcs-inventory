<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: ./auth/login.php");
  exit();
}

include("./backend/db_config.php");
$PAGE_TITLE = "Inventory Management System";
$BOOTSTRAP_CSS_PATH = "./assets/vendors/css/bootstrap.min.css";
$MAIN_CSS_PATH = "./assets/css/main.css";
$JQUERY_PATH = "./assets/vendors/jquery-3.7.1.min.js";
$BOOTSTRAP_JS_PATH = "./assets/vendors/js/bootstrap.min.js";
$MAIN_JS_PATH = "./assets/js/main.js";
$ICON_IMG_PATH = "./assets/imgs/dcs-logo-round.png";
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $BOOTSTRAP_CSS_PATH ?>">
  <link rel="stylesheet" href="<?= $MAIN_CSS_PATH ?>">
  <link rel="icon" type="image/x-icon" href="<?= $ICON_IMG_PATH ?>">
  <title>DCS - <?= $PAGE_TITLE ?></title>
</head>

<body>
  <nav class="navbar">
    <ul class="nav-list">
      <li style="color:#fff;"><?= $username ?></li>
      <li><a href="./backend/logout.php" class="btn btn-danger">Logout</a></li>
    </ul>
  </nav>
  <main>
    <!-- ########## START OF PAGE HEADER IN INDEX.HTML ########### -->

    <div class="page-title d-flex flex-row">
      <div class="row justify-content-center">

        <h1>DCS <?= $PAGE_TITLE ?></h1>

        <div class="col-auto">
          <label for="searchBar" class="form-label">
            Search:
          </label>
        </div>

        <div class="col-auto">
          <input type="text" id="searchBar" class="form-control" placeholder="Search...">
          <input type="hidden" id="token" value="<?= $_SESSION['csrf_token']; ?>">
        </div>

        <div class="col-auto">
          <div class="row">
            <div class="wrapper d-flex justify-content-start text-center">
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addItemModal">
                Add Item
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ########## END OF PAGE HEADER IN INDEX.HTML ########### -->

    <!-- ########## START OF ITEM TABLE IN INDEX.HTML ########### -->

    <div class="content table-responsive mx-auto primary-table col-sm-11 col-md-10 col-lg-9 col-xl-9 col-xxl-8">
      <table class="table table-hover" id="items-table">
        <thead>
          <tr scope="row">
            <th scope="col">Item Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Location</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <?php
          $sql = "SELECT * FROM items";
          $res = $conn->query($sql);
          if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) { ?>

              <tr scope="row">
                <td><?= $row['item_name'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['location'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                  <a href="#" class="update-btn btn btn-primary" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target=".update-item-modal">Update</a>
                  <a href="#" class="delete-btn btn btn-danger" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target=".delete-item-modal">Delete</a>
                </td>
              </tr>

            <?php }
          } else { ?>

            <tr scope="row">
              <td colspan="6">
                0 Item Listed!
              </td>
            </tr>

          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- ########## END OF ITEM TABLE IN INDEX.HTML ########### -->

    <!-- ########## START OF ADD ITEM MODAL IN INDEX.HTML ########### -->

    <div id="addItemModal" class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="addItemForm">

            <div class="modal-header">
              <h5 class="modal-title">Add Item</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-default">Item Name</span>
                </div>
                <input type="text" id="itemName" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" autocomplete="off" required />
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-default">Quantity</span>
                </div>
                <input type="number" min="0" id="quantity" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" autocomplete="off" required />
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-default">Location</span>
                </div>
                <input type="text" id="location" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" autocomplete="off" required />
              </div>

              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-default">Description</span>
                </div>
                <textarea id="description" class="form-control" aria-label="With textarea"></textarea>
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-default">Status</span>
                </div>
                <select name="status" id="status" class="btn btn-secondary btn-sm dropdown-toggle" autocomplete="off" required>
                  <option class="status-option" value="In Good Condition">In Good Condition</option>
                  <option class="status-option" value="In Bad Condition">In Bad Condition</option>
                  <option class="status-option" value="Discontinued">Discontinued</option>
                </select>
              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
            </div>

          </form>
        </div>
      </div>
    </div>
    <!-- ########### END OF ADD ITEM MODAL IN INDEX.HTML ############ -->
    <?php include("./includes/modals/update_item.php"); ?>
    <?php include("./includes/modals/delete-item.php"); ?>
    <!-- ########### START OF MESSAGE MODAL IN INDEX.HTML ############ -->
    <div id="popupMsg" class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="popupTitle"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body" id="popupMsgContent">

          </div>
        </div>
      </div>
    </div>
    <!-- ########### END OF MESSAGE MODAL IN INDEX.HTML ############ -->
  </main>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.1/purify.min.js"></script>
  <script src="<?= $BOOTSTRAP_JS_PATH ?>"></script>
  <script src="<?= $JQUERY_PATH ?>"></script>
  <script src="<?= $MAIN_JS_PATH ?>"></script>
</body>

</html>