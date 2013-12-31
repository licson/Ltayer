/*!
 * jQuery Double Tap Plugin.
 *
 * Copyright (c) 2010 Raul Sanchez (http://www.appcropolis.com)
 *
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */
(function ($) {
	$.fn.doubletap = function (onDoubleTapCallback, onTapCallback, delay) {
		var eventName, action;
		delay = delay === null ? 500 : delay;
		eventName = 'touchend';

		$(this).on(eventName, function (event) {
			var now = new Date().getTime();
			var lastTouch = $(this).data('lastTouch') || now + 1; // first time this will make delta a negative number
			var delta = now - lastTouch;
			clearTimeout(action);
			if(delta < 500 && delta > 0) {
				if(onDoubleTapCallback !== null && typeof onDoubleTapCallback == 'function') {
					onDoubleTapCallback(event);
				}
			} else {
				$(this).data('lastTouch', now);
				action = setTimeout(function (evt) {
					if(onTapCallback !== null && typeof onTapCallback == 'function') {
						onTapCallback(evt);
					}
					clearTimeout(action); // clear the timeout
				}, delay, [event]);
			}
			$(this).data('lastTouch', now);
		});
	};
})(jQuery);

/*
 * Ltayer JS Component
 *
 * Copyright (c) 2013 Ltay Team (http://ltay.net/)
 *
 * The project is released under the MIT License.
 * http://www.opensource.org/licenses/mit-license.php
 */

var Ltayer = Ltayer || {};
Ltayer.UI = Ltayer.UI || {};

/*
 * Class: Ltayer.Window
 *
 * This handles the main window GUI.
 * An window is created in runtime by calling the class.
 */

Ltayer.Window = function (url, title) {
	var self = this;

	this.url = url;
	this.title = title;

	this.maximum = false;

	this.pane = $('<div class="window"></div>');
	this.buttons = $('<div class="user-header buttons"><div class="button-group"><span class="close ion-ios7-close-empty"></span><span class="max ion-ios7-plus-empty"></span><span class="min ion-ios7-minus-empty"></span></div></div>');
	this.iframe = $('<iframe allowtransparency></iframe>');
	this._iframeOverlay = $('<div style="position: absolute; z-index: 2; left: 0pt; top: 0pt; right: 0pt; bottom: 0pt;"></div>');

	this.buttons.append($('<p>', {
		text: title,
		class: 'header-title'
	}));
	this.pane.append(this.buttons);
	this.pane.append(this.iframe);

	this.buttons.find('.max').click(function () {
		self.max();
	});

	this.buttons.find('.close').click(function () {
		self.close();
	});

	this.buttons.find('.min').click(function () {
		self.pane.fadeOut(500);
	});

	this.show();
};

Ltayer.Window.prototype.show = function () {
	var self = this;

	this.iframe.on('load', function () {
		$(this).css('background', 'transparent');
	});

	this.iframe.attr('src', this.url);

	this.pane.appendTo('body');

	this.pane.draggable({
		stack: ".window",
		scroll: false,
		start: function () {
			Ltayer._WindowMananger.enableIframeOverlay();
		},
		stop: function () {
			Ltayer._WindowMananger.disableIframeOverlay();
			Ltayer._AJAX.end_record_window_pos_action();
		}
	}).resizable({
		resize: function () {
			self.maximum = false;
			self.iframe.height(self.pane.height());
		},
		start: function () {
			Ltayer._WindowMananger.enableIframeOverlay();
		},
		stop: function () {
			Ltayer._WindowMananger.disableIframeOverlay();
			Ltayer._AJAX.end_record_window_pos_action();
		},
		minWidth: 300,
		minHeight: 300
	});

	this.iframe.height(this.pane.height());
	this.pane.fadeIn(500);
	Ltayer._WindowMananger.add(this);
	// this.max();
};

Ltayer.Window.prototype.max = function () {
	var self = this;
	if(!this.maximum) {
		this.pane.animate({
			top: $('#status-bar').outerHeight(),
			width: $('#status-bar').outerWidth(),
			height: $('body').height() - $('#status-bar').outerHeight(),
			left: 0,
			right: 0
		}, {
			duration: 500,
			step: function () {
				self.iframe.height(self.pane.height());
			},
			complete: function () {
				self.maximum = true;
				Ltayer._AJAX.end_record_window_pos_action();
			}
		});
	} else {
		this.pane.animate({
			width: window.innerWidth / 2,
			height: window.innerHeight * 0.7,
			top: '15%',
			left: '25%'
		}, {
			duration: 500,
			step: function () {
				self.iframe.height(self.pane.height());
			},
			complete: function () {
				self.maximum = false;
				Ltayer._AJAX.end_record_window_pos_action();
			}
		});
	}
};

