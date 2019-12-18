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
	var div = document.getElementById('stickers');

	var ploadmage = document.getElementById('ploadmage');
	var ploadbtn = document.getElementById('ploadbtn');

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
	ploadmage.addEventListener("change", () => {
		if (ploadmage.files.length > 0) {
			console.log("JKBDF");
			var img = new Image();
			img.height = 400;
			img.width = 500;
			img.addEventListener('load', () => {
				canvas.height = img.height;
				canvas.width = img.width;
				sticksCanvas.height = canvas.height;
				sticksCanvas.width = canvas.width;

				ctx.drawImage(img, 0, 0 ,500 ,400);
				display.src = canvas.toDataURL();

				display.style.display = "block";
				video.style.display = "none";
				capture.style.display = "none";
				ploadmage.style.display = "none";
				ploadbtn.style.display = "block";
				sticker_display.style.display = "block";
				sticksCanvas.style.display = "block";
				div.style.display = "flex";	
			});
		}
		img.src = URL.createObjectURL(ploadmage.files[0])
	});
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
		sticksctx.drawImage(onestick, 0, 0, 100, 100);
		sticker_display.src = sticksCanvas.toDataURL();
	});
	twostick.addEventListener("click", () => {
		sticksctx.drawImage(twostick, 225, 0, 100, 100);
		sticker_display.src = sticksCanvas.toDataURL();
	});
	threestick.addEventListener("click", () => {
		sticksctx.drawImage(threestick, 0, 225, 100, 100);
		sticker_display.src = sticksCanvas.toDataURL();
	});
	fourstick.addEventListener("click", () => {
		sticksctx.drawImage(fourstick, 225, 225, 100, 100);
		sticker_display.src = sticksCanvas.toDataURL();
	});
	ploadbtn.addEventListener("click", () => {
		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'upload_image.php');
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.send("make_img=" + encodeURIComponent(canvas.toDataURL().replace("data:image/png;base64,", ""))+"&make_sticks=" + encodeURIComponent(sticksCanvas.toDataURL().replace("data:image/png;base64,", "")));
	});
	saveMerge.addEventListener("click", () => {
		let xhr = new XMLHttpRequest();
		xhr.open('POST', 'upload_image.php');
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.send("make_img=" + encodeURIComponent(canvas.toDataURL().replace("data:image/png;base64,", ""))+"&make_sticks=" + encodeURIComponent(sticksCanvas.toDataURL().replace("data:image/png;base64,", "")));
	});
	
});