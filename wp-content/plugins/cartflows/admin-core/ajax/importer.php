<?php
/**
 * Importer
 *
 * @package CartFlows
 */

namespace CartflowsAdmin\AdminCore\Ajax;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CartflowsAdmin\AdminCore\Inc\AdminMenu;
use CartflowsAdmin\AdminCore\Ajax\AjaxBase;
use CartflowsAdmin\AdminCore\Inc\AdminHelper;

/**
 * Importer.
 */
class Importer extends AjaxBase {

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
	 * Register AJAX Events.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_ajax_events() {

		$ajax_events = array(
			'create_flow',
			'import_flow',

			'create_step',

			'import_step',

			'activate_plugin',

			'sync_library',
			'request_count',
			'import_sites',
			'update_library_complete',
			'export_flow',

			'get_flows_list',

			'import_json_flow',
			'export_all_flows',
		);

		$this->init_ajax_events( $ajax_events );

		add_action( 'admin_footer', array( $this, 'json_importer_popup_wrapper' ) );
	}

	/**
	 * Export Flows.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function export_all_flows() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		if ( ! check_ajax_referer( 'cartflows_export_all_flows', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		$export = \CartFlows_Importer::get_instance();
		$flows  = $export->get_all_flow_export_data();
		$flows  = apply_filters( 'cartflows_export_data', $flows );

		if ( ! empty( $flows ) && is_array( $flows ) && count( $flows ) > 0 ) {

			$response_data = array(
				'message' => __( 'Flows exported successfully', 'cartflows' ),
				'flows'   => $flows,
				'export'  => true,
			);

		} else {
			$response_data = array(
				'message' => __( 'No flows to export', 'cartflows' ),
				'flows'   => $flows,
				'export'  => false,
			);
		}

		wp_send_json_success( $response_data );

	}

	/**
	 * Import the Flow.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function import_json_flow() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_import_json_flow', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		$flow_data = ( isset( $_POST['flow_data'] ) ) ? json_decode( stripslashes( $_POST['flow_data'] ), true ) : array(); // phpcs:ignore

		$response_data = array(
			'message'      => 'Error occured. Flow not imported.',
			'flow_data'    => $flow_data,
			'redirect_url' => admin_url( 'admin.php?page=' . CARTFLOWS_SLUG ),
		);

		if ( is_array( $flow_data ) ) {
			$imported_flow = \CartFlows_Importer::get_instance()->import_from_json_data( $flow_data );

			$response_data['message']      = 'Flows Imported successfully';
			$response_data['redirect_url'] = admin_url( 'admin.php?page=' . CARTFLOWS_SLUG . '&path=flows' );

		}

		wp_send_json_success( $response_data );
	}

	/**
	 * Import Wrapper.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function json_importer_popup_wrapper() {
		echo '<div id="wcf-json-importer"></div>';
	}

	/**
	 * Export Step
	 */
	public function export_flow() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_export_flow', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}
		$flow_id    = ( isset( $_POST['flow_id'] ) ) ? absint( $_POST['flow_id'] ) : ''; // phpcs:ignore

