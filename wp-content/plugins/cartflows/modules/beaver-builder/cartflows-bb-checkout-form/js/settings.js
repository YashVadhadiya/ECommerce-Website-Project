(function($){
	FLBuilder.registerModuleHelper(
		'cartflows-bb-checkout-form', 
		{
			init: function() {
				var form        = $('.fl-builder-settings'),
                layout   = form.find('select[name=checkout_layout]');
                
                form.find('#fl-field-checkout_layout .fl-field-description').hide();
                form.find('#fl-field-input_skins .fl-field-description').hide();

				// Init validation events.
				this._layout_styleChanged();

				// Validation events.
                layout.on('change',  $.proxy( this._layout_styleChanged, this ) );
                
                var module_id = $( '.fl-module-cartflows-bb-checkout-form' ).data( 'node' );

                var $module_wrapper = $( '.fl-node-' + module_id + ' .cartflows-bb__checkout-form' );

                var settings_data = $module_wrapper.data( 'settings-data' );

                var is_offer_enable = CartFlowsBBVars.wcf_pre_checkout_offer;
                var enable_product_options = CartFlowsBBVars.wcf_enable_product_options;
                var enable_order_bump = CartFlowsBBVars.wcf_order_bump;

                if( 'yes' === is_offer_enable ) {
                    
                    form.find( "#fl-field-pre_checkout_enable_preview .fl-field-label" ).show();
                    form.find( "#fl-field-pre_checkout_enable_preview select" ).show();
                    form.find( "#fl-field-pre_checkout_enable_preview .fl-field-description" ).hide();

                    form.find( "#fl-field-checkout_offer_subtitle_text" ).show();
                    form.find( "#fl-field-checkout_offer_product_name" ).show();
                    form.find( "#fl-field-checkout_offer_product_desc" ).show();
                    form.find( "#fl-field-checkout_offer_accept_button_text" ).show();
                    form.find( "#fl-field-checkout_offer_title_text" ).show();
                    form.find( "#fl-field-checkout_offer_skip_button_text" ).show();

                    form.find('#fl-builder-settings-section-pre_checkout_offer_style').show();

                } else {

                    form.find( "#fl-field-pre_checkout_enable_preview .fl-field-label" ).hide();
                    form.find( "#fl-field-pre_checkout_enable_preview select" ).hide();
                    form.find( "#fl-field-pre_checkout_enable_preview .fl-field-description" ).show();

                    form.find( "#fl-field-checkout_offer_subtitle_text" ).hide();
                    form.find( "#fl-field-checkout_offer_product_name" ).hide();
                    form.find( "#fl-field-checkout_offer_product_desc" ).hide();
                    form.find( "#fl-field-checkout_offer_title_text" ).hide();
                    form.find( "#fl-field-checkout_offer_accept_button_text" ).hide();
                    form.find( "#fl-field-checkout_offer_skip_button_text" ).hide();

                    form.find('#fl-builder-settings-section-pre_checkout_offer_style').hide();
                }

                if( 'yes' === enable_product_options ) {

                    form.find( "#fl-field-product_options_position .fl-field-label" ).show();
                    form.find( "#fl-field-product_options_position select" ).show();
                    form.find( "#fl-field-product_options_position .fl-field-description" ).hide();

                    form.find( "#fl-field-product_options_skin" ).show();
                    form.find( "#fl-field-product_options_images" ).show();
                    form.find( "#fl-field-product_option_section_title_text" ).show();

                    form.find('#fl-builder-settings-section-product_style').show();
                    
                } else {

                    form.find( "#fl-field-product_options_position .fl-field-label" ).hide();
                    form.find( "#fl-field-product_options_position select" ).hide();
                    form.find( "#fl-field-product_options_position .fl-field-description" ).show();

                    form.find( "#fl-field-product_options_skin" ).hide();
                    form.find( "#fl-field-product_options_images" ).hide();
                    form.find( "#fl-field-product_option_section_title_text" ).hide();

                    form.find('#fl-builder-settings-section-product_style').hide();
                }

                if( 'yes' === enable_order_bump ) {

                    var separator = '<hr style="margin: 15px 0px 5px">'
                    // Option for description.
                    form.find( "#fl-field-order_bump_position .fl-field-label" ).show();
                    form.find( "#fl-field-order_bump_position select" ).show();
                    form.find( "#fl-field-order_bump_position .fl-field-description" ).hide();

                    form.find( "#fl-field-order_bump_checkbox_label" ).show();
                    form.find( "#fl-field-order_bump_highlight_text" ).show();
                    form.find( "#fl-field-order_bump_product_description" ).show();
                    form.find( "#fl-field-order_bump_checkbox_arrow" ).show();
                    form.find( "#fl-field-order_bump_checkbox_arrow_animation" ).show();

                    form.find('#fl-builder-settings-section-order_bump_style').show();

                    form.find( "#fl-field-order_bump_skin" ).after(separator);
                    form.find( "#fl-field-order_bump_checkbox_arrow_animation" ).after(separator);
                    form.find( "#fl-field-order_bump_desc_color" ).after(separator);
                } else {

                    form.find( "#fl-field-order_bump_position .fl-field-label" ).hide();
                    form.find( "#fl-field-order_bump_position select" ).hide();
                    form.find( "#fl-field-order_bump_position .fl-field-description" ).show();

                    form.find( "#fl-field-order_bump_checkbox_label" ).hide();
                    form.find( "#fl-field-order_bump_highlight_text" ).hide();
                    form.find( "#fl-field-order_bump_product_description" ).hide();
                    form.find( "#fl-field-order_bump_checkbox_arrow" ).hide();
                    form.find( "#fl-field-order_bump_checkbox_arrow_animation" ).hide();
                    
                    form.find('#fl-builder-settings-section-order_bump_style').hide();
                }
				
			},
			_layout_styleChanged: function() {
				var form        = $('.fl-builder-settings'),
				layout   = form.find('select[name=checkout_layout]').val();
				
				if ( 'two-step' == layout ) {
					// form.find( "#fl-field-width" ).hide();
					form.find('#fl-builder-settings-section-two_step').show();
					form.find('#fl-builder-settings-section-two_step_style').show();
				} else {
					form.find('#fl-builder-settings-section-two_step').hide();
					form.find('#fl-builder-settings-section-two_step_style').hide();
				}
			},

		}
	);

})(jQuery);