Ltayer.Window.prototype.close = function () {
	var self = this;
	this.pane.fadeOut(500, function () {
		self.pane.remove();
		self.pane = null;
		Ltayer._WindowMananger.remove(self);
	});
};

Ltayer.Window.prototype.setPos = function (x, y) {
	this.pane.animate({
		left: x,
		top: y
	}, 500);
};

Ltayer.Window.prototype.setDim = function (w, h) {
	var self = this;

	this.pane.animate({
		width: w,
		height: h
	}, {
		duration: 500,
		step: function () {
			self.iframe.height(self.pane.height());
		},
		complete: function () {
			self.maximum = false;
			Ltayer._AJAX.end_record_window_pos_action();
		}
	});
};

Ltayer.Window.prototype.getPos = function () {
	var x = Number(this.pane.css('left').replace('px', ''));
	var y = Number(this.pane.css('top').replace('px', ''));

	return [x, y];
};

Ltayer.Window.prototype.getDim = function () {
	var w = Number(this.pane.css('width').replace('px', ''));
	var h = Number(this.pane.css('height').replace('px', ''));

	return [w, h];
};

/*
 * Class: Ltayer.WindowMananger
 *
 * Manages the window created at runtime.
 */

Ltayer.WindowMananger = function () {
	this.windows = [];
};

Ltayer.WindowMananger.prototype.add = function (win) {
	this.windows.push(win);
	this.update();
};

Ltayer.WindowMananger.prototype.remove = function (win) {
	this.windows.splice(this.windows.indexOf(win), 1);
	this.update();
};

Ltayer.WindowMananger.prototype.findAppByTitle = function (text) {
	var result = null;
	$.each(this.windows, function (i, ele) {
		if(ele.title == text) {
			result = ele;
		}
	});

	return result;
};

Ltayer.WindowMananger.prototype.findAppByElement = function (ele) {
	var result = null;
	$.each(this.windows, function (i, ele) {
		if(ele.pane == ele) {
			result = ele;
		}
	});

	return result;
};

Ltayer.WindowMananger.prototype.enableIframeOverlay = function () {
	$.each(this.windows, function (i, ele) {
		ele._iframeOverlay.appendTo(ele.pane);
	});
};

Ltayer.WindowMananger.prototype.disableIframeOverlay = function () {
	$.each(this.windows, function (i, ele) {
		ele._iframeOverlay.remove();
	});
};

Ltayer.WindowMananger.prototype.update = function () {
	$('#status-bar li.app-item').remove();

	Ltayer._AJAX.end_record_window_pos_action();

	var menu = $('#status-bar ul');
	$.each(this.windows, function (i, ele) {
		menu.append(
			$('<li>')
			.attr('data-index', i)
			.addClass('app-item')
			.append(
				$('<a>', {
					text: ele.title,
					href: '#'
				})
			)
		);
	});
};

/*
 * Class: Ltayer.AJAX
 *
 * Handles AJAX Interactions
 */

Ltayer.AJAX = function () {};

Ltayer.AJAX.prototype.action = function (method, data, cb) {
	$.ajax({
		url: 'core/ajax.php',
		data: 'action=' + method + (data ? '&' + data : ''),
		type: "GET",
		success: cb
	});
};

Ltayer.AJAX.prototype.app_sorted_action = function () {
	this.action('update_app_pos', $('#shortcuts').sortable('serialize'), function (result) {
		if(!result) {
			new Ltayer.UI.Alert({
				title: "資料庫錯誤!",
				msg: "儲存新的版面排序時發生錯誤!"
			});
		}
	});
};

Ltayer.AJAX.prototype.end_record_window_pos_action = function () {
	var data = [];
	$.each(Ltayer._WindowMananger.windows, function (i, ele) {
		data.push({
			pos: ele.getPos(),
			dim: ele.getDim(),
			url: ele.url,
			title: ele.title,
			max: ele.maximum
		});
	});

	this.action('end_update_window_pos', 'wins=' + window.JSON.stringify(data), function (result) {
		if(!result) {
			new Ltayer.UI.Alert({
				title: "資料庫錯誤!",
				msg: "儲存新的視窗排序時發生錯誤!"
			});
		}
	});
};

/*
 * Class: Ltayer.UI.Alert
 *
 * Creates alert messages and its UI
 */

Ltayer.UI.Alert = function (opts) {
	var self = this;
	this._opts = $.extend({
		duration: false,
		fxDur: 500,
		title: '訊息',
		theme: 'error',
		onClose: function () {}
	}, opts);

	this.body = $('<div class="ltayer-ui-alert"><div class="ltayer-ui-alert-title"></div><div class="ltayer-ui-alert-body"></div><span class="btn">OK</span></div>');
	this.overlay = $('<div class="ltayer-ui-alert-overlay"></div>');

	this.body.addClass('ltayer-ui-alert-' + this._opts.theme);

	if(!this._opts.msg) {
		throw new Error("A Message is required!");
	}

	this.body.find('.ltayer-ui-alert-title').append(this._opts.title);
	this.body.find('.ltayer-ui-alert-body').append(this._opts.msg);
	this.body.find('.btn').click(function () {
		self.close();
		self._opts.onClose();
	});
	this.overlay.click(function () {
		self.close();
		self._opts.onClose();
	});

	this.show();

	if(this._opts.duration != false) {
		setTimeout(function () {
			self.close();
			self._opts.onClose();
		}, this._opts.duration);
	}
};

