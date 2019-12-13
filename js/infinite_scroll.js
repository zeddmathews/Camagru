var load_id = 1;
window.addEventListener("load", () => {
	loadMore()
});

loadMore = () => {
	var index = document.getElementById('gallery');
	var xhr = new XMLHttpRequest();
	console.log('oi');
	if (index) {
		xhr.onload = () => {
		if (xhr.status == 200) {
			load_id++;
		}
		xhr.open('POST', '/Camagru/scroll.php?load_id='+load_id);
		xhr.send();
		}
	}
};