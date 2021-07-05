<?php
/*
** Template to Render Social Icons on Top Bar
*/
$social_style = get_theme_mod('store_social_icon_style_set','hvr-ripple-out');
for ($i = 1; $i < 7; $i++) :
	$social = get_theme_mod('store_social_'.$i);
	if ( ($social != 'none') && ($social != '') ) : ?>
	<a class="social-style <?php echo $social_style; ?>" href="<?php echo esc_url( get_theme_mod('store_social_url'.$i) ); ?>"><i class="fab fa-<?php echo $social; ?>"></i></a>
	<?php endif;

endfor; ?>