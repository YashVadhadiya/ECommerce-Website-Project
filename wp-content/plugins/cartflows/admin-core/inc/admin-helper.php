<?php
/**
 * CartFlows Admin Helper.
 *
 * @package CartFlows
 */

namespace CartflowsAdmin\AdminCore\Inc;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class AdminHelper.
 */
class AdminHelper {

	/**
	 * Meta_options.
	 *
	 * @var object instance
	 */
	public static $meta_options = array();
	/**
	 * Common.
	 *
	 * @var object instance
	 */
	public static $common = null;

	/**
	 * Permalink setting.
	 *
	 * @var object instance
	 */
	public static $permalink_setting = null;

	/**
	 * Facebook.
	 *
	 * @var object instance
	 */
	public static $facebook = null;

	/**
	 * Google_analytics_settings.
	 *
	 * @var object instance
	 */
	public static $google_analytics_settings = null;

	/**
	 * Options.
	 *
	 * @var object instance
	 */
	public static $options = null;

	/**
	 * Get flow meta options.
	 *
	 * @param int $post_id post id.
	 * @return array.
	 */
	public static function get_flow_meta_options( $post_id ) {

		if ( ! isset( self::$meta_options[ $post_id ] ) ) {

			/**
			 * Set metabox options
			 */

			$default_meta = wcf()->options->get_flow_fields( $post_id );
			$stored_meta  = get_post_meta( $post_id );

			/**
			 * Get options
			 */
			self::$meta_options[ $post_id ] = self::get_prepared_meta_options( $default_meta, $stored_meta );
		}

		return self::$meta_options[ $post_id ];
	}

	/**
	 * Get step meta options.
	 *
	 * @param int $step_id step id.
	 * @return array.
	 */
	public static function get_step_meta_options( $step_id ) {

		if ( ! isset( self::$meta_options[ $step_id ] ) ) {

			$step_type   = wcf_get_step_type( $step_id );
			$step_fields = array();
			$step_tabs   = array();

			$default_meta = self::get_step_default_meta( $step_type, $step_id );

			$stored_meta = get_post_meta( $step_id );

			$prepared_options = self::get_prepared_meta_options( $default_meta, $stored_meta );

			$prepared_options = apply_filters( 'cartflows_' . $step_type . '_step_meta_fields', $prepared_options, $step_id );

			$step_tabs = apply_filters( 'cartflows_' . $step_type . '_step_tabs', $step_tabs );

			/**
			 * Get options
			 */
			self::$meta_options[ $step_id ]['type']    = $step_type;
			self::$meta_options[ $step_id ]['tabs']    = $step_tabs;
			self::$meta_options[ $step_id ]['options'] = $prepared_options;
		}

		return self::$meta_options[ $step_id ];
	}

	/**
	 * Merge default and saved meta options.
	 *
	 * @param array $default_meta Default meta.
	 * @param array $stored_meta Saved meta.
	 * @return array.
	 */
	public static function get_prepared_meta_options( $default_meta, $stored_meta ) {

		$meta_options = array();

		// Set stored and override defaults.
		foreach ( $default_meta as $key => $value ) {

			$meta_options[ $key ] = ( isset( $stored_meta[ $key ][0] ) ) ? maybe_unserialize( $stored_meta[ $key ][0] ) : $default_meta[ $key ]['default'];
		}

		return $meta_options;
	}

	/**
	 * Get Common settings.
	 *
	 * @return array.
	 */
	public static function get_common_settings() {

		$options = array();

		$common_default = apply_filters(
			'cartflows_common_settings_default',
			array(
				'disallow_indexing'    => 'disable',
				'global_checkout'      => '',
				'default_page_builder' => 'elementor',
			)
		);

		$common = self::get_admin_settings_option( '_cartflows_common', false, false );

		$common = wp_parse_args( $common, $common_default );

		foreach ( $common as $key => $data ) {
			$options[ '_cartflows_common[' . $key . ']' ] = $data;
		}

		return $options;
	}

