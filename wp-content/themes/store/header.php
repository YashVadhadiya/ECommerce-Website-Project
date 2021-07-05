<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package store
 */
?>
<?php get_template_part('modules/header/head') ?>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'store' ); ?></a>
    <?php get_template_part('modules/header/jumbosearch') ?>
    <?php get_template_part('modules/header/top','bar') ?>
    <?php get_template_part('modules/header/masthead') ?>
	<!-- Smooth scrolling-->
    <div class="scroll-down">
        <a id="button-scroll-up" href="#colophon">
            <i class="fas fa-hand-point-down"></i>
        </a>
    </div>

    <?php get_template_part('framework/featured-components/slider', 'swiper'); ?>
    <?php if (class_exists('woocommerce')) : ?>
        <?php get_template_part('framework/featured-components/coverflow', 'product'); ?>
        <?php get_template_part('framework/featured-components/featured-promotional', 'product'); ?>
        <?php get_template_part('framework/featured-components/featured', 'products'); ?>
    <?php endif; ?>
    <?php get_template_part('framework/featured-components/coverflow', 'posts'); ?>
    <?php get_template_part('framework/featured-components/featured', 'posts'); ?>

	<div class="mega-container">
	
		<div id="content" class="site-content container">