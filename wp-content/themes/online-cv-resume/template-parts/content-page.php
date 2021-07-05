<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package online_cv_resume
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class( array('col-md-12','entry-single-content-wrp') ); ?>>

   
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
    	<div class="entry-content blog-details">
       <?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'online-cv-resume' ),
			'after'  => '</div>',
		) );
		?>
        
        <?php if ( get_edit_post_link() ) : ?>
		<div class="entry-edit">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'online-cv-resume' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</div ><!-- .entry-footer -->
	<?php endif; ?>
        </div>
      
   
</div>
<!-- #post-<?php the_ID(); ?> -->
