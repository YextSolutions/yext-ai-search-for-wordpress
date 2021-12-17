<?php
/**
 * Core plugin functionality.
 *
 * @package Yext
 */

namespace Yext\Core;

use \WP_Error;
use \Yext\Install;
use \Yext\Uninstall;
use \Yext\Components\SearchBar;
use \Yext\Admin\Settings;
use \Yext\Templates\SearchPageTemplate;
use \Yext\Utility;

/**
 * Default setup routine
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'init', $n( 'i18n' ) );
	add_action( 'init', $n( 'init' ) );
	add_action( 'wp_enqueue_scripts', $n( 'scripts' ) );
	add_action( 'wp_enqueue_scripts', $n( 'styles' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_scripts' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_styles' ) );

	// Editor styles. add_editor_style() doesn't work outside of a theme.
	add_filter( 'mce_css', $n( 'mce_css' ) );
	// Hook to allow async or defer on asset loading.
	add_filter( 'script_loader_tag', $n( 'script_loader_tag' ), 10, 2 );

	do_action( 'yext_loaded' );
}

/**
 * Registers the default textdomain.
 *
 * @return void
 */
function i18n() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'yext' );
	load_textdomain( 'yext', WP_LANG_DIR . '/yext/yext-' . $locale . '.mo' );
	load_plugin_textdomain( 'yext', false, plugin_basename( YEXT_PATH ) . '/languages/' );
}

/**
 * Initializes the plugin and fires an action other plugins can hook into.
 *
 * @return void
 */
function init() {

	// initialize admin settings
	$admin_settings = Settings::instance();
	$admin_settings->setup();

	// register Yext custom search template
	$search_template = SearchPageTemplate::instance();
	$search_template->setup();

	// initialize search bar
	$search_bar = SearchBar::instance();
	$search_bar->setup();

	do_action( 'yext_init' );
}

/**
 * Activate the plugin
 *
 * @return void
 */
function activate() {

	Install::instance()->run();

	// First load the init scripts in case any rewrite functionality is being loaded
	init();
	flush_rewrite_rules();
}

/**
 * Deactivate the plugin
 *
 * Uninstall routines should be in uninstall.php
 *
 * @return void
 */
function deactivate() {
	Uninstall::run();
}


/**
 * The list of knows contexts for enqueuing scripts/styles.
 *
 * @return array
 */
function get_enqueue_contexts() {
	return [ 'admin', 'frontend', 'shared' ];
}

/**
 * Generate an URL to a script, taking into account whether SCRIPT_DEBUG is enabled.
 *
 * @param string $script Script file name (no .js extension)
 * @param string $context Context for the script ('admin', 'frontend', or 'shared')
 *
 * @return string|WP_Error URL
 */
function script_url( $script, $context ) {
	if ( ! in_array( $context, get_enqueue_contexts(), true ) ) {
		return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in Yext script loader.' );
	}

	return YEXT_URL . "dist/js/${script}.js";
}

/**
 * Generate an URL to a stylesheet, taking into account whether SCRIPT_DEBUG is enabled.
 *
 * @param string $stylesheet Stylesheet file name (no .css extension)
 * @param string $context Context for the script ('admin', 'frontend', or 'shared')
 *
 * @return string URL
 */
function style_url( $stylesheet, $context ) {
	if ( ! in_array( $context, get_enqueue_contexts(), true ) ) {
		return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in Yext stylesheet loader.' );
	}

	return YEXT_URL . "dist/css/${stylesheet}.css";
}

/**
 * Enqueue scripts for front-end.
 *
 * @return void
 */
