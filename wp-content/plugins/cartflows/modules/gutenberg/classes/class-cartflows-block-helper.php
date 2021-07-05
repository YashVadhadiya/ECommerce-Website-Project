<?php
/**
 * Cartflows Block Helper.
 *
 * @package Cartflows
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Cartflows_Block_Helper' ) ) {

	/**
	 * Class Cartflows_Block_Helper.
	 */
	class Cartflows_Block_Helper {

		/**
		 * Get Next Step Button CSS
		 *
		 * @since x.x.x
		 * @param array  $attr The block attributes.
		 * @param string $id The selector ID.
		 * @return array The Widget List.
		 */
		public static function get_next_step_button_css( $attr, $id ) {

			$defaults = Cartflows_Gb_Helper::$block_list['wcfb/next-step-button']['attributes'];

			$attr = array_merge( $defaults, (array) $attr );

			$bg_type      = ( isset( $attr['backgroundType'] ) ) ? $attr['backgroundType'] : 'none';
			$overlay_type = ( isset( $attr['overlayType'] ) ) ? $attr['overlayType'] : 'none';

			$m_selectors = array();
			$t_selectors = array();

			$selectors = array(

				' .wpcf__next-step-button-wrap'       => array(
					'text-align' => $attr['align'],
				),
				' .wpcf__next-step-button-link'       => array(
					'text-align'       => $attr['textAlignment'],
					'color'            => $attr['textColor'],
					'background-color' => $attr['backgroundColor'],
					'border-style'     => $attr['borderStyle'],
					'border-color'     => $attr['borderColor'],
					'border-width'     => Cartflows_Gb_Helper::get_css_value( $attr['borderWidth'], 'px' ),
					'border-radius'    => Cartflows_Gb_Helper::get_css_value( $attr['borderRadius'], 'px' ),
					'padding-top'      => Cartflows_Gb_Helper::get_css_value( $attr['vPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'padding-bottom'   => Cartflows_Gb_Helper::get_css_value( $attr['vPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'padding-left'     => Cartflows_Gb_Helper::get_css_value( $attr['hPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'padding-right'    => Cartflows_Gb_Helper::get_css_value( $attr['hPaddingDesktop'], $attr['paddingTypeDesktop'] ),
				),
				' .wpcf__next-step-button-link:hover' => array(
					'background-color' => $attr['buttonHoverColor'],
					'color'            => $attr['textHoverColor'],
					'border-color'     => $attr['borderHoverColor'],
				),
				' .wpcf__next-step-button-link .wpcf__next-step-button-content-wrap .wpcf__next-step-button-title-wrap' => array(
					'text-transform' => $attr['titletextTransform'],
					'letter-spacing' => Cartflows_Gb_Helper::get_css_value( $attr['titleletterSpacing'], 'px' ),
				),
				' .wpcf__next-step-button-link .wpcf__next-step-button-content-wrap .wpcf__next-step-button-sub-title' => array(
					'margin-top'     => Cartflows_Gb_Helper::get_css_value( $attr['titleBottomSpacing'], 'px' ),
					'text-transform' => $attr['subtitletextTransform'],
					'letter-spacing' => Cartflows_Gb_Helper::get_css_value( $attr['subtitleletterSpacing'], 'px' ),
				),
				' .wpcf__next-step-button-icon svg'   => array(
					'width'  => Cartflows_Gb_Helper::get_css_value( $attr['iconSize'], 'px' ),
					'height' => Cartflows_Gb_Helper::get_css_value( $attr['iconSize'], 'px' ),
					'fill'   => $attr['iconColor'],
				),
				' .wpcf__next-step-button-link:hover .wpcf__next-step-button-icon svg' => array(
					'fill' => $attr['iconHoverColor'],
				),
			);
			if ( 'full' === $attr['align'] ) {
				$selectors[' a.wpcf__next-step-button-link'] = array(
					'width'           => '100%',
					'justify-content' => 'center',
				);
			}
			if ( 'color' == $bg_type ) {
				$selectors[' .wpcf__next-step-button-link'] = array(
					'opacity' => ( isset( $attr['backgroundOpacity'] ) && '' !== $attr['backgroundOpacity'] ) ? $attr['backgroundOpacity'] / 100 : '',
				);
			}

			if ( 'gradient' == $bg_type ) {
				$selectors[' .wpcf__next-step-button-link'] = array(
					'border-style'   => $attr['borderStyle'],
					'border-color'   => $attr['borderColor'],
					'border-width'   => Cartflows_Gb_Helper::get_css_value( $attr['borderWidth'], 'px' ),
					'border-radius'  => Cartflows_Gb_Helper::get_css_value( $attr['borderRadius'], 'px' ),
					'padding-top'    => Cartflows_Gb_Helper::get_css_value( $attr['vPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'padding-bottom' => Cartflows_Gb_Helper::get_css_value( $attr['vPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'padding-left'   => Cartflows_Gb_Helper::get_css_value( $attr['hPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'padding-right'  => Cartflows_Gb_Helper::get_css_value( $attr['hPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'color'          => $attr['textColor'],
				);
			}

			$position = str_replace( '-', ' ', $attr['backgroundPosition'] );

			if ( 'image' == $bg_type ) {
				$selectors[' .wpcf__next-step-button-link'] = array(
					'opacity'               => ( isset( $attr['backgroundOpacity'] ) && '' !== $attr['backgroundOpacity'] ) ? $attr['backgroundOpacity'] / 100 : 0,
					'background-color'      => $attr['backgroundImageColor'],
					'border-style'          => $attr['borderStyle'],
					'border-color'          => $attr['borderColor'],
					'border-width'          => Cartflows_Gb_Helper::get_css_value( $attr['borderWidth'], 'px' ),
					'border-radius'         => Cartflows_Gb_Helper::get_css_value( $attr['borderRadius'], 'px' ),
					'padding-top'           => Cartflows_Gb_Helper::get_css_value( $attr['vPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'padding-bottom'        => Cartflows_Gb_Helper::get_css_value( $attr['vPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'padding-left'          => Cartflows_Gb_Helper::get_css_value( $attr['hPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'padding-right'         => Cartflows_Gb_Helper::get_css_value( $attr['hPaddingDesktop'], $attr['paddingTypeDesktop'] ),
					'color'                 => $attr['textColor'],
					'background-image'      => ( isset( $attr['backgroundImage'] ) && isset( $attr['backgroundImage']['url'] ) ) ? "url('" . $attr['backgroundImage']['url'] . "' )" : null,
					'background-position'   => $position,
					'background-attachment' => $attr['backgroundAttachment'],
					'background-repeat'     => $attr['backgroundRepeat'],
					'background-size'       => $attr['backgroundSize'],
				);
			} elseif ( 'gradient' === $bg_type ) {

				$selectors[' .wpcf__next-step-button-link']['background-color'] = 'transparent';
				$selectors[' .wpcf__next-step-button-link']['opacity']          = ( isset( $attr['backgroundOpacity'] ) && '' !== $attr['backgroundOpacity'] ) ? $attr['backgroundOpacity'] / 100 : '';
				if ( $attr['gradientValue'] ) {
					$selectors[' .wpcf__next-step-button-link']['background-image'] = $attr['gradientValue'];

				} else {
					if ( 'linear' === $attr['gradientType'] ) {

						$selectors[' .wpcf__next-step-button-link']['background-image'] = "linear-gradient(${ $attr['gradientAngle'] }deg, ${ $attr['gradientColor1'] } ${ $attr['gradientLocation1'] }%, ${ $attr['gradientColor2'] } ${ $attr['gradientLocation2'] }%)";
					} else {

						$selectors[' .wpcf__next-step-button-link']['background-image'] = "radial-gradient( at ${ $attr['gradientPosition'] }, ${ $attr['gradientColor1'] } ${ $attr['gradientLocation1'] }%, ${ $attr['gradientColor2'] } ${ $attr['gradientLocation2'] }%)";
					}
				}
			}

			$margin_type = ( 'after_title' === $attr['iconPosition'] || 'after_title_sub_title' === $attr['iconPosition'] ) ? 'margin-left' : 'margin-right';

			$selectors[' .wpcf__next-step-button-icon svg'][ $margin_type ] = Cartflows_Gb_Helper::get_css_value( $attr['iconSpacing'], 'px' );

			$t_selectors = array(
				' .wpcf__next-step-button-wrap' => array(
					'text-align' => $attr['talign'],
				),
				' .wpcf__next-step-button-link' => array(
					'padding-top'    => Cartflows_Gb_Helper::get_css_value( $attr['vPaddingTablet'], $attr['paddingTypeTablet'] ),
					'padding-bottom' => Cartflows_Gb_Helper::get_css_value( $attr['vPaddingTablet'], $attr['paddingTypeTablet'] ),
					'padding-left'   => Cartflows_Gb_Helper::get_css_value( $attr['hPaddingTablet'], $attr['paddingTypeTablet'] ),
					'padding-right'  => Cartflows_Gb_Helper::get_css_value( $attr['hPaddingTablet'], $attr['paddingTypeTablet'] ),
				),
			);

			$m_selectors = array(
				' .wpcf__next-step-button-wrap' => array(
					'text-align' => $attr['malign'],
				),
				' .wpcf__next-step-button-link' => array(
					'padding-top'    => Cartflows_Gb_Helper::get_css_value( $attr['vPaddingMobile'], $attr['paddingTypeMobile'] ),
					'padding-bottom' => Cartflows_Gb_Helper::get_css_value( $attr['vPaddingMobile'], $attr['paddingTypeMobile'] ),
					'padding-left'   => Cartflows_Gb_Helper::get_css_value( $attr['hPaddingMobile'], $attr['paddingTypeMobile'] ),
					'padding-right'  => Cartflows_Gb_Helper::get_css_value( $attr['hPaddingMobile'], $attr['paddingTypeMobile'] ),
				),
			);

			$combined_selectors = array(
				'desktop' => $selectors,
				'tablet'  => $t_selectors,
				'mobile'  => $m_selectors,
			);

			$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'title', ' .wpcf__next-step-button-link .wpcf__next-step-button-content-wrap .wpcf__next-step-button-title-wrap', $combined_selectors );
			$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'subTitle', ' .wpcf__next-step-button-link .wpcf__next-step-button-content-wrap .wpcf__next-step-button-sub-title', $combined_selectors );

			return Cartflows_Gb_Helper::generate_all_css( $combined_selectors, ' .cf-block-' . $id );
		}

			/**
			 * Get Order Detail Form Block CSS
			 *
			 * @since x.x.x
			 * @param array  $attr The block attributes.
			 * @param string $id The selector ID.
			 * @return array The Widget List.
			 */
		public static function get_order_detail_form_css( $attr, $id ) {

			$defaults     = Cartflows_Gb_Helper::$block_list['wcfb/order-detail-form']['attributes'];
			$bg_type      = ( isset( $attr['backgroundType'] ) ) ? $attr['backgroundType'] : 'none';
			$overlay_type = ( isset( $attr['overlayType'] ) ) ? $attr['overlayType'] : 'none';

			$attr = array_merge( $defaults, $attr );

			$t_selectors = array();
			$m_selectors = array();
			$selectors   = array();

			$order_overview            = ( $attr['orderOverview'] ) ? 'block' : 'none';
			$order_details             = ( $attr['orderDetails'] ) ? 'block' : 'none';
			$billing_address           = ( $attr['billingAddress'] ) ? 'block' : 'none';
			$shipping_address          = ( $attr['shippingAddress'] ) ? 'block' : 'none';
			$shipping_address_position = ( $attr['billingAddress'] ) ? 'right' : 'left';
			$customer_details          = ( $attr['billingAddress'] || $attr['shippingAddress'] ) ? 'block' : 'none';

			$selectors = array(
				// Genaral.
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order ul.order_details'       => array(
					'display' => $order_overview,
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order section.woocommerce-order-details'       => array(
					'display' => $order_details,
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details .woocommerce-column--billing-address'       => array(
					'display' => $billing_address,
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details .woocommerce-column--shipping-address'       => array(
					'display' => $shipping_address,
					'float'   => $shipping_address_position,
				),
				// Spacing.
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order p.woocommerce-thankyou-order-received'       => array(
					'margin-bottom' => Cartflows_Gb_Helper::get_css_value( $attr['headingBottomSpacing'], 'px' ),
				),
				' .wpcf__order-detail-form .woocommerce-order ul.order_details, .wpcf__order-detail-form .woocommerce-order .woocommerce-customer-details, .wpcf__order-detail-form .woocommerce-order .woocommerce-order-details, .wpcf__order-detail-form .woocommerce-order .woocommerce-order-downloads, .wpcf__order-detail-form .woocommerce-order .woocommerce-bacs-bank-details, .wpcf__order-detail-form .woocommerce-order-details.mollie-instructions'       => array(
					'margin-bottom' => Cartflows_Gb_Helper::get_css_value( $attr['sectionSpacing'], 'px' ),
				),
				// Heading.
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-thankyou-order-received'       => array(
					'text-align' => $attr['headingAlignment'],
					'color'      => $attr['headingColor'],
				),
				// Sections.
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order h2'       => array(
					'color' => $attr['sectionHeadingColor'],
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order, .wpcf__order-detail-form .woocommerce-order-downloads table.shop_table'       => array(
					'color' => $attr['sectionContentColor'],
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-overview.woocommerce-thankyou-order-details.order_details, .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details, .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details, .wpcf__order-detail-form .woocommerce-order-downloads'       => array(
					'background-color' => $attr['sectionBackgroundColor'],
				),
				// Order Overview.
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-overview.woocommerce-thankyou-order-details.order_details'       => array(
					'color'            => $attr['orderOverviewTextColor'],
					'background-color' => $attr['orderOverviewBackgroundColor'],
				),
				// Downloads.
				' .wpcf__order-detail-form .woocommerce-order h2.woocommerce-order-downloads__title, .wpcf__order-detail-form .woocommerce-order .woocommerce-order-downloads h2.woocommerce-order-downloads__title'       => array(
					'color' => $attr['downloadHeadingColor'],
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-downloads table.shop_table'       => array(
					'color' => $attr['downloadContentColor'],
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-downloads'       => array(
					'background-color' => $attr['downloadBackgroundColor'],
				),
				// Order Details.
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details .woocommerce-order-details__title'       => array(
					'color' => $attr['orderDetailHeadingColor'],
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details .woocommerce-table'       => array(
					'color' => $attr['orderDetailContentColor'],
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details'       => array(
					'background-color' => $attr['orderDetailBackgroundColor'],
				),
				// Customer Details.
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details .woocommerce-column__title'       => array(
					'color' => $attr['customerDetailHeadingColor'],
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details address'       => array(
					'color' => $attr['customerDetailContentColor'],
				),
				' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details'       => array(
					'background-color' => $attr['customerDetailBackgroundColor'],
					'display'          => $customer_details,
				),

			);

				$selectors[' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-overview.woocommerce-thankyou-order-details.order_details, .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details, .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details, .wpcf__order-detail-form .woocommerce-order-downloads'] = array(
					'opacity'          => ( isset( $attr['backgroundOpacity'] ) && '' !== $attr['backgroundOpacity'] ) ? $attr['backgroundOpacity'] / 100 : '',
					'background-color' => $attr['backgroundColor'],
				);

				$position = str_replace( '-', ' ', $attr['backgroundPosition'] );

				if ( 'image' == $bg_type ) {
					$selectors[' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-overview.woocommerce-thankyou-order-details.order_details, .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details, .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details, .wpcf__order-detail-form .woocommerce-order-downloads'] = array(
						'opacity'               => ( isset( $attr['backgroundOpacity'] ) && '' !== $attr['backgroundOpacity'] ) ? $attr['backgroundOpacity'] / 100 : 0,
						'background-color'      => $attr['backgroundImageColor'],
						'background-image'      => ( isset( $attr['backgroundImage'] ) && isset( $attr['backgroundImage']['url'] ) ) ? "url('" . $attr['backgroundImage']['url'] . "' )" : null,
						'background-position'   => $position,
						'background-attachment' => $attr['backgroundAttachment'],
						'background-repeat'     => $attr['backgroundRepeat'],
						'background-size'       => $attr['backgroundSize'],
					);
				}
				// Order review.
				$selectors[' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-overview.woocommerce-thankyou-order-details.order_details'] = array(
					'opacity'          => ( isset( $attr['odbackgroundOpacity'] ) && '' !== $attr['odbackgroundOpacity'] ) ? $attr['odbackgroundOpacity'] / 100 : 0.79,
					'background-color' => $attr['odbackgroundColor'],
				);

				$position = str_replace( '-', ' ', $attr['backgroundPosition'] );

				if ( 'image' == $attr['odbackgroundType'] ) {
					$selectors[' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-overview.woocommerce-thankyou-order-details.order_details'] = array(
						'opacity'               => ( isset( $attr['odbackgroundOpacity'] ) && '' !== $attr['odbackgroundOpacity'] ) ? $attr['odbackgroundOpacity'] / 100 : 0,
						'background-color'      => $attr['odbackgroundImageColor'],
						'background-image'      => ( isset( $attr['odbackgroundImage'] ) && isset( $attr['odbackgroundImage']['url'] ) ) ? "url('" . $attr['odbackgroundImage']['url'] . "' )" : null,
						'background-position'   => $position,
						'background-attachment' => $attr['odbackgroundAttachment'],
						'background-repeat'     => $attr['odbackgroundRepeat'],
						'background-size'       => $attr['odbackgroundSize'],
					);
				}
				// Downloads.
				$selectors[' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-downloads'] = array(
					'opacity'          => ( isset( $attr['dbackgroundOpacity'] ) && '' !== $attr['dbackgroundOpacity'] ) ? $attr['dbackgroundOpacity'] / 100 : 0.79,
					'background-color' => $attr['dbackgroundType'],
				);

				$dposition = str_replace( '-', ' ', $attr['dbackgroundPosition'] );

				if ( 'image' == $attr['dbackgroundType'] ) {
					$selectors[' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-downloads'] = array(
						'opacity'               => ( isset( $attr['dbackgroundOpacity'] ) && '' !== $attr['dbackgroundOpacity'] ) ? $attr['dbackgroundOpacity'] / 100 : 0,
						'background-color'      => $attr['dbackgroundImageColor'],
						'background-image'      => ( isset( $attr['dbackgroundImage'] ) && isset( $attr['dbackgroundImage']['url'] ) ) ? "url('" . $attr['dbackgroundImage']['url'] . "' )" : null,
						'background-position'   => $dposition,
						'background-attachment' => $attr['dbackgroundAttachment'],
						'background-repeat'     => $attr['dbackgroundRepeat'],
						'background-size'       => $attr['dbackgroundSize'],
					);
				}
				// Order details.
				$selectors[' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details'] = array(
					'opacity'          => ( isset( $attr['odetailbackgroundOpacity'] ) && '' !== $attr['odetailbackgroundOpacity'] ) ? $attr['odetailbackgroundOpacity'] / 100 : 0.79,
					'background-color' => $attr['odetailbackgroundColor'],
				);

				$odetailposition = str_replace( '-', ' ', $attr['odetailbackgroundPosition'] );

				if ( 'image' == $attr['odetailbackgroundType'] ) {
					$selectors[' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details'] = array(
						'opacity'               => ( isset( $attr['odetailbackgroundOpacity'] ) && '' !== $attr['odetailbackgroundOpacity'] ) ? $attr['odetailbackgroundOpacity'] / 100 : 0,
						'background-color'      => $attr['odetailbackgroundImageColor'],
						'background-image'      => ( isset( $attr['odetailbackgroundImage'] ) && isset( $attr['odetailbackgroundImage']['url'] ) ) ? "url('" . $attr['odetailbackgroundImage']['url'] . "' )" : null,
						'background-position'   => $odetailposition,
						'background-attachment' => $attr['odetailbackgroundAttachment'],
						'background-repeat'     => $attr['odetailbackgroundRepeat'],
						'background-size'       => $attr['odetailbackgroundSize'],
					);
				}
				// Customer details.
				$selectors[' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details'] = array(
					'opacity'          => ( isset( $attr['cdetailsbackgroundOpacity'] ) && '' !== $attr['cdetailsbackgroundOpacity'] ) ? $attr['cdetailsbackgroundOpacity'] / 100 : 0.79,
					'background-color' => $attr['cdetailbackgroundColor'],
				);

				$cdetailposition = str_replace( '-', ' ', $attr['cdetailbackgroundPosition'] );

				if ( 'image' == $attr['cdetailbackgroundType'] ) {
					$selectors[' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details'] = array(
						'opacity'               => ( isset( $attr['cdetailsbackgroundOpacity'] ) && '' !== $attr['cdetailsbackgroundOpacity'] ) ? $attr['cdetailsbackgroundOpacity'] / 100 : 0,
						'background-color'      => $attr['cdetailsbackgroundImageColor'],
						'background-image'      => ( isset( $attr['cdetailbackgroundImage'] ) && isset( $attr['cdetailbackgroundImage']['url'] ) ) ? "url('" . $attr['cdetailbackgroundImage']['url'] . "' )" : null,
						'background-position'   => $cdetailposition,
						'background-attachment' => $attr['cdetailbackgroundAttachment'],
						'background-repeat'     => $attr['cdetailbackgroundRepeat'],
						'background-size'       => $attr['cdetailbackgroundSize'],
					);
				}

				$combined_selectors = array(
					'desktop' => $selectors,
					'tablet'  => $t_selectors,
					'mobile'  => $m_selectors,
				);

				// Heading.
				$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'heading', ' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-thankyou-order-received', $combined_selectors );
				// Sections.
				$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'sectionHeading', ' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order h2', $combined_selectors );
				$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'sectionContent', ' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-overview.woocommerce-thankyou-order-details.order_details li, .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order p, .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details .woocommerce-table, .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details address, .wpcf__order-detail-form .woocommerce-order-downloads table.shop_table', $combined_selectors );
				// Order Overview.
				$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'orderOverview', ' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-overview.woocommerce-thankyou-order-details.order_details li', $combined_selectors );
				// Downloads.
				$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'downloadHeading', ' .wpcf__order-detail-form .woocommerce-order h2.woocommerce-order-downloads__title, .wpcf__order-detail-form .woocommerce-order .woocommerce-order-downloads h2.woocommerce-order-downloads__title', $combined_selectors );
				$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'downloadContent', ' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-downloads table.shop_table', $combined_selectors );
				// Order Details.
				$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'orderDetailHeading', ' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details .woocommerce-order-details__title', $combined_selectors );
				$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'orderDetailContent', ' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-order-details .woocommerce-table', $combined_selectors );
				// Customer Details.
				$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'customerDetailHeading', ' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details .woocommerce-column__title', $combined_selectors );
				$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'customerDetailContent', ' .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details address, .wpcf__order-detail-form .wcf-thankyou-wrap .woocommerce-order .woocommerce-customer-details address p', $combined_selectors );

				return Cartflows_Gb_Helper::generate_all_css( $combined_selectors, ' .cf-block-' . $id );
		}

			/**
			 * Get Checkout form CSS
			 *
			 * @since x.x.x
			 * @param array  $attr The block attributes.
			 * @param string $id The selector ID.
			 * @return array The Widget List.
			 */
		public static function get_checkout_form_css( $attr, $id ) {

			$defaults = Cartflows_Gb_Helper::$block_list['wcfb/checkout-form']['attributes'];

			$attr = array_merge( $defaults, (array) $attr );

			$bg_type      = ( isset( $attr['backgroundType'] ) ) ? $attr['backgroundType'] : 'none';
			$overlay_type = ( isset( $attr['overlayType'] ) ) ? $attr['overlayType'] : 'none';

			$box_shadow_position_css = $attr['boxShadowPosition'];

			if ( 'outset' === $attr['boxShadowPosition'] ) {
				$box_shadow_position_css = '';
			}

			$m_selectors = array();
			$t_selectors = array();

			$selectors = array(
				' .wcf-embed-checkout-form .woocommerce h3, .wcf-embed-checkout-form .woocommerce-checkout #order_review_heading, .wcf-embed-checkout-form .woocommerce h3, .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-steps .wcf-current .step-name' => array(
					'color' => $attr['headBgColor'],
				),
				' .wcf-embed-checkout-form .woocommerce #order_review button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button' => array(
					'color'            => $attr['buttonTextColor'],
					'border-style'     => $attr['buttonBorderStyle'],
					'border-width'     => Cartflows_Gb_Helper::get_css_value( $attr['buttonBorderWidth'], 'px' ),
					'border-color'     => $attr['buttonBorderColor'],
					'border-radius'    => Cartflows_Gb_Helper::get_css_value( $attr['buttonBorderRadius'], 'px' ),
					'background-color' => $attr['buttonBgColor'],
				),
				' .wcf-embed-checkout-form .woocommerce #payment #place_order:hover' => array(
					'color'            => $attr['buttonTextHoverColor'],
					'border-color'     => $attr['buttonBorderHoverColor'],
					'background-color' => $attr['buttonBgHoverColor'],
				),
				' .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small:hover' => array(
					'color'            => $attr['buttonTextHoverColor'],
					'border-color'     => $attr['buttonBorderHoverColor'],
					'background-color' => $attr['buttonBgHoverColor'],
				),
				' .wcf-embed-checkout-form .woocommerce-checkout #payment ul.payment_methods' => array(
					'background-color' => $attr['sectionbgColor'],
					'padding-top'      => Cartflows_Gb_Helper::get_css_value( $attr['sectionhrPadding'], 'px' ),
					'padding-right'    => Cartflows_Gb_Helper::get_css_value( $attr['sectionvrPadding'], 'px' ),
					'padding-bottom'   => Cartflows_Gb_Helper::get_css_value( $attr['sectionhrPadding'], 'px' ),
					'padding-left'     => Cartflows_Gb_Helper::get_css_value( $attr['sectionvrPadding'], 'px' ),
					'margin-top'       => Cartflows_Gb_Helper::get_css_value( $attr['sectionhrMargin'], 'px' ),
					'margin-right'     => Cartflows_Gb_Helper::get_css_value( $attr['sectionvrMargin'], 'px' ),
					'margin-bottom'    => Cartflows_Gb_Helper::get_css_value( $attr['sectionhrMargin'], 'px' ),
					'margin-left'      => Cartflows_Gb_Helper::get_css_value( $attr['sectionvrMargin'], 'px' ),
					'border-radius'    => Cartflows_Gb_Helper::get_css_value( $attr['sectionBorderRadius'], 'px' ),
				),
				' .wcf-embed-checkout-form .woocommerce-checkout #payment label a, .wcf-embed-checkout-form .woocommerce-checkout #payment label' => array(
					'color' => $attr['paymenttitleColor'],
				),
				' .wcf-embed-checkout-form #payment .woocommerce-privacy-policy-text p' => array(
					'color' => $attr['paymentdescriptionColor'],
				),
				' .wcf-embed-checkout-form .woocommerce-checkout #payment div.payment_box' => array(
					'background-color' => $attr['informationbgColor'],
					'color'            => $attr['paymentdescriptionColor'],
				),
				' .wcf-embed-checkout-form .woocommerce-checkout #payment div.payment_box::before' => array(
					'border-bottom-color' => $attr['informationbgColor'],
				),
				' .wcf-embed-checkout-form .woocommerce form p.form-row label' => array(
					'color' => $attr['fieldLabelColor'],
				),
				' .wcf-embed-checkout-form .woocommerce form .form-row input.input-text, .wcf-embed-checkout-form .woocommerce form .form-row select, .wcf-embed-checkout-form .woocommerce form .form-row textarea, .wcf-embed-checkout-form .select2-container--default .select2-selection--single, .wcf-embed-checkout-form #order_review .wcf-custom-coupon-field input[type="text"], .wcf-embed-checkout-form .woocommerce form .form-row input.input-text, .wcf-embed-checkout-form .woocommerce form .form-row textarea, .wcf-embed-checkout-form .select2-container--default .select2-selection--single, .wcf-embed-checkout-form .woocommerce form .form-row select.select, .wcf-embed-checkout-form .woocommerce form .form-row select' => array(
					'background-color' => $attr['fieldBgColor'],
					'border-radius'    => Cartflows_Gb_Helper::get_css_value( $attr['fieldBorderRadius'], 'px' ),
					'border-color'     => $attr['fieldBorderColor'],
					'border-style'     => $attr['fieldBorderStyle'],
					'border-width'     => Cartflows_Gb_Helper::get_css_value( $attr['fieldBorderWidth'], 'px' ),
				),
				' .wcf-embed-checkout-form .woocommerce form .form-row input.input-text, .wcf-embed-checkout-form .woocommerce form .form-row textarea, span#select2-shipping_country-container, span#select2-billing_country-container, .wcf-embed-checkout-form #order_review .wcf-custom-coupon-field input[type="text"], .wcf-embed-checkout-form .woocommerce form .form-row input.input-text, .wcf-embed-checkout-form .woocommerce form .form-row textarea, .wcf-embed-checkout-form .select2-container--default .select2-selection--single, .wcf-embed-checkout-form .woocommerce form .form-row select, .wcf-embed-checkout-form .woocommerce form .form-row select, .wcf-embed-checkout-form ::placeholder, .wcf-embed-checkout-form ::-webkit-input-placeholder, span#select2-shipping_state-container, span#select2-billing_state-container' => array(
					'color' => $attr['fieldInputColor'],
				),
				' .woocommerce-NoticeGroup.woocommerce-NoticeGroup-checkout li, .wcf-embed-checkout-form .woocommerce .wcf-custom-coupon-field .woocommerce-error li' => array(
					'color' => $attr['errorMsgColor'],
				),
				' .wcf-embed-checkout-form .woocommerce .woocommerce-NoticeGroup .woocommerce-error, .wcf-embed-checkout-form .woocommerce .woocommerce-notices-wrapper .woocommerce-error' => array(
					'background-color' => $attr['errorMsgBgColor'],
					'border-radius'    => Cartflows_Gb_Helper::get_css_value( $attr['msgBorderRadius'], 'px' ),
					'border-color'     => $attr['errorMsgBorderColor'],
					'padding-top'      => Cartflows_Gb_Helper::get_css_value( $attr['msgHrPadding'], 'px' ),
					'padding-right'    => Cartflows_Gb_Helper::get_css_value( $attr['msgVrPadding'], 'px' ),
					'padding-bottom'   => Cartflows_Gb_Helper::get_css_value( $attr['msgHrPadding'], 'px' ),
					'padding-left'     => Cartflows_Gb_Helper::get_css_value( $attr['msgVrPadding'], 'px' ),
					'border-width'     => Cartflows_Gb_Helper::get_css_value( $attr['msgBorderSize'], 'px' ),
				),
				' .wcf-embed-checkout-form .woocommerce #payment input[type=radio]:checked:before, .wcf-embed-checkout-form .woocommerce #order_review button, .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small, .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button, .wcf-embed-checkout-form .woocommerce-checkout form.login .button:hover, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button:hover, .wcf-embed-checkout-form .woocommerce #payment #place_order:hover, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small:hover, .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-steps .step-one.wcf-current:before, .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-steps .step-two.wcf-current:before, .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-steps .steps.wcf-current:before, .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-note, body .wcf-pre-checkout-offer-wrapper .wcf-nav-bar-step.active .wcf-progress-nav-step, body .wcf-pre-checkout-offer-wrapper .wcf-nav-bar-step.active .wcf-nav-bar-step-line:before, body .wcf-pre-checkout-offer-wrapper .wcf-nav-bar-step.active .wcf-nav-bar-step-line:after' => array(
					'background-color' => $attr['globalbgColor'],
				),
				' .wcf-embed-checkout-form-two-step .wcf-embed-checkout-form-note:before' => array(
					'border-top-color' => $attr['globalbgColor'],
				),
				' .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns .wcf-next-button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button, .wcf-embed-checkout-form form.checkout_coupon .button, body .wcf-pre-checkout-offer-wrapper #wcf-pre-checkout-offer-content button.wcf-pre-checkout-offer-btn' => array(
					'background-color' => $attr['globalbgColor'],
				),
				' .wcf-embed-checkout-form ,  .wcf-embed-checkout-form #payment .woocommerce-privacy-policy-text p' => array(
					'color' => $attr['globaltextColor'],
				),
				' .woocommerce form .form-row.woocommerce-invalid label' => array(
					'color' => $attr['errorLabelColor'],
				),
				' .wcf-embed-checkout-form .select2-container--default.field-required .select2-selection--single, .wcf-embed-checkout-form .woocommerce form .form-row input.input-text.field-required, .wcf-embed-checkout-form .woocommerce form .form-row textarea.input-text.field-required, .wcf-embed-checkout-form .woocommerce #order_review .input-text.field-required  .wcf-embed-checkout-form .woocommerce form .form-row.woocommerce-invalid .select2-container, .wcf-embed-checkout-form .woocommerce form .form-row.woocommerce-invalid input.input-text,  .wcf-embed-checkout-form .woocommerce form .form-row.woocommerce-invalid select' => array(
					'border-color' => $attr['errorFieldBorderColor'],
				),
			);
			if ( 'color' == $bg_type ) {
				$selectors[' .wcf-embed-checkout-form .woocommerce #order_review button, .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small, .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button, .wcf-embed-checkout-form form.checkout_coupon .button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button'] = array(
					'opacity'          => ( isset( $attr['backgroundOpacity'] ) && '' !== $attr['backgroundOpacity'] ) ? $attr['backgroundOpacity'] / 100 : 0.79,
					'box-shadow'       => Cartflows_Gb_Helper::get_css_value( $attr['boxShadowHOffset'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowVOffset'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowBlur'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowSpread'], 'px' ) . ' ' . $attr['boxShadowColor'] . ' ' . $box_shadow_position_css,
					'background-color' => $attr['backgroundColor'],
				);
				$selectors[' .wcf-embed-checkout-form .woocommerce #order_review button:hover, .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button:hover, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small:hover, .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button:hover, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button:hover, .wcf-embed-checkout-form form.checkout_coupon .button:hover, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button:hover, .wcf-embed-checkout-form .woocommerce #payment #place_order:hover'] = array(
					'background-color' => $attr['backgroundHoverColor'],
				);
			}

			if ( 'gradient' == $bg_type ) {
				$selectors[' .wcf-embed-checkout-form .woocommerce #order_review button, .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small, .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button, .wcf-embed-checkout-form form.checkout_coupon .button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button'] = array(
					'box-shadow' => Cartflows_Gb_Helper::get_css_value( $attr['boxShadowHOffset'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowVOffset'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowBlur'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowSpread'], 'px' ) . ' ' . $attr['boxShadowColor'] . ' ' . $box_shadow_position_css,
				);
			}

			$position = str_replace( '-', ' ', $attr['backgroundPosition'] );

			if ( 'image' == $bg_type ) {
				$selectors[' .wcf-embed-checkout-form .woocommerce #order_review button, .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small, .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button, .wcf-embed-checkout-form form.checkout_coupon .button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button'] = array(
					'opacity'               => ( isset( $attr['backgroundOpacity'] ) && '' !== $attr['backgroundOpacity'] ) ? $attr['backgroundOpacity'] / 100 : 0,
					'background-color'      => $attr['backgroundImageColor'],
					'background-image'      => ( isset( $attr['backgroundImage'] ) && isset( $attr['backgroundImage']['url'] ) ) ? "url('" . $attr['backgroundImage']['url'] . "' )" : null,
					'background-position'   => $position,
					'background-attachment' => $attr['backgroundAttachment'],
					'background-repeat'     => $attr['backgroundRepeat'],
					'background-size'       => $attr['backgroundSize'],
					'box-shadow'            => Cartflows_Gb_Helper::get_css_value( $attr['boxShadowHOffset'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowVOffset'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowBlur'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowSpread'], 'px' ) . ' ' . $attr['boxShadowColor'] . ' ' . $box_shadow_position_css,
				);
			} elseif ( 'gradient' === $bg_type ) {

				$selectors[' .wcf-embed-checkout-form .woocommerce #order_review button, .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small, .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button, .wcf-embed-checkout-form form.checkout_coupon .button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button']['background-color'] = 'transparent';
				$selectors[' .wcf-embed-checkout-form .woocommerce #order_review button, .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small, .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button, .wcf-embed-checkout-form form.checkout_coupon .button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button']['opacity']          = ( isset( $attr['backgroundOpacity'] ) && '' !== $attr['backgroundOpacity'] ) ? $attr['backgroundOpacity'] / 100 : 0;
				if ( $attr['gradientValue'] ) {
					$selectors[' .wcf-embed-checkout-form .woocommerce #order_review button, .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small, .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button, .wcf-embed-checkout-form form.checkout_coupon .button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button']['background-image'] = $attr['gradientValue'];

				} else {
					if ( 'linear' === $attr['gradientType'] ) {

						$selectors[' .wcf-embed-checkout-form .woocommerce #order_review button, .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small, .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button, .wcf-embed-checkout-form form.checkout_coupon .button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button']['background-image'] = "linear-gradient(${ $attr['gradientAngle'] }deg, ${ $attr['gradientColor1'] } ${ $attr['gradientLocation1'] }%, ${ $attr['gradientColor2'] } ${ $attr['gradientLocation2'] }%)";
					} else {

							$selectors[' .wcf-embed-checkout-form .woocommerce #order_review button, .wcf-embed-checkout-form .woocommerce form.woocommerce-form-login .form-row button, .wcf-embed-checkout-form .woocommerce #order_review button.wcf-btn-small, .wcf-embed-checkout-form .woocommerce-checkout form.woocommerce-form-login .button, .wcf-embed-checkout-form .woocommerce-checkout form.checkout_coupon .button, .wcf-embed-checkout-form form.checkout_coupon .button, .wcf-embed-checkout-form-two-step .woocommerce .wcf-embed-checkout-form-nav-btns a.wcf-next-button']['background-image'] = "radial-gradient( at ${ $attr['gradientPosition'] }, ${ $attr['gradientColor1'] } ${ $attr['gradientLocation1'] }%, ${ $attr['gradientColor2'] } ${ $attr['gradientLocation2'] }%)";
					}
				}
			}

			$combined_selectors = array(
				'desktop' => $selectors,
				'tablet'  => $t_selectors,
				'mobile'  => $m_selectors,
			);

			$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'global', ' .wcf-embed-checkout-form .woocommerce', $combined_selectors );
			$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'head', ' .wcf-embed-checkout-form .woocommerce h3, .wcf-embed-checkout-form .woocommerce-checkout #order_review_heading, .wcf-embed-checkout-form .woocommerce h3, .wcf-embed-checkout-form .woocommerce h3 span', $combined_selectors );
			$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'button', ' .wcf-embed-checkout-form .woocommerce #order_review button', $combined_selectors );
			$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'input', ' .wcf-embed-checkout-form .woocommerce form p.form-row label, .wcf-embed-checkout-form .woocommerce form .form-row input.input-text, .wcf-embed-checkout-form .woocommerce form .form-row textarea, .wcf-embed-checkout-form .woocommerce form .form-row select#billing_country, .wcf-embed-checkout-form .woocommerce form .form-row select#billing_state, span#select2-billing_country-container, .wcf-embed-checkout-form .select2-container--default .select2-selection--single .select2-selection__rendered, .wcf-embed-checkout-form #order_review .wcf-custom-coupon-field input[type="text"], .wcf-embed-checkout-form .woocommerce form .form-row input.input-text, .wcf-embed-checkout-form .woocommerce form .form-row textarea, .wcf-embed-checkout-form .select2-container--default .select2-selection--single, .wcf-embed-checkout-form .woocommerce form .form-row select, .wcf-embed-checkout-form .woocommerce form .form-row select, .wcf-embed-checkout-form ::placeholder, .wcf-embed-checkout-form ::-webkit-input-placeholder, .wcf-embed-checkout-form .woocommerce #payment [type="radio"]:checked + label, .wcf-embed-checkout-form .woocommerce #payment [type="radio"]:not(:checked) + label', $combined_selectors );

			return Cartflows_Gb_Helper::generate_all_css( $combined_selectors, ' .cf-block-' . $id );
		}

			/**
			 * Get Optin Form Block CSS
			 *
			 * @since x.x.x
			 * @param array  $attr The block attributes.
			 * @param string $id The selector ID.
			 * @return array The Widget List.
			 */
		public static function get_optin_form_css( $attr, $id ) {

			$defaults = Cartflows_Gb_Helper::$block_list['wcfb/optin-form']['attributes'];

			$attr = array_merge( $defaults, $attr );

			$t_selectors = array();
			$m_selectors = array();
			$selectors   = array();

			$box_shadow_position_css = $attr['boxShadowPosition'];

			if ( 'outset' === $attr['boxShadowPosition'] ) {
				$box_shadow_position_css = '';
			}

			$selectors = array(
				// General.
				' .wcf-optin-form .checkout.woocommerce-checkout #order_review .woocommerce-checkout-payment button#place_order' => array(
					'background-color' => $attr['generalPrimaryColor'],
					'border-color'     => $attr['generalPrimaryColor'],
				),

				// Input Fields.
				' .wcf-optin-form .checkout.woocommerce-checkout label' => array(
					'color' => $attr['inputFieldLabelColor'],
				),
				' .wcf-optin-form .checkout.woocommerce-checkout span input.input-text' => array(
					'color'            => $attr['inputFieldTextPlaceholderColor'],
					'background-color' => $attr['inputFieldBackgroundColor'],
					'border-style'     => $attr['inputFieldBorderStyle'],
					'border-width'     => Cartflows_Gb_Helper::get_css_value( $attr['inputFieldBorderWidth'], 'px' ),
					'border-radius'    => Cartflows_Gb_Helper::get_css_value( $attr['inputFieldBorderRadius'], 'px' ),
					'border-color'     => $attr['inputFieldBorderColor'],
				),

				// Submit Button.
				' .wcf-optin-form .checkout.woocommerce-checkout .wcf-order-wrap #order_review .woocommerce-checkout-payment button#place_order' => array(
					'color'            => $attr['submitButtonTextColor'],
					'background-color' => $attr['submitButtonBackgroundColor'],
					'border-style'     => $attr['submitButtonBorderStyle'],
					'border-width'     => Cartflows_Gb_Helper::get_css_value( $attr['submitButtonBorderWidth'], 'px' ),
					'border-radius'    => Cartflows_Gb_Helper::get_css_value( $attr['submitButtonBorderRadius'], 'px' ),
					'border-color'     => $attr['submitButtonBorderColor'],
					'box-shadow'       => Cartflows_Gb_Helper::get_css_value( $attr['boxShadowHOffset'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowVOffset'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowBlur'], 'px' ) . ' ' . Cartflows_Gb_Helper::get_css_value( $attr['boxShadowSpread'], 'px' ) . ' ' . $attr['boxShadowColor'] . ' ' . $box_shadow_position_css,
				),
				' .wcf-optin-form .checkout.woocommerce-checkout .wcf-order-wrap #order_review .woocommerce-checkout-payment button#place_order:hover' => array(
					'color'            => $attr['submitButtonTextHoverColor'],
					'background-color' => $attr['submitButtonBackgroundHoverColor'],
					'border-color'     => $attr['submitButtonBorderHoverColor'],
				),

			);

			$combined_selectors = array(
				'desktop' => $selectors,
				'tablet'  => $t_selectors,
				'mobile'  => $m_selectors,
			);

			// General.
			$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'general', ' .wcf-optin-form .checkout.woocommerce-checkout label, .wcf-optin-form .checkout.woocommerce-checkout span input.input-text, .wcf-optin-form .checkout.woocommerce-checkout .wcf-order-wrap #order_review .woocommerce-checkout-payment button#place_order', $combined_selectors );

			// Input Fields.
			$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'inputField', ' .wcf-optin-form .checkout.woocommerce-checkout label, .wcf-optin-form .checkout.woocommerce-checkout span input.input-text', $combined_selectors );

			// Submit Button.
			$combined_selectors = Cartflows_Gb_Helper::get_typography_css( $attr, 'submitButton', ' .wcf-optin-form .checkout.woocommerce-checkout .wcf-order-wrap #order_review .woocommerce-checkout-payment button#place_order', $combined_selectors );

			return Cartflows_Gb_Helper::generate_all_css( $combined_selectors, ' .cf-block-' . $id );
		}



	}
}
