<?php
/**
 * Search Bar Renderer
 *
 * @package Yext\Blocks
 */

namespace Yext\Blocks\SearchBar;

use Yext\Admin\Settings;

/**
 * Render Search Bar Block
 *
 * @param  array $atts Block Attributes
 * @return string       Block Markup
 */
function render( $atts ) {

	$settings            = Settings::localized_settings();
	$search_bar_settings = $settings['components']['search_bar'];

	$class  = 'yext-search-bar';
	$class .= isset( $atts['className'] ) ? ' ' . $atts['className'] : '';

	$placeholder_text = isset( $atts['placeholderText'] ) ? $atts['placeholderText'] : '';
	$submit_text      = isset( $atts['submitText'] ) ? $atts['submitText'] : '';
	$label_text       = isset( $atts['labelText'] ) ? $atts['labelText'] : '';

	$styles = [
		'--yxt-searchbar-text-color' => $atts['textColor'] ?? null,
		'--yxt-searchbar-text-font-size' => $atts['fontSize'] ? $atts['fontSize'] . 'px' : null,
		'--yxt-searchbar-text-font-weight' => $atts['fontWeight'] ?? null,
		'--yxt-searchbar-text-line-height' => $atts['lineHeight'] ?? null,
		'--yxt-searchbar-form-outline-color-base' => $atts['borderColor'] ?? null,
		'--yxt-searchbar-form-border-radius' => $atts['borderRadius'] ? $atts['borderRadius'] . 'px' : null,
		'--yxt-searchbar-form-background-color' => $atts['backgroundColor'] ?? null,
		'--yxt-searchbar-button-background-color-base' => $atts['buttonBackgroundColor'] ?? null,
		'--yxt-searchbar-button-background-color-hover' => $atts['buttonHoverBackgroundColor'] ?? null,
		'--yxt-autocomplete-background-color' => $atts['autocompleteBackgroundColor'] ?? null,
		// '--yxt-autocomplete-text-color' => $atts['autocompleteTextColor'],
		'--yxt-autocomplete-separator-color' => $atts['autocompleteSeparatorColor'] ?? null,
		'--yxt-autocomplete-option-hover-background-color' => $atts['autocompleteOptionHoverBackgroundColor'] ?? null,
		'--yxt-autocomplete-text-font-size' => $atts['autocompleteOptionFontSize'] ? $atts['autocompleteOptionFontSize'] . 'px' : null,
		'--yxt-autocomplete-text-font-weight' => $atts['autocompleteOptionFontWeight'] ?? null,
		'--yxt-autocomplete-text-line-height' => $atts['autocompleteOptionLineHeight'] ?? null,
		'--yxt-autocomplete-prompt-header-font-weight' => $atts['autocompleteHeaderFontWeight'] ?? null,
	];

	$filtered_styles = array_filter(
		array_map(
			function ( $key, $value ) {
				return ! empty( $value )
					? $key . ':' . $value
					: null;
			},
			array_keys( $styles ),
			$styles
		),
		function ( $value ) {
			return ! ! $value;
		}
	);

	// Start the output buffer for rendering
	ob_start();
	?>
	<div
		class="<?php echo esc_attr( $class ); ?>"
	<?php if ( ! empty( $placeholder_text ) ) : ?>
		data-placeholder-text="<?php echo esc_attr( $placeholder_text ); ?>"
	<?php endif; ?>
	<?php if ( ! empty( $submit_text ) ) : ?>
		data-submit-text="<?php echo esc_attr( $submit_text ); ?>"
	<?php endif; ?>
	<?php if ( ! empty( $label_text ) ) : ?>
		data-label-text="<?php echo esc_attr( $label_text ); ?>"
	<?php endif; ?>
	<?php if ( ! empty( $filtered_styles ) ) : ?>
		style="<?php echo esc_attr( implode( ';', $filtered_styles ) ); ?>"
	<?php endif; ?>
	></div>
	<?php

	return ob_get_clean();
}
