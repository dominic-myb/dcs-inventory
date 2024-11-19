<?php
include("../includes/components/connection.php");
$search = $_GET['q'] ?? '';
$search = mysqli_real_escape_string($conn, $search);

$sql = "SELECT * FROM items WHERE item_name LIKE '%$search%' OR quantity LIKE '%$search%' OR location LIKE '%$search%' OR status LIKE '%$search%'";
$res = mysqli_query($conn, $sql);

$data = [];
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
