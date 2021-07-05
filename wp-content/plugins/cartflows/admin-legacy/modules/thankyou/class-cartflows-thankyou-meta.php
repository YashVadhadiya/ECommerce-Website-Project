<?php
/**
 * Checkout post meta box
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
class Cartflows_Thankyou_Meta extends Cartflows_Meta {

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

		if ( _is_wcf_thankyou_type() ) {

			$stored_meta = get_post_meta( $post->ID );
			$thank_meta  = self::get_meta_option( $post->ID );

			// Set stored and override defaults.
			foreach ( $stored_meta as $key => $value ) {
				if ( array_key_exists( $key, $thank_meta ) ) {
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
				'wcf-thankyou-settings',                // Id.
				__( 'Thank You Settings', 'cartflows' ), // Title.
				array( $this, 'settings_markup_meta_box' ),      // Callback.
				$post_type,                 // Post_type.
				'normal',                               // Context.
				'high'                                  // Priority.
			);

			add_meta_box(
				'wcf-thankyou-design-settings',                // Id.
				__( 'Thank You Design', 'cartflows' ), // Title.
				array( $this, 'design_markup_meta_box' ),      // Callback.
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
	public function settings_markup_meta_box( $post ) {

		wp_nonce_field( 'save-nonce-thankyou-step-meta', 'nonce-thankyou-step-meta' );

		do_action( 'wcf_thankyou_settings_markup_before' );
		$this->settings_tabs( self::$meta_option_data, $post->ID );
		do_action( 'wcf_thankyou_settings_markup_after' );
	}

	/**
	 * Page Header Tabs
	 *
	 * @param  array $options Post meta.
	 * @param  int   $post_id Post ID.
	 */
	public function settings_tabs( $options, $post_id ) {

		$active_tab = 'wcf-thankyou-redirect';

		$tabs = array(
			array(
				'title' => __( 'Settings', 'cartflows' ),
				'id'    => 'wcf-thankyou-redirect',
				'class' => 'wcf-thankyou-redirect' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-randomize',
			),
			array(
				'title' => __( 'Custom Script', 'cartflows' ),
				'id'    => 'wcf-thankyou-custom-script-header',
				'class' => 'wcf-thankyou-custom-script-header' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-format-aside',
			),
		);

		?>
		<div class="wcf-thankyou-table wcf-metabox-wrap widefat">
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
					<div class="wcf-thankyou-redirect wcf-tab-content widefat" >
					<?php
						echo wcf()->meta->get_text_field(
							array(
								'label' => __( 'Thank You Page Text', 'cartflows' ),
								'name'  => 'wcf-tq-text',
								'value' => $options['wcf-tq-text'],
								'attr'  => array(
									'placeholder' => __( 'Thank you. Your order has been received.', 'cartflows' ),
								),
								'help'  => __( 'It will change the default text on thank you page.', 'cartflows' ),
							)
						);

						echo wcf()->meta->get_hr_line_field( array() );

						echo wcf()->meta->get_checkbox_field(
							array(
								'label' => __( 'Redirect After Purchase', 'cartflows' ),
								'name'  => 'wcf-show-tq-redirect-section',
								'value' => $options['wcf-show-tq-redirect-section'],
								'after' => 'Enable',
							)
						);

						echo wcf()->meta->get_text_field(
							array(
								'label' => __( 'Redirect Link', 'cartflows' ),
								'name'  => 'wcf-tq-redirect-link',
								'value' => $options['wcf-tq-redirect-link'],
								'attr'  => array(
									'placeholder' => __( 'https://', 'cartflows' ),
								),
							)
						);

					?>
					</div>

					<?php $this->tab_custom_script( $options, $post_id ); ?>

					<?php $this->right_column_footer( $options, $post_id ); ?>
				</div>
			</div>
		</div>

		<?php
	}

	/**
	 * Metabox Markup
	 *
	 * @param  object $post Post object.
	 * @return void
	 */
	public function design_markup_meta_box( $post ) {

		wp_nonce_field( 'save-nonce-thankyou-step-meta', 'nonce-thankyou-step-meta' );

		do_action( 'wcf_thankyou_design_settings_markup_before' );
		$this->design_settings_tabs( self::$meta_option_data, $post->ID );
		do_action( 'wcf_thankyou_design_settings_markup_after' );
	}

	/**
	 * Page Header Tabs
	 *
	 * @param  array $options Post meta.
	 * @param  int   $post_id Post ID.
	 */
	public function design_settings_tabs( $options, $post_id ) {

		$active_tab = 'wcf-thankyou-design';

		$tabs = array(
			array(
				'title' => __( 'Shortcodes', 'cartflows' ),
				'id'    => 'wcf-thankyou-shortcodes',
				'class' => 'wcf-thankyou-shortcodes' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-editor-code',
			),
			array(
				'title' => __( 'Design', 'cartflows' ),
				'id'    => 'wcf-thankyou-design',
				'class' => 'wcf-thankyou-design' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-admin-customizer',
			),
			array(
				'title' => __( 'Edit Fields', 'cartflows' ),
				'id'    => 'wcf-thankyou-fields',
				'class' => 'wcf-thankyou-fields' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
				'icon'  => 'dashicons-welcome-widgets-menus',
			),
		);

		?>
		<div class="wcf-thankyou-design-table wcf-metabox-wrap widefat">
			<div class="wcf-table-container">
				<?php echo wcf_get_page_builder_notice(); ?>
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
					<div class="wcf-thankyou-shortcodes wcf-tab-content active widefat">
						<?php

						echo wcf()->meta->get_shortcode_field(
							array(
								'label'   => __( 'Order Details', 'cartflows' ),
								'name'    => 'wcf-order-details',
								'content' => esc_html( '[cartflows_order_details]' ),
							)
						);
						?>
					</div>
					<div class="wcf-thankyou-design wcf-tab-content widefat">
						<?php

							echo wcf()->meta->get_section(
								array(
									'label' => __( 'Text', 'cartflows' ),
								)
							);

							echo wcf()->meta->get_color_picker_field(
								array(
									'label' => __( 'Color', 'cartflows' ),
									'name'  => 'wcf-tq-text-color',
									'value' => $options['wcf-tq-text-color'],
								)
							);

							echo wcf()->meta->get_font_family_field(
								array(
									'for'   => 'wcf-tq-font-family',
									'label' => esc_html__( 'Font Family', 'cartflows' ),
									'name'  => 'wcf-tq-font-family',
									'value' => $options['wcf-tq-font-family'],
								)
							);

							echo wcf()->meta->get_number_field(
								array(
									'label' => __( 'Font Size', 'cartflows' ),
									'name'  => 'wcf-tq-font-size',
									'value' => $options['wcf-tq-font-size'],
								)
							);

							echo wcf()->meta->get_section(
								array(
									'label' => __( 'Heading', 'cartflows' ),
								)
							);

							echo wcf()->meta->get_color_picker_field(
								array(
									'label' => __( 'Color', 'cartflows' ),
									'name'  => 'wcf-tq-heading-color',
									'value' => $options['wcf-tq-heading-color'],
								)
							);

							echo wcf()->meta->get_font_family_field(
								array(
									'for'   => 'wcf-tq-heading-font-family',
									'label' => esc_html__( 'Font Family', 'cartflows' ),
									'name'  => 'wcf-tq-heading-font-family',
									'value' => $options['wcf-tq-heading-font-family'],
								)
							);

							echo wcf()->meta->get_font_weight_field(
								array(
									'for'   => 'wcf-tq-heading-font-family',
									'label' => esc_html__( 'Font Weight', 'cartflows' ),
									'name'  => 'wcf-tq-heading-font-wt',
									'value' => $options['wcf-tq-heading-font-wt'],
								)
							);

							echo wcf()->meta->get_checkbox_field(
								array(
									'label' => __( 'Advanced Options', 'cartflows' ),
									'name'  => 'wcf-tq-advance-options-fields',
									'value' => $options['wcf-tq-advance-options-fields'],
									'after' => 'Enable',
								)
							);

							echo wcf()->meta->get_number_field(
								array(
									'for'   => 'wcf-heading',
									'label' => esc_html__( 'Container Width (In px)', 'cartflows' ),
									'name'  => 'wcf-tq-container-width',
									'value' => $options['wcf-tq-container-width'],
								)
							);

							echo wcf()->meta->get_color_picker_field(
								array(
									'label' => __( 'Section Background Color', 'cartflows' ),
									'name'  => 'wcf-tq-section-bg-color',
									'value' => $options['wcf-tq-section-bg-color'],
								)
							);

						?>
					</div>
					<div class="wcf-thankyou-fields wcf-tab-content widefat">
						<?php
						echo wcf()->meta->get_checkbox_field(
							array(
								'name'  => 'wcf-show-overview-section',
								'value' => $options['wcf-show-overview-section'],
								'after' => esc_html__( 'Enable Order Overview ', 'cartflows' ),
							)
						);

						echo wcf()->meta->get_checkbox_field(
							array(
								'name'  => 'wcf-show-details-section',
								'value' => $options['wcf-show-details-section'],
								'after' => esc_html__( 'Enable Order Details ', 'cartflows' ),
							)
						);

						echo wcf()->meta->get_checkbox_field(
							array(
								'name'  => 'wcf-show-billing-section',
								'value' => $options['wcf-show-billing-section'],
								'after' => esc_html__( 'Enable Billing Details ', 'cartflows' ),
							)
						);

						echo wcf()->meta->get_checkbox_field(
							array(
								'name'  => 'wcf-show-shipping-section',
								'value' => $options['wcf-show-shipping-section'],
								'after' => esc_html__( 'Enable Shipping Details ', 'cartflows' ),
							)
						);

						echo wcf()->meta->get_hidden_field(
							array(
								'name'  => 'wcf-field-google-font-url',
								'value' => $options['wcf-field-google-font-url'],
							)
						);
						?>
					</div>
					<?php $this->right_column_footer( $options, $post_id ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Get metabox options
	 *
	 * @param int $post_id post ID.
	 * @return array
	 */
	public static function get_meta_option( $post_id ) {

		if ( null === self::$meta_option ) {

			/**
			 * Set metabox options
			 *
			 * @see http://php.net/manual/en/filter.filters.sanitize.php
			 */
			self::$meta_option = wcf()->options->get_thankyou_fields( $post_id );
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

		$is_valid_nonce = ( isset( $_POST['nonce-thankyou-step-meta'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce-thankyou-step-meta'] ) ), 'save-nonce-thankyou-step-meta' ) ) ? true : false;

		// Exits script depending on save status.
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
		}

		wcf()->options->save_thankyou_fields( $post_id );
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Cartflows_Thankyou_Meta::get_instance();
