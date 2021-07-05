<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package online_cv_resume
 */

?>

<div data-aos="fade-up" id="post-<?php the_ID(); ?>" <?php post_class( array('col-md-12') ); ?>>

    <div class="blog-post shadow-box">
		<?php
			/**
			* Hook - online_cv_resume_posts_blog_media.
			*
			* @hooked online_cv_resume_posts_blog_media - 10
			* @hooked online_cv_resume_posts_blog_media - 20
			* @hooked online_cv_resume_posts_blog_loop_title - 20
			*/
			do_action( 'online_cv_resume_posts_blog_media' );
        ?>
    
       <div class="entry-summary">
		<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
      
    </div> <!-- /.blog-post -->
</div>

