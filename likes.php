<?php include('header.php')?>
<?php
	require('config/pdo_connection');

	try {
		
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>
<?php include('footer.php')?>