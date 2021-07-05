<?php
/* 
**   Custom Modifcations in CSS depending on user settings.
*/

function store_custom_css_mods() {

	echo "<style id='custom-css-mods'>";
	
	
	//If Menu Description is Disabled.
	if ( !has_nav_menu('primary') || get_theme_mod('store_disable_nav_desc', true) ) :
		echo "#site-navigation ul li a { padding: 16px 12px; }";
	endif;
	
	//Exception: IMage transform origin should be left on Left Alignment, i.e. Default
	if ( get_theme_mod('store_title_font') ) :
		echo ".title-font, h1, h2, .section-title, .woocommerce ul.products li.product h3 { font-family: '".esc_html( get_theme_mod('store_title_font','Lato') )."'; }";
	endif;
	
	if ( get_theme_mod('store_body_font') ) :
		echo "body { font-family: '".esc_html( get_theme_mod('store_body_font','Open Sans') )."'; }";
	endif;
	
	if ( get_theme_mod('store_site_titlecolor') ) :
		echo "#masthead h1.site-title a { color: ".esc_html( get_theme_mod('store_site_titlecolor', '#FFFFFF') )."; }";
	endif;
	
	if ( get_theme_mod('store_header_desccolor','#777') ) :
		echo ".site-description { color: ".esc_html( get_theme_mod('store_header_desccolor','#FFFFFF') )."; }";
	endif;
	//Check Jetpack is active
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) )
		echo '.pagination { display: none; }';
	
	if ( get_theme_mod('store_hide_title_tagline') ) :
		echo "#masthead .site-branding #text-title-desc { display: none; }";
	endif;

	if ( get_theme_mod('store_hide_fc_line') ):
        echo ".site-info .sep { display: none; }";
	endif;

    if (get_theme_mod('store_hero_background_image') != '') :
        $image = get_theme_mod('store_hero_background_image');
        echo  "#hero {
                    	background-image: url('" . $image . "');
                        background-size: cover;
                }";
    else:
        echo "#hero { background: #efefef; }";
    endif;

	echo "</style>";
}

add_action('wp_head', 'store_custom_css_mods');