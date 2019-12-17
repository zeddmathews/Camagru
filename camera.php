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
	<script src="js/show_stickers.js"></script>
	<title>Feed</title>
</head>
<body>
	<h3>Add/Take pictures</h3>
	<div class="sc">
	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="ploadmage" id="ploadmage">
		<button name="ploadbtn" id="ploadbtn">Upload</button>
	</form>
	</div>
	<div class="sc">
		<button id="capture" onclick="showStickers();">Capture</button>
		<button id="save">Save</button>
	</div>
	<div class="camera">
		<video autoplay = true id="video"></video>
		<div class="overlap">
			<img id="display_canvas">
			<img id="sticks_canvas">
		</div>
		<img src="" id="image"/>
	</div>
	<div class="stickers" id="stickers">
		<img class="sticks" id="1stick" src="image/stickers/pissed_off_gandaft.png">
		<img class="sticks" id="2stick" src="image/stickers/bilbo.png">
		<img class="sticks" id="3stick" src="image/stickers/legolas.png">
		<img class="sticks" id="4stick" src="image/stickers/gimli.png">
	</div>
</body>
</html>
<?php include('footer.php');?>