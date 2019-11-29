<?php include('header.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel ="stylesheet" href="css/camagru.css">
	<script src="js/camera.js"></script>
	<title>Feed</title>
</head>
<body onload="init();">
	<h3>Display (preferably) pretty shit</h3>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="img_up" id="img_up">
		<input type="submit" name="submit" value="Upload Image">
	</form>
	<button onclick="startCam();">Camera</button>
	<button onclick="stopCam();">Off</button>
	<button onclick="takeSnap();">Capture</button>
	<button onclick="saveSnap();">Save</button>
	<video autoplay = true id="video"></video>
	<canvas id="myCanvas" width="300" height="300"></canvas>
	<img src="" id="image"/>

</body>
</html>
<?php include('footer.php');?>