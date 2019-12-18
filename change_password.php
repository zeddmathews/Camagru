<?php include('header.php')?>
<?php
	if(filter_has_var(INPUT_POST, 'verify')) {
		$verify = trim(htmlentities($_POST['Verify']));
		try {
			$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
			$stmt->execute(array($verify));
			$fetch = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($fetch['verified'] == "0") {
				echo 'Verify your account';
			}
			else if ($fetch['email'] == $verify) {
				$token = md5($verify);
				$update = $conn->prepare("UPDATE users SET token = ? WHERE email = ?");
				$update->execute(array($token, $verify));
				$msg = 'Click the following link to reset your password: http://localhost:8080/Camagru/re-verify.php?email='.$verify.'&token='.$token;
				mail($verify, 'Reset password', $msg);
				echo 'An email with a reset link has been sent to you';
			}
			else {
				echo 'This account does not exist';
			}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
?>
<form class="change-form" action="" method="post">
	<input type="email" name="Verify" placeholder="Verify your email" required>
	<br>
	<button type="submit" name="verify">Verify</button>
</form>
<?php include('footer.php')?>