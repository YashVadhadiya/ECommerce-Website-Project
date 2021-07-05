<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'online-cv-resume' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location?', 'online-cv-resume' ); ?></p>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
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
