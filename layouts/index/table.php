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
        <tbody id="table-body">
            <?php
            $sql = "SELECT * FROM items";
            $res = $conn->query($sql);
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
            ?>
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
                <?php
                }
            } else {
                ?>
                <tr scope="row">
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