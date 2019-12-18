<?php
	if (session_status() == PHP_SESSION_NONE) {
	session_start();
	}
	if (isset($_SESSION['logged_in']) && !(empty($_SESSION['logged_in']))) {
		session_unset();
		session_destroy();
	}
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		header("Location: change_password.php");
	}
?>