<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Camagru</title>
	<link rel="stylesheet" href="css/camagru.css">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
<div id="header">
	<a href="index.php" id="left">Camagru</a>
<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	require('config/pdo_connection.php');
	
	if (isset($_SESSION['created'])) {
		// Select all columns from users
		$stmt = $conn->prepare("SELECT * FROM users");
		$stmt->execute();
		$users = $stmt->fetch(PDO::FETCH_ASSOC);

		// Select all columns from images
		$stm = $conn->prepare("SELECT * FROM images");
		$stm->execute();
		$images = $stm->fetch(PDO::FETCH_ASSOC);

		// Select all columns from comments
		$st = $conn->prepare("SELECT * FROM comments");
		$st->execute();
		$comments = $st->fetch(PDO::FETCH_ASSOC);

		// Select all columns from likes
		$s = $conn->prepare("SELECT * FROM likes");
		$s->execute();
		$likes = $s->fetch(PDO::FETCH_ASSOC);
	}
	
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		?>	<a href="login.php" id="right">Login</a>
			<a href="signup.php" id="right">Sign Up</a>
	<?php
	} else {
		?>	<a href="profile.php" id="right">Profile</a>
			<a href="camera.php" id="right">Camera</a>
			<a href="logout.php" id ="right">Logout</a>
	<?php
	}
	?>
</div>
<hr class="h">