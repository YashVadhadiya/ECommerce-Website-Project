<?php
function store_customize_register_featured_posts_showcase( $wp_customize ) {


//Extra Panel for Users, who dont have WooCommerce

// CREATE THE fcp PANEL
$wp_customize->add_panel( 'store_a_fcp_panel', array(
    'priority'       => 40,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => 'Featured Posts Showcase',
    'description'    => '',
) );


//SQUARE BOXES
$wp_customize->add_section(
    'store_a_fc_boxes',
    array(
        'title'     => 'Square Boxes',
        'priority'  => 10,
        'panel'     => 'store_a_fcp_panel'
    )
);

$wp_customize->add_setting(
    'store_a_box_enable',
    array( 'sanitize_callback' => 'store_sanitize_checkbox' )
);

$wp_customize->add_control(
    'store_a_box_enable', array(
        'settings' => 'store_a_box_enable',
        'label'    => __( 'Enable Square Boxes & Posts Slider.', 'store' ),
        'section'  => 'store_a_fc_boxes',
        'type'     => 'checkbox',
    )
);


$wp_customize->add_setting(
    'store_a_box_title',
    array( 'sanitize_callback' => 'sanitize_text_field' )
);

$wp_customize->add_control(
    'store_a_box_title', array(
        'settings' => 'store_a_box_title',
        'label'    => __( 'Title for the Boxes','store' ),
        'section'  => 'store_a_fc_boxes',
        'type'     => 'text',
    )
);

$wp_customize->add_setting(
    'store_a_box_cat',
    array( 'sanitize_callback' => 'store_sanitize_category' )
);

$wp_customize->add_control(
    new WP_Customize_Category_Control(
        $wp_customize,
        'store_a_box_cat',
        array(
            'label'    => __('Posts Category.','store'),
            'settings' => 'store_a_box_cat',
            'section'  => 'store_a_fc_boxes'
        )
    )
);


//SLIDER
$wp_customize->add_section(
    'store_a_fc_slider',
    array(
        'title'     => __('3D Cube Posts Slider','store'),
        'priority'  => 10,
        'panel'     => 'store_a_fcp_panel',
        'description' => __('This is the Posts Slider, displayed left to the square boxes.', 'store')
    )
);


$wp_customize->add_setting(
    'store_a_slider_title',
    array( 'sanitize_callback' => 'sanitize_text_field' )
);

$wp_customize->add_control(
    'store_a_slider_title', array(
        'settings' => 'store_a_slider_title',
        'label'    => __( 'Title for the Slider', 'store' ),
        'section'  => 'store_a_fc_slider',
        'type'     => 'text',
    )
);

$wp_customize->add_setting(
    'store_a_slider_count',
    array( 'sanitize_callback' => 'store_sanitize_positive_number' )
);

$wp_customize->add_control(
    'store_a_slider_count', array(
        'settings' => 'store_a_slider_count',
        'label'    => __( 'No. of Posts(Min:3, Max: 10)', 'store' ),
        'section'  => 'store_a_fc_slider',
        'type'     => 'range',
        'input_attrs' => array(
            'min'   => 3,
            'max'   => 10,
            'step'  => 1,
            'class' => 'test-class test',
            'style' => 'color: #0a0',
        ),
    )
);

$wp_customize->add_setting(
    'store_a_slider_cat',
    array( 'sanitize_callback' => 'store_sanitize_category' )
);

$wp_customize->add_control(
    new WP_Customize_Category_Control(
        $wp_customize,
        'store_a_slider_cat',
        array(
            'label'    => __('Category For Slider.','store'),
            'settings' => 'store_a_slider_cat',
            'section'  => 'store_a_fc_slider'
        )
    )
);



//COVERFLOW

$wp_customize->add_section(
    'store_a_fc_coverflow',
    array(
        'title'     => __('Top CoverFlow Slider','store'),
        'priority'  => 5,
        'panel'     => 'store_a_fcp_panel'
    )
);

$wp_customize->add_setting(
    'store_a_coverflow_title',
    array( 'sanitize_callback' => 'sanitize_text_field' )
);

$wp_customize->add_control(
    'store_a_coverflow_title', array(
        'settings' => 'store_a_coverflow_title',
        'label'    => __( 'Title for the Coverflow', 'store' ),
        'section'  => 'store_a_fc_coverflow',
        'type'     => 'text',
    )
);

$wp_customize->add_setting(
    'store_a_coverflow_enable',
    array( 'sanitize_callback' => 'store_sanitize_checkbox' )
);

$wp_customize->add_control(
    'store_a_coverflow_enable', array(
        'settings' => 'store_a_coverflow_enable',
        'label'    => __( 'Enable', 'store' ),
        'section'  => 'store_a_fc_coverflow',
        'type'     => 'checkbox',
    )
);

$wp_customize->add_setting(
    'store_a_coverflow_cat',
    array( 'sanitize_callback' => 'store_sanitize_category' )
);


$wp_customize->add_control(
    new WP_Customize_Category_Control(
        $wp_customize,
        'store_a_coverflow_cat',
        array(
            'label'    => __('Category For Image Grid','store'),
            'settings' => 'store_a_coverflow_cat',
            'section'  => 'store_a_fc_coverflow'
        )
    )
);

$wp_customize->add_setting(
    'store_a_coverflow_pc',
    array( 'sanitize_callback' => 'store_sanitize_positive_number' )
);

$wp_customize->add_control(
    'store_a_coverflow_pc', array(
        'settings' => 'store_a_coverflow_pc',
        'label'    => __( 'Max No. of Posts in the Grid. Min: 5.', 'store' ),
        'section'  => 'store_a_fc_coverflow',
        'type'     => 'number',
        'default'  => '0'
    )
);

// 	Store Pro Placeholder
$wp_customize->add_section(
    'store_a_placeholder',
    array(
        'title'     => 'More Featured Areas in Store Pro!',
        'priority'  => 30,
        'panel'     => 'store_a_fcp_panel'
    )
);

$wp_customize->add_control(
    'store_a_box_placeholder', array(
        //'settings' => 'store_a_box_enable',
        'label'    => __( '', 'store' ),
        'section'  => 'store_a_placeholder',
        'settings' => array(),
    )
);
}
add_action( 'customize_register', 'store_customize_register_featured_posts_showcase' );