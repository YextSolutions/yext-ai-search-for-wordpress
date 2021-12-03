<?php
/**
 * Search Results Block Registration
 *
 * @package Yext\Blocks
 */

namespace Yext\Blocks\SearchResults;

use \Yext\Blocks\Block;

/**
 * Register Search Results Block
 *
 * @return void
 */
function register() {
	$path = __DIR__;
	require_once "$path/block.php";

	$n = function( $func ) {
		return __NAMESPACE__ . "\\$func";
	};

	new Block( 'search-results', [], $n( 'render' ) );
}
