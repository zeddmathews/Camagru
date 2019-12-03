<?php include('header.php');?>
	<?php
		require('config/pdo_connection.php');
		if (isset($_POST['submit'])) {
			if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
				echo '<label>You are not logged in</label><br>';
			}
		}
		try {
			$stmt = $conn->prepare("SELECT * FROM images ORDER BY id DESC");
			$stmt->execute();
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		try {
			$query = $conn->prepare("SELECT * FROM users WHERE email = ?");
			$query->execute(array($_SESSION['logged_in']));
			$result = $query->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel ="stylesheet" href="css/camagru.css">
	<script src="js/camera.js"></script>
	<title>Feed</title>
	<style>
		.img
		{
			/* border: 10px solid red; */
			/* background: no-repeat; */
			/* background-size: cover; */
			height: 25vh;
			width: 12.5vw;
		}
	</style>
</head>
<body onload="init();">
	<h3>Welcome <?php echo $result['username']?></h3>
	<img src="" id="image"/>
	<br>
	<?php
			while ($imgs = $stmt->fetch(PDO::FETCH_ASSOC)) {?>
				<h4>Posted by <?php echo $imgs['username']?></h4>
				<img class = "img" src = "image/<?php echo $imgs['imagename'] ?>">
				<br>
				<button onclick="likes(<?php echo $imgs['id']?>);">Like</button>
				<p> 1 </p>
			<?php
			}
	?>

</body>
</html>
<?php include('footer.php');?>