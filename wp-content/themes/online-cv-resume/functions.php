<?php
/**
 * Implement the theme Core feature.
 */
require get_template_directory() . '/inc/theme-core.php';


require get_template_directory() . '/inc/post-related-hook.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
* Implement the theme Layout.
*/
require get_template_directory() . '/inc/theme-layout-hook.php';

/**
* Implement the theme Layout.
*/
require get_template_directory() . '/inc/pro/admin-page.php';

/**
 * Customizer additions.
 */

require_once( trailingslashit( get_template_directory() ) . '/inc/customizer/class-customize.php' );

/**
* recommended plugins.
*/
require get_template_directory() . '/inc/tgm/recommended.php';