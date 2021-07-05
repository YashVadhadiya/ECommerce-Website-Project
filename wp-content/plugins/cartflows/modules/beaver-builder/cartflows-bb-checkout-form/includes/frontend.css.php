<?php
/**
 * BB Checkout Form Module front-end CSS php file.
 *
 * @package cartflows
 */

global $post;

?>

#fl-field-checkout_layout .cartflows-bb-link,
#fl-field-input_skins .cartflows-bb-link {
	color: #0086b0;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce .woocommerce-checkout .product-name .remove:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #payment input[type=checkbox]:checked:before,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce .woocommerce-shipping-fields [type="checkbox"]:checked:before,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-info::before,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-message::before,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce a,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-steps .wcf-current .step-name,
body .wcf-pre-checkout-offer-wrapper .wcf-content-main-head .wcf-content-modal-title .wcf_first_name {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->global_primary_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce .woocommerce-checkout .product-name .remove:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #payment input[type=checkbox]:focus, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce .woocommerce-shipping-fields [type="checkbox"]:focus,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #payment input[type=radio]:checked:focus,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #payment input[type=radio]:not(:checked):focus,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.login .button:hover, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #payment #place_order:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-note,
body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn {
	border-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->global_primary_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #payment input[type=radio]:checked:before,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.login .button:hover, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #payment #place_order:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step  .wcf-embed-checkout-form-steps .step-one.wcf-current:before,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step  .wcf-embed-checkout-form-steps .step-two.wcf-current:before,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-steps .steps.wcf-current:before,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-note,
body .wcf-pre-checkout-offer-wrapper .wcf-nav-bar-step.active .wcf-progress-nav-step,
body .wcf-pre-checkout-offer-wrapper .wcf-nav-bar-step.active .wcf-nav-bar-step-line:before, 
body .wcf-pre-checkout-offer-wrapper .wcf-nav-bar-step.active .wcf-nav-bar-step-line:after {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->global_primary_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-note:before {
	border-top-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->global_primary_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form form.checkout_coupon .button,
body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->global_primary_color ); ?>;
	color: #fff;
}



.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form #payment .woocommerce-privacy-policy-text p {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->global_text_color ); ?>;
}

<?php
if ( class_exists( 'FLBuilderCSS' ) ) {
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'global_typography',
			'selector'     => ".fl-node-$id .cartflows-bb__checkout-form .wcf-embed-checkout-form",
		)
	);
}
?>

.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form .woocommerce h3,
.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form .woocommerce h3 span,
.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form .woocommerce-checkout #order_review_heading,
.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-steps .wcf-current .step-name {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->heading_color ); ?>;
}

<?php
if ( class_exists( 'FLBuilderCSS' ) ) {
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'heading_typography',
			'selector'     => ".fl-node-$id .cartflows-bb__checkout-form .wcf-embed-checkout-form .woocommerce h3,
            .fl-node-$id .cartflows-bb__checkout-form .wcf-embed-checkout-form .woocommerce h3 span,
            .fl-node-$id .cartflows-bb__checkout-form .wcf-embed-checkout-form .woocommerce-checkout #order_review_heading,
            .fl-node-$id .cartflows-bb__checkout-form .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-steps .step-name,
            .fl-node-$id .wcf-embed-checkout-form .woocommerce .col2-set .col-1 h3, 
            .fl-node-$id .wcf-embed-checkout-form .woocommerce .col2-set .col-2 h3",
		)
	);
}
?>

