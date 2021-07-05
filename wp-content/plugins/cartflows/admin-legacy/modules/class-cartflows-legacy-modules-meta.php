<?php
/**
 * Modules Loader
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initial Setup
 *
 * @since 1.0.0
 */
class Cartflows_Legacy_Modules_Meta {


	/**
	 * Member Variable
	 *
	 * @var object instance
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor function that initializes required actions and hooks
	 */
	public function __construct() {

		require_once CARTFLOWS_LEGACY_ADMIN_DIR . 'modules/flow/class-cartflows-flow-meta.php';

		require_once CARTFLOWS_LEGACY_ADMIN_DIR . 'modules/landing/class-cartflows-landing-meta.php';

		if ( wcf()->is_woo_active ) {
			require_once CARTFLOWS_LEGACY_ADMIN_DIR . 'modules/checkout/class-cartflows-checkout-meta.php';
			require_once CARTFLOWS_LEGACY_ADMIN_DIR . 'modules/thankyou/class-cartflows-thankyou-meta.php';
			require_once CARTFLOWS_LEGACY_ADMIN_DIR . 'modules/optin/class-cartflows-optin-meta.php';

		}
	}
}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Cartflows_Legacy_Modules_Meta::get_instance();
