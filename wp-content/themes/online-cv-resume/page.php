<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package online_cv_resume
 */

get_header();
?>
<?php
	/**
	* Hook - online_cv_resume_container_hook_before.
	*
	* @hooked online_cv_resume_container_wrp_start - 10
	*/
	do_action( 'online_cv_resume_container_hook_before' );
?>
	<div id="primary" class="content-area">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</div><!-- #primary -->
<?php
	/**
	* Hook - online_cv_resume_container_hook_after.
	*
	* @hooked online_cv_resume_container_wrp_end - 10
	*/
	do_action( 'online_cv_resume_container_hook_after' );
?>
<?php

get_footer();
