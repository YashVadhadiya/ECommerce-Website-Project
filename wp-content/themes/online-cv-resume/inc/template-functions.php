<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package online_cv_resume
 */

add_action( 'wp_head', 'online_cv_resume_move_theme_down' );
function online_cv_resume_move_theme_down() {
  if ( is_admin_bar_showing() ) {
    ?>
    <style type="text/css">
	body{
		padding-top:28px;	
	}
	.side-bar-icon{
		top:48px;	
	}
	div.sidewrapper.sidenav{
		padding-top:48px;	
	}
    </style>
    <?php
  }
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function online_cv_resume_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'online_cv_resume_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function online_cv_resume_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'online_cv_resume_pingback_header' );



function online_cv_resume_alowed_tags() {
	
	$wp_post_allow_tag = wp_kses_allowed_html( 'post' );
	
	$allowed_tags = array(
		'a' => array(
			'class' => array(),
			'href'  => array(),
			'rel'   => array(),
			'title' => array(),
		),
		'abbr' => array(
			'title' => array(),
		),
		'b' => array(),
		'blockquote' => array(
			'cite'  => array(),
		),
		'cite' => array(
			'title' => array(),
		),
		'code' => array(),
		'del' => array(
			'datetime' => array(),
			'title' => array(),
		),
		'dd' => array(),
		'div' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'dl' => array(),
		'dt' => array(),
		'em' => array(),
		'h1' => array(),
		'h2' => array(),
		'h3' => array(),
		'h4' => array(),
		'h5' => array(),
		'h6' => array(),
		'i' => array(),
		'img' => array(
			'alt'    => array(),
			'class'  => array(),
			'height' => array(),
			'src'    => array(),
			'width'  => array(),
		),
		'li' => array(
			'class' => array(),
		),
		'ol' => array(
			'class' => array(),
		),
		'p' => array(
			'class' => array(),
		),
		'q' => array(
			'cite' => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'strike' => array(),
		'strong' => array(),
		'ul' => array(
			'class' => array(),
		),
		'iframe' => array(
			'src'             => array(),
			'height'          => array(),
			'width'           => array(),
			'frameborder'     => array(),
			'allowfullscreen' => array(),
		),
		'time' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
			'datetime' => array(),
			'content' => array(),
		),
	);

	
	$tags = array_merge($wp_post_allow_tag, $allowed_tags);

	return apply_filters( 'online_cv_resume_alowed_tags', $tags );
	
}


