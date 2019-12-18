<?php include('header.php')?>
<?php
	try {
		$token = $_GET['token'];
		$stmt = $conn->prepare("SELECT verified FROM users WHERE token = ?");
		$stmt->execute(array($token));
		$comp = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($comp['verified'] == 1) {
			echo 'Already verified';
			?>
			<a href="login.php">Login</a>
			<?php
			exit ;
		}
		else {
			$update = $conn->prepare("UPDATE users SET verified = 1, notifications = 1 WHERE token = :token");
			$update->bindParam(':token', $token);
			$update->execute();
			$stmt = $conn->prepare("SELECT verified FROM users WHERE token = ?");
			$stmt->execute(array($token));
			$test = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($test['verified'] == "1") {
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
<?php include('footer.php')?>