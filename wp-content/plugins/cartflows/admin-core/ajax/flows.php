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
use CartflowsAdmin\AdminCore\Inc\MetaOps;

/**
 * Class Flows.
 */
class Flows extends AjaxBase {

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
	 * Register ajax events.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_ajax_events() {

		$ajax_events = array(
			'update_flow_title',
			'clone_flow',
			'delete_flow',
			'trash_flow',
			'restore_flow',
			'reorder_flow_steps',
			'trash_flows_in_bulk',
			'update_flow_post_status',
			'delete_flows_permanently',
			'save_flow_meta_settings',
			'export_flows_in_bulk',
			'update_status',
		);

		$this->init_ajax_events( $ajax_events );
	}

	/**
	 * Export the flows and it's data.
	 */
	public function export_flows_in_bulk() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_export_flows_in_bulk', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( ! isset( $_POST['flow_ids'] ) ) {
			$response_data = array( 'message' => __( 'No Flow IDs has been supplied to export!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		$flow_ids = array_map( 'intval', explode( ',', wp_unslash($_POST['flow_ids']) ) ); //phpcs:ignore

		$flows  = array();
		$export = \CartFlows_Importer::get_instance();
		foreach ( $flow_ids as $key => $flow_id ) {
			$flows[] = $export->get_flow_export_data( $flow_id );
		}

		$response_data = array(
			'message' => __( 'Flows exported successfully', 'cartflows' ),
			'flows'   => $flows,
		);

		wp_send_json_success( $response_data );

	}

	/**
	 * Save flow meta data.
	 */
	public function save_flow_meta_settings() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_save_flow_meta_settings', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		$response_data = array(
			'status' => false,
			'text'   => __( 'Can\'t update the flow data', 'cartflows' ),
		);

		if ( isset( $_POST['flow_id'] ) ) {
			$flow_id = intval( $_POST['flow_id'] );

			if ( empty( $flow_id ) ) {
				wp_send_json_success( $response_data );
			}

			$new_flow_title = isset( $_POST['post_title'] ) ? sanitize_text_field( wp_unslash( $_POST['post_title'] ) ) : get_the_title( $flow_id );

			if ( '' === $new_flow_title ) {
				$new_flow_title = __( '(no title)', 'cartflows' );
			}

			$new_flow_slug = isset( $_POST['post_name'] ) ? sanitize_text_field( wp_unslash( $_POST['post_name'] ) ) : '';

			$post_meta = wcf()->options->get_flow_fields( $flow_id );
			MetaOps::save_meta_fields( $flow_id, $post_meta );
		}

		$new_flow_data = array(
			'ID'         => $flow_id,
			'post_title' => $new_flow_title,
			'post_name'  => $new_flow_slug,
		);

		wp_update_post( $new_flow_data );

