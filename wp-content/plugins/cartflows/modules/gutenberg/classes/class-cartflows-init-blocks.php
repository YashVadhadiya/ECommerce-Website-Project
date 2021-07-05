<?php
/**
 * Cartflows Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   x.x.x
 * @package Cartflows
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Cartflows_Init_Blocks.
 *
 * @package Cartflows
 */
class Cartflows_Init_Blocks {

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

		// Hook: Frontend assets.
		add_action( 'enqueue_block_assets', array( $this, 'block_assets' ) );

		// Hook: Editor assets.
		add_action( 'enqueue_block_editor_assets', array( $this, 'editor_assets' ) );

		add_filter( 'block_categories', array( $this, 'register_block_category' ), 10, 2 );

		add_action( 'wp_ajax_wpcf_order_detail_form_shortcode', array( $this, 'order_detail_form_shortcode' ) );
		add_action( 'wp_ajax_wpcf_order_checkout_form_shortcode', array( $this, 'order_checkout_form_shortcode' ) );
		add_action( 'wp_ajax_wpcf_optin_form_shortcode', array( $this, 'optin_form_shortcode' ) );
	}

	/**
	 * Renders the Order Detail Form shortcode.
	 *
	 * @since x.x.x
	 */
	public function order_detail_form_shortcode() {

		check_ajax_referer( 'wpcf_ajax_nonce', 'nonce' );

		add_filter(
			'cartflows_show_demo_order_details',
			function() {
				return true;
			}
		);

		if ( ! empty( $_POST['thanyouText'] ) ) {

			add_filter(
				'cartflows_thankyou_meta_wcf-tq-text',
				function( $text ) {
					check_ajax_referer( 'wpcf_ajax_nonce', 'nonce' );

					$text = isset( $_POST['thanyouText'] ) ? sanitize_text_field( wp_unslash( $_POST['thanyouText'] ) ) : '';

					return $text;
				},
				10,
				1
			);
		}

		$data['html'] = do_shortcode( '[cartflows_order_details]' );

		wp_send_json_success( $data );
	}

	/**
	 * Renders the Order Checkout Form shortcode.
	 *
	 * @since x.x.x
	 */
	public function order_checkout_form_shortcode() {
		check_ajax_referer( 'wpcf_ajax_nonce', 'nonce' );

		add_filter(
			'cartflows_show_demo_checkout',
			function() {
				return true;
			}
		);

		if( isset( $_POST['id'] ) ){ //phpcs:ignore
			$checkout_id = intval( $_POST['id'] ); //phpcs:ignore
		}

		$global_checkout = intval( Cartflows_Helper::get_common_setting( 'global_checkout' ) );

		$flow_id = wcf()->utils->get_flow_id_from_step_id( $checkout_id );

		if ( ! wcf()->flow->is_flow_testmode( $flow_id ) && ( $global_checkout !== $checkout_id ) ) {

			$products = wcf()->utils->get_selected_checkout_products( $checkout_id );

			if ( ! is_array( $products ) || empty( $products[0]['product'] ) ) {
				wc_clear_notices();
				wc_add_notice( __( 'No product is selected. Please select products from the checkout meta settings to continue.', 'cartflows' ), 'error' );
			}
		}
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form' );

		add_action( 'woocommerce_checkout_order_review', array( Cartflows_Checkout_Markup::get_instance(), 'display_custom_coupon_field' ) );

		$attributes['layout'] = isset( $_POST['layout'] ) ? sanitize_title( wp_unslash( $_POST['layout'] ) ) : '';
		//phpcs:ignore $attributes['obposition']                          = isset( $_POST['obposition'] ) ? sanitize_title( wp_unslash( $_POST['obposition'] ) ) : ''; //phpcs:ignore
		$attributes['orderBumpSkin']                   = isset( $_POST['orderBumpSkin'] ) ? sanitize_title( wp_unslash( $_POST['orderBumpSkin'] ) ) : '';
		$attributes['orderBumpCheckboxArrow']          = isset( $_POST['orderBumpCheckboxArrow'] ) ? sanitize_title( wp_unslash( $_POST['orderBumpCheckboxArrow'] ) ) : '';
		$attributes['orderBumpCheckboxArrowAnimation'] = isset( $_POST['orderBumpCheckboxArrowAnimation'] ) ? sanitize_title( wp_unslash( $_POST['orderBumpCheckboxArrowAnimation'] ) ) : '';
		$attributes['sectionposition']                 = isset( $_POST['sectionposition'] ) ? sanitize_title( wp_unslash( $_POST['sectionposition'] ) ) : '';
		$attributes['productOptionsSkin']              = isset( $_POST['productOptionsSkin'] ) ? sanitize_title( wp_unslash( $_POST['productOptionsSkin'] ) ) : '';
		$attributes['productOptionsImages']            = isset( $_POST['productOptionsImages'] ) ? sanitize_title( wp_unslash( $_POST['productOptionsImages'] ) ) : '';
		$attributes['productOptionsSectionTitleText']  = isset( $_POST['productOptionsSectionTitleText'] ) ? sanitize_text_field( wp_unslash( $_POST['productOptionsSectionTitleText'] ) ) : '';
		$attributes['PreSkipText']                     = isset( $_POST['PreSkipText'] ) ? sanitize_title( wp_unslash( $_POST['PreSkipText'] ) ) : '';
		$attributes['PreOrderText']                    = isset( $_POST['PreOrderText'] ) ? sanitize_title( wp_unslash( $_POST['PreOrderText'] ) ) : '';
		$attributes['PreProductTitleText']             = isset( $_POST['PreProductTitleText'] ) ? sanitize_title( wp_unslash( $_POST['PreProductTitleText'] ) ) : '';
		$attributes['preSubTitleText']                 = isset( $_POST['preSubTitleText'] ) ? sanitize_title( wp_unslash( $_POST['preSubTitleText'] ) ) : '';
		$attributes['preTitleText']                    = isset( $_POST['preTitleText'] ) ? sanitize_title( wp_unslash( $_POST['preTitleText'] ) ) : '';
		$attributes['PreProductDescText']              = isset( $_POST['PreProductDescText'] ) ? sanitize_title( wp_unslash( $_POST['PreProductDescText'] ) ) : '';
		//phpcs:ignore $attributes['orderBumpCheckboxLabel']              = isset( $_POST['orderBumpCheckboxLabel'] ) ? sanitize_text_field( wp_unslash( $_POST['orderBumpCheckboxLabel'] ) ) : ''; //phpcs:ignore
		//phpcs:ignore $attributes['orderBumpHighlightText']              = isset( $_POST['orderBumpHighlightText'] ) ? sanitize_text_field( wp_unslash( $_POST['orderBumpHighlightText'] ) ) : ''; //phpcs:ignore
		//phpcs:ignore $attributes['orderBumpCheckboxProductDescription'] = isset( $_POST['orderBumpCheckboxProductDescription'] ) ? sanitize_text_field( wp_unslash( $_POST['orderBumpCheckboxProductDescription'] ) ) : ''; //phpcs:ignore
		$attributes['inputSkins']              = isset( $_POST['inputSkins'] ) ? sanitize_title( wp_unslash( $_POST['inputSkins'] ) ) : '';
		$attributes['enableNote']              = isset( $_POST['enableNote'] ) ? sanitize_title( wp_unslash( $_POST['enableNote'] ) ) : '';
		$attributes['noteText']                = isset( $_POST['noteText'] ) ? sanitize_text_field( wp_unslash( $_POST['noteText'] ) ) : '';
		$attributes['stepOneTitleText']        = isset( $_POST['stepOneTitleText'] ) ? sanitize_text_field( wp_unslash( $_POST['stepOneTitleText'] ) ) : '';
		$attributes['stepOneSubTitleText']     = isset( $_POST['stepOneSubTitleText'] ) ? sanitize_text_field( wp_unslash( $_POST['stepOneSubTitleText'] ) ) : '';
		$attributes['stepTwoTitleText']        = isset( $_POST['stepTwoTitleText'] ) ? sanitize_text_field( wp_unslash( $_POST['stepTwoTitleText'] ) ) : '';
		$attributes['stepTwoSubTitleText']     = isset( $_POST['stepTwoSubTitleText'] ) ? sanitize_text_field( wp_unslash( $_POST['stepTwoSubTitleText'] ) ) : '';
		$attributes['offerButtonTitleText']    = isset( $_POST['offerButtonTitleText'] ) ? sanitize_text_field( wp_unslash( $_POST['offerButtonTitleText'] ) ) : '';
		$attributes['offerButtonSubTitleText'] = isset( $_POST['offerButtonSubTitleText'] ) ? sanitize_text_field( wp_unslash( $_POST['offerButtonSubTitleText'] ) ) : '';

		do_action( 'cartflows_gutenberg_checkout_options_filters', $attributes );

		$data['html'] = do_shortcode( '[cartflows_checkout]' );

		wp_send_json_success( $data );
	}

	/**
	 * Renders the Optin Form shortcode.
	 *
	 * @since x.x.x
	 */
	public function optin_form_shortcode() {

		check_ajax_referer( 'wpcf_ajax_nonce', 'nonce' );

		add_filter(
			'cartflows_show_demo_optin_form',
			function() {
				return true;
			}
		);

		if( isset( $_POST['id'] ) ){ //phpcs:ignore
			$optin_id = intval( $_POST['id'] ); //phpcs:ignore
		}

		$products = wcf()->options->get_optin_meta_value( $optin_id, 'wcf-optin-product' );
		if ( is_array( $products ) && count( $products ) < 1 ) {
			wc_clear_notices();
			wc_add_notice( __( 'No product is selected. Please select a Simple, Virtual and Free product from the meta settings.', 'cartflows' ), 'error' );
		}

		add_filter( 'woocommerce_cart_needs_payment', '__return_false' );
		add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
		add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false' );

		$data['html']       = do_shortcode( '[cartflows_optin]' );
		$data['buttonText'] = wcf()->options->get_optin_meta_value( $optin_id, 'wcf-submit-button-text' );
		wp_send_json_success( $data );
	}

	/**
	 * Enqueue Gutenberg block assets for both frontend + backend.
	 *
	 * @since x.x.x
	 */
	public function block_assets() {

		global $post;

		if ( $post && CARTFLOWS_STEP_POST_TYPE === $post->post_type ) {

			// Register block styles for both frontend + backend.
			wp_enqueue_style(
				'CF_block-cartflows-style-css', // Handle.
				CARTFLOWS_URL . 'modules/gutenberg/dist/blocks.style.build.css',
				is_admin() ? array( 'wp-editor' ) : null, // Dependency to include the CSS after it.
				CARTFLOWS_VER // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
			);
		}

	}

	/**
	 * Enqueue assets for both backend.
	 *
	 * @since x.x.x
	 */
	public function editor_assets() {

		$post_id   = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0; //phpcs:ignore
		$post_type = get_post_type( $post_id );

		if ( CARTFLOWS_STEP_POST_TYPE === $post_type ) {

			$wpcf_ajax_nonce       = wp_create_nonce( 'wpcf_ajax_nonce' );
			$step_type             = wcf()->utils->get_step_type( $post_id );
			$show_checkout_pro_opt = apply_filters( 'cartflows_show_checkout_pro_opt', false );

			if ( 'optin' === $step_type ) {
				wp_enqueue_style( 'wcf-optin-template', wcf()->utils->get_css_url( 'optin-template' ), '', CARTFLOWS_VER );
			}
			if ( 'checkout' === $step_type ) {
				wp_enqueue_style( 'wcf-checkout-template', wcf()->utils->get_css_url( 'checkout-template' ), '', CARTFLOWS_VER );
			}

			// Register block editor script for backend.
			wp_register_script(
				'CF_block-cartflows-block-js', // Handle.
				CARTFLOWS_URL . 'modules/gutenberg/dist/blocks.build.js',
				array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
				CARTFLOWS_VER, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
				true // Enqueue the script in the footer.
			);

			wp_set_script_translations( 'CF_block-cartflows-block-js', 'cartflows' );

			// Register block editor styles for backend.
			wp_register_style(
				'CF_block-cartflows-block-editor-css', // Handle.
				CARTFLOWS_URL . 'modules/gutenberg/dist/blocks.editor.build.css',
				array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
				CARTFLOWS_VER // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
			);

			// Common Editor style.
			wp_enqueue_style(
				'CF_block-common-editor-css', // Handle.
				CARTFLOWS_URL . 'modules/gutenberg/dist/blocks.commoneditorstyle.build.css',
				array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
				CARTFLOWS_VER // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
			);

			// Enqueue frontend CSS in editor.
			wp_enqueue_style( 'CF_block-cartflows-frotend-style', CARTFLOWS_URL . 'assets/css/frontend.css', array(), CARTFLOWS_VER );

			// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cartflowsGlobal` object.
			wp_localize_script(
				'CF_block-cartflows-block-js',
				'cf_blocks_info', // Array containing dynamic data for a JS Global.
				array(
					'pluginDirPath'            => plugin_dir_path( __DIR__ ),
					'pluginDirUrl'             => plugin_dir_url( __DIR__ ),
					'category'                 => 'cartflows',
					'ajax_url'                 => admin_url( 'admin-ajax.php' ),
					'wpcf_ajax_nonce'          => $wpcf_ajax_nonce,
					'blocks'                   => Cartflows_Block_Config::get_block_attributes(),
					'tablet_breakpoint'        => CF_TABLET_BREAKPOINT,
					'mobile_breakpoint'        => CF_MOBILE_BREAKPOINT,
					'show_checkout_pro_opt'    => $show_checkout_pro_opt,
					'ID'                       => $post_id,
					'step_type'                => $step_type,
					'is_cartflows_pro_install' => _is_cartflows_pro(),
					'is_woo_active'            => wcf()->is_woo_active,
				// Add more data here that you want to access from `cartflowsGlobal` object.
				)
			);

			/**
			 * Register Gutenberg block on server-side.
			 *
			 * Register the block on server-side to ensure that the block
			 * scripts and styles for both frontend and backend are
			 * enqueued when the editor loads.
			 *
			 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
			 * @since x.x.x
			 */
			register_block_type(
				'wcfb/next-step-button',
				array(
					// Enqueue blocks.build.js in the editor only.
					'editor_script' => 'CF_block-cartflows-block-js',
					// Enqueue blocks.editor.build.css in the editor only.
					'style'         => 'CF_block-cartflows-block-editor-css',
					// Enqueue blocks.commoneditorstyle.build.css in the editor only.
					'editor_style'  => 'CF_block-common-editor-css',
				)
			);

		}
	}

	/**
	 * Gutenberg block category for WCFB.
	 *
	 * @param array  $categories Block categories.
	 * @param object $post Post object.
	 * @since x.x.x
	 */
	public function register_block_category( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'cartflows',
					'title' => __( 'Cartflows', 'cartflows' ),
				),
			)
		);
	}

}

/**
 *  Prepare if class 'Cartflows_Init_Blocks' exist.
 *  Kicking this off by calling 'get_instance()' method
 */
Cartflows_Init_Blocks::get_instance();
