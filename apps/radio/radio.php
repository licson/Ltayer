<?php
$address=$_POST["address"];
?>
<button id="play">播放</button>
<script>
var audio = new Audio();
audio.src = '<?php echo $address;?>;';
audio.play();

var button = document.getElementById('play');
var pause = false;

button.addEventListener('click',function(e){
	e.preventDefault();
	pause = !pause;
	
	if(pause){
		button.textContent = "播放";
		audio.pause();
	}
	else {
		button.textContent = "暫停";
		audio.play();
	}
},false);
</script>