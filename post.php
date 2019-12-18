<?php include('header.php')?>
<script src="js/likes.js"></script>
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
		try {
			$fetch = $conn->prepare("SELECT * FROM likes WHERE post_id = ?");
			$fetch->execute(array($id));
			$likes = $fetch->rowCount();
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	if (isset($_SESSION['logged_in']) && !empty($_SESSION['logged_in'])) {
		if (filter_has_var(INPUT_POST, 'delete')) {
			$delete_image = $conn->prepare("DELETE FROM images WHERE id = ?");
			$delete_image->execute(array($id));
			$delete_like = $conn->prepare("DELETE FROM likes WHERE post_id = ?");
			$delete_like->execute(array($id));
			$delete_comment = $conn->prepare("DELETE FROM comments WHERE post_id = ?");
			$delete_comment->execute(array($id));
			header("Location: index.php");
		}
		if (filter_has_var(INPUT_POST, 'comment')) {
			$comment = trim(htmlentities($_POST['comment']));
			if (empty($comment)) {
				echo 'Put stuff';
			}
			else if (!empty($comment)) {
				try {
					$upload_comment = $conn->prepare("INSERT INTO comments (postedby, commentedby, comment, post_id) VALUES(?, ?, ?, ?)");
					$upload_comment->execute(array($imgs['username'], $_SESSION['user'], $comment, $id));
					$check_notif = $conn->prepare("SELECT * FROM users WHERE email = ?");
					$check_notif->execute(array($_SESSION['logged_in']));
					$is_on = $check_notif->fetch(PDO::FETCH_ASSOC);
					if ($is_on['notifications'] == "1") {
						$msg = $_SESSION['user'].'commented: '.$comment.' on the image: '.$imgs['imagename'].'.';
						mail($imgs['email'], 'Comment', $msg);
					}
				}
				catch(PDOException $e) {
					echo $e->getMessage();
				}
				
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
	<br>
	<button name="like" onclick="like(<?php echo $id?>);">Like</button>
	<b id="num_likes-<?php echo $id?>"><?php echo $likes?></b>
<form class="edit-form" action="" method="post">
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