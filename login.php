<?php include('header.php')?>
<h1>Login</h1>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Login</title>
</head>
<body>
	<form class="login-form" action="">

		<label>E-mail</label>
		<br>
		<input type="email" name="email" required>

		<br>

		<label>Password</label>
		<br>
		<input type="password" name="password" required>

		<br>

		<button type="submit" name="Login">Login</button>
	</form>
</body>
</html>

<?php include('footer.php')?>

<?php
	require('../config/pdo_connection.php');
	$mail = trim(htmlspecialchars($_POST['email']));
	$pass = trim(htmlspecialchars($_POST['password']));
	try {
		$stmt = $conn->prepare("SELECT username FROM users WHERE email = :mail AND encrypt = :pass");
		$stmt->bindParam(':mail', $mail);
		$stmt->bindParam(':encrypt', $pass);
		$stmt->execute();
		$_SESSION['logged_in'] = $mail;
		header("Location: feed.php");
	}
	catch (PDOException $e) {
		echo 'Nice'. $e->getMessage();
	}
?>