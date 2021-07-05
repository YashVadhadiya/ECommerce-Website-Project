<?php
/**
 * Functions hooked to post page.
 *
 * @package online_cv_resume
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 if ( ! function_exists( 'online_cv_resume_posts_formats_thumbnail' ) ) :

	/**
	 * Post formats thumbnail.
	 *
	 * @since 1.0.0
	 */
	function online_cv_resume_posts_formats_thumbnail() {
		$formats = ( get_post_format(get_the_ID()) != "" ) ? get_post_format(get_the_ID()) : 'image' ;
		$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
		
	?>
		<?php 
        if ( has_post_thumbnail() ) :
				echo '<div class="article-img post-top-image formats-image"><span class="post-format-icon"><i class="dashicons dashicons-format-image"></i></span>';
        ?>
        	<div class="img-wrp">
            	<?php if( is_single() ){ $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id ); ?>
                	<a href="<?php echo esc_url( $post_thumbnail_url );?>" class="image-popup"><?php the_post_thumbnail('full');?></a>
                <?php }else{ ?>
				<?php the_post_thumbnail('full');?>
                <?php }?>
            </div>
            
         <?php 	
		 if( !is_single() ){
		 	echo '<a href="'.esc_url( get_permalink( get_the_ID() ) ).'" class="article-link"><i class="dashicons dashicons-arrow-right-alt"></i></a>';
		 }
		 
		echo '</div>'; ?>   
        
        
				
        <?php endif;?>  
	<?php
	}

endif;
add_action( 'online_cv_resume_posts_formats_thumbnail', 'online_cv_resume_posts_formats_thumbnail' );


if ( ! function_exists( 'online_cv_resume_posts_formats_video' ) ) :

	/**
	 * Post Formats Video.
	 *
	 * @since 1.0.0
	 */
	function online_cv_resume_posts_formats_video() {
	
		$content = apply_filters( 'the_content', get_the_content(get_the_ID()) );
		$video = false;
		// Only get video from the content if a playlist isn't present.
		if ( false === strpos( $content, 'wp-playlist-script' ) ) {
			$video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
		}
		
		
			// If not a single post, highlight the video file.
			
			if ( ! empty( $video ) ) :
				echo '<div class="article-img post-top-image formats-video"><span class="post-format-icon"><i class="dashicons dashicons-format-video"></i></span>';
					if( isset( $video[0] ) ) :
					echo '<div class="blog-media img-wrp"><div class="entry-video embed-responsive embed-responsive-16by9">';
						echo wp_kses( $video[0], online_cv_resume_alowed_tags() );
					echo '</div></div>';
					endif;
				if( !is_single() ){
					echo '<a href="'.esc_url( get_permalink( get_the_ID() ) ).'" class="article-link"><i class="dashicons dashicons-arrow-right-alt"></i></a>';
				}
				echo '</div>';
			else: 
				do_action('online_cv_resume_posts_formats_thumbnail');	
			endif;
		
		
	 }

endif;
add_action( 'online_cv_resume_posts_formats_video', 'online_cv_resume_posts_formats_video' ); 


if ( ! function_exists( 'online_cv_resume_posts_formats_audio' ) ) :

	/**
	 * Post Formats audio.
	 *
	 * @since 1.0.0
	 */
	function online_cv_resume_posts_formats_audio() {
		$content = apply_filters( 'the_content', get_the_content() );
		$audio = false;
	
		// Only get audio from the content if a playlist isn't present.
		if ( false === strpos( $content, 'wp-playlist-script' ) ) {
			$audio = get_media_embedded_in_content( $content, array( 'audio' ) );
		}
	
		
		
	
		// If not a single post, highlight the audio file.
		if ( ! empty( $audio ) ) :
		
			foreach ( $audio as $audio_html ) {
				if ( has_post_thumbnail() ) :
				
				echo '<div class="article-img post-top-image formats-video"><span class="post-format-icon"><i class="dashicons dashicons-format-video"></i></span>';
				
					$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
					$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
					echo '<div class="blog-media-bg img-wrp" style="background: url(\''.esc_url( $post_thumbnail_url ).'\') no-repeat center center; background-size:cover; -webkit-background-size:cover; -moz-background-size:cover;">';
						echo '<span class="vertical-center">'.wp_kses( $audio_html, online_cv_resume_alowed_tags() ).'</span>';
					echo '</div>';
					
					if( !is_single() ){
					echo '<a href="'.esc_url( get_permalink( get_the_ID() ) ).'" class="article-link"><i class="dashicons dashicons-arrow-right-alt"></i></a>';
				}
				echo '</div>';
				else:
					echo '<div class="blog-media img-wrp">';
					
					echo wp_kses( $audio_html, online_cv_resume_alowed_tags() );
					echo '</div>';	
				endif;
				
				
			}
		else: 
			do_action('online_cv_resume_posts_formats_video');	
		endif;
	
		
	 }

