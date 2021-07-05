<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package online_cv_resume
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="main-page-wrapper">

<?php
	/**
	* Hook - online_cv_resume_aside_common.
	*
	* @hooked online_cv_resume_body_loader - 10
	* @hooked online_cv_resume_aside_navigation - 20
	*/
	do_action( 'online_cv_resume_aside_common' );
?>
