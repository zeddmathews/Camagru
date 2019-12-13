<?php include('header.php');?>
<?php 
	if (!isset($_SESSION['created'])) {
		header("Location: config/setup.php");	
	}
?>
<div id="gallery">
</div>
<?php include('footer.php');?>