 (function($){

	function ga_simple_loop( elem, options ){
		var numberOfItems = $(elem).find(options.element).length;
		var curr = 0;
		$(elem).find(options.element).eq( curr ).fadeIn( options.animation );
		setInterval(
			function(){
				$(elem).find(options.element).eq( curr ).fadeOut( options.animation );
				curr = (curr == numberOfItems-1 ) ? 0 : curr+1;
				console.log(curr);
				$(elem).find(options.element).eq( curr ).fadeIn( options.animation );
			},
			options.timeintervel
		);
	}

	$.fn.ga_simple_loop = function (options) {
		var defaults = {
			'timeintervel' : 6000,
			'animation'    : 1000,
			'element'      : '> li'
		};

		var settings = $.extend({}, defaults, options);

		return this.each(function(){
			ga_simple_loop(this, settings);
		});
	};

})(jQuery);

jQuery(document).ready(function($){
	$(".ga-home-twitter ul").ga_simple_loop();
});