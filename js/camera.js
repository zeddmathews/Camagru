// var canvas;
// var ctx;
// var stickercanvas;

window.addEventListener("load", () => {
	var video = document.querySelector("#video");
	
	var canvas = document.createElement('canvas');
	var display = document.getElementById('display_canvas');
	var ctx = canvas.getContext('2d');
	
	var capture = document.getElementById('capture');
	
	var sticksCanvas = document.createElement('canvas');
	var sticker_display = document.getElementById('sticks_canvas');
	var onestick = document.getElementById('1stick');
	var twostick = document.getElementById('2stick');
	var threestick = document.getElementById('3stick');
	var fourstick = document.getElementById('4stick');
	var sticksctx = sticksCanvas.getContext('2d');

	var saveMerge = document.getElementById('save');

	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia ({video: true,audio: false}
			).then( function(localMediaStream) {
				video.srcObject = localMediaStream;
			}).catch( function(err) {
				console.log("The following error occured: " + err);
			}
			);
		}
		else {
			console.log("getUserMedia not supported");
		}
		capture.addEventListener("click", () => {
			canvas.height = video.offsetHeight;
			canvas.width = video.offsetWidth;
			sticksCanvas.height = canvas.height;
			sticksCanvas.width = canvas.width;

			display.style.display = 'block';
			sticker_display.style.display = 'block';
			ctx.drawImage(video, 0, 0, canvas.height, canvas.width);
			display.src = canvas.toDataURL();
			sticker_display.src = sticksCanvas.toDataURL();
			video.style.display = "none"
		});
		onestick.addEventListener("click", () => {
			sticksctx.drawImage(onestick, 0, 0, 100, 75);
			sticker_display.src = sticksCanvas.toDataURL();
		});
		twostick.addEventListener("click", () => {
			sticksctx.drawImage(twostick, 75, 75, 100, 50);
			sticker_display.src = sticksCanvas.toDataURL();
		});
		threestick.addEventListener("click", () => {
			sticksctx.drawImage(threestick, 150, 150, 100, 50);
			sticker_display.src = sticksCanvas.toDataURL();
		});
		fourstick.addEventListener("click", () => {
			sticksctx.drawImage(fourstick, 225, 225, 50, 50);
			sticker_display.src = sticksCanvas.toDataURL();
		});
		saveMerge.addEventListener("click", () => {
			let xhr = new XMLHttpRequest();
			xhr.open('POST', 'upload_image.php');
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.send("make_img=" + encodeURIComponent(canvas.toDataURL().replace("data:image/png;base64,", ""))+"&make_sticks=" + encodeURIComponent(sticksCanvas.toDataURL().replace("data:image/png;base64,", "")));
		});
	
});