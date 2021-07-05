<?php
/**
 * WCFB - Checkout Form Styler.
 *
 * @package WCFB
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WCFB_Checkout_Form' ) ) {

	/**
	 * Class WCFB_Checkout_Form.
	 */
	class WCFB_Checkout_Form {

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
		}

		/**
		 * Registers the `core/latest-posts` block on server.
		 *
		 * @since 0.0.1
		 */
		public function register_blocks() {

			// Check if the register function exists.
			if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}

			$attr = array(
				'block_id'                => array(
					'type'    => 'string',
					'default' => '',
				),
				'className'               => array(
					'type' => 'string',
				),
				'boxShadowColor'          => array(
					'type'    => 'string',
					'default' => '',
				),
				'boxShadowHOffset'        => array(
					'type'    => 'number',
					'default' => 0,
				),
				'boxShadowVOffset'        => array(
					'type'    => 'number',
					'default' => 0,
				),
				'boxShadowBlur'           => array(
					'type'    => 'number',
					'default' => 0,
				),
				'boxShadowSpread'         => array(
					'type'    => 'number',
					'default' => 0,
				),
				'boxShadowPosition'       => array(
					'type'    => 'string',
					'default' => 'outset',
				),
				'isHtml'                  => array(
					'type' => 'boolean',
				),
				'showprecheckoutoffer'    => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'formJson'                => array(
					'type'    => 'object',
					'default' => null,
				),
				'fieldVrPadding'          => array(
					'type'    => 'number',
					'default' => 10,
				),
				'fieldHrPadding'          => array(
					'type'    => 'number',
					'default' => 10,
				),
				'headBgColor'             => array(
					'type'    => 'string',
					'default' => '',
				),
				'fieldBgColor'            => array(
					'type'    => 'string',
					'default' => '',
				),
				'fieldLabelColor'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'fieldInputColor'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'fieldBorderStyle'        => array(
					'type'    => 'string',
					'default' => '',
				),
				'fieldBorderWidth'        => array(
					'type'    => 'number',
					'default' => '',
				),
				'fieldBorderRadius'       => array(
					'type'    => 'number',
					'default' => '',
				),
				'fieldBorderColor'        => array(
					'type'    => 'string',
					'default' => '',
				),
				'fieldBorderFocusColor'   => array(
					'type'    => 'string',
					'default' => '',
				),
				'buttonAlignment'         => array(
					'type'    => 'string',
					'default' => 'left',
				),
				'buttonVrPadding'         => array(
					'type'    => 'number',
					'default' => 10,
				),
				'buttonHrPadding'         => array(
					'type'    => 'number',
					'default' => 25,
				),
				'buttonBorderStyle'       => array(
					'type'    => 'string',
					'default' => '',
				),
				'buttonBorderWidth'       => array(
					'type'    => 'number',
					'default' => 1,
				),
				'buttonBorderRadius'      => array(
					'type'    => 'number',
					'default' => 0,
				),
				'buttonBorderColor'       => array(
					'type'    => 'string',
					'default' => '',
				),
				'buttonTextColor'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'buttonBgColor'           => array(
					'type'    => 'string',
					'default' => '',
				),
				'buttonBorderHoverColor'  => array(
					'type'    => 'string',
					'default' => '',
				),
				'buttonTextHoverColor'    => array(
					'type'    => 'string',
					'default' => '',
				),
				'buttonBgHoverColor'      => array(
					'type'    => 'string',
					'default' => '',
				),
				'fieldSpacing'            => array(
					'type'    => 'number',
					'default' => '',
				),
				'fieldLabelSpacing'       => array(
					'type'    => 'number',
					'default' => '',
				),
				'inputFontSize'           => array(
					'type'    => 'number',
					'default' => '',
				),
				'inputFontSizeType'       => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'inputFontSizeTablet'     => array(
					'type' => 'number',
				),
				'inputFontSizeMobile'     => array(
					'type' => 'number',
				),
				'inputFontFamily'         => array(
					'type'    => 'string',
					'default' => 'Default',
				),
				'inputFontWeight'         => array(
					'type' => 'string',
				),
				'inputFontSubset'         => array(
					'type' => 'string',
				),
				'inputLineHeightType'     => array(
					'type'    => 'string',
					'default' => 'em',
				),
				'inputLineHeight'         => array(
					'type' => 'number',
				),
				'inputLineHeightTablet'   => array(
					'type' => 'number',
				),
				'inputLineHeightMobile'   => array(
					'type' => 'number',
				),
				'inputLoadGoogleFonts'    => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'buttonFontSize'          => array(
					'type'    => 'number',
					'default' => '',
				),
				'buttonFontSizeType'      => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'buttonFontSizeTablet'    => array(
					'type' => 'number',
				),
				'buttonFontSizeMobile'    => array(
					'type' => 'number',
				),
				'buttonFontFamily'        => array(
					'type'    => 'string',
					'default' => 'Default',
				),
				'buttonFontWeight'        => array(
					'type' => 'string',
				),
				'buttonFontSubset'        => array(
					'type' => 'string',
				),
				'buttonLineHeightType'    => array(
					'type'    => 'string',
					'default' => 'em',
				),
				'buttonLineHeight'        => array(
					'type' => 'number',
				),
				'buttonLineHeightTablet'  => array(
					'type' => 'number',
				),
				'buttonLineHeightMobile'  => array(
					'type' => 'number',
				),
				'buttonLoadGoogleFonts'   => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'errorMsgColor'           => array(
					'type'    => 'string',
					'default' => '',
				),
				'errorMsgBgColor'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'errorMsgBorderColor'     => array(
					'type'    => 'string',
					'default' => '',
				),
				'msgBorderSize'           => array(
					'type'    => 'number',
					'default' => '',
				),
				'msgBorderRadius'         => array(
					'type'    => 'number',
					'default' => '',
				),
				'msgVrPadding'            => array(
					'type'    => 'number',
					'default' => '',
				),
				'msgHrPadding'            => array(
					'type'    => 'number',
					'default' => '',
				),
				'msgBorderRadiusType'     => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'fieldBorderRadiusType'   => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'buttonBorderRadiusType'  => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'paymentdescriptionColor' => array(
					'type'    => 'string',
					'default' => '',
				),
				'paymenttitleColor'       => array(
					'type'    => 'string',
					'default' => '',
				),
				'sectionbgColor'          => array(
					'type'    => 'string',
					'default' => '',
				),
				'informationbgColor'      => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'sectionBorderRadius'     => array(
					'type'    => 'number',
					'default' => '',
				),
				'sectionhrPadding'        => array(
					'type'    => 'string',
					'default' => '',
				),
				'sectionvrPadding'        => array(
					'type'    => 'string',
					'default' => '',
				),
				'sectionhrMargin'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'sectionvrMargin'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'headFontSize'            => array(
					'type'    => 'string',
					'default' => '',
				),
				'headFontSizeType'        => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'headFontSizeTablet'      => array(
					'type'    => 'string',
					'default' => '',
				),
				'headFontSizeMobile'      => array(
					'type'    => 'string',
					'default' => '',
				),
				'headFontFamily'          => array(
					'type'    => 'string',
					'default' => '',
				),
				'headFontWeight'          => array(
					'type'    => 'string',
					'default' => '',
				),
				'headFontSubset'          => array(
					'type'    => 'string',
					'default' => '',
				),
				'headLineHeightType'      => array(
					'type'    => 'string',
					'default' => '',
				),
				'headLineHeight'          => array(
					'type'    => 'string',
					'default' => '',
				),
				'headLineHeightTablet'    => array(
					'type'    => 'string',
					'default' => '',
				),
				'headLineHeightMobile'    => array(
					'type'    => 'string',
					'default' => '',
				),
				'headLoadGoogleFonts'     => array(
					'type'    => 'string',
					'default' => '',
				),
				'globaltextColor'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'globalbgColor'           => array(
					'type'    => 'string',
					'default' => '',
				),
				'globalFontSize'          => array(
					'type'    => 'number',
					'default' => '',
				),
				'globalFontSizeType'      => array(
					'type'    => 'string',
					'default' => 'px',
				),
				'globalFontSizeTablet'    => array(
					'type' => 'number',
				),
				'globalFontSizeMobile'    => array(
					'type' => 'number',
				),
				'globalFontFamily'        => array(
					'type'    => 'string',
					'default' => 'Default',
				),
				'globalFontWeight'        => array(
					'type' => 'string',
				),
				'globalFontSubset'        => array(
					'type' => 'string',
				),
				'globalLineHeightType'    => array(
					'type'    => 'string',
					'default' => 'em',
				),
				'globalLineHeight'        => array(
					'type' => 'number',
				),
				'globalLineHeightTablet'  => array(
					'type' => 'number',
				),
				'globalLineHeightMobile'  => array(
					'type' => 'number',
				),
				'globalLoadGoogleFonts'   => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'backgroundType'          => array(
					'type'    => 'string',
					'default' => 'color',
				),
				'backgroundImage'         => array(
					'type' => 'object',
				),
				'backgroundPosition'      => array(
					'type'    => 'string',
					'default' => 'center-center',
				),
				'backgroundSize'          => array(
					'type'    => 'string',
					'default' => 'cover',
				),
				'backgroundRepeat'        => array(
					'type'    => 'string',
					'default' => 'no-repeat',
				),
				'backgroundAttachment'    => array(
					'type'    => 'string',
					'default' => 'scroll',
				),
				'backgroundOpacity'       => array(
					'type' => 'number',
				),
				'backgroundImageColor'    => array(
					'type'    => 'string',
					'default' => '',
				),
				'backgroundColor'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'backgroundHoverColor'    => array(
					'type'    => 'string',
					'default' => '',
				),
				'gradientColor1'          => array(
					'type'    => 'string',
					'default' => '#f16334',
				),
				'gradientColor2'          => array(
					'type'    => 'string',
					'default' => '#f16334',
				),
				'gradientType'            => array(
					'type'    => 'string',
					'default' => 'linear',
				),
				'gradientLocation1'       => array(
					'type'    => 'number',
					'default' => 0,
				),
				'gradientLocation2'       => array(
					'type'    => 'number',
					'default' => 100,
				),
				'gradientAngle'           => array(
					'type'    => 'number',
					'default' => 0,
				),
				'gradientPosition'        => array(
					'type'    => 'string',
					'default' => 'center center',
				),
				'gradientValue'           => array(
					'type'    => 'string',
					'default' => '',
				),
				'errorLabelColor'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'errorFieldBorderColor'   => array(
					'type'    => 'string',
					'default' => '',
				),
			);

			$attributes = apply_filters( 'cartflows_gutenberg_cf_attributes_filters', $attr );

			register_block_type(
				'wcfb/checkout-form',
				array(
					'attributes'      => $attributes,
					'render_callback' => array( $this, 'render_html' ),
				)
			);
		}

		/**
		 * Render CF HTML.
		 *
		 * @param array $attributes Array of block attributes.
		 *
		 * @since x.x.x
		 */
		public function render_html( $attributes ) {

			$main_classes = array(
				'wcf-gb-checkout-form cartflows-gutenberg__checkout-form',
				'cf-block-' . $attributes['block_id'],
			);

			if ( isset( $attributes['className'] ) ) {
				$main_classes[] = $attributes['className'];
			}

			do_action( 'cartflows_gutenberg_checkout_options_filters', $attributes );

			ob_start();
			?>
			<div class = "<?php echo esc_attr( implode( ' ', $main_classes ) ); ?>">
				<?php echo do_shortcode( '[cartflows_checkout]' ); ?>
			</div>
			<?php
			return ob_get_clean();
		}
	}

	/**
	 *  Prepare if class 'WCFB_Checkout_Form' exist.
	 *  Kicking this off by calling 'get_instance()' method
	 */
	WCFB_Checkout_Form::get_instance();
}
