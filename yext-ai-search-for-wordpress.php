<?php
/**
 * Plugin Name:       Yext AI Search for WordPress
 * Description:       Connect WordPress to Yext knowledge graph and display Answers experience.
 * Version:           1.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Yext Engineering
 * Author URI:        https://yext.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       yext
 * Domain Path:       /languages
 *
 * @package           Yext
 */

// Useful global constants.
define( 'YEXT_VERSION', '1.0' );
define( 'YEXT_URL', plugin_dir_url( __FILE__ ) );
define( 'YEXT_PATH', plugin_dir_path( __FILE__ ) );
define( 'YEXT_INC', YEXT_PATH . 'includes/' );
define( 'YEXT_TEMPLATES', YEXT_INC . 'templates/' );

// Require Composer autoloader if it exists.
if ( file_exists( YEXT_PATH . 'vendor/autoload.php' ) ) {
	require_once YEXT_PATH . 'vendor/autoload.php';
}

// Include files.
require_once YEXT_INC . '/utility.php';
require_once YEXT_INC . '/core.php';
require_once YEXT_INC . '/blocks.php';

// Activation/Deactivation.
register_activation_hook( __FILE__, '\Yext\Core\activate' );
register_uninstall_hook( __FILE__, '\Yext\Core\deactivate' );

// Bootstrap.
Yext\Core\setup();
Yext\Blocks\setup();
