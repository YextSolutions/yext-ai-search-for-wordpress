<?php
/**
 * Search Bar Renderer
 *
 * @package Yext\Blocks
 */

namespace Yext\Blocks\SearchBar;

use \Yext\Admin\Settings;

/**
 * Render Search Bar Block
 *
 * @param  array $atts Block Attributes
 * @return string      Block Markup
 */
function render( $atts ) {

	$class  = 'yext-search-bar';
	$class .= isset( $atts['className'] ) ? ' ' . $atts['className'] : '';
	$class .= ! empty( $atts['align'] ) ? ' align' . $atts['align'] : '';

	$placeholder_text = isset( $atts['placeholderText'] ) ? $atts['placeholderText'] : '';
	$submit_text      = isset( $atts['submitText'] ) ? $atts['submitText'] : '';
	$submit_icon      = isset( $atts['submitIcon'] ) ? $atts['submitIcon'] : '';
	$label_text       = isset( $atts['labelText'] ) ? $atts['labelText'] : '';
	$prompt_header    = isset( $atts['promptHeader'] ) ? $atts['promptHeader'] : '';
	$settings         = Settings::get_settings();
	$redirect_url     = '';

	if ( isset( $settings['search_results']['redirect_page'] ) ) {
		$redirect_url = get_the_permalink( intval( isset( $settings['search_results']['redirect_page'] ) ) );
	}

	$filtered_styles = [];
	$styles          = [
		'--yxt-searchbar-text-color'                       => isset( $atts['textColor'] ) ? $atts['textColor'] : null,
		'--yxt-searchbar-text-font-size'                   => isset( $atts['fontSize'] ) ? $atts['fontSize'] . 'px' : null,
		'--yxt-searchbar-text-font-weight'                 => isset( $atts['fontWeight'] ) ? $atts['fontWeight'] : null,
		'--yxt-searchbar-text-line-height'                 => isset( $atts['lineHeight'] ) ? $atts['lineHeight'] : null,
		'--yxt-searchbar-form-outline-color-base'          => isset( $atts['borderColor'] ) ? $atts['borderColor'] : null,
		'--yxt-searchbar-form-border-radius'               => isset( $atts['borderRadius'] ) ? $atts['borderRadius'] . 'px' : null,
		'--yxt-searchbar-form-background-color'            => isset( $atts['backgroundColor'] ) ? $atts['backgroundColor'] : null,
		'--yxt-searchbar-placeholder-color'                => isset( $atts['placeholderTextColor'] ) ? $atts['placeholderTextColor'] : null,
		'--yxt-searchbar-placeholder-font-weight'          => isset( $atts['placeholderFontWeight'] ) ? $atts['placeholderFontWeight'] : null,
		'--yxt-searchbar-placeholder-line-height'          => isset( $atts['placeholderLineHeight'] ) ? $atts['placeholderLineHeight'] : null,
		'--yxt-searchbar-button-background-color-base'     => isset( $atts['buttonBackgroundColor'] ) ? $atts['buttonBackgroundColor'] : null,
		'--yxt-searchbar-button-background-color-hover'    => isset( $atts['buttonHoverBackgroundColor'] ) ? $atts['buttonHoverBackgroundColor'] : null,
		'--yxt-searchbar-button-text-color'                => isset( $atts['buttonTextColor'] ) ? $atts['buttonTextColor'] : null,
		'--yxt-searchbar-button-text-color-hover'          => isset( $atts['buttonHoverTextColor'] ) ? $atts['buttonHoverTextColor'] : null,
		'--yxt-autocomplete-background-color'              => isset( $atts['autocompleteBackgroundColor'] ) ? $atts['autocompleteBackgroundColor'] : null,
		'--yxt-autocomplete-text-color'                    => isset( $atts['autocompleteTextColor'] ) ? $atts['autocompleteTextColor'] : null,
		'--yxt-autocomplete-separator-color'               => isset( $atts['autocompleteSeparatorColor'] ) ? $atts['autocompleteSeparatorColor'] : null,
		'--yxt-autocomplete-option-hover-background-color' => isset( $atts['autocompleteOptionHoverBackgroundColor'] ) ? $atts['autocompleteOptionHoverBackgroundColor'] : null,
		'--yxt-autocomplete-text-font-size'                => isset( $atts['autocompleteOptionFontSize'] ) ? $atts['autocompleteOptionFontSize'] . 'px' : null,
		'--yxt-autocomplete-text-font-weight'              => isset( $atts['autocompleteOptionFontWeight'] ) ? $atts['autocompleteOptionFontWeight'] : null,
		'--yxt-autocomplete-text-line-height'              => isset( $atts['autocompleteOptionLineHeight'] ) ? $atts['autocompleteOptionLineHeight'] : null,
		'--yxt-autocomplete-prompt-header-font-weight'     => isset( $atts['autocompleteHeaderFontWeight'] ) ? $atts['autocompleteHeaderFontWeight'] : null,
	];

	foreach ( $styles as $property => $value ) {
		if ( $value ) {
			$filtered_styles[] = $property . ':' . $value;
		}
	}

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
	<?php if ( ! empty( $submit_icon ) ) : ?>
		data-submit-icon="<?php echo esc_attr( $submit_icon ); ?>"
	<?php endif; ?>
	<?php if ( ! empty( $label_text ) ) : ?>
		data-label-text="<?php echo esc_attr( $label_text ); ?>"
	<?php endif; ?>
	<?php if ( ! empty( $prompt_header ) ) : ?>
		data-prompt-header="<?php echo esc_attr( $prompt_header ); ?>"
	<?php endif; ?>
	<?php if ( ! empty( $redirect_url ) ) : ?>
		data-redirect-url="<?php echo esc_attr( $redirect_url ); ?>"
	<?php endif; ?>
	<?php if ( ! empty( $filtered_styles ) ) : ?>
		style="<?php echo esc_attr( implode( ';', $filtered_styles ) ); ?>"
	<?php endif; ?>
	></div>
	<?php

	return ob_get_clean();
}
