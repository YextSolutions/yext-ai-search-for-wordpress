<?php
/**
 * Plugin Name:       Yext AI Search
 * Description:       Connect WordPress to Yext knowledge graph and display Answers experience.
 * Version:           1.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Yext Engineering
 * Author URI:        https://yext.com
 * License:           BSD 3-Clause "New" or "Revised" License
 * License URI:       https://opensource.org/licenses/BSD-3-Clause
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
register_deactivation_hook( __FILE__, '\Yext\Core\deactivate' );

// Bootstrap.
Yext\Core\setup();
Yext\Blocks\setup();
