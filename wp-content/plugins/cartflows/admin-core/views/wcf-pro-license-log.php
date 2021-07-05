<?php
/**
 * CartFlows Pro License Debug Log HTML.
 *
 * @package CARTFLOWS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * File.
 *
 * @file
 * Header file.
 */
require_once CARTFLOWS_DIR . 'includes/admin/cartflows-admin-header.php';
?>

<div class="wcf-debug-page-content wcf-clear">
	<div class="wcf-log__section wcf-license-log__section">

		<!-- CartFlows Pro license debug log -->
			<div class="log-viewer-select">
				<h2 class="log-viewer--title">
					<span><?php esc_html_e( 'License debug log', 'cartflows' ); ?></span>
				</h2>	
			</div>
			<div class="log-viewer">
				<form method="post" class="wrap wcf-clear" action="" >
					<div class="form-wrap">
						<div class="wcf-license-row wcf-license-agrs">
							<p><b><u><?php esc_html_e( 'License Arguments:', 'cartflows' ); ?></u></b></p>
							<?php
								echo '<pre>';
								print_r( $args ); // phpcs:ignore
								echo '</pre>';
							?>
						</div>

						<hr>

						<div class="wcf-license-row wcf-license-call">
							<p><b><u><?php esc_html_e( 'License Call:', 'cartflows' ); ?></u></b></p>
							<a href="<?php echo $target_url; ?>" target="_blank" style="overflow-wrap: break-word;"><?php echo $target_url; ?></a>
						</div>

						<hr>

						<div class="wcf-license-row wcf-license-response" style="overflow-wrap: break-word;">
							<p><b><u><?php esc_html_e( 'License API Response:', 'cartflows' ); ?></u></b></p>
							<?php
								echo "<pre style='white-space: pre-wrap;'>";
								print_r( $response ); // phpcs:ignore
								echo '</pre>';
							?>
						</div>
					</div>
				</form>
			</div>
		<!-- CartFlows Pro license debug log -->

	</div>
</div>
