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
	<script src="js/notifications.js"></script>
</head>
<body>
<div id="header">
<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	require('config/pdo_connection.php');	
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		?>	
		<div class="nav_bar">
			<div class="yes">
			<a href="index.php" id="white">Feed</a>
			</div>
			<div class="yes">
			<a href="login.php" id="blue">Login</a>
			</div>
			<div class="yes">
			<a href="signup.php" id="white">Sign Up</a>
			</div>
		</div>
	<?php
	}
	else {
		?>	
		<div class="log_nav">
			<a href="index.php" id="blue">Feed</a>
			<a href="personal_gallery.php" id="white">My Gallery</a>
			<a href="profile.php" id="blue">Profile</a>
			<a href="camera.php" id="white">Camera</a>
			<a href="logout.php" id ="blue">Logout</a>
		</div>
	<?php
	}
	?>
</div>
<hr class="h">