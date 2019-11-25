<?php include('header.php')?>
<h1>Signup</h1>

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
		<label>Name</label>
		<br>
		<input type="text" name="firstname" required>

		<br>

		<label>Surname</label>
		<br>
		<input type="text" name="lastname" required>

		<br>

		<label>Username</label>
		<br>
		<input type="text" name="username" required>

		<br>

		<label>E-mail</label>
		<br>
		<input type="email" name="email" required>

		<br>

		<label>Password</label>
		<br>
		<input type="password" name="password_1" required>

		<br>

		<label>Confirm password</label>
		<br>
		<input type="password" name="password_2" required>

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
		$sql = "INSERT INTO users(firstname, lastname, username, email, encrypt, verified, notifications, token)
		VALUES (:first, :last, :user, :mail, :encrypt, false, false, :token)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':first', $first);
		$stmt->bindParam(':last', $last);
		$stmt->bindParam(':user', $user);
		$stmt->bindParam(':mail', $mail);
		$stmt->bindParam(':encrypt', $encrypt);
		$stmt->bindParam(':token', $token);
		$msg = 'Please click the following link to activate your account: http://localhost:8080/kay/dud/dev/verify.php?email='.$mail.'&token='.$token;
		mail($mail, 'Confirmation', $msg);
		echo "<br> An email with a verification link has been sent to you.";
		$stmt->execute();
		header("Location: ../user/php/verify.php");
	}
	catch (PDOException $e){
		echo $sql ."<br>". $e->getMessage();
	}
}
else {
	echo 'Can shit just function?';
	exit ;
}

$conn = null;
?>