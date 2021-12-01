<?php
/**
 * Abstract class for a tab within settings
 *
 * @package Yext\Components\SearchBar
 */

namespace Yext\Components;

use \Yext\Admin\Settings;
use \Yext\Traits\Singleton;

/**
 * Tab class
 */
final class SearchBar {

	use Singleton;

	/**
	 * Search Bar classname
	 *
	 * @var string
	 */
	private $classname = 'yext-search-bar';

	/**
	 * Settings
	 *
	 * @var mixed
	 */
	private $settings;

	/**
	 * Init the tab.
	 */
	public function setup() {
		$this->settings = Settings::get_settings();

		if ( '1' === $this->settings['search_bar']['override_core_search'] ) {
			add_filter( 'get_search_form', [ $this, 'render_search_bar' ], 15 );
			add_filter( 'render_block', [ $this, 'render_search_bar_block' ], 10, 2 );
		}
	}

	/**
	 * Override searchform.php markup
	 *
	 * @return string
	 */
	public function render_search_bar() {
		return sprintf(
			'<div class="%s"></div>',
			esc_attr( $this->classname )
		);
	}

	/**
	 * Override core/search block markup
	 *
	 * @param string $block_content Block markup
	 * @param mixed  $block         Block object
	 * @return string
	 */
	public function render_search_bar_block( $block_content = '', $block = [] ) {
		if ( isset( $block['blockName'] ) && 'core/search' === $block['blockName'] ) {
			return $this->render_search_bar();
		}

		return $block_content;
	}
}
