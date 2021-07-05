<?php
/**
 * Stats
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Stats
 *
 * @since 1.0.0
 */
class Cartflows_Stats {

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
	 *  Constructor
	 */
	public function __construct() {

		add_action( 'wp_ajax_cartflows_fetch_stats', array( $this, 'fetch_stats' ) );
	}

	/**
	 * Get stats.
	 */
	public function fetch_stats() {

		check_ajax_referer( 'wcf-fetch-stats', 'security' );

		$filter = filter_input( INPUT_POST, 'filter', FILTER_SANITIZE_STRING );

		if ( ! $filter ) {
			$filter = 'week';
		}

		$from_date = gmdate( 'Y-m-d' );
		$to_date   = gmdate( 'Y-m-d' );
        $to_date   = date( 'Y-m-d H:i:s', strtotime( $to_date . '23:59:59' ) ); //phpcs:ignore

		switch ( $filter ) {

			case 'today':
                $from_date = date( 'Y-m-d H:i:s', strtotime( $from_date . '00:00:00' ) ); //phpcs:ignore
				break;
			case 'yesterday':
				$yesterday = gmdate( 'Y-m-d', strtotime( '-1 days' ) );
                $from_date = date( 'Y-m-d H:i:s', strtotime( $yesterday . '00:00:00' ) ); //phpcs:ignore
                $to_date   = date( 'Y-m-d H:i:s', strtotime( $yesterday . '23:59:59' ) ); //phpcs:ignore
				break;
			case 'week':
				$from_date = gmdate( 'Y-m-d', strtotime( '-7 days' ) );
                $from_date = date( 'Y-m-d H:i:s', strtotime( $from_date . '00:00:00' ) ); //phpcs:ignore
				break;
			case 'month':
				$from_date = gmdate( 'Y-m-d', strtotime( '-1 months' ) );
                $from_date = date( 'Y-m-d H:i:s', strtotime( $from_date . '00:00:00' ) ); //phpcs:ignore
				break;
			case 'custom':
				$to_date   = $to_date ? $to_date : gmdate( 'Y-m-d' );
				$from_date = $from_date ? $from_date : $to_date;
				break;
			default:
		}
	}
}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Cartflows_Stats::get_instance();
