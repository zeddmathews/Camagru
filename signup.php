<?php include('header.php')?>
<h1>Signup</h1>
<?php include('footer.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Signup</title>
</head>
<body>
	<form class="register-form" action="../../dev/register.php" method="post">
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

<?php
require('config/pdo_connection.php');

$password1 = trim(htmlspecialchars($_POST['password_1']));
$password2 = trim(htmlspecialchars($_POST['password_2']));
$lemail = trim(htmlspecialchars($_POST['email']));
$firsty = trim(htmlspecialchars($_POST['firstname']));
$lasty = trim(htmlspecialchars($_POST['lastname']));
$usery = trim(htmlspecialchars($_POST['username']));

// $upp = preg_match('@[A-Z]@', $password1);
// $low = preg_match('@[a-z]@', $password1);
// $num = preg_match('@[0-9]@', $password1);
// $spec = preg_match('@[^\w]@', $password1);

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
// if (strlen($password1) < 8) {
// 	echo 'Password too short<br>';
// }
// if (!$upp || !$low || !$num || !$spec || strlen($password1) < 8) {
// 	echo 'Password shoulbe be at least 8 characters in length and should include
// 	at least one upper case letter, one lower case letter, one number, and one special character.<br>';
// }
// else {
// 	echo 'Meh password<br>';
// }
if ($password1 != $password2) {
	echo 'Passwords do not match<br>';
}
// try {
// 	// Matching user to avoid duplicates
// }
// catch (PDOException $e){
// 	echo 'You dun fucked up:'. $e->getMessage();
// }
if ($password1 == $password2) {
	try {
		$encrypt = password_hash($password1, PASSWORD_BCRYPT);
		$token = md5($_POST['username']);
		$sql = "INSERT INTO users(firstname, lastname, username, email, encrypt, verified, notifications, token)
		VALUES (:firsty, :lasty, :usery, :lemail, :encrypt, false, false, :token)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':firsty', $firsty);
		$stmt->bindParam(':lasty', $lasty);
		$stmt->bindParam(':usery', $usery);
		$stmt->bindParam(':lemail', $lemail);
		$stmt->bindParam(':encrypt', $encrypt);
		$stmt->bindParam(':token', $token);
		$msg = 'Please click the following link to activate your account: http://localhost:8080/kay/dud/dev/verify.php?email='.$lemail.'&token='.$token;
		mail($lemail, 'Confirmation', $msg);
		echo "<br> An email with a verification link has been sent to you.";
		$stmt->execute();
	}
	catch (PDOException $e){
		echo $sql ."<br>". $e->getMessage();
	}
}
else {
	echo 'Can shit just function?';
}
header("Location: ../user/php/verify.php");
$conn = null;
?>
