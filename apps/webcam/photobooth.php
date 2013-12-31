<?php require_once('../../core/require.php'); ?>
<html>
	<head>
		<title>照相機</title>
		<meta charset="utf-8" />
    	<style>
    	#container {
            margin: 0 auto;
            width: 90%;
        }
        
        canvas#capture {
			width: 50%;
			box-shadow: #555 0 0 5px;
			-webkit-box-shadow: #555 0 0 5px;
			-moz-box-shadow: #555 0 0 5px;
        }
        
    	#webcam {
			width: 49%;
            background-color: #000;
			box-shadow: #555 0 0 5px;
			-webkit-box-shadow: #555 0 0 5px;
			-moz-box-shadow: #555 0 0 5px;
    	}
		
		#videoarea {
			border-bottom: #ccc 1px solid;
			padding-bottom: 1em;
			margin-bottom: 1em;
		}
		
		button, input[type=button] {
			background: #ccc;
		}
    	</style>
	</head>
	
	<body>
		<div id="container">
			<div id="videoarea">
			    <video id="webcam"></video>
				<canvas id="capture"></canvas>
		    </div>
		    <input type="button" id="snapPicture" value="喀嚓，笑一個！" />
		    <input type="button" id="save" value="儲存到雲端硬碟" />
		</div>
		<script src="script_photo.js"></script>
	</body>
</html>