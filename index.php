<?php include('header.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="js/infinite_scroll.js"></script>
	<title>Document</title>
</head>
<body>
	
</body>
</html>
<?php 
	if (!isset($_SESSION['created'])) {
		header("Location: config/setup.php");	
	}
	if (isset($_SESSION['logged_in']) && !(empty($_SESSION['logged_in']))) {
		try {
			$query = $conn->prepare("SELECT * FROM users WHERE email = ?");
			$query->execute(array($_SESSION['logged_in']));
			$result = $query->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
?>
<h3>Welcome to Camagru<?php 
	if (isset($_SESSION['logged_in']) && !(empty($_SESSION['logged_in']))) {
		echo ' '.$result['username'];
	}
	?></h3>
<div id="gallery">
</div>
<?php include('footer.php');?>