<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package online_cv_resume
 */

?>

<div data-aos="fade-up" id="post-<?php the_ID(); ?>" <?php post_class( array('col-md-12','aos-animate') ); ?> >

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
    
       	<?php
			/**
			* Hook - online_cv_resume_blog_loop_content_type.
			*
			* @hooked online_cv_resume_blog_loop_content_type - 10
			*/
			do_action( 'online_cv_resume_blog_loop_content_type' );
        ?>
      
    </div> <!-- /.blog-post -->
</div>
<!-- #post-<?php the_ID(); ?> -->
