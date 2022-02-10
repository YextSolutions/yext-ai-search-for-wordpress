<?php
/**
 * Utility functions for the plugin.
 *
 * @package Yext
 */

namespace Yext\Utility;

use \Yext\Admin\Settings;

/**
 * Get plugin config
 *
 * @return array|false
 */
function get_plugin_settings() {
	$settings = get_option( 'yext_plugin_settings' );
	return $settings ? json_decode( $settings, true ) : false;
}

/**
 * Get asset info from extracted asset files
 *
 * @param string $slug Asset slug as defined in build/webpack configuration
 * @param string $attribute Optional attribute to get. Can be version or dependencies
 * @return string|array
 */
function get_asset_info( $slug, $attribute = null ) {
	if ( file_exists( YEXT_PATH . 'dist/js/' . $slug . '.asset.php' ) ) {
		$asset = require YEXT_PATH . 'dist/js/' . $slug . '.asset.php';
	} elseif ( file_exists( YEXT_PATH . 'dist/css/' . $slug . '.asset.php' ) ) {
		$asset = require YEXT_PATH . 'dist/css/' . $slug . '.asset.php';
	} else {
		return null;
	}

	if ( ! empty( $attribute ) && isset( $asset[ $attribute ] ) ) {
		return $asset[ $attribute ];
	}

	return $asset;
}

/**
 * Returns the icon manifest file in JSON format.
 */
function get_icon_manifest() {
	$icons = '';

	if ( file_exists( YEXT_PATH . 'dist/icons.json' ) ) {
		$icons = file_get_contents( YEXT_PATH . 'dist/icons.json' );
	}

	return json_decode( $icons, true ) ?? [];
}

/**
 * Get the SDK version.
 */
function get_sdk_version() {
	$settings = Settings::get_settings();
	$default_version = 'v1.2.0';

	return isset( $settings['plugin']['sdk_version'] ) && ! empty( $settings['plugin']['sdk_version'] )
		? $settings['plugin']['sdk_version']
		: $default_version;
}

/**
 * Icon name dictionary
 *
 * @param string $icon Icon name
 */
function map_icon_name( $icon ) {
	$map = [
		'chevron' => 'Arrow',
		'support' => 'Question Mark',
	];

	return $map[ $icon ] ?? ucwords( str_replace( '_', ' ', $icon ) );
}

/**
 * Build an option list to use in the icon dropdown
 */
function build_icon_options() {
	$icons   = get_icon_manifest();
	$options = [
		'' => 'Yext',
	];

	foreach ( array_keys( $icons ) as $icon ) {
		$options[ $icon ] = map_icon_name( $icon );
	}

	return $options;
}

/**
 * Allow SVGs only within the supplied content
 *
 * @param  string  $content HTML markup to sanitize
 * @param  boolean $echo    Whether or not we should echo the markup or return
 * @return string
 */
function kses_allow_svgs( $content, $echo = true ) {
	$svg_allowed = [
		'svg'            => [
			'id'                => true,
			'version'           => true,
			'class'             => true,
			'fill'              => true,
			'height'            => true,
			'xml:space'         => true,
			'xmlns'             => true,
			'xmlns:xlink'       => true,
			'viewbox'           => true,
			'enable-background' => true,
			'width'             => true,
			'x'                 => true,
			'y'                 => true,
			'focusable'         => true,
			'role'              => true,
			'aria-label'        => true,
		],
		'use'            => [
			'xlink:href' => true,
		],
		'title'          => true,
		'defs'           => true,
		'path'           => [
			'id'           => true,
			'clip-rule'    => true,
			'd'            => true,
			'fill'         => true,
			'fill-rule'    => true,
			'stroke'       => true,
			'stroke-width' => true,
			'class'        => true,
			'mask'         => true,
			'transform'    => true,
		],
		'rect'           => [
			'id'        => true,
			'x'         => true,
			'y'         => true,
			'width'     => true,
			'height'    => true,
			'rx'        => true,
			'stroke'    => true,
			'fill'      => true,
			'class'     => true,
			'transform' => true,
		],
		'g'              => [
			'id'           => true,
			'clip-rule'    => true,
			'clip-path'    => true,
			'd'            => true,
			'transform'    => true,
			'fill'         => true,
			'fill-rule'    => true,
			'stroke'       => true,
			'stroke-width' => true,
			'class'        => true,
			'mask'         => true,
		],
		'polygon'        => [
			'id'           => true,
			'clip-rule'    => true,
			'd'            => true,
			'fill'         => true,
			'fill-rule'    => true,
			'stroke'       => true,
			'stroke-width' => true,
			'points'       => true,
			'class'        => true,
		],
		'circle'         => [
			'id'           => true,
			'clip-rule'    => true,
			'd'            => true,
			'fill'         => true,
			'fill-rule'    => true,
			'stroke'       => true,
			'stroke-width' => true,
			'cx'           => true,
			'cy'           => true,
			'r'            => true,
			'class'        => true,
		],
		'lineargradient' => [
			'id'                => true,
			'gradientunits'     => true,
			'x'                 => true,
			'y'                 => true,
			'x2'                => true,
			'y2'                => true,
			'gradienttransform' => true,
			'class'             => true,
		],
		'stop'           => [
			'id'     => true,
			'offset' => true,
			'style'  => true,
		],
		'mask'           => [
			'id'        => true,
			'maskUnits' => true,
			'mask-type' => true,
			'x'         => true,
			'y'         => true,
			'width'     => true,
			'height'    => true,
			'fill'      => true,
		],
		'clipPath'       => [
			'id' => true,
		],
	];

	if ( $echo ) {
		echo wp_kses( $content, $svg_allowed );
	}

	return wp_kses( $content, $svg_allowed );
}

/**
 * Get or output an SVG icon
 *
 * @param string $filename SVG filename
 * @param array  $atts     SVG attributes
 * @param bool   $echo     Echo or return contents
 */
function yext_icon( $filename, $atts = [], $echo = true ) {
	$yext_icons = get_icon_manifest();

	if ( empty( $filename ) ) {
		return false;
	}

	$svg = ( isset( $yext_icons[ $filename ] ) ) ? $yext_icons[ $filename ] : false;
	if ( ! $svg ) {
		return false;
	}

	// If no custom attributes are found, return the SVG string.
	// Otherwise, parse the SVG string and merge attributes.
	if ( empty( $atts ) ) {
		return kses_allow_svgs( $svg, $echo );
	}

	// Get the SVG element from the string
	preg_match( '/<svg[^>]+>/i', $svg, $svg_tag );
	if ( empty( $svg_tag[0] ) ) {
		return false;
	}

	// Grab the attributes from the SVG element
	$default_atts = wp_kses_hair( $svg_tag[0], [ 'https', 'http' ] );

	// Get the inner HTML of the SVG
	$inner_html = str_replace( $svg_tag[0], '', $svg );
	$inner_html = str_replace( '</svg>', '', $inner_html );

	// Merge the attributes
	foreach ( $default_atts as $k => $v ) {
		if ( empty( $atts[ $v['name'] ] ) ) {
			$atts[ $v['name'] ] = $v['value'];
		}
	}

	// Stringify the attributes
	$atts = array_map(
		function( $k, $v ) {
			return "$k=" . '"' . $v . '"';
		},
		array_keys( $atts ),
		$atts
	);

	// Rebuild the SVG element
	$svg = '<svg ' . implode( ' ', $atts ) . '>' . $inner_html . '</svg>';

	return kses_allow_svgs( $svg, $echo );
}
