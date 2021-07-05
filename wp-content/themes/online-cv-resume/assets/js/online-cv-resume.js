(function($) {
    "use strict";
    jQuery(document).ready(function($) {
        
      
		 if( $("#sidebar-actions").length){
			$('#sidebar-actions').on('click', function(e) {
				e.preventDefault();
				$(this).toggleClass('active');
				$('body').toggleClass('nav-expanded');
			});
		}
		
		 if( $("#aside-nav-actions").length){
			$('#aside-nav-actions').on('click', function(e) {
				e.preventDefault();
				$(this).toggleClass('active');
				$('#aside-nav-wrapper').toggleClass('show');
			});
		}
		
		
		if( $('#aside-nav-wrapper .navbar-nav li.menu-item-has-children').length ){
			
			$('#aside-nav-wrapper .navbar-nav li.menu-item-has-children').each(function(index, element) {
                $(this).append('<i class="responsive-nav-show-hide fa fa-chevron-down"></i>');
				
            });
		}
		
		
		if( $(".responsive-nav-show-hide").length){
			$('.responsive-nav-show-hide').on('click', function(e) {
				e.preventDefault();
				$(this).toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
				$(this).parents('li').find('ul.sub-menu').eq(0).toggle();
				
			});
		}

		
	
        if( $('.theme-own-carousel .gallery').length ){
			$(".theme-own-carousel .gallery").owlCarousel({
				
				stagePadding: 0,
				loop: true,
				autoplay: true,
				autoplayTimeout: 2000,
				margin: 10,
				nav: false,
				dots: false,
				smartSpeed: 1000,
				responsive: {
					0: {
						items: 1
					},
					600: {
						items: 1
					},
					1000: {
						items: 1
					}
				}
			});
		}

		$(".image-popup").fancybox();
	
       

        
    });

    
    $(window).on ('load', function (){ // makes sure the whole site is loaded

      

        // ------------------------------- AOS Animation 
        AOS.init({
          duration: 1000,
          mirror: true
        });


	});
	
})(jQuery);

