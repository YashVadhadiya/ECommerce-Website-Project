( function ( $ ) {
	var wcf_steps_hide_show_delete = function () {
		$( '.wcf-flow-settings .wcf-step-delete' ).on( 'click', function ( e ) {
			e.preventDefault();
			var current_target = $( e.target );

			var $this = $( this ),
				step_id = $this.data( 'id' ),
				icon_span = $this.find( '.dashicons-trash' ),
				text_span = $this.find( '.wcf-step-act-btn-text' ),
				wcf_step = $this.closest( '.wcf-step' ),
				parent = $this.parents( '.wcf-step-wrap' );

			var delete_status = confirm(
				'This action will delete this flow step. Are you sure?'
			);
			if ( true == delete_status ) {
				console.log( 'Step Deleting' );
				icon_span.addClass( 'wp-ui-text-notification' );
				text_span
					.addClass( 'wp-ui-text-notification' )
					.text( 'Deleting..' );
				//$this.text('Deleting..');

				var post_id = $( 'form#post #post_ID' ).val();

				wcf_step.addClass( 'wcf-loader' );
				$.ajax( {
					url: ajaxurl,
					data: {
						action: 'cartflows_delete_flow_step',
						post_id: post_id,
						step_id: step_id,
						security: cartflows_admin.wcf_delete_flow_step_nonce,
					},
					dataType: 'json',
					type: 'POST',
					success: function ( data ) {
						if ( data.reload ) {
							location.reload();
						} else {
							parent.slideUp( 400, 'swing', function () {
								parent.remove();
							} );
						}

						setTimeout( function () {
							$(
								'.wcf-flow-steps-container'
							).trigger( 'wcf-step-deleted', [ step_id ] );
						}, 600 );

						console.log( data );
					},
				} );
			}
		} );
	};

	var wcf_flow_step_clone = function () {
		$( '.wcf-flow-settings .wcf-step-clone' ).on( 'click', function ( e ) {
			e.preventDefault();

			if ( $( this ).hasClass( 'wcf-pro' ) ) {
				return;
			}

			var $this = $( this ),
				step_id = $this.data( 'id' ),
				icon_span = $this.find( '.dashicons-trash' ),
				text_span = $this.find( '.wcf-step-act-btn-text' ),
				wcf_step = $this.closest( '.wcf-step' );

			var clone_status = confirm(
				'Do you want to clone this step? Are you sure?'
			);

			if ( true == clone_status ) {
				console.log( 'Clonning Step' );
				icon_span.addClass( 'wp-ui-text-notification' );
				text_span
					.addClass( 'wp-ui-text-notification' )
					.text( 'Clonning...' );

				var post_id = $( 'form#post #post_ID' ).val();

				wcf_step.addClass( 'wcf-loader' );

				$.ajax( {
					url: ajaxurl,
					data: {
						action: 'cartflows_clone_flow_step',
						post_id: post_id,
						step_id: step_id,
						security: cartflows_admin.wcf_clone_flow_step_nonce,
					},
					dataType: 'json',
					type: 'POST',
					success: function ( data ) {
						location.reload();
					},
				} );
			}
		} );
	};

	var wcf_flow_steps_sortbale = function () {
		$( '.wcf-flow-settings .wcf-flow-steps-container' ).sortable( {
			connectWith: '.wcf-flow-steps-container',
			forcePlaceholderSize: true,
			placeholder: 'sortable-placeholder',

			update: function ( event, ui ) {
				var $this = $( this ),
					step_fields = $this.find( '.wcf-steps-hidden' ),
					step_ids = [],
					post_id = $( 'form#post #post_ID' ).val();

				step_fields.each( function ( i, obj ) {
					step_ids.push( $( this ).val() ); //test
				} );

				$this.sortable( 'disable' );
				$.ajax( {
					url: ajaxurl,
					data: {
						action: 'cartflows_reorder_flow_steps',
						post_id: post_id,
						step_ids: step_ids,
						security: cartflows_admin.wcf_reorder_flow_steps_nonce,
					},
					dataType: 'json',
					type: 'POST',
					success: function ( data ) {
						$this.sortable( 'enable' );

						if ( data.status ) {
							console.log( 'Sorted' );
						}

						console.log( data );
					},
				} );
			},
		} );
	};

	var wcf_handle_flow_options = function () {
		$( document ).on( 'click', '.wcf-edit-settings', function ( e ) {
			var setting_button = $( this ),
				$window = $( window ),
				step_wrap = setting_button.closest( '.wcf-step-wrap' );

			if ( step_wrap.hasClass( 'wcf-ab-test' ) ) {
				step_wrap = setting_button.closest( '.wcf-step' );
			}

			var setting_menu = step_wrap.find( '#wcf-edit-dropdown' ),
				step_wrap_height = step_wrap.height(),
				step_wrap_top = step_wrap.offset().top - $window.scrollTop(),
				el_parent_bottom = step_wrap_top + step_wrap.outerHeight(),
				el_dropdown_height = setting_menu.outerHeight( true ),
				class_css = '';

			if ( setting_button.hasClass( 'active' ) ) {
				setting_button.removeClass( 'active' );
				setting_menu.removeClass(
					'wcf-edit-show wcf-edit-above wcf-edit-below'
				);
				return false;
			}

			setting_button.addClass( 'active' );

			setting_menu.addClass( 'wcf-edit-show' );

			if ( step_wrap_top > el_dropdown_height ) {
				class_css = 'wcf-edit-above';
			} else {
				class_css = 'wcf-edit-below';
			}

			setting_menu.addClass( class_css );
		} );

		$( 'body' ).on( 'click', function () {
			$( '.wcf-edit-settings' ).removeClass( 'active' );
			$( '.wcf-flow-steps-container' )
				.find( '.wcf-step-wrap #wcf-edit-dropdown' )
				.removeClass( 'wcf-edit-above wcf-edit-below wcf-edit-show' );
		} );
	};

	$( function () {
		wcf_steps_hide_show_delete();

		wcf_flow_steps_sortbale();

		wcf_handle_flow_options();

		wcf_flow_step_clone();
	} );
} )( jQuery );
