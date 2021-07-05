<?php
/**
 * CartFlows Admin.
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class Cartflows_Admin.
 */
class Cartflows_Admin {

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
	 */
	public function __construct() {

		$this->init_hooks();
	}

	/**
	 * Init Hooks.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function init_hooks() {

		if ( ! is_admin() ) {
			return;
		}

		/* Add lite version class to body */
		add_action( 'admin_body_class', array( $this, 'add_admin_body_class' ) );

		add_filter( 'plugin_action_links_' . CARTFLOWS_BASE, array( $this, 'add_action_links' ) );

		add_action( 'in_admin_header', array( $this, 'embed_page_header' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'load_ui_switch_notice_script' ) );

		add_action( 'admin_notices', array( $this, 'show_ui_switch_notice' ) );
		add_action( 'admin_notices', array( $this, 'show_remove_legacy_notice' ) );

		add_action( 'wp_ajax_wcf_switch_to_new_ui', array( $this, 'update_ui_switch_option' ) );

		add_action( 'admin_init', array( $this, 'flush_rules_after_save_permalinks' ) );
	}

	/**
	 *  After save of permalinks.
	 */
	public static function flush_rules_after_save_permalinks() {

		$has_saved_permalinks = get_option( 'cartflows_permalink_refresh' );
		if ( $has_saved_permalinks ) {
			flush_rewrite_rules();
			delete_option( 'cartflows_permalink_refresh' );
		}
	}

	/**
	 * Show action on plugin page.
	 *
	 * @param  array $links links.
	 * @return array
	 */
	public function add_action_links( $links ) {

		$default_url = admin_url( 'admin.php?page=' . CARTFLOWS_SETTINGS );

		if ( ! CARTFLOWS_LEGACY_ADMIN ) {

			$default_url = add_query_arg(
				array(
					'page' => CARTFLOWS_SLUG,
					'path' => 'settings',
				),
				admin_url()
			);
		}

		$mylinks = array(
			'<a href="' . $default_url . '">' . __( 'Settings', 'cartflows' ) . '</a>',
			'<a target="_blank" href="' . esc_url( 'https://cartflows.com/docs' ) . '">' . __( 'Docs', 'cartflows' ) . '</a>',
		);

		if ( ! _is_cartflows_pro() ) {
			array_push( $mylinks, '<a style="color: #39b54a; font-weight: bold;" target="_blank" href="' . esc_url( 'https://cartflows.com/pricing/' ) . '"> Go Pro </a>' );
		}

		return array_merge( $links, $mylinks );
	}

	/**
	 * Check is flow admin.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	public static function is_flow_edit_admin() {

		$current_screen = get_current_screen();

		if (
			is_object( $current_screen ) &&
			isset( $current_screen->post_type ) &&
			( CARTFLOWS_FLOW_POST_TYPE === $current_screen->post_type ) &&
			isset( $current_screen->base ) &&
			( 'post' === $current_screen->base )
		) {
			return true;
		}
		return false;
	}

	/**
	 * Admin body classes.
	 *
	 * Body classes to be added to <body> tag in admin page
	 *
	 * @param String $classes body classes returned from the filter.
	 * @return String body classes to be added to <body> tag in admin page
	 */
	public function add_admin_body_class( $classes ) {

		$classes .= ' cartflows-' . CARTFLOWS_VER;

		if ( isset( $_GET['action'] ) && in_array( sanitize_text_field( wp_unslash( $_GET['action'] ) ), array( 'wcf-log', 'wcf-license' ) ) ) { //phpcs:ignore
			$classes .= ' wcf-debug-page ';
		}

		return $classes;
	}

	/**
	 * Show embed header.
	 *
	 * @since 1.0.0
	 */
	public function show_embed_header() {

		$current_screen = get_current_screen();

		if (
			is_object( $current_screen ) &&
			isset( $current_screen->post_type ) &&
			( CARTFLOWS_FLOW_POST_TYPE === $current_screen->post_type ) &&
			isset( $current_screen->base ) &&
			( 'post' === $current_screen->base || 'edit' === $current_screen->base )
		) {
			return true;
		}

		return false;
	}
	/**
	 * Set up a div for the header embed to render into.
	 * The initial contents here are meant as a place loader for when the PHP page initialy loads.
	 */
	public function embed_page_header() {

		if ( ! $this->show_embed_header() ) {
			return;
		}

		wp_enqueue_style( 'cartflows-admin-embed-header', CARTFLOWS_URL . 'admin/assets/css/admin-embed-header.css', array(), CARTFLOWS_VER );

		include_once CARTFLOWS_DIR . 'includes/admin/cartflows-admin-header.php';
	}

	/**
	 * Check allowed screen for notices.
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function allowed_screen_for_notices() {

		$screen          = get_current_screen();
		$screen_id       = $screen ? $screen->id : '';
		$allowed_screens = array(
			'cartflows_page_cartflows_settings',
			'edit-cartflows_flow',
			'dashboard',
			'plugins',
		);

		if ( in_array( $screen_id, $allowed_screens, true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * New UI notice.
	 */
	public function load_ui_switch_notice_script() {

		if ( ! $this->allowed_screen_for_notices() ) {
			return;
		}

		// Loading Script file.
		wp_enqueue_script( 'cartflows-switch-ui-notice', CARTFLOWS_URL . 'admin/assets/js/ui-notice.js', array( 'jquery' ), CARTFLOWS_VER, false );
	}

	/**
	 * Show switch to new UI Notice.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function show_ui_switch_notice() {

		if ( ! CARTFLOWS_LEGACY_ADMIN ) {
			return;
		}

		if ( ! $this->allowed_screen_for_notices() ) {
			return;
		}

		// Load Script.

		/* Add backward compatibility */
		$show_notice = get_option( 'cartflows-switch-ui-notice', false );

		if ( false === $show_notice ) { ?>
			<div class="notice notice-info wcf-notice">
				<div class="wcf-notice-container" style="display: flex;padding: 18px 0;">
					<div class="wcf-notice-image" style="margin: 0 15px 0 0; flex: auto; max-width:70px">
						<img src="<?php echo CARTFLOWS_URL; ?>assets/images/cf-emblem.svg" alt="cartflows-logo" style="border-radius: 100%;"/>
					</div>
					<div class="wcf-notice-content">
						<h2 style="margin: 0;"><?php esc_html_e( 'We have introduced new slick and faster UI. ', 'cartflows' ); ?></h2>
						<p><?php esc_html_e( 'You are using a legacy admin UI. Switch to new faster UI now!', 'cartflows' ); ?></p>
						<div class="wcf-notice-actions" style="margin: 8px 0 0;">
							<a class="button button-primary switch-to-new-ui" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'wcf-switch-ui-action', 'update' ), 'wcf_switch_ui_nonce', 'wcf_switch_ui' ) ); ?>"><?php esc_html_e( 'Use New UI', 'cartflows' ); ?></a>
							<a class="button button-secondary skip-switch-new-ui" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'wcf-switch-ui-action', 'skip' ), 'wcf_switch_ui_nonce', 'wcf_switch_ui' ) ); ?>"><?php esc_html_e( 'Skip', 'cartflows' ); ?></a>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}

	/**
	 * Show remove legacy UI notice.
	 *
	 * @sience 1.6.12
	 * @return void
	 */
	public function show_remove_legacy_notice() {

		if ( ! CARTFLOWS_LEGACY_ADMIN ) {
			return;
		}

		if ( ! $this->allowed_screen_for_notices() ) {
			return;
		}

		?>
		<div class="notice notice-error wcf-notice">
			<p><b><?php esc_html_e( 'Attention!! We will be removing the CartFlows legacy UI.', 'cartflows' ); ?></b></p>
			<p><?php esc_html_e( 'CartFlows old admin UI will be removed in the next major update. If you are still using a legacy admin UI, switch to a new, faster UI now!', 'cartflows' ); ?></p>
			<p>
				<a class="button button-primary switch-to-new-ui" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'wcf-switch-ui-action', 'update' ), 'wcf_switch_ui_nonce', 'wcf_switch_ui' ) ); ?>"><?php esc_html_e( 'Switch to new UI', 'cartflows' ); ?></a>
			</p>			
		</div>
		<?php
	}

	/**
	 * Update new UI options.
	 * Delete legacy admin UI option.
	 */
	public function update_ui_switch_option() {

		if ( isset( $_POST['security'] ) && ! empty( $_POST['security'] ) && wp_verify_nonce( $_POST['security'], 'wcf_switch_ui_nonce' ) ) { //phpcs:ignore

			$action = isset( $_POST['button_action'] ) ? sanitize_text_field( wp_unslash( $_POST['button_action'] ) ) : '';

			if ( 'update' === $action ) {
				delete_option( 'cartflows-legacy-admin' );
			}

			update_option( 'cartflows-switch-ui-notice', $action );

			$response_data = array(
				'message'     => 'Redirecting to new UI',
				'redirect_to' => admin_url( 'admin.php?page=' . CARTFLOWS_SLUG ),
			);

			wp_send_json_success( $response_data );
		}
	}
}

Cartflows_Admin::get_instance();
