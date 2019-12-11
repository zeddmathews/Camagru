<?php include('header.php')?>
<?php
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		header("Location: login.php");
	}
	try {
		$stmt = $conn->prepare("SELECT * FROM images WHERE email = ? ORDER BY id DESC");
		$stmt->execute(array($_SESSION['logged_in']));
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	try {
		$this_user = $conn->prepare("SELECT * FROM images ORDER BY id DESC");
		$this_user->execute();
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	$print_user = $this_user->fetch(PDO::FETCH_ASSOC);
	while ($imgs = $stmt->fetch(PDO::FETCH_ASSOC)):?>
		<a href="post.php?id=<?php echo $imgs['id'];?>">
			<h4>Posted by <?php echo $imgs['username']?></h4>
			<img class = "img" src = "image/<?php echo $imgs['imagename'] ?>">
		</a>
	<?php endwhile
?>

<?php include('footer.php')?>