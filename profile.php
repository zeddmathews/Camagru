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
				try {
				$scan_all = $conn->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
				$scan_all->execute(array($row['username'], $row['email']));
				$compare = $scan_all->fetch(PDO::FETCH_ASSOC);
				$scan_all = $conn->prepare("SELECT * FROM users WHERE username = ?");
				$scan_all->execute(array($nu));
				$run = $scan_all->fetch(PDO::FETCH_ASSOC);
				}
				catch(PDOException $e) {
					echo 'Is broken: '.$e->getMessage();
				}
				if ($ucu != $row['username']) {
					echo 'Incorrect username';
				}
				else if (!(password_verify($ucp, $row['encrypt']))) {
					echo 'Incorrect password';
				}
				else if ($nu == $run['username']) {
					echo 'Username already taken';
				}
				else {
					$token = md5($nu);
					$update_username = $conn->prepare("UPDATE users SET username = ?, verified = 0, token = ? WHERE username = ?");
					$update_username->execute(array($nu, $token, $ucu));
					$test_user = $conn->prepare("SELECT username FROM users WHERE username = ?");
					$test_user->execute(array($nu));
					$print_user = $test_user->fetch(PDO::FETCH_ASSOC);
					if ($print_user['username'] == $nu) {
						echo 'Username successfully updated'."<br>".'A new verification email has been sent to you.'."<br>".'Please verify your account and login again.';
						$msg = 'Please click the following link to re-activate your account: http://localhost:8080/Camagru/verify_update.php?email='.$_SESSION['logged_in'].'&token='.$token;
						mail($mail, 'Re-activate Account', $msg);
						if (isset($_SESSION['logged_in']) && !(empty($_SESSION['logged_in']))) {
							session_unset();
							session_destroy();
						}
						?>
							<button><a href="login.php">Login</a></button>
						<?php
					}
				}
			}
		}
	?>
	<form class="update-email" action="" method="post">
		<h2>Update your email</h2>
		<input type="email" name="mail_curr_mail" placeholder="Email" required>
		<br>
		<br>
		<input type="password" name="mail_curr_pass" placeholder="Password" required>
		<br>
		<br>
		<input type="email" name="new_mail" placeholder="New Email" required>
		<br>
		<br>
		<button type="submit" name="Update-email">Update</button>
	</form>
	<?php
		if (filter_has_var(INPUT_POST, 'Update-email')) {
			$mcm = trim(htmlspecialchars($_POST['mail_curr_mail']));
			$nm = trim(htmlspecialchars($_POST['new_mail']));
			$mcp = trim(htmlspecialchars($_POST['mail_curr_pass']));
			if (empty($mcm) || empty($nm) || empty($mcp)) {
				echo 'Please fill in all fields';
			}
			else if (!empty($mcm) && !empty($nm) && !empty($mcp)){
				$scan_all = $conn->prepare("SELECT * FROM users WHERE email = ?");
				$scan_all->execute(array($row['email']));
				$compare = $scan_all->fetch(PDO::FETCH_ASSOC);
				$scan_all = $conn->prepare("SELECT * FROM users WHERE email = ?");
				$scan_all->execute(array($nm));
				$run = $scan_all->fetch(PDO::FETCH_ASSOC);
				if ($mcm != $_SESSION['logged_in']) {
					echo 'Incorrect email';
				}
				else if (!(password_verify($mcp, $row['encrypt']))) {
					echo 'Incorrect password';
				}
				else if ($nm == $run['email']) {
					echo 'Email already taken';
				}
				else {
					$token = md5($mcp);
					$update_email = $conn->prepare("UPDATE users SET email = ?, verified = 0, token = ? WHERE email = ?");
					$update_email->execute(array($nm, $token, $mcm));
					$test_email = $conn->prepare("SELECT email FROM users WHERE email = ?");
					$test_email->execute(array($nm));
					$print_email = $test_email->fetch(PDO::FETCH_ASSOC);
					if ($print_email['email'] == $nm) {
						echo 'Email successfully updated'."<br>".'A new verification email has been sent to you.'."<br>".'Please verify your account and login again.';
						$msg = 'Please click the following link to re-activate your account: http://localhost:8080/Camagru/verify_update.php?email='.$nm.'&token='.$token;
						mail($nm, 'Re-activate Account', $msg);
						if (isset($_SESSION['logged_in']) && !(empty($_SESSION['logged_in']))) {
							session_unset();
							session_destroy();
						}
						?>
							<button><a href="login.php">Login</a></button>
						<?php
					}
				}
			}
		}
	?>
	<form class="notifications" action="" method="post">
		<h2>Notifications</h2>
		<!-- <button type="submit" name="on">On</button>
		<br>
		<br>
		<button type="submit" name="off">Off</button> -->
		<label class="switch">
			<input type="checkbox">
			<span class="slider"></span>
		</label>
	</form>
	<?php
	var_dump($users['email']);
		if (filter_has_var(INPUT_POST, 'on')) {
			// $check_on = $conn->prepare("SELECT * FROM users WHERE");
		}
		if (filter_has_var(INPUT_POST, 'off')) {

		}
	?>
</body>
</html>

<?php include('footer.php');?>