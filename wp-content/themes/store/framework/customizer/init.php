<?php
/**
 * store Theme Customizer
 *
 * @package store
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function store_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    //Renameing Default Sections
    $wp_customize->get_section('colors')->title = __('Theme Skins & Colors', 'store');
    $wp_customize->get_section('colors')->panel = 'store_design_panel';
    $wp_customize->get_section('background_image')->panel = 'store_design_panel';
    
    // 	Store Pro Placeholder
	$wp_customize->add_section(
	    'store_main_placeholder',
	    array(
	        'title'     => 'More Options in Store Pro!',
	        'priority'  => 50,
	    )
	);
	
	$wp_customize->add_control(
	    'store_main_placeholder', array(
	        'label'    => __( '', 'store' ),
	        'section'  => 'store_main_placeholder',
	        'settings' => array(),
	    )
	);
}
add_action( 'customize_register', 'store_customize_register' );


//Load All Individual Settings Based on Sections/Panels.
require_once get_template_directory().'/framework/customizer/_googlefonts.php';
require_once get_template_directory().'/framework/customizer/_fposts-showcase.php';
require_once get_template_directory().'/framework/customizer/_fproducts-showcase.php';
require_once get_template_directory().'/framework/customizer/_slider-swiper.php';
require_once get_template_directory().'/framework/customizer/_layouts.php';
require_once get_template_directory().'/framework/customizer/_sanitization.php';
require_once get_template_directory().'/framework/customizer/header.php';
require_once get_template_directory().'/framework/customizer/navigation.php';
require_once get_template_directory().'/framework/customizer/skins.php';
require_once get_template_directory().'/framework/customizer/social-icons.php';
require_once get_template_directory().'/framework/customizer/misc-scripts.php';


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function store_customize_preview_js() {
    wp_enqueue_script( 'store_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'store_customize_preview_js' );