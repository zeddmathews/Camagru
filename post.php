<?php include('header.php')?>
<?php
	if ($_GET['id']) {
		$id = $_GET['id'];
		try {
			$stmt = $conn->prepare("SELECT * FROM images WHERE id = ?");
			$stmt->execute(array($id));
			$imgs = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	if (isset($_SESSION['logged_in']) && !empty($_SESSION['logged_in'])) {
		if (filter_has_var(INPUT_POST, 'like')) {

		}
		if (filter_has_var(INPUT_POST, 'delete')) {
			$delete = $conn->prepare("DELETE FROM images WHERE id = ?");
			$delete->execute(array($id));
			header("Location: index.php");
		}
	}
	?>
<img class = "img" src = "image/<?php echo $imgs['imagename'] ?>">
<form class="edit-form" action="" method="post">
	<button type="submit" name="like">Like</button>
<?php if ($_SESSION['logged_in'] == $imgs['email']): ?>
	<button type="submit" name="delete">Delete</button>
<?php endif?>
</form>
<?php?>
<?php include('footer.php')?>