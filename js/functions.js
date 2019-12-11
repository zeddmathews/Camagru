function notif() {
	document.getElementById('notif_form').submit();
	noti = document.getElementById('notifications');

	switchState = new XMLHttpRequest();

	switchState.open('POST', 'profile.php');
	switchState.onload = function() {
		alert(noti);
		noti.value = 1;
	}
	switchState.send('switchstate='+true);
}