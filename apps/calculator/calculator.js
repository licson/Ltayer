/*--------------------------------------------------
// JCalculator - A Calculator Plugin for jQuery   //
//                                                //
// Author: Hitesh Agarwal                         //
// Version: 1.0                                   //
// Date: 14-feb 11                                //
// License: GNU General Public License v2.0       //
//                                                //
--------------------------------------------------*/

/*
	1. Must include jquery and jquery-ui[js and css] before the script
	2. Must include calculator.css
	
	usage:
		html: <div id="calculator1"></div>
		  js: later
*/

// @param params = later

(function($) {

	$.fn.calculator = function(params){
		var settings = jQuery.extend({},$.fn.calculator.defaults, params);
		
		
		//iterate over every matched element
		return this.each(function(){
			var calc = $(this);
			
			if(!calc.hasClass('converted2calc')){
				
				calc.settings = $.meta ?  $.extend({}, settings, calc.data()) : settings;
				
				$.fn.calculator.init(calc);
				
				// add class to chack later if calculator is ready to use
				calc.addClass('converted2calc');
			}
		});
	}
	
	$.fn.calculator.init = function(calc){
		calc.expression = '';
		calc.text = '0';
		calc._cleartextflag = false;
		calc._executable = true;
		calc._lastresult = null;
		
		//format calculator
		$.fn.calculator.format(calc).find('.calc-title-bar').text(calc.settings.title);
		
		/* Append Buttons
		------------------*/
		for(i in $.fn.calculator.buttons){
			$.fn.calculator.format.addButton(calc, $.fn.calculator.buttons[i]);
		}
			
		calc.keydown(function(event){
			event.preventDefault();
			if($.fn.calculator.buttons[event.keyCode]){
				$.fn.calculator.buttons[event.keyCode].onPress(calc);		// calling button's onPress event specified in button itself
				$.fn.calculator.action.updateDisplay(calc);					// updating calculator's display as calculator text or expression may have changed during button's onpress event
				calc.settings.buttonPressed();								// firing event buttonPressed to execute custom code passed in calculator params
			}
		})
		
		// hide it if defaultOpen is false
		calc.settings.defaultOpen?'':calc.css({display:'none'});
		
		// make it draggable if movable is true
		(calc.settings.movable&&$.fn.draggable)?(calc.draggable({handle:'.calc-title-bar-container'}).find('.calc-title-bar-container').css('cursor','move')):'';

		// make it closable if movable is true
		calc.settings.movable?( $('<div class="calc-title-bar-button-close"></div>').button({icons: {primary: "ui-icon-close"}, text: false}).appendTo(calc.find('.calc-title-bar-container')).css({position:'absolute',right:2,top:2,width:15,height:14}).click(function(){calc.settings.hide(calc)}) ):'';

		// make it resizable if resizable is true
		(calc.settings.resizable&&$.fn.resizable)?calc.resizable({handles:'se'}).css({minHeight:160, minWidth:130}):'';
		
		$.fn.calculator.action.updateDisplay(calc);
	}

	$.fn.calculator.hide = function(calc) {
		calc.hide();
	};
	
	$.fn.calculator.show = function(calc) {
		calc.show();
	};

	// define our format function
	$.fn.calculator.format = function(calc) {
		return calc.addClass('calculator calc-wrapper ui-widget ui-corner-all ui-widget-content').html('<div class="calc-title-bar-container ui-widget-header"><div class="calc-title-bar" style="padding:2px 3px;"></div></div><div class="calc-container" style="position:absolute;left:4px;right:4px;top:22px;bottom:8px"><div class="calc-text-wrapper" style="height:20%;left:3px;position:absolute;right:0;top:3%;"><label class="calc-text" style="background:#fff;border:1px solid #CCC;bottom:0;left:4%;overflow:hidden;padding:2px;position:absolute;right:4%;text-align:right;vertical-align:middle;"></label></div><div class="calc-buttons-wrapper" style="bottom:4px;left:2px;position:absolute;right:2px;top:23%;"></div></div>').attr('tabindex',0).css({width:calc.settings.width, height:calc.settings.height, outline:'none', position:'relative', zIndex:99999}).focusin(function(){calc.find('.calc-text').css({backgroundColor:'#FFFFF2'})}).focusout(function(){calc.find('.calc-text').css({backgroundColor:''})});
	};
	
	$.fn.calculator.format.createButton = function(button){
		var style = (button.left)?'left:'+button.left+';':'';
		style += (button.top)?'top:'+button.top+';':'';
		style += (button.width)?'width:'+button.width+';':'';
		style += (button.height)?'height:'+button.height+';':'';
		return $('<div class="calc-button-wrapper" style="position:absolute;'+style+'"><div class="calc-button" style="left:0;right:0;bottom:0;position:absolute;text-align:center;text-decoration:none;top:0;">'+button.symbol+'</div></div>');
	}
	
	// function to add button
	$.fn.calculator.format.addButton = function(calc,button){
		$.fn.calculator.format.createButton(button).button().appendTo(calc.find('.calc-buttons-wrapper')).click(function(){
			button.onPress(calc);							// calling button's onPress event specified in button itself
			$.fn.calculator.action.updateDisplay(calc);		// updating calculator's display as calculator text or expression may have changed during button's onpress event
			calc.settings.buttonPressed();					// firing event buttonPressed to execute custom code passed in calculator params
		});
		
	}
	
	// calculator actions
	$.fn.calculator.action = {
		updateDisplay: function(calc){
			calc.find('.calc-text').text(calc.text);
			calc.settings.displayChanged();					// firing event displayChanged to execute custom code passed in calculator params
		},
		input: function(calc, button){
			if(calc._executable){
				if(calc.text.length < calc.settings.accuracy||calc._cleartextflag){
					var input = (calc.text=='0'||calc._cleartextflag)?((button.symbol=='.')?'0.':(button.symbol=='0')?'':button.symbol):calc.text+button.symbol;
					
					if($.fn.calculator.validate.input(input)){
						calc.text = input;
						calc.expression = calc.expression+((input=='0.')?input:button.symbol);
						calc._cleartextflag = false;
					}
				}
				calc._lastresult = null;
			}
			else{
				if($.fn.calculator.validate.expression(calc.expression)){
					calc.text = eval(calc.expression);
					calc._lastresult = calc.text + '';
					calc.text = (calc.text.toPrecision(calc.settings.accuracy).indexOf('e') == -1)?parseFloat( calc.text.toPrecision(calc.settings.accuracy)) + '':calc.text.toPrecision(calc.settings.accuracy);
					//calc.expression = calc.text;
					calc.expression = '';
					calc._executable = false;
					calc._cleartextflag = true;					// clear display on next user input
				}
				if(calc._lastresult){
					calc.expression = calc._lastresult;
					calc._lastresult = null;
				}
				calc._cleartextflag = true;					// clear display on next user input
				calc.expression = (calc.expression=='')?button.symbol:($.fn.calculator.validate.operation(calc.expression)?calc.expression.replace(/[-+/\*]$/,button.symbol):calc.expression+button.symbol);
			}
		}
	}

	$.fn.calculator.buttons = {
		/* index:{
				symbol:<button's symbol to show on calc>, 
				onpress: <event to execute on button pressed [event param calc | the calculator itself]>,
				left:<button's left position in percentage inside calc buttons container>, 
				top:<button's top position in percentage inside calc buttons container>, 
				width:<button's width in percentage inside calc buttons container [optional | handle inside css either]>,
				height:<button's height in percentage inside calc buttons container [optional | handle inside css either]>,
			}
		*/
		96:{symbol:'0', keycode: 48, left:'4%', top:'80%', width:'44%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);} },
		97:{symbol:'1', keycode: 49, left:'4%', top:'61%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);} },
		98:{symbol:'2', keycode: 50, left:'28%', top:'61%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);} },
		99:{symbol:'3', keycode: 51, left:'52%', top:'61%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);} },
		100:{symbol:'4', keycode: 52, left:'4%', top:'42%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);}  },
		101:{symbol:'5', keycode: 53, left:'28%', top:'42%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);}  },
		102:{symbol:'6', keycode: 54, left:'52%', top:'42%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);}  },
		103:{symbol:'7', keycode: 55, left:'4%', top:'23%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);}  },
		104:{symbol:'8', keycode: 56, left:'28%', top:'23%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);}  },
		105:{symbol:'9', keycode: 57, left:'52%', top:'23%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);}  },
		110:{symbol:'.', keycode: 110, left:'52%', top:'80%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;$.fn.calculator.action.input(calc, this);} },
		111:{symbol:'/', keycode: 111, left:'4%', top:'4%', width:'20%', height:'15%', onPress:function(calc){calc._executable = false;$.fn.calculator.action.input(calc, this);} },
		106:{symbol:'*', keycode: 106, left:'28%', top:'4%', width:'20%', height:'15%', onPress:function(calc){calc._executable = false;$.fn.calculator.action.input(calc, this);} },
		107:{symbol:'+', keycode: 107, left:'76%', top:'23%', width:'20%',height:'34%', onPress:function(calc){calc._executable = false;$.fn.calculator.action.input(calc, this);} },
		109:{symbol:'-', keycode: 109, left:'52%', top:'4%', width:'20%', height:'15%', onPress:function(calc){calc._executable = false;$.fn.calculator.action.input(calc, this);} },
		13:{symbol:'=', keycode: 13, left:'76%', top:'61%', width:'20%', height:'34%', onPress:function(calc){
				if($.fn.calculator.validate.expression(calc.expression)){
					calc.text = eval(calc.expression);
					calc._lastresult = calc.text + '';
					calc.text = (calc.text.toPrecision(calc.settings.accuracy).indexOf('e') == -1)?parseFloat( calc.text.toPrecision(calc.settings.accuracy)) + '':calc.text.toPrecision(calc.settings.accuracy);
					//calc.expression = calc.text;
					calc.expression = '';
					calc._executable = false;
					calc._cleartextflag = true;					// clear display on next user input
				}
				else{
					calc.expression = calc.text;
				}
			}  
		},
		27:{symbol:'C', keycode: 27, left:'76%', top:'4%', width:'20%', height:'15%', onPress:function(calc){calc._executable = true;calc.expression = '';calc.text='0';}}
	}
	
	$.fn.calculator.validate = {
		input: function(text){
			return text.match(/^((0|(0\.[0-9]*))|([1-9][0-9]*|([1-9][0-9]*\.[0-9]*)|([1-9][0-9]*\.[0-9]*)|([1-9][0-9]*)))$/);
		},
		expression: function(expr){
			//alert(expr);
			return expr.match(/^\d{1,}(\.\d{1,})?[-+*/]\d{1,}(\.\d{1,})?$/);
		},
		operation: function(expr){
			return expr.match(/[-+/\*]$/);
		}
	}


	/* implementing jQuery UI functions in case no jquery ui found
	----------------------------------------------------------------*/
	if(!$.fn.button){
		$.fn.button = function(){
			return this.each(function(){
				button = $(this);
				button.find('.calc-button').css({borderWidth:1,borderStyle:'solid',borderColor:'#CCCCCC',lineHeight:1.4,fontSize:'1em',cursor:'pointer',fontWeight:'bold'});
			})
		}
	}

	// plugin defaults
	$.fn.calculator.defaults = {
		defaultOpen: true,
		title: 'Calculator',
		accuracy: 12,
		width: '100%',
		height: '100%',
		movable: false,
		resizable: false,
		show: function(calc){
			$.fn.calculator.show(calc);
		},
		hide: function(calc){
			$.fn.calculator.hide(calc);
		},
		buttonPressed: function(calc, button){},
		displayChanged: function(calc, text, expression){}
		//expressionChanged: function(){calc, expression},
		//textChanged: function(){calc, text}
		//animations: false,
	};

})(jQuery);