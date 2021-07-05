<?php
function store_customize_register_featured_products_showcase($wp_customize) {
    if ( class_exists('woocommerce') ) :
        // CREATE THE fcp PANEL
        $wp_customize->add_panel( 'store_fcp_panel', array(
            'priority'       => 40,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => 'Featured Product Showcase',
            'description'    => '',
        ) );


        //SQUARE BOXES
        $wp_customize->add_section(
            'store_fc_boxes',
            array(
                'title'     => 'Square Boxes',
                'priority'  => 10,
                'panel'     => 'store_fcp_panel'
            )
        );

        $wp_customize->add_setting(
            'store_box_enable',
            array( 'sanitize_callback' => 'store_sanitize_checkbox' )
        );

        $wp_customize->add_control(
            'store_box_enable', array(
                'settings' => 'store_box_enable',
                'label'    => __( 'Enable Square Boxes & Products Slider.', 'store' ),
                'section'  => 'store_fc_boxes',
                'type'     => 'checkbox',
            )
        );


        $wp_customize->add_setting(
            'store_box_title',
            array( 'sanitize_callback' => 'sanitize_text_field' )
        );

        $wp_customize->add_control(
            'store_box_title', array(
                'settings' => 'store_box_title',
                'label'    => __( 'Title for the Boxes','store' ),
                'section'  => 'store_fc_boxes',
                'type'     => 'text',
            )
        );

        $wp_customize->add_setting(
            'store_box_cat',
            array( 'sanitize_callback' => 'store_sanitize_product_category' )
        );

        $wp_customize->add_control(
            new WP_Customize_Product_Category_Control(
                $wp_customize,
                'store_box_cat',
                array(
                    'label'    => __('Product Category.','store'),
                    'settings' => 'store_box_cat',
                    'section'  => 'store_fc_boxes'
                )
            )
        );


        //SLIDER
        $wp_customize->add_section(
            'store_fc_slider',
            array(
                'title'     => __('3D Cube Products Slider','store'),
                'priority'  => 10,
                'panel'     => 'store_fcp_panel',
                'description' => 'This is the Products Slider, displayed left to the square boxes.',
            )
        );


        $wp_customize->add_setting(
            'store_slider_title',
            array( 'sanitize_callback' => 'sanitize_text_field' )
        );

        $wp_customize->add_control(
            'store_slider_title', array(
                'settings' => 'store_slider_title',
                'label'    => __( 'Title for the Slider', 'store' ),
                'section'  => 'store_fc_slider',
                'type'     => 'text',
            )
        );

        $wp_customize->add_setting(
            'store_slider_count',
            array( 'sanitize_callback' => 'store_sanitize_positive_number' )
        );

        $wp_customize->add_control(
            'store_slider_count', array(
                'settings' => 'store_slider_count',
                'label'    => __( 'No. of Products(Min:3, Max: 10)', 'store' ),
                'section'  => 'store_fc_slider',
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
            'store_slider_cat',
            array( 'sanitize_callback' => 'store_sanitize_product_category' )
        );

        $wp_customize->add_control(
            new WP_Customize_Product_Category_Control(
                $wp_customize,
                'store_slider_cat',
                array(
                    'label'    => __('Category For Slider.','store'),
                    'settings' => 'store_slider_cat',
                    'section'  => 'store_fc_slider'
                )
            )
        );



        //COVERFLOW

        $wp_customize->add_section(
            'store_fc_coverflow',
            array(
                'title'     => __('Top CoverFlow Slider','store'),
                'priority'  => 5,
                'panel'     => 'store_fcp_panel'
            )
        );

        $wp_customize->add_setting(
            'store_coverflow_enable',
            array( 'sanitize_callback' => 'store_sanitize_checkbox' )
        );

        $wp_customize->add_control(
            'store_coverflow_enable', array(
                'settings' => 'store_coverflow_enable',
                'label'    => __( 'Enable', 'store' ),
                'section'  => 'store_fc_coverflow',
                'type'     => 'checkbox',
            )
        );

        $wp_customize->add_setting(
            'store_coverflow_cat',
            array( 'sanitize_callback' => 'store_sanitize_product_category' )
        );


        $wp_customize->add_control(
            new WP_Customize_Product_Category_Control(
                $wp_customize,
                'store_coverflow_cat',
                array(
                    'label'    => __('Category For Image Grid','store'),
                    'settings' => 'store_coverflow_cat',
                    'section'  => 'store_fc_coverflow'
                )
            )
        );

        $wp_customize->add_setting(
            'store_coverflow_pc',
            array( 'sanitize_callback' => 'store_sanitize_positive_number' )
        );

        $wp_customize->add_control(
            'store_coverflow_pc', array(
                'settings' => 'store_coverflow_pc',
                'label'    => __( 'Max No. of Products in the Grid. Min: 5.', 'store' ),
                'section'  => 'store_fc_coverflow',
                'type'     => 'number',
                'default'  => '0'
            )
        );

        // Promotional Product Section
        $wp_customize->add_section('store_hero1_section',
            array(
                'title' => __('Promotional Product', 'store'),
                'priority' => 20,
                'panel'     => 'store_fcp_panel'
            )
        );

        $wp_customize->add_setting('store_hero_enable',
            array(
                'sanitize_callback' => 'store_sanitize_checkbox'
            ));
        $wp_customize->add_control('store_hero_enable',
            array(
                'setting' => 'store_hero_enable',
                'section' => 'store_hero1_section',
                'label' => __('Enable Promotional Product', 'store'),
                'type' => 'checkbox',
            )
        );

        $wp_customize->add_setting('store_hero_background_image',
            array(
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize, 'store_hero_background_image',
                array (
                    'setting' => 'store_hero_background_image',
                    'section' => 'store_hero1_section',
                    'label' => __('Background Image', 'store'),
                    'description' => __('Upload an image to display in background of the area', 'store'),
                )
            )
        );

        $wp_customize->add_setting('store_hero1_full_content',
            array(
                'sanitize_callback' => 'store_sanitize_checkbox'
            )
        );

        $wp_customize->add_control('store_hero1_full_content',
            array(
                'setting' => 'store_hero1_full_content',
                'section' => 'store_hero1_section',
                'label' => __('Show Full Content insted of excerpt', 'store'),
                'type' => 'checkbox',
            )
        );

        $wp_customize->add_setting('store_fp_product_id',
            array(
                'sanitize_callback' => 'absint'
            )
        );

        $wp_customize->add_control('store_fp_product_id',
            array(
                'setting' => 'store_fp_product_id',
                'section' => 'store_hero1_section',
                'label' => __('Product ID', 'store'),
                'description' => __('Enter the product which you want to promote.', 'store'),
                'type' => 'text',
            )
        );
        
        // 	Store Pro Placeholder
		$wp_customize->add_section(
		    'store_placeholder',
		    array(
		        'title'     => 'More Featured Areas in Store Pro!',
		        'priority'  => 30,
		        'panel'     => 'store_fcp_panel'
		    )
		);
		
		$wp_customize->add_control(
		    'store_box_placeholder', array(
		        //'settings' => 'store_a_box_enable',
		        'label'    => __( '', 'store' ),
		        'section'  => 'store_placeholder',
		        'settings' => array(),
		    )
		);


    else :
    
    	//SQUARE BOXES
        $wp_customize->add_section(
            'store_fc_boxes_placeholder',
            array(
                'title'     => 'Enable WooCommerce for More!',
                'priority'  => 45,
                //'panel'     => 'store_fcp_panel'
            )
        );/*


        $wp_customize->add_setting(
            'store_box_enable_holder',
            array( 'sanitize_callback' => 'store_sanitize_checkbox' )
        );
*/

        $wp_customize->add_control(
            'store_box_enable', array(
                'settings' => 'store_box_enable_placeholder',
                'label'    => __( 'Enable Square Boxes & Products Slider.', 'store' ),
                'section'  => 'store_fc_boxes_placeholder',
                'settings'	=> array(),
                //'type'     => 'checkbox',
            )
        );
        
    endif;

}
add_action('customize_register', 'store_customize_register_featured_products_showcase');