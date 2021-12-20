<?php
/**
 * Search page template register
 * Sourced from: https://github.com/wpexplorer/page-templater
 *
 * @package Yext\Templates
 */

namespace Yext\Templates;

use \Yext\Admin\Settings;
use Yext\Traits\Singleton;

/**
 * Register Yext custom search template
 */
final class SearchPageTemplate extends AbstractTemplate {

	use Singleton;

	/**
	 * The template file
	 */
	const TEMPLATE_FILE = 'yext-search-results.php';

	/**
	 * The template file
	 */
	const TEMPLATE_TITLE = 'Yext Plugin - Search Results Page';

	/**
	 * Filters the path of the current template before including it.
	 * Checks if the template should be assigned to the search page
	 *
	 * @param string $template The path of the template to include.
	 */
	public function template_include( $template ) {
		// Return our custom search template if is the search page
		if ( $this->should_override_template() ) {
			// Get the template path and file
			$yext_template = $this->get_template_include_path();
		} else {
			// call parent method
			$yext_template = parent::template_include( $template );
		}
		// Return template if exists, fallback to default template on error
		return file_exists( $yext_template ) ? $yext_template : $template;
	}

	/**
	 * Checks for template override on the search page
	 *
	 * @return bool
	 */
	public function should_override_template() {
		$settings = Settings::get_settings();
		return is_search() && isset( $settings['search_results']['redirect_url'] ) && empty( $settings['search_results']['redirect_url'] );
	}

}
