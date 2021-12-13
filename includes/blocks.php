<?php
/**
 * Gutenberg Blocks setup
 *
 * @package Yext\Core
 */

namespace Yext\Blocks;

use \Yext\Admin\Settings;

/**
 * Set up blocks
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'init', $n( 'register_blocks' ) );
	add_action( 'enqueue_block_editor_assets', $n( 'blocks_editor_scripts' ) );

	add_filter( 'block_categories_all', $n( 'blocks_categories' ), 10, 2 );
}

/**
 * Enqueue shared frontend and editor JavaScript for blocks.
 *
 * @return void
 */
function blocks_scripts() {
	wp_enqueue_script(
		'blocks',
		YEXT_URL . '/dist/js/blocks.js',
		[],
		YEXT_VERSION,
		true
	);
}


/**
 * Enqueue editor-only JavaScript/CSS for blocks.
 *
 * @return void
 */
function blocks_editor_scripts() {
	wp_enqueue_script(
		'yext-blocks-editor',
		YEXT_URL . '/dist/js/blocks.js',
		[ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-block-editor' ],
		YEXT_VERSION,
		false
	);

	wp_enqueue_style(
		'yext-editor-style',
		YEXT_URL . '/dist/css/editor-style.css',
		[],
		YEXT_VERSION
	);

	wp_localize_script( 'yext-blocks-editor', 'YEXT_SETTINGS', Settings::localized_settings() );
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
	require_once YEXT_INC . 'block-editor/blocks/search-results/register.php';

	SearchResults\register();
}