<?php
if ( class_exists( 'FLBuilderCSS' ) ) {
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'input_text_typography',
			'selector'     => ".fl-node-$id .wcf-embed-checkout-form .woocommerce form .form-row input.input-text, .fl-node-$id .wcf-embed-checkout-form .woocommerce form .form-row textarea,
            .fl-node-$id .wcf-embed-checkout-form .select2-container--default .select2-selection--single,
            .fl-node-$id .wcf-embed-checkout-form .woocommerce form .form-row select.select,
            .fl-node-$id .wcf-embed-checkout-form .woocommerce .col2-set .col-1, 
            .fl-node-$id .wcf-embed-checkout-form .woocommerce .col2-set .col-2,
            .fl-node-$id .wcf-embed-checkout-form .woocommerce form p.form-row label,
            .fl-node-$id .wcf-embed-checkout-form .woocommerce #payment [type='radio']:checked + label,
            .fl-node-$id .wcf-embed-checkout-form .woocommerce #payment [type='radio']:not(:checked) + label,
			.fl-node-$id .wcf-embed-checkout-form .woocommerce form .form-row select,
			.fl-node-$id .wcf-embed-checkout-form .woocommerce #order_review .wcf-custom-coupon-field input[type='text']",
		)
	);
}
?>

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout label,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form p.form-row label {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->label_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form #order_review .wcf-custom-coupon-field input[type="text"],
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row input.input-text,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row textarea,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .select2-container--default .select2-selection--single,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row select.select,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row select {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->input_bgcolor ); ?>;
}

.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form #order_review .wcf-custom-coupon-field input[type="text"],
.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form .woocommerce form .form-row input.input-text,
.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form .woocommerce form .form-row textarea,
.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form .select2-container--default .select2-selection--single,
.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form .woocommerce form .form-row select,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row select,
.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form ::placeholder,
.fl-node-<?php echo $id; ?> .cartflows-bb__checkout-form .wcf-embed-checkout-form ::-webkit-input-placeholder {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->input_color ); ?> !important;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form #order_review .wcf-custom-coupon-field input[type="text"],
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row input.input-text,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row textarea,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .select2-container--default .select2-selection--single,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row select.select,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row select {
	border-radius: <?php echo ( '' != $settings->input_border_radius ) ? $settings->input_border_radius : '0'; ?>px;
}

<?php if ( 'none' !== $settings->input_border_style ) { ?>
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form #order_review .wcf-custom-coupon-field input[type="text"],
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row input.input-text,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row textarea,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .select2-container--default .select2-selection--single,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row select.select,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row select {
		border-style: <?php echo ( '' != $settings->input_border_style ) ? $settings->input_border_style : 'solid'; ?>;
		border-width: <?php echo ( '' != $settings->input_border_width ) ? $settings->input_border_width : '1'; ?>px;
		border-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->input_border_color ); ?>;
	}

<?php } ?>

<?php
if ( class_exists( 'FLBuilderCSS' ) ) {
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $settings,
			'setting_name' => 'button_typography',
			'selector'     => ".fl-node-$id .wcf-embed-checkout-form .woocommerce #order_review button,
			.fl-node-$id .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, 
			.fl-node-$id .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small,
			.fl-node-$id .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, 
			.fl-node-$id .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button,
			.fl-node-$id .wcf-embed-checkout-form form.checkout_coupon .button,
			.fl-node-$id .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button,
			body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn",
		)
	);
}
?>

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form form.checkout_coupon .button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button,
body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->button_text_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form form.checkout_coupon .button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button,
body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->button_bg_color ); ?>;
}

