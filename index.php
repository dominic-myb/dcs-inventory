<?php
include("./backend/db_config.php");
$PAGE_TITLE = "Inventory Management System";
$BOOTSTRAP_CSS_PATH = "./assets/vendors/css/bootstrap.min.css";
$MAIN_CSS_PATH = "./assets/css/main.css";
$JQUERY_PATH = "./assets/vendors/jquery-3.7.1.min.js";
$BOOTSTRAP_JS_PATH = "./assets/vendors/js/bootstrap.min.js";
$MAIN_JS_PATH = "./assets/js/main.js";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $BOOTSTRAP_CSS_PATH ?>">
  <link rel="stylesheet" href="<?= $MAIN_CSS_PATH ?>">
  <title><?= $PAGE_TITLE ?></title>
</head>

<body>
  <main>
    <!-- ########## START OF PAGE HEADER IN INDEX.HTML ########### -->

    <div class="page-title d-flex flex-row">
      <div class="row justify-content-center">

        <h1>DCS <?= $PAGE_TITLE ?></h1>

        <div class="col-auto">
          <label for="search-bar" class="form-label">
            Search:
          </label>
        </div>

        <div class="col-auto">
          <input type="text" id="search-bar" class="form-control" placeholder="Search...">
        </div>

        <div class="col-auto">
          <div class="row">
            <div class="wrapper d-flex justify-content-start text-center">
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-item-modal">
                Add Item
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ########## END OF PAGE HEADER IN INDEX.HTML ########### -->

    <div id="search-result"></div>

    <!-- ########## START OF ITEM TABLE IN INDEX.HTML ########### -->

    <div class="content table-responsive mx-auto primary-table col-sm-11 col-md-10 col-lg-9 col-xl-9 col-xxl-8">
      <table class="table" id="items-table">
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
        <tbody id="table-body">
          <?php
          $sql = "SELECT * FROM items";
          $res = $conn->query($sql);
          if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) { ?>

              <tr scope="row">
                <td><?= $row['item_name'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['location'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                  <a href="update.php?update_id=<?= $row['id'] ?>" class="btn btn-primary">Update</a>
                  <a href="delete.php?delete_id=<?= $row['id'] ?>" class="btn btn-danger">Delete</a>
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

    <div id="add-item-modal" class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title">Add Item</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <form id="add-item-form" method="post">

              <label>Item Name</label>
              <input type="text" name="item-name" required>
              <label>Quantity</label>
              <input type="number" name="quantity" required>
              <label>Location</label>
              <input type="text" name="location" required>
              <label>Description</label>
              <textarea name="description"></textarea>
              <label>Status</label>
              <select name="status" id="status" class="btn btn-primary btn-sm dropdown-toggle" required>
                <option value="In Good Condition">In Good Condition</option>
                <option value="In Bad Condition">In Bad Condition</option>
                <option value="Discontinued">Discontinued</option>
              </select>

            </form>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary">Save</button>
          </div>

        </div>
      </div>
    </div>

    <!-- ########### END OF ADD ITEM MODAL IN INDEX.HTML ############ -->
  </main>
  <script src="<?= $BOOTSTRAP_JS_PATH ?>"></script>
  <script src="<?= $JQUERY_PATH ?>"></script>
  <script src="<?= $MAIN_JS_PATH ?>"></script>
</body>

</html>