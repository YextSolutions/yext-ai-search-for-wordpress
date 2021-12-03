<?php
/**
 * Gutenberg Blocks setup
 *
 * @package Yext\Core
 */

namespace Yext\Blocks;

/**
 * Set up blocks
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'enqueue_block_editor_assets', $n( 'blocks_editor_scripts' ) );

	add_filter( 'block_categories', $n( 'blocks_categories' ), 10, 2 );
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
		'blocks-editor',
		YEXT_URL . '/dist/js/blocks-editor.js',
		[ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components' ],
		YEXT_VERSION,
		false
	);

	wp_enqueue_style(
		'editor-style',
		YEXT_URL . '/dist/css/editor-style.css',
		[],
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
