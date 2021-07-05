<?php
/**
 * Optin post meta fields
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use CartflowsAdmin\AdminCore\Inc\AdminHelper;
/**
 * Meta Boxes setup
 */
class Cartflows_Checkout_Meta_Data extends Cartflows_Step_Meta_Base {


	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


	/**
	 * Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'cartflows_checkout_step_meta_fields', array( $this, 'filter_values' ) );
	}


	/**
	 * Filter checkout values
	 *
	 * @param  array $options options.
	 */
	public function filter_values( $options ) {

		if ( isset( $options['wcf-checkout-products'] ) ) {
			// Update the product name in the option 'wcf-checkout-products'.
			$checkout_products = $options['wcf-checkout-products'];

			if ( is_array( $checkout_products ) && isset( $checkout_products[0] ) ) {

				foreach ( $checkout_products as $index => $product ) {

					$product_obj = wc_get_product( $product['product'] );
					if ( $product_obj ) {
						$checkout_products[ $index ]['name']          = rawurldecode( $product_obj->get_formatted_name() );
						$checkout_products[ $index ]['img_url']       = get_the_post_thumbnail_url( $product['product'] );
						$checkout_products[ $index ]['regular_price'] = AdminHelper::get_product_original_price( $product_obj );
					}
				}
			} else {
				$checkout_products = array();
			}

			$options['wcf-checkout-products'] = $checkout_products;
		}

		return $options;
	}

	/**
	 * Page Header Tabs
	 *
	 * @param  int   $step_id Post meta.
	 * @param  array $options options.
	 */
	public function get_settings( $step_id, $options = array() ) {

		$this->step_id = $step_id;
		$this->options = $options;

		$common_tabs = $this->common_tabs();
		$add_tabs    = array(
			'checkout_products'    => array(
				'title'    => __( 'Products', 'cartflows' ),
				'id'       => 'checkout_products',
				'class'    => '',
				'icon'     => 'dashicons-format-aside',
				'priority' => 10,
			),
			'order_bump'           => array(
				'title'    => __( 'Order Bump', 'cartflows' ),
				'id'       => 'order_bump',
				'class'    => '',
				'icon'     => 'dashicons-format-aside',
				'priority' => 20,
			),
			'checkout_offer'       => array(
				'title'    => __( 'Checkout Offer', 'cartflows' ),
				'id'       => 'checkout_offer',
				'class'    => '',
				'icon'     => 'dashicons-format-aside',
				'priority' => 30,
			),
			'checkout_form_fields' => array(
				'title'    => __( 'Form Fields', 'cartflows' ),
				'id'       => 'checkout_form_fields',
				'class'    => '',
				'icon'     => 'dashicons-format-aside',
				'priority' => 40,
			),
			'settings'             => array(
				'title'    => __( 'Settings', 'cartflows' ),
				'id'       => 'settings',
				'class'    => '',
				'icon'     => 'dashicons-format-aside',
				'priority' => 50,
			),

		);

		$tabs            = array_merge( $common_tabs, $add_tabs );
		$settings        = $this->get_settings_fields( $step_id );
		$design_settings = $this->get_design_fields( $step_id );
		$options         = $this->get_data( $step_id );
		$custom_fields   = apply_filters( 'cartflows_get_checkout_custom_fields_data', $step_id, $options );

		$settings_data = array(
			'tabs'            => $tabs,
			'settings'        => $settings,
			'page_settings'   => $this->get_page_settings( $step_id ),
			'design_settings' => $design_settings,
			'custom_fields'   => $custom_fields,
		);

		return $settings_data;
	}

