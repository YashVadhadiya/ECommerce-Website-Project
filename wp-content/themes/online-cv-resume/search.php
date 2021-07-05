<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
                <h3 class="blog-title entry-heading">
				<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'online-cv-resume' ), '<span>' . get_search_query() . '</span>' );
					?>
                    </h3>
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
	<div id="primary" class="content-area">

		<?php if ( have_posts() ) : ?>
			
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
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
