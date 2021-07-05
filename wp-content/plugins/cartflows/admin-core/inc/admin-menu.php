<?php
/**
 * CartFlows Admin Menu.
 *
 * @package CartFlows
 */

namespace CartflowsAdmin\AdminCore\Inc;

use CartflowsAdmin\AdminCore\Inc\AdminHelper;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin_Menu.
 */
class AdminMenu {

	/**
	 * Instance
	 *
	 * @access private
	 * @var object Class object.
	 * @since 1.0.0
	 */
	private static $instance;

	/**
	 * For Gutenberg
	 *
	 * @var $is_gutenberg_editor_active
	 */
	private $is_gutenberg_editor_active = false;

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
	 * Instance
	 *
	 * @access private
	 * @var string Class object.
	 * @since 1.0.0
	 */
	private $menu_slug;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->menu_slug = 'cartflows';

		$this->initialize_hooks();
	}

	/**
	 * Init Hooks.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function initialize_hooks() {
		add_action( 'admin_menu', array( $this, 'setup_menu' ) );
		add_action( 'admin_init', array( $this, 'settings_admin_scripts' ) );

		/* Flow content view */
		add_action( 'cartflows_render_admin_page_content', array( $this, 'render_content' ), 10, 2 );

		add_action( 'edit_form_after_title', array( $this, 'new_admin_flow_setting_redirection' ), 10, 1 );

		/*
		Redirection.
			//add_action( 'edit_form_after_title', array( $this, 'new_admin_step_setting_redirection' ), 10, 1 );
		*/

		/* To check the status of gutenberg */
		add_action( 'enqueue_block_editor_assets', array( $this, 'set_block_editor_status' ) );
		add_action( 'admin_footer', array( $this, 'back_to_new_step_ui_for_gutenberg' ) );

		add_action( 'admin_notices', array( $this, 'back_to_new_step_ui_for_classic_editor' ) );
	}


		/**
		 * Display admin notices.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
	public function back_to_new_step_ui_for_classic_editor() {

		if ( CARTFLOWS_STEP_POST_TYPE !== get_post_type() ) {
			return;
		}

		$flow_id = get_post_meta( get_the_id(), 'wcf-flow-id', true );
		$step_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0; //phpcs:ignore

		if ( $flow_id && $step_id ) {

			$step_redirect_url = esc_url( admin_url() . 'admin.php?page=' . $this->menu_slug . '&action=wcf-edit-step&step_id=' . $step_id . '&flow_id=' . $flow_id ); // phpcs:igmore Generic.Strings.UnnecessaryStringConcat.Found.
			?>
			<div class="wcf-notice-back-edit-flow">
				<p>
					<a href="<?php echo esc_url( $step_redirect_url ); ?>" class="button button-primary button-hero wcf-header-back-button" style="text-decoration: none;">
						<?php esc_html_e( 'Back to Step Editing', 'cartflows' ); ?>
					</a>
				</p>
			</div>
			<?php
		}

	}

	/**
	 * Set status true for gutenberg.
	 *
	 * @return void
	 */
	public function set_block_editor_status() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Set gutenberg status here.
		$this->is_gutenberg_editor_active = true;
	}

	/**
	 * Back to flow button gutenberg template
	 *
	 * @return void
	 */
	public function back_to_new_step_ui_for_gutenberg() {

		// Exit if block editor is not enabled.
		if ( ! $this->is_gutenberg_editor_active ) {
			return;
		}

		wp_enqueue_script( 'cartflows-admin' . '-common-script', CARTFLOWS_ADMIN_CORE_URL . 'assets/js/common.js', array( 'jquery' ), CARTFLOWS_VER, false ); //phpcs:ignore

		if ( CARTFLOWS_STEP_POST_TYPE !== get_post_type() ) {
			return;
		}

		$flow_id = get_post_meta( get_the_id(), 'wcf-flow-id', true );
		$step_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0; //phpcs:ignore

		if ( $flow_id && $step_id ) {
			$step_redirect_url = esc_url( admin_url() . 'admin.php?page=' . $this->menu_slug . '&action=wcf-edit-step&step_id=' . $step_id . '&flow_id=' . $flow_id ); //phpcs:ignore Generic.Strings.UnnecessaryStringConcat.Found.

			?>
		<script id="wcf-gutenberg-back-flow-button" type="text/html">
			<div class="wcf-notice-back-edit-flow gutenberg-button" >
				<a href="<?php echo $step_redirect_url; ?>" class="button button-primary button-large wcf-header-back-button" style="text-decoration: none;">
					<?php esc_html_e( 'Back to Step Editing', 'cartflows' ); ?>
				</a>
			</div>
		</script>
			<?php
		}
	}

	/**
	 * Back to flow button
	 *
	 * @param array $meta meta data.
	 *
	 * @return void
	 */
	public function new_admin_flow_setting_redirection( $meta ) {

		$flow_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0; //phpcs:ignore

		$post_type = get_post_type();

		if ( CARTFLOWS_FLOW_POST_TYPE === $post_type && 0 !== $flow_id ) {

			$redirect_url = esc_url( admin_url() . 'admin.php?page=' . $this->menu_slug . '&action=wcf-edit-flow&flow_id=' . $flow_id );
			$btn_markup   = '<div class="wcf-flow-editing-action" style="padding: 50px;text-align: center;">';
			$btn_markup  .= '<a class="button button-primary button-hero" href="' . $redirect_url . '">' . __( 'Go to Flow Editing', 'cartflows' ) . '</a>';
			$btn_markup  .= '</div>';

			echo $btn_markup;
		}
	}

	/**
	 * Back to flow button
	 *
	 * @param int $flow_id id.
	 *
	 * @return void
	 */
	public function new_admin_step_setting_redirection( $flow_id ) {

		$flow_id = isset( $flow_id ) ? intval( $flow_id ) : 0;

		$step_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0; //phpcs:ignore

		if ( 0 !== $flow_id && 0 !== $step_id ) {

			$redirect_url       = esc_url( admin_url() . 'admin.php?page=' . $this->menu_slug . '&action=wcf-edit-step&step_id=' . $step_id . '&flow_id=' . $flow_id );
			$add_new_btn_markup = "<a class='button button-primary button-hero' href='$redirect_url'>" . __( 'Go to Step Editing', 'cartflows' ) . ' </a>';
			echo $add_new_btn_markup;
		}

	}

	/**
	 *  Initialize after Cartflows pro get loaded.
	 */
	public function settings_admin_scripts() {
		// Enqueue admin scripts.
		if (isset($_GET['page']) && ('cartflows' === $_GET['page'] || false !== strpos($_GET['page'], 'cartflows_'))) { //phpcs:ignore

			add_action( 'admin_enqueue_scripts', array( $this, 'styles_scripts' ) );

			add_filter( 'admin_footer_text', array( $this, 'add_footer_link' ), 99 );
		}
	}

	/**
	 * Add submenu to admin menu.
	 *
	 * @since 1.0.0
	 */
	public function setup_menu() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		global $submenu;

		$parent_slug = $this->menu_slug;
		$capability  = 'manage_options';

		add_menu_page(
			'CartFlows',
			'CartFlows',
			$capability,
			$parent_slug,
			array( $this, 'render' ),
			'data:image/svg+xml;base64,' . base64_encode(file_get_contents(CARTFLOWS_DIR . 'assets/images/cartflows-icon.svg')), //phpcs:ignore
			40
		);

		// Add settings menu.
		add_submenu_page(
			$parent_slug,
			__( 'Flows', 'cartflows' ),
			__( 'Flows', 'cartflows' ),
			$capability,
			'admin.php?page=' . $this->menu_slug . '&path=flows'
		);
		add_submenu_page(
			$parent_slug,
			__( 'Settings', 'cartflows' ),
			__( 'Settings', 'cartflows' ),
			$capability,
			'admin.php?page=' . $this->menu_slug . '&path=settings'
		);
		add_submenu_page(
			$parent_slug,
			__( 'Templates', 'cartflows' ),
			__( 'Templates', 'cartflows' ),
			$capability,
			'admin.php?page=' . $this->menu_slug . '&path=library'
		);

		// Rename to Home menu.
		$submenu[$parent_slug][0][0] = __('Home', 'cartflows'); //phpcs:ignore
	}

	/**
	 * Renders the admin settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function render() {
		$menu_page_slug = (isset($_GET['page'])) ? sanitize_text_field(wp_unslash($_GET['page'])) : CARTFLOWS_SETTINGS; //phpcs:ignore
		$page_action    = '';

		if ( isset( $_GET['action'] )  ) { //phpcs:ignore
			$page_action = sanitize_text_field( wp_unslash( $_GET['action'] ) ); //phpcs:ignore
			$page_action = str_replace( '_', '-', $page_action );
		}

		include_once CARTFLOWS_ADMIN_CORE_DIR . 'views/admin-base.php';
	}

	/**
	 * Renders the admin settings content.
	 *
	 * @since 1.0.0
	 * @param sting $menu_page_slug current page name.
	 * @param sting $page_action current page action.
	 *
	 * @return void
	 */
	public function render_content( $menu_page_slug, $page_action ) {

		if ( 'cartflows' === $menu_page_slug ) {
			if ( $this->is_current_page( 'cartflows' ) ) {
				include_once CARTFLOWS_ADMIN_CORE_DIR . 'views/settings-app.php';
			} elseif ( $this->is_current_page( 'cartflows', array( 'wcf-edit-flow', 'wcf-edit-step' ) ) ) {
				include_once CARTFLOWS_ADMIN_CORE_DIR . 'views/editor-app.php';
			} elseif ( $this->is_current_page( 'cartflows', array( 'wcf-log' ) ) ) {
				include_once CARTFLOWS_ADMIN_CORE_DIR . 'inc/wcf-debugger.php';
			} elseif ( $this->is_current_page( 'cartflows', array( 'wcf-license' ) ) && 'active' === $this->get_plugin_status( 'cartflows-pro/cartflows-pro.php' ) ) {
				include_once CARTFLOWS_ADMIN_CORE_DIR . 'inc/wcf-pro-license.php';
			} else {
				include_once CARTFLOWS_ADMIN_CORE_DIR . 'views/404-error.php';
			}
		}
	}

	/**
	 * Enqueues the needed CSS/JS for the builder's admin settings page.
	 *
	 * @since 1.0.0
	 */
	public function styles_scripts() {

		$admin_slug = 'cartflows-admin';

		// Styles.
		wp_enqueue_style( $admin_slug . '-common', CARTFLOWS_ADMIN_CORE_URL . 'assets/css/common.css', array(), CARTFLOWS_VER );
		wp_style_add_data( $admin_slug . '-common', 'rtl', 'replace' );

		wp_enqueue_style( $admin_slug . '-header', CARTFLOWS_ADMIN_CORE_URL . 'assets/css/header.css', array(), CARTFLOWS_VER );
		wp_style_add_data( $admin_slug . '-header', 'rtl', 'replace' );

		/*
		Enqueue.
				// wp_enqueue_style( $admin_slug . '-fixed-header', CARTFLOWS_ADMIN_CORE_URL . 'assets/css/fixed-header.css', array(), CARTFLOWS_VER );
				// wp_style_add_data( $admin_slug . '-fixed-header', 'rtl', 'replace' );
		*/

		wp_enqueue_script( $admin_slug . '-common-script', CARTFLOWS_ADMIN_CORE_URL . 'assets/js/common.js', array( 'jquery' ), CARTFLOWS_VER, false );

		$current_flow_steps = array();
		$flow_id = isset( $_GET['flow_id'] ) ? intval( $_GET['flow_id'] ) : 0; //phpcs:ignore
		if ( $flow_id ) {
			$current_flow_steps = AdminHelper::get_flow_meta_options( $flow_id );
		}

		$product_src = esc_url_raw(
			add_query_arg(
				array(
					'post_type'      => 'product',
					'wcf-woo-iframe' => 'true',
				),
				admin_url( 'post-new.php' )
			)
		);

		$page_builder = \Cartflows_Helper::get_common_setting( 'default_page_builder' );

		// Fixed bulk action.
		$active_flows_bulkactions = array(
			array(
				'value' => '-1',
				'label' => __( 'Bulk Action', 'cartflows' ),
			),
			array(
				'value' => 'draft',
				'label' => __( 'Move to Draft', 'cartflows' ),
			),
			array(
				'value' => 'trash',
				'label' => __( 'Move to Trash', 'cartflows' ),
			),
			array(
				'value' => 'export',
				'label' => __( 'Export', 'cartflows' ),
			),
			array(
				'value' => 'delete_permanently',
				'label' => __( 'Delete Permanently', 'cartflows' ),
			),
		);

		$trash_flows_bulkactions = array(
			array(
				'value' => '-1',
				'label' => __( 'Bulk Action', 'cartflows' ),
			),
			array(
				'value' => 'restore',
				'label' => __( 'Restore', 'cartflows' ),
			),
			array(
				'value' => 'delete_permanently',
				'label' => __( 'Delete Permanently', 'cartflows' ),
			),
		);

		$draft_flows_bulkactions = array(
			array(
				'value' => '-1',
				'label' => __( 'Bulk Action', 'cartflows' ),
			),
			array(
				'value' => 'export',
				'label' => __( 'Export', 'cartflows' ),
			),
			array(
				'value' => 'trash',
				'label' => __( 'Move to Trash', 'cartflows' ),
			),
			array(
				'value' => 'delete_permanently',
				'label' => __( 'Delete Permanently', 'cartflows' ),
			),
		);

		$page_builder      = \Cartflows_Helper::get_common_setting( 'default_page_builder' );
		$page_builder_name = \Cartflows_Helper::get_page_builder_name( $page_builder );

		$localize = apply_filters(
			'cartflows_react_admin_localize',
			array(
				'current_user'                    => ! empty( wp_get_current_user()->user_firstname ) ? wp_get_current_user()->user_firstname : wp_get_current_user()->display_name,
				'cf_pro_status'                   => $this->get_plugin_status( 'cartflows-pro/cartflows-pro.php' ),
				'woocommerce_status'              => $this->get_plugin_status( 'woocommerce/woocommerce.php' ),
				'default_page_builder'            => $page_builder,
				'required_plugins'                => \Cartflows_Helper::get_plugins_groupby_page_builders(),
				'required_plugins_data'           => $this->get_required_plugins_data(),
				'is_any_required_plugins_missing' => $this->get_any_required_plugins_status(),
				'admin_base_slug'                 => $this->menu_slug,
				'admin_base_url'                  => admin_url(),
				'plugin_dir'                      => CARTFLOWS_URL,
				'admin_url'                       => admin_url( 'admin.php' ),
				'ajax_url'                        => admin_url( 'admin-ajax.php' ),
				'home_slug'                       => $this->menu_slug,
				'is_pro'                          => _is_cartflows_pro(),
				'page_builder'                    => $page_builder,
				'page_builder_name'               => $page_builder_name,
				'global_checkout'                 => \Cartflows_Helper::get_common_setting( 'global_checkout' ),
				'flows_count'                     => \wp_count_posts( CARTFLOWS_FLOW_POST_TYPE, 'readable' ),
				'currentFlowSteps'                => $current_flow_steps,
				'license_status'                  => \get_option( 'wc_am_client_cartflows_activated', '' ),
				'cf_domain_url'                   => CARTFLOWS_DOMAIN_URL,
				'logo_url'                        => esc_url_raw( CARTFLOWS_URL . 'assets/images/cartflows-logo.svg' ),
				'create_product_src'              => $product_src,
				'cf_font_family'                  => AdminHelper::get_font_family(),
				'flows_and_steps'                 => \Cartflows_Helper::get_instance()->get_flows_and_steps(),
				'active_flows_bulkactions'        => $active_flows_bulkactions,
				'trash_flows_bulkactions'         => $trash_flows_bulkactions,
				'draft_flows_bulkactions'         => $draft_flows_bulkactions,
				'woo_currency'                    => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '',
				'template_library_url'            => wcf()->get_site_url(),
				'image_placeholder'               => esc_url_raw( CARTFLOWS_URL . 'admin-core/assets/images/image-placeholder.png' ),
			)
		);

		if ( $this->is_current_page( $this->menu_slug ) ) {
			$this->settings_app_scripts( $localize );
		} elseif ( $this->is_current_page( 'cartflows', array( 'wcf-edit-flow', 'wcf-edit-step' ) ) ) {
			wp_enqueue_media();
			$this->editor_app_scripts( $localize );
		}
	}

	/**
	 * Get required plugin status.
	 */
	public function get_required_plugins_data() {

		$missing_plugins_data = array();

		$page_builder_plugins = \Cartflows_Helper::get_plugins_groupby_page_builders();

		foreach ( $page_builder_plugins as $slug => $data ) {

			$missing_plugins_data[ $slug ] = 'no';
			$current_page_builder_data     = $page_builder_plugins[ $slug ];

			foreach ( $current_page_builder_data['plugins'] as $plugin ) {
				if ( 'activate' === $plugin['status'] || 'install' === $plugin['status'] ) {
					$missing_plugins_data[ $slug ] = 'yes';
				}
			}

			// Divi.
			if ( 'divi' === $slug ) {
				if ( 'activate' === $current_page_builder_data['theme-status'] ) {
					$missing_plugins_data[ $slug ] = 'yes';
				}
			}
		}

		return $missing_plugins_data;
	}
	/**
	 * Get required plugin status
	 */
	public function get_any_required_plugins_status() {

		$default_page_builder = \Cartflows_Helper::get_common_setting( 'default_page_builder' );
		$any_inactive         = 'no';

		$page_builder_plugins = \Cartflows_Helper::get_plugins_groupby_page_builders();

		if ( isset( $page_builder_plugins[ $default_page_builder ] ) ) {

			$current_page_builder_data = $page_builder_plugins[ $default_page_builder ];

			foreach ( $current_page_builder_data['plugins'] as $plugin ) {
				if ( 'activate' === $plugin['status'] || 'install' === $plugin['status'] ) {
					$any_inactive = 'yes';
				}
			}

			// Divi.
			if ( 'divi' === $default_page_builder ) {
				if ( 'activate' === $current_page_builder_data['theme-status'] ) {
					$any_inactive = 'yes';
				}
			}
		}

		return $any_inactive;
	}

	/**
	 * Get plugin status
	 *
	 * @since 1.1.4
	 *
	 * @param  string $plugin_init_file Plguin init file.
	 * @return mixed
	 */
	public function get_plugin_status( $plugin_init_file ) {

		$installed_plugins = get_plugins();

		if ( ! isset( $installed_plugins[ $plugin_init_file ] ) ) {
			return 'not-installed';
		} elseif ( is_plugin_active( $plugin_init_file ) ) {
			return 'active';
		} else {
			return 'inactive';
		}
	}

	/**
	 * Settings app scripts
	 *
	 * @param array $localize Variable names.
	 */
	public function settings_app_scripts( $localize ) {
		$handle            = 'wcf-react-settings';
		$build_path        = CARTFLOWS_ADMIN_CORE_DIR . 'assets/build/';
		$build_url         = CARTFLOWS_ADMIN_CORE_URL . 'assets/build/';
		$script_asset_path = $build_path . 'settings-app.asset.php';
		$script_info       = file_exists( $script_asset_path )
			? include $script_asset_path
			: array(
				'dependencies' => array(),
				'version'      => CARTFLOWS_VER,
			);

		$script_dep = array_merge( $script_info['dependencies'], array( 'updates' ) );

		wp_register_script(
			$handle,
			$build_url . 'settings-app.js',
			$script_dep,
			$script_info['version'],
			true
		);

		wp_register_style(
			$handle,
			$build_url . 'settings-app.css',
			array(),
			CARTFLOWS_VER
		);

		wp_enqueue_script( $handle );

		wp_set_script_translations( $handle, 'cartflows' );

		wp_enqueue_style( $handle );
		wp_style_add_data( $handle, 'rtl', 'replace' );

		$localize['is_flows_limit'] = ( ! _is_cartflows_pro() && 3 <= AdminHelper::get_flows_count() ) ? true : false;

		wp_localize_script( $handle, 'cartflows_react', $localize );

	}

	/**
	 * Settings app scripts
	 *
	 * @param array $localize Variable names.
	 */
	public function editor_app_scripts( $localize ) {
		$handle            = 'wcf-editor-app';
		$build_path        = CARTFLOWS_ADMIN_CORE_DIR . 'assets/build/';
		$build_url         = CARTFLOWS_ADMIN_CORE_URL . 'assets/build/';
		$script_asset_path = $build_path . 'editor-app.asset.php';
		$script_info       = file_exists( $script_asset_path )
			? include $script_asset_path
			: array(
				'dependencies' => array(),
				'version'      => CARTFLOWS_VER,
			);

		wp_register_script(
			$handle,
			$build_url . 'editor-app.js',
			$script_info['dependencies'],
			$script_info['version'],
			true
		);

		wp_register_style(
			$handle,
			$build_url . 'editor-app.css',
			array(),
			CARTFLOWS_VER
		);

		wp_enqueue_script( $handle );

		wp_set_script_translations( $handle, 'cartflows' );

		wp_enqueue_style( $handle );
		wp_style_add_data( $handle, 'rtl', 'replace' );

		$localize['flow_id'] = isset( $_GET['flow_id'] ) ? intval( $_GET['flow_id'] ) : 0; //phpcs:ignore

		$step_id = isset( $_GET['step_id'] ) ? intval( $_GET['step_id'] ) : false; //phpcs:ignore

		if ( $step_id ) {

			$meta_options        = AdminHelper::get_step_meta_options( $step_id );
			$localize['options'] = $meta_options['options'];
		}

		wp_localize_script( $handle, 'cartflows_react', $localize );
	}

	/**
	 * CHeck if it is current page by parameters
	 *
	 * @param string $page_slug Menu name.
	 * @param string $action Menu name.
	 *
	 * @return  string page url
	 */
	public function is_current_page( $page_slug = '', $action = '' ) {

		$page_matched = false;

		if ( empty( $page_slug ) ) {
			return false;
		}

		$current_page_slug = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : ''; //phpcs:ignore
		$current_action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : ''; //phpcs:ignore

		if ( ! is_array( $action ) ) {
			$action = explode( ' ', $action );
		}

		if ( $page_slug === $current_page_slug && in_array( $current_action, $action, true ) ) {
			$page_matched = true;
		}

		return $page_matched;
	}

	/**
	 *  Add footer link.
	 */
	public function add_footer_link() {

		$logs_page_url = add_query_arg(
			array(
				'page'   => CARTFLOWS_SLUG,
				'action' => 'wcf-log',
			),
			admin_url( '/admin.php' )
		);

		echo '<span id="footer-thankyou"> Thank you for using <a href="https://cartflows.com/">CartFlows</a></span> | <a href="' . $logs_page_url . '">Logs</a> | <a href="#!" class="switch-to-old-ui">' . __( 'Switch To Old UI', 'cartflows' ) . '</a>';
	}

}

AdminMenu::get_instance();
