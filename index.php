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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
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

		<div class="row justify-content-center">
			<div class="col-12 col-md-10 col-lg-9">
				<div class="table-responsive">
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
											<a href="#" class="update-btn btn btn-primary" data-id="<?= $row['id'] ?>" data-bs-toggle="modal"
												data-bs-target=".update-item-modal">Update</a>
											<a href="#" class="delete-btn btn btn-danger" data-id="<?= $row['id'] ?>" data-bs-toggle="modal"
												data-bs-target=".delete-item-modal">Delete</a>
										</td>
									</tr>

								<?php }
							} else { ?>

								<tr>
									<td colspan="6" class="text-center py-4">
										0 Item Listed!
									</td>
								</tr>

							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- ########## END OF ITEM TABLE IN INDEX.HTML ########### -->
		<?php
		include "./includes/modals/add-item.php";
		include "./includes/modals/update-item.php";
		include "./includes/modals/delete-item.php";
		include "./includes/modals/popup-message.php";
		?>

	</main>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.1/purify.min.js"></script>
	<script src="<?= $BOOTSTRAP_JS_PATH ?>"></script>
	<script src="<?= $JQUERY_PATH ?>"></script>
	<script src="<?= $MAIN_JS_PATH ?>"></script>
</body>

</html>