<?php
/**
* Enqueue Scripts for Admin
*/
function store_custom_wp_admin_style() {
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/fontawesome-all.min.css' );

    wp_enqueue_style( 'store-admin_css', get_template_directory_uri() . '/assets/theme-styles/css/admin.css' );
}
add_action( 'customize_controls_print_styles', 'store_custom_wp_admin_style' );
