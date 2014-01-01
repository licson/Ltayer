<?php require_once('../../core/require.php'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>小畫家</title>
		<link rel="stylesheet" href="../../css/jquery-ui-1.10.3.custom.min.css" />
		<style>
			body {
				font-size: 9pt;
				margin: 0;
				padding: 0;
			}
			
			#line {
				clear: both;
			}
			
			#paintarea {
				position: fixed;
				top: 0;
				left: 0;
				z-index: -99;
			}
			
			#controls {
				position: fixed;
				width: auto;
				display: inline-block;
				padding: 1em;
				top: 1em;
				left: 1em;
			}
			
			.option {
				float: left;
				width: 20px;
				height: 20px;
				margin-right: 4px;
				margin-bottom: 4px;
				box-shadow: 0 0 4px #aaa;
			}
			
			.paint_controls {
			    background-color: #fff;
			    box-shadow: 0 0 15px #ccc;
			}
			
			.active {
				box-shadow: 0 0 4px #000;
			}
			
			#paint {
				cursor: arrow;
			}
		</style>
		<script src="../../js/jquery-1.9.1.js" type="text/javascript"></script>
		<script src="../../js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="../../js/jquery.ui.touch.min.js"></script>
		<script>
			$(function () {
				var p_width, p_color;
				var colors = ['#F00', '#0F0', '#00F', '#FF0', '#0FF', '#F0F', '#F90', '#FFF'];
				$.each(colors, function (i) {
					$("<div class='option' style='background-color:" + colors[i] + "'></div>").appendTo('#pallete');
				});

				for(var i = 1; i <= 9; i++) {
					$('<div class="option"><div></div></div>')
					.find('div')
                    .css({
                        'margin-top': 10 - i / 2,
                        'margin-left': 10 - i / 2,
                        width: i,
                        height: i
                    })
					.end()
					.appendTo('#line');
				}

				var cBlock = $("#pallete .option");
				var lBlock = $("#line .option");

				cBlock
					.click(function () {
						cBlock.removeClass("active");
						$(this).addClass("active");
						
						p_color = $(this).css('background-color');
						
						lBlock
                            .children("div")
                            .css("background-color", p_color);
					})
					.first()
					.click();

				lBlock
					.click(function () {
						lBlock.removeClass("active");
						$(this).addClass("active");
						p_width = $(this)
                            .children("div")
                            .css("width")
                            .replace("px", "");
					})
					.eq(3)
					.click();

				var $canvas = $("#paint");
				var ctx = $canvas[0].getContext("2d");

				$canvas[0].width = window.innerWidth;
				$canvas[0].height = window.innerHeight;

				$(window).on('resize', function () {
					var state = ctx.getImageData(0, 0, $canvas[0].width, $canvas[0].height);
					
					$canvas[0].width = window.innerWidth;
					$canvas[0].height = window.innerHeight;
					
					ctx.putImageData(state, 0, 0);
				});

				ctx.lineCap = "butt";
				ctx.fillStyle = "white";
				ctx.fillRect(0, 0, $canvas.width(), $canvas.height());
				var mousedown = false;

				$canvas
					.on('mousedown touchstart', function (e) {
						ctx.beginPath();
						ctx.strokeStyle = p_color;
						ctx.lineWidth = p_width;

						var posX = (e.pageX || e.originalEvent.targetTouches[0].pageX);
						var posY = (e.pageY || e.originalEvent.targetTouches[0].pageY);

						ctx.moveTo(posX, posY);
						mousedown = true;
					})
					.on('mousemove touchmove', function (e) {
						if(mousedown) {
							var posX = (e.pageX || e.originalEvent.targetTouches[0].pageX);
							var posY = (e.pageY || e.originalEvent.targetTouches[0].pageY);

							ctx.lineTo(posX, posY);
							ctx.stroke();
						}
					})
					.on('mouseup touchend', function (e) {
						mousedown = false;
					});

				$("#saveImg").button().click(function () {
					var data = escape($canvas[0].toDataURL('image/png').split(',')[1]);
					var xhr = new XMLHttpRequest();

					xhr.onreadystatechange = function () {
						if(xhr.status === 200 && xhr.readyState == 4) {
							$("#output").dialog("open");
						}
					};

					xhr.open("POST", "./save.php", true);
					xhr.send(data);
				});

				$("#output").dialog({
					autoOpen: false,
					modal: true
				});

				$("#controls").draggable({
					containment: "parent",
					scroll: false,
					start: function(){
                        $(this).animate({
                            opacity: 1
                        }, 500);
					},
					stop: function(){
                        $(this).animate({
                            opacity: 0.5
                        }, 500);
					}
				});
			});
		</script>
	</head>
	<body>
		<div class="paint_controls ui-corner-all ui-helper-clearfix" id="controls">
			<div id="pallete"></div>
			<div id="line"></div>
			<input type="button" id="saveImg" value="儲存圖片" />
		</div>
		<div id="paintarea">
			<canvas id="paint" width="100%" height="600" />
		</div>
		<div id="output" title="完成">儲存完成!</div>
	</body>
</html>
