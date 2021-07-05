<?php
/**
 * Batch Processing
 *
 * @package Cartflows
 * @since x.x.x
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Cartflows_Batch_Processing_Sync_Library' ) ) :

	/**
	 * Cartflows_Batch_Processing_Sync_Library
	 *
	 * @since 1.0.14
	 */
	class Cartflows_Batch_Processing_Sync_Library {

		/**
		 * Instance
		 *
		 * @since 1.0.14
		 * @access private
		 * @var object Class object.
		 */
		private static $instance;

		/**
		 * Site slug
		 *
		 * @since x.x.x
		 * @access private
		 * @var string Site slug.
		 */
		private $site_slug;

		/**
		 * Site url
		 *
		 * @since x.x.x
		 * @access private
		 * @var string Site url.
		 */
		private $site_url;

		/**
		 * Initiator
		 *
		 * @since 1.0.14
		 * @return object initialized object of class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.0.14
		 */
		public function __construct() {
			$this->site_url  = wcf()->get_site_url();
			$this->site_slug = wcf()->get_site_slug();
		}

		/**
		 * Generate JSON file.
		 *
		 * @since x.x.x
		 *
		 * @param  string $filename File name.
		 * @param  array  $data     JSON file data.
		 * @return void.
		 */
		public function generate_file( $filename = '', $data = array() ) {
			$file = CARTFLOWS_DIR . 'admin-core/assets/importer-data/' . $filename . '.json';

			Cartflows_Helper::get_filesystem()->put_contents( $file, wp_json_encode( $data ) );
		}

		/**
		 * Import
		 *
		 * @since 1.0.14
		 * @since x.x.x Added page no.
		 *
		 * @param  integer $page Page number.
		 * @return array
		 */
		public function import_sites( $page = 1 ) {

			$api_args        = array(
				'timeout' => 30,
			);
			$sites_and_pages = array();

			wcf()->logger->sync_log( 'Requesting ' . $page );

			update_site_option( 'cartflows-batch-status-string', 'Requesting ' . $page, 'no' );

			$query_args = apply_filters(
				'cartflows_import_query_args',
				array(
					'per_page' => 15,
					'page'     => $page,
				)
			);

			$api_url = add_query_arg( $query_args, $this->site_url . 'wp-json/cartflows-server/v1/flows-and-steps/' );

			$response = wp_remote_get( $api_url, $api_args );
			if ( ! is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 200 ) {
				$sites_and_pages = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( isset( $sites_and_pages['code'] ) ) {
					$message = isset( $sites_and_pages['message'] ) ? $sites_and_pages['message'] : '';
					if ( ! empty( $message ) ) {
						wcf()->logger->sync_log( 'HTTP Request Error: ' . $message );
					} else {
						wcf()->logger->sync_log( 'HTTP Request Error!' );
					}
				} else {
					$option_name = 'cartflows-' . $this->site_slug . '-flows-and-steps-' . $page;

					update_site_option( 'cartflows-batch-status-string', 'Storing data for page ' . $page . ' in option ' . $option_name );

					update_site_option( $option_name, $sites_and_pages['flows'] );

					if ( defined( 'WP_CLI' ) ) {
						$this->generate_file( $option_name, $sites_and_pages['flows'] );
					}
				}
			} else {
				wcf()->logger->sync_log( 'API Error: ' . $response->get_error_message() );
			}

			wcf()->logger->sync_log( 'Complete storing data for page ' . $page );
			update_site_option( 'cartflows-batch-status-string', 'Complete storing data for page ' . $page, 'no' );

			return $sites_and_pages;
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Cartflows_Batch_Processing_Sync_Library::get_instance();

endif;
