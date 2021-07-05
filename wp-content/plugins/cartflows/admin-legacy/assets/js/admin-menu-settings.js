( function ( $ ) {
	/* Disable/Enable Facebook Pixel Field section*/
	var wcf_toggle_fields_facebook_pixel = function () {
		var fb_pixel_fields = '.wcf-fb-pixel-wrapper';
		jQuery( fb_pixel_fields ).toggle(
			jQuery( '#wcf_wcf_facebook_pixel_tracking' ).is( ':checked' )
		);
		jQuery( '#wcf_wcf_facebook_pixel_tracking' ).on( 'click', function () {
			jQuery( fb_pixel_fields ).toggle(
				jQuery( '#wcf_wcf_facebook_pixel_tracking' ).is( ':checked' )
			);
		} );
	};
	/* Disable/Enable Facebook Pixel Field section*/

	/* Disable/Enable Google Analytics Field section */
	var wcf_toggle_fields_google_analytics = function () {
		var google_analytics_fields = '.wcf-google-analytics-wrapper';

		jQuery( google_analytics_fields ).toggle(
			jQuery( '#wcf_enable_google-analytics-id' ).is( ':checked' )
		);

		jQuery( '#wcf_enable_google-analytics-id' ).on( 'click', function () {
			jQuery( google_analytics_fields ).toggle(
				jQuery( '#wcf_enable_google-analytics-id' ).is( ':checked' )
			);
		} );
	};
	/* Disable/Enable Google Analytics Field section */

	var wcf_fetch_stats_overview = function () {
		$( '.wcf-stats-buttons button' ).on( 'click', function ( e ) {
			e.preventDefault();

			var $this = $( this ),
				wrap = $this.closest( '.wcf-stats-buttons' ),
				filter = $this.data( 'filter' );

			wrap.find( '.button' )
				.removeClass( 'button-primary' )
				.addClass( 'button-secondary' );
			$this
				.addClass( 'button-primary' )
				.removeClass( 'button-secondary' );

			$.ajax( {
				url: ajaxurl,
				data: {
					action: 'cartflows_fetch_stats',
					filter: filter,
					security: cartflows_admin.wcf_fetch_stats_nonce,
				},
				dataType: 'json',
				type: 'POST',
				success: function ( data ) {
					console.log( data );
				},
			} );
		} );
	};

	$( function () {
		wcf_toggle_fields_facebook_pixel();
		wcf_toggle_fields_google_analytics();
	} );
} )( jQuery );
