<?php
/**
 * CartFlows Admin Legacy.
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Cartflows_Legacy_Admin_Loader.
 */
class Cartflows_Legacy_Admin_Loader {

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
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		define( 'CARTFLOWS_LEGACY_ADMIN_DIR', CARTFLOWS_DIR . 'admin-legacy/' );
		define( 'CARTFLOWS_LEGACY_ADMIN_URL', CARTFLOWS_URL . 'admin-legacy/' );

		$this->setup_classes();
	}

	/**
	 * Include required classes.
	 */
	public function setup_classes() {
		include_once CARTFLOWS_LEGACY_ADMIN_DIR . 'class-cartflows-admin-classes.php';
		include_once CARTFLOWS_LEGACY_ADMIN_DIR . 'class-cartflows-legacy-importer.php';
		include_once CARTFLOWS_LEGACY_ADMIN_DIR . 'class-cartflows-meta.php';
		include_once CARTFLOWS_LEGACY_ADMIN_DIR . 'modules/class-cartflows-legacy-modules-meta.php';
	}
}

Cartflows_Legacy_Admin_Loader::get_instance();
