<?php if (get_theme_mod('store_a_coverflow_enable') && is_front_page() ) : ?>
<div id="coverflow-posts" class="container">
	<div class="section-title title-font">
		<?php echo esc_html( get_theme_mod('store_a_coverflow_title','Featured Products') ); ?>
	</div>
	<div class="swiper-container-posts">
	        <div class="swiper-wrapper">
	        	 <?php
			        $args = array( 
			        	'post_type' => 'post',
			        	'posts_per_page' => esc_html( get_theme_mod('store_a_coverflow_pc',10) ), 
			        	'cat' => esc_html( get_theme_mod('store_a_coverflow_cat',0) ),
					    
			        );
			       
			        $loop = new WP_Query( $args );
			        while ( $loop->have_posts() ) : 
			        
			        	$loop->the_post(); 
			        	global $product; 
			        	
			        	if ( has_post_thumbnail() ) :
			        		$image_data = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID), 'store-sq-thumb' ); 
							$image_url = $image_data[0];
                        else:
                            $image_url = get_template_directory_uri()."/assets/images/placeholder2.jpg";
						endif;		
			        	
			        ?>
					
						<div class="swiper-slide" style="background-image:url(<?php echo esc_url( $image_url ); ?>)">
							<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
							<div class="product-details">
							<h3><?php the_title(); ?></h3>
							</div>
							</a>
						</div>
												
					 <?php endwhile; ?>
					 <?php wp_reset_query(); ?>	
	            
	        </div>
	        <!-- Add Pagination -->
	        
	    </div>
</div>
<?php endif; ?>