<?php
//Logo Settings
function store_customize_register_header( $wp_customize ) {
    //Header Settings
    $wp_customize->add_panel('store_header_panel', array(
        'title' => __('Header Settings', 'store'),
        'priority' =>20,
    ));

$wp_customize->add_section( 'title_tagline' , array(
    'title'      => __( 'Title, Tagline & Logo', 'store' ),
    'priority'   => 1,
    'panel'      => 'store_header_panel'
) );

$wp_customize->add_setting( 'store_logo' , array(
    'default'     => '',
    'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'store_logo',
        array(
            'label' => 'Upload Logo',
            'section' => 'title_tagline',
            'settings' => 'store_logo',
            'priority' => 5,
        )
    )
);

function store_logo_enabled($control) {
    $option = $control->manager->get_setting('store_logo');
    return $option->value() == true;
}

    //Settings For Logo Area

    $wp_customize->add_setting(
        'store_hide_title_tagline',
        array( 'sanitize_callback' => 'store_sanitize_checkbox',
        		'transport'			=> 'postMessage'
        	)
    );

    $wp_customize->add_control(
        'store_hide_title_tagline', array(
            'settings' => 'store_hide_title_tagline',
            'label'    => __( 'Hide Title and Tagline.', 'store' ),
            'section'  => 'title_tagline',
            'type'     => 'checkbox',
        )
    );
    function store_title_visible( $control ) {
        $option = $control->manager->get_setting('store_hide_title_tagline');
        return $option->value() == false ;
    }

//Replace Header Text Color with, separate colors for Title and Description
//Override store_site_titlecolor
$wp_customize->remove_setting('header_textcolor');
$wp_customize->add_setting('store_site_titlecolor', array(
    'default'     => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
));

$wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'store_site_titlecolor', array(
        'label' => __('Site Title Color','store'),
        'section' => 'colors',
        'settings' => 'store_site_titlecolor',
        'type' => 'color'
    ) )
);

$wp_customize->add_setting('store_header_desccolor', array(
    'default'     => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
));

$wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'store_header_desccolor', array(
        'label' => __('Site Tagline Color','store'),
        'section' => 'colors',
        'settings' => 'store_header_desccolor',
        'type' => 'color'
    ) )
);

// 	Store Pro Placeholder
	$wp_customize->add_section(
	    'store_header_placeholder',
	    array(
	        'title'     => 'More Header Settings in Store Pro!',
	        'priority'  => 30,
	        'panel'     => 'store_header_panel'
	    )
	);
	
	$wp_customize->add_control(
	    'store_header_placeholder', array(
	        //'settings' => 'store_a_box_enable',
	        'label'    => __( '', 'store' ),
	        'section'  => 'store_header_placeholder',
	        'settings' => array(),
	    )
	);
}
add_action( 'customize_register', 'store_customize_register_header' );