Ltayer.UI.Alert.prototype.show = function () {
	this.overlay.appendTo('body').fadeIn(this._opts.fxDur);
	this.body.appendTo('body').fadeIn(this._opts.fxDur);

	var h = this.body.outerHeight();

	this.body.css({
		top: (window.innerHeight - h) / 2
	});
};

Ltayer.UI.Alert.prototype.close = function () {
	var self = this;

	this.overlay.appendTo('body').fadeOut(this._opts.fxDur, function () {
		self.overlay.remove();
	});

	this.body.appendTo('body').fadeOut(this._opts.fxDur, function () {
		self.body.remove();
	});
};

/*
 * Class: Ltayer.UI.Desktop
 *
 * Handles the desktop GUI.
 */

Ltayer.UI.Desktop = function () {
	var self = this;
	this.selectedApps = [];

	$('#pane').selectable({
		filter: "#shortcuts li",
		start: function () {
			self.selectedApps = [];
		},
		selected: function (e, ui) {
			self.selectedApps.push(ui.selected);
		}
	});

	$('#shortcuts').sortable({
		stop: function () {
			Ltayer._AJAX.app_sorted_action();
		}
	});
	$('#shortcuts li a')
		.click(function () {
			return false;
		})
		.dblclick(this.appicon_trigger)
		.doubletap(this.appicon_trigger);

	$.contextMenu({
		selector: '*:not(#status-bar):not(#status-bar ul li)',
		callback: function (key) {
			self.appicon_contextmenu_trigger(key);
		},
		items: {
			open_apps: {
				name: "開啟選取的應用程式"
			},
			select_all: {
				name: "（反向）選取所有應用程式"
			},
			sep1: "-------------",
			settings: {
				name: "進入設定"
			},
			logout: {
				name: "登出"
			}
		}
	});

	$('#dockicon').sortable();
	$('#dockicon li a:not(#dock-logout)')
		.click(function () {
			return false;
		})
		.dblclick(this.appicon_trigger)
		.doubletap(this.appicon_trigger);

	$('#dock-logout')
		.dblclick(function (e) {
			e.preventDefault();
			window.LtayerKernal.logout();
		})
		.doubletap(function (e) {
			e.preventDefault();
			window.LtayerKernal.logout();
		});

	$('#ltayer-logout').click(function (e) {
		e.preventDefault();
		window.LtayerKernal.logout();
	});
};

Ltayer.UI.Desktop.prototype.appicon_trigger = function (e) {
	e.preventDefault();
	var text = $('span', this).text();

	new Ltayer.Window($(this).attr('href'), text);
};

Ltayer.UI.Desktop.prototype.appicon_contextmenu_trigger = function (key) {
	var self = this;

	switch(key) {
	case 'open_apps':
		if($('.ui-selected').length === 0) {
			new Ltayer.UI.Alert({
				msg: "沒有選擇應用程式!"
			});
		}

		var startPosX = window.innerWidth * 0.5;
		var startPosY = $('#status-bar').height() + 5;

		$.each(this.selectedApps, function (i, ele) {
			var href = $(ele).find('a').attr('href');
			var text = $(ele).find('span').text();

			var win = new Ltayer.Window(href, text);
			win.setPos(startPosX * Math.random(), startPosY + 32 * i);
		});
		break;

	case 'select_all':
		$('#shortcuts li').each(function () {
			$(this).toggleClass('ui-selected');

			var i = self.selectedApps.indexOf(this);
			if(i > -1) {
				self.selectedApps.splice(i, 1);
			} else {
				self.selectedApps.push(this);
			}
		});
		break;

	case 'settings':
		window.LtayerKernal.openApp('./admin/', '控制台');
		break;

	case 'logout':
		window.LtayerKernal.logout();
		break;
	}
};

/*
 * Class: Ltayer.UI.WindowMananger
 *
 * Creates the multitasking UI.
 */

Ltayer.UI.WindowMananger = function () {
	var self = this;

	$('#status-bar').on('click', 'li.app-item', function () {
		var win = Ltayer._WindowMananger.windows[$(this).attr('data-index')];
		win.pane.css('z-index', 100000 + (1000 * Math.random() | 0));
		win.pane.fadeIn(750);

		$(this).effect('transfer', {
			to: win.pane,
			className: "ui-effects-transfer"
		}, 500);
	});

	this.create_contextmenu();
};

