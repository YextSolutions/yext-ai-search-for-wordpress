<?php
/**
 * Yext Blocks Registration
 *
 * @package Yext\Blocks
 */

namespace Yext\Blocks;

use WP_Block_Type_Registry;

/**
 * Yext Block Object
 */
class Block {

	/**
	 * Block Namespace
	 *
	 * @var string
	 */
	const NAMESPACE = 'yext';

	/**
	 * Block Category
	 *
	 * @var string
	 */
	const CATEGORY = 'yext-blocks';

	/**
	 * Block Meta File
	 *
	 * @var string
	 */
	const BLOCK_META = 'block.json';

	/**
	 * Child Block Meta File
	 *
	 * @var string
	 */
	const CHILD_META = 'itemdata.json';

	/**
	 * Custom Block Directory
	 *
	 * @var string
	 */
	const BLOCK_DIR = YEXT_INC . 'block-editor/blocks';

	/**
	 * Block Name
	 *
	 * @var string
	 */
	public $block;

	/**
	 * Block Attributes
	 *
	 * @var array
	 */
	public $atts;

	/**
	 * Block Render Callback
	 *
	 * @var string
	 */
	public $callback;

	/**
	 * WP Block Type Registry
	 *
	 * @var WP_Block_Type_Registry
	 */
	public $wp_blocks;

	/**
	 * Construct the block object
	 *
	 * @param  string $block    Block Name - with or without prefix
	 * @param  array  $atts     Block attributes
	 * @param  string $callback Block render callback
	 * @return void
	 */
	public function __construct( $block, $atts = [], $callback ) {

		$this->block     = $block;
		$this->atts      = $atts;
		$this->callback  = $callback;
		$this->wp_blocks = WP_Block_Type_Registry::get_instance();

		if ( ! $this->wp_blocks->is_registered( self::block_name( $this->block ) ) ) {
			$this->register();
		}
	}

	/**
	 * Register Block
	 *
	 * @return \WP_Block_Type
	 */
	public function register() {
		$block_name = self::block_name( $this->block );

		if ( empty( $this->atts ) ) {
			$this->atts = self::get_block_data( $this->block );
		}

		// If attributes do not contain a render_callback
		// And a valid $callback parameter has been passed
		if ( ( ! isset( $this->atts['render_callback'] ) ) && function_exists( $this->callback ) ) {
			$this->atts['render_callback'] = $this->callback;
		}

		return $this->wp_blocks->register( $block_name, $this->atts );
	}

	/**
	 * Get Block Data from JSON file
	 *
	 * @param string $block Block name without prefix
	 *                      OR block metadata file path
	 * @return array        Array of block data
	 */
	public static function get_block_data( $block ) {

		// If a path was passed instead of block name, grab that
		if ( file_exists( $block ) ) {
			return json_decode( file_get_contents( $block ), true ); // phpcs:ignore
		}

		$path     = self::block_path( $block );
		$metadata = trailingslashit( $path ) . self::BLOCK_META;

		if ( substr_compare( $block, '-item', -strlen( '-item' ) ) === 0 ) {
			$metadata = trailingslashit( $path ) . self::CHILD_META;
		}

		if ( file_exists( $metadata ) ) {
			$data = file_get_contents( $metadata ); // phpcs:ignore

			if ( $data ) {
				$data = json_decode( $data, true );
			}

			return $data;
		}

		return false;
	}

	/**
	 * Get block path
	 *
	 * @param  string $block Block name without prefix
	 * @return string
	 */
	public static function block_path( $block ) {
		$parts = explode( '/', $block );

		if ( isset( $parts[1] ) ) {
			$block = $parts[1];
		}

		return self::BLOCK_DIR . "/$block";
	}

	/**
	 * Create block name with namespace
	 *
	 * @param string $block Block name
	 * @return string       Namespaced block name
	 */
	public static function block_name( $block ) {
		if ( false === strpos( $block, '/' ) ) {
			return trailingslashit( self::NAMESPACE ) . $block;
		}

		return $block;
	}
}
