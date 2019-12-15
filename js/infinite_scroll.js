var load_id = 1;
window.addEventListener("load", () => {
	loadMore()
});

loadMore = () => {
	var index = document.getElementById('gallery');
	var xhr = new XMLHttpRequest();
	if (index) {
		console.log('oi');
		// xhr.onload = () => {
			console.log(xhr.responseText);
		if (xhr.status == 200) {
			load_id++;
		}
		xhr.open('POST', '/Camagru/scroll.php?load_id='+load_id);
		xhr.send();
		// }
	}
};