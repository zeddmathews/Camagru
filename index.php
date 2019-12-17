<?php include('header.php');?>
<script src="js/infinite_scroll.js"></script>
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