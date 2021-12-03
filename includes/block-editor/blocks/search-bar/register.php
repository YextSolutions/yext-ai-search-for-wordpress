<?php
/**
 * Search Bar Block Registration
 *
 * @package Yext\Blocks
 */

namespace Yext\Blocks\SearchBar;

use \Yext\Blocks\Block;

/**
 * Register Search Bar Block
 *
 * @return void
 */
function register() {
	$path = __DIR__;
	require_once "$path/block.php";

	$n = function( $func ) {
		return __NAMESPACE__ . "\\$func";
	};

	new Block( 'search-bar', [], $n( 'render' ) );
}
