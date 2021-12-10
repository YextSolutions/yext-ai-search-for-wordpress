<?php
/**
 * Plugin deactivation class
 *
 * @package Yext
 */

namespace Yext;

use Yext\Admin\Settings;

/**
 * Settings for the plugin
 */
final class Uninstall {

	/**
	 * Plugin deactivation main method
	 */
	public static function run() {
		self::delete_plugin_settings();

	}

	/**
	 * Delete plugin settings
	 *
	 * @return void
	 */
	public static function delete_plugin_settings() {
		delete_option( Settings::SETTINGS_NAME );
	}
}
