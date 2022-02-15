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
	add_action( 'admin_enqueue_scripts', $n( 'admin_preconnect' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_scripts' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_styles' ) );
	add_action( 'admin_notices', $n( 'activation_notice' ) );

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
 * Check if plugin activation notice is showing
 *
 * @return boolean
 */
function is_plugin_notice_showing() {
	return get_option( 'yext_plugin_activated', false ) && current_user_can( 'manage_options' );
}

/**
 * Display a notice to continue the plugin setup after activation
 *
 * @return void
 */
function activation_notice() {
	if ( is_plugin_notice_showing() ) {
		$class      = 'notice notice-success yext-activated-notice is-dismissible';
		$key        = 'yext-activated';
		$link_class = 'yext-settings__button yext-settings__button--primary';
		$message    = __( 'Congratulations, the Yext plugin is now activated.', 'yext' );
		$link_text  = __( 'Start Setup', 'yext' );

		printf(
			'<div class="%1$s" data-dismissible="%2$s">
				<div class="row">
					<svg class="yext-logo" height="40" width="40" viewBox="0 0 720 720" xmlns="http://www.w3.org/2000/svg">
						<path d="M360 0C161.18 0 0 161.18 0 360s161.18 360 360 360 360-161.18 360-360S558.82 0 360 0Zm0 691.2C177.08 691.2 28.8 542.92 28.8 360S177.08 28.8 360 28.8 691.2 177.08 691.2 360 542.92 691.2 360 691.2Z" fill="currentColor"/>
						<path d="M370.8 399.6h64.8v129.6h28.8V399.6h64.8v-28.8H370.8v28.8Zm-38.37-32.4L270 429.64l-62.43-62.44-20.37 20.37L249.64 450l-62.44 62.43 20.37 20.37L270 470.36l62.43 62.44 20.37-20.37L290.36 450l62.44-62.43-20.37-20.37Zm115.77-18c44.73 0 81-36.27 81-81h-28.8c0 28.83-23.37 52.2-52.2 52.2-8.23 0-16.01-1.91-22.93-5.3l90.91-90.91c-14.44-22.25-39.48-36.98-67.98-36.98-44.74 0-81 36.27-81 81s36.26 80.99 81 80.99Zm0-133.2c10.12 0 19.56 2.89 27.56 7.88l-71.88 71.88c-4.99-8-7.87-17.44-7.87-27.56-.01-28.83 23.36-52.2 52.19-52.2ZM270 259.58l-60.74-72.38-22.06 18.51 68.4 81.52v61.97h28.8v-61.97l68.4-81.52-22.06-18.51L270 259.58Z" fill="currentColor"/>
					</svg>
					<h2>%3$s</h2>
				</div>
				<p>%4$s</p>
				<a href="%5$s" class="%6$s">%7$s</a>
			</div>',
			esc_attr( $class ),
			esc_attr( $key ),
			esc_html( 'Yext' ),
			esc_html( $message ),
			esc_url( admin_url( 'admin.php?page=yext' ) ),
			esc_attr( $link_class ),
			esc_html( $link_text )
		);
	}
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
 * Check if current admin page is a Yext plugin page.
 *
 * @param string $page Name of current page
 *
 * @return boolean
 */
function is_yext_page( $page ) {
	return strpos( $page, 'yext' ) !== false;
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
	$sdk_version = Utility\get_sdk_version();

	wp_enqueue_script( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		'yext-search-bar',
		'https://assets.sitescdn.net/answers-search-bar/' . $sdk_version . '/answers.min.js',
		[],
		null,
		true
	);

	wp_enqueue_script( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		'yext-search-bar-templates',
		'https://assets.sitescdn.net/answers-search-bar/' . $sdk_version . '/answerstemplates-iife.compiled.min.js',
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
 * Add preconnect links to head.
 *
 * @param string $page Current page name.
 * @return void
 */
function admin_preconnect( $page ) {

	if ( is_yext_page( $page ) ) {

		$preconnect_hrefs = [
			'https://fonts.googleapis.com',
			'https://fonts.gstatic.com',
		];

		foreach ( $preconnect_hrefs as $href ) {
			echo "<link rel='preconnect' href='" . esc_url( $href ) . "' crossorigin>";
		}
	}
}

/**
 * Enqueue scripts for admin.
 *
 * @param string $page Current page name.
 *
 * @return void
 */
function admin_scripts( $page ) {
	$rest_url = get_rest_url( null, '/yext/v1' );

	if ( is_yext_page( $page ) ) {
		wp_enqueue_script(
			'yext-admin',
			script_url( 'admin', 'admin' ),
			Utility\get_asset_info( 'admin', 'dependencies' ),
			Utility\get_asset_info( 'admin', 'version' ),
			true
		);

		// Default settings
		$defaults = [];
		if ( file_exists( YEXT_INC . 'settings.json' ) ) {
			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			$defaults = file_get_contents( YEXT_INC . 'settings.json', false );
		}

		wp_localize_script(
			'yext-admin',
			'YEXT',
			[
				'defaults'     => json_decode( $defaults ),
				'settings'     => Settings::get_settings(),
				'site_url'     => esc_url( get_site_url() ),
				'settings_url' => esc_url( admin_url( 'admin.php?page=yext' ) ),
				'rest_url'     => $rest_url,
				'icons'        => Utility\get_icon_manifest(),
			]
		);
	} elseif ( is_plugin_notice_showing() ) {
		wp_enqueue_script(
			'yext-admin-notice',
			script_url( 'admin-notice-script', 'admin' ),
			Utility\get_asset_info( 'admin-notice-script', 'dependencies' ),
			Utility\get_asset_info( 'admin-notice-script', 'version' ),
			true
		);

		wp_localize_script(
			'yext-admin-notice',
			'YEXT',
			[
				'rest_url' => $rest_url,
			]
		);
	}
}

/**
 * Enqueue styles for front-end.
 *
 * @return void
 */
function styles() {
	$sdk_version = Utility\get_sdk_version();

	wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		'yext-search-bar',
		'https://assets.sitescdn.net/answers-search-bar/' . $sdk_version . '/answers.css',
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
 * @param string $page Current page name.
 *
 * @return void
 */
function admin_styles( $page ) {

	if ( is_yext_page( $page ) ) {
		$sdk_version = Utility\get_sdk_version();

		wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			'yext-search-bar',
			'https://assets.sitescdn.net/answers-search-bar/' . $sdk_version . '/answers.css',
			[],
			null
		);

		wp_enqueue_style(
			'yext-admin',
			style_url( 'admin-style', 'admin' ),
			[ 'yext-search-bar' ],
			YEXT_VERSION
		);

		wp_enqueue_style(
			'yext-admin-vendor',
			style_url( 'admin-vendor', 'admin' ),
			[],
			YEXT_VERSION
		);

		// TODO: add filter for CSS variable output
		wp_add_inline_style( 'yext-admin', Settings::print_css_variables() );

		wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			'poppins',
			'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap',
			[],
			null
		);
	} elseif ( is_plugin_notice_showing() ) {
		wp_enqueue_style(
			'yext-admin-notice',
			style_url( 'admin-notice', 'admin' ),
			[],
			YEXT_VERSION
		);

		wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			'poppins',
			'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap',
			[],
			null
		);
	}
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
		return $tag;
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
