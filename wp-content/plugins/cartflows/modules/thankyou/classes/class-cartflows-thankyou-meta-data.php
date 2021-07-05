<?php
/**
 * Thank you post meta fields.
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Meta Boxes setup
 */
class Cartflows_Thankyou_Meta_Data extends Cartflows_Step_Meta_Base {


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

	}

	/**
	 * Page Header Tabs
	 *
	 * @param  int   $step_id Post ID.
	 * @param  array $options Post meta.
	 */
	public function get_settings( $step_id, $options = array() ) {

		$this->step_id = $step_id;
		$this->options = $options;

		$common_tabs = $this->common_tabs();
		$add_tabs    = array(
			'settings' => array(
				'title'    => __( 'Settings', 'cartflows' ),
				'id'       => 'settings',
				'class'    => '',
				'icon'     => 'dashicons-format-aside',
				'priority' => 40,
			),

		);

		$tabs            = array_merge( $common_tabs, $add_tabs );
		$settings        = $this->get_settings_fields( $step_id );
		$design_settings = $this->get_design_fields( $step_id );

		$settings_data = array(
			'tabs'            => $tabs,
			'settings'        => $settings,
			'design_settings' => $design_settings,
		);

		return $settings_data;
	}

	/**
	 * Get design settings data.
	 *
	 * @param  int $step_id Post ID.
	 */
	public function get_design_fields( $step_id ) {

		$options = $this->get_data( $step_id );

		$settings = array(
			'settings' => array(
				'heading'          => array(
					'title'  => __( 'Heading', 'cartflows' ),
					'fields' => array(
						'heading-color'       => array(
							'type'  => 'color-picker',
							'name'  => 'wcf-tq-heading-color',
							'label' => __( 'Color', 'cartflows' ),
							'value' => $options['wcf-tq-heading-color'],
						),
						'heading-font-family' => array(
							'type'              => 'font-family',
							'name'              => 'wcf-tq-heading-font-family',
							'label'             => __( 'Font Family', 'cartflows' ),
							'value'             => $options['wcf-tq-heading-font-family'],
							'font_weight_name'  => 'wcf-tq-heading-font-wt',
							'font_weight_value' => $options['wcf-tq-heading-font-wt'],
							'for'               => '',
						),
					),
				),

				'text'             => array(
					'title'  => __( 'Text', 'cartflows' ),
					'fields' => array(
						'text-color'       => array(
							'type'  => 'color-picker',
							'name'  => 'wcf-tq-text-color',
							'label' => __( 'Color', 'cartflows' ),
							'value' => $options['wcf-tq-text-color'],
						),
						'text-font-family' => array(
							'type'  => 'font-family',
							'name'  => 'wcf-tq-font-family',
							'label' => __( 'Font Family', 'cartflows' ),
							'value' => $options['wcf-tq-font-family'],
						),
						'text-font-size'   => array(
							'type'  => 'number',
							'name'  => 'wcf-tq-font-size',
							'label' => __( 'Font Size', 'cartflows' ),
							'value' => $options['wcf-tq-font-size'],
						),
					),
				),

				'advanced-options' => array(
					'title'  => __( 'Advanced Options', 'cartflows' ),
					'fields' => array(
						'wcf-tq-advance-options-fields' => array(
							'type'  => 'checkbox',
							'label' => __( 'Enable Advanced Options', 'cartflows' ),
							'name'  => 'wcf-tq-advance-options-fields',
							'value' => $options['wcf-tq-advance-options-fields'],
						),
						'wcf-show-details-section'      => array(
							'type'       => 'number',
							'label'      => __( 'Container Width (In px)', 'cartflows' ),
							'name'       => 'wcf-tq-container-width',
							'value'      => $options['wcf-tq-container-width'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-tq-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
						'section-bg-color'              => array(
							'type'       => 'color-picker',
							'name'       => 'wcf-tq-section-bg-color',
							'label'      => __( 'Section Background Color', 'cartflows' ),
							'value'      => $options['wcf-tq-section-bg-color'],
							'conditions' => array(
								'fields' => array(
									array(
										'name'     => 'wcf-tq-advance-options-fields',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
					),
				),

			),
		);

		return $settings;
	}


	/**
	 * Get settings fields.
	 *
	 * @param  int $step_id Post ID.
	 */
	public function get_settings_fields( $step_id ) {

		$options = $this->get_data( $step_id );

		$settings = array(
			'settings' => array(
				'shortcode'       => array(
					'title'    => __( 'Shortcode', 'cartflows' ),
					'priority' => 10,
					'fields'   => array(
						'thankyou-shortcode' => array(
							'type'     => 'text',
							'name'     => 'thankyou-shortcode',
							'label'    => __( 'Order Details', 'cartflows' ),
							'value'    => '[cartflows_order_details]',
							'help'     => esc_html__( 'Add this shortcode to your optin page', 'cartflows' ),
							'readonly' => true,
						),
					),
				),
				'general'         => array(
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
				'thankyou_fields' => array(
					'title'    => __( 'Fields Settings', 'cartflows' ),
					'priority' => 30,
					'fields'   => array(
						'wcf-show-overview-section' => array(
							'type'  => 'checkbox',
							'label' => __( 'Enable Order Overview', 'cartflows' ),
							'name'  => 'wcf-show-overview-section',
							'value' => $options['wcf-show-overview-section'],
						),
						'wcf-show-details-section'  => array(
							'type'  => 'checkbox',
							'label' => __( 'Enable Order Details', 'cartflows' ),
							'name'  => 'wcf-show-details-section',
							'value' => $options['wcf-show-details-section'],
						),
						'wcf-show-billing-section'  => array(
							'type'  => 'checkbox',
							'label' => __( 'Enable Billing Details', 'cartflows' ),
							'name'  => 'wcf-show-billing-section',
							'value' => $options['wcf-show-billing-section'],
						),
						'wcf-show-shipping-section' => array(
							'type'  => 'checkbox',
							'label' => __( 'Enable Shipping Details', 'cartflows' ),
							'name'  => 'wcf-show-shipping-section',
							'value' => $options['wcf-show-shipping-section'],
						),
					),
				),

				'settings'        => array(
					'title'    => __( 'Advanced Settings', 'cartflows' ),
					'priority' => 40,
					'fields'   => array(
						'wcf-tq-text'                  => array(
							'type'        => 'text',
							'label'       => __( 'Thank You Page Text', 'cartflows' ),
							'name'        => 'wcf-tq-text',
							'value'       => $options['wcf-tq-text'],
							'placeholder' => __( 'Thank you. Your order has been received.', 'cartflows' ),
						),
						'wcf-show-tq-redirect-section' => array(
							'type'  => 'checkbox',
							'label' => __( 'Redirect After Purchase', 'cartflows' ),
							'name'  => 'wcf-show-tq-redirect-section',
							'value' => $options['wcf-show-tq-redirect-section'],
							'help'  => __( 'Enter comma seprated field name. E.g. first_name, last_name', 'cartflows' ),
						),
						'wcf-tq-redirect-link'         => array(
							'type'        => 'text',
							'label'       => __( 'Redirect Link', 'cartflows' ),
							'name'        => 'wcf-tq-redirect-link',
							'value'       => $options['wcf-tq-redirect-link'],
							'placeholder' => __( 'https://', 'cartflows' ),
							'conditions'  => array(
								'fields' => array(
									array(
										'name'     => 'wcf-show-tq-redirect-section',
										'operator' => '===',
										'value'    => 'yes',
									),
								),
							),
						),
					),
				),

				'thanku-scripts'  => array(
					'title'    => __( 'Custom Script', 'cartflows' ),
					'priority' => 50,
					'fields'   => array(
						'wcf-thanku-custom-script' => array(
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

			$thanku_data = array();

			// Stored data.
			$stored_meta = get_post_meta( $step_id );

			// Default.
			$thank_meta = self::get_meta_option( $step_id );

			// Set stored and override defaults.
		foreach ( $thank_meta as $key => $value ) {
			if ( array_key_exists( $key, $stored_meta ) ) {
				$thanku_data[ $key ] = ( isset( $stored_meta[ $key ][0] ) ) ? maybe_unserialize( $stored_meta[ $key ][0] ) : '';
			} else {
				$thanku_data[ $key ] = ( isset( $thank_meta[ $key ]['default'] ) ) ? $thank_meta[ $key ]['default'] : '';
			}
		}

		return $thanku_data;

	}

	/**
	 * Get meta.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function get_meta_option( $post_id ) {

			$meta_option = wcf()->options->get_thankyou_fields( $post_id );

		return $meta_option;

	}

}

/**
 * Kicking this off by calling 'get_instance()' method.
 */
Cartflows_Thankyou_Meta_Data::get_instance();
