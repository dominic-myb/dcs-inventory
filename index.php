<?php include("./includes/components/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  $pageTitle = "Inventory Management System";
  const BOOTSTRAP_CSS_PATH = "./assets/css/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css";
  const MAIN_CSS_PATH = "./assets/css/main.css";
  const BOOTSTRAP_JS_PATH = "./assets/css/vendor/bootstrap-5.2.3-dist/js/bootstrap.min.js";
  const MAIN_JS_PATH = "./assets/js/main.js";
  ?>
  <link rel="stylesheet" href="<?php echo BOOTSTRAP_CSS_PATH ?>">
  <link rel="stylesheet" href="<?php echo MAIN_CSS_PATH ?>">
  <title>DCS <?php echo $pageTitle ?></title>
</head>

<body>
  <main>
    <div class="page-title">
      <h1>DCS <?php echo $pageTitle ?></h1>
    </div>
    <div class="content table-responsive mx-auto primary-table col-sm-11 col-md-10 col-lg-9 col-xl-9 col-xxl-8">
      <table class="table">
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
        <tbody>
          <?php
          $query = "SELECT * FROM items";
          $res = $conn->query($query);
          if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
          ?>
              <tr scope="row">
                <td><?php echo $row['item_name'] ?></td>
                <td><?php echo $row['quantity'] ?></td>
                <td><?php echo $row['location'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['status'] ?></td>
                <td>
                  <a href="update.php?update_id=<?php echo $row['id'] ?>" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i>Update</a>
                  <a href="delete.php?delete_id=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
                </td>
              </tr>
            <?php
            }
          } else {
            ?>
            <tr class="row">
              <td colspan="6">
                0 Item Listed!
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>

    <div id="add-btn-container" class="container col-sm-11 col-md-10 col-lg-9 col-xl-9 col-xxl-8 p-0">
      <div class="row">
        <div class="wrapper d-flex justify-content-start text-center">
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-item-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
            </svg>Add
          </button>
        </div>
      </div>
    </div>

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

  </main>
  <script src="<?php echo BOOTSTRAP_JS_PATH ?>"></script>
  <script src="<?php echo MAIN_JS_PATH ?>"></script>
</body>

</html>