/*!
 * jQuery Double Tap Plugin.
 *
 * Copyright (c) 2010 Raul Sanchez (http://www.appcropolis.com)
 *
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */

(function($){
    $.fn.doubletap = function(onDoubleTapCallback, onTapCallback, delay){
        var eventName, action;
        delay = delay == null? 500 : delay;
        eventName = 'touchend';

        $(this).on(eventName, function(event){
            var now = new Date().getTime();
            var lastTouch = $(this).data('lastTouch') || now + 1 /** the first time this will make delta a negative number */;
            var delta = now - lastTouch;
            clearTimeout(action);
            if(delta < 500 && delta > 0){
                if(onDoubleTapCallback != null && typeof onDoubleTapCallback == 'function'){
                    onDoubleTapCallback(event);
                }
            }else{
                $(this).data('lastTouch', now);
                action = setTimeout(function(evt){
                    if(onTapCallback != null && typeof onTapCallback == 'function'){
                        onTapCallback(evt);
                    }
                    clearTimeout(action);   // clear the timeout
                }, delay, [event]);
            }
            $(this).data('lastTouch', now);
        });
    };
})(jQuery);

var Window = function(url,title){
	var self = this;
	
	this.url = url;
	this.title = title;
	
	this.maximum = false;
	
	this.pane = $('<div class="window"></div>');
	this.buttons = $('<div class="user-header buttons"><span class="close ui-icon ui-icon-close"></span><span class="max ui-icon ui-icon-plus"></span><span class="min ui-icon ui-icon-minus"></span></div>');
	this.iframe = $('<iframe allowtransparency></iframe>');
	
	this.buttons.append($('<p>',{text: title,class:'pull-right'}));
	this.pane.append(this.buttons);
	this.pane.append(this.iframe);
	
	this.buttons.on('touchend mouseover', function(){
		self.buttons.stop().animate({
			opacity: 1
		}, 500);
		
		self.buttons.delay(3000).animate({
			opacity: 0.4
		}, 500);
	});
	
	this.buttons.find('.max').click(function(){
		self.max();
	});
	
	this.buttons.find('.close').click(function(){
		self.close();
	});
	
	this.buttons.find('.min').click(function(){
		self.pane.fadeOut(500);
	});
};

Window.prototype.show = function(){
	var self = this;
	
	this.iframe.on('load',function(){
		$(this).css('background','transparent')
	});
	this.iframe.attr('src',this.url);
	
	this.pane.appendTo('body');
	this.pane.draggable({stack:".window"}).resizable({
		resize:function(){
			self.maximum = false;
			self.iframe.height(self.pane.height());
		},
		minWidth: 229,
		minHeight: 316
	});
	
	this.iframe.height(this.pane.height());
	this.pane.fadeIn(500);
	this.max();
	this.buttons.delay(3000).animate({
		opacity: 0.4
	}, 500);
};

Window.prototype.max = function(){
	var self = this;
	if(!this.maximum){
		this.pane.animate({
			width: window.innerWidth,
			height: window.innerHeight - $('#status-bar').outerHeight(),
			top: $('#status-bar').offset().top + $('#status-bar').outerHeight(),
			left: 0
		},{
			duration: 500,
			step: function(){
				self.iframe.height(self.pane.height());
			},
			complete: function(){
				self.maximum = true;
			}
		});
		$('#wins').fadeOut(500)
	}
	else {
		this.pane.animate({
			width: window.innerWidth / 2,
			height: window.innerHeight * 0.7,
			top: '15%',
			left: '25%'
		},{
			duration: 500,
			step: function(){
				self.iframe.height(self.pane.height());
			},
			complete: function(){
				self.maximum = false;
			}
		});
		$('#wins').fadeIn(500);
	}
};

Window.prototype.close = function(){
	var self = this;
	this.pane.fadeOut(500,function(){
		self.pane.remove();
		self.pane = null;
		wins._update();
	});
}

var wins = {};
wins._update = function(){
	var menu = $('#wins').html('');
	for(var i in wins){
		if(i === '_update') continue;
		if(!wins[i].pane){
			delete wins[i];
		}
		else {
			menu.append($('<li>',{text:i}));
		}
	}
	
	if(menu.is(':empty')){
		menu.append($('<li>',{text:'沒有視窗！',class:'ignore'})).delay(1500).fadeOut(500);
	}
};

$(function(){
	var trigger = function(e){
		e.preventDefault();
		var text = $(this).text();
		
		wins[text] = new Window($(this).attr('href'),text);
		wins[text].show();
		wins._update();
	}
	
	$('#shortcuts').sortable();
	$('#shortcuts li a').click(function(){return false;});
	$('#shortcuts li a').dblclick(trigger);
	$('#shortcuts li a').doubletap(trigger);
	
	$('#wins').css({
		top: $('#status-bar').outerHeight() + 5
	});
	
	$('#win_button').click(function(e){
		e.preventDefault();
		$('#wins').fadeToggle(500);
	});
	
	$('#wins').on('click','li:not(.ignore)',function(){
		wins[$(this).text()].pane.fadeIn(750);
		$(this).effect('transfer',{
			to: wins[$(this).text()].pane,
			className: "ui-effects-transfer"
		},500);
	})
	
	$('li[data-role=logo]').click(function(){
		for(var i in wins){
			if(i === '_update') continue;
			wins[i].pane.fadeOut(500);
		}
	});
});