<?php
	require('config/pdo_connection.php');

	if(!(isset($_SESSION['logged_in']))) {
		die ('You are not logged in');
	}
	try {
		var_dump ($_POST);
		$upload_dir = "saved/";
		$file = $upload_dir . basename($_FILES["img_up"]["name"]);
		$yes = 1;
		$imgName = $_FILES["img_up"]["name"];
		$type = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		move_uploaded_file($_FILES["img_up"]["tmp_name"], $file);

		$stmt = $conn->prepare("INSERT INTO images(`imagename`, `created`) VALUES(?, ?)");
		$stmt->execute(array($imgName, 1));
	}
	catch (PDOException $e) {
		echo 'No you'."<br>".$e->getMessage();
	}
?>