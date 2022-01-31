<?php
/**
 * Plugin activation class
 *
 * @package Yext
 */

namespace Yext;

use Yext\Admin\Settings;
use Yext\Traits\Singleton;

/**
 * Install plugin methods
 */
final class Install {

	use Singleton;

	/**
	 * Admin notices for user feedback
	 *
	 * @var array
	 */
	private $notices = [];


	/**
	 * Plugin activation main method
	 */
	public function run() {
		$this->save_default_settings();
		$this->create_search_results_page();
		add_action( 'admin_notices', [ $this, 'admin_notices' ], 4 );
	}

	/**
	 * Save plugin default settings if no existing settings
	 *
	 * @return void
	 */
	public function save_default_settings() {
		// Do not override existing settings
		if ( ! empty( Settings::get_settings() ) ) {
			return;
		}

		$settings = false;

		// Register default settings
		if ( file_exists( YEXT_INC . 'settings.json' ) ) {
			$settings = file_get_contents( YEXT_INC . 'settings.json', false ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		}

		update_option(
			'yext_plugin_activated',
			true,
			false
		);

		update_option(
			'yext_plugin_settings',
			$settings ? json_decode( $settings, true ) : [],
			false
		);
	}

	/**
	 * Create a custom page for the search results
	 *
	 * @return void
	 */
	public function create_search_results_page() {
		$args = [
			'posts_per_page' => 1,
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'meta_key'       => 'yext_results_template',
			'meta_value'     => 1,
		];

		$has_page_template = new \WP_Query( $args );

		if ( $has_page_template->have_posts() ) {
			$page_id = $has_page_template->posts[0]->ID;
		} else {
			$page_id = wp_insert_post(
				[
					'post_content' => $this->yext_search_page_content(),
					'post_status'  => 'publish',
					'post_title'   => __( 'Search results', 'yext' ),
					'post_type'    => 'page',
					'meta_input'   => [
						'yext_results_template' => 1,
					],
				]
			);
		}

		if ( ! is_wp_error( $page_id ) && is_numeric( $page_id ) ) {
			Settings::update_settings(
				[
					'search_results' => [
						'results_page' => (string) $page_id,
					],
				]
			);

			// For activation purposes only
			update_option(
				'yext_plugin_activated',
				true,
				false
			);
		}
	}

	/**
	 * Return the content for the Yext search page
	 *
	 * @return string
	 */
	public function yext_search_page_content() {
		return '<!-- wp:yext/search-results {"url":""} /-->';
	}
}
