<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package online_cv_resume
 */

get_header();
?>
<div id="main-page">
<section class="our-blog">
  <div class="container">
    <div class="main-wrapper-bg pd-20">
      <div class="row">
            <div class="col-md-12">
            	<div class="p-20">
				<?php
                    the_archive_title( '<h3 class="blog-title entry-heading">', '</h3>' );
                    the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
                </div>
            </div>
        </div>
    </div>
 </div>
</section>
</div>
<?php
	/**
	* Hook - online_cv_resume_container_hook_before.
	*
	* @hooked online_cv_resume_container_wrp_start - 10
	*/
	do_action( 'online_cv_resume_container_hook_before' );
?>

<?php
if ( have_posts() ) :

	/* Start the Loop */
	while ( have_posts() ) :
		the_post();

		/*
		 * Include the Post-Type-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
		 */
		get_template_part( 'template-parts/content', get_post_type() );

	endwhile;

	//the_posts_navigation();
	do_action('online_cv_resume_posts_loop_navigation');
	
else :

	get_template_part( 'template-parts/content', 'none' );

endif;
?>

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
