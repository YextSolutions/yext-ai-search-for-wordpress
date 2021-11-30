<?php
/**
 * Search bar preview HTML
 *
 * @package Yext
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="yext-preview-search-form">
	<div class="yext-preview-search-bar">
		<input type="text" placeholder="<?php esc_attr_e( 'Search....', 'yext' ); ?>" />
		<button type="submit" class="yext-preview-submit-button">
			<?php esc_html_e( 'Search', 'yext' ); ?>
		</button>
	</div>
	<div class="yext-preview-search-autocomplete-wrapper">
		<div class="yext-preview-search-autocomplete">
			<ul>
				<li><?php esc_html_e( 'Search results preview item.', 'yext' ); ?></li>
				<li><?php esc_html_e( 'Auto complete preview item.', 'yext' ); ?></li>
			</ul>
		</div>
	</div>
</div>
