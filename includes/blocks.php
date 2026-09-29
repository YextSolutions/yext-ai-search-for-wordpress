<?php
/**
 * Gutenberg Blocks setup
 *
 * @package Yext\Core
 */

namespace Yext\Blocks;

use Yext\Admin\Settings;
use Yext\Utility;

/**
 * Set up blocks
 *
 * @return void
 */
function setup() {
	add_action( 'init', __NAMESPACE__ . '\\register_editor_assets' );
	add_action( 'init', __NAMESPACE__ . '\\register_blocks' );

	add_filter( 'block_categories_all', __NAMESPACE__ . '\\blocks_categories', 10, 2 );
}

/**
 * Register editor assets declared by block.json.
 *
 * @return void
 */
function register_editor_assets() {
	$sdk_version = Utility\get_sdk_version();

	wp_register_script(
		'yext-blocks-editor',
		YEXT_URL . '/dist/js/blocks.js',
		[ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-block-editor' ],
		YEXT_VERSION,
		false
	);

	wp_localize_script(
		'yext-blocks-editor',
		'YEXT',
		[
			'settings'    => Settings::localized_settings(),
			'icons'       => Utility\get_icon_manifest(),
			'iconOptions' => Utility\build_icon_options(),
		]
	);

	wp_register_style(
		'yext-search-bar',
		'https://assets.sitescdn.net/answers-search-bar/' . $sdk_version . '/answers.css',
		[],
		null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
	);

	wp_register_style(
		'yext-editor-style',
		YEXT_URL . '/dist/blocks/editor-style.css',
		[ 'yext-search-bar' ],
		YEXT_VERSION
	);
}

/**
 * Filters the registered block categories.
 *
 * @param array $categories Registered categories.
 *
 * @return array Filtered categories.
 */
function blocks_categories( $categories ) {
	return array_merge(
		$categories,
		[
			[
				'slug'  => 'yext-blocks',
				'title' => __( 'Yext Blocks', 'yext' ),
			],
		]
	);
}

/**
 * Register Server-Side Gutenberg Blocks
 * Require the block register.php file and run the function
 *
 * @return void
 */
function register_blocks() {
	require_once YEXT_INC . 'block-editor/blocks/search-bar/register.php';
	require_once YEXT_INC . 'block-editor/blocks/search-results/register.php';

	SearchBar\register();
	SearchResults\register();
}
