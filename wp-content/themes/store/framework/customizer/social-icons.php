<?php
// Social Icons
function store_customize_register_social( $wp_customize ) {
$wp_customize->add_section('store_social_section', array(
    'title' => __('Social Icons','store'),
    'priority' => 3,
    'panel'      => 'store_header_panel'

));
//social icons style
$social_style = array(
    'hvr-ripple-out'  => __('Default', 'store'),
    'hvr-wobble-bottom'   => __('Style 1', 'store'),
    'hvr-bounce-to-bottom'   => __('Style 2', 'store'),
    'hvr-rectangle-out'   => __('Style 3', 'store'),
    'hvr-shutter-in-horizontal'   => __('Style 4', 'store'),
);
$wp_customize->add_setting(
    'store_social_icon_style_set', array(
    'sanitize_callback' => 'store_sanitize_social_style',
    'default' => 'hvr-ripple-out',
    'transport'	=> 'postMessage'
));

function store_sanitize_social_style( $input ) {
    if ( in_array($input, array(
        'hvr-bounce-to-bottom',
        'hvr-wobble-bottom',
        'hvr-ripple-out',
        'hvr-rectangle-out',
        'hvr-shutter-in-horizontal') ) )
        return $input;
    else
        return '';
}

$wp_customize->add_control( 'store_social_icon_style_set', array(
    'settings' => 'store_social_icon_style_set',
    'label' => __('Social Icon Style ','store'),
    'description' => __('You can choose your icon style','store'),
    'section' => 'store_social_section',
    'type' => 'select',
    'choices' => $social_style,
));
$social_networks = array( //Redefinied in Sanitization Function.
    'none' => __('-','store'),
    'facebook' => __('Facebook','store'),
    'twitter' => __('Twitter','store'),
    'google-plus' => __('Google Plus','store'),
    'instagram' => __('Instagram','store'),
    'vimeo-square' => __('Vimeo','store'),
    'youtube' => __('Youtube','store'),
    'flickr' => __('Flickr','store'),
    'pinterest'	=> __('Pinterest','store')
);

$social_count = count($social_networks);

for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :

    $wp_customize->add_setting(
        'store_social_'.$x, array(
        'sanitize_callback' => 'store_sanitize_social',
        'default' => 'none',
        'transport'	=> 'postMessage'
    ));

    $wp_customize->add_control( 'store_social_'.$x, array(
        'settings' => 'store_social_'.$x,
        'label' => __('Icon ','store').$x,
        'section' => 'store_social_section',
        'type' => 'select',
        'choices' => $social_networks,
    ));

    $wp_customize->add_setting(
        'store_social_url'.$x, array(
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control( 'store_social_url'.$x, array(
        'settings' => 'store_social_url'.$x,
        'description' => __('Icon ','store').$x.__(' Url','store'),
        'section' => 'store_social_section',
        'type' => 'url',
        'choices' => $social_networks,
    ));

endfor;

function store_sanitize_social( $input ) {
    $social_networks = array(
        'none' ,
        'facebook',
        'twitter',
        'google-plus',
        'instagram',
        'vimeo-square',
        'youtube',
        'flickr',
        'pinterest'
    );
    if ( in_array($input, $social_networks) )
        return $input;
    else
        return '';
}
}
add_action( 'customize_register', 'store_customize_register_social' );