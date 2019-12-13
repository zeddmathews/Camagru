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
	if (filter_has_var(INPUT_POST, 'comment')) {
		$comment = trim(htmlspecialchars($_POST['comment']));
		if (empty($comment)) {
			echo 'Put stuff';
		}
		else if (!empty($comment)) {
			try {
				$upload_comment = $conn->prepare("INSERT INTO comments (postedby, commentedby, comment) VALUES(?, ?, ?)");
				$upload_comment->execute(array($imgs['username'], $_SESSION['user'], $comment));
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
			
		}
	}
	try {
		$check_comment = $conn->prepare("SELECT * FROM comments ORDER BY id DESC");
		$check_comment->execute();
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	?>
<img class = "img" src = "image/<?php echo $imgs['imagename'] ?>">
<form class="edit-form" action="" method="post">
	<button type="submit" name="like">Like</button>
	<br>
<?php if ($_SESSION['logged_in'] == $imgs['email']): ?>
	<button type="submit" name="delete">Delete</button>
	<br>
<?php endif?>
	<input type="text" name="comment" placeholder="Comment...">
	<br>
	<button type="submit" name="buttonses">Comment</button>
</form>
<?php while($print = $check_comment->fetch(PDO::FETCH_ASSOC)):?>
<h4>Commented by: <?php echo $print['commentedby']?></h4>
<p>
<?php
echo $print['comment'];
?>
</p>
<?php endwhile?>
<?php include('footer.php')?>