		$response_data = array(
			'message' => __( 'Successfully saved the flow data!', 'cartflows' ),
		);
		wp_send_json_success( $response_data );
	}

	/**
	 * Delete the flow and it's data.
	 */
	public function delete_flows_permanently() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_delete_flows_permanently', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		$flow_ids = isset( $_POST['flow_ids'] ) ? array_map( 'intval', explode( ',', wp_unslash( $_POST['flow_ids'] ) ) ) : array(); //phpcs:ignore

		foreach ( $flow_ids as $key => $flow_id ) {
			/* Get Steps */
			$steps = get_post_meta( $flow_id, 'wcf-steps', true );

			/* delte All steps */
			if ( $steps && is_array( $steps ) ) {
				foreach ( $steps as $step ) {

					/* Need to delete ab test data as well */
					wp_delete_post( $step['id'], true );
				}
			}
			/* Trash term */
			$term_data = term_exists( 'flow-' . $flow_id, CARTFLOWS_TAXONOMY_STEP_FLOW );

			if ( is_array( $term_data ) ) {
				wp_trash_post( $term_data['term_id'], CARTFLOWS_TAXONOMY_STEP_FLOW );
			}

			/* Finally trash flow post and it's data */
				wp_delete_post( $flow_id, true );
		}

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message' => __( 'Successfully deleted the Flows!', 'cartflows' ),
		);
		wp_send_json_success( $response_data );
	}

	/**
	 * Update flow status.
	 */
	public function update_flow_post_status() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_update_flow_post_status', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( ! isset( $_POST['flow_ids'] ) ) {
			$response_data = array( 'message' => __( 'No Flow IDs has been supplied to delete!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		$flow_ids = isset( $_POST['flow_ids'] ) ? array_map( 'intval', explode( ',', wp_unslash( $_POST['flow_ids'] ) ) ) : array(); //phpcs:ignore

		$new_status = isset( $_POST['new_status'] ) ? sanitize_text_field( wp_unslash( $_POST['new_status'] ) ) : '';

		foreach ( $flow_ids as $key => $flow_id ) {
			/* Get Steps */
			$steps = get_post_meta( $flow_id, 'wcf-steps', true );

			/* Trash All steps */
			if ( $steps && is_array( $steps ) ) {
				foreach ( $steps as $step ) {

					$my_post                = array();
					$my_post['ID']          = $step['id'];
					$my_post['post_status'] = $new_status;
					wp_update_post( wp_slash( $my_post ) );

				}
			}

			/*
			Trash term
				// $term_data = term_exists( 'flow-' . $flow_id, CARTFLOWS_TAXONOMY_STEP_FLOW );
				// if ( is_array( $term_data ) ) {
				// wp_trash_post( $term_data['term_id'], CARTFLOWS_TAXONOMY_STEP_FLOW );
				// }
			*/

			/* Finally trash flow post and it's data */
			$flow_post                = array();
			$flow_post['ID']          = $flow_id;
			$flow_post['post_status'] = $new_status;
			wp_update_post( $flow_post );
		}

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message' => __( 'Successfully trashed the Flows!', 'cartflows' ),
		);
		wp_send_json_success( $response_data );
	}


	/**
	 * Trash the flows and it's data.
	 */
	public function trash_flows_in_bulk() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_trash_flows_in_bulk', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( ! isset( $_POST['flow_ids'] ) ) {
			$response_data = array( 'message' => __( 'No Flow IDs has been supplied to delete!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		$flow_ids = isset( $_POST['flow_ids'] ) ? array_map( 'intval', explode( ',', wp_unslash( $_POST['flow_ids'] ) ) ) : array(); //phpcs:ignore

		foreach ( $flow_ids as $key => $flow_id ) {
			/* Get Steps */
			$steps = get_post_meta( $flow_id, 'wcf-steps', true );

			/* Trash All steps */
			if ( $steps && is_array( $steps ) ) {
				foreach ( $steps as $step ) {

					/* Need to delete ab test data as well */
					wp_trash_post( $step['id'], true );
				}
			}

			/* Trash term */
			$term_data = term_exists( 'flow-' . $flow_id, CARTFLOWS_TAXONOMY_STEP_FLOW );

			if ( is_array( $term_data ) ) {
				wp_trash_post( $term_data['term_id'], CARTFLOWS_TAXONOMY_STEP_FLOW );
			}

			/* Finally trash flow post and it's data */
			wp_trash_post( $flow_id, true );
		}

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message' => __( 'Successfully trashed the Flows!', 'cartflows' ),
		);
		wp_send_json_success( $response_data );
	}
	/**
	 * Update flow title.
	 */
	public function update_flow_title() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_update_flow_title', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( isset( $_POST['flow_id'] ) && isset( $_POST['new_flow_title'] ) ) {
			$flow_id  = intval( $_POST['flow_id'] ); //phpcs:ignore
			$new_flow_title = sanitize_text_field( $_POST['new_flow_title'] ); //phpcs:ignore
		}

		$result = array(
			'status' => false,
			'text'   => __( 'Can\'t update the flow title', 'cartflows' ),
		);

		if ( empty( $flow_id ) || empty( $new_flow_title ) ) {
			wp_send_json( $result );
		}

		$new_flow_data = array(
			'ID'         => $flow_id,
			'post_title' => $new_flow_title,
		);
		wp_update_post( $new_flow_data );

		$result = array(
			'status' => true,
			/* translators: %s flow id */
			'text'   => sprintf( __( 'Flow title updated - %s', 'cartflows' ), $flow_id ),
		);

		wp_send_json( $result );
	}

	/**
	 * Clone the Flow.
	 */
	public function clone_flow() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_clone_flow', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		/**
		 * Check flow id
		 */
		if ( empty( $_POST['id'] ) ) {
			$response_data = array( 'message' => __( 'No Flow ID has been supplied to clone!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		/**
		 * Get the original post id
		 */
		$post_id = absint( $_POST['id'] );

		/**
		 * And all the original post data then
		 */
		$post = get_post( $post_id );

		/**
		 * Assign current user to be the new post author
		 */
		$current_user    = wp_get_current_user();
		$new_post_author = $current_user->ID;

		/**
		 * If post data not exists, throw error
		 */
		if ( ! isset( $post ) || null === $post ) {
			$response_data = array( 'message' => __( 'Invalid Flow ID has been supplied to clone!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		global $wpdb;

		/**
		 * Let's start cloning
		 */

		/**
		 * New post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => $post->post_status,
			'post_title'     => $post->post_title . ' Clone',
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order,
		);

		/**
		 * Insert the post
		 */
		$new_flow_id = wp_insert_post( $args );

		/**
		 * Get all current post terms ad set them to the new post
		 *
		 * Returns array of taxonomy names for post type, ex array("category", "post_tag");.
		 */
		$taxonomies = get_object_taxonomies( $post->post_type );

		foreach ( $taxonomies as $taxonomy ) {

			$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );

			wp_set_object_terms( $new_flow_id, $post_terms, $taxonomy, false );
		}

		/**
		 * Duplicate all post meta just in two SQL queries
		 */
		// @codingStandardsIgnoreStart
		$post_meta_infos = $wpdb->get_results(
			"SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id"
		);
		// @codingStandardsIgnoreEnd

		if ( ! empty( $post_meta_infos ) ) {

			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) VALUES ";

			$sql_query_sel = array();

			foreach ( $post_meta_infos as $meta_info ) {

				$meta_key = $meta_info->meta_key;

				if ( '_wp_old_slug' === $meta_key ) {
					continue;
				}

				$meta_value = addslashes( $meta_info->meta_value );

				$sql_query_sel[] = "($new_flow_id, '$meta_key', '$meta_value')";
			}

			$sql_query .= implode( ',', $sql_query_sel );

			// @codingStandardsIgnoreStart
			$wpdb->query( $sql_query );
			// @codingStandardsIgnoreEnd
		}

		/* Steps Cloning */
		$flow_steps     = get_post_meta( $post_id, 'wcf-steps', true );
		$new_flow_steps = array();

		/* Set Steps Empty */
		update_post_meta( $new_flow_id, 'wcf-steps', $new_flow_steps );

		if ( is_array( $flow_steps ) && ! empty( $flow_steps ) ) {

			foreach ( $flow_steps as $index => $step_data ) {

				$step_id   = $step_data['id'];
				$step_type = get_post_meta( $step_id, 'wcf-step-type', true );

				$step_object = get_post( $step_id );

				/**
				 * New step post data array
				 */
				$step_args = array(
					'comment_status' => $step_object->comment_status,
					'ping_status'    => $step_object->ping_status,
					'post_author'    => $new_post_author,
					'post_content'   => $step_object->post_content,
					'post_excerpt'   => $step_object->post_excerpt,
					'post_name'      => $step_object->post_name,
					'post_parent'    => $step_object->post_parent,
					'post_password'  => $step_object->post_password,
					'post_status'    => $step_object->post_status,
					'post_title'     => $step_object->post_title,
					'post_type'      => $step_object->post_type,
					'to_ping'        => $step_object->to_ping,
					'menu_order'     => $step_object->menu_order,
				);

				/**
				 * Insert the post
				 */
				$new_step_id = wp_insert_post( $step_args );

				/**
				 * Duplicate all step meta
				 */
				// @codingStandardsIgnoreStart
				$post_meta_infos = $wpdb->get_results(
					"SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$step_id"
				);
				// @codingStandardsIgnoreEnd

				if ( ! empty( $post_meta_infos ) ) {

					$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) VALUES ";

					$sql_query_sel = array();

					foreach ( $post_meta_infos as $meta_info ) {

						$meta_key = $meta_info->meta_key;

						if ( '_wp_old_slug' === $meta_key || 'wcf-ab-test' === $meta_key ) {
							continue;
						}

						$meta_value = addslashes( $meta_info->meta_value );

						$sql_query_sel[] = "($new_step_id, '$meta_key', '$meta_value')";
					}

					$sql_query .= implode( ',', $sql_query_sel );

					// @codingStandardsIgnoreStart
					$wpdb->query( $sql_query );
					// @codingStandardsIgnoreEnd
				}

				// insert post meta.
				update_post_meta( $new_step_id, 'wcf-flow-id', $new_flow_id );
				update_post_meta( $new_step_id, 'wcf-step-type', $step_type );

				/**
				 * @ to_do later
				 * delete split test connecctivity
				 */

				wp_set_object_terms( $new_step_id, $step_type, CARTFLOWS_TAXONOMY_STEP_TYPE );
				wp_set_object_terms( $new_step_id, 'flow-' . $new_flow_id, CARTFLOWS_TAXONOMY_STEP_FLOW );

				/* Add New Flow Steps */
				$new_flow_steps[] = array(
					'id'    => $new_step_id,
					'title' => $step_object->post_title,
					'type'  => $step_type,
				);
			}
		}

		/* Update New Flow Step Post Meta */
		update_post_meta( $new_flow_id, 'wcf-steps', $new_flow_steps );

		/* Clear Page Builder Cache */
		AdminHelper::clear_cache();

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message'      => __( 'Successfully cloned the Flow!', 'cartflows' ),
			'redirect_url' => admin_url( 'post.php?action=edit&post=' . $new_flow_id ),
		);
		wp_send_json_success( $response_data );
	}

	/**
	 * Restore the flow and it's data.
	 */
	public function restore_flow() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_restore_flow', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( ! isset( $_POST['flow_id'] ) ) {
			$response_data = array( 'message' => __( 'No Flow ID has been supplied to delete!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		$flow_id = intval( $_POST['flow_id'] );

		/* Get Steps */
		$steps = get_post_meta( $flow_id, 'wcf-steps', true );

		/* Untrash All steps */
		if ( $steps && is_array( $steps ) ) {
			foreach ( $steps as $step ) {

				/* Need to delete ab test data as well */
				wp_untrash_post( $step['id'], true );
			}
		}

		/* Untrash term */
		$term_data = term_exists( 'flow-' . $flow_id, CARTFLOWS_TAXONOMY_STEP_FLOW );

		if ( is_array( $term_data ) ) {
			wp_untrash_post( $term_data['term_id'], CARTFLOWS_TAXONOMY_STEP_FLOW );
		}

		/* Finally untrash flow post and it's data */
		wp_untrash_post( $flow_id, true );

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message' => __( 'Successfully restored the Flow!', 'cartflows' ),
		);
		wp_send_json_success( $response_data );
	}

	/**
	 * Trash the flow and it's data.
	 */
	public function trash_flow() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_trash_flow', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( ! isset( $_POST['flow_id'] ) ) {
			$response_data = array( 'message' => __( 'No Flow ID has been supplied to delete!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		$flow_id = intval( $_POST['flow_id'] );

		/* Get Steps */
		$steps = get_post_meta( $flow_id, 'wcf-steps', true );

		/* Trash All steps */
		if ( $steps && is_array( $steps ) ) {
			foreach ( $steps as $step ) {

				/* Need to delete ab test data as well */
				wp_trash_post( $step['id'], true );
			}
		}

		/* Trash term */
		$term_data = term_exists( 'flow-' . $flow_id, CARTFLOWS_TAXONOMY_STEP_FLOW );

		if ( is_array( $term_data ) ) {
			wp_trash_post( $term_data['term_id'], CARTFLOWS_TAXONOMY_STEP_FLOW );
		}

		/* Finally trash flow post and it's data */
		wp_trash_post( $flow_id, true );

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message' => __( 'Successfully trashed the Flow!', 'cartflows' ),
		);
		wp_send_json_success( $response_data );
	}

	/**
	 * Delete the flow and it's data.
	 */
	public function delete_flow() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_delete_flow', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( ! isset( $_POST['flow_id'] ) ) {
			$response_data = array( 'message' => __( 'No Flow ID has been supplied to delete!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		$flow_id = intval( $_POST['flow_id'] );

		/* Get Steps */
		$steps = get_post_meta( $flow_id, 'wcf-steps', true );

		/* Delete All steps */
		if ( $steps && is_array( $steps ) ) {
			foreach ( $steps as $step ) {

				/* Need to delete ab test data as well */
				wp_delete_post( $step['id'], true );
			}
		}

		/* Delete term */
		$term_data = term_exists( 'flow-' . $flow_id, CARTFLOWS_TAXONOMY_STEP_FLOW );

		if ( is_array( $term_data ) ) {
			wp_delete_term( $term_data['term_id'], CARTFLOWS_TAXONOMY_STEP_FLOW );
		}

		/* Finally delete flow post and it's data */
		wp_delete_post( $flow_id, true );

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message' => __( 'Successfully deleted the Flow!', 'cartflows' ),
		);
		wp_send_json_success( $response_data );
	}

	/**
	 * Update status.
	 */
	public function update_status() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_update_status', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( ! isset( $_POST['flow_id'] ) ) {
			$response_data = array( 'message' => __( 'No Flow IDs has been supplied to delete!', 'cartflows' ) );
			wp_send_json_error( $response_data );
		}

		$flow_id = isset( $_POST['flow_id'] ) ? intval( $_POST['flow_id'] ) : 0;

		$new_status = isset( $_POST['new_status'] ) ? sanitize_text_field( wp_unslash( $_POST['new_status'] ) ) : '';

		/* Get Steps */
		$steps = get_post_meta( $flow_id, 'wcf-steps', true );

		/* Trash All steps */
		if ( $steps && is_array( $steps ) ) {
			foreach ( $steps as $step ) {

				$my_post                = array();
				$my_post['ID']          = $step['id'];
				$my_post['post_status'] = $new_status;
				wp_update_post( wp_slash( $my_post ) );

			}
		}

		/*
			Trash term
		// $term_data = term_exists( 'flow-' . $flow_id, CARTFLOWS_TAXONOMY_STEP_FLOW );

		// if ( is_array( $term_data ) ) {
		// wp_trash_post( $term_data['term_id'], CARTFLOWS_TAXONOMY_STEP_FLOW );
		// }
		*/

		/* Finally trash flow post and it's data */
		$flow_post                = array();
		$flow_post['ID']          = $flow_id;
		$flow_post['post_status'] = $new_status;
		wp_update_post( $flow_post );

		/**
		 * Redirect to the new flow edit screen
		 */
		$response_data = array(
			'message' => __( 'Successfully updated the Flow status!', 'cartflows' ),
		);
		wp_send_json_success( $response_data );
	}


	/**
	 * Prepare where items for query.
	 */
	public function reorder_flow_steps() {

		$response_data = array( 'message' => $this->get_error_msg( 'permission' ) );

		/**
		 * Check permission
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( $response_data );
		}

		/**
		 * Nonce verification
		 */
		if ( ! check_ajax_referer( 'cartflows_reorder_flow_steps', 'security', false ) ) {
			$response_data = array( 'message' => $this->get_error_msg( 'nonce' ) );
			wp_send_json_error( $response_data );
		}

		if ( isset( $_POST['post_id'] ) && isset( $_POST['step_ids'] ) ) {
			$flow_id  = intval( $_POST['post_id'] ); //phpcs:ignore
			$step_ids = explode( ',', $_POST['step_ids'] ); //phpcs:ignore
			$step_ids = array_map( 'intval', $step_ids );
		}
		$result = array(
			'status' => false,
			/* translators: %s flow id */
			'text'   => sprintf( __( 'Steps not sorted for flow - %s', 'cartflows' ), $flow_id ),
		);

		if ( ! $flow_id || ! is_array( $step_ids ) ) {
			wp_send_json( $result );
		}

		$flow_steps     = get_post_meta( $flow_id, 'wcf-steps', true );
		$flow_steps_map = array();

		foreach ( $flow_steps as $key => $value ) {
			$flow_steps_map[ $value['id'] ] = $value;
		}

		$new_flow_steps = array();

		foreach ( $step_ids as $index => $step_id ) {

			$new_flow_step_data = array();

			if ( isset( $flow_steps_map[ $step_id ] ) ) {
				$new_flow_step_data = $flow_steps_map[ $step_id ];
			}

			$new_flow_step_data['id']    = intval( $step_id );
			$new_flow_step_data['title'] = get_the_title( $step_id );
			$new_flow_step_data['type']  = get_post_meta( $step_id, 'wcf-step-type', true );

			$new_flow_steps[] = $new_flow_step_data;
		}

		update_post_meta( $flow_id, 'wcf-steps', $new_flow_steps );

		/* Setup steps data */
		$meta_options = AdminHelper::get_flow_meta_options( $flow_id );
		$steps        = AdminHelper::prepare_step_data( $flow_id, $meta_options );

		$result = array(
			'status' => true,
			/* translators: %s flow id */
			'text'   => sprintf( __( 'Steps sorted for flow - %s', 'cartflows' ), $flow_id ),
			'steps'  => $steps,
		);

		wp_send_json( $result );
	}

}
