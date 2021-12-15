<?php
/**
 * Utility functions for the plugin.
 *
 * @package Yext
 */

namespace Yext\Utility;

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
