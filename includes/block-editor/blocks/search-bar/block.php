<?php
/**
 * Search Bar Renderer
 *
 * @package Yext\Blocks
 */

namespace Yext\Blocks\SearchBar;

/**
 * Render Search Bar Block
 *
 * @param  array $atts Block Attributes
 * @return string       Block Markup
 */
function render( $atts ) {

	$background_color = isset( $atts['backgroundColor'] ) ? $atts['backgroundColor'] : false;
	$class            = 'yext-search-bar';
	$class           .= isset( $atts['className'] ) ? ' ' . $atts['className'] : '';
	$class           .= ! empty( $atts['align'] ) ? ' ' . $atts['align'] : '';

	// Start the output buffer for rendering
	ob_start();
	?>
	<div class="<?php echo esc_attr( $class ); ?>">
		// Frontend view here
	</div>
	<?php

	return ob_get_clean();
}