endif;
add_action( 'online_cv_resume_posts_formats_audio', 'online_cv_resume_posts_formats_audio' ); 

add_filter( 'use_default_gallery_style', '__return_false' );


if ( ! function_exists( 'online_cv_resume_posts_formats_gallery' ) ) :

	/**
	 * Post Formats gallery.
	 *
	 * @since 1.0.0
	 */
	function online_cv_resume_posts_formats_gallery() {
		
		if ( get_post_gallery() ) :
	
		
		echo '<div class="article-img formats-gallery">  <span class="post-format-icon"><i class="dashicons dashicons-format-gallery"></i></span>';
		
			echo '<div class="theme-own-carousel owlGallery img-wrp">';
				echo  wp_kses( get_post_gallery(), online_cv_resume_alowed_tags() );
			echo '<div class="clearfix"></div></div>';
			
			
			if( !is_single() ){
					echo '<a href="'.esc_url( get_permalink( get_the_ID() ) ).'" class="article-link"><i class="dashicons dashicons-arrow-right-alt"></i></a>';
				}
				echo '</div>';
		else: 
			do_action('online_cv_resume_posts_formats_thumbnail');	
		endif;	
	
	 }

endif;
add_action( 'online_cv_resume_posts_formats_gallery', 'online_cv_resume_posts_formats_gallery' ); 




if ( ! function_exists( 'online_cv_resume_posts_formats_header' ) ) :

	/**
	 * Post online_cv_resume_posts_blog_media
	 *
	 * @since 1.0.0
	 */
	function online_cv_resume_posts_blog_media() {
		$formats = get_post_format(get_the_ID()) ;
		
			switch ( $formats ) {
				default:
					do_action('online_cv_resume_posts_formats_thumbnail');
				break;
				case 'gallery':
					do_action('online_cv_resume_posts_formats_gallery');
				break;
				case 'audio':
					do_action('online_cv_resume_posts_formats_audio');
				break;
				case 'video':
					do_action('online_cv_resume_posts_formats_video');
				break;
			} 
		
		
	 }

endif;

          
add_action( 'online_cv_resume_posts_blog_media', 'online_cv_resume_posts_blog_media' ); 






if ( ! function_exists( 'online_cv_resume_posts_loop_navigation' ) ) :

	/**
	 * Post Posts Loop Navigation
	 *
	 * @since 1.0.0
	 */
	function online_cv_resume_posts_loop_navigation() {
		
		 $type = get_theme_mod( 'loop_navigation_type', 'default' );
		
		if( $type == 'default' ):
			$args = array (
			   'prev_text'          => '<span>'. esc_html__('Previous Posts','online-cv-resume').'</span>',
			   'next_text'          =>  '<span>'.esc_html__('Next Posts','online-cv-resume').'</span>',
			);
			echo '<div class="pagination-custom">';
				the_posts_navigation( $args );
			echo '</div>';
		else:
		
			echo '<div class="pagination-custom">';
			the_posts_pagination( array(
				'format' => '/page/%#%',
				'type' => 'list',
				'mid_size' => 2,
				'prev_text' => esc_html__( 'Previous', 'online-cv-resume' ),
				'next_text' => esc_html__( 'Next', 'online-cv-resume' ),
				'screen_reader_text' => esc_html__( '&nbsp;', 'online-cv-resume' ),
			) );
		echo '</div>';
		endif;
	}

endif;
add_action( 'online_cv_resume_posts_loop_navigation', 'online_cv_resume_posts_loop_navigation', 11 ); 




