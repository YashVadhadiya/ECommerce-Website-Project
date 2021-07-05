<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*  
Title: Home Page Hero
Class: online-cv-resume-section
Width: 720
*/

$wrp_style  = '';
if( isset ( $settings['bg_image'] )  ){
$bg_image_ids = $settings['bg_image'];
if(  count( $bg_image_ids ) > 0 ){
	$bg_url = wp_get_attachment_url( $bg_image_ids[0] );
	$wrp_style = 'background:url('.esc_url( $bg_url ).') no-repeat center  center; background-size:cover;';
}}
?>
<div class="hero-section" style=" <?php echo esc_attr( $wrp_style );?> ">
	<div class="text-align-center">
    	<h1 class="author-name"><?php echo esc_html($settings['heading']);?></h1>
        <h3><?php echo esc_html($settings['heading-2nd']);?></h3>
    
		<?php if ( isset( $settings['hero_btn_group'] ) && count( $settings['hero_btn_group'] ) >0  ) :
			 foreach ( $settings['hero_btn_group'] as $val) : 
		?> 
        <a href="<?php echo esc_url($val['btn_link']);?>" class=" theme-btn"><span><?php echo esc_html($val['btn_text']);?></span></a>
        <?php endforeach; endif;?>
        
      
    </div>
</div>

