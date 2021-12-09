<?php
/**
 * Search Results Renderer
 *
 * @package Yext\Blocks
 */

namespace Yext\Blocks\SearchResults;

/**
 * Render Search Results Block
 *
 * @param  array $atts Block Attributes
 * @return string       Block Markup
 */
function render( $atts ) {

	$url    = isset( $atts['url'] ) ? $atts['url'] : false;
	$class  = 'yext-search-results';
	$class .= isset( $atts['className'] ) ? ' ' . $atts['className'] : '';
	$class .= ! empty( $atts['align'] ) ? ' ' . $atts['align'] : '';

	if ( ! $url ) {
		return;
	}

	// Start the output buffer for rendering
	ob_start();
	?>
	<div class="<?php echo esc_attr( $class ); ?>">
		<iframe
			class="yext-search-results-iframe"
			src="<?php echo esc_url_raw( $url ); ?>"
			frameborder="0"
		></iframe>
	</div>
	<?php

	return ob_get_clean();
}
