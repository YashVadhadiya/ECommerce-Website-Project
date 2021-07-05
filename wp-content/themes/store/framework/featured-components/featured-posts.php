<?php if ( get_theme_mod('store_a_box_enable') && is_front_page() ) : ?>
<div id="featured-posts" class="container">
	<div class="col-md-4 col-sm-4">
	<div class="section-title title-font">
		<?php echo esc_html( get_theme_mod('store_a_slider_title','Featured Products') ); ?>
	</div>
	    <div class="fposts-container">
	        <div class="swiper-wrapper">
	            <?php
				        $args = array( 
			        	'post_type' => 'post',
			        	'posts_per_page' => get_theme_mod('store_a_slider_count',10),
			        	'cat'         => esc_html( get_theme_mod('store_a_slider_cat',0) ),
			        	);
				        $loop = new WP_Query( $args );
				        while ( $loop->have_posts() ) : 
				        
				        	$loop->the_post(); 
				        	global $product; 
				        	
				        	if ( has_post_thumbnail() ) :
				        		$image_data = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID), 'store-sq-thumb' ); 
								$image_url = $image_data[0];
                            else:
                                $image_url = get_template_directory_uri()."/assets/images/600x600.png";
							endif;		
				        	
				        ?>
						
							<div class="swiper-slide">
								<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
									<img src="<?php echo $image_url; ?>">
									<div class="product-details">
										<h3><?php the_title(); ?></h3>
									</div>
								</a>
								</div>
													
						 <?php endwhile; ?>
						 <?php wp_reset_query(); ?>	
		            
		        </div>
	        <!-- Add Pagination -->
	        
	        <div class="swiper-button-next sbncp swiper-button-white"></div>
        <div class="swiper-button-prev sbpcp swiper-button-white"></div>
	    </div>
	</div> 
	<!--col-md-4-ends-->
	
	<div class="col-md-8 col-sm-8">
	<div class="section-title title-font">
		<?php echo esc_html( get_theme_mod('store_a_box_title','Trending') ) ?>
	</div>
	    <div class="featured-grid-container">
	        <div class="fg-wrapper">
	            <?php
				        $args = array( 
			        	'post_type' => 'post',
			        	'posts_per_page' => 8, 
			        	'cat'  => esc_html( get_theme_mod('store_a_box_cat',0) ),
			        	'ignore_sticky_posts' => 1,
			        	);
				        $loop = new WP_Query( $args );
				        while ( $loop->have_posts() ) : 
				        
				        	$loop->the_post(); 
				        	global $product; 
				        	
				        	if ( has_post_thumbnail() ) :
				        		$image_data = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID), 'store-sq-thumb' ); 
								$image_url = $image_data[0];
                            else:
                                $image_url = get_template_directory_uri()."/assets/images/600x600.png";
							endif;		
				        	
				        ?>
						<div class="fg-item-container col-md-3 col-sm-3 col-xs-6">
							<div class="fg-item">
								<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
									<img src="<?php echo $image_url; ?>">
									<div class="product-details">
										<h3><?php the_title(); ?></h3>
									</div>
								</a>
								</div>
						</div>					
						 <?php endwhile; ?>
						 <?php wp_reset_query(); ?>	
						
		        </div>	        
	    </div>
	</div>     
</div>
<?php endif; ?>