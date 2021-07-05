<?php
/**
 * online_cv_resume functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package online_cv_resume
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! function_exists( 'online_cv_resume_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function online_cv_resume_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on online_cv_resume, use a find and replace
		 * to change 'online_cv_resume' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'online-cv-resume', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'online-cv-resume' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'online_cv_resume_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_editor_style( '//fonts.googleapis.com/css?family=K2D:300,400,500,600,700|Roboto:400,500,700' );
		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		
		/*
		* Enable support for Post Formats.
		* See https://developer.wordpress.org/themes/functionality/post-formats/
		*/
		add_theme_support( 'post-formats', array(
			'image',
			'video',
			'gallery',
			'audio',
			'quote'
		) );
		
	}
endif;
add_action( 'after_setup_theme', 'online_cv_resume_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function online_cv_resume_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'online_cv_resume_content_width', 640 );
}
add_action( 'after_setup_theme', 'online_cv_resume_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function online_cv_resume_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'online-cv-resume' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'online-cv-resume' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Home Page hero Section', 'online-cv-resume' ),
		'id'            => 'hero',
		'description'   => esc_html__( 'Add widgets here.', 'online-cv-resume' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="screen-reader-text">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'online_cv_resume_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function online_cv_resume_scripts() {
	
	/* vendor css*/
	wp_enqueue_style( 'google-font', 'https://fonts.googleapis.com/css?family=K2D:300,400,500,600,700|Roboto:400,500,700' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/vendor/font-awesome/css/font-awesome.css', array(), '4.7' );
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.css', array(), '4.0.0' );
	
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/vendor/fancybox/jquery.fancybox.css', array(), '3.5.6' );
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/vendor/owl-carousel/animate.css', array(), '3.5.6' );
	wp_enqueue_style( 'owl-animate', get_template_directory_uri() . '/vendor/owl-carousel/owl.animate.css', array(), '3.5.6' );

	wp_enqueue_style( 'aos-next', get_template_directory_uri() . '/vendor/aos-next/aos.css');
	wp_enqueue_style( 'online_cv_resume-css', get_template_directory_uri() . '/assets/css/online-cv-resume.css', array(), '1.0.0' );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'online_cv_resume-style', get_stylesheet_uri() );
	
	wp_enqueue_style( 'online_cv_resume-responsive', get_template_directory_uri() . '/assets/css/online-cv-resume-responsive.css', array(), '1.0.0' );
	wp_enqueue_style( 'online_cv_resume-color', get_template_directory_uri() . '/assets/css/color4.css', array(), '1.0.0' );
	
	
	/* vendor js*/
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap.js', array('jquery'), '20151215', true  );

	wp_enqueue_script( 'fancybox-js', get_template_directory_uri() . '/vendor/fancybox/jquery.fancybox.js', array(), '', true  );
	wp_enqueue_script( 'owl-carousel-js', get_template_directory_uri() . '/vendor/owl-carousel/owl.carousel.js', array(), '', true  );
	wp_enqueue_script( 'aos-next-js', get_template_directory_uri() . '/vendor/aos-next/aos.js', array(), '', true );


	wp_enqueue_script( 'online_cv_resume-js', get_template_directory_uri() . '/assets/js/online-cv-resume.js', array(), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'online_cv_resume_scripts' );




/**
 * Set up the WordPress core custom header feature.
 *header.jpg
 * @uses online_cv_resume_header_style()
 */
function online_cv_resume_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'online_cv_resume_custom_header_args', array(
		'default-image' => get_template_directory_uri() . '/images/header.jpg',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 350,
		'flex-height'            => true,
		'wp-head-callback'       => 'online_cv_resume_header_style',
	) ) );
	
	register_default_headers( array(
		'default-image' => array(
		'url' => '%s/images/custom-header.jpg',
		'thumbnail_url' => '%s/images/header.jpg',
		'description' => esc_html__( 'Default Header Image', 'online-cv-resume' ),
		),
	));
}
add_action( 'after_setup_theme', 'online_cv_resume_custom_header_setup' );

if ( ! function_exists( 'online_cv_resume_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see online_cv_resume_custom_header_setup().
	 */
	function online_cv_resume_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.site-heading,
			.site-heading a,
			#aside-nav-actions .site-subtitle {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
