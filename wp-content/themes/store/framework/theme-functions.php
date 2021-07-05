<?php
/*
 * @package store, Copyright Rohit Tripathi, rohitink.com
 * This file contains Custom Theme Related Functions.
 */
/*
 * @package madhat, Copyright Rohit Tripathi, rohitink.com
 * This file contains Custom Theme Related Functions.
 */
//Import Admin Modules
require get_template_directory() . '/framework/admin_modules/register_styles.php';
require get_template_directory() . '/framework/admin_modules/register_widgets.php';
require get_template_directory() . '/framework/admin_modules/theme_setup.php';
require get_template_directory() . '/framework/admin_modules/admin_styles.php';

 
class Store_Menu_With_Description extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$fontIcon = ! empty( $item->attr_title ) ? ' <i class="fa ' . esc_attr( $item->attr_title ) .'">' : '';
		$attributes = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>'.$fontIcon.'</i>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '<br /><span class="menu-desc">' . $item->description . '</span>';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
	}
}

/*
 * Pagination Function. Implements core paginate_links function.
 */
function store_pagination() {
	global $wp_query;
	$big = 12345678;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
	            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	            echo '<div class="pagination"><div><ul>';
	            echo '<li><span>'. $paged . ' of ' . $wp_query->max_num_pages .'</span></li>';
	            foreach ( $page_format as $page ) {
	                    echo "<li>$page</li>";
	            }
	           echo '</ul></div></div>';
	 }
}

/*
** Customizer Controls 
*/
if (class_exists('WP_Customize_Control')) {
	class WP_Customize_Category_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select &mdash;', 'store' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );
 
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }

    class Store_Skin_Chooser extends WP_Customize_Control{
        public $type = 'skins';

        public function render_content(){
            ?>

            <span class="customize-control-title">
            <?php echo esc_html( $this->label ); ?>
            </span>

            <?php if($this->description){ ?>
                <span class="description customize-control-description">
            	<?php echo wp_kses_post($this->description); ?>
            </span>
            <?php } ?>

            <?php $name = '_customize-skin-' . $this->id;
            foreach ($this->choices as $key=>$value) { ?>
                <label>
                    <input type="radio" class="custom_skin_control" style="background: <?php echo $key; ?>"  value="<?php echo esc_attr($value); ?>" <?php $this->link(); ?> name="<?php echo esc_attr( $name ); ?>" <?php checked( $this->value(), $value ); ?>/>
                </label>
            <?php }
        }
    }

} 

if ( class_exists('WP_Customize_Control') && class_exists('woocommerce') ) {
	class WP_Customize_Product_Category_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select &mdash;', 'store' ),
                    'option_none_value' => '0',
                    'taxonomy'          => 'product_cat',
                    'selected'          => $this->value(),
                )
            );
 
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }
}    
if (class_exists('WP_Customize_Control')) {
	class WP_Customize_Upgrade_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {
             printf(
                '<label class="customize-control-upgrade"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $this->description
            );
        }
    }
}

/*
** Function to check if Sidebar is enabled on Current Page 
*/

function store_load_sidebar() {
	$load_sidebar = true;
	if ( get_theme_mod('store_disable_sidebar') ) :
		$load_sidebar = false;
	elseif( get_theme_mod('store_disable_sidebar_home') && is_home() )	:
		$load_sidebar = false;
	elseif( get_theme_mod('store_disable_sidebar_front') && is_front_page() ) :
		$load_sidebar = false;
	endif;
	
	return  $load_sidebar;
}

/*
**	Determining Sidebar and Primary Width
*/
function store_primary_class() {
	$sw = esc_html( get_theme_mod('store_sidebar_width',4));
	$class = "col-md-".(12-$sw);
	
	if ( !store_load_sidebar() ) 
		$class = "col-md-12";
	
	echo $class;
}
add_action('store_primary-width', 'store_primary_class');

function store_secondary_class() {
	$sw = esc_html(get_theme_mod('store_sidebar_width',4));
	$class = "col-md-".$sw;
	
	echo $class;
}
add_action('store_secondary-width', 'store_secondary_class');


/*
**	Helper Function to Convert Colors
*/
function store_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}
function store_fade($color, $val) {
	return "rgba(".store_hex2rgb($color).",". $val.")";
}


/*
** Function to Get Theme Layout 
*/
function store_get_blog_layout(){
	$ldir = 'framework/layouts/content';
	if (get_theme_mod('store_blog_layout') ) :
		get_template_part( $ldir , get_theme_mod('store_blog_layout') );
	else :
		get_template_part( $ldir ,'grid');	
	endif;	
}
add_action('store_blog_layout', 'store_get_blog_layout');

/*
** Function to Set Main Class 
*/
function store_get_main_class(){
	
	$layout = esc_html(get_theme_mod('store_blog_layout'));
	if (strpos($layout,'store') !== false) {
	    	echo 'store-main';
	}		
}
add_action('store_main-class', 'store_get_main_class');

/*
** Load WooCommerce Compatibility FIle
*/
if ( class_exists('woocommerce') ) :
	require get_template_directory() . '/framework/woocommerce.php';
endif;


/*
** Load Custom Widgets
*/

require get_template_directory() . '/framework/widgets/recent-posts.php';


/**
 *	Setting up a PHP constant for use in WP Forms Lite Plugin
**/


if ( ! defined( 'WPFORMS_SHAREASALE_ID' ) ) {
	define( 'WPFORMS_SHAREASALE_ID', '1802605' );
}