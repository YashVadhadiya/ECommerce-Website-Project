<?php
/**
 * CartFlows Debugger.
 *
 * @package CartFlows
 */

namespace CartflowsAdmin\AdminCore\Inc;

use CartflowsAdmin\AdminCore\Inc\AdminHelper;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WcfDebugger.
 */
class WcfDebugger {

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
	 * Instance
	 *
	 * @access private
	 * @var string Class object.
	 * @since 1.0.0
	 */
	private $menu_slug;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->wcf_display_logs();
	}


	/**
	 * Show the log page contents for file log handler.
	 */
	public function wcf_display_logs() {

		if ( ! empty( $_REQUEST['handle'] ) ) { //phpcs:ignore

			$this->wcf_delete_log_file();
		}

		$logs = $this->wcf_get_log_files();

		$form_url = esc_url(
			add_query_arg(
				array(
					'page'   => 'cartflows',
					'action' => 'wcf-log',
				),
				admin_url( '/admin.php' )
			)
		);

		if ( ! empty( $_REQUEST['log_file'] ) && isset( $logs[ sanitize_title( wp_unslash( $_REQUEST['log_file'] ) ) ] ) ) { //phpcs:ignore
			$viewed_log = $logs[ sanitize_title( wp_unslash( $_REQUEST['log_file'] ) ) ]; //phpcs:ignore
		} elseif ( ! empty( $logs ) ) {
			$viewed_log = current( $logs );
		}
		$handle = ! empty( $viewed_log ) ? $this->wcf_get_log_file_handle( $viewed_log ) : '';

		include_once CARTFLOWS_ADMIN_CORE_DIR . 'views/debugger.php';
	}

	/**
	 * Return the log file handle.
	 *
	 * @param string $filename Filename to get the handle for.
	 * @return string
	 */
	public function wcf_get_log_file_handle( $filename ) {
		return substr( $filename, 0, strlen( $filename ) > 48 ? strlen( $filename ) - 48 : strlen( $filename ) - 4 );
	}

	/**
	 * Get all log files in the log directory.
	 *
	 * @return array
	 */
	public function wcf_get_log_files() {
		$files  = scandir( CARTFLOWS_LOG_DIR );
		$result = array();

		if ( ! empty( $files ) ) {
			foreach ( $files as $key => $value ) {
				if ( ! in_array( $value, array( '.', '..' ), true ) ) {
					if ( ! is_dir( $value ) && strstr( $value, '.log' ) ) {
						$result[ sanitize_title( $value ) ] = $value;
					}
				}
			}
		}

		return $result;
	}

	/**
	 * Delete Provided log file
	 */
	public function wcf_delete_log_file() {

		if ( ! isset( $_REQUEST['_wpnonce'] ) || empty( $_REQUEST['_wpnonce'] )
			|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'remove_log' ) ) {

				wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'cartflows' ) );
		}

			wp_delete_file( CARTFLOWS_LOG_DIR . rtrim( $_REQUEST['handle'], '-log' ) . '.log' ); //phpcs:ignore

			echo "<div class='updated inline wcf-delete-log--message'> Log deleted successfully! </div>";
	}


}

WcfDebugger::get_instance();
