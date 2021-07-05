<?php
/* The Template to Render the Slider
*
*/

//Define all Variables.
if ( get_theme_mod('store_main_slider_enable' ) && is_front_page() ) : 

	$count_x = $count = get_theme_mod('store_main_slider_count');

		
		?>
		<div id="slider-bg" data-stellar-background-ratio="0.5">
			<div class="container">
				<div class="slider-container theme-default">
			            <div class="swiper-wrapper">
			            <?php
			            for ( $i = 1; $i <= $count; $i++ ) :
	
							$url = esc_url ( get_theme_mod('store_slide_url'.$i) );
							$img = esc_url ( get_theme_mod('store_slide_img'.$i) );
							$title = esc_html( get_theme_mod('store_slide_title'.$i) );
							$desc = esc_html( get_theme_mod('store_slide_desc'.$i) );
							 
							
							?>
							<div class="swiper-slide">
				            	<a href="<?php echo $url; ?>">
				            		<img src="<?php echo $img ?>" data-thumb="<?php echo $img ?>" title="<?php echo $title." - ".$desc ?>" />
				            	</a>
				            	<div class="slidecaption">
					                
					                <?php if ($title) : ?>
						                <div class="slide-title"><?php echo $title ?></div>
                                    <?php endif ?>
                                    <?php if ( $desc) : ?>
						                <div class="slide-desc"><span><?php echo $desc ?></span></div>
						            <?php endif; ?> 
								</div>
				            </div>
			             <?php endfor; ?>
			               
			            </div>
			            <div class="swiper-pagination swiper-pagination-white"></div>
 
						<div class="swiper-button-next slidernext swiper-button-white"></div>
						<div class="swiper-button-prev sliderprev swiper-button-white"></div>
			        </div>
			</div> 
		</div>
	<?php	
	
endif;	?>	   