if ( ! function_exists( 'online_cv_resume_single_post_navigation' ) ) :

	/**
	 * Post Single Posts Navigation 
	 *
	 * @since 1.0.0
	 */
	function online_cv_resume_single_post_navigation( ) {
		
		$prevPost = get_previous_post(true);
		$nextPost = get_next_post(true);
		if( $prevPost || $nextPost) :
		echo '<div class="container single-prev-next"><div class="row ">';
		if( $prevPost ) :
			echo '<div class="col-md-6 col-sm-6 row">';
				$prevthumbnail = get_the_post_thumbnail($prevPost->ID, array(40,40) );
				echo '<div class="col-sm-2">';
				previous_post_link('%link',$prevthumbnail , TRUE); 
				echo '</div>';
				echo '<div class="text col-sm-10"><h6>'.esc_html__('Previous Article','online-cv-resume').'</h6>';
					previous_post_link('%link',"<span>%title</span>", TRUE); 
				echo '</div>';
				
			echo '</div>';
			
		endif;
		
		
		if( $nextPost ) : 
			echo '<div class="col-md-6 col-sm-6  text-right row">';
				$nextthumbnail = get_the_post_thumbnail($nextPost->ID, array(40,40) );
				
				echo '<div class="text col-sm-10"><h6>'.esc_html__('Next Article','online-cv-resume').'</h6>';
					next_post_link('%link',"<span>%title</span>", TRUE);
				echo '</div>';
				
				echo '<div class="col-sm-2 text-right">';
				next_post_link('%link',$nextthumbnail, TRUE);
				echo '</div>';
				
			echo '</div>';
			
		endif;
		echo '</div></div>';
		
		endif;
	} 

endif;
add_action( 'online_cv_resume_single_posts_footer', 'online_cv_resume_single_post_navigation', 30 ); 


if( ! function_exists( 'online_cv_resume_blog_loop_content_type' ) && ! is_admin() ) :

    /**
    
     *
     * @since  1.0.0
     *
     * @param $type
     * @return html
     */
    function online_cv_resume_blog_loop_content_type( $type =  'full-content' ){
      
  		
        if ( $type === 'full-content' ) {
			$content = preg_replace("/<embed[^>]+>/i", "", get_the_content() , 1);
			echo  wp_kses( strip_shortcodes( $content ), online_cv_resume_alowed_tags() );
        }else{
			the_excerpt();
		}

        

    }

endif; 
add_action( 'online_cv_resume_blog_loop_content_type', 'online_cv_resume_blog_loop_content_type', 10 ); 




if( ! function_exists( 'online_cv_resume_read_more_link' ) ) :
	/**
	* Adds custom Read More.
	*
	*/
	function online_cv_resume_read_more_link( $more  ) {
		
		return sprintf( '<div class="more-link">
             <a href="%1$s" class="read-more">%2$s<i class="fa fa-fw fa-long-arrow-right"></i></a>
        </div>',
            get_permalink( get_the_ID() ),
			apply_filters( 'online_cv_resume_read_more_text',  esc_html__( 'Read More', 'online-cv-resume' ) )
        );
		
	}
	add_filter( 'the_content_more_link', 'online_cv_resume_read_more_link' );
endif;

if( ! function_exists( 'online_cv_resume_excerpt_more' ) ) :
	/**
	 * Filter the "read more" excerpt string link to the post.
	 *
	 * @param string $more "Read more" excerpt string.
	 * @return string (Maybe) modified "read more" excerpt string.
	 */
function online_cv_resume_excerpt_more( $more ) {
    if ( ! is_single() ) {
        $more = sprintf( '<div class="more-link">
             <a href="%1$s" class="read-more">%2$s<i class="fa fa-caret-right"></i></a>
        </div>',
            get_permalink( get_the_ID() ),
            esc_html__( 'Read More', 'online-cv-resume' )
        );
		
    }
    return $more;
}
add_filter( 'excerpt_more', 'online_cv_resume_excerpt_more' );

endif;


if ( ! function_exists( 'online_cv_resume_posts_loop_meta_info' ) ) :

	/**
	 * Post Posts Loop meta info
	 *
	 * @since 1.0.0
	 */
	function online_cv_resume_posts_loop_meta_info() {
		?>
        <ul class="meta-info">
            <?php echo ( function_exists('online_cv_resume_posted_by') ) ? wp_kses(  online_cv_resume_posted_by() , online_cv_resume_alowed_tags() ) : '';?>
            <?php echo ( function_exists('online_cv_resume_posted_on') ) ? wp_kses(  online_cv_resume_posted_on() , online_cv_resume_alowed_tags() ) : '';?>
            
        </ul>
        <?php
	}

