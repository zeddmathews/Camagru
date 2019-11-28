<?php include('header.php');?>

<?php
	require('config/pdo_connection.php');
	$mail = $_SESSION['logged_in'];
	$stmt = $conn->prepare("SELECT username FROM users WHERE email = ?");
	$stmt->execute(array($mail));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	echo $row['username'];
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
	<button onclick=""></button>
</body>
</html>

<?php include('footer.php');?>