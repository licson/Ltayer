var photoButton = document.getElementById('snapPicture');
var saveButton = document.getElementById('save');
var vidContainer = document.getElementById('webcam');
var picture = document.getElementById('capture');

photoButton.addEventListener('click', picCapture, false);
saveButton.addEventListener('click', save, false);

navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
var URL = window.URL || window.webkitURL;
	
if (navigator.getUserMedia){
	navigator.getUserMedia({ video:true }, onSuccess, onError);
}
else {
	alert('您的瀏覽器不支援此功能');
}

function onSuccess(stream){
	var vidStream;
	
	if (URL){
		vidStream = URL.createObjectURL(stream);
	}
	else {
		vidStream = stream;
	}
	
	vidContainer.autoplay = true;
	vidContainer.src = vidStream;
	vidContainer.addEventListener('loadedmetadata', function(){
        picture.width = vidContainer.videoWidth; 
        picture.height = vidContainer.videoHeight; 
	});
	
}

function onError(){
	alert('Webcam連線發生錯誤');
}

function picCapture(){
	var context = picture.getContext('2d');
	
	context.drawImage(vidContainer, 0, 0, picture.width, picture.height);
}

function save(){
	var data = escape(picture.toDataURL('image/png').split(',')[1]);
	var xhr = new XMLHttpRequest();
	
	xhr.onreadystatechange = function(){
		if(xhr.status === 200 && xhr.readyState == 4){
			alert("儲存完成!");
		}
	};
	
	xhr.open("POST", "./save.php", true);
	xhr.send(data);
}