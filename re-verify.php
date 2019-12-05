<?php include('header.php')?>
<?php
	require('config/pdo_connection.php');

	if (isset($_SESSION['logged_in']) && !(empty($_SESSION['logged_in']))) {
		header("Location: profile.php");
	}
	try {
		$email = $_GET['email'];
		$token = $_GET['token'];
		$check = $conn->prepare("SELECT * FROM users WHERE email = ?");
		$check->execute(array($email));
		$comp = $check->fetch(PDO::FETCH_ASSOC);
		if ($comp['token'] == $token) {
			echo 'Account verified';
		}
		else {
			echo 'Oops';
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	if (filter_has_var(INPUT_POST, 'update_password')) {
		$new_pass = trim(htmlspecialchars($_POST['new_password']));
		$conf_pass = trim(htmlspecialchars($_POST['conf_new_pass']));
		if (!empty($new_pass && !empty($conf_pass))) {
			try {
				// $upp = preg_match('@[A-Z]@', $new_pass);
				// $low = preg_match('@[a-z]@', $new_pass);
				// $num = preg_match('@[0-9]@', $new_pass);
				// $spec = preg_match('@[^\w]@', $new_pass);
				// if (!$upp) {
				// 	echo 'No uppercase letters<br>';
				// }
				// else if (!$low) {
				// 	echo 'No lowercase letters<br>';
				// }
				// else if (!$num) {
				// 	echo 'No numbers<br>';
				// }
				// else if (!$spec) {
				// 	echo 'No special characters<br>';
				// }
				// else if (strlen($pass1) < 8) {
				// 	echo 'Password too short<br>';
				// }
				if ($new_pass != $conf_pass) {
					echo 'Passwords do not match';
				}
				else {
					$encrypt = password_hash($new_pass, PASSWORD_BCRYPT);
					$update = $conn->prepare("UPDATE users SET encrypt = ? WHERE email = ?");
					$update->execute(array($encrypt, $email));
					$fetch = $update->fetch(PDO::FETCH_ASSOC);
					var_dump($fetch['encrypt']);
				}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
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
		<button type="submit" name="update_password">Update Password</button>
	</form>
</body>
</html>
<?php include('footer.php')?>