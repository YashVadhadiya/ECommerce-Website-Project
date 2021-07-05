<?php
function store_customize_register_misc($wp_customize) {
    //Upgrade to Pro
    $wp_customize->add_section(
        'store_sec_pro',
        array(
            'title'     => __('Important Links','store'),
            'priority'  => 10,
        )
    );

    $wp_customize->add_setting(
        'store_pro',
        array( 'sanitize_callback' => 'esc_textarea' )
    );

    $wp_customize->add_control(
        new WP_Customize_Upgrade_Control(
            $wp_customize,
            'store_pro',
            array(
				'description'	=> '<a class="store-important-links" href="https://inkhive.com/product/store" target="_blank">'.__('<b>STORE PRO</b>', 'store').'</a>
									<a class="store-important-links" href="https://inkhive.com/contact-us/" target="_blank">'.__('InkHive Support Forum', 'store').'</a>
                                    <a class="store-important-links" href="https://inkhive.com/documentation/store" target="_blank">'.__('Store Documentation', 'store').'</a>
                                    <a class="store-important-links" href="https://demo.inkhive.com/store-pro/" target="_blank">'.__('Store Pro Live Demo', 'store').'</a>
                                    <a class="store-important-links" href="https://www.facebook.com/inkhivethemes/" target="_blank">'.__('We Love Our Facebook Fans', 'store').'</a>
                                    <a class="store-important-links" href="https://wordpress.org/support/theme/store/reviews" target="_blank">'.__('Review Store on WordPress', 'store').'</a>',
						'section' => 'store_sec_pro',
						'settings' => 'store_pro',
            )
        )
    );
}
add_action('customize_register', 'store_customize_register_misc');