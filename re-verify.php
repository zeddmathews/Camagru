<?php include('header.php')?>
<?php
	require('config/pdo_connection.php');

	if (isset($_SESSION['logged_in']) && !(empty($_SESSION['logged_in']))) {
		header("Location: profile.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>New Password</title>
	<link rel="stylesheet" href="css/camagru.css">
</head>
<body>
	<form class="new-pass-form" action="" method="post">
		<input type="password" name="new_password" placeholder="New Password">
		<br>
		<input type="password" name="conf_new_pass" placeholder="Confirm Password">
		<br>
	</form>
</body>
</html>
<?php include('footer.php')?>