<?php
/**
 * Cartflows Blocks Loader.
 *
 * @package Cartflows
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Cartflows_Block_Loader' ) ) {

	/**
	 * Class Cartflows_Block_Loader.
	 */
	final class Cartflows_Block_Loader {

		/**
		 * Member Variable
		 *
		 * @var instance
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
		 * Constructor
		 */
		public function __construct() {

			define( 'CF_TABLET_BREAKPOINT', '976' );
			define( 'CF_MOBILE_BREAKPOINT', '767' );

			$this->load_plugin();
		}

		/**
		 * Loads plugin files.
		 *
		 * @since x.x.x
		 *
		 * @return void
		 */
		public function load_plugin() {
			require_once CARTFLOWS_DIR . 'modules/gutenberg/classes/class-cartflows-gb-helper.php';
			require_once CARTFLOWS_DIR . 'modules/gutenberg/classes/class-cartflows-gutenberg-editor.php';
			require_once CARTFLOWS_DIR . 'modules/gutenberg/classes/class-cartflows-init-blocks.php';
			if ( wcf()->is_woo_active ) {
				require_once CARTFLOWS_DIR . 'modules/gutenberg/dist/blocks/order-detail-form/class-wcfb-order-detail-form.php';
				require_once CARTFLOWS_DIR . 'modules/gutenberg/dist/blocks/checkout-form/class-wcfb-checkout-form.php';
				require_once CARTFLOWS_DIR . 'modules/gutenberg/dist/blocks/optin-form/class-wcfb-optin-form.php';
			}
		}
	}
	Cartflows_Block_Loader::get_instance();
}

