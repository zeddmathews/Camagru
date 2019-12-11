function notif() {
	var noti = document.getElementById('notifications');

	var switchState = new XMLHttpRequest();

	switchState.open('POST', 'profile.php');
	switchState.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	switchState.onload = function() { 
		noti.value = 1;
		console.log(switchState.responseText)
	}
	switchState.send('switchstate='+true);
}