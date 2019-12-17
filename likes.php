<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	require('config/pdo_connection.php');

	$id = $_POST['pid'];
		$user_id = $conn->prepare("SELECT * FROM users WHERE username = ?");
		$user_id->execute(array($_SESSION['user']));
		$uid = $user_id->fetch(PDO::FETCH_ASSOC);
		$statement = $conn->prepare("SELECT * FROM `likes` WHERE `post_id` = ? AND `user_id` = ?");
		$statement->execute(array($id, $uid['id']));
		$isLike = $statement->fetch(PDO::FETCH_ASSOC);

		$insert_like = $conn->prepare("INSERT INTO likes(`user_id`, `post_id`, `username`) VALUES(?, ?, ?)");
		if (!$isLike) {
			$insert_like->execute(array($uid['id'], $id, $_SESSION['user']));
			http_response_code(200);
		}
		else 
		{
			http_response_code(205);
			$delete = $conn->prepare("DELETE FROM `likes` WHERE `post_id` = ? AND `user_id` = ?");
			$delete->execute(array($id, $uid['id']));
		}
?>