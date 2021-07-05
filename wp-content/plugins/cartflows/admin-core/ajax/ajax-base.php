<?php
/**
 * CartFlows Ajax Base.
 *
 * @package CartFlows
 */

namespace CartflowsAdmin\AdminCore\Ajax;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CartflowsAdmin\AdminCore\Ajax\AjaxErrors;

/**
 * Class Admin_Menu.
 */
abstract class AjaxBase {

	/**
	 * Ajax action prefix.
	 *
	 * @var string
	 */
	private $prefix = 'cartflows';

	/**
	 * Erros class instance.
	 *
	 * @var object
	 */
	public $errors = null;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->errors = AjaxErrors::get_instance();
	}

	/**
	 * Register ajax events.
	 *
	 * @param array $ajax_events Ajax events.
	 */
	public function init_ajax_events( $ajax_events ) {

		if ( ! empty( $ajax_events ) ) {

			foreach ( $ajax_events as $ajax_event ) {
				add_action( 'wp_ajax_' . $this->prefix . '_' . $ajax_event, array( $this, $ajax_event ) );

				$this->localize_ajax_action_nonce( $ajax_event );
			}
		}
	}

	/**
	 * Localize nonce for ajax call.
	 *
	 * @param string $action Action name.
	 * @return void
	 */
	public function localize_ajax_action_nonce( $action ) {

		if ( current_user_can( 'manage_options' ) ) {

			add_filter(
				'cartflows_react_admin_localize',
				function( $localize ) use ( $action ) {

					$localize[ $action . '_nonce' ] = wp_create_nonce( $this->prefix . '_' . $action );
					return $localize;
				}
			);

		}
	}


	/**
	 * Get ajax error message.
	 *
	 * @param string $type Message type.
	 * @return string
	 */
	public function get_error_msg( $type ) {

		return $this->errors->get_error_msg( $type );
	}
}
