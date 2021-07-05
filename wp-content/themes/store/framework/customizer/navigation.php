<?php
//Settings for Nav Area
function store_customize_register_nav( $wp_customize ) {
$wp_customize->add_section(
    'store_menu_basic',
    array(
        'title'     => __('Menu Settings','store'),
        'priority'  => 0,
        'panel'     => 'nav_menus'
    )
);

$wp_customize->add_setting( 'store_disable_nav_desc' , array(
    'default'     => true,
    'sanitize_callback' => 'store_sanitize_checkbox',
) );

$wp_customize->add_control(
    'store_disable_nav_desc', array(
    'label' => __('Disable Description of Menu Items','store'),
    'section' => 'store_menu_basic',
    'settings' => 'store_disable_nav_desc',
    'type' => 'checkbox'
) );
}
add_action( 'customize_register', 'store_customize_register_nav' );