	/**
	 * Get admin settings.
	 *
	 * @param string $key key.
	 * @param bool   $default key.
	 * @param bool   $network_override key.
	 *
	 * @return array.
	 */
	public static function get_admin_settings_option( $key, $default = false, $network_override = false ) {

		// Get the site-wide option if we're in the network admin.
		if ( $network_override && is_multisite() ) {
			$value = get_site_option( $key, $default );
		} else {
			$value = get_option( $key, $default );
		}

		return $value;
	}

	/**
	 * Get Common settings.
	 *
	 * @return array.
	 */
	public static function get_permalink_settings() {

		$options = array();

		$permalink_default = apply_filters(
			'cartflows_permalink_settings_default',
			array(
				'permalink'           => CARTFLOWS_STEP_POST_TYPE,
				'permalink_flow_base' => CARTFLOWS_FLOW_POST_TYPE,
				'permalink_structure' => '',

			)
		);

		$permalink_data = self::get_admin_settings_option( '_cartflows_permalink', false, false );

		$permalink_data = wp_parse_args( $permalink_data, $permalink_default );

		foreach ( $permalink_data as $key => $data ) {
			$options[ '_cartflows_permalink[' . $key . ']' ] = $data;
		}

		return $options;
	}

	/**
	 * Get Common settings.
	 *
	 * @return array.
	 */
	public static function get_facebook_settings() {

		$options = array();

		$facebook_default = array(
			'facebook_pixel_id'                => '',
			'facebook_pixel_add_to_cart'       => 'enable',
			'facebook_pixel_initiate_checkout' => 'enable',
			'facebook_pixel_add_payment_info'  => 'enable',
			'facebook_pixel_purchase_complete' => 'enable',
			'facebook_pixel_tracking'          => 'disable',
			'facebook_pixel_tracking_for_site' => 'disable',
		);

		$facebook = self::get_admin_settings_option( '_cartflows_facebook', false, false );

		$facebook = wp_parse_args( $facebook, $facebook_default );

		$facebook = apply_filters( 'cartflows_facebook_settings_default', $facebook );

		foreach ( $facebook as $key => $data ) {
			$options[ '_cartflows_facebook[' . $key . ']' ] = $data;
		}

		return $options;
	}

	/**
	 * Get Common settings.
	 *
	 * @return array.
	 */
	public static function get_google_analytics_settings() {

		$options = array();

		$google_analytics_settings_default = apply_filters(
			'cartflows_google_analytics_settings_default',
			array(
				'enable_google_analytics'          => 'disable',
				'enable_google_analytics_for_site' => 'disable',
				'google_analytics_id'              => '',
				'enable_begin_checkout'            => 'disable',
				'enable_add_to_cart'               => 'disable',
				'enable_add_payment_info'          => 'disable',
				'enable_purchase_event'            => 'disable',
			)
		);

		$google_analytics_settings_data = self::get_admin_settings_option( '_cartflows_google_analytics', false, true );

		$google_analytics_settings_data = wp_parse_args( $google_analytics_settings_data, $google_analytics_settings_default );

		foreach ( $google_analytics_settings_data as $key => $data ) {
			$options[ '_cartflows_google_analytics[' . $key . ']' ] = $data;
		}

		return $options;
	}

