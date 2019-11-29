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
	<form class="login-form" action="" method="post">

		<input type="email" name="email" placeholder="E-mail" required>

		<br>

		<input type="password" name="password" placeholder="Password" required>

		<br>

		<button type="submit" name="Login">Login</button>
	</form>
</body>
</html>

<?php include('footer.php')?>

<?php
	require('config/pdo_connection.php');
	$mail = trim(htmlspecialchars($_POST['email']));
	$pass = trim(htmlspecialchars($_POST['password']));
	if ($_POST) {	
		try {
			$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
			$stmt->execute(array($mail));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($result['email'] != $mail) {
				echo 'This account does not exist';
			}
			if (password_verify($pass, $result['encrypt'])) {
				$_SESSION['logged_in'] = $mail;
				header("Location: feed.php");
			}
		}
		catch (PDOException $e) {
			echo 'Nice'. $e->getMessage();
		}
	}
?>