		if ( ! $flow_id ) {
			$response_data = array( 'message' => __( 'Invalid flow ID.', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		$flows[] = \CartFlows_Importer::get_instance()->get_flow_export_data( $flow_id );
		$flows   = apply_filters( 'cartflows_export_data', $flows );

		$response_data = array(
			'message'   => __( 'Flow exported successfully', 'cartflows' ),
			'flow_name' => sanitize_title( get_the_title( $flow_id ) ),
			'flows'     => $flows,
		);
		wp_send_json_success( $response_data );

	}

	/**
	 * Update library complete
	 */
	public function update_library_complete() {
		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_update_library_complete', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		\CartFlows_Batch_Process::get_instance()->update_latest_checksums();

		update_site_option( 'cartflows-batch-is-complete', 'no', 'no' );
		update_site_option( 'cartflows-manual-sync-complete', 'yes', 'no' );

		$response_data = array( 'message' => 'SUCCESS: cartflows_import_sites' );
		wp_send_json_success( $response_data );
	}

	/**
	 * Import Sites
	 */
	public function import_sites() {
		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_import_sites', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		$page_no = isset( $_POST['page_no'] ) ? absint( $_POST['page_no'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( $page_no ) {
			$sites_and_pages = \Cartflows_Batch_Processing_Sync_Library::get_instance()->import_sites( $page_no );
			wp_send_json_success(
				array(
					'message'         => 'SUCCESS: cartflows_import_sites',
					'sites_and_pages' => $sites_and_pages,
				)
			);
		}

		wp_send_json_error(
			array(
				'message' => 'SUCCESS: cartflows_import_sites',
			)
		);
	}

	/**
	 * Sync Library
	 */
	public function sync_library() {
		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_sync_library', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		/**
		 * LOGIC
		 */
		if ( 'no' === \CartFlows_Batch_Process::get_instance()->get_last_export_checksums() ) {
			wp_send_json_success( 'updated' );
		}

		$status = \CartFlows_Batch_Process::get_instance()->test_cron();
		if ( is_wp_error( $status ) ) {
			$import_with = 'ajax';
		} else {
			$import_with = 'batch';
			// Process import.
			\CartFlows_Batch_Process::get_instance()->process_batch();
		}

		$response_data = array(
			'message' => 'SUCCESS: cartflows_sync_library',
			'status'  => $import_with,
		);

		wp_send_json_success( $response_data );
	}

	/**
	 * Request Count
	 */
	public function request_count() {
		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_request_count', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		$total_requests = \CartFlows_Batch_Process::get_instance()->get_total_requests();
		if ( $total_requests ) {
			wp_send_json_success(
				array(
					'message' => 'SUCCESS: cartflows_request_count',
					'count'   => $total_requests,
				)
			);
		}

		wp_send_json_error(
			array(
				'message' => 'ERROR: cartflows_request_count',
				'count'   => $total_requests,
			)
		);
	}

	/**
	 * Create Step
	 */
	public function create_step() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_create_step', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		wcf()->logger->import_log( 'STARTED! Importing Step' );

		$flow_id    = ( isset( $_POST['flow_id'] ) ) ? esc_attr( $_POST['flow_id'] ) : ''; // phpcs:ignore
		$step_type  = ( isset( $_POST['step_type'] ) ) ? esc_attr( $_POST['step_type'] ) : ''; // phpcs:ignore
		$step_title = ( isset( $_POST['step_title'] ) ) ? esc_attr( $_POST['step_title'] ) : ''; // phpcs:ignore
		$step_title = isset( $_POST['step_name'] ) && ! empty( $_POST['step_name'] ) ? sanitize_text_field( wp_unslash( $_POST['step_name'] ) ) : $step_title;

		// Create new step.
		$new_step_id = \CartFlows_Importer::get_instance()->create_step( $flow_id, $step_type, $step_title );

		if ( empty( $new_step_id ) ) {
			/* translators: %s: step ID */
			wp_send_json_error( sprintf( __( 'Invalid step id %1$s.', 'cartflows' ), $new_step_id ) );
		}

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message'      => __( 'Successfully created the step!', 'cartflows' ),
			'redirect_url' => admin_url( 'post.php?action=edit&post=' . $new_step_id ),
		);
		wp_send_json_success( $response_data );

	}

	/**
	 * Active Plugin
	 */
	public function activate_plugin() {
		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_activate_plugin', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		\wp_clean_plugins_cache();

		$plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : ''; // phpcs:ignore

		$activate = \activate_plugin( $plugin_init, '', false, true );

		if ( is_wp_error( $activate ) ) {
			wp_send_json_error(
				array(
					'success' => false,
					'message' => $activate->get_error_message(),
				)
			);
		}

		wp_send_json_success(
			array(
				'message' => 'Plugin activated successfully.',
			)
		);
	}

	/**
	 * Create the Flow.
	 */
	public function create_flow() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_create_flow', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		// Create post object.
		$new_flow_post = array(
			'post_title'   => isset( $_POST['flow_name'] ) ? sanitize_text_field( wp_unslash( $_POST['flow_name'] ) ) : '',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => CARTFLOWS_FLOW_POST_TYPE,
		);

		// Insert the post into the database.
		$flow_id = wp_insert_post( $new_flow_post );

		if ( is_wp_error( $flow_id ) ) {
			wp_send_json_error( $flow_id->get_error_message() );
		}

		$flow_steps = array();

		if ( wcf()->is_woo_active ) {
			$steps_data = array(
				'sales'              => array(
					'title' => __( 'Sales Landing', 'cartflows' ),
					'type'  => 'landing',
				),
				'order-form'         => array(
					'title' => __( 'Checkout (Woo)', 'cartflows' ),
					'type'  => 'checkout',
				),
				'order-confirmation' => array(
					'title' => __( 'Thank You (Woo)', 'cartflows' ),
					'type'  => 'thankyou',
				),
			);
		} else {
			$steps_data = array(
				'landing'  => array(
					'title' => __( 'Landing', 'cartflows' ),
					'type'  => 'landing',
				),
				'thankyou' => array(
					'title' => __( 'Thank You', 'cartflows' ),
					'type'  => 'landing',
				),
			);
		}

		foreach ( $steps_data as $slug => $data ) {

			$post_content = '';
			$step_type    = trim( $data['type'] );

			// Create new step.
			$step_id = wp_insert_post(
				array(
					'post_type'    => CARTFLOWS_STEP_POST_TYPE,
					'post_title'   => $data['title'],
					'post_content' => $post_content,
					'post_status'  => 'publish',
				)
			);

			// Return the error.
			if ( is_wp_error( $step_id ) ) {
				wp_send_json_error( $step_id->get_error_message() );
			}

			if ( $step_id ) {

				$flow_steps[] = array(
					'id'    => $step_id,
					'title' => $data['title'],
					'type'  => $step_type,
				);

				// Insert post meta.
				update_post_meta( $step_id, 'wcf-flow-id', $flow_id );
				update_post_meta( $step_id, 'wcf-step-type', $step_type );

				// Set taxonomies.
				wp_set_object_terms( $step_id, $step_type, CARTFLOWS_TAXONOMY_STEP_TYPE );
				wp_set_object_terms( $step_id, 'flow-' . $flow_id, CARTFLOWS_TAXONOMY_STEP_FLOW );

				update_post_meta( $step_id, '_wp_page_template', 'cartflows-default' );
			}
		}

		update_post_meta( $flow_id, 'wcf-steps', $flow_steps );

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message'      => __( 'Successfully created the Flow!', 'cartflows' ),
			'redirect_url' => admin_url( 'post.php?action=edit&post=' . $flow_id ),
			'flow_id'      => $flow_id,
		);
		wp_send_json_success( $response_data );
	}

	/**
	 * Create the Flow.
	 */
	public function import_flow() {

		wcf()->logger->import_log( 'STARTED! Importing Flow' );

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_import_flow', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		$flow = isset( $_POST['flow'] ) ? json_decode( stripslashes( $_POST['flow'] ), true ) : array(); // phpcs:ignore

		// Get single step Rest API response.
		$response = \CartFlows_API::get_instance()->get_flow( $flow['ID'] );

		if ( is_wp_error( $response['data'] ) ) {

			$btn = __( 'Request timeout error. Please check if the firewall or any security plugin is blocking the outgoing HTTP/HTTPS requests to templates.cartflows.com or not. <br><br>To resolve this issue, please check this <a target="_blank" href="https://cartflows.com/docs/request-timeout-error-while-importing-the-flow-step-templates/">article</a>.', 'cartflows' );

			wp_send_json_error(
				array(
					'message'        => $response['data']->get_error_message(),
					'call_to_action' => $btn,
					'data'           => $response,
				)
			);
		}

		$license_status = isset( $response['data']['licence_status'] ) ? $response['data']['licence_status'] : '';

		// If license is invalid then.
		if ( 'valid' !== $license_status ) {

			$cf_pro_status = AdminMenu::get_instance()->get_plugin_status( 'cartflows-pro/cartflows-pro.php' );

			$cta = '';
			$btn = '';
			if ( 'not-installed' === $cf_pro_status ) {
				/* translators: %1$s: link html start, %2$s: link html end*/
				$btn = sprintf( __( 'CartFlows Pro Required! %1$sUpgrade to CartFlows Pro%2$s', 'cartflows' ), '<a target="_blank" href="https://cartflows.com/">', '</a>' );
				/* translators: %1$s: link html start, %2$s: link html end*/
				$cta = sprintf( __( 'To import the premium flow %1$supgrade to CartFlows Pro%2$s.', 'cartflows' ), '<a target="_blank" href="https://cartflows.com/">', '</a>' );
			} elseif ( 'inactive' === $cf_pro_status ) {
				/* translators: %1$s: link html start, %2$s: link html end*/
				$btn = sprintf( __( 'Activate the CartFlows Pro to import the flow! %1$sActivate CartFlows Pro%2$s', 'cartflows' ), '<a target="_blank" href="' . admin_url( 'plugins.php?plugin_status=search&paged=1&s=CartFlows+Pro' ) . '">', '</a>' );
				/* translators: %1$s: link html start, %2$s: link html end*/
				$cta = sprintf( __( 'To import the premium flow %1$sactivate Cartflows Pro%2$s and validate the license key.', 'cartflows' ), '<a target="_blank" href="' . admin_url( 'plugins.php?plugin_status=search&paged=1&s=CartFlows+Pro' ) . '">', '</a>' );
			} elseif ( 'active' === $cf_pro_status ) {
				/* translators: %1$s: link html start, %2$s: link html end*/
				$btn = sprintf( __( 'Invalid License Key! %1$sActivate CartFlows Pro%2$s', 'cartflows' ), '<a target="_blank" href="' . admin_url( 'plugins.php?cartflows-license-popup' ) . '">', '</a>' );
				/* translators: %1$s: link html start, %2$s: link html end*/
				$cta = sprintf( __( 'To import the premium flow %1$sactivate CartFlows Pro%2$s.', 'cartflows' ), '<a target="_blank" href="' . admin_url( 'plugins.php?cartflows-license-popup' ) . '">', '</a>' );
			}

			wp_send_json_error(
				array(
					'message'        => \ucfirst( $license_status ) . ' license key!',
					'call_to_action' => $btn,
					'data'           => $response,
				)
			);
		}

		if ( empty( $flow ) ) {
			$response_data = array( 'message' => __( 'Flows data not found.', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		/**
		 * Create Flow
		 */
		$new_flow_post = array(
			'post_title'   => isset( $_POST['flow_name'] ) ? sanitize_text_field( wp_unslash( $_POST['flow_name'] ) ) : '',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => CARTFLOWS_FLOW_POST_TYPE,
		);

		// Insert the post into the database.
		$new_flow_id = wp_insert_post( $new_flow_post );

		if ( is_wp_error( $new_flow_id ) ) {
			wp_send_json_error( $new_flow_id->get_error_message() );
		}

		wcf()->logger->import_log( '✓ Flow Created! Flow ID: ' . $new_flow_id . ' - Remote Flow ID - ' . $flow['ID'] );

		/**
		 * All Import Steps
		 */
		$steps = isset( $flow['steps'] ) ? $flow['steps'] : array();

		foreach ( $steps as $key => $step ) {
			$this->import_single_step(
				array(
					'step' => array(
						'id'    => $step['ID'],
						'title' => $step['title'],
						'type'  => $step['type'],
					),
					'flow' => array(
						'id' => $new_flow_id,
					),
				)
			);
		}

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message'      => __( 'Successfully imported the Flow!', 'cartflows' ),
			'items'        => $flow,
			'redirect_url' => admin_url( 'post.php?action=edit&post=' . $new_flow_id ),
			'new_flow_id'  => $new_flow_id,
		);

		wcf()->logger->import_log( 'COMPLETE! Importing Flow' );

		wp_send_json_success( $response_data );
	}

	/**
	 * Import Step
	 *
	 * @return void
	 */
	public function import_step() {

		wcf()->logger->import_log( 'STARTED! Importing Step' );

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_import_step', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		$step    = isset( $_POST['step'] ) ? json_decode( stripslashes( $_POST['step'] ), true ) : array(); // phpcs:ignore
		$flow_id = isset( $_POST['flow_id'] ) ? absint( $_POST['flow_id'] ) : 0;

		$remote_flow_id = isset( $_POST['remote_flow_id'] ) ? absint( $_POST['remote_flow_id'] ) : 0;

		// Get single step Rest API response.
		$response       = \CartFlows_API::get_instance()->get_flow( $remote_flow_id );
		$license_status = isset( $response['data']['licence_status'] ) ? $response['data']['licence_status'] : '';

		// If license is invalid then.
		if ( 'valid' !== $license_status ) {

			$cf_pro_status = AdminMenu::get_instance()->get_plugin_status( 'cartflows-pro/cartflows-pro.php' );

			$cta = '';
			if ( 'not-installed' === $cf_pro_status ) {
				$cta = '<a target="_blanks" href="https://cartflows.com/">Upgrade to Cartflows Pro</a>';
			} elseif ( 'inactive' === $cf_pro_status ) {
				$cta = '<a target="_blank" href="' . admin_url( 'plugins.php?plugin_status=search&paged=1&s=CartFlows+Pro' ) . '">Activate Cartflows Pro</a>';
			} elseif ( 'active' === $cf_pro_status ) {
				$cta = '<a target="_blank" href="' . admin_url( 'plugins.php?cartflows-license-popup' ) . '">Activate Cartflows Pro</a>.';
			}

			wp_send_json_error(
				array(
					'message' => \ucfirst( $license_status ) . ' license key! ' . $cta,
					'data'    => $response,
				)
			);
		}

		if ( empty( $remote_flow_id ) ) {
			$response_data = array( 'message' => __( 'Flows data not found.', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}
		$step['title'] = isset( $_POST['step_name'] ) && ! empty( $_POST['step_name'] ) ? sanitize_text_field( wp_unslash( $_POST['step_name'] ) ) : $step['title'];
		// Create steps.
		$this->import_single_step(
			array(
				'step' => array(
					'id'    => $step['ID'],
					'title' => $step['title'],
					'type'  => $step['type'],
				),
				'flow' => array(
					'id' => $flow_id,
				),
			)
		);

		wcf()->logger->import_log( 'COMPLETE! Importing Step' );

		if ( empty( $step ) ) {
			$response_data = array( 'message' => __( 'Step data not found.', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		/**
		 * Redirect to the new step edit screen
		 */
		$response_data = array(
			'message' => __( 'Successfully imported the Step!', 'cartflows' ),
		);

		wcf()->logger->import_log( 'COMPLETE! Importing Step' );

		wp_send_json_success( $response_data );

	}

	/**
	 * Create Simple Step
	 *
	 * @param array $args Rest API Arguments.
	 * @return void
	 */
	public function import_single_step( $args = array() ) {

		wcf()->logger->import_log( 'STARTED! Importing Step' );

		$step_id    = isset( $args['step']['id'] ) ? absint( $args['step']['id'] ) : 0;
		$step_title = isset( $args['step']['title'] ) ? $args['step']['title'] : '';
		$step_type  = isset( $args['step']['type'] ) ? $args['step']['type'] : '';
		$flow_id    = isset( $args['flow']['id'] ) ? absint( $args['flow']['id'] ) : '';

		// Create new step.
		$new_step_id = \CartFlows_Importer::get_instance()->create_step( $flow_id, $step_type, $step_title );

		if ( empty( $step_id ) || empty( $new_step_id ) ) {
			/* translators: %s: step ID */
			wp_send_json_error( sprintf( __( 'Invalid step id %1$s or post id %2$s.', 'cartflows' ), $step_id, $new_step_id ) );
		}

		wcf()->logger->import_log( 'Remote Step ' . $step_id . ' for local flow "' . get_the_title( $new_step_id ) . '" [' . $new_step_id . ']' );

		// Get single step Rest API response.
		$response = \CartFlows_API::get_instance()->get_template( $step_id );
		wcf()->logger->import_log( wp_json_encode( $response ) );

		if ( 'divi' === \Cartflows_Helper::get_common_setting( 'default_page_builder' ) ) {
			if ( isset( $response['data']['divi_content'] ) && ! empty( $response['data']['divi_content'] ) ) {

				update_post_meta( $new_step_id, 'divi_content', $response['data']['divi_content'] );

				wp_update_post(
					array(
						'ID'           => $new_step_id,
						'post_content' => $response['data']['divi_content'],
					)
				);
			}
		}

		if ( 'gutenberg' === \Cartflows_Helper::get_common_setting( 'default_page_builder' ) ) {
			if ( isset( $response['data']['divi_content'] ) && ! empty( $response['data']['divi_content'] ) ) {
				wp_update_post(
					array(
						'ID'           => $new_step_id,
						'post_content' => $response['data']['divi_content'],
					)
				);
			}
		}

		/* Imported Step */
		update_post_meta( $new_step_id, 'cartflows_imported_step', 'yes' );

		// Import Post Meta.
		$this->import_post_meta( $new_step_id, $response );

		do_action( 'cartflows_import_complete' );

		// Batch Process.
		do_action( 'cartflows_after_template_import', $new_step_id, $response );

		wcf()->logger->import_log( 'COMPLETE! Importing Step' );

	}

	/**
	 * Import Post Meta
	 *
	 * @since 1.0.0
	 *
	 * @param  integer $post_id  Post ID.
	 * @param  array   $response  Post meta.
	 * @return void
	 */
	public function import_post_meta( $post_id, $response ) {

		$metadata = (array) $response['post_meta'];

		$exclude_meta_keys = array(
			'wcf-checkout-products',
			'wcf-optin-product',
			'wcf-offer-product',
			'wcf-order-bump-product',
			'wcf-pre-checkout-offer-product',
		);

		foreach ( $metadata as $meta_key => $meta_value ) {

			if ( in_array( $meta_key, $exclude_meta_keys, true ) ) {
				continue;
			}

			$meta_value = isset( $meta_value[0] ) ? $meta_value[0] : '';

			if ( $meta_value ) {

				if ( is_serialized( $meta_value, true ) ) {
					$raw_data = maybe_unserialize( stripslashes( $meta_value ) );
				} elseif ( is_array( $meta_value ) ) {
					$raw_data = json_decode( stripslashes( $meta_value ), true );
				} else {
					$raw_data = $meta_value;
				}

				if ( '_elementor_data' === $meta_key ) {
					if ( is_array( $raw_data ) ) {
						$raw_data = wp_slash( wp_json_encode( $raw_data ) );
					} else {
						$raw_data = wp_slash( $raw_data );
					}
				}
				if ( '_elementor_data' !== $meta_key && '_elementor_draft' !== $meta_key && '_fl_builder_data' !== $meta_key && '_fl_builder_draft' !== $meta_key ) {
					if ( is_array( $raw_data ) ) {
						wcf()->logger->import_log( '✓ Added post meta ' . $meta_key /* . ' | ' . wp_json_encode( $raw_data ) */ );
					} else {
						if ( ! is_object( $raw_data ) ) {
							wcf()->logger->import_log( '✓ Added post meta ' . $meta_key /* . ' | ' . $raw_data */ );
						}
					}
				}

				update_post_meta( $post_id, $meta_key, $raw_data );
			}
		}
	}


	/**
	 * Get flows list for preview
	 *
	 * @return void
	 */
	public function get_flows_list() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_get_flows_list', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		$flows_list = \Cartflows_Helper::get_instance()->get_flows_and_steps();

		/**
		 * Redirect to the new step edit screen
		 */
		$response_data = array(
			'message' => __( 'Successful!', 'cartflows' ),
			'flows'   => $flows_list,
		);

		wp_send_json_success( $response_data );
	}
}