endif;
add_action( 'online_cv_resume_posts_blog_media', 'online_cv_resume_posts_loop_meta_info', 20 ); 

if ( ! function_exists( 'online_cv_resume_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function online_cv_resume_posted_on() {
		if ( 'post' === get_post_type() ) {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			}
	
			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() )
			);
	
			$posted_on = sprintf(
				/* translators: %s: post date. */
				esc_html_x( 'Posted on %s', 'post date', 'online-cv-resume' ),
				'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
			);
	
			echo '<li><span class="posted-on">' . $posted_on . '</span></li>'; // WPCS: XSS OK.
			
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'online-cv-resume' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<li><span class="cat-links">' . esc_html__( 'Posted in %1$s', 'online-cv-resume' ) . '</span></li>', $categories_list ); // WPCS: XSS OK.
			}
		}

	}
endif;

if ( ! function_exists( 'online_cv_resume_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function online_cv_resume_posted_by() {
		if ( 'post' === get_post_type() ) {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'By %s', 'post author', 'online-cv-resume' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<li><span class="byline"> ' . $byline . '</span></li>'; // WPCS: XSS OK.
		}

	}
endif;


if ( ! function_exists( 'online_cv_resume_posts_blog_heading_title' ) ) :

	/**
	 * Post Posts Loop meta info
	 *
	 * @since 1.0.0
	 */
	function online_cv_resume_posts_blog_heading_title() {
		if ( is_singular() ) :
			the_title( '<h3 class="blog-title entry-heading">', '</h3>' );
		else :
			the_title( '<h3 class="blog-title entry-heading"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		endif;
	}

endif;
add_action( 'online_cv_resume_posts_blog_media', 'online_cv_resume_posts_blog_heading_title', 20 ); 




if ( ! function_exists( 'shopstore_walker_comment' ) ) : 
	/**
	 * Implement Custom Comment template.
	 *
	 * @since 1.0.0
	 *
	 * @param $comment, $args, $depth
	 * @return $html
	 */
	  
	function online_cv_resume_walker_comment($comment, $args, $depth) {
		
		?>
		<li <?php comment_class( empty( $args['has_children'] ) ? 'comment shift' : 'comment' ) ?> id="comment-<?php comment_ID() ?>">
        
            <div class="single-comment clearfix">
				 <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, 80,'','', array('class' => 'float-left') ); ?>
                <div class="comment float-left">
                    <h6><?php echo get_comment_author_link();?></h6>
                    <div class="date"> 
                        <?php
                            /* translators: 1: date, 2: time */
                            printf( esc_html__('%1$s at %2$s', 'online-cv-resume' ), get_comment_date(),  get_comment_time() ); 
                        ?>
                    </div>
                    
                    <div class="reply"> <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
                            
                   
                    <p><?php comment_text(); ?></p>
                </div>
            </div>
    
			<div class="clearfix"></div>
	   </li>
       <?php
	}
	
	
endif;

if ( ! function_exists( 'shopstore_walker_comment' ) ) : 
	/**
	 * @since 1.0.0
	 *
	 */
	function online_cv_resume_move_comment_field_to_bottom( $fields ) {
		
		$comment_field = $fields['comment'];
		$cookies_field = $fields['cookies'];
		
		unset( $fields['comment'] );
		unset( $fields['cookies'] );
		
		$fields['comment'] = $comment_field;
		$fields['cookies'] = $cookies_field;
		
		return $fields;
	}
	 
	add_filter( 'comment_form_fields', 'online_cv_resume_move_comment_field_to_bottom' );

endif;


if ( ! function_exists( 'online_cv_resume_single_posts_tag' ) ) : 
	/**
	 * @since 1.0.0
	 *
	 */
	function online_cv_resume_single_posts_tag( ) {
	   if ( 'post' === get_post_type() ) {
		   echo '<div class="bottom-content clearfix">';
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('<ul class="tag-meta float-left"><li>','</li><li>','</li></ul>');
			if ( $tags_list ) {
				echo '<i class="tag-icon fa fa-tag"></i>';
				echo wp_kses(  $tags_list , online_cv_resume_alowed_tags() );
			}
			
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
				'<span class="edit-link float-right">',
				'</span>'
			);
		  echo '</div>';	
		}
	}
	 
	add_filter( 'online_cv_resume_single_posts_footer', 'online_cv_resume_single_posts_tag' );

endif;
 

 