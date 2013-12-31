$(function () {
    function distance(x0, y0, x1, y1) {
        return Math.sqrt((x1 - x0) * (x1 - x0) + (y1 - y0) * (y1 - y0));
    }
    
	var proximity = 180;
	var fps = 30;
	var iconSmall = 48,
		iconLarge = 96;
	var iconDiff = iconLarge - iconSmall;
	var mouseX, mouseY;
	var dock = $("#dock");
	var animating = false,
		redrawReady = false;

	$('body').removeClass("no_js");
	
	$(document).on("mousemove", function (e) {
		if(dock.is(":visible")) {
			mouseX = e.pageX;
			mouseY = e.pageY;

			redrawReady = true;
			registerConstantCheck();
		}
	});

	function registerConstantCheck() {
		if(!animating) {
			animating = true;

			window.setTimeout(callCheck, 1000 / fps);
		}
	}

	function callCheck() {
		sizeDockIcons();

		animating = false;

		if(redrawReady) {
			redrawReady = false;
			registerConstantCheck();
		}
	}

	//do the maths and resize each icon
	function sizeDockIcons() {
		dock.find("li").each(function () {
			//find the distance from the center of each icon
			var centerX = $(this).offset().left + ($(this).outerWidth() / 2.0);
			var centerY = $(this).offset().top + ($(this).outerHeight() / 2.0);

			var dist = distance(centerX, centerY, mouseX, mouseY);

			//determine the new sizes of the icons from the mouse distance from their centres
			var newSize = (1 - Math.min(1, Math.max(0, dist / proximity))) * iconDiff + iconSmall;
			$(this).find("a").css({
				width: newSize
			});
		});
	}
});