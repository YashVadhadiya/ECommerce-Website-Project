<?php if (get_theme_mod('store_coverflow_enable') && is_front_page() ) : ?>
<div id="coverflow" class="container">
	<div class="swiper-container">
	        <div class="swiper-wrapper">
	        	 <?php
			        $args = array( 
			        	'post_type' => 'product',
			        	'posts_per_page' => esc_html( get_theme_mod('store_coverflow_pc',10) ), 
			        	'tax_query' => array(
								         array(
								            'taxonomy'      => 'product_cat',
								            'terms'         => esc_html( get_theme_mod('store_coverflow_cat',0) ),
								            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
								         )
					    )
			        );
			       
			        $loop = new WP_Query( $args );
			        while ( $loop->have_posts() ) : 
			        
			        	$loop->the_post(); 
			        	global $product; 
			        	
			        	if ( has_post_thumbnail() ) :
			        		$image_data = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID), 'shop_catalog' ); 
							$image_url = $image_data[0];
                        else:
                            $image_url = get_template_directory_uri()."/assets/images/placeholder2.jpg";
						endif;		
			        	
			        ?>
					
						<div class="swiper-slide" style="background-image:url(<?php echo esc_url( $image_url ); ?>)">
							<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
							<div class="product-details">
							<h3><?php the_title(); ?></h3>
							<span class="price"><?php echo $product->get_price_html(); ?></span>
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