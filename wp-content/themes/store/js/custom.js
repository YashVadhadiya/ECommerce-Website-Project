jQuery(document).ready( function() {
	jQuery('#searchicon').click(function() {
		jQuery('#jumbosearch').fadeIn();
		jQuery('#jumbosearch input').focus();
	});
	jQuery('#jumbosearch .closeicon').click(function() {
		jQuery('#jumbosearch').fadeOut();
	});
	jQuery('body').keydown(function(e){
	    
	    if(e.keyCode == 27){
	        jQuery('#jumbosearch').fadeOut();
	    }
	});
		
	jQuery('#site-navigation ul.menu').slicknav({
		label: 'Menu',
		duration: 1000,
		prependTo:'#slickmenu'
	});	
	
});
 
    

// Swiper Slider Coverflow		
jQuery(function(){
  var myCoverflow = jQuery('.swiper-container').swiper({
    pagination: '.swiper-pagination',
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    slideToClickedSlide: true,
    paginationClickable: true,
    loop: true,
    coverflow: {
	        rotate: 50,
	        stretch: 0,
	        depth: 100,
	        modifier: 1,
	        slideShadows : true
	    }
    });
    
    //myCoverflow.slideTo(3, 0, false);
    
});

jQuery(function(){
  var myCoverflow = jQuery('.swiper-container-posts').swiper({
    pagination: '.swiper-pagination',
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    slideToClickedSlide: true,
    paginationClickable: true,
    loop: true,
    coverflow: {
	        rotate: 50,
	        stretch: 0,
	        depth: 100,
	        modifier: 1,
	        slideShadows : true
	    }
    });
    
    //myCoverflow.slideTo(3, 0, false);
    
});

//Featured Products - CUbe
jQuery(function(){
  var mySwiper = jQuery('.fp-container').swiper({
        pagination: '.swiper-pagination',
        effect: 'cube',
        grabCursor: true,
        paginationClickable: true,
        loop: true,
        pagination: false,
        nextButton: '.sbnc',
        prevButton: '.sbpc',
        cube: {
            shadow: false,
            slideShadows: true,
            shadowOffset: 12,
            shadowScale: 0.64
        }
        });
    });

jQuery(function(){
  var mySwiper = jQuery('.fposts-container').swiper({
        pagination: '.swiper-pagination',
        effect: 'cube',
        grabCursor: true,
        paginationClickable: true,
        loop: true,
        pagination: false,
        nextButton: '.sbncp',
        prevButton: '.sbpcp',
        cube: {
            shadow: false,
            slideShadows: true,
            shadowOffset: 12,
            shadowScale: 0.64
        }
        });
    });

//SLIDER
jQuery(function(){
  var mySlider = jQuery('.slider-container').swiper({
        pagination: '.swiper-pagination',
        paginationClickable: '.swiper-pagination',
        nextButton: '.sliderext',
        prevButton: '.sliderprev',
        spaceBetween: 30,
        autoplay: 2500,
        effect: 'fade'
    });		
});

//smooth scrolling
jQuery(document).ready( function() {
jQuery("#button-scroll-up").click(function() {
    jQuery('html, body').animate({
        scrollTop: jQuery("#colophon").offset().top
    }, 2000);
});

});

jQuery(document).ready( function() {
    jQuery("#button-scroll-down").click(function() {
        jQuery('html, body').animate({
            scrollTop: jQuery("#top-bar").offset().top
        }, 2000);
    });

});
	