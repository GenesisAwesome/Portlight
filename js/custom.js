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
			'element'      : '> li:not(".last")'
		};

		var settings = $.extend({}, defaults, options);

		return this.each(function(){
			ga_simple_loop(this, settings);
		});
	};

})(jQuery);

jQuery(document).ready(function($){
	$('.portlight-home-bottom .latest-tweets ul').ga_simple_loop();

	$('.nav-primary .genesis-nav-menu').before('<span class="responsive-navigation"><i class="fa fa-bars"></i> Navigation</span>');
	$('.nav-primary .sub-menu').before( '<span class="responsive-sub-nav"></span>' );

	$('.responsive-navigation, .responsive-sub-nav').click(function(){
		$(this).toggleClass('nav-active').next('.genesis-nav-menu, .sub-menu').slideToggle();
	});

	// Reset Nav
	$(window).resize(function(e) {
		if ( window.innerWidth > 767 ) {
			$('.nav-primary .genesis-nav-menu, .nav-primary .sub-menu').removeAttr('style');
			$('.responsive-navigation, .responsive-sub-nav').removeClass('nav-active');
		}
	});
});