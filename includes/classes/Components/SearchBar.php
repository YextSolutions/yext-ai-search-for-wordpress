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
	 * Check if the Yext configuration is valid
	 *
	 * @return boolean
	 */
	public function is_valid() {
		return $this->is_override_core_search_enabled() &&
			$this->has_integration_setting( 'api_key' ) &&
			$this->has_integration_setting( 'experience_key' ) &&
			$this->has_integration_setting( 'business_id' );
	}

	/**
	 * Init the tab.
	 */
	public function setup() {
		$this->settings = Settings::get_settings();

		if ( $this->is_valid() && $this->is_live() ) {
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
			$use_yext = isset( $block['attrs']['useYextSearchBar'] ) ? $block['attrs']['useYextSearchBar'] : true;

			if ( $use_yext ) {
				return $this->render_search_bar();
			}
		}

		return $block_content;
	}

	/**
	 * Checked if user has finished the setup
	 *
	 * @return bool
	 */
	protected function is_live() {
		return isset( $this->settings['wizard']['live'] ) && $this->settings['wizard']['live'];
	}

	/**
	 * Is override search bar enabled
	 *
	 * @return bool
	 */
	protected function is_override_core_search_enabled() {
		return isset( $this->settings['search_bar']['core']['override_core_search'] ) && ( '1' === $this->settings['search_bar']['core']['override_core_search'] );
	}

	/**
	 * Check existance of a specific field within yext plugin section
	 *
	 * @param string $key Setting key
	 * @return boolean    true if setting exist and has a value
	 */
	protected function has_integration_setting( $key ) {
		return isset( ( $this->settings['plugin'][ $key ] ) ) && ! empty( $this->settings['plugin'][ $key ] );
	}
}
