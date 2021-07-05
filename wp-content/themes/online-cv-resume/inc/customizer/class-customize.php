<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class OnlineCVresume_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		//require_once( get_template_directory() . 'inc/customizer/section-pro.php' );
		load_template( dirname( __FILE__ ) . '/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Online_CV_Resume_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Online_CV_Resume_Section_Pro(
				$manager,
				'example_1',
				array(
					'title'    => esc_html__( 'Online CV Resume', 'online-cv-resume' ),
					'pro_text' => esc_html__( 'Go Pro',         'online-cv-resume' ),
					'pro_url'  => 'https://edatastyle.com/product/online-cv-resume-wordpress-theme/',
					'priority'  => 1,
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'online-cv-resume-controls', trailingslashit( get_template_directory_uri() ) . '/inc/customizer/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'online-cv-resume-controls', trailingslashit( get_template_directory_uri() ) . '/inc/customizer/customize-controls.css' );
	}
}

// Doing this customizer thang!
OnlineCVresume_Customize::get_instance();
