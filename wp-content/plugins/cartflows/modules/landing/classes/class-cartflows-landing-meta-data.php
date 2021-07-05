<?php
/**
 * Landing post meta box
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
class Cartflows_Landing_Meta_Data extends Cartflows_Step_Meta_Base {


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
	 * Page Header Tabs.
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
				'icon'     => 'dashicons-info',
				'priority' => 20,
			),

		);

		$tabs     = array_merge( $common_tabs, $add_tabs );
		$settings = $this->get_settings_fields( $step_id );

		$settings_data = array(
			'tabs'     => $tabs,
			'settings' => $settings,
		);

		return $settings_data;
	}

	/**
	 * Page Header Tabs.
	 *
	 * @param int $step_id Step ID.
	 */
	public function get_settings_fields( $step_id ) {

		$next_step_link = wcf()->utils->get_linking_url(
			array( 'class' => 'wcf-next-step' )
		);

		$options  = $this->get_data( $step_id );
		$settings = array(
			'settings' => array(
				'shortcode'       => array(
					'title'    => __( 'Shortcode', 'cartflows' ),
					'priority' => 10,
					'fields'   => array(
						'landing-shortcode' => array(
							'type'     => 'text',
							'name'     => 'thankyou-shortcode',
							'label'    => __( 'Next Step Link', 'cartflows' ),
							'value'    => $next_step_link,
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
				'landing-scripts' => array(
					'title'    => __( 'Custom Script', 'cartflows' ),
					'priority' => 30,
					'fields'   => array(

						'wcf-landing-custom-script' => array(
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

		$meta_option = wcf()->options->get_landing_fields( $post_id );

		return $meta_option;

	}
}

/**
 * Kicking this off by calling 'get_instance()' method.
 */
Cartflows_Landing_Meta_Data::get_instance();
