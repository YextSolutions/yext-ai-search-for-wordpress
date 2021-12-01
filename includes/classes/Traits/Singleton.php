<?php
/**
 * Singleton Trait
 *
 * @package Yext\Traits
 */

namespace Yext\Traits;

/**
 * Singleton trait to be reused for Singleton pattern
 */
trait Singleton {

	/**
	 * Singleton instance.
	 *
	 * @var bool|Singleton
	 */
	private static $instance = false;

	/**
	 * Return post type instance
	 *
	 * @return bool|Singleton
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
