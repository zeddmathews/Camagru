<?php
	session_start();
	require('config/pdo_connection.php');

	try {
		$token = $_GET['token'];
		$stmt = $conn->prepare("SELECT verified FROM users WHERE token = ?");
		$stmt->execute(array($token));
		if ($stmt->fetchColumn() === 1) {
			echo 'Already verified';
			exit ;
		}
		else {
			$update = $conn->prepare("UPDATE users SET verified = 1 WHERE token = :token");
			$update->bindParam(':token', $token);
			$update->execute();
			$stmt = $conn->prepare("SELECT verified FROM users WHERE token = ?");
			$stmt->execute(array($token));
			if ($stmt->fetchColumn() === "1") {
				header("Location: login.php");
			}
			else {
				echo 'You done fucked up';
			}
		}
	}
	catch(PDOException $e) {
		echo 'Well done'."<br>".'You caused this shit:'.$e->getMessage();
	}
?>