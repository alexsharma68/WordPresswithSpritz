/*
Version: WordPresswithSpritz 0.2
URL: http://www.WordPresswithSpritz.com
Description: WordPresswithSpritz.
*/
(function ($) {
    var base; /* Base Variable */
	var Spritzers = []; // Array Containing all the Editors that will be Created						// variable for layout
	var spritzController = null;
    $.WordPresswithSpritz = function (el, op) { 		// Core Function
        base 			= this; 						// objects to base variable
        base.$el 		= $(el); 						// passed base variable to base.$el variable
        base.el 		= el;
		base.current 	= null;
		base.thisEl		= null;							// passed elements to base.el variable
        base.$el.data("WordPresswithSpritz", base); 	// creating data variable to store data
        base.init = function () { 						// first/initial function, which will be called the first time when the page loads
			base.op = $.extend({}, $.WordPresswithSpritz.defaultOptions, op);// extending function/overwriting default option by new options
			
			//console.log(base.op);
			
			spritzController = new SPRITZ.spritzinc.SpritzerController(base.op);
 			spritzController.attach(base.$el);
			
            j('body').on('click','.spritz_start',function(){
				alert("ee");
				$(".spritzer_popup").show()
				base.current = $(this);
				
				var url		= $(this).data('target');
				var sector	= $(this).data('selector');
				
				if(base.url(url)){
					if(sector==''){
						SpritzClient.fetchContents(url, base.onSpritzifySuccess, base.onSpritzifyError);
					}else{
						SpritzClient.fetchContents(url, base.onSpritzifySuccess, base.onSpritzifyError,sector);	
					}
				}else if(url=='' || url=='body'){
					if(sector==''){
						SpritzClient.fetchContents(document.URL, base.onSpritzifySuccess, base.onSpritzifyError);
					}else{
						SpritzClient.fetchContents(document.URL, base.onSpritzifySuccess, base.onSpritzifyError,sector);
					}
				}else{
					if(sector==''){
						SpritzClient.spritzify(base.getText($(this)), 'en_US', base.onSpritzifySuccess, base.onSpritzifyError);
					}else{
						SpritzClient.spritzify(base.getText($(this)), 'en_US', base.onSpritzifySuccess, base.onSpritzifyError,sector);
					}
				}
            });
			
			//spritzController.stopSpritzing();
        }
		
		base.init();
		
		base.url=function(str){
			var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
			
			if (urlregex.test(str)) {
				return (true);
			}
			
			return (false);
		}
		
		base.getText = function(e){
			try{
				var elm = null;
				elm = e.data('target');
				
				if(j(elm).length){
					return $.trim(j(elm).html().replace(/(<([^>]+)>)/ig,"")).replace(/\s/g, '');;
				}
			}catch(e){
				alert("Invalid content target. Please provide a valid target to read content.")
			}
		}
		
		base.onSpritzifySuccess = function(spritzText) {
			base.$el.find("#spritzer-loading").removeAttr("style");
			spritzController.startSpritzing(spritzText);
		}
		
		base.onSpritzifyError = function(error) {
			alert("Unable to Spritz: " + error.message);
		}
	}
	
    $.WordPresswithSpritz.defaultOptions = {
		"redicleWidth" 			: 340,
		"redicleHeight" 		: 70,
		"redicleHeight_collaps"	: 0,
		"defaultSpeed" 			: 250, 
		"speedItems" 			: [250, 300, 350, 400, 450, 500, 550, 600], 
		"controlButtons" 		: ["pauseplay", "rewind", "back"],
		"controlTitles" 		: {
			"pause" 			: "Pause",
			"play" 				: "Play",
			"rewind" 			: "Rewind", 
			"back" 				: "Previous Sentence"
		}
    };
	
    $.fn.WordPresswithSpritz = function (op) {
        return this.each(function () {
            (new $.WordPresswithSpritz(this, op));
        });
    };
})(jQuery);
