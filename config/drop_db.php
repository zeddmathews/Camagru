<?php
	require('config/database.php');
	require('config/pdo_connection.php');

	$ditch = "DROP DATABASE IF EXISTS $DB_NAME";
	$conn->exec($ditch);
	echo 'Kay byyyyeee';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
	<button><a href ="setup.php">Setup</a></button>
</body>
</html>