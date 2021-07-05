<?php
/**
 * Dynamic Thank you css.
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$output = "
	
.wcf-thankyou-wrap{
		color: {$text_color};
		font-family: {$text_font_family};
		max-width:{$container_width}px;
		font-size: {$text_font_size}px;
	}

	.woocommerce-order h2.woocommerce-column__title, 
	.woocommerce-order h2.woocommerce-order-details__title, 
	.woocommerce-order .woocommerce-thankyou-order-received,
	.woocommerce-order-details h2,
	.woocommerce-order h2.wc-bacs-bank-details-heading,
	.woocommerce-order h2.woocommerce-order-downloads__title {
		color: {$heading_text_color};
		font-family: {$heading_font_family};
		font-weight: {$heading_font_weight};
	}

	.woocommerce-order ul.order_details,
	.woocommerce-order .woocommerce-order-details,
	.woocommerce-order .woocommerce-customer-details,
	.woocommerce-order .woocommerce-bacs-bank-details,
	.woocommerce-order .woocommerce-order-downloads{
		background-color: {$section_bg_color}
	}
	img.emoji, img.wp-smiley {}
	";

if ( 'no' == $show_order_review ) {
	$output .= '
		.woocommerce-order ul.order_details{
			display: none;
		}
		';
}

if ( 'no' == $show_order_details ) {
	$output .= '
		.woocommerce-order .woocommerce-order-details{
			display: none;
		}
		';
}

if ( 'no' == $show_billing_details ) {
	$output .= '
		.woocommerce-order .woocommerce-customer-details .woocommerce-column--billing-address{
			display: none;
		}
		.woocommerce-order .woocommerce-customer-details .woocommerce-column--shipping-address{
			float:left;
		}
		';
}

if ( 'no' == $show_shipping_details ) {
	$output .= '
		.woocommerce-order .woocommerce-customer-details .woocommerce-column--shipping-address{
			display: none;
		}
		';
}

if ( 'no' == $show_billing_details && 'no' == $show_shipping_details ) {
	$output .= '
		.woocommerce-order .woocommerce-customer-details{
			display: none;
		}
		';
}