function scripts() {
	wp_enqueue_script(
		'yext-shared',
		script_url( 'shared', 'shared' ),
		Utility\get_asset_info( 'shared', 'dependencies' ),
		Utility\get_asset_info( 'shared', 'version' ),
		true
	);

	wp_enqueue_script( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		'yext-search-bar',
		'https://assets.sitescdn.net/answers-search-bar/v1/answers.min.js',
		[],
		null,
		true
	);

	wp_enqueue_script( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		'yext-search-bar-templates',
		'https://assets.sitescdn.net/answers-search-bar/v1/answerstemplates-iife.compiled.min.js',
		[],
		null,
		true
	);

	wp_enqueue_script(
		'yext-frontend',
		script_url( 'frontend', 'frontend' ),
		[
			'yext-search-bar',
			'yext-search-bar-templates',
		],
		Utility\get_asset_info( 'frontend', 'version' ),
		true
	);

	wp_localize_script(
		'yext-frontend',
		'YEXT',
		[ 'settings' => Settings::localized_settings() ]
	);
}

/**
 * Enqueue scripts for admin.
 *
 * @return void
 */
function admin_scripts() {
	wp_enqueue_script(
		'yext-admin',
		script_url( 'admin', 'admin' ),
		// TODO: use get_asset_info()
		// @see https://github.com/10up/wp-scaffold/blob/trunk/themes/10up-theme/includes/utility.php#L23
		[ 'wp-url' ],
		YEXT_VERSION,
		true
	);
}

/**
 * Enqueue styles for front-end.
 *
 * @return void
 */
function styles() {
	wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		'yext-search-bar',
		'https://assets.sitescdn.net/answers-search-bar/v1/answers.css',
		[],
		null
	);

	wp_enqueue_style(
		'yext-frontend',
		style_url( 'style', 'frontend' ),
		[ 'yext-search-bar' ],
		YEXT_VERSION
	);
	/**
	 * TODO: add filter for CSS variable output
	 */
	wp_add_inline_style( 'yext-frontend', Settings::print_css_variables() );
}

/**
 * Enqueue styles for admin.
 *
 * @return void
 */
function admin_styles() {
	wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		'yext-search-bar',
		'https://assets.sitescdn.net/answers-search-bar/v1/answers.css',
		[],
		null
	);

	wp_enqueue_style(
		'yext-shared',
		style_url( 'shared-style', 'shared' ),
		[],
		YEXT_VERSION
	);

	wp_enqueue_style(
		'yext-admin',
		style_url( 'admin-style', 'admin' ),
		[ 'yext-search-bar' ],
		YEXT_VERSION
	);
	/**
	 * TODO: add filter for CSS variable output
	 */
	wp_add_inline_style( 'yext-admin', Settings::print_css_variables() );
}

/**
 * Enqueue editor styles. Filters the comma-delimited list of stylesheets to load in TinyMCE.
 *
 * @param string $stylesheets Comma-delimited list of stylesheets.
 * @return string
 */
function mce_css( $stylesheets ) {
	if ( ! empty( $stylesheets ) ) {
		$stylesheets .= ',';
	}

	return $stylesheets . YEXT_URL . ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
			'assets/css/frontend/editor-style.css' :
			'dist/css/editor-style.min.css' );
}

/**
 * Add async/defer attributes to enqueued scripts that have the specified script_execution flag.
 *
 * @link https://core.trac.wordpress.org/ticket/12009
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @return string
 */
function script_loader_tag( $tag, $handle ) {
	$script_execution = wp_scripts()->get_data( $handle, 'script_execution' );

	if ( ! $script_execution ) {
		return $tag;
	}

	if ( 'async' !== $script_execution && 'defer' !== $script_execution ) {
		return $tag; // _doing_it_wrong()?
	}

	// Abort adding async/defer for scripts that have this script as a dependency. _doing_it_wrong()?
	foreach ( wp_scripts()->registered as $script ) {
		if ( in_array( $handle, $script->deps, true ) ) {
			return $tag;
		}
	}

	// Add the attribute if it hasn't already been added.
	if ( ! preg_match( ":\s$script_execution(=|>|\s):", $tag ) ) {
		$tag = preg_replace( ':(?=></script>):', " $script_execution", $tag, 1 );
	}

	return $tag;
}
