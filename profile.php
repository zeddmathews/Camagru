<?php include('header.php');?>

<?php
	require('config/pdo_connection.php');
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		header("Location: login.php");
	}
	$mail = $_SESSION['logged_in'];
	$stmt = $conn->prepare("SELECT username FROM users WHERE email = ?");
	$stmt->execute(array($mail));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	echo $row['username'];

	if (filter_has_var(INPUT_POST, 'Update')) {
		$cur_user = trim(htmlspecialchars($_POST['current_user']));
		$cur_email = trim(htmlspecialchars($_POST['current_email']));
		$cur_pass = trim(htmlspecialchars($_POST['current_password']));
		$new_user = trim(htmlspecialchars($_POST['new_user']));
		$new_email = trim(htmlspecialchars($_POST['new_email']));
		$new_pass = trim(htmlspecialchars($_POST['new_password']));

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
				$scan_all = $conn->prepare("SELECT * FROM users WHERE (username = ?, email = ?)");
				$scan_all->execute(array($row['username'], $row['email']));
				$compare = $scan_all->fetch(PDO::FETCH_ASSOC);
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
	<form class="update-info" action="" method="post">
		<h3>Update your information</h3>
		<br>
		<input type="text" name="current_user" placeholder="Username" required>
		<br>
		<input type="email" name="current_email" placeholder="Email" required>
		<br>
		<input type="password" name="current_password" placeholder="Password" required>
		<br>
		<input type="text" name="new_user" placeholder="New Username" required>
		<br>
		<input type="email" name="new_email" placeholder="New Email" required>
		<br>
		<input type="password" name="new_password" placeholder="New Password" required>
		<br>
		<button type="submit" name="Update">Update</button>
	</form>
</body>
</html>

<?php include('footer.php');?>