Ltayer.UI.WindowMananger.prototype.create_contextmenu = function () {
	$.contextMenu({
		selector: '#status-bar',
		callback: function (key) {
			switch(key) {
			case "close_all":
				$.each(Ltayer._WindowMananger.windows, function (i, ele) {
					setTimeout(function () {
						ele.close();
					}, 300 * i);
				});
				Ltayer._WindowMananger.update();
				break;

			case "show_all":
				$.each(Ltayer._WindowMananger.windows, function (i, ele) {
					ele.pane.delay(100 * i).fadeIn(500);
				});
				break;

			case "min_all":
				$.each(Ltayer._WindowMananger.windows, function (i, ele) {
					ele.pane.delay(100 * i).fadeOut(500);
				});
				break;

			case "sort":
				var startPosX = window.innerWidth * 0.05;
				var startPosY = $('#status-bar').height() + 5;
				var ww = window.innerWidth * 0.5;
				var hh = window.innerHeight * 0.7;

				$.each(Ltayer._WindowMananger.windows.sort(function (a, b) {
					return a.title.charCodeAt(0) - b.title.charCodeAt(0);
				}), function (i, ele) {
					ele.setPos(startPosX + 32 * i, startPosY + 32 * i);
					ele.setDim(ww, hh);
					ele.pane.css('z-index', i + 1);
				});

				Ltayer._WindowMananger.update();
				break;
			}
		},
		items: {
			close_all: {
				name: "關閉所有視窗"
			},
			show_all: {
				name: "顯示所有視窗"
			},
			min_all: {
				name: "縮小所有視窗"
			},
			sep1: "-------------",
			sort: {
				name: "排序視窗"
			}
		}
	});
};

/*
 * Class: Ltayer.UI.Time
 *
 * Handles the clock UI
 */

Ltayer.UI.Time = function () {
	var self = this;
	this.ele = $('#status-bar ul li[data-role=time] a');

	this.ele.click(function (e) {
		e.preventDefault();
		new Ltayer.UI.Alert({
			theme: 'info',
			title: '時間',
			msg: self.getAlertMsg()
		});
	});

	setInterval(function () {
		self.update();
	}, 1000);

	this.update();
};

Ltayer.UI.Time.prototype.padZeros = function (num) {
	if(num < 10) return '0' + num;
	else return num;
};

Ltayer.UI.Time.prototype.getAlertMsg = function () {
	var ele = $('<div>');
	var date = new Date();

	ele.text(
		"今天是" +
		date.getFullYear() + ' 年 ' +
		this.padZeros(date.getMonth() + 1) + ' 月 ' +
		this.padZeros(date.getDate()) + ' 日 '
	);

	$('<div id="time-ui-calender">').appendTo(ele);

	setTimeout(function () {
		$('#time-ui-calender')
			.datepicker()
			.find('.ui-datepicker-inline')
			.css('display', 'inline-block');
	}, 500)
	return ele;
};

Ltayer.UI.Time.prototype.update = function () {
	var date = new Date();
	this.ele.html(
		this.padZeros(date.getHours()) + ':' +
		this.padZeros(date.getMinutes()) + ':' +
		this.padZeros(date.getSeconds())
	);
};

/*
 * Class: Ltayer.Kernal
 *
 * Prepare and start the system.
 */

Ltayer.Kernal = function () {
	/*
	 * Prepares the required system components
	 */
	Ltayer._WindowMananger = new Ltayer.WindowMananger();
	Ltayer._AJAX = new Ltayer.AJAX();
};

Ltayer.Kernal.prototype.openApp = function (href, text) {
	new Ltayer.Window(href, text);
};

Ltayer.Kernal.prototype.logout = function () {
	new Ltayer.UI.Alert({
		msg: "你即將登出!",
		duration: 3000,
		theme: "neutral",
		onClose: function () {
			window.location.href = "logout.php";
		}
	});
};

Ltayer.Kernal.prototype.restoreLastSession = function () {
	Ltayer._AJAX.action('get_last_window_state', null, function (result) {
		$.each(result, function (i, ele) {
			var win = new Ltayer.Window(ele.url, ele.title);
			if(!ele.max) {
				win.setPos(ele.pos[0], ele.pos[1]);
				win.setDim(ele.dim[0], ele.dim[1]);
			} else {
				win.max();
			}
		});
	});
};

Ltayer.Kernal.prototype.start = function () {
	this.desktop = new Ltayer.UI.Desktop();
	this.windowMananger = new Ltayer.UI.WindowMananger();
	this.time = new Ltayer.UI.Time();
	this.restoreLastSession();
};

/*
 * Start the Kernal
 */

$(function () {
	window.LtayerKernal = new Ltayer.Kernal();
	window.LtayerKernal.start();
});