<?php // Button text hover color. ?>

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.login .button:hover, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #payment #place_order:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form form.checkout_coupon .button:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button:hover,
body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn:hover {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->button_text_hover_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.login .button:hover, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #payment #place_order:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form form.checkout_coupon .button:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button:hover,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button:hover,
body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn:hover {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->button_bg_hover_color ); ?>;
	border-color:  <?php echo FLBuilderColor::hex_or_rgb( $settings->button_border_hover_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form form.checkout_coupon .button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button,
body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn {
	border-radius: <?php echo ( '' != $settings->button_border_radius ) ? $settings->button_border_radius : '0'; ?>px;
}

<?php if ( 'none' != $settings->button_border_style ) { ?>

	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, 
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, 
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form form.checkout_coupon .button,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button,
	body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn {
		border-style: <?php echo ( '' != $settings->button_border_style ) ? $settings->button_border_style : 'solid'; ?>;
		border-width: <?php echo ( '' != $settings->button_border_width ) ? $settings->button_border_width : '0'; ?>px;
		border-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->button_border_color ); ?>;
	}

<?php } else { ?>

	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, 
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, 
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form form.checkout_coupon .button,
	.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button,
	body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn {
		border-width: 0px !important;
	}

<?php } ?>

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout #payment,
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout #payment label, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout #payment label a {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->payment_section_text_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout #payment div.payment_box {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->payment_section_desc_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout #payment ul.payment_methods {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->payment_section_bg_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout #payment div.payment_box {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->payment_info_bg_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form #add_payment_method #payment div.payment_box::before, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-cart #payment div.payment_box::before, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout #payment div.payment_box::before {
	border-bottom-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->payment_info_bg_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout #payment ul.payment_methods {
	border-radius: <?php echo ( '' != $settings->payment_section_border_radius ) ? $settings->payment_section_border_radius : '0'; ?>px;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout #payment ul.payment_methods {
	padding-top: <?php echo ( '' != $settings->payment_section_padding_dimension_top ) ? $settings->payment_section_padding_dimension_top : ''; ?>px;
	padding-bottom: <?php echo ( '' != $settings->payment_section_padding_dimension_bottom ) ? $settings->payment_section_padding_dimension_bottom : ''; ?>px;
	padding-left: <?php echo ( '' != $settings->payment_section_padding_dimension_left ) ? $settings->payment_section_padding_dimension_left : ''; ?>px;
	padding-right: <?php echo ( '' != $settings->payment_section_padding_dimension_right ) ? $settings->payment_section_padding_dimension_right : ''; ?>px;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout #payment ul.payment_methods {
	margin-top: <?php echo ( '' != $settings->payment_section_margin_dimension_top ) ? $settings->payment_section_margin_dimension_top : ''; ?>px;
	margin-bottom: <?php echo ( '' != $settings->payment_section_margin_dimension_bottom ) ? $settings->payment_section_margin_dimension_bottom : ''; ?>px;
	margin-left: <?php echo ( '' != $settings->payment_section_margin_dimension_left ) ? $settings->payment_section_margin_dimension_left : ''; ?>px;
	margin-right: <?php echo ( '' != $settings->payment_section_margin_dimension_right ) ? $settings->payment_section_margin_dimension_right : ''; ?>px;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce-checkout .woocommerce-invalid label, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form p.form-row.woocommerce-invalid label,
.fl-node-<?php echo $id; ?> .woocommerce form .form-row.woocommerce-invalid label {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->field_label_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .select2-container--default.field-required .select2-selection--single, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row input.input-text.field-required, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row textarea.input-text.field-required, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review .input-text.field-required
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row.woocommerce-invalid .select2-container, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row.woocommerce-invalid input.input-text, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row.woocommerce-invalid select {
	border-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->error_field_border_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce .woocommerce-error, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce .woocommerce-NoticeGroup .woocommerce-error, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce .woocommerce-notices-wrapper .woocommerce-error {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->error_text_color ); ?>;
	border-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->error_border_color ); ?>;
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->error_bg_color ); ?>;
}

.fl-node-<?php echo $id; ?> .woocommerce form .form-row.woocommerce-invalid label {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->field_label_color ); ?>;
}

.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .select2-container--default.field-required .select2-selection--single, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row input.input-text.field-required, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row textarea.input-text.field-required, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce #order_review .input-text.field-required
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row.woocommerce-invalid .select2-container, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row.woocommerce-invalid input.input-text, 
.fl-node-<?php echo $id; ?> .wcf-embed-checkout-form .woocommerce form .form-row.woocommerce-invalid select {
	border-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->error_field_border_color ); ?>;
}

