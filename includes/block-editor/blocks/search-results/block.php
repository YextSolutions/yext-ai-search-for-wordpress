<?php
/**
 * Search Results Renderer
 *
 * @package Yext\Blocks
 */

namespace Yext\Blocks\SearchResults;

use \Yext\Admin\Settings;

/**
 * Render Search Results Block
 *
 * @param  array $atts Block Attributes
 * @return string       Block Markup
 */
function render( $atts ) {

	$url      = isset( $atts['url'] ) ? $atts['url'] : false;
	$class    = 'yext-search-results';
	$class   .= isset( $atts['className'] ) ? ' ' . $atts['className'] : '';
	$class   .= ! empty( $atts['align'] ) ? ' ' . $atts['align'] : '';
	$settings = Settings::get_settings();

	// Use Plugin Settings value when empty
	if ( ! $url && isset( $settings['plugin']['answers_iframe_url'] ) ) {
		$url = $settings['plugin']['answers_iframe_url'];
	}

	// Double check if there really is iFrame URL
	if ( ! $url ) {
		return;
	}

	// Start the output buffer for rendering
	ob_start();

	// phpcs:disable WordPress.WP.EnqueuedResources.NonEnqueuedScript
	?>
	<div id="answers-container" class="<?php echo esc_attr( $class ); ?>"></div>
	<script src="<?php echo esc_url_raw( $url ); ?>/iframe.js"></script>
	<?php
	// phpcs:enable WordPress.WP.EnqueuedResources.NonEnqueuedScript

	return ob_get_clean();
}
