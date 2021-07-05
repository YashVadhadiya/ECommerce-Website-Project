<?php
/**
 * Functions which enhance the theme layout by hooking into WordPress
 *
 * @package online_cv_resume
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists('online_cv_resume_aside_navigation') ):
	/**
	 * Aside Navigation
	 *
	 * @param     NUll
	 * @return    $html
	 */
	function online_cv_resume_aside_navigation( ) {
	?>
    	<button class="side-bar-icon" id="aside-nav-actions">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div id="aside-nav-wrapper">
        <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() || get_header_image() !="" ) { ?>
			<?php $header = ( get_header_image() != "" ) ? 'background-image: url('. esc_url( get_header_image() ).'); background-size:cover;' : ''; ?>
            <div class="profile-wrp">
                <div class="wp-header-image" style=" <?php echo esc_attr( $header );?>"></div>
                <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ): ?>
                <div class="my-photo"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php the_custom_logo(); ?></a></div>
                <?php endif;?>
            </div>
            <?php }?>
            <?php if ( function_exists( 'the_custom_logo' ) && !has_custom_logo() ): ?>
            	<h3 class="site-heading"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h3>
             <?php else : ?>   
             <h3 class="site-heading"> <?php bloginfo( 'name' ); ?></h3>
             <?php endif;?>
            <?php $description = get_bloginfo( 'description', 'display' );
                  if ( $description || is_customize_preview() ) : ?>
           		 <div class="site-subtitle"><?php echo esc_html( $description ); ?></div>
            <?php endif; ?>
            
            
            <?php
            wp_nav_menu( array(
                'theme_location'  => 'primary',
               
                'container'       => 'nav',
                'container_id'    => 'theme-menu-list',
                'menu_class'      => 'navbar-nav ml-auto',
             
            ) );
            ?>
            
        </div> <!-- /.aside-nav-wrapper -->
        
    
    <?php
	}
endif;


add_action('online_cv_resume_aside_common','online_cv_resume_aside_navigation',20);



if( !function_exists('online_cv_resume_aside_sidebar') ):
	/**
	 * Aside Sidebar
	 *
	 * @param     NUll
	 * @return    $sidebar widgets
	 */
	function online_cv_resume_aside_sidebar( ) {
	?>
        <button class="side-bar-icon" id="sidebar-actions">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <div class="sidewrapper sidenav">
        	<?php get_sidebar(); ?>
        </div>
    <?php
	}
endif;


add_action('online_cv_resume_aside_common','online_cv_resume_aside_sidebar',30);

/*
* ---------------------------------------------------------------
* --------------------------- CONTANIR -------------------------- 
* ---------------------------------------------------------------
*/

if( !function_exists('online_cv_resume_container_wrp_start') ):
	/**
	 * Container Div
	 *
	 * @param     NUll
	 * @return    $sidebar widgets
	 */
	function online_cv_resume_container_wrp_start( ) {
	?>
    <div id="main-page">
    	<?php if ( is_active_sidebar( 'hero' ) && ( is_home() && is_front_page() ) ) {
			dynamic_sidebar( 'hero' );	
		}?>
        <!-- Blog Details -->
        <section class="our-blog">
            <div class="main-wrapper-bg">
                <div class="container">
                    <div class="row">
    <?php
	}
endif;


add_action('online_cv_resume_container_hook_before','online_cv_resume_container_wrp_start',5);


if( !function_exists('online_cv_resume_container_wrp_end') ):
	/**
	 * Container Div end
	 *
	 * @param     NUll
	 * @return    $sidebar widgets
	 */
	function online_cv_resume_container_wrp_end( ) {
	?>
    			</div>
        	</div>
         </div>
       </section>
     </div>
    <?php
	}
endif;


add_action('online_cv_resume_container_hook_after','online_cv_resume_container_wrp_end',999);