	/**
	 * Checkout Selection Field
	 *
	 * @return string
	 */
	public static function flow_checkout_selection_field() {

		$checkout_steps = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type'      => CARTFLOWS_STEP_POST_TYPE,
				'post_status'    => 'publish',
				'orderby'        => 'ID',
				'order'          => 'ASC',
				'tax_query'      => array( //phpcs:ignore
					array(
						'taxonomy' => CARTFLOWS_TAXONOMY_STEP_TYPE,
						'field'    => 'slug',
						'terms'    => 'checkout',
					),
				),
				'meta_query'     => array( //phpcs:ignore
					array(
						'key'     => 'wcf-control-step',
						'compare' => 'NOT EXISTS',
					),
				),
			)
		);

		$checkout_steps_list = array(
			array(
				'value' => '',
				'label' => __( 'Select', 'cartflows' ),
			),
		);
		foreach ( $checkout_steps as $index => $step_data ) {

			array_push(
				$checkout_steps_list,
				array(
					'value' => $step_data->ID,
					'label' => $step_data->post_title . ' ( # ' . $step_data->ID . ' ) ',

				)
			);
		}

		return $checkout_steps_list;
	}



	/**
	 * Clear Page Builder Cache
	 */
	public static function clear_cache() {

		// Clear 'Elementor' file cache.
		if ( class_exists( '\Elementor\Plugin' ) ) {
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		}
	}

	/**
	 * Get Flows count.
	 */
	public static function get_flows_count() {

		$flow_posts = get_posts(
			array(
				'posts_per_page' => 4,
				'post_type'      => CARTFLOWS_FLOW_POST_TYPE,
				'post_status'    => array( 'publish', 'pending', 'draft', 'future', 'private' ),
			)
		);

		return count( $flow_posts );
	}

	/**
	 * Font family field.
	 *
	 * @return array field.
	 */
	public static function get_font_family() {

		$font_family[0] = array(
			'value' => '',
			'label' => __( 'Default', 'cartflows' ),
		);

		$system_font_family = array();
		$google_font_family = array();

		foreach ( \CartFlows_Font_Families::get_system_fonts() as $name => $variants ) {
			array_push(
				$system_font_family,
				array(
					'value' => $name,
					'label' => esc_attr( $name ),
				)
			);
		}

		$font_family[1] = array(
			'label'   => __( 'System Fonts', 'cartflows' ),
			'options' => $system_font_family,
		);

		foreach ( \CartFlows_Font_Families::get_google_fonts() as $name => $single_font ) {
			$variants   = wcf_get_prop( $single_font, 'variants' );
			$category   = wcf_get_prop( $single_font, 'category' );
			$font_value = '\'' . esc_attr( $name ) . '\', ' . esc_attr( $category );
			array_push(
				$google_font_family,
				array(
					'value' => $font_value,
					'label' => esc_attr( $name ),
				)
			);
		}

		$font_family[2] = array(
			'label'   => __( 'Google Fonts', 'cartflows' ),
			'options' => $google_font_family,
		);

		return $font_family;
	}

	/**
	 * Get step default meta.
	 *
	 * @param string $step_type type.
	 * @param int    $step_id id.
	 */
	public static function get_step_default_meta( $step_type, $step_id ) {

		$step_default_fields = array();

		switch ( $step_type ) {
			case 'landing':
				$step_default_fields = wcf()->options->get_landing_fields( $step_id );
				break;

			case 'checkout':
				$step_default_fields = wcf()->options->get_checkout_fields( $step_id );
				break;

			case 'thankyou':
				$step_default_fields = wcf()->options->get_thankyou_fields( $step_id );
				break;

			case 'optin':
				$step_default_fields = wcf()->options->get_optin_fields( $step_id );
				break;

			default:
				break;
		}
		$step_default_fields = apply_filters( 'cartflows_' . $step_type . '_step_default_meta_fields', $step_default_fields, $step_id );
		return $step_default_fields;
	}

	/**
	 * Get options.
	 */
	public static function get_options() {

		$general_settings   = self::get_common_settings();
		$permalink_settings = self::get_permalink_settings();
		$fb_settings        = self::get_facebook_settings();
		$ga_settings        = self::get_google_analytics_settings();

		$options = array_merge( $general_settings, $permalink_settings, $fb_settings, $ga_settings );

		$options = apply_filters( 'cartflows_global_data_options', $options );

		return $options;
	}

		/**
		 * Get product price.
		 *
		 * @param object $product product data.
		 */
	public static function get_product_original_price( $product ) {

		$custom_price = '';
		$product_id   = 0;

		if ( $product->is_type( 'variable' ) ) {

			$default_attributes = $product->get_default_attributes();

			if ( ! empty( $default_attributes ) ) {

				foreach ( $product->get_children() as $c_in => $variation_id ) {

					if ( 0 === $c_in ) {
						$product_id = $variation_id;
					}

					$single_variation = new \WC_Product_Variation( $variation_id );

					if ( $default_attributes == $single_variation->get_attributes() ) {

						$product_id = $variation_id;
						break;
					}
				}
			} else {

				$product_childrens = $product->get_children();

				if ( is_array( $product_childrens ) && ! empty( $product_childrens ) ) {

					foreach ( $product_childrens  as $c_in => $c_id ) {

						$product_id = $c_id;
						break;
					}
				} else {

					// Return if no childrens found.
					return;
				}
			}

			$product = wc_get_product( $product_id );
		}

		if ( $product ) {
			$custom_price = $product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price();
		}

		return $custom_price;
	}

	/**
	 * Prepare step data.
	 *
	 * @param  int   $flow_id Flow id.
	 * @param  array $meta_options Meta data.
	 *
	 * @return array
	 */
	public static function prepare_step_data( $flow_id, $meta_options ) {

		$steps = $meta_options['wcf-steps'];

		if ( is_array( $steps ) && ! empty( $steps ) ) {

			$is_checkout = 0;
			$step_length = count( $steps );

			foreach ( $steps as $in => $step ) {
				$step_id                             = $step['id'];
				$steps[ $in ]['title']               = get_the_title( $step_id );
				$steps[ $in ]['is_product_assigned'] = \Cartflows_Helper::has_product_assigned( $step_id );

				$steps[ $in ]['actions']      = self::get_step_actions( $flow_id, $step_id );
				$steps[ $in ]['menu_actions'] = self::get_step_actions( $flow_id, $step_id, 'menu' );

				$steps[ $in ]['menu_actions'] = self::get_step_actions( $flow_id, $step_id, 'menu' );

				if ( 'checkout' === $step['type'] ) {
					$is_checkout++;
				}

				if ( _is_cartflows_pro() && in_array( $step['type'], array( 'upsell', 'downsell' ), true ) ) {

					$is_thankyou = 0;

					// Check if next remaining steps has thank you page.
					for ( $i = $in; $i < $step_length; $i++ ) {
						if ( 'thankyou' === $steps[ $i ]['type'] ) {
							$is_thankyou++;
						}
					}

					if ( $is_checkout > 0 && $is_thankyou > 0 ) {

						$wcf_step_obj = wcf_pro_get_step( $step_id );
						$flow_steps   = $wcf_step_obj->get_flow_steps();
						$control_step = $wcf_step_obj->get_control_step();
						if ( 'upsell' === $step['type'] ) {
							$next_yes_steps = wcf_pro()->flow->get_next_step_id_for_upsell_accepted( $wcf_step_obj, $flow_steps, $step_id, $control_step );
							$next_no_steps  = wcf_pro()->flow->get_next_step_id_for_upsell_rejected( $wcf_step_obj, $flow_steps, $step_id, $control_step );
						}

						if ( 'downsell' === $step['type'] ) {
							$next_yes_steps = wcf_pro()->flow->get_next_step_id_for_downsell_accepted( $wcf_step_obj, $flow_steps, $step_id, $control_step );
							$next_no_steps  = wcf_pro()->flow->get_next_step_id_for_downsell_rejected( $wcf_step_obj, $flow_steps, $step_id, $control_step );
						}

						if ( ! empty( $next_yes_steps ) && false !== get_post_status( $next_yes_steps ) ) {

							$yes_label = __( 'YES : ', 'cartflows' ) . get_the_title( $next_yes_steps );
						} else {
							$yes_label = __( 'YES : Step not Found', 'cartflows' );
						}

						if ( ! empty( $next_no_steps ) && false !== get_post_status( $next_no_steps ) ) {

							$no_label = __( 'No : ', 'cartflows' ) . get_the_title( $next_no_steps );
						} else {
							$no_label = __( 'No : Step not Found', 'cartflows' );
						}

						$steps[ $in ]['offer_yes_next_step'] = $yes_label;
						$steps[ $in ]['offer_no_next_step']  = $no_label;
					}
				}

				/* Add variation data */
				if ( ! empty( $steps[ $in ]['ab-test-variations'] ) ) {

					$ab_test_variations = $steps[ $in ]['ab-test-variations'];

					foreach ( $ab_test_variations as $variation_in => $variation ) {

						$ab_test_variations[ $variation_in ]['title']               = get_the_title( $variation['id'] );
						$ab_test_variations[ $variation_in ]['actions']             = self::get_ab_test_step_actions( $flow_id, $variation['id'] );
						$ab_test_variations[ $variation_in ]['menu_actions']        = self::get_ab_test_step_actions( $flow_id, $variation['id'], 'menu' );
						$ab_test_variations[ $variation_in ]['is_product_assigned'] = \Cartflows_Helper::has_product_assigned( $variation['id'] );
					}

					$steps[ $in ]['ab-test-variations'] = $ab_test_variations;
				}

				if ( ! empty( $steps[ $in ]['ab-test-archived-variations'] ) ) {

					$ab_test_archived_variations = $steps[ $in ]['ab-test-archived-variations'];

					foreach ( $ab_test_archived_variations as $variation_in => $variation ) {

						$ab_test_archived_variations[ $variation_in ]['actions'] = self::get_ab_test_step_archived_actions( $flow_id, $variation['id'], $variation['deleted'] );
						$ab_test_archived_variations[ $variation_in ]['hide']    = get_post_meta( $variation['id'], 'wcf-hide-step', true );
					}

					$steps[ $in ]['ab-test-archived-variations'] = $ab_test_archived_variations;
				}
			}
		}

		return $steps;

	}

		/**
		 * Get step actions.
		 *
		 * @param  int    $flow_id Flow id.
		 * @param  int    $step_id Step id.
		 * @param  string $type type.
		 *
		 * @return array
		 */
	public static function get_step_actions( $flow_id, $step_id, $type = 'inline' ) {

		if ( 'menu' === $type ) {
			$actions = array(
				'clone'  => array(
					'slug'       => 'clone',
					'class'      => 'wcf-step-clone',
					'icon_class' => 'dashicons dashicons-admin-page',
					'text'       => __( 'Clone', 'cartflows' ),
					'pro'        => true,
					'link'       => '#',
					'ajaxcall'   => 'cartflows_clone_step',
				),
				'delete' => array(
					'slug'       => 'delete',
					'class'      => 'wcf-step-delete',
					'icon_class' => 'dashicons dashicons-trash',
					'text'       => __( 'Delete', 'cartflows' ),
					'link'       => '#',
					'ajaxcall'   => 'cartflows_delete_step',
				),
				'abtest' => array(
					'slug'       => 'abtest',
					'class'      => 'wcf-step-abtest',
					'icon_class' => 'dashicons dashicons-forms',
					'text'       => __( 'A/B Test', 'cartflows' ),
					'pro'        => true,
					'link'       => '#',
				),

				/*
				Action.
					// 'export' => array(
					// 'slug'       => 'export',
					// 'class'      => 'wcf-step-export',
					// 'icon_class' => 'dashicons dashicons-database-export',
					// 'text'       => __( 'Export', 'cartflows' ),
					// 'link'       => '#',
					// 'pro'        => true,
					// ),
				*/
			);
		} else {
			$actions = array(
				'view' => array(
					'slug'       => 'view',
					'class'      => 'wcf-step-view',
					'icon_class' => 'dashicons dashicons-visibility',
					'target'     => 'blank',
					'text'       => __( 'View', 'cartflows' ),
					'link'       => get_permalink( $step_id ),
				),
				'edit' => array(
					'slug'       => 'edit',
					'class'      => 'wcf-step-edit',
					'icon_class' => 'dashicons dashicons-edit',
					'text'       => __( 'Edit', 'cartflows' ),
					'link'       => admin_url( 'admin.php?page=cartflows&action=wcf-edit-step&step_id=' . $step_id . '&flow_id=' . $flow_id ),
				),
			);
		}
		return $actions;
	}

	/**
	 * Get step actions.
	 *
	 * @param  int    $flow_id Flow id.
	 * @param  int    $step_id Step id.
	 * @param  string $type type.
	 *
	 * @return array
	 */
	public static function get_ab_test_step_actions( $flow_id, $step_id, $type = 'inline' ) {

		if ( 'menu' === $type ) {

			$actions = array(
				'clone'    => array(
					'slug'       => 'clone',
					'class'      => 'wcf-ab-test-step-clone',
					'icon_class' => 'dashicons dashicons-admin-page',
					'text'       => __( 'Clone', 'cartflows' ),
					'link'       => '#',
					'pro'        => true,
					'ajaxcall'   => 'cartflows_clone_ab_test_step',
				),
				'delete'   => array(
					'slug'       => 'delete',
					'class'      => 'wcf-ab-test-step-delete',
					'icon_class' => 'dashicons dashicons-trash',
					'text'       => __( 'Delete', 'cartflows' ),
					'link'       => '#',
					'ajaxcall'   => 'cartflows_delete_ab_test_step',
				),
				'archived' => array(
					'slug'       => 'archived',
					'class'      => 'wcf-ab-test-step-archived',
					'icon_class' => 'dashicons dashicons-archive',
					'text'       => __( 'Archived', 'cartflows' ),
					'link'       => '#',
				),
				'winner'   => array(
					'slug'       => 'winner',
					'class'      => 'wcf-declare-winner',
					'icon_class' => 'dashicons dashicons-yes-alt',
					'text'       => __( 'Declare as Winner', 'cartflows' ),
					'link'       => '#',
				),
			);

		} else {

			$actions = array(
				'view' => array(
					'slug'       => 'view',
					'class'      => 'wcf-step-view',
					'icon_class' => 'dashicons dashicons-visibility',
					'target'     => 'blank',
					'text'       => __( 'View', 'cartflows' ),
					'link'       => get_permalink( $step_id ),
				),
				'edit' => array(
					'slug'       => 'edit',
					'class'      => 'wcf-step-edit',
					'icon_class' => 'dashicons dashicons-edit',
					'text'       => __( 'Edit', 'cartflows' ),
					'link'       => admin_url( 'admin.php?page=cartflows&action=wcf-edit-step&step_id=' . $step_id . '&flow_id=' . $flow_id ),
				),
			);
		}

		return $actions;
	}

	/**
	 * Get ab test step action.
	 *
	 * @param  int  $flow_id Flow id.
	 * @param  int  $step_id Step id.
	 * @param  bool $deleted Step deleted or archived.
	 * @return array
	 */
	public static function get_ab_test_step_archived_actions( $flow_id, $step_id, $deleted ) {

		if ( $deleted ) {
			$actions = array(
				'archive-hide' => array(
					'slug'        => 'hide',
					'class'       => 'wcf-step-archive-hide',
					'icon_class'  => 'dashicons dashicons-hidden',
					'target'      => 'blank',
					'before_text' => __( 'Deleted variation can\'t be restored.', 'cartflows' ),
					'text'        => __( 'Hide', 'cartflows' ),
					'link'        => '#',
				),
			);
		} else {

			$actions = array(
				'archive-restore' => array(
					'slug'       => 'restore',
					'class'      => 'wcf-step-archive-restore',
					'icon_class' => 'dashicons dashicons-open-folder',
					'target'     => 'blank',
					'text'       => __( 'Restore', 'cartflows' ),
					'link'       => '#',
				),
				'archive-delete'  => array(
					'slug'       => 'delete',
					'class'      => 'wcf-step-archive-delete',
					'icon_class' => 'dashicons dashicons-trash',
					'target'     => 'blank',
					'text'       => __( 'Delete', 'cartflows' ),
					'link'       => '#',
				),
			);
		}

		return $actions;
	}
}

