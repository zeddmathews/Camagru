<?php
	session_start();
	session_unset();
	session_destroy();
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		echo 'You have successfully logged out';
		header("Location: index.php");
	}
?>