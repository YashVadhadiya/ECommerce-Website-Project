<?php
/**
 * The template for displaying all pages.
 * Template Name: Full Width
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package madhat


 */

get_header(); ?>

    <div id="primary-mono" class="content-area col-md-12 page">
        <main id="main" class="site-main" role="main">

            <?php while ( have_posts() ) : the_post();?>
                <?php get_template_part( 'modules/content/content', 'page' ); ?>

                <?php
                // If comments are open or we have at least one comment, load up the comment template
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; // end of the loop. ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_footer(); ?>