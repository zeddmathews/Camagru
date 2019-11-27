var webcamStream;

function startCam() {
	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia ({video: true,audio: false}
		).then( function(localMediaStream) {
			var video = document.querySelector("#video");
			video.srcObject = localMediaStream;
		}).catch( function(err) {
				console.log("The following error occured: " + err);
			}
		);
	}
	else {
	console.log("getUserMedia not supported");
	}
}

// Try this shit later ->

// // window.addEventListener("load", startCam);

// $.ajax("urlthaticameupwith.com", {info: thoy}).then((res) => {

// }).catch ((err) => {

// })

// var req = new XMLHttpRequest();
// req.addEventListener("load", () => {
// 	console.log(req.responseText);
// })
// req.open("GET", "urlthatilike.com");
// req.setRequestHeader("Content-Type", "application/JSON");

// req.send("{info: stuff}");

function stopCam() {
	// navigator.mediaDevices.getUserMedia ({video: false})
	video.srcObject = null;
}

var canvas;
var ctx;

function init() {
	canvas = document.getElementById("myCanvas");
	ctx = canvas.getContext('2d');
}

function takeSnap() {
	ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
}

function saveSnap() {
	var data = document.getElementById("myCanvas");
	document.getElementById("image").src = document.getElementById("myCanvas").toDataURL('image/png');
	let xhr = new XMLHttpRequest();
	xhr.addEventListener("load", () => {
		console.log(xhr.responseText);
	});
	xhr.open('POST', 'upload_image.php');
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send("gobble=" + encodeURIComponent(data.toDataURL().replace("data:image/png;base64,", "")));
	console.log(data);
}