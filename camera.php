<?php include('header.php');?>
<?php
	if (!(isset($_SESSION['logged_in'])) && empty($_SESSION['logged_in'])) {
		header("Location: login.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="js/camera.js"></script>
	<title>Feed</title>
</head>
<body>
	<h3>Add/Take pictures</h3>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="img_up" id="img_up">
		<input type="submit" name="submit" value="Upload Image">
	</form>
	<button id="capture">Capture</button>
	<button id="save">Save</button>
	<div class="camera">
		<video autoplay = true id="video"></video>
		<div class="overlap">
			<img id="display_canvas">
			<img id="sticks_canvas">
		</div>
		<img src="" id="image"/>
	</div>
	<div class="stickers">
		<img class="sticks" id="1stick" src="image/stickers/pissed_off_gandaft.png">
		<img class="sticks" id="2stick" src="image/stickers/bilbo.png">
		<img class="sticks" id="3stick" src="image/stickers/legolas.png">
		<img class="sticks" id="4stick" src="image/stickers/gimli.png">
	</div>
</body>
</html>
<?php include('footer.php');?>