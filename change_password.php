<?php include('header.php')?>
<?php
	require('config/pdo_connection.php');

	if(filter_has_var(INPUT_POST, 'verify')) {
		$verify = trim(htmlspecialchars($_POST['Verify']));
		try {
			$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
			$stmt->execute(array($verify));
			$fetch = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($fetch['email'] == $verify) {
				echo 'no yoooouuuu';
			}
			else {
				echo 'rip';
			}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="css/camagru.css">
</head>
<body>
	<form>
		<input type="email" name="Verify" placeholder="Verify your email" required>
		<br>
		<button type="submit" name="verify">Verify</button>
	</form>
</body>
</html>
<?php include('footer.php')?>