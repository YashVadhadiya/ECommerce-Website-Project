<?php
/**
 * Checkout design metabox markup
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$active_tab = 'wcf-checkout-style';

$tab_array = array(
	array(
		'title' => __( 'Shortcodes', 'cartflows' ),
		'id'    => 'wcf-checkout-shortcodes',
		'class' => 'wcf-checkout-shortcodes' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
		'icon'  => 'dashicons-editor-code',
	),
	array(
		'title' => __( 'Checkout Design', 'cartflows' ),
		'id'    => 'wcf-checkout-style',
		'class' => 'wcf-checkout-style' === $active_tab ? 'wcf-tab wp-ui-text-highlight active' : 'wcf-tab',
		'icon'  => 'dashicons-admin-customizer',
	),
);

$option_tabs = apply_filters( 'cartflows_checkout_design_settings_tabs', $tab_array, $active_tab );

?>
<div class="wcf-checkout-design-table wcf-metabox-wrap widefat">
	<div class="wcf-table-container">
		<?php echo wcf_get_page_builder_notice(); ?>
		<div class="wcf-column-left">
			<div class="wcf-tab-wrapper">
				<?php foreach ( $option_tabs as $key => $option_tab ) { ?>
					<div class="<?php echo esc_attr( $option_tab['class'] ); ?>" data-tab="<?php echo esc_attr( $option_tab['id'] ); ?>">
						<span class="dashicons <?php echo esc_attr( $option_tab['icon'] ); ?>"></span>
						<span class="wcf-tab-title"><?php echo esc_html( $option_tab['title'] ); ?></span>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="wcf-column-right">
			<?php
				$this->design_tab_shortcodes( $options, $post_id );
				$this->design_tab_style( $options, $post_id );
				do_action( 'cartflows_checkout_design_tabs_content', $options, $post_id );
				$this->right_column_footer( $options, $post_id );
			?>
		</div>
	</div>
</div>

<?php
