( function ( $ ) {
	var wcf_flows_search_init = function () {
		var product_search = $( '.wcf-flows-search' );

		if ( product_search.length > 0 ) {
			$( 'select.wcf-flows-search' ).select2();
			var nonce = $( 'input[name="wcf_json_search_flows_nonce"]' ).val();

			$( 'select.wcf-flows-search' )
				.filter( ':not(.enhanced)' )
				.each( function () {
					var select2_args = {
						allowClear: $( this ).data( 'allow_clear' )
							? true
							: false,
						placeholder: $( this ).data( 'placeholder' ),
						minimumInputLength: $( this ).data(
							'minimum_input_length'
						)
							? $( this ).data( 'minimum_input_length' )
							: '3',
						escapeMarkup: function ( m ) {
							return m;
						},

						ajax: {
							url: ajaxurl,
							dataType: 'json',
							quietMillis: 250,
							method: 'post',
							data: function ( params, page ) {
								return {
									term: params.term,
									action:
										$( this ).data( 'action' ) ||
										'wcf_json_search_flows',

									security: nonce,
								};
							},
							processResults: function ( data, page ) {
								var terms = [];
								if ( data ) {
									$.each( data, function ( id, text ) {
										terms.push( {
											id: id,
											text: text,
										} );
									} );
								}
								return { results: terms };
							},
							cache: true,
						},
					};

					select2_args = $.extend(
						select2_args,
						getEnhancedSelectFormatString()
					);

					$( this ).select2( select2_args ).addClass( 'enhanced' );
				} );
		}
	};

	if ( typeof getEnhancedSelectFormatString === 'undefined' ) {
		function getEnhancedSelectFormatString() {
			var formatString = {
				noResults: function () {
					return wc_enhanced_select_params.i18n_no_matches;
				},
				errorLoading: function () {
					return wc_enhanced_select_params.i18n_searching;
				},
				inputTooShort: function ( args ) {
					var remainingChars = args.minimum - args.input.length;

					if ( 1 === remainingChars ) {
						return wc_enhanced_select_params.i18n_input_too_short_1;
					}

					return wc_enhanced_select_params.i18n_input_too_short_n.replace(
						'%qty%',
						remainingChars
					);
				},
				inputTooLong: function ( args ) {
					var overChars = args.input.length - args.maximum;

					if ( 1 === overChars ) {
						return wc_enhanced_select_params.i18n_input_too_long_1;
					}

					return wc_enhanced_select_params.i18n_input_too_long_n.replace(
						'%qty%',
						overChars
					);
				},
				maximumSelected: function ( args ) {
					if ( args.maximum === 1 ) {
						return wc_enhanced_select_params.i18n_selection_too_long_1;
					}

					return wc_enhanced_select_params.i18n_selection_too_long_n.replace(
						'%qty%',
						args.maximum
					);
				},
				loadingMore: function () {
					return wc_enhanced_select_params.i18n_load_more;
				},
				searching: function () {
					return wc_enhanced_select_params.i18n_searching;
				},
			};

			var language = { language: formatString };

			return language;
		}
	}

	$( function () {
		wcf_flows_search_init();
	} );
} )( jQuery );
