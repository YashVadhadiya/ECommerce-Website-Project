<?php
/**
 * Admin Base HTML.
 *
 * @package CARTFLOWS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wcf-admin-header">
	<div class="wcf-container wcf-flex">
		<div class="wcf-admin-header__logo">
			<img class="wcf-admin-header__logo-image svg" src="<?php echo esc_url_raw( CARTFLOWS_URL . 'assets/images/cartflows-logo.svg' ); ?>" />
		</div>
		<div class="wcf-admin-header__breadcrumbs">
			<span><?php esc_attr_e( 'Generate More Leads & More Sales', 'cartflows' ); ?></span>
		</div>
		<div class="wcf-admin-header__links">
			<a target="_blank" class="wcf-help-links__item" title="Knowledge Base" href="//cartflows.com/docs/"><span class="dashicons dashicons-book"></span></a>
			<a target="_blank" class="wcf-help-links__item" title="Community" href="//facebook.com/groups/cartflows/"><span class="dashicons dashicons-groups"></span></a>
			<a target="_blank" class="wcf-help-links__item" title="Support" href="//cartflows.com/contact/"><span class="dashicons dashicons-sos"></span></a>
		</div>
	</div>
</div>
