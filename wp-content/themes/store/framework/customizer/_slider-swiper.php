<?php
//SLIDER
// SLIDER PANEL
function store_customize_register_slider( $wp_customize ) {
$wp_customize->add_panel( 'store_slider_panel', array(
    'priority'       => 35,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => 'Main Slider',
) );

$wp_customize->add_section(
    'store_sec_slider_options',
    array(
        'title'     => 'Enable/Disable',
        'priority'  => 0,
        'panel'     => 'store_slider_panel'
    )
);


$wp_customize->add_setting(
    'store_main_slider_enable',
    array( 'sanitize_callback' => 'store_sanitize_checkbox' )
);

$wp_customize->add_control(
    'store_main_slider_enable', array(
        'settings' => 'store_main_slider_enable',
        'label'    => __( 'Enable Slider on HomePage.', 'store' ),
        'section'  => 'store_sec_slider_options',
        'type'     => 'checkbox',
    )
);


$wp_customize->add_setting(
    'store_main_slider_count',
    array(
        'default' => '0',
        'sanitize_callback' => 'store_sanitize_positive_number'
    )
);
// Select How Many Slides the User wants, and Reload the Page.
    $wp_customize->add_control(
        'store_main_slider_count', array(
            'settings' => 'store_main_slider_count',
            'label'    => __( 'No. of Slides(Min:0, Max: 10)' ,'store'),
            'section'  => 'store_sec_slider_options',
            'type'     => 'number',
            'description' => __('Save the Settings, and Reload this page to Configure the Slides.','store'),

        )
    );

    for ( $i = 1 ; $i <= 10 ; $i++ ) :

        //Create the settings Once, and Loop through it.
        static $x = 0;
        $wp_customize->add_section(
            'store_slide_sec'.$i,
            array(
                'title'     => 'Slide '.$i,
                'priority'  => $i,
                'panel'     => 'store_slider_panel',
                'active_callback' => 'store_show_slide_sec'

            )
        );

        $wp_customize->add_setting(
            'store_slide_img'.$i,
            array( 'sanitize_callback' => 'esc_url_raw' )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'store_slide_img'.$i,
                array(
                    'label' => '',
                    'section' => 'store_slide_sec'.$i,
                    'settings' => 'store_slide_img'.$i,
                )
            )
        );

        $wp_customize->add_setting(
            'store_slide_title'.$i,
            array( 'sanitize_callback' => 'sanitize_text_field' )
        );

        $wp_customize->add_control(
            'store_slide_title'.$i, array(
                'settings' => 'store_slide_title'.$i,
                'label'    => __( 'Slide Title','store' ),
                'section'  => 'store_slide_sec'.$i,
                'type'     => 'text',
            )
        );

        $wp_customize->add_setting(
            'store_slide_desc'.$i,
            array( 'sanitize_callback' => 'sanitize_text_field' )
        );

        $wp_customize->add_control(
            'store_slide_desc'.$i, array(
                'settings' => 'store_slide_desc'.$i,
                'label'    => __( 'Slide Description','store' ),
                'section'  => 'store_slide_sec'.$i,
                'type'     => 'text',
            )
        );



        $wp_customize->add_setting(
            'store_slide_CTA_button'.$i,
            array( 'sanitize_callback' => 'sanitize_text_field' )
        );

        $wp_customize->add_control(
            'store_slide_CTA_button'.$i, array(
                'settings' => 'store_slide_CTA_button'.$i,
                'label'    => __( 'Custom Call to Action Button Text(Optional)','store' ),
                'section'  => 'store_slide_sec'.$i,
                'type'     => 'text',
            )
        );

        $wp_customize->add_setting(
            'store_slide_url'.$i,
            array( 'sanitize_callback' => 'esc_url_raw' )
        );

        $wp_customize->add_control(
            'store_slide_url'.$i, array(
                'settings' => 'store_slide_url'.$i,
                'label'    => __( 'Target URL','store' ),
                'section'  => 'store_slide_sec'.$i,
                'type'     => 'url',
            )
        );

    endfor;
    
    // 	Store Pro Placeholder
	$wp_customize->add_section(
	    'store_slider_placeholder',
	    array(
	        'title'     => 'More Slider Settings in Store Pro!',
	        'priority'  => 30,
	        'panel'     => 'store_slider_panel'
	    )
	);
	
	$wp_customize->add_control(
	    'store_slider_placeholder', array(
	        //'settings' => 'store_a_box_enable',
	        'label'    => __( '', 'store' ),
	        'section'  => 'store_slider_placeholder',
	        'settings' => array(),
	    )
	);

    //active callback to see if the slide section is to be displayed or not
    function store_show_slide_sec( $control ) {
        $option = $control->manager->get_setting('store_main_slider_count');
        global $x;
        if ( $x < $option->value() ){
            $x++;
            return true;
        }
    }
}
add_action( 'customize_register', 'store_customize_register_slider' );