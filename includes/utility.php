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
