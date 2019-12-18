<?php
	require('config/pdo_connection.php');
	session_start();
	if(!(isset($_SESSION['logged_in']))) {
		die ('You are not logged in');
	}
	try {
		$img = $_POST['make_img'];
		$sticks = $_POST['make_sticks'];
		$img = base64_decode($img);
		$img = imagecreatefromstring($img);
		$sticks = base64_decode($sticks);
		$sticks = imagecreatefromstring($sticks);
		$file_name = rand(1000000, 9999999);

		imagecopy($img, $sticks, 0, 0, 0, 0, 500, 500);

		$check_exists = $conn->prepare("SELECT * FROM images WHERE imagename = ?");
		$check_exists->execute(array($file_name . ".png"));
		while ($check_exists->rowCount())
		{
			$file_name .= "-";
			$check_exists->execute(array($file_name . ".png"));
		}
		$file_name .= ".png";
		imagepng($img, "image/" . $file_name);

		$fetch = $conn->prepare("SELECT * FROM users WHERE email = ?");
		$fetch->execute(array($_SESSION['logged_in']));
		$print = $fetch->fetch(PDO::FETCH_ASSOC);
		$stmt = $conn->prepare("INSERT INTO images(`imagename`, `username`, `email`, `created`) VALUES(?, ?, ?, ?)");
		$stmt->execute(array($file_name, $print['username'], $_SESSION['logged_in'], 1));
	}
	catch (PDOException $e) {
		echo 'No you'."<br>".$e->getMessage();
	}
?>