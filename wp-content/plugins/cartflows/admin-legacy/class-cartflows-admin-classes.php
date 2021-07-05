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
 * Class Cartflows_Admin_Classes.
 */
class Cartflows_Admin_Classes {

	/**
	 * Calls on initialization
	 *
	 * @since 1.0.0
	 */
	public static function init() {

		self::init_hooks();
	}

	/**
	 * Init Hooks.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function init_hooks() {

		if ( ! is_admin() ) {
			return;
		}

		include_once CARTFLOWS_LEGACY_ADMIN_DIR . 'class-cartflows-admin-fields.php';

		/*
		Add CARTFLOWS menu option to admin.
		add_action( 'network_admin_menu', __CLASS__ . '::menu' );
		*/
		add_action( 'admin_menu', __CLASS__ . '::menu' );
		add_action( 'admin_menu', __CLASS__ . '::submenu', 999 );
		add_action( 'admin_menu', __CLASS__ . '::register_as_submenu', 100 );

		add_action( 'cartflows_render_admin_content', __CLASS__ . '::render_content' );

		add_action( 'admin_init', __CLASS__ . '::settings_admin_scripts' );

		/* Global Addmin Script */
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::global_admin_scripts', 20 );

		add_action( 'admin_footer', __CLASS__ . '::global_admin_data', 9555 );

		add_action( 'admin_init', __CLASS__ . '::cartflows_after_save_permalinks' );

		add_filter( 'get_user_option_meta-box-order_' . CARTFLOWS_STEP_POST_TYPE, __CLASS__ . '::metabox_order' );

