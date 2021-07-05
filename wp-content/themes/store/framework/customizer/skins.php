<?php
//Select the Default Theme Skin
function store_customize_register_skins( $wp_customize ) {
    $wp_customize->add_setting(
        'store_skin',
        array(
            'default'=> 'default',
            'sanitize_callback' => 'store_sanitize_skin'
        )
    );

    function store_sanitize_skin( $input ) {
        if ( in_array($input, array('default','orange','brown','green', 'grayscale','reddish') ) )
            return $input;
        else
            return '';
    }

    //Skins
    $wp_customize->add_setting(
        'store_skins',
        array(
            'default'	=> 'default',
            'sanitize_callback' => 'store_sanitize_skin',
            'transport'	=> 'refresh'
        )
    );

    if(!function_exists('store_skin_array')){
        function store_skin_array(){
            return array(
                '#42a1cd' => 'default',
                '#e48d48' => 'orange',
                '#643020' => 'brown',
                '#34c94a' => 'green',
                '#444' => 'grayscale',
                '#CA2D4F' => 'reddish',
            );
        }
    }

    $store_skin_array = store_skin_array();


    $wp_customize->add_control(
        new Store_Skin_Chooser(
            $wp_customize,
            'store_skins',
            array(
                'settings'		=> 'store_skins',
                'section'		=> 'colors',
                'label'			=> __( 'Select Skins', 'store' ),
                'type'			=> 'skins',
                'choices'		=> $store_skin_array,
            )
        )
    );

}
add_action( 'customize_register', 'store_customize_register_skins' );