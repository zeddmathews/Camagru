<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	require('config/pdo_connection.php');
?>
<?php
$load_id = $_GET['load_id'];
var_dump($load_id);
$offset = ($load_id - 1) * 5;
try {
		$stmt = $conn->prepare("SELECT * FROM images ORDER BY id DESC LIMIT 5 OFFSET :offset");
		$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
		$stmt->execute();
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>
<body>
	<img src="" id="image"/>
	<br>
	<?php while ($imgs = $stmt->fetch(PDO::FETCH_ASSOC)):?>
		<a href="post.php?id=<?php echo $imgs['id'];?>">
			<h4>Posted by <?php echo $imgs['username']?></h4>
			<img class = "img" src = "image/<?php echo $imgs['imagename'] ?>">
		</a>
	<?php endwhile?>

</body>