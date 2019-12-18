<?php include('header.php')?>
<h2>Login</h2>

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

		<br>
		<input type="password" name="password" placeholder="Password" required>

		<br>

		<button type="submit" name="Login">Login</button>
		<br>
		<button type="button"><a href="signup.php">Sign Up</a></button>
		<br>
		<button type="button"><a href="change_password.php">Forgotten password?</a></button>
	</form>
</body>
</html>
<?php
	if (isset($_SESSION['logged_in']) && !(empty($_SESSION['logged_in']))) {
		header("Location: index.php");
	}
	if (filter_has_var(INPUT_POST, 'Login')) {
		$mail = trim(htmlentities($_POST['email']));
		$pass = trim(htmlentities($_POST['password']));
		if (!empty($mail) && !empty($pass)) {
			try {
				$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
				$stmt->execute(array($mail));
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($result['verified'] == "0") {
					echo 'Please verify your account';
				}
				else if ($result['email'] != $mail) {
					echo 'This account does not exist';
				}
				else if (password_verify($pass, $result['encrypt'])) {
					$_SESSION['logged_in'] = $mail;
					$_SESSION['user'] = $result['username'];
					if ($result['notifications'] == "1") {
						$msg = 'You logged in to your Camagru account on '.date("Y.m.d").' at '.date("h:i:sa").'.';
						mail($mail, 'You logged in', $msg);
					}
					header("Location: index.php");
				}
				else {
					echo 'Invalid password';
				}
			}
			catch (PDOException $e) {
				echo 'Nice'. $e->getMessage();
			}
		}
	}
	?>
	<?php include('footer.php')?>