		add_action( 'save_post_cartflows_step', __CLASS__ . '::delete_dynamic_css', 10, 3 );
	}

	/**
	 * Delete the step dynamic css when cartflows_step post is update.
	 *
	 * @param  int    $post_id post id.
	 * @param  object $post post data.
	 * @param  bool   $update existing post.
	 */
	public static function delete_dynamic_css( $post_id, $post, $update ) {

		// We are storing the our dynamic css in the post meta and deleting when any setting changes and post updated. Once deleted it will be regenerated with first page load.
		delete_post_meta( $post_id, 'wcf-dynamic-css' );
	}

	/**
	 * Metabox fixed orders.
	 *
	 * @param  array $metabox_orders Orders.
	 * @return array
	 */
	public static function metabox_order( $metabox_orders ) {

		if ( isset( $metabox_orders['side'] ) ) {

			$metabox_orders['side'] = str_replace(
				array(
					'wcf-checkout-settings',
					'wcf-ladning-settings',
					'wcf-optin-settings',
					'wcf-thankyou-settings',
				),
				'',
				$metabox_orders['side']
			);
		}

		return $metabox_orders;
	}

	/**
	 *  After save of permalinks.
	 */
	public static function cartflows_after_save_permalinks() {

		$has_saved_permalinks = get_option( 'cartflows_permalink_saved' );
		if ( $has_saved_permalinks ) {
			flush_rewrite_rules();
			delete_option( 'cartflows_permalink_saved' );
		}
	}


	/**
	 *  Initialize after Cartflows pro get loaded.
	 */
	public static function settings_admin_scripts() {
		// Enqueue admin scripts.
		if ( isset( $_GET['page'] ) && ( 'cartflows' === $_GET['page'] || false !== strpos( $_GET['page'], 'cartflows_' ) ) ) { //phpcs:ignore
			add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles_scripts' );

			self::save_settings();
		}
	}

	/**
	 * Renders the admin settings menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function menu() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		add_menu_page(
			'CartFlows',
			'CartFlows',
			'manage_options',
			CARTFLOWS_SLUG,
			__CLASS__ . '::render',
			'data:image/svg+xml;base64,' . base64_encode( file_get_contents( CARTFLOWS_DIR . 'assets/images/cartflows-icon.svg' ) ),//phpcs:ignore
			39.7
		);

	}

	/**
	 * Add submenu to admin menu.
	 *
	 * @since 1.0.0
	 */
	public static function submenu() {

		global $submenu;

		$parent_slug = CARTFLOWS_SLUG;
		$capability  = 'manage_options';

		// Home menu.
		$submenu[ $parent_slug ][0][0] = __( 'Home', 'cartflows' ); //phpcs:ignore

		// Add settings menu.
		add_submenu_page(
			$parent_slug,
			__( 'Settings', 'cartflows' ),
			__( 'Settings', 'cartflows' ),
			$capability,
			'cartflows_settings',
			__CLASS__ . '::render'
		);
	}

	/**
	 * Add flows submenu
	 *
	 * @since 1.0.0
	 */
	public static function register_as_submenu() {
		add_submenu_page(
			CARTFLOWS_SLUG,
			__( 'Flows', 'cartflows' ),
			__( 'Flows', 'cartflows' ),
			'edit_pages',
			'edit.php?post_type=' . CARTFLOWS_FLOW_POST_TYPE
		);
	}

	/**
	 * Renders the admin settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function render() {
		$menu_page_slug = ( isset( $_GET['page'] ) ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : CARTFLOWS_SETTINGS; //phpcs:ignore
		$action 		= ( isset( $_GET['action'] ) ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : ''; //phpcs:ignore
		$action         = ( ! empty( $action ) && '' != $action ) ? $action : 'general';
		$action         = str_replace( '_', '-', $action );

		// Enable header icon filter below.
		$header_wrapper_class = apply_filters( 'cartflows_admin_header_wrapper_class', array( $action, $menu_page_slug ) );

		include_once CARTFLOWS_DIR . 'admin-legacy/includes/admin/cartflows-admin.php';
	}

	/**
	 * Renders the admin settings content.
	 *
	 * @since 1.0.0
	 * @param sting $menu_page_slug current page name.
	 *
	 * @return void
	 */
	public static function render_content( $menu_page_slug ) {

		if ( CARTFLOWS_SETTINGS === $menu_page_slug ) {

			$action = ( isset( $_GET['action'] ) ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : ''; //phpcs:ignore
			$action = ( ! empty( $action ) && '' != $action ) ? $action : 'general';
			$action = str_replace( '_', '-', $action );
			$action = 'general';

			include_once CARTFLOWS_DIR . 'admin-legacy/includes/admin/cartflows-general.php';
		}

		if ( 'cartflows' === $menu_page_slug ) {

			$action = ( isset( $_GET['action'] ) ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : ''; //phpcs:ignore
			$action = ( ! empty( $action ) && '' != $action ) ? $action : 'general';
			$action = str_replace( '_', '-', $action );
			$action = 'general';

			include_once CARTFLOWS_DIR . 'admin-legacy/includes/admin/cartflows-home.php';
		}
	}

	/**
	 * Save Global Setting options.
	 *
	 * @since 1.0.0
	 */
	public static function save_migrate_ui_settings() {

		if ( isset( $_POST['cartflows-use-new-ui-nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cartflows-use-new-ui-nonce'] ) ), 'cartflows-use-new-ui' ) ) {

			$url = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

			delete_option( 'cartflows-legacy-admin' );
			update_option( 'cartflows-switch-ui-notice', 'update' );

			$query = array(
				'message' => 'saved',
			);

			$redirect_to = add_query_arg( $query, $url );

			wp_safe_redirect( $redirect_to );
			exit;
		} // End if statement.
	}

	/**
	 * Save Global Setting options.
	 *
	 * @since 1.0.0
	 */
	public static function save_common_settings() {

		if ( isset( $_POST['cartflows-common-settings-nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cartflows-common-settings-nonce'] ) ), 'cartflows-common-settings' ) ) {

			$url          = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$new_settings = array();

			if ( isset( $_POST['_cartflows_common'] ) ) {
				// Loop through the input and sanitize each of the values.
				$new_settings = self::sanitize_form_inputs( wp_unslash( $_POST['_cartflows_common'] ) ); //phpcs:ignore
			}

			Cartflows_Helper::update_admin_settings_option( '_cartflows_common', $new_settings, false );

			$query = array(
				'message' => 'saved',
			);

			$redirect_to = add_query_arg( $query, $url );

			wp_safe_redirect( $redirect_to );
			exit;
		} // End if statement.
	}

	/**
	 * Save Debug Setting options.
	 *
	 * @since 1.1.14
	 */
	public static function save_debug_settings() {

		if ( isset( $_POST['cartflows-debug-settings-nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cartflows-debug-settings-nonce'] ) ), 'cartflows-debug-settings' ) ) {

			$url          = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$new_settings = array();

			if ( isset( $_POST['_cartflows_debug_data'] ) ) {
				$new_settings = self::sanitize_form_inputs( wp_unslash( $_POST['_cartflows_debug_data'] ) ); //phpcs:ignore
			}

			Cartflows_Helper::update_admin_settings_option( '_cartflows_debug_data', $new_settings, false );

			$query = array(
				'message' => 'saved',
			);

			$redirect_to = add_query_arg( $query, $url );

			wp_safe_redirect( $redirect_to );
			exit;

		}
	}


	/**
	 * Save permalink Setting options.
	 *
	 * @since 1.1.14
	 */
	public static function save_permalink_settings() {

		if ( isset( $_POST['cartflows-permalink-settings-nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cartflows-permalink-settings-nonce'] ) ), 'cartflows-permalink-settings' ) ) {

			$url          = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$new_settings = array();

			if ( isset( $_POST['reset'] ) ) {
				$_POST['_cartflows_permalink'] = array(
					'permalink'           => CARTFLOWS_STEP_POST_TYPE,
					'permalink_flow_base' => CARTFLOWS_FLOW_POST_TYPE,
					'permalink_structure' => '',
				);

			}

			if ( isset( $_POST['_cartflows_permalink'] ) ) {
				$cartflows_permalink_settings = self::sanitize_form_inputs( wp_unslash( $_POST['_cartflows_permalink'] ) ); //phpcs:ignore

				if ( empty( $cartflows_permalink_settings['permalink'] ) ) {
					$new_settings['permalink'] = CARTFLOWS_STEP_POST_TYPE;
				} else {
					$new_settings['permalink'] = $cartflows_permalink_settings['permalink'];
				}

				if ( empty( $cartflows_permalink_settings['permalink_flow_base'] ) ) {
					$new_settings['permalink_flow_base'] = CARTFLOWS_FLOW_POST_TYPE;
				} else {
					$new_settings['permalink_flow_base'] = $cartflows_permalink_settings['permalink_flow_base'];
				}

				$new_settings['permalink_structure'] = $cartflows_permalink_settings['permalink_structure'];

			}

			Cartflows_Helper::update_admin_settings_option( '_cartflows_permalink', $new_settings, false );

			$query = array(
				'message' => 'saved',
			);

			$redirect_to = add_query_arg( $query, $url );

			update_option( 'cartflows_permalink_saved', true );

			wp_safe_redirect( $redirect_to );
			exit;

		}
	}

	/**
	 * Save google analytics Setting options.
	 *
	 * @since 1.1.14
	 */
	public static function save_google_analytics_settings() {

		if ( isset( $_POST['cartflows-google-analytics-settings-nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cartflows-google-analytics-settings-nonce'] ) ), 'cartflows-google-analytics-settings' ) ) {

			$url          = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$new_settings = array();

			if ( isset( $_POST['_cartflows_google_analytics'] ) ) {
				$new_settings = self::sanitize_form_inputs( $_POST['_cartflows_google_analytics'] ); //phpcs:ignore

			}

			Cartflows_Helper::update_admin_settings_option( '_cartflows_google_analytics', $new_settings, true );

			$query = array(
				'message' => 'saved',
			);

			$redirect_to = add_query_arg( $query, $url );

			wp_safe_redirect( $redirect_to );
			exit;

		}
	}

	/**
	 * Loop through the input and sanitize each of the values.
	 *
	 * @param array $input_settings input settings.
	 * @return array
	 */
	public static function sanitize_form_inputs( $input_settings = array() ) {
		$new_settings = array();
		foreach ( $input_settings as $key => $val ) {

			if ( is_array( $val ) ) {
				foreach ( $val as $k => $v ) {
					$new_settings[ $key ][ $k ] = ( isset( $val[ $k ] ) ) ? sanitize_text_field( $v ) : '';
				}
			} else {
				$new_settings[ $key ] = ( isset( $input_settings[ $key ] ) ) ? sanitize_text_field( $val ) : '';
			}
		}
		return $new_settings;
	}

	/**
	 * Check is cartflows admin.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	public static function is_global_admin() {

		$current_screen = get_current_screen();

		if (
			is_object( $current_screen ) &&
			isset( $current_screen->post_type ) &&
			( CARTFLOWS_FLOW_POST_TYPE === $current_screen->post_type ||
				CARTFLOWS_STEP_POST_TYPE === $current_screen->post_type
			)
		) {
			return true;
		}
		return false;
	}

	/**
	 * Global Admin Scripts.
	 *
	 * @since 1.0.0
	 */
	public static function global_admin_scripts() {

		global $post;

		$installed_plugins = get_plugins();
		$is_wc_installed   = isset( $installed_plugins['woocommerce/woocommerce.php'] ) ? true : false;
		$edit_test_mode    = filter_input( INPUT_GET, 'edit_test_mode', FILTER_SANITIZE_STRING );
		$edit_test_mode    = 'yes' === $edit_test_mode ? true : false;
		$step_type         = '';

		if ( self::is_global_admin() && $post ) {

			$step_type = get_post_meta( $post->ID, 'wcf-step-type', true ) ? get_post_meta( $post->ID, 'wcf-step-type', true ) : '';
		}

		$localize = array(
			'ajaxurl'               => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'            => wp_create_nonce( 'cartflows-nonce' ),
			'wc_status'             => array(
				'installed' => $is_wc_installed,
				'active'    => wcf()->is_woo_active,
				'message'   => __( 'This page requires WooCommerce plugin installed and activated!', 'cartflows' ),
			),
			'current_step_type'     => $step_type,
			'wc_activating_message' => __( 'Installing and activating..', 'cartflows' ),
			'wc_install_error'      => __( 'There was an error with the installation of plugin.', 'cartflows' ),
			'wcf_edit_test_mode'    => $edit_test_mode,
			'wcf_fetch_stats_nonce' => wp_create_nonce( 'wcf-fetch-stats' ),
		);

		$localize = apply_filters( 'cartflows_admin_js_localize', $localize );

		$localize_script  = '<!-- script to print the admin localized variables -->';
		$localize_script .= '<script type="text/javascript">';
		$localize_script .= 'var cartflows_admin = ' . wp_json_encode( $localize ) . ';';
		$localize_script .= '</script>';

		echo $localize_script;

		if ( self::is_global_admin() ) {

			// Styles.
			wp_enqueue_style( 'cartflows-global-admin', CARTFLOWS_LEGACY_ADMIN_URL . 'assets/css/global-admin.css', array(), CARTFLOWS_VER );
			wp_style_add_data( 'cartflows-global-admin', 'rtl', 'replace' );

			wp_enqueue_script(
				'wcf-global-admin',
				CARTFLOWS_LEGACY_ADMIN_URL . 'assets/js/global-admin.js',
				array( 'jquery' ),
				CARTFLOWS_VER,
				true
			);

			do_action( 'cartflows_global_admin_scripts' );
		}
	}

	/**
	 * Global Admin Data.
	 *
	 * @since 1.0.0
	 */
	public static function global_admin_data() {

		$current_screen = get_current_screen();

		if ( ! $current_screen ) {
			return;
		}

		if ( 'edit-' . CARTFLOWS_FLOW_POST_TYPE != $current_screen->id ) {
			return;
		}

		$default_page_builder = Cartflows_Helper::get_common_setting( 'default_page_builder' );
		?>

		<div id="wcf-remote-flow-importer" class="wcf-templates-popup-overlay">
			<div class="wcf-templates-popup-content">
				<div class="spinner"></div>
				<div class="wcf-templates-wrap wcf-templates-wrap-flows">

					<div id="wcf-remote-flow-actions" class="wcf-template-header">
						<div class="wcf-template-logo-wrap">
							<span class="wcf-cartflows-logo-img">
								<span class="cartflows-logo-icon"></span>
							</span>
							<span class="wcf-cartflows-title"><?php esc_html_e( 'Flows Library', 'cartflows' ); ?></span>
						</div>
						<div class="wcf-tab-wrapper">
							<?php if ( 'other' !== $default_page_builder ) { ?>
								<div id="wcf-get-started-steps">
									<ul class="filter-links ">
										<li>
											<a href="#" class="current" data-slug="ready-templates" data-title="<?php esc_html_e( 'Ready Templates', 'cartflows' ); ?>"><?php esc_html_e( 'Ready Templates', 'cartflows' ); ?></a>
										</li>
										<li>
											<a href="#" data-slug="canvas" data-title="<?php esc_html_e( 'Create Your Own', 'cartflows' ); ?>"><?php esc_html_e( 'Create Your Own', 'cartflows' ); ?></a>
										</li>
									</ul>
								</div>
							<?php } ?>
						</div>
						<div class="wcf-popup-close-wrap">
							<span class="close-icon"><span class="wcf-cartflow-icons dashicons dashicons-no"></span></span>
						</div>
					</div>
					<!-- <div class="wcf-search-form">
						<label class="screen-reader-text" for="wp-filter-search-input"><?php esc_html_e( 'Search Sites', 'cartflows' ); ?> </label>
						<input placeholder="<?php esc_html_e( 'Search Flow...', 'cartflows' ); ?>" type="text" aria-describedby="live-search-desc" class="wcf-flow-search-input">
					</div> -->

					<div id="wcf-remote-content">
						<?php if ( 'other' !== $default_page_builder ) { ?>
							<div id="wcf-ready-templates">
								<div id="wcf-remote-filters">
									<div id="wcf-page-builders"></div>
									<div id="wcf-categories"></div>
								</div>
								<div class="wcf-page-builder-notice"></div>
								<div id="wcf-remote-flow-list" class="wcf-remote-list wcf-template-list-wrap"><span class="spinner is-active"></span></div>
								<div id="wcf-upcoming-page-builders" style="display: none;" class="wcf-remote-list wcf-template-list-wrap"></div>
							</div>
						<?php } ?>
						<div id="wcf-start-from-scratch" style="<?php echo ( 'other' !== $default_page_builder ) ? 'display: none;' : ''; ?>">
							<div class="inner">
								<a href="#" class="button button-hero button-primary cartflows-flow-import-blank"><?php esc_html_e( 'Design Your Flow', 'cartflows' ); ?></a>
								<p class="wcf-learn-how"><a href="https://cartflows.com/docs/cartflows-step-types/" target="_blank"><?php esc_html_e( 'Learn How', 'cartflows' ); ?> <i class="dashicons dashicons-external"></i></a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
	}

	/**
	 * Enqueues the needed CSS/JS for the builder's admin settings page.
	 *
	 * @since 1.0.0
	 */
	public static function styles_scripts() {

		// Styles.
		wp_enqueue_style( 'cartflows-admin-settings', CARTFLOWS_LEGACY_ADMIN_URL . 'assets/css/admin-menu-settings.css', array(), CARTFLOWS_VER );
		wp_style_add_data( 'cartflows-admin-settings', 'rtl', 'replace' );

		// Script.
		wp_enqueue_script( 'cartflows-admin-settings', CARTFLOWS_LEGACY_ADMIN_URL . 'assets/js/admin-menu-settings.js', array( 'jquery', 'wp-util', 'updates' ), CARTFLOWS_VER, false );

		$localize = array(
			'ajax_nonce' => wp_create_nonce( 'cartflows-widget-nonce' ),
		);

		wp_localize_script( 'cartflows-admin-settings', 'cartflows', apply_filters( 'cartflows_js_localize', $localize ) );

		do_action( 'cartflows_admin_settings_after_enqueue_scripts' );
	}

	/**
	 * Save All admin settings here
	 */
	public static function save_settings() {

		// Only admins can save settings.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		self::save_migrate_ui_settings();
		self::save_common_settings();
		self::save_debug_settings();
		self::save_permalink_settings();

		self::save_google_analytics_settings();
		self::save_facebook_settings();

		// Let extensions hook into saving.
		do_action( 'cartflows_admin_settings_save' );
	}

	/**
	 * Get and return page URL
	 *
	 * @param string $menu_slug Menu name.
	 * @since 1.0.0
	 * @return  string page url
	 */
	public static function get_page_url( $menu_slug ) {

		$parent_page = self::$default_menu_position;

		if ( strpos( $parent_page, '?' ) !== false ) {
			$query_var = '&page=' . self::$plugin_slug;
		} else {
			$query_var = '?page=' . self::$plugin_slug;
		}

		$parent_page_url = admin_url( $parent_page . $query_var );

		$url = $parent_page_url . '&action=' . $menu_slug;

		return esc_url( $url );
	}

	/**
	 * Save Global Setting options.
	 *
	 * @since 1.0.0
	 */
	public static function save_facebook_settings() {

		if ( isset( $_POST['cartflows-facebook-settings-nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cartflows-facebook-settings-nonce'] ) ), 'cartflows-facebook-settings' ) ) {

			$url          = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$new_settings = array();

			if ( isset( $_POST['_cartflows_facebook'] ) ) {
				$new_settings = self::sanitize_form_inputs( wp_unslash( $_POST['_cartflows_facebook'] ) ); //phpcs:ignore
			}

			Cartflows_Helper::update_admin_settings_option( '_cartflows_facebook', $new_settings, false );
			$query       = array(
				'message' => 'saved',
			);
			$redirect_to = add_query_arg( $query, $url );
			wp_safe_redirect( $redirect_to );
			exit;
		}
	}

	/**
	 * Show embed header.
	 *
	 * @since 1.0.0
	 */
	public static function show_embed_header() {

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
}

Cartflows_Admin_Classes::init();
