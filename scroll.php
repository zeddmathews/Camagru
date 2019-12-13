<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	require('config/pdo_connection.php');
?>
<?php
$load_id = $_GET['load_id'];
$offset = ($load_id - 1) * 5;
try {
		$stmt = $conn->prepare("SELECT * FROM images ORDER BY id DESC LIMIT 5 OFFSET :offset");
		$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
		$stmt->execute();
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	if (isset($_SESSION['logged_in']) && !(empty($_SESSION['logged_in']))) {
		try {
			$query = $conn->prepare("SELECT * FROM users WHERE email = ?");
			$query->execute(array($_SESSION['logged_in']));
			$result = $query->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
?>
<body>
	<h3>Welcome to Camagru<?php 
	if (isset($_SESSION['logged_in']) && !(empty($_SESSION['logged_in']))) {
		echo ' '.$result['username'];
	}
	?></h3>
	<img src="" id="image"/>
	<br>
	<?php while ($imgs = $stmt->fetch(PDO::FETCH_ASSOC)):?>
		<a href="post.php?id=<?php echo $imgs['id'];?>">
			<h4>Posted by <?php echo $imgs['username']?></h4>
			<img class = "img" src = "image/<?php echo $imgs['imagename'] ?>">
		</a>
	<?php endwhile?>

</body>