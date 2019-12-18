var load_id = 1;
loadMore = () => {
	var index = document.getElementById('gallery');
	var notNotIndex = document.getElementById('personal_gallery');
	if (index) {
		var xhr = new XMLHttpRequest();
		xhr.onload = () => {
			if (xhr.status === 200) {
				load_id++;
				index.innerHTML += xhr.responseText;
			}
		}
		xhr.open('POST', 'scroll.php?load_id='+load_id);
		xhr.send();
	}
	if (notNotIndex) {
		var req = new XMLHttpRequest();
		req.onload = () => {
			if (req.status === 200) {
				load_id++;
				notNotIndex.innerHTML += req.responseText;
			}
		}
		req.open('POST', 'pg_scroll.php?load_id='+load_id);
		req.send();
	}
};

infiniteScroll = () => {
	var notIndex = document.getElementById('gallery');
	var stillNotIndex = document.getElementById('personal_gallery');
	if (notIndex) {
		var contentHeight = notIndex.offsetHeight;
		var y = window.pageYOffset + window.innerHeight;
		if (y >= contentHeight)
			loadMore();
	}
	if (stillNotIndex) {
			var contentHeight = stillNotIndex.offsetHeight;
			var y = window.pageYOffset + window.innerHeight;
			if (y >= contentHeight)
			loadMore();
		}
	};
window.addEventListener("load", () => {
	loadMore()
});
window.onscroll = infiniteScroll;