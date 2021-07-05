/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	wp.customize( 'store_hide_title_tagline', function ( value ) {
		value.bind( function ( to ) {
			$( '#text-title-desc' ).toggle();
		});
	} );
	wp.customize( 'store_footer_text', function( value ) {
		value.bind( function ( to ) {
			$( '.custom-text').text( to );
		});
	});
	wp.customize( 'store_hide_fc_line', function( value ) {
		value.bind( function ( to ) {
			$( '.sep').toggle();
		});
	});
	wp.customize( 'store_social_icon_style_set', function( value ) {
		value.bind( function( to ) {
			var	ChangeClass	=	'common ' + to;
			jQuery( '.social-icons a' ).attr( 'class', ChangeClass );
		});
	});
	wp.customize( 'store_social_1', function( value ) {
		value.bind( function( to ) {
			var ClassNew	=	'fab fa-' + to;
			jQuery('.social-icons' ).find( 'i:eq(0)' ).attr( 'class', ClassNew );
		});
	});
	
	wp.customize( 'store_social_2', function( value ) {
		value.bind( function( to ) {
			var ClassNew	=	'fab fa-' + to;
			jQuery('.social-icons' ).find( 'i:eq(1)' ).attr( 'class', ClassNew );
		});
	});
	
	wp.customize( 'store_social_3', function( value ) {
		value.bind( function( to ) {
			var ClassNew	=	'fab fa-' + to;
			jQuery('.social-icons' ).find( 'i:eq(2)' ).attr( 'class', ClassNew );
		});
	});
	
	wp.customize( 'store_social_4', function( value ) {
		value.bind( function( to ) {
			var ClassNew	=	'fab fa-' + to;
			jQuery('.social-icons' ).find( 'i:eq(3)' ).attr( 'class', ClassNew );
		});
	});
	
	wp.customize( 'store_social_5', function( value ) {
		value.bind( function( to ) {
			var ClassNew	=	'fab fa-' + to;
			jQuery('.social-icons' ).find( 'i:eq(4)' ).attr( 'class', ClassNew );
		});
	});
	
	wp.customize( 'store_social_6', function( value ) {
		value.bind( function( to ) {
			var ClassNew	=	'fab fa-' + to;
			jQuery('.social-icons' ).find( 'i:eq(5)' ).attr( 'class', ClassNew );
		});
	});
	
	wp.customize( 'store_social_7', function( value ) {
		value.bind( function( to ) {
			var ClassNew	=	'fab fa-' + to;
			jQuery('.social-icons' ).find( 'i:eq(6)' ).attr( 'class', ClassNew );
		});
	});
} )( jQuery );
