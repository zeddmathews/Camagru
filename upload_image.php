<?php
	require('config/pdo_connection.php');
	session_start();
	if(!(isset($_SESSION['logged_in']))) {
		die ('You are not logged in');
	}
	try {
		$img = $_POST['make_img'];
		$img = base64_decode($img);
		$img = imagecreatefromstring($img);
		$file_name = rand(1000000, 9999999);
		$check_exists = $conn->prepare("SELECT * FROM images WHERE imagename = ?");
		$check_exists->execute(array($file_name . ".png"));
		while ($check_exists->rowCount())
		{
			$file_name .= "-";
			$check_exists->execute(array($file_name . ".png"));
		}
		$file_name .= ".png";
		imagepng($img, "image/" . $file_name);
		// var_dump ($_POST);
		// $upload_dir = "saved/";
		// $file = $upload_dir . basename($_FILES["img_up"]["name"]);
		// $yes = 1;
		// $imgName = $_FILES["img_up"]["name"];
		// $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		// move_uploaded_file($_FILES["img_up"]["tmp_name"], $file);

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