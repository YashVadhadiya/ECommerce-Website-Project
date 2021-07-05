<?php
/**
 * CartFlows Flows Stats ajax actions.
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
class FlowsStats extends AjaxBase {

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
			'get_all_flows_stats',
		);

		$this->init_ajax_events( $ajax_events );
	}


	/**
	 * Get all Flows Stats.
	 */
	public function get_all_flows_stats() {

		$total_flow_revenue = $this->get_earnings();

		$response = array(
			'flow_stats' => $total_flow_revenue,
		);

		wp_send_json_success( $response );

	}

	/**
	 * Calculate earning.
	 *
	 * @return array
	 */
	public function get_earnings() {

		$orders           = $this->get_orders_by_flow();
		$gross_sale       = 0;
		$order_count      = 0;
		$total_bump_offer = 0;
		$cartflows_offer  = 0;
		$visits           = 0;
		$currency_symbol  = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '';
		$cf_pro_status    = _is_cartflows_pro();

		if ( ! empty( $orders ) ) {

			foreach ( $orders as $order ) {

				$order_id    = $order->ID;
				$order       = wc_get_order( $order_id );
				$order_total = $order->get_total();
				$order_count++;

				if ( ! $order->has_status( 'cancelled' ) ) {
					$gross_sale += (float) $order_total;
				}

				if ( ! $cf_pro_status ) {
					continue;
				}

				$bump_product_id = $order->get_meta( '_wcf_bump_product' );
				$bump_offer      = 0;

				$separate_offer_order = $order->get_meta( '_cartflows_parent_flow_id' );

				if ( empty( $separate_offer_order ) ) {

					foreach ( $order->get_items() as $item_id => $item_data ) {

						$item_product_id = $item_data->get_product_id();
						$item_total      = $item_data->get_total();

						$is_upsell   = wc_get_order_item_meta( $item_id, '_cartflows_upsell', true );
						$is_downsell = wc_get_order_item_meta( $item_id, '_cartflows_downsell', true );

						if ( $item_product_id == $bump_product_id ) {
							$bump_offer += $item_total;
						}

						// Upsell.
						if ( 'yes' === $is_upsell ) {

							if ( ! isset( $cartflows_offer ) ) {
								$cartflows_offer = 0;
							}

							$cartflows_offer += number_format( (float) $item_total, 2, '.', '' );
						}

						// Downsell.
						if ( 'yes' === $is_downsell ) {

							if ( ! isset( $cartflows_offer ) ) {
								$cartflows_offer = 0;
							}

							$cartflows_offer += number_format( (float) $item_total, 2, '.', '' );
						}
					}
				} else {
					$is_offer = $order->get_meta( '_cartflows_offer' );

					if ( 'yes' === $is_offer ) {

						if ( ! isset( $cartflows_offer ) ) {
							$cartflows_offer = 0;
						}

						$cartflows_offer += number_format( (float) $order_total, 2, '.', '' );
					}
				}

				$total_bump_offer += $bump_offer;

			}

			if ( $cf_pro_status ) {

				/* Get the Flow IDs. */
				$flow_ids = array_column( $orders, 'meta_value' );

				/* Calculate the Visits of those flows. */
				$visits = $this->fetch_visits( $flow_ids );
			}
		}

		// Return All Stats.
		return array(
			'order_currency'       => $currency_symbol,
			'total_orders'         => $order_count,
			'total_revenue'        => number_format( (float) $gross_sale, 2, '.', '' ),
			'total_bump_revenue'   => number_format( (float) $total_bump_offer, 2, '.', '' ),
			'total_offers_revenue' => number_format( (float) $cartflows_offer, 2, '.', '' ),
			'total_visits'         => $visits,
		);
	}

	/**
	 * Fetch total visits.
	 *
	 * @param integer $flow_ids flows id.
	 * @return array|object|null
	 */
	public function fetch_visits( $flow_ids ) {

		global $wpdb;

		$query_dates = array();

		$visit_db      = $wpdb->prefix . CARTFLOWS_PRO_VISITS_TABLE;
		$visit_meta_db = $wpdb->prefix . CARTFLOWS_PRO_VISITS_META_TABLE;

		$query_dates = $this->get_query_dates();

		/*
		Need to look into date format later.
		// $analytics_reset_date = wcf()->options->get_flow_meta_value( $flow_id, 'wcf-analytics-reset-date' );

		// if ( $analytics_reset_date > $query_dates["start_date"] ) {
		// $query_dates["start_date"] = $analytics_reset_date;
		// }
		*/

		$all_steps = array();
		$steps     = array();

		foreach ( $flow_ids as $key => $flow_id ) {

			if ( ! empty( $steps ) ) {
				$steps = array_merge( $steps, wcf()->flow->get_steps( $flow_id ) );
			} else {
				$steps = wcf()->flow->get_steps( $flow_id );
			}
		}

		foreach ( $steps as $s_key => $s_data ) {

			if ( isset( $s_data['ab-test'] ) ) {

				if ( isset( $s_data['ab-test-variations'] ) && ! empty( $s_data['ab-test-variations'] ) ) {

					foreach ( $s_data['ab-test-variations'] as $v_key => $v_data ) {

						$all_steps[] = $v_data['id'];
					}
				} else {
					$all_steps[] = $s_data['id'];
				}

				if ( isset( $s_data['ab-test-archived-variations'] ) && ! empty( $s_data['ab-test-archived-variations'] ) ) {

					foreach ( $s_data['ab-test-archived-variations'] as $av_key => $av_data ) {

						$all_steps[] = $av_data['id'];
					}
				}
			} else {
				$all_steps[] = $s_data['id'];
			}
		}

		$step_ids = implode( ', ', $all_steps );

		// phpcs:disable
		$query = $wpdb->prepare(
			"SELECT 
			 COUNT( DISTINCT( $visit_db.id ) ) AS total_visits
			 FROM $visit_db INNER JOIN $visit_meta_db ON $visit_db.id = $visit_meta_db.visit_id
			 WHERE step_id IN ( $step_ids ) 
			 AND ( date_visited BETWEEN %s AND %s ) 
			 GROUP BY step_id
			 ORDER BY NULL", //phpcs:ignore
			$query_dates["start_date"],
			$query_dates["end_date"]
		);
		// phpcs:enable
		$visits = $wpdb->get_results( $query ); //phpcs:ignore

		$total_visits = 0;

		foreach ( $visits as $visit ) {
			$total_visits += $visit->total_visits;
		}

		// phpcs:enable
		return $total_visits;
	}

	/**
	 * Get orders data for flow.
	 *
	 * @since x.x.x
	 *
	 * @return int
	 */
	public function get_orders_by_flow() {

		global $wpdb;

		$query_dates = array();

		$query_dates = $this->get_query_dates();

		$conditions = array(
			'tb1.post_type' => 'shop_order',
		);

		$where = $this->get_items_query_where( $conditions );

		$where .= " AND ( tb1.post_date BETWEEN IF (tb2.meta_key='wcf-analytics-reset-date'>'" . $query_dates['start_date'] . "', tb2.meta_key, '" . $query_dates['start_date'] . "')  AND '" . $query_dates['end_date'] . "' )";
		$where .= " AND ( ( tb2.meta_key = '_wcf_flow_id' ) OR ( tb2.meta_key = '_cartflows_parent_flow_id' ) )";
		$where .= " AND tb1.post_status IN ( 'wc-completed', 'wc-processing', 'wc-cancelled' )";

		$query = 'SELECT tb1.ID, DATE( tb1.post_date ) date, tb2.meta_value FROM ' . $wpdb->prefix . 'posts tb1 
		INNER JOIN ' . $wpdb->prefix . 'postmeta tb2
		ON tb1.ID = tb2.post_id 
		' . $where;

		// @codingStandardsIgnoreStart.
		return $wpdb->get_results( $query );
		// @codingStandardsIgnoreEnd.

	}

	/**
	 * Get Query Dates
	 *
	 * @since x.x.x
	 */
	public function get_query_dates() {

		$start_date = filter_input( INPUT_POST, 'date_from', FILTER_SANITIZE_STRING );
		$end_date   = filter_input( INPUT_POST, 'date_to', FILTER_SANITIZE_STRING );

		$start_date = $start_date ? $start_date : date( 'Y-m-d' ); //phpcs:ignore
		$end_date   = $end_date ? $end_date : date( 'Y-m-d' ); //phpcs:ignore

		$start_date = date( 'Y-m-d H:i:s', strtotime( $start_date . '00:00:00' ) ); //phpcs:ignore
		$end_date   = date( 'Y-m-d H:i:s', strtotime( $end_date . '23:59:59' ) ); //phpcs:ignore

		return array(
			'start_date' => $start_date,
			'end_date'   => $end_date,
		);
	}
	/**
	 * Prepare where items for query.
	 *
	 * @param array $conditions conditions to prepare WHERE query.
	 * @return string
	 */
	protected function get_items_query_where( $conditions ) {

		global $wpdb;

		$where_conditions = array();
		$where_values     = array();

		foreach ( $conditions as $key => $condition ) {

			if ( false !== stripos( $key, 'IN' ) ) {
				$where_conditions[] = $key . '( %s )';
			} else {
				$where_conditions[] = $key . '= %s';
			}

			$where_values[] = $condition;
		}

		if ( ! empty( $where_conditions ) ) {
			// @codingStandardsIgnoreStart
			return $wpdb->prepare( 'WHERE 1 = 1 AND ' . implode( ' AND ', $where_conditions ), $where_values );
			// @codingStandardsIgnoreEnd
		} else {
			return '';
		}
	}
}
