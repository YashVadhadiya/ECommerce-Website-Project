<?php
/**
 * Enqueue scripts and styles.
 */
function store_scripts() {
    wp_enqueue_style( 'store-style', get_stylesheet_uri() );

    wp_enqueue_style('store-title-font', '//fonts.googleapis.com/css?family='.str_replace(" ", "+", get_theme_mod('store_title_font', 'Lato') ).':100,300,400,700' );
    if (get_theme_mod('store_body_font','Open Sans') != get_theme_mod('store_title_font','Lato')) {
        wp_enqueue_style('store-body-font', '//fonts.googleapis.com/css?family='.str_replace(" ", "+", get_theme_mod('store_body_font', 'Open Sans') ).':100,300,400,700' );
    }

    wp_enqueue_style( 'store-fontawesome-style', get_template_directory_uri() . '/assets/font-awesome/css/fontawesome-all.min.css' );

    wp_enqueue_style( 'store-bootstrap-style', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css' );

    wp_enqueue_style( 'store-hover-style', get_template_directory_uri() . '/assets/css/hover.min.css' );

    wp_enqueue_style( 'store-slicknav', get_template_directory_uri() . '/assets/css/slicknav.css' );

    wp_enqueue_style( 'store-swiperslider-style', get_template_directory_uri() . '/assets/css/swiper.min.css' );

    wp_enqueue_style( 'store-main-theme-style', get_template_directory_uri() . '/assets/theme-styles/css/'.get_theme_mod('store_skins', 'default').'.css', array(), null );

    wp_enqueue_script( 'store-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

    wp_enqueue_script( 'store-externaljs', get_template_directory_uri() . '/js/external.js', array('jquery'), '20120206', true );

    wp_enqueue_script( 'store-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_enqueue_script( 'store-custom-js', get_template_directory_uri() . '/js/custom.js', array('store-externaljs') );
}
add_action( 'wp_enqueue_scripts', 'store_scripts' );