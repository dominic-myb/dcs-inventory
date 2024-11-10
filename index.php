<?php include("includes/components/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "Inventory Management System";
    $BOOTSTRAP_PATH = "./assets/css/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css";
    $MAIN_JS_PATH = "./assets/js/main.js";
    $MAIN_CSS_PATH = "./assets/css/main.css";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $BOOTSTRAP_PATH ?>">
    <link rel="stylesheet" href="<?php echo $MAIN_CSS_PATH ?>">
    <title>DCS <?php echo $pageTitle ?></title>
</head>

<body>
    <main>
        <div class="page-title">
            <h1>DCS - Inventory Management System</h1>
        </div>
        <div class="content">
            <table class="col-sm-3 col-lg-6 table-primary">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php
                        $query = "SELECT * FROM items";
                        $res = $conn->query($query);
                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                        ?>
                                <td><?php echo $row['item_name'] ?></td>
                                <td><?php echo $row['quantity'] ?></td>
                                <td><?php echo $row['location'] ?></td>
                                <td><?php echo $row['description'] ?></td>
                                <td><?php echo $row['status'] ?></td>
                                <td>
                                    <a href="update.php?updateid=<?php echo $row['id'] ?>" class="btn btn-primary">Update</a>
                                    <a href="delete.php?deleteid=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            <?php
                            }
                        } else {
                            ?>
                            <td colspan="6">0 Items Listed!</td>
                        <?php
                        }

                        ?>
                    </tr>
                </tbody>

            </table>
        </div>

    </main>
    <script src="<?php echo $MAIN_JS_PATH ?>"></script>
</body>

</html>