<?php
/**
 * WCFB - Optin Detail Form.
 *
 * @package UAGB
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WCFB_Optin_Form' ) ) {

	/**
	 * Class WCFB_Optin_Form.
	 */
	class WCFB_Optin_Form {

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

			// Activation hook.
			add_action( 'init', array( $this, 'register_blocks' ) );
			add_action( 'init', array( $this, 'dynamic_options_ajax_filters' ), 1 );
		}

		/**
		 * Registers the `core/latest-posts` block on server.
		 *
		 * @since x.x.x
		 */
		public function register_blocks() {

			// Check if the register function exists.
			if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}

			$attr = array(
				'block_id'                         => array(
					'type' => 'string',
				),
				'classMigrate'                     => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'className'                        => array(
					'type' => 'string',
				),
				// General.
				'generalPrimaryColor'              => array(
					'type'    => 'string',
					'default' => '',
				),
				// general font family.
				'generalLoadGoogleFonts'           => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'generalFontFamily'                => array(
					'type' => 'string',
				),
				'generalFontWeight'                => array(
					'type' => 'string',
				),
				'generalFontSubset'                => array(
					'type' => 'string',
				),
				// general font size.
				'generalFontSize'                  => array(
					'type' => 'number',
				),
				'generalFontSizeType'              => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'generalFontSizeTablet'            => array(
					'type' => 'number',
				),
				'generalFontSizeMobile'            => array(
					'type' => 'number',
				),
				// general line height.
				'generalLineHeightType'            => array(
					'type'    => 'string',
					'default' => 'em',
				),
				'generalLineHeight'                => array(
					'type' => 'number',
				),
				'generalLineHeightTablet'          => array(
					'type' => 'number',
				),
				'generalLineHeightMobile'          => array(
					'type' => 'number',
				),
				// Input Fields.
				// input field font family.
				'inputFieldLoadGoogleFonts'        => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'inputFieldFontFamily'             => array(
					'type' => 'string',
				),
				'inputFieldFontWeight'             => array(
					'type' => 'string',
				),
				'inputFieldFontSubset'             => array(
					'type' => 'string',
				),
				// input field font size.
				'inputFieldFontSize'               => array(
					'type' => 'number',
				),
				'inputFieldFontSizeType'           => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'inputFieldFontSizeTablet'         => array(
					'type' => 'number',
				),
				'inputFieldFontSizeMobile'         => array(
					'type' => 'number',
				),
				// input field line height.
				'inputFieldLineHeightType'         => array(
					'type'    => 'string',
					'default' => 'em',
				),
				'inputFieldLineHeight'             => array(
					'type' => 'number',
				),
				'inputFieldLineHeightTablet'       => array(
					'type' => 'number',
				),
				'inputFieldLineHeightMobile'       => array(
					'type' => 'number',
				),
				'inputFieldLabelColor'             => array(
					'type'    => 'string',
					'default' => '',
				),
				'inputFieldBackgroundColor'        => array(
					'type'    => 'string',
					'default' => '',
				),
				'inputFieldTextPlaceholderColor'   => array(
					'type'    => 'string',
					'default' => '',
				),
				// border.
				'inputFieldBorderStyle'            => array(
					'type'    => 'string',
					'default' => '',
				),
				'inputFieldBorderWidth'            => array(
					'type' => 'number',
				),
				'inputFieldBorderRadius'           => array(
					'type' => 'number',
				),
				'inputFieldBorderColor'            => array(
					'type'    => 'string',
					'default' => '',
				),
				// Submit Button.
				// submit button font family.
				'submitButtonText'                 => array(
					'type'    => 'string',
					'default' => '',
				),
				'submitButtonLoadGoogleFonts'      => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'submitButtonFontFamily'           => array(
					'type' => 'string',
				),
				'submitButtonFontWeight'           => array(
					'type' => 'string',
				),
				'submitButtonFontSubset'           => array(
					'type' => 'string',
				),
				// submit button font size.
				'submitButtonFontSize'             => array(
					'type' => 'number',
				),
				'submitButtonFontSizeType'         => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'submitButtonFontSizeTablet'       => array(
					'type' => 'number',
				),
				'submitButtonFontSizeMobile'       => array(
					'type' => 'number',
				),
				// submit button line height.
				'submitButtonLineHeightType'       => array(
					'type'    => 'string',
					'default' => 'em',
				),
				'submitButtonLineHeight'           => array(
					'type' => 'number',
				),
				'submitButtonLineHeightTablet'     => array(
					'type' => 'number',
				),
				'submitButtonLineHeightMobile'     => array(
					'type' => 'number',
				),
				'submitButtonTextColor'            => array(
					'type'    => 'string',
					'default' => '',
				),
				'submitButtonBackgroundColor'      => array(
					'type'    => 'string',
					'default' => '',
				),
				'submitButtonTextHoverColor'       => array(
					'type'    => 'string',
					'default' => '',
				),
				'submitButtonBackgroundHoverColor' => array(
					'type'    => 'string',
					'default' => '',
				),
				// border.
				'submitButtonBorderStyle'          => array(
					'type'    => 'string',
					'default' => '',
				),
				'submitButtonBorderWidth'          => array(
					'type' => 'number',
				),
				'submitButtonBorderRadius'         => array(
					'type' => 'number',
				),
				'submitButtonBorderColor'          => array(
					'type'    => 'string',
					'default' => '',
				),
				'submitButtonBorderHoverColor'     => array(
					'type'    => 'string',
					'default' => '',
				),
				'boxShadowColor'                   => array(
					'type'    => 'string',
					'default' => '',
				),
				'boxShadowHOffset'                 => array(
					'type' => 'number',
				),
				'boxShadowVOffset'                 => array(
					'type' => 'number',
				),
				'boxShadowBlur'                    => array(
					'type' => 'number',
				),
				'boxShadowSpread'                  => array(
					'type' => 'number',
				),
				'boxShadowPosition'                => array(
					'type'    => 'string',
					'default' => 'outset',
				),
			);

			$attributes = apply_filters( 'cartflows_gutenberg_optin_attributes_filters', $attr );

			register_block_type(
				'wcfb/optin-form',
				array(
					'attributes'      => $attributes,
					'render_callback' => array( $this, 'render_html' ),
				)
			);

		}

		/**
		 * Dynamic options ajax filters actions.
		 */
		public function dynamic_options_ajax_filters() {

			add_action(
				'cartflows_woo_checkout_update_order_review_init',
				function( $post_data ) {
					if ( ! empty( $post_data['_wcf_submitButtonText'] ) ) {
						$setting_name = $post_data['_wcf_submitButtonText'];
						add_filter(
							'cartflows_optin_meta_wcf-submit-button-text',
							function ( $value ) use ( $setting_name ) {
								$value = $setting_name;

								return $value;
							},
							99,
							1
						);
					}
				}
			);
		}

		/**
		 * Settings
		 *
		 * @since x.x.x
		 * @var object $settings
		 */
		public static $settings;


		/**
		 * Render Optin Detail Form HTML.
		 *
		 * @param array $attributes Array of block attributes.
		 *
		 * @since x.x.x
		 */
		public function render_html( $attributes ) {

			self::$settings = $attributes;

			$main_classes = array(
				'cf-block-' . $attributes['block_id'],
			);

			if ( isset( $attributes['className'] ) ) {
				$main_classes[] = $attributes['className'];
			}

			$classes = array(
				'wpcf__optin-form',
			);

			do_action( 'cartflows_gutenberg_optin_options_filters', $attributes );

			add_action(
				'woocommerce_after_order_notes',
				function () {

					echo '<input type="hidden" class="input-hidden" name="_wcf_submitButtonText" value="' . esc_attr( self::$settings['submitButtonText'] ) . '">';

				},
				99
			);

			ob_start();

			?>
				<div class = "<?php echo esc_attr( implode( ' ', $main_classes ) ); ?>">
					<div class = "<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
						<?php
						echo do_shortcode( '[cartflows_optin]' );
						?>
					</div>
				</div>
				<?php

				return ob_get_clean();
		}


	}

	/**
	 *  Prepare if class 'WCFB_Optin_Form' exist.
	 *  Kicking this off by calling 'get_instance()' method
	 */
	WCFB_Optin_Form::get_instance();
}
