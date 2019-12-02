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
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		?>	<a href="login.php" id="right">Login</a>
			<a href="signup.php" id="right">Sign Up</a>
	<?php
	} else {
		?>	<a href="profile.php" id="right">Profile</a>
			<a href="camera.php" id="right">Images</a>
			<a href="logout.php" id ="right">Logout</a>
	<?php
	}
	?>
</div>
<hr class="h">