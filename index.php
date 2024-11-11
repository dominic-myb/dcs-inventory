<?php include("./includes/components/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $pageTitle = "Invetory Management System";
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
        <div class="content table-responsive primary-table">
            <table class="table">
                <thead>
                    <tr>
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
                            <tr>
                                <td class="item-name"><?php echo $row['item_name'] ?></td>
                                <td><?php echo $row['quantity'] ?></td>
                                <td><?php echo $row['location'] ?></td>
                                <td class="desc"><?php echo $row['description'] ?></td>
                                <td><?php echo $row['status'] ?></td>
                                <td>
                                    <a href="update.php?updateid=<?php echo $row['id'] ?>" class="btn btn-primary">Update</a>
                                    <a href="delete.php?deleteid=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
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
    </main>
    <script src="<?php echo BOOTSTRAP_JS_PATH ?>"></script>
    <script src="<?php echo MAIN_JS_PATH ?>"></script>
</body>

</html>