	/**
	 * Get design settings data.
	 *
	 * @param  int $step_id Post ID.
	 */
	public function get_design_fields( $step_id ) {

		$options           = $this->get_data( $step_id );
		$layout_pro_option = array();

		if ( ! _is_cartflows_pro() ) {
			$layout_pro_option = array(
				'one-column' => __( 'One Column (Available in CartFlows Pro) ', 'cartflows' ),
				'two-step'   => __( 'Two Step (Available in CartFlows Pro) ', 'cartflows' ),
			);
		}

		$settings = array(
			'settings' => array(
				'checkout-design'          => array(
					'title'    => __( 'Checkout Design', 'cartflows' ),
					'priority' => 10,
					'fields'   => array(
						'checkout-skin'       => array(
							'type'        => 'select',
							'label'       => __( 'Checkout Skin', 'cartflows' ),
							'name'        => 'wcf-checkout-layout',
							'value'       => $options['wcf-checkout-layout'],

							'options'     => array(
								array(
									'value' => 'one-column',
									'label' => esc_html__( 'One Column', 'cartflows' ),
								),
								array(
									'value' => 'two-column',
									'label' => esc_html__( 'Two Column', 'cartflows' ),
								),
								array(
									'value' => 'two-step',
									'label' => esc_html__( 'Two Step', 'cartflows' ),
								),
							),
							'pro_options' => $layout_pro_option,
						),
						'primary-color'       => array(
							'type'  => 'color-picker',
							'name'  => 'wcf-primary-color',
							'label' => __( 'Primary Color', 'cartflows' ),
							'value' => $options['wcf-primary-color'],
						),
						'heading-font-family' => array(
							'type'  => 'font-family',
							'label' => esc_html__( 'Font Family', 'cartflows' ),
							'name'  => 'wcf-base-font-family',
							'value' => $options['wcf-base-font-family'],
						),
					),
				),

				'checkout-text-design'     => array(
					'title'    => __( 'Checkout Texts & Buttons', 'cartflows' ),
					'priority' => 20,
					'fields'   => array(
						'advanced-options'          => array(
							'type'  => 'checkbox',
							'label' => __( 'Enable Advance Options', 'cartflows' ),
							'name'  => 'wcf-advance-options-fields',
							'value' => $options['wcf-advance-options-fields'],
						),

						'heading-heading'           => array(
							'type'       => 'heading',
							'label'      => esc_html__( 'Heading', 'cartflows' ),
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),

						'heading-font-color'        => array(
							'type'       => 'color-picker',
							'label'      => __( 'Heading Color', 'cartflows' ),
							'name'       => 'wcf-heading-color',
							'value'      => $options['wcf-heading-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'heading-font-family'       => array(
							'type'              => 'font-family',
							'for'               => 'wcf-heading',
							'label'             => esc_html__( 'Font Family', 'cartflows' ),
							'name'              => 'wcf-heading-font-family',
							'value'             => $options['wcf-heading-font-family'],
							'font_weight_name'  => 'wcf-heading-font-weight',
							'font_weight_value' => $options['wcf-heading-font-weight'],
							'for'               => 'wcf-heading',
							'conditions'        => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),

						'heading-input-field'       => array(
							'type'       => 'heading',
							'label'      => esc_html__( 'Input Fields', 'cartflows' ),
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),

						'input-field-style'         => array(
							'type'       => 'select',
							'label'      => __( 'Style', 'cartflows' ),
							'name'       => 'wcf-fields-skins',
							'value'      => $options['wcf-fields-skins'],
							'options'    => array(
								array(
									'value' => 'default',
									'label' => esc_html__( 'Default', 'cartflows' ),
								),
								array(
									'value' => 'style-one',
									'label' => esc_html__( 'Floating Labels', 'cartflows' ),
								),

							),
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'input-font-family'         => array(
							'type'              => 'font-family',
							'for'               => 'wcf-input',
							'label'             => esc_html__( 'Font Family', 'cartflows' ),
							'name'              => 'wcf-input-font-family',
							'value'             => $options['wcf-input-font-family'],
							'font_weight_name'  => 'wcf-input-font-weight',
							'font_weight_value' => $options['wcf-input-font-weight'],
							'for'               => 'wcf-input',
							'conditions'        => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),

						'input-size'                => array(
							'type'       => 'select',
							'label'      => __( 'Size', 'cartflows' ),
							'name'       => 'wcf-input-field-size',
							'value'      => $options['wcf-input-field-size'],
							'options'    => array(
								array(
									'value' => '33px',
									'label' => esc_html__( 'Extra Small', 'cartflows' ),
								),
								array(
									'value' => '38px',
									'label' => esc_html__( 'Small', 'cartflows' ),
								),
								array(
									'value' => '44px',
									'label' => esc_html__( 'Medium', 'cartflows' ),
								),
								array(
									'value' => '58px',
									'label' => esc_html__( 'Large', 'cartflows' ),
								),
								array(
									'value' => '68px',
									'label' => esc_html__( 'Extra Large', 'cartflows' ),
								),
								array(
									'value' => 'custom',
									'label' => esc_html__( 'Custom', 'cartflows' ),
								),
							),
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'input-bottom-space'        => array(
							'type'       => 'number',
							'label'      => __( 'Top Bottom Spacing', 'cartflows' ),
							'name'       => 'wcf-field-tb-padding',
							'value'      => $options['wcf-field-tb-padding'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-input-field-size',
										'operator' => '===',
										'value'    => 'custom',
									),
								),
							),
						),
						'input-right-space'         => array(
							'type'       => 'number',
							'label'      => __( 'Left Right Spacing', 'cartflows' ),
							'name'       => 'wcf-field-lr-padding',
							'value'      => $options['wcf-field-lr-padding'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-input-field-size',
										'operator' => '===',
										'value'    => 'custom',
									),
								),
							),
						),
						'input-text/p-color'        => array(
							'type'       => 'color-picker',
							'label'      => __( 'Text / Placeholder Color', 'cartflows' ),
							'name'       => 'wcf-field-color',
							'value'      => $options['wcf-field-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'input-bg-color'            => array(
							'type'       => 'color-picker',
							'label'      => __( 'Background Color', 'cartflows' ),
							'name'       => 'wcf-field-bg-color',
							'value'      => $options['wcf-field-bg-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'input-border-color'        => array(
							'type'       => 'color-picker',
							'label'      => __( 'Border Color', 'cartflows' ),
							'name'       => 'wcf-field-border-color',
							'value'      => $options['wcf-field-border-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'input-label-color'         => array(
							'type'       => 'color-picker',
							'label'      => __( 'Label Color', 'cartflows' ),
							'name'       => 'wcf-field-label-color',
							'value'      => $options['wcf-field-label-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),

						'button-heading'            => array(
							'type'       => 'heading',
							'label'      => esc_html__( 'Buttons', 'cartflows' ),
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'button-font-family'        => array(
							'type'              => 'font-family',
							'for'               => 'wcf-button',
							'label'             => esc_html__( 'Font Family', 'cartflows' ),
							'name'              => 'wcf-button-font-family',
							'value'             => $options['wcf-button-font-family'],
							'font_weight_name'  => 'wcf-button-font-weight',
							'font_weight_value' => $options['wcf-button-font-weight'],
							'for'               => 'wcf-button',
							'conditions'        => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),

						'buttom-font-size'          => array(
							'type'       => 'select',
							'label'      => __( 'Size', 'cartflows' ),
							'name'       => 'wcf-input-button-size',
							'value'      => $options['wcf-input-button-size'],
							'options'    => array(
								array(
									'value' => '33px',
									'label' => esc_html__( 'Extra Small', 'cartflows' ),
								),
								array(
									'value' => '38px',
									'label' => esc_html__( 'Small', 'cartflows' ),
								),
								array(
									'value' => '44px',
									'label' => esc_html__( 'Medium', 'cartflows' ),
								),
								array(
									'value' => '58px',
									'label' => esc_html__( 'Large', 'cartflows' ),
								),
								array(
									'value' => '68px',
									'label' => esc_html__( 'Extra Large', 'cartflows' ),
								),
								array(
									'value' => 'custom',
									'label' => esc_html__( 'Custom', 'cartflows' ),
								),
							),
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'buttom-top-space'          => array(
							'type'       => 'number',
							'label'      => __( 'Top Bottom Spacing', 'cartflows' ),
							'name'       => 'wcf-submit-tb-padding',
							'value'      => $options['wcf-submit-tb-padding'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-input-button-size',
										'operator' => '===',
										'value'    => 'custom',
									),
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'buttom-left-space'         => array(
							'type'       => 'number',
							'label'      => __( 'Left Right Spacing', 'cartflows' ),
							'name'       => 'wcf-submit-lr-padding',
							'value'      => $options['wcf-submit-lr-padding'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-input-button-size',
										'operator' => '===',
										'value'    => 'custom',
									),
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'buttom-text-color'         => array(
							'type'       => 'color-picker',
							'label'      => __( 'Text Color', 'cartflows' ),
							'name'       => 'wcf-submit-color',
							'value'      => $options['wcf-submit-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'buttom-text-hover-color'   => array(
							'type'       => 'color-picker',
							'label'      => __( 'Text Hover Color', 'cartflows' ),
							'name'       => 'wcf-submit-hover-color',
							'value'      => $options['wcf-submit-hover-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'buttom-bg-color'           => array(
							'type'       => 'color-picker',
							'label'      => __( 'Background Color', 'cartflows' ),
							'name'       => 'wcf-submit-bg-color',
							'value'      => $options['wcf-submit-bg-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'buttom-bg-hover-color'     => array(
							'type'       => 'color-picker',
							'label'      => __( 'Background Hover Color', 'cartflows' ),
							'name'       => 'wcf-submit-bg-hover-color',
							'value'      => $options['wcf-submit-bg-hover-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'buttom-border-color'       => array(
							'type'       => 'color-picker',
							'label'      => __( 'Border Color', 'cartflows' ),
							'name'       => 'wcf-submit-border-color',
							'value'      => $options['wcf-submit-border-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'buttom-border-hover-color' => array(
							'type'       => 'color-picker',
							'label'      => __( 'Border Hover Color', 'cartflows' ),
							'name'       => 'wcf-submit-border-hover-color',
							'value'      => $options['wcf-submit-border-hover-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),

						'section-heading'           => array(
							'type'       => 'heading',
							'label'      => esc_html__( 'Sections', 'cartflows' ),
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),

						'highlighted-area'          => array(
							'type'       => 'color-picker',
							'label'      => __( 'Highlight Area Background Color', 'cartflows' ),
							'name'       => 'wcf-hl-bg-color',
							'value'      => $options['wcf-hl-bg-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),

					),
				),

				'checkout-two-step-design' => array(
					'title'      => __( 'Two-Step Design', 'cartflows' ),
					'priority'   => 40,
					'fields'     => ! _is_cartflows_pro() ? array(
						'product-option' => array(
							'type'    => 'pro-notice',
							'feature' => 'Two Step',
						),
					) : '',
					'conditions' => array(
						'relation' => 'and',
						'fields'   => array(
							array(
								'name'     => 'wcf-checkout-layout',
								'operator' => '===',
								'value'    => 'two-step',
							),
						),
					),
				),

				'product-option-design'    => array(
					'title'    => __( 'Product Options', 'cartflows' ),
					'priority' => 50,
					'fields'   => ! _is_cartflows_pro() ? array(
						'product-option' => array(
							'type'    => 'pro-notice',
							'feature' => 'Product Options',
						),
					) : '',
				),

				'order-bump-design'        => array(
					'title'    => __( 'Order Bump', 'cartflows' ),
					'priority' => 60,
					'fields'   => ! _is_cartflows_pro() ? array(
						'product-option' => array(
							'type'    => 'pro-notice',
							'feature' => 'Order Bump',
						),
					)

						: '',

				),

				'checkout-offer-design'    => array(
					'title'    => __( 'Checkout Offer', 'cartflows' ),
					'priority' => 70,
					'fields'   => ! _is_cartflows_pro() ? array(
						'product-option' => array(
							'type'    => 'pro-notice',
							'feature' => 'Checkout Offer',
						),
					)

						: '',
				),

			),
		);

		$settings = apply_filters( 'cartflows_react_checkout_design_fields', $settings, $options );
		return $settings;
	}

	/**
	 * Get page settings.
	 *
	 * @param int $step_id Step ID.
	 */
	public function get_page_settings( $step_id ) {

		$options = $this->get_data( $step_id );

		$settings = array(
			'settings' => array(
				'product'         => array(
					'title'    => __( 'Product', 'cartflows' ),
					'priority' => 20,
					'fields'   => array(
						'wcf-checkout-products' => array(
							'type'                   => 'product-repeater',
							'fieldtype'              => 'product',
							'name'                   => 'wcf-checkout-products',
							'value'                  => array(),
							'label'                  => __( 'Select Product', 'cartflows' ),
							'placeholder'            => __( 'Search for a product...', 'cartflows' ),
							'multiple'               => false,
							'allow_clear'            => true,
							'allowed_product_types'  => array(),
							'excluded_product_types' => array( 'grouped' ),
							'include_product_types'  => array( 'braintree-subscription, braintree-variable-subscription' ),
						),
						'checkout-product-doc'  => array(
							'type'    => 'doc',
							/* translators: %1$1s: link html start, %2$12: link html end*/
							'content' => sprintf( __( 'For more information about the checkout product settings please %1$1s Click here.%2$2s', 'cartflows' ), '<a href="https://cartflows.com/docs/set-product-quantity-and-discount/" target="_blank">', '</a>' ),
						),
					),
				),

				'coupon'          => array(
					'title'    => __( 'Coupon', 'cartflows' ),
					'priority' => 30,
					'fields'   => ! _is_cartflows_pro() ? array(
						'coupon' => array(
							'type'    => 'pro-notice',
							'feature' => __( 'Coupon', 'cartflows' ),
						),
					)

					: '',

				),
				// Product Options.
				'product-options' => array(
					'title'    => __( 'Product Options', 'cartflows' ),
					'priority' => 40,
					'fields'   => ! _is_cartflows_pro() ? array(
						'product-option' => array(
							'type'    => 'pro-notice',
							'feature' => 'Product Options',
						),
					)

						: '',

				),

				// Bump Order.
				'order-bump'      => array(
					'title'    => __( 'Order Bump', 'cartflows' ),
					'priority' => 50,
					'fields'   => ! _is_cartflows_pro() ? array(
						'order-bump' => array(
							'type'    => 'pro-notice',
							'feature' => 'Order Bump',
						),
					)

						: '',

				),

				// checkout offer.
				'checkout-offer'  => array(
					'title'    => __( 'Checkout Offer', 'cartflows' ),
					'priority' => 60,
					'fields'   => ! _is_cartflows_pro() ? array(
						'checkout-offer' => array(
							'type'    => 'pro-notice',
							'feature' => 'Checkout Offer',
						),
					)

						: '',
				),

			),
		);

		$settings = apply_filters( 'cartflows_react_checkout_meta_fields', $settings, $step_id, $options );

		return $settings;
	}
	/**
	 * Get settings data.
	 *
	 * @param  int $step_id Post ID.
	 */
	public function get_settings_fields( $step_id ) {

		$options = $this->get_data( $step_id );

		$settings = array(
			'settings' => array(
				'shortcodes'        => array(
					'title'    => __( 'Shortcodes', 'cartflows' ),
					'priority' => 10,
					'fields'   => array(
						'checkout-shortcode' => array(
							'type'     => 'text',
							'name'     => 'checkout-shortcode',
							'label'    => __( 'CartFlows Checkout', 'cartflows' ),
							'value'    => '[cartflows_checkout]',
							'help'     => esc_html__( 'Add this shortcode to your checkout page', 'cartflows' ),
							'readonly' => true,
						),
					),
				),
				'general'           => array(
					'title'    => __( 'General', 'cartflows' ),
					'priority' => 20,
					'fields'   => array(
						'title' => array(
							'type'  => 'text',
							'name'  => 'post_title',
							'label' => __( 'Step Title', 'cartflows' ),
							'value' => get_the_title( $step_id ),
						),
						'slug'  => array(
							'type'  => 'text',
							'name'  => 'post_name',
							'label' => __( 'Step Slug', 'cartflows' ),
							'value' => get_post_field( 'post_name', $step_id ),
						),
					),
				),

				// Checkout Fields.
				'checkout-settings' => array(
					'title'    => __( 'Checkout Settings', 'cartflows' ),
					'priority' => 30,
					'fields'   => array(

						'wcf-place-order-button-text' => array(
							'type'        => 'text',
							'label'       => __( 'Place Order Button Text', 'cartflows' ),
							'name'        => 'wcf-checkout-place-order-button-text',
							'value'       => $options['wcf-checkout-place-order-button-text'],
							'placeholder' => __( 'Place order', 'cartflows' ),
							'help'        => __( 'It will change the Place Order Button text on checkout page.', 'cartflows' ),
						),

						'wcf-edit-cart'               => array(
							'type'  => 'checkbox',
							'label' => __( 'Enable cart editing on checkout', 'cartflows' ),
							'name'  => 'wcf-remove-product-field',
							'value' => $options['wcf-remove-product-field'],
						),

						'redirection-doc'             => array(
							'type'    => 'doc',
							'label'   => __( 'Doc', 'cartflows' ),
							'content' => sprintf( esc_html__( 'Users will able to remove products from the checkout page.', 'cartflows' ) ),
						),

						'wcf-animate-browser-tab'     => ! _is_cartflows_pro() ? array(
							'type'    => 'pro-notice',
							'feature' => 'Animate Browser Tab',
						) : '',
					),
				),

				'custom-scripts'    => array(
					'title'    => __( 'Custom Script', 'cartflows' ),
					'priority' => 40,
					'fields'   => array(

						'wcf-checkout-custom-script' => array(
							'type'  => 'textarea',
							'label' => __( 'Custom Script', 'cartflows' ),
							'name'  => 'wcf-custom-script',
							'value' => $options['wcf-custom-script'],
						),
					),
				),
			),
		);

		return $settings;
	}

	/**
	 * Get data.
	 *
	 * @param  int $step_id Post ID.
	 */
	public function get_data( $step_id ) {

		$optin_data = array();

		// Stored data.
		$stored_meta = get_post_meta( $step_id );

		// Default.
		$default_data = self::get_meta_option( $step_id );

		// Set stored and override defaults.
		foreach ( $default_data as $key => $value ) {
			if ( array_key_exists( $key, $stored_meta ) ) {
				$optin_data[ $key ] = ( isset( $stored_meta[ $key ][0] ) ) ? maybe_unserialize( $stored_meta[ $key ][0] ) : '';
			} else {
				$optin_data[ $key ] = ( isset( $default_data[ $key ]['default'] ) ) ? $default_data[ $key ]['default'] : '';
			}
		}

		return $optin_data;

	}

	/**
	 * Get meta.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function get_meta_option( $post_id ) {

		$meta_option = wcf()->options->get_checkout_fields( $post_id );

		return $meta_option;

	}

	/**
	 * Get name.
	 *
	 * @param int $id Product ID.
	 */
	public static function get_name( $id ) {

		$product_object = wc_get_product( $id );

		$formatted_name = '';

		if ( is_object( $formatted_name ) ) {
			$formatted_name = rawurldecode( $product_object->get_formatted_name() );
		}
		return $formatted_name;

	}

}

/**
 * Kicking this off by calling 'get_instance()' method.
 */
Cartflows_Checkout_Meta_Data::get_instance();

