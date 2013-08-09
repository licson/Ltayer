
var photoButton = document.getElementById('snapPicture');
photoButton.addEventListener('click', picCapture, false);

navigator.getUserMedia ||
	(navigator.getUserMedia = navigator.mozGetUserMedia ||
	navigator.webkitGetUserMedia || navigator.msGetUserMedia);
	
if (navigator.getUserMedia){
		navigator.getUserMedia({video:true,audio:false}, onSuccess, onError);
	}else{
		alert('您的瀏覽器不支援此功能');
}

function onSuccess(stream){
	vidContainer = document.getElementById('webcam');
	var vidStream;
	
	if (window.webkitURL){
			vidStream = window.webkitURL.createObjectURL(stream);
		}else{
		vidStream = stream;
	}
	
	vidContainer.autoplay = true;
	vidContainer.src = vidStream;
}

function onError(){
	alert('Webcam連線發生錯誤');
}

function picCapture(){
	var picture = document.getElementById('capture'),
		context = picture.getContext('2d');
	
		
	picture.width = "800";
	picture.height = "600";
	
	context.drawImage(vidContainer, 0, 0, picture.width, picture.height);
	var dataURL = picture.toDataURL();
	document.getElementById('canvasImg').src = dataURL;
}





