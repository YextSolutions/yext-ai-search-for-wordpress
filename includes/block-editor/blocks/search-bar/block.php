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

	$data_attrs = [
		'data-placeholder-text' => $placeholder_text,
		'data-submit-text'      => $submit_text,
		'data-label-text'       => $label_text,
	];

	$styles = [
		'--yxt-searchbar-text-color' => $atts['textColor'] ?? $search_bar_settings['color'],
		'--yxt-searchbar-text-font-size' => $atts['fontSize'] . 'px' ?? $search_bar_settings['font_size'],
		'--yxt-searchbar-text-font-weight' => $atts['fontWeight'] ?? $search_bar_settings['font_weight'],
		'--yxt-searchbar-text-line-height' => $atts['lineHeight'] ?? $search_bar_settings['line_height'],
		'--yxt-searchbar-form-outline-color-base' => $atts['borderColor'] ?? $search_bar_settings['border_color'],
		'--yxt-searchbar-form-border-radius' => $atts['borderRadius'] . 'px' ?? $search_bar_settings['border_radius'],
		'--yxt-searchbar-form-background-color' => $atts['backgroundColor'] ?? $search_bar_settings['background_color'],
		'--yxt-searchbar-button-background-color-base' => $atts['buttonBackgroundColor'] ?? $search_bar_settings['button']['background_color'],
		'--yxt-searchbar-button-background-color-hover' => $atts['buttonHoverBackgroundColor'] ?? $search_bar_settings['button']['hover_background_color'],
		'--yxt-autocomplete-background-color' => $atts['autocompleteBackgroundColor'] ?? $search_bar_settings['autocomplete']['background_color'],
		// '--yxt-autocomplete-text-color' => $atts['autocompleteTextColor'] ?? $search_bar_settings['autocomplete']['text_color'],
		'--yxt-autocomplete-separator-color' => $atts['autocompleteSeparatorColor'] ?? $search_bar_settings['autocomplete']['separator_color'],
		'--yxt-autocomplete-option-hover-background-color' => $atts['autocompleteOptionHoverBackgroundColor'] ?? $search_bar_settings['autocomplete']['option_hover_background_color'],
		'--yxt-autocomplete-text-font-size' => $atts['autocompleteOptionFontSize'] . 'px' ?? $search_bar_settings['autocomplete']['font_size'],
		'--yxt-autocomplete-text-font-weight' => $atts['autocompleteOptionFontWeight'] ?? $search_bar_settings['autocomplete']['font_weight'],
		'--yxt-autocomplete-text-line-height' => $atts['autocompleteOptionLineHeight'] ?? $search_bar_settings['autocomplete']['line_height'],
		'--yxt-autocomplete-prompt-header-font-weight' => $atts['autocompleteHeaderFontWeight'] ?? $search_bar_settings['autocomplete']['header_font_weight'],
	];

	$filtered_attrs = array_map(
		function ( $key, $value ) {
			return ! empty( $value )
				? $key . '="' . $value . '"'
				: null;
		},
		array_keys( $data_attrs ),
		$data_attrs
	);

	// Start the output buffer for rendering
	ob_start();
	?>
	<div class="<?php echo esc_attr( $class ); ?>"<?php echo implode( ' ', $filtered_attrs ); ?> data-styles="<?php echo esc_attr( json_encode( $styles ) ); ?>"></div> <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php

	return ob_get_clean();
}
