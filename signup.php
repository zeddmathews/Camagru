<?php include('header.php')?>
<h2>Signup</h2>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Signup</title>
</head>
<body>
	<form class="signup-form" action="" method="post">
		<br>
		<input type="text" name="firstname" placeholder="Name" required>

		<br>

		<br>
		<input type="text" name="lastname" placeholder="Surname" required>

		<br>

		<br>
		<input type="text" name="username" placeholder="Username" required>

		<br>

		<br>
		<input type="email" name="email" placeholder="E-mail" required>

		<br>

		<br>
		<input type="password" name="password_1" placeholder="Password" required>

		<br>

		<br>
		<input type="password" name="password_2" placeholder="Confirm password" required>

		<br>

		<button type="submit" name="Register">Register</button>

		<br>

		<label>Already have an account?</label>
		<button type="button"><a href="../../index.php">Login</a></button>
		<button type="button"><a href="./reset_account.php">Forgotten password?</a></button>
	</form>
</body>
</html>

<?php include('footer.php')?>

<?php
require('config/pdo_connection.php');
if ($_POST) {
	$pass1 = trim(htmlspecialchars($_POST['password_1']));
	$pass2 = trim(htmlspecialchars($_POST['password_2']));
	$mail = trim(htmlspecialchars($_POST['email']));
	$first = trim(htmlspecialchars($_POST['firstname']));
	$last = trim(htmlspecialchars($_POST['lastname']));
	$user = trim(htmlspecialchars($_POST['username']));

	// $upp = preg_match('@[A-Z]@', $pass1);
	// $low = preg_match('@[a-z]@', $pass1);
	// $num = preg_match('@[0-9]@', $pass1);
	// $spec = preg_match('@[^\w]@', $pass1);
	if(empty($first) || empty($last) || empty($user) || empty($mail) || empty($pass1) || empty($pass2)) {
		echo "<label>Please fill in all fields</label>";
		exit ;
	}

	// if (!$upp) {
	// 	echo 'No uppercase letters<br>';
	// }
	// if (!$low) {
	// 	echo 'No lowercase letters<br>';
	// }
	// if (!$num) {
	// 	echo 'No numbers<br>';
	// }
	// if (!$spec) {
	// 	echo 'No special characters<br>';
	// }
	// if (strlen($pass1) < 8) {
	// 	echo 'Password too short<br>';
	// }
	// if (!$upp || !$low || !$num || !$spec || strlen($pass1) < 8) {
	// 	echo 'Password shoulbe be at least 8 characters in length and should include
	// 	at least one upper case letter, one lower case letter, one number, and one special character.<br>';
	// 	exit ;
	// }
	// else {
	// 	echo 'Meh password<br>';
	// }
	if ($pass1 != $pass2) {
		echo 'Passwords do not match<br>';
		exit ;
	}
	// try {
	// 	// Matching user to avoid duplicates
	// }
	// catch (PDOException $e){
	// 	echo 'You dun fucked up:'. $e->getMessage();
	// }
	if ($pass1 == $pass2) {
		try {
			$encrypt = password_hash($pass1, PASSWORD_BCRYPT);
			$token = md5($_POST['username']);
			$match = $conn->prepare("SELECT * FROM users WHERE email = :mail");
			$match->bindParam(':mail', $mail);
			$match->execute();
			$cmp = $match->fetchAll();
			$match = $conn->prepare("SELECT * FROM users WHERE username = :user");
			$match->bindParam(':user', $user);
			$cmp2 = $match->fetchAll();
			if (sizeof($cmp) == 0 && sizeof($cmp2) == 0) {
				$sql = "INSERT INTO users(firstname, lastname, username, email, encrypt, verified, notifications, token)
				VALUES (:first, :last, :user, :mail, :encrypt, false, false, :token)";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':first', $first);
				$stmt->bindParam(':last', $last);
				$stmt->bindParam(':user', $user);
				$stmt->bindParam(':mail', $mail);
				$stmt->bindParam(':encrypt', $encrypt);
				$stmt->bindParam(':token', $token);
				$stmt->execute();
				$msg = 'Please click the following link to activate your account: http://localhost:8080/Camagru/verify.php?email='.$mail.'&token='.$token;
				mail($mail, 'Confirmation', $msg);
				echo "<br> An email with a verification link has been sent to you.";
				header("Location: verification_message.php");
			}
			else {
				echo 'Duplicate entries';
			}
			
		}
		catch (PDOException $e){
			echo $sql ."<br>". $e->getMessage();
		}
	}
	else {
		echo 'Can shit just function?';
		exit ;
	}
}
$conn = null;
?>
