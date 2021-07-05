<?php
/**
 * CartFlows Flows ajax actions.
 *
 * @package CartFlows
 */

namespace CartflowsAdmin\AdminCore\Ajax;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CartflowsAdmin\AdminCore\Ajax\AjaxBase;
use CartflowsAdmin\AdminCore\Inc\AdminHelper;

/**
 * Class Flows.
 */
class CommonSettings extends AjaxBase {

	/**
	 * Instance
	 *
	 * @access private
	 * @var object Class object.
	 * @since 1.0.0
	 */
	private static $instance;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object initialized object of class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Register_ajax_events.
	 *
	 * @return void
	 */
	public function register_ajax_events() {

		$ajax_events = array(
			'save_global_settings',
			'switch_to_old_ui',
			'regenerate_css_for_steps',
		);

		$this->init_ajax_events( $ajax_events );
	}

	/**
	 * Delete the post meta key for dynamic css to regenerate the it.
	 */
	public function regenerate_css_for_steps() {

		$response_data = array( 'messsage' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_regenerate_css_for_steps', 'security', false ) ) {
			$response_data = array( 'messsage' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		// Update cartflows asset version to regenerate the dynamic css. We are using the time() function to add the random number.
		update_option( 'cartflows-assets-version', time() );

		$response_data = array(
			'messsage' => __( 'Successfully deleted the dynamic CSS keys!', 'cartflows' ),
		);
		wp_send_json_success( $response_data );

	}


	/**
	 * Shift to old UI call.
	 *
	 * @return void
	 */
	public function switch_to_old_ui() {

		$response_data = array( 'messsage' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_switch_to_old_ui', 'security', false ) ) {
			$response_data = array( 'messsage' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( empty( $_POST ) ) {
			$response_data = array( 'messsage' => __( 'No post data found!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		if ( isset( $_POST['cartflows_ui'] ) && 'old' === $_POST['cartflows_ui'] ) { //phpcs:ignore
			// Loop through the input and sanitize each of the values.
			update_option( 'cartflows-legacy-admin', true );
			delete_option( 'cartflows-switch-ui-notice' );

			$response_data = array(
				'redirect_to' => add_query_arg(
					array(
						'page' => 'cartflows',
					),
					esc_url_raw( isset( $_POST['redirect_url'] ) ? wp_unslash( $_POST['redirect_url'] ) : '' )
				),
			);

		}

		wp_send_json_success( $response_data );
	}

	/**
	 * Save settings.
	 *
	 * @return void
	 */
	public function save_global_settings() {

		$response_data = array( 'messsage' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_save_global_settings', 'security', false ) ) {
			$response_data = array( 'messsage' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( empty( $_POST ) ) {
			$response_data = array( 'messsage' => __( 'No post data found!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		if ( isset( $_POST ) ) {

			$setting_tab = isset( $_POST['setting_tab'] ) ? sanitize_text_field( wp_unslash( $_POST['setting_tab'] ) ) : '';

			switch ( $setting_tab ) {

				case 'general_settings':
					$this->save_general_settings();
					break;

				case 'permalink':
					$this->save_permalink_settings();
					break;

				case 'facebook_pixel':
					$this->save_fb_pixel_settings();
					break;

				case 'google_analytics':
					$this->save_google_analytics_settings();
					break;

				case 'other_settings':
					$this->save_other_settings();
					break;

				default:
					$this->save_general_settings();

			}
		}

		$response_data = array(
			'messsage' => __( 'Successfully saved data!', 'cartflows' ),
		);
		wp_send_json_success( $response_data );
	}

	/**
	 * Save settings.
	 *
	 * @return void
	 */
	public function save_other_settings() {

		$new_settings = '';

		if ( isset( $_POST['cartflows_delete_plugin_data'] ) ) { //phpcs:ignore
			$new_settings = sanitize_text_field( $_POST['cartflows_delete_plugin_data'] ); //phpcs:ignore

		}

		$this->update_admin_settings_option( 'cartflows_delete_plugin_data', $new_settings, false );

		if ( _is_cartflows_pro() ) {
			$this->update_admin_settings_option( 'cartflows_pro_delete_plugin_data', $new_settings, false );
		}

	}

	/**
	 * Save settings.
	 *
	 * @return void
	 */
	public function save_general_settings() {

		$new_settings = array();

		if ( isset( $_POST['_cartflows_common'] ) ) { //phpcs:ignore
			// Loop through the input and sanitize each of the values.
			$new_settings = $this->sanitize_form_inputs( wp_unslash( $_POST['_cartflows_common'] ) ); //phpcs:ignore
		}

		$this->update_admin_settings_option( '_cartflows_common', $new_settings, false );
	}

	/**
	 * Save settings.
	 *
	 * @return void
	 */
	public function save_fb_pixel_settings() {

		$new_settings = array();

		if ( isset( $_POST['_cartflows_facebook'] ) ) { //phpcs:ignore
			$new_settings = $this->sanitize_form_inputs( wp_unslash( $_POST['_cartflows_facebook'] ) ); //phpcs:ignore	
		}

		$this->update_admin_settings_option( '_cartflows_facebook', $new_settings, false );

	}

	/**
	 * Save settings.
	 *
	 * @return void
	 */
	public function save_google_analytics_settings() {

		$new_settings = array();

		if ( isset( $_POST['_cartflows_google_analytics'] ) ) { //phpcs:ignore
			$new_settings = $this->sanitize_form_inputs( wp_unslash( $_POST['_cartflows_google_analytics'] ) ); //phpcs:ignore
		}

		$this->update_admin_settings_option( '_cartflows_google_analytics', $new_settings, true );
	}

	/**
	 * Save settings.
	 *
	 * @return void
	 */
	public function save_permalink_settings() {

		if ( isset( $_POST['reset'] ) ) { //phpcs:ignore
			$_POST['_cartflows_permalink'] = array(
				'permalink'           => CARTFLOWS_STEP_POST_TYPE,
				'permalink_flow_base' => CARTFLOWS_FLOW_POST_TYPE,
				'permalink_structure' => '',
			);

		}
		$new_settings = array();
		if ( isset( $_POST['_cartflows_permalink'] ) ) { //phpcs:ignore
			$cartflows_permalink_settings = $this->sanitize_form_inputs( wp_unslash( $_POST['_cartflows_permalink'] ) ); //phpcs:ignore

			if ( empty( $cartflows_permalink_settings['permalink'] ) ) {
				$new_settings['permalink'] = CARTFLOWS_STEP_POST_TYPE;
			} else {
				$new_settings['permalink'] = $cartflows_permalink_settings['permalink'];
			}

			if ( empty( $cartflows_permalink_settings['permalink_flow_base'] ) ) {
				$new_settings['permalink_flow_base'] = CARTFLOWS_FLOW_POST_TYPE;
			} else {
				$new_settings['permalink_flow_base'] = $cartflows_permalink_settings['permalink_flow_base'];
			}

			$new_settings['permalink_structure'] = $cartflows_permalink_settings['permalink_structure'];

		}

		$this->update_admin_settings_option( '_cartflows_permalink', $new_settings, false );

		update_option( 'cartflows_permalink_refresh', true );
	}

	/**
	 * Update admin settings.
	 *
	 * @param string $key key.
	 * @param bool   $value key.
	 * @param bool   $network network.
	 */
	public function update_admin_settings_option( $key, $value, $network = false ) {

		// Update the site-wide option since we're in the network admin.
		if ( $network && is_multisite() ) {
			update_site_option( $key, $value );
		} else {
			update_option( $key, $value );
		}

	}

	/**
	 * Save settings.
	 *
	 * @param array $input_settings settimg data.
	 */
	public function sanitize_form_inputs( $input_settings = array() ) {
		$new_settings = array();
		foreach ( $input_settings as $key => $val ) {

			if ( is_array( $val ) ) {
				foreach ( $val as $k => $v ) {
					$new_settings[ $key ][ $k ] = ( isset( $val[ $k ] ) ) ? sanitize_text_field( $v ) : '';
				}
			} else {
				$new_settings[ $key ] = ( isset( $input_settings[ $key ] ) ) ? sanitize_text_field( $val ) : '';
			}
		}
		return $new_settings;
	}
}
