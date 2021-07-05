<?php
//Fonts
function store_customize_register_fonts( $wp_customize ) {
$wp_customize->add_section(
    'store_typo_options',
    array(
        'title'     => __('Google Web Fonts','store'),
        'priority'  => 41,
        'description' => __('Defaults: Lato, Open Sans.','store'),
        'panel'     => 'store_design_panel'
    )
);

$font_array = array('Raleway','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo 13px','Lora','Source Sans Pro','PT Sans','Ubuntu','Lobster','Arimo','Bitter','Noto Sans');
$fonts = array_combine($font_array, $font_array);

$wp_customize->add_setting(
    'store_title_font',
    array(
        'default'=> 'Lato',
        'sanitize_callback' => 'store_sanitize_gfont'
    )
);

function store_sanitize_gfont( $input ) {
    if ( in_array($input, array('Raleway','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo 13px','Lora','Source Sans Pro','PT Sans','Ubuntu','Lobster','Arimo','Bitter','Noto Sans') ) )
        return $input;
    else
        return '';
}

$wp_customize->add_control(
    'store_title_font',array(
        'label' => __('Title','store'),
        'settings' => 'store_title_font',
        'section'  => 'store_typo_options',
        'type' => 'select',
        'choices' => $fonts,
    )
);

$wp_customize->add_setting(
    'store_body_font',
    array(	'default'=> 'Open Sans',
        'sanitize_callback' => 'store_sanitize_gfont' )
);

$wp_customize->add_control(
    'store_body_font',array(
        'label' => __('Body','store'),
        'settings' => 'store_body_font',
        'section'  => 'store_typo_options',
        'type' => 'select',
        'choices' => $fonts
    )
);
}
add_action( 'customize_register', 'store_customize_register_fonts' );