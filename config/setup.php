
<?php
	session_start();
	require('database.php');

	// Build DB
	try {
		$sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->exec($sql);
		$_SESSION['created'] = 'created database';
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

	// Create default users
	try {
		$password = 'noyou';
		$lemail = 'iam@groot.com';
		$firsty = 'I';
		$lasty = 'Am';
		$usery = 'Groot';
		$token = md5($usery);
		$encrypt = password_hash($password, PASSWORD_BCRYPT);
		$sql = "INSERT INTO users(firstname, lastname, username, email, encrypt, verified, notifications, token)
		VALUES (:firsty, :lasty, :usery, :lemail, :encrypt, 1, 1, :token)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':firsty', $firsty);
		$stmt->bindParam(':lasty', $lasty);
		$stmt->bindParam(':usery', $usery);
		$stmt->bindParam(':lemail', $lemail);
		$stmt->bindParam(':encrypt', $encrypt);
		$stmt->bindParam(':token', $token);
		$stmt->execute();
	}
	catch (PDOException $e){
		echo $sql ."<br>". $e->getMessage();
	}
	try {
		$password = 'begone';
		$lemail = 'pika@chu.com';
		$firsty = 'Pika';
		$lasty = 'Pi';
		$usery = 'Pichu';
		$token = md5($usery);
		$encrypt = password_hash($password, PASSWORD_BCRYPT);
		$sql = "INSERT INTO users(firstname, lastname, username, email, encrypt, verified, notifications, token)
		VALUES (:firsty, :lasty, :usery, :lemail, :encrypt, 1, 1, :token)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':firsty', $firsty);
		$stmt->bindParam(':lasty', $lasty);
		$stmt->bindParam(':usery', $usery);
		$stmt->bindParam(':lemail', $lemail);
		$stmt->bindParam(':encrypt', $encrypt);
		$stmt->bindParam(':token', $token);
		$stmt->execute();
	}
	catch (PDOException $e){
		echo $sql ."<br>". $e->getMessage();
	}
	try {
		$password = 'default';
		$lemail = 'nub@noob.com';
		$firsty = 'Nubly';
		$lasty = 'Noob';
		$usery = 'Default';
		$token = md5($usery);
		$encrypt = password_hash($password, PASSWORD_BCRYPT);
		$sql = "INSERT INTO users(firstname, lastname, username, email, encrypt, verified, notifications, token)
		VALUES (:firsty, :lasty, :usery, :lemail, :encrypt, 1, 1, :token)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':firsty', $firsty);
		$stmt->bindParam(':lasty', $lasty);
		$stmt->bindParam(':usery', $usery);
		$stmt->bindParam(':lemail', $lemail);
		$stmt->bindParam(':encrypt', $encrypt);
		$stmt->bindParam(':token', $token);
		$stmt->execute();
	}
	catch (PDOException $e){
		echo $sql ."<br>". $e->getMessage();
	}

	// Build table 'Images'
	try {
		$sql = "CREATE TABLE IF NOT EXISTS images (
			id INT(250) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			imagename VARCHAR(200) NOT NULL,
			username VARCHAR (100) NOT NULL,
			email VARCHAR(200) NOT NULL,
			created VARCHAR(200) NOT NULL
		)";
		$conn->exec($sql);
		echo "Extremely functional shit<br>";
		
	}
	catch (PDOException $e){
		echo $sql ."<br>". $e->getMessage();
	}

	// Build table 'Comments'
	try {
		$sql = "CREATE TABLE IF NOT EXISTS comments (
			id INT(250) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			postedby VARCHAR(200),
			commentedby VARCHAR(200)
		)";
		$conn->exec($sql);
		echo "Amazingly functional shit<br>";
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

	// Build table 'Likes'
	try {
		$sql = "CREATE TABLE IF NOT EXISTS likes (
			like_id INT AUTO_INCREMENT PRIMARY KEY,
			user_id INT NOT NULL,
			post_id INT NOT NULL,
			FOREIGN KEY (user_id) REFERENCES users(id),
			FOREIGN KEY (post_id) REFERENCES images(id)
		)";
		$conn->exec($sql);
		echo "Phenomenally functional shit<br>";
		header("Location: ../index.php");
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

	// Insert default images
	// try {
	// 	$stmt = $conn->prepare("INSERT INTO images(`imagename`, `username`, `created`) VALUES(?, ?, ?)");
	// 	$stmt->execute(array("feather.jpeg", Groot, 1));
	// 	$stmt = $conn->prepare("INSERT INTO images(`imagename`, `username`, `created`) VALUES(?, ?, ?)");
	// 	$stmt->execute(array("flowers.jpeg", Groot, 1));
	// 	$stmt = $conn->prepare("INSERT INTO images(`imagename`, `username`, `created`) VALUES(?, ?, ?)");
	// 	$stmt->execute(array("glow.jpeg", Groot, 1));
	// 	$stmt = $conn->prepare("INSERT INTO images(`imagename`, `username`, `created`) VALUES(?, ?, ?)");
	// 	$stmt->execute(array("rose.jpeg", Groot, 1));
	// 	$stmt = $conn->prepare("INSERT INTO images(`imagename`, `username`, `created`) VALUES(?, ?, ?)");
	// 	$stmt->execute(array("water.jpeg", Groot, 1));
	// }
	// catch(PDOException $e) {
	// 	echo $e->getMessage();
	// }
	$conn = null;
?>