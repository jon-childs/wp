(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		//==== Kill default action on dead links
		$('a[href=""], a[href="#"]').on('click', function(e){
			e.preventDefault();
			e.stopPropagation();
		});
		
		//==== Allow 'rel' attribute to open new tabs
		$('a[rel="external"]').on('click', function(e){
			console.log('external link');
			if(!($(this).attr('href') == '' || $(this).attr('href') == '#')){
				e.preventDefault();
				window.open($(this).attr('href'));
			}
		});
		
		//====TOGGLE MOBILE MENU====
		$('header .nav-toggle').click(function(){
			$('header nav, nav.header').slideToggle();
			//console.log('[menu] toggle');
		});
		
		//====EXPAND NAV CHILDREN ON CLICK WHEN IN MOBILE VIEW===
		$('nav a').click(function(e){
			if($('header .nav-toggle').is(':visible')){
				if($(this).siblings('ul').length && !$(this).hasClass('clicked')){
					e.preventDefault();
					e.stopPropagation();
					$(this).siblings('ul').show();
					$(this).addClass('clicked');
				}
			}
		});
		
	});
	
})(jQuery, this);
