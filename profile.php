<?php include('header.php');?>

<?php
	// require('config/pdo_connection.php');
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		header("Location: login.php");
	}
	$mail = $_SESSION['logged_in'];
	$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
	$stmt->execute(array($mail));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	echo $row['username']."<br>";
	// var_dump($row['email']);
	// var_dump($row['username']);

	if (filter_has_var(INPUT_POST, 'Update')) {
		$cur_user = trim(htmlspecialchars($_POST['current_user']));
		$cur_email = trim(htmlspecialchars($_POST['current_email']));
		$cur_pass = trim(htmlspecialchars($_POST['current_password']));
		$new_user = trim(htmlspecialchars($_POST['new_user']));
		$new_email = trim(htmlspecialchars($_POST['new_email']));
		$new_pass = trim(htmlspecialchars($_POST['new_password']));
		$new_pass2 = trim(htmlspecialchars($_POST['new_password2']));

		if ($cur_user != $row['username']) {
			echo 'Incorrect username';
		}
		else if ($cur_email != $row['email']) {
			echo 'Incorrect email';
		}
		else if (!(password_verify($cur_pass, $row['encrypt']))) {
			echo 'Incorrect password';
		}
		else {
			try {
				$scan_all = $conn->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
				$scan_all->execute(array($row['username'], $row['email']));
				$compare = $scan_all->fetch(PDO::FETCH_ASSOC);
				if ($new_user == $row['username']) {
					echo 'Pick a new username';
				}
				else if ($new_user == $compare['username']) {
					echo 'Username already taken';
				}
				else if ($new_email == $row['email']) {
					echo 'Pick a new email';
				}
				else if ($new_email == $compare['email']) {
					echo 'Email already taken';
				}
				// $upp = preg_match('@[A-Z]@', $new_pass);
				// $low = preg_match('@[a-z]@', $new_pass);
				// $num = preg_match('@[0-9]@', $new_pass);
				// $spec = preg_match('@[^\w]@', $new_pass);
				// else if (!$upp) {
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
				// else if (strlen($new_pass) < 8) {
				// 	echo 'Password too short<br>';
				// }
				// if (!$upp || !$low || !$num || !$spec || strlen($new_pass) < 8) {
				// 	echo 'Password shoulbe be at least 8 characters in length and should include
				// 	at least one upper case letter, one lower case letter, one number, and one special character.<br>';
				// 	exit ;
				// }
				else if ($new_pass != $new_pass2) {
					echo 'Please enter matching passwords';
				}
				else {
					try {
						$encrypt = password_hash($new_pass, PASSWORD_BCRYPT);
						$update_info = $conn->prepare("UPDATE users SET username = ?, email = ?, encrypt = ?, verified = 0 WHERE username = ?");
						$update_info->execute(array($new_user, $new_email, $new_pass, $cur_user));
						$test = $conn->prepare("SELECT username FROM users WHERE username = ?");
						$test->execute(array($new_user));
						$print = $test->fetch(PDO::FETCH_ASSOC);
						if ($print['username'] == $new_user) {
							echo 'Details successfully updated. Please verify your new email address.';
						}
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
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
	<title>Profile</title>
</head>
<body>
	<form class="update-username" action="" method="post">
		<h2>Update your username</h2>
		<input type="text" name="user_curr_user" placeholder="Username" required>
		<br>
		<br>
		<input type="password" name="user_curr_pass" placeholder="Password" required>
		<br>
		<br>
		<input type="text" name="new_user" placeholder="New Username" required>
		<br>
		<br>
		<button type="submit" name="Update-username">Update</button>
	</form>
	<?php
		if (filter_has_var(INPUT_POST, 'Update-username')) {
			$ucu = trim(htmlspecialchars($_POST['user_curr_user']));
			$ucp = trim(htmlspecialchars($_POST['user_curr_pass']));
			$nu = trim(htmlspecialchars($_POST['new_user']));
			if (empty($ucu) || empty($ucp) || empty($nu)) {
				echo 'Please fill in all fields';
			}
			else if (!empty($ucu) && !empty($ucp) && !empty($nu)){
				$scan_all = $conn->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
				$scan_all->execute(array($row['username'], $row['email']));
				$compare = $scan_all->fetch(PDO::FETCH_ASSOC);
				if ($ucu != $row['username']) {
					echo 'Incorrect username';
				}
				else if (!(password_verify($ucp, $row['encrypt']))) {
					echo 'Incorrect password';
				}
				else if ($nu == $compare['username']) {
					echo 'Username already taken';
				}
				else {
					echo 'Try stuff';
				}
			}
		}
	?>
	<form class="update-password" action="" method="post">
		<h2>Update your password</h2>
		<input type="password" name="pass_curr_pass" placeholder="Password" required>
		<br>
		<br>
		<input type="password" name="new_pass" placeholder="New Password" required>
		<br>
		<br>
		<input type="password" name="new_pass2" placeholder="Comfirm New Password" required>
		<br>
		<br>
		<button type="submit" name="Update-password">Update</button>
	</form>
	<form class="update-email" action="" method="post">
		<h2>Update your email</h2>
		<input type="email" name="mail_curr_mail" placeholder="Email" required>
		<br>
		<br>
		<input type="email" name="new_mail" placeholder="New Email" required>
		<br>
		<br>
		<input type="password" name="mail_curr_pass" placeholder="Password" required>
		<br>
		<br>
		<button type="submit" name="Update-email">Update</button>
	</form>
</body>
</html>

<?php include('footer.php');?>