<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package online_cv_resume
 */

?>
</div> <!-- #main-page -->
 <div class="footer-copyright-wrp">
			<?php
				/* translators: 1: Current Year, 2: Blog Name 3: Theme Developer 4: WordPress. */
				printf( esc_html__( 'Copyright &copy; %1$s %2$s All Right Reserved. %3$s Theme By %4$s . Proudly powered by %5$s .', 'online-cv-resume' ), esc_attr( date( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ),'<a href="https://wordpress.org/themes/online-cv-resume/">Online CV Resume</a>', '<a href="https://edatastyle.com/product/online-cv-resume/">eDataStyle</a>', '<a href="https://wordpress.org">WordPress</a>' );
            ?>
        </div>	  
<?php wp_footer(); ?>

</body>
</html>
