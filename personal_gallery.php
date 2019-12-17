<?php include('header.php')?>
<script src="js/infinite_scroll.js"></script>
<?php
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		header("Location: login.php");
	}
?>
<div id="personal_gallery">
</div>
<?php include('footer.php')?>