<?php
/**
 * Checkout post meta
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta Boxes setup
 */
class Cartflows_Checkout_Meta extends Cartflows_Meta {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Meta Option
	 *
	 * @var $meta_option
	 */
	private static $meta_option = null;

	/**
	 * Meta Options map key->value map,
	 *
	 * @var $meta_option_data
	 */
	private static $meta_option_data = array();

	/**
	 * Initiator
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

		/* Init Metabox */
		add_action( 'load-post.php', array( $this, 'init_metabox' ) );
		add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
	}
	/**
	 * Init Metabox
	 */
	public function init_metabox() {

		add_action( 'add_meta_boxes', array( $this, 'setup_meta_box' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_meta_box' ) );
	}

	/**
	 *  Setup Metabox
	 *
	 * @param string $post_type post type.
	 * @param object $post post object.
	 */
	public function setup_meta_box( $post_type, $post ) {

		if ( _is_wcf_checkout_type() ) {

			$stored_meta   = get_post_meta( $post->ID );
			$checkout_meta = self::get_meta_option( $post->ID );

			// Set stored and override defaults.
			foreach ( $stored_meta as $key => $value ) {
				if ( array_key_exists( $key, $checkout_meta ) ) {
					self::$meta_option[ $key ]['default'] = ( isset( $stored_meta[ $key ][0] ) ) ? maybe_unserialize( $stored_meta[ $key ][0] ) : '';
				} else {
					self::$meta_option[ $key ]['default'] = ( isset( $stored_meta[ $key ][0] ) ) ? $stored_meta[ $key ][0] : '';
				}
			}

			// Get defaults.
			$new_meta = self::get_meta_option( $post->ID );

			foreach ( $new_meta as $key => $value ) {
				self::$meta_option_data[ $key ] = $new_meta[ $key ]['default'];
			}

			add_meta_box(
				'wcf-checkout-settings',                // Id.
				__( 'Checkout Settings', 'cartflows' ), // Title.
				array( $this, 'settings_markup_metabox' ),      // Callback.
				$post_type,                 // Post_type.
				'normal',                               // Context.
				'high'                                  // Priority.
			);

			add_meta_box(
				'wcf-checkout-design-settings',                // Id.
				__( 'Checkout Layout & Design', 'cartflows' ), // Title.
				array( $this, 'design_markup_metabox' ),      // Callback.
				$post_type,                 // Post_type.
				'normal',                               // Context.
				'high'                                  // Priority.
			);
		}
	}

	/**
	 * Metabox Markup
	 *
	 * @param  object $post Post object.
	 * @return void
	 */
	public function settings_markup_metabox( $post ) {

		wp_nonce_field( 'save-nonce-checkout-step-meta', 'nonce-checkout-step-meta' );

		do_action( 'wcf_checkout_settings_markup_before' );
		$this->settings_tabs_markup( self::$meta_option_data, $post->ID );
		do_action( 'wcf_checkout_settings_markup_after' );
	}

	/**
	 * Page Header Tabs
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function settings_tabs_markup( $options, $post_id ) {

		$active_tab = 'wcf-checkout-general';

		$tab_array = array(
			array(
				'title' => __( 'Select Product', 'cartflows' ),
				'id'    => 'wcf-checkout-general',
				'class' => 'wcf-checkout-general' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-info',
			),
			array(
				'title' => __( 'Product Options', 'cartflows' ),
				'id'    => 'wcf-product-options',
				'class' => 'wcf-product-options' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons dashicons-screenoptions',
			),
			array(
				'title' => __( 'Order Bump', 'cartflows' ),
				'id'    => 'wcf-product-order-bump',
				'class' => 'wcf-product-order-bump' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-cart',
			),
			array(
				'title' => __( 'Checkout Offer', 'cartflows' ),
				'id'    => 'wcf-pre-checkout-offer',
				'class' => 'wcf-pre-checkout-offer' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-arrow-up-alt',
			),
			array(
				'title' => __( 'Checkout Fields', 'cartflows' ),
				'id'    => 'wcf-checkout-custom-fields',
				'class' => 'wcf-checkout-custom-fields' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-welcome-widgets-menus',
			),
			array(
				'title' => __( 'Checkout Settings', 'cartflows' ),
				'id'    => 'wcf-checkout-custom-settings',
				'class' => 'wcf-checkout-custom-settings' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-admin-generic',
			),
			array(
				'title' => __( 'Custom Script', 'cartflows' ),
				'id'    => 'wcf-checkout-custom-script-header',
				'class' => 'wcf-checkout-custom-script-header' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-format-aside',
			),
		);

		$show_logo = filter_input( INPUT_GET, 'logo-tab', FILTER_VALIDATE_BOOLEAN );

		if ( $show_logo ) {
			$logo_tab = array(
				'title' => __( 'Logo (Optional)', 'cartflows' ),
				'id'    => 'wcf-checkout-header',
				'class' => 'wcf-checkout-header' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-format-image',
			);
			array_push( $tab_array, $logo_tab );
		}

		$tabs = apply_filters( 'cartflows_checkout_tabs', $tab_array, $active_tab );

		?>
		<div class="wcf-checkout-table wcf-metabox-wrap widefat">
			<div class="wcf-table-container">
				<div class="wcf-column-left">
					<div class="wcf-tab-wrapper">

						<?php foreach ( $tabs as $key => $tab ) { ?>
							<div class="<?php echo esc_attr( $tab['class'] ); ?>" data-tab="<?php echo esc_attr( $tab['id'] ); ?>">
								<span class="dashicons <?php echo esc_attr( $tab['icon'] ); ?>"></span>
								<span class="wcf-tab-title"><?php echo esc_html( $tab['title'] ); ?></span>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="wcf-column-right">
					<?php $this->tab_general( $options, $post_id ); ?>
					<?php $this->tab_product_options( $options, $post_id ); ?>
					<?php $this->tab_product_bump( $options, $post_id ); ?>
					<?php $this->tab_pre_checkout_offer( $options, $post_id ); ?>
					<?php $this->tab_custom_fields( $options, $post_id ); ?>
					<?php $this->tab_custom_settings( $options, $post_id ); ?>
					<?php $this->tab_header_content( $options, $post_id ); ?>
					<?php $this->tab_custom_script( $options, $post_id ); ?>
					<?php do_action( 'cartflows_checkout_tabs_content', $options, $post_id ); ?>
					<?php $this->right_column_footer( $options, $post_id ); ?>
				</div>
			</div>
		</div>

		<?php
	}

	/* Design metabox settings */

	/**
	 * Metabox Markup
	 *
	 * @param  object $post Post object.
	 * @return void
	 */
	public function design_markup_metabox( $post ) {

		wp_nonce_field( 'save-nonce-checkout-step-meta', 'nonce-checkout-step-meta' );

		do_action( 'wcf_checkout_design_settings_markup_before' );
		$this->design_tabs_markup( self::$meta_option_data, $post->ID );
		do_action( 'wcf_checkout_design_settings_markup_after' );
	}

	/**
	 * Design settings Tabs
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function design_tabs_markup( $options, $post_id ) {

		include CARTFLOWS_LEGACY_ADMIN_DIR . 'modules/checkout/meta-views/design-checkout-metabox-markup.php';
	}

	/**
	 * Product options tab.
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function tab_product_options( $options, $post_id ) {
		?>
		<div class="wcf-product-options wcf-tab-content widefat">
			<?php
			if ( ! _is_cartflows_pro() ) {
				echo wcf()->meta->get_description_field(
					array(
						'name'    => 'wcf-upgrade-to-pro',
						/* translators: %s: link */
						'content' => '<i>' . sprintf( esc_html__( 'Upgrade to %1$sCartFlows Pro%2$s for Product Options feature.', 'cartflows' ), '<a href="https://cartflows.com/" target="_blank">', '</a>' ) . '</i>',
					)
				);
			} elseif ( _is_cartflows_pro() && _is_cartflows_pro_ver_less_than( '1.5.4' ) ) {
				$version      = '1.5.4';
				$file_path    = 'cartflows-pro/cartflows-pro.php';
				$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
				echo wcf()->meta->get_description_field(
					array(
						'name'    => 'wcf-upgrade-to-pro',
						// translators: %s: link.
						'content' => '<i>' . sprintf( esc_html__( 'Update %1$sCartFlows Pro%2$s to %3$s or above for Product Options', 'cartflows' ), '<a href="' . $upgrade_link . '" target="_blank">', '</a>', $version ) . '</i>',
					)
				);
			}

			do_action( 'cartflows_product_options_tab_content', $options, $post_id );
			?>
		</div>
		<?php
	}

	/**
	 * Shortcodes tab
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function design_tab_shortcodes( $options, $post_id ) {
		?>
		<div class="wcf-checkout-shortcodes wcf-tab-content widefat">

			<?php

			echo wcf()->meta->get_shortcode_field(
				array(
					'label'   => 'Checkout Page',
					'name'    => 'wcf-checkout-shortcode',
					'content' => '[cartflows_checkout]',
					'help'    => esc_html__( 'Add this shortcode to your checkout page', 'cartflows' ),
				)
			);
			?>
		</div>
		<?php
	}

	/**
	 * General tab
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function tab_general( $options, $post_id ) {
		?>
		<div class="wcf-checkout-general wcf-tab-content widefat">

			<?php

			echo wcf()->meta->get_product_selection_repeater(
				array(
					'name'        => 'wcf-checkout-products',
					'value'       => $options['wcf-checkout-products'],
					'allow_clear' => true,
				)
			);

			if ( ! _is_cartflows_pro() ) {

				echo wcf()->meta->get_hr_line_field( array() );
				echo wcf()->meta->get_description_field(
					array(
						'name'    => 'wcf-upgrade-to-pro',
						/* translators: %s: link */
						'content' => '<i>' . sprintf( esc_html__( 'Upgrade to %1$sCartFlows Pro%2$s for Pre-applied Coupon.', 'cartflows' ), '<a href="https://cartflows.com/" target="_blank">', '</a>' ) . '</i>',
					)
				);
			}

			do_action( 'cartflows_checkout_general_tab_content', $options, $post_id );

			?>
		</div>
		<?php
	}

	/**
	 * Pre Checkout tab
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function tab_pre_checkout_offer( $options, $post_id ) {
		?>
		<div class="wcf-pre-checkout-offer wcf-tab-content widefat">
			<?php
			if ( ! _is_cartflows_pro() ) {
				echo wcf()->meta->get_description_field(
					array(
						'name'    => 'wcf-upgrade-to-pro',
						/* translators: %s: link */
						'content' => '<i>' . sprintf( esc_html__( 'Upgrade to %1$sCartFlows Pro%2$s for Checkout Offer feature', 'cartflows' ), '<a href="https://cartflows.com/" target="_blank">', '</a>' ) . '</i>',
					)
				);
			} elseif ( _is_cartflows_pro_ver_less_than( '1.2.0' ) ) {

				$version = '1.2.0';
				echo wcf()->meta->get_description_field(
					array(
						'name'    => 'wcf-upgrade-to-pro',
						/* translators: %s: link */
						'content' => '<i>' . sprintf( esc_html__( 'Update to %1$sCartFlows Pro%2$s to %3$s or above for Checkout Offer feature', 'cartflows' ), '<a href="https://cartflows.com/" target="_blank">', '</a>', $version ) . '</i>',
					)
				);
			}
			?>

			<?php do_action( 'cartflows_pre_checkout_offer_tab_content', $options, $post_id ); ?> 
		</div>
		<?php
	}


	/**
	 * Pre Checkout tab
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function animate_title_settings( $options, $post_id ) {

		echo wcf()->meta->get_hr_line_field( array() );

		if ( ! _is_cartflows_pro() ) {
			echo wcf()->meta->get_description_field(
				array(
					'name'    => 'wcf-upgrade-to-pro',
					/* translators: %s: link */
					'content' => '<i>' . sprintf( __( 'Upgrade to %1$sCartFlows Pro%2$s for animate browser tab feature', 'cartflows' ), '<a href="https://cartflows.com/" target="_blank">', '</a>' ) . '</i>',
				)
			);
		} elseif ( _is_cartflows_pro_ver_less_than( '1.4.0' ) ) {

			$version = '1.4.0';
			echo wcf()->meta->get_description_field(
				array(
					'name'    => 'wcf-upgrade-to-pro',
					/* translators: %s: link */
					'content' => '<i>' . sprintf( __( 'Update to %1$sCartFlows Pro%2$s to %3$s or above for animate browser tab feature', 'cartflows' ), '<a href="https://cartflows.com/" target="_blank">', '</a>', $version ) . '</i>',
				)
			);
		}

		do_action( 'cartflows_animate_browser_tab_settings', $options, $post_id );
	}

	/**
	 * Product bump tab
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function tab_product_bump( $options, $post_id ) {
		?>
		<div class="wcf-product-order-bump wcf-tab-content widefat">
			<?php
			if ( ! _is_cartflows_pro() ) {
				echo wcf()->meta->get_description_field(
					array(
						'name'    => 'wcf-upgrade-to-pro',
						/* translators: %s: link */
						'content' => '<i>' . sprintf( esc_html__( 'Upgrade to %1$sCartFlows Pro%2$s for Order Bump feature.', 'cartflows' ), '<a href="https://cartflows.com/" target="_blank">', '</a>' ) . '</i>',
					)
				);
			}
			?>

			<?php do_action( 'cartflows_order_bump_tab_content', $options, $post_id ); ?> 
		</div>
		<?php
	}
	/**
	 * Tab custom fields
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function tab_custom_fields( $options, $post_id ) {
		?>
		<div class="wcf-checkout-custom-fields wcf-tab-content widefat">
			<?php
				/* Custom Checkout Fields Section */

			if ( ! _is_cartflows_pro() ) {
				echo wcf()->meta->get_description_field(
					array(
						'name'    => 'wcf-upgrade-to-pro',
						/* translators: %s: link */
						'content' => '<i>' . sprintf( esc_html__( 'Upgrade to %1$sCartFlows Pro%2$s for Custom Fields feature.', 'cartflows' ), '<a href="https://cartflows.com/" target="_blank">', '</a>' ) . '</i>',
					)
				);
			}
			?>
			<?php do_action( 'cartflows_custom_fields_tab_content', $options, $post_id ); ?>
		</div>
		<?php
	}
	/**
	 * Tab custom settings
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function tab_custom_settings( $options, $post_id ) {
		?>
		<div class="wcf-checkout-custom-settings wcf-tab-content widefat">
			<div class="wcf-custom-settings-fields">
			<?php

				echo wcf()->meta->get_text_field(
					array(
						'label' => __( 'Place Order Button Text', 'cartflows' ),
						'name'  => 'wcf-checkout-place-order-button-text',
						'value' => $options['wcf-checkout-place-order-button-text'],
						'attr'  => array(
							'placeholder' => __( 'Place order', 'cartflows' ),
						),
						'help'  => __( 'It will change the Place Order Button text on checkout page.', 'cartflows' ),
					)
				);

				echo wcf()->meta->get_hr_line_field( array() );

				echo wcf()->meta->get_checkbox_field(
					array(
						'name'  => 'wcf-remove-product-field',
						'value' => $options['wcf-remove-product-field'],
						'after' => esc_html__( 'Enable cart editing on checkout', 'cartflows' ),
					)
				);

				echo wcf()->meta->get_description_field(
					array(
						'name'    => '',
						/* translators: %s: link */
						'content' => '<i>' . sprintf( esc_html__( 'Users will able to remove products from the checkout page.', 'cartflows' ), '<a href="https://cartflows.com/" target="_blank">', '</a>' ) . '</i>',
					)
				);

				$this->animate_title_settings( $options, $post_id );
			?>
			</div>
			<?php do_action( 'cartflows_custom_settings_tab_content', $options, $post_id ); ?>
		</div>
		<?php
	}

	/**
	 * Tab style
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function design_tab_style( $options, $post_id ) {
		include CARTFLOWS_LEGACY_ADMIN_DIR . 'modules/checkout/meta-views/design-checkout-style-tab.php';
	}


	/**
	 * Tab Header (Used for add logo into header)
	 *
	 * @param array $options options.
	 * @param int   $post_id post ID.
	 */
	public function tab_header_content( $options, $post_id ) {
		?>

		<div class="wcf-checkout-header wcf-tab-content widefat">
			<?php

				$layout_pro_option = array();

				echo wcf()->meta->get_image_field(
					array(
						'name'  => 'wcf-header-logo-image',
						'value' => $options['wcf-header-logo-image'],
						'label' => esc_html__( 'Header Logo', 'cartflows' ),
					)
				);

				echo wcf()->meta->get_number_field(
					array(
						'name'  => 'wcf-header-logo-width',
						'value' => $options['wcf-header-logo-width'],
						'label' => esc_html__( 'Logo Width (In px)', 'cartflows' ),
					)
				);
			?>
			<?php do_action( 'cartflows_checkout_header_tab_content', $options, $post_id ); ?> 
		</div>
		<?php
	}
	/**
	 * Get metabox options
	 *
	 * @param int $post_id post ID.
	 */
	public static function get_meta_option( $post_id ) {

		if ( null === self::$meta_option ) {

			/**
			 * Set metabox options
			 *
			 * @see http://php.net/manual/en/filter.filters.sanitize.php
			 */
			self::$meta_option = wcf()->options->get_checkout_fields( $post_id );
		}

		return self::$meta_option;
	}

	/**
	 * Metabox Save
	 *
	 * @param  number $post_id Post ID.
	 * @return void
	 */
	public function save_meta_box( $post_id ) {

		// Checks save status.
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );

		$is_valid_nonce = ( isset( $_POST['nonce-checkout-step-meta'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce-checkout-step-meta'] ) ), 'save-nonce-checkout-step-meta' ) ) ? true : false;

		// Exits script depending on save status.
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
		}

		wcf()->options->save_checkout_fields( $post_id );
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Cartflows_Checkout_Meta::get_instance();
