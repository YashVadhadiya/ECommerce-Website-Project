<?php
/**
 * Cartflows_Tracking
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Flow Markup
 *
 * @since 1.0.0
 */
class Cartflows_Tracking {


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
		add_action( 'wp_head', array( $this, 'add_tracking_code' ) );
	}

	/**
	 * Add the facebook pixel and google analytics code.
	 */
	public function add_tracking_code() {

		$this->add_facebook_pixel_tracking_code();
		$this->add_google_analytics_tracking_code();
	}



	/**
	 * Function for facebook pixel.
	 */
	public function add_facebook_pixel_tracking_code() {

		$facebook_settings = Cartflows_Helper::get_facebook_settings();

		if ( 'enable' === $facebook_settings['facebook_pixel_tracking'] ) {

			$facebook_id = esc_attr( $facebook_settings['facebook_pixel_id'] );
			echo '<!-- Facebook Pixel Script By CartFlows -->';
			$fb_script = "<script type='text/javascript'>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window, document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');	
			</script>
			<noscript><img height='1' width='1' style='display:none' src='https://www.facebook.com/tr?id=" . $facebook_id . "&ev=PageView&noscript=1'/></noscript>";

			$fb_page_view = "<script type='text/javascript'>
			fbq('init', $facebook_id);
			fbq('track', 'PageView', {'plugin': 'CartFlows'});
			</script>";

			if ( 'enable' === $facebook_settings['facebook_pixel_tracking_for_site'] && ! wcf()->utils->is_step_post_type() ) {
				echo $fb_script;
				echo $fb_page_view;
			} else {
				echo $fb_script;
			}
			echo '<!-- End Facebook Pixel Script By CartFlows -->';
		}
	}

	/**
	 * Prepare response data for facebook.
	 *
	 * @param int   $order_id order_id.
	 * @param array $offer_data offer data.
	 */
	public static function send_fb_response_if_enabled( $order_id, $offer_data = array() ) {

		// Stop Execution if WooCommerce is not installed & don't set the cookie.
		if ( ! wcf()->is_woo_active ) {
			return;
		}

		$fb_settings = Cartflows_Helper::get_facebook_settings();
		if ( 'enable' === $fb_settings['facebook_pixel_tracking'] ) {
			setcookie( 'wcf_order_details', wp_json_encode( self::prepare_purchase_data_fb_response( $order_id, $offer_data ) ), strtotime( '+1 year' ), '/' );
		}

	}

	/**
	 * Prepare purchase response for facebook purcase event.
	 *
	 * @param integer $order_id order id.
	 * @param array   $offer_data offer data.
	 * @return mixed
	 */
	public static function prepare_purchase_data_fb_response( $order_id, $offer_data = array() ) {

		$thankyou = array();

		$thankyou['order_id']     = $order_id;
		$thankyou['content_type'] = 'product';
		$thankyou['currency']     = wcf()->options->get_checkout_meta_value( $order_id, '_order_currency' );
		$thankyou['userAgent']    = wcf()->options->get_checkout_meta_value( $order_id, '_customer_user_agent' );
		$thankyou['plugin']       = 'CartFlows';
		$order                    = wc_get_order( $order_id );

		if ( ! $order ) {
			return $thankyou;
		}

		if ( empty( $offer_data ) ) {
			// Iterating through each WC_Order_Item_Product objects.
			foreach ( $order->get_items() as $item_key => $item ) {
				$product                   = $item->get_product(); // Get the WC_Product object.
				$thankyou['content_ids'][] = (string) $product->get_id();
			}
			$thankyou['value'] = wcf()->options->get_checkout_meta_value( $order_id, '_order_total' );
		} else {
			$thankyou['content_ids'][] = (string) $offer_data['id'];
			$thankyou['value']         = $offer_data['total'];
		}

		return $thankyou;
	}

	/**
	 * Prepare cart data for fb response.
	 *
	 * @return array
	 */
	public static function prepare_cart_data_fb_response() {

		$params = array();

		if ( ! wcf()->is_woo_active ) {
			return $params;
		}

		$cart_total       = WC()->cart->get_cart_contents_total();
		$cart_items_count = WC()->cart->get_cart_contents_count();
		$items            = WC()->cart->get_cart();
		$product_names    = '';
		$category_names   = '';
		$cart_contents    = array();
		foreach ( $items as $item => $value ) {

			$_product = wc_get_product( $value['product_id'] );
			if ( $_product ) {
				$params['content_ids'][] = (string) $_product->get_id();
				$product_names           = $product_names . ', ' . $_product->get_title();
				$category_names          = $category_names . ', ' . wp_strip_all_tags( wc_get_product_category_list( $_product->get_id() ) );
				array_push(
					$cart_contents,
					array(
						'id'         => $_product->get_id(),
						'name'       => $_product->get_title(),
						'quantity'   => $value['quantity'],
						'item_price' => $_product->get_price(),
					)
				);
			}
		}

		$user                         = wp_get_current_user();
		$roles                        = implode( ', ', $user->roles );
		$params['content_name']       = substr( $product_names, 2 );
		$params['category_name']      = substr( $category_names, 2 );
		$params['user_roles']         = $roles;
		$params['plugin']             = 'CartFlows';
		$params['contents']           = wp_json_encode( $cart_contents );
		$params['content_type']       = 'product';
		$params['value']              = $cart_total;
		$params['num_items']          = $cart_items_count;
		$params['currency']           = get_woocommerce_currency();
		$params['language']           = get_bloginfo( 'language' );
		$params['userAgent']          = wp_unslash( $_SERVER['HTTP_USER_AGENT'] ); //phpcs:ignore
		$params['product_catalog_id'] = '';
		$params['domain']             = get_site_url();

		return $params;
	}

	/**
	 * Render google tag framework.
	 */
	public function add_google_analytics_tracking_code() {

		$google_analytics_settings = Cartflows_Helper::get_google_analytics_settings();

		$ga_tracking_code = esc_attr( $google_analytics_settings['google_analytics_id'] );

		if ( 'enable' === $google_analytics_settings['enable_google_analytics'] ) {
			?>
			<!-- Google Analytics Script By CartFlows -->
			<script type="text/javascript">
				var tracking_id = '<?php echo $ga_tracking_code; ?>';
			</script>
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<?php // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript ?>
			<script async src=https://www.googletagmanager.com/gtag/js?id=<?php echo $ga_tracking_code; ?>></script>
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
			</script>

			<!-- Google Analytics Script By CartFlows -->
			<?php
			if ( 'enable' === $google_analytics_settings['enable_google_analytics_for_site'] ) {
				?>
				<script>
					gtag('config', tracking_id);
				</script>
				<?php
			}
		}
	}

	/**
	 * Set cookies to send ga data.
	 *
	 * @param int   $order_id order id.
	 * @param array $offer_data offer product data.
	 */
	public static function send_ga_data_if_enabled( $order_id, $offer_data = array() ) {

		// Stop Execution if WooCommerce is not installed & don't set the cookie.
		if ( ! wcf()->is_woo_active ) {
			return;
		}

		$google_analytics_settings = Cartflows_Helper::get_google_analytics_settings();

		if ( 'enable' === $google_analytics_settings['enable_google_analytics'] && 'enable' === $google_analytics_settings['enable_purchase_event'] ) {

			setcookie( 'wcf_ga_trans_data', wp_json_encode( self::get_ga_purchase_transactions_data( $order_id, $offer_data ) ), strtotime( '+1 year' ), '/' );
		}
	}


	/**
	 * Prepare cart data for GA response.
	 *
	 * @param int   $order_id order id.
	 * @param array $offer_data offer product data.
	 * @return array
	 */
	public static function get_ga_purchase_transactions_data( $order_id, $offer_data ) {

		$response = array();

		$order             = wc_get_order( $order_id );
		$response['items'] = array();
		$cart_contents     = array();
		$items             = array();

		if ( $order ) {
			$items    = $order->get_items();
			$response = array(
				'transaction_id' => $order_id,
				'affiliation'    => get_bloginfo( 'name' ),
				'value'          => $order->get_total(),
				'currency'       => $order->get_currency(),
				'tax'            => $order->get_cart_tax(),
				'shipping'       => $order->get_shipping_total(),
				'coupon'         => '',
			);
		}
		if ( empty( $offer_data ) ) {
			// Iterating through each WC_Order_Item_Product objects.
			foreach ( $items as $item => $value ) {

				$_product = wc_get_product( $value['product_id'] );

				if ( $_product ) {

					if ( ! $_product->is_type( 'variable' ) ) {
						$product_data = self::get_required_product_data_for_ga( $_product );
					} else {
						$variable_product = wc_get_product( $value['variation_id'] );
						$product_data     = self::get_required_product_data_for_ga( $variable_product );
					}
					array_push(
						$cart_contents,
						array(
							'id'       => $product_data['id'],
							'name'     => $product_data['name'],
							'category' => wp_strip_all_tags( wc_get_product_category_list( $_product->get_id() ) ),
							'price'    => $product_data['price'],
							'quantity' => $value['quantity'],
						)
					);
				}
			}
		} else {
			array_push(
				$cart_contents,
				array(
					'id'       => $offer_data['id'],
					'name'     => $offer_data['name'],
					'quantity' => $offer_data['qty'],
					'price'    => $offer_data['price'],
				)
			);
		}

		$response['items'] = $cart_contents;

		// Prepare the json data to send it to google.
		return $response;
	}

	/**
	 * Prepare Ecommerce data for GA response.
	 *
	 * @return array
	 */
	public static function prepare_cart_data_ga_response() {

		$items_data = array();

		// Stop Execution if WooCommerce is not installed & don't set the cookie.
		if ( ! wcf()->is_woo_active ) {
			return $items_data;
		}

		$items = WC()->cart->get_cart();

		foreach ( $items as $item => $value ) {

			$_product = wc_get_product( $value['product_id'] );

			if ( $_product ) {
				if ( ! $_product->is_type( 'variable' ) ) {
					$product_data = self::get_required_product_data_for_ga( $_product );
				} else {
					$variable_product = wc_get_product( $value['variation_id'] );
					$product_data     = self::get_required_product_data_for_ga( $variable_product );
				}

				array_push(
					$items_data,
					array(
						'id'       => $product_data['id'],
						'name'     => $product_data['name'],
						'category' => wp_strip_all_tags( wc_get_product_category_list( $_product->get_id() ) ),
						'price'    => $product_data['price'],
						'quantity' => $value['quantity'],
					)
				);
			}
		}

		return $items_data;
	}

	/**
	 * Get product data.
	 *
	 * @param object $_product product data.
	 */
	public static function get_required_product_data_for_ga( $_product ) {

		$data = array(
			'id'    => $_product->get_id(),
			'name'  => $_product->get_name(),
			'price' => $_product->get_price(),
		);
		return $data;
	}
}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Cartflows_Tracking::get_instance();
