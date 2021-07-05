<?php
/**
 * CartFlows Admin Header.
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wcf-menu-page-header">
	<div class="wcf-container wcf-flex">
		<div class="wcf-title">
			<span class="screen-reader-text"><?php echo esc_attr( CARTFLOWS_NAME ); ?></span>
			<img class="wcf-logo" src="<?php echo esc_attr( CARTFLOWS_URL ) . 'assets/images/cartflows-logo.svg'; ?>" />
		</div>
		<div class="wcf-top-links">
			<?php
				esc_attr_e( 'Generate More Leads & More Sales', 'cartflows' );
			?>
		</div>
	</div>
</div>
