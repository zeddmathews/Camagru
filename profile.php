<?php include('header.php');?>

<?php
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		header("Location: login.php");
	}
	$mail = $_SESSION['logged_in'];
	$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
	$stmt->execute(array($mail));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	echo $row['username']."<br>";
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
			$ucu = trim(htmlentities($_POST['user_curr_user']));
			$ucp = trim(htmlentities($_POST['user_curr_pass']));
			$nu = trim(htmlentities($_POST['new_user']));
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
			$mcm = trim(htmlentities($_POST['mail_curr_mail']));
			$nm = trim(htmlentities($_POST['new_mail']));
			$mcp = trim(htmlentities($_POST['mail_curr_pass']));
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
	<?php
	try {
		$sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
		$sql->execute(array($mail));
		$get_notif = $sql->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	if ($get_notif['notifications'] == 1) {
		$value = 1;
	}
	else if ($get_notif['notifications'] == 0) {
		$value = 0;
	}
	if (isset($_POST['switchstate'])) {
		if ($value == 1) {
			echo 'HEY!';
			$update_notifications = $conn->prepare("UPDATE users SET notifications = 0 WHERE email = ?");
			$update_notifications->execute(array($mail));
			$value = 0;
		}
		else if ($value == 0) {
			echo 'YOU!';
			$update_notifications = $conn->prepare("UPDATE users SET notifications = 1 WHERE email = ?");
			$update_notifications->execute(array($mail));
			$value = 1;
		}
		die();
	}
	?>
		<h2>Notifications</h2>
		<label class="switch">
			<input type="checkbox" id="notifications" onclick="notif();" <?php if ($value == 1) {echo "checked";} ?>>
			<span class="slider"></span>
		</label>
		<br>
		<br>
	<button><a href="force_logout.php">Reset Password</a></button>
	<?php
	?>
</body>
</html>

<?php include('footer.php');?>