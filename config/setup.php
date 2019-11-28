
<?php
	session_start();
	require('database.php');

	// Build DB
	try {
		$sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->exec($sql);
		echo "Shit functions<br>";
	}
	catch (PDOException $e){
		echo $sql ."<br>". $e->getMessage();
	}

	require('pdo_connection.php');

	// Build Table 'Users'
	try {
		$sql = "CREATE TABLE IF NOT EXISTS users (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			firstname VARCHAR(100) NOT NULL,
			lastname VARCHAR(100) NOT NULL,
			username VARCHAR(100) NOT NULL UNIQUE,
			email VARCHAR(100) NOT NULL UNIQUE,
			encrypt VARCHAR(200) NOT NULL,
			verified BOOLEAN NOT NULL,
			notifications BOOLEAN NOT NULL,
			token VARCHAR(100) NOT NULL UNIQUE
		)";
		$conn->exec($sql);
		echo "More shit functions<br>";
	}
	catch (PDOException $e){
		echo $sql ."<br>". $e->getMessage();
	}

	// // Create default user
	// try {
	// 	$password = 'ftg150Fu#';
	// 	$lemail = 'mathewszain@gmail.com';
	// 	$firsty = 'Zain';
	// 	$lasty = 'Mathews';
	// 	$usery = 'Gandaft';
	// 	$token = md5($usery);
	// 	$encrypt = password_hash($password, PASSWORD_BCRYPT);
	// 	$sql = "INSERT INTO users(firstname, lastname, username, email, encrypt, verified, notifications, token)
	// 	VALUES (:firsty, :lasty, :usery, :lemail, :encrypt, 1, 1, :token)";
	// 	$stmt = $conn->prepare($sql);
	// 	$stmt->bindParam(':firsty', $firsty);
	// 	$stmt->bindParam(':lasty', $lasty);
	// 	$stmt->bindParam(':usery', $usery);
	// 	$stmt->bindParam(':lemail', $lemail);
	// 	$stmt->bindParam(':encrypt', $encrypt);
	// 	$stmt->bindParam(':token', $token);
	// 	$stmt->execute();
	// }
	// catch (PDOException $e){
	// 	echo $sql ."<br>". $e->getMessage();
	// }

	// Build table 'Images'
	try {
		$sql = "CREATE TABLE IF NOT EXISTS images (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			imagename VARCHAR(200) NOT NULL,
			username VARCHAR (100) NOT NULL,
			created VARCHAR(200) NOT NULL
		)";
		$conn->exec($sql);
		echo "Extremely functional shit";
	}
	catch (PDOException $e){
		echo $sql ."<br>". $e->getMessage();
	}
	header("Location: ../index.php");
	$conn = null;
?>