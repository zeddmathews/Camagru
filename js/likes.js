function like(id)
{
	var request = new XMLHttpRequest();

	request.onload = function()
	{
		if (request.status === 200)
		{
			var likes = document.getElementById("num_likes-"+id);
			likes.innerHTML = 1 + Number(likes.innerHTML);
		}
		else if (request.status === 205)
		{
			var likes = document.getElementById("num_likes-"+id);
			likes.innerHTML = Number(likes.innerHTML) - 1;
		}
		else
			console.log(request.responseText);

	}
	request.open("POST", "likes.php");
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send("pid="+id);
}