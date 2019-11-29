<?php
	require('database.php');
	try {
	$conn = new PDO($DB_CON, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOExcpetion $e) {
		echo 'Error' .$e->getMessage();
	}
?>