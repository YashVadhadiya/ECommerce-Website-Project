( function ( $ ) {
	var switch_to_new_ui = function () {
		$(
			'a.switch-to-new-ui, .cartflows-use-new-ui-save-btn, a.skip-switch-new-ui'
		).on( 'click', function ( e ) {
			e.preventDefault();

			let $this = $( this ),
				href = $this.attr( 'href' ),
				params = new URLSearchParams( href ),
				nonce = params.get( 'wcf_switch_ui' ),
				button_action = $this.hasClass( 'skip-switch-new-ui' )
					? 'skip'
					: 'update';

			var data = {
				action: 'wcf_switch_to_new_ui',
				button_action: button_action,
				security: nonce,
			};

			if ( button_action === 'skip' ) {
				$this.text( 'Saving...' );
			} else {
				$this.text( 'Switching UI...' );
			}

			$.ajax( {
				type: 'POST',
				url: ajaxurl,
				data: data,

				success: function ( response ) {
					if ( response.success ) {
						window.location.href = response.data[ 'redirect_to' ];
					}
				},
			} );
		} );
	};

	$( function () {
		switch_to_new_ui();
	} );
} )( jQuery );
