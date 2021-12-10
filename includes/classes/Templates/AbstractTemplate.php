<?php
/**
 * Abstract template register
 * Sourced from: https://github.com/wpexplorer/page-templater
 *
 * @package Yext\Templates
 */

namespace Yext\Templates;

use Yext\Traits\Singleton;

/**
 *  Yext custom template abstract class
 */
abstract class AbstractTemplate {

	/**
	 * The template array config.
	 *
	 * @var array
	 */
	protected $template = [];

	/**
	 * The template file
	 */
	const TEMPLATE_FILE = self::TEMPLATE_FILE;

	/**
	 * The template title
	 */
	const TEMPLATE_TITLE = self::TEMPLATE_TITLE;

	/**
	 * Initialize class hooks and filters
	 */
	public function setup() {

		// Add option to template selector in editor
		add_filter( 'theme_page_templates', [ $this, 'editor_add_template_option' ] );

		// Add a filter to the save post to inject out template into the page cache
		add_filter( 'wp_insert_post_data', [ $this, 'register_template' ] );

		// Add a filter to the template include to determine if the page has our
		// template assigned and return it's path
		add_filter( 'template_include', [ $this, 'template_include' ] );

		// Template array config
		$this->template = [
			$this->get_template_file() => $this->get_template_title(),
		];
	}

	/**
	 * Return template file
	 *
	 * @return string
	 */
	public function get_template_file() {
		return static::TEMPLATE_FILE;
	}

	/**
	 * Return template title
	 *
	 * @return string
	 */
	public function get_template_title() {
		return static::TEMPLATE_TITLE;
	}

	/**
	 * Add the template to the available options in the editor context
	 *
	 * @param array $post_templates  Array of template header names keyed by the template file name.
	 * @return array $post_templates Filtered templates
	 */
	public function editor_add_template_option( $post_templates ) {
		$post_templates = array_merge( $post_templates, $this->template );
		return $post_templates;
	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doesn't really exist.
	 *
	 * @param array $data An array of slashed, sanitized, and processed post data.
	 * @return array $data
	 */
	public function register_template( $data ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list.
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = [];
		}

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key, 'themes' );

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->template );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $data;

	}

	/**
	 * Filters the path of the current template before including it.
	 * Checks if the template is assigned to the page
	 *
	 * @param string $template The path of the template to include.
	 * @return string $file Full path and file for the template
	 */
	public function template_include( $template ) {
		// Return the search template instead of the template for the first item in the loop
		if ( is_search() || is_archive() ) {
			return $template;
		}

		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}

		$current_template = get_post_meta( $post->ID, '_wp_page_template', true );

		// Return default template if the page is not using our custom one
		if ( $current_template !== $this->get_template_file() ) {
			return $template;
		}

		// Get the template path and file
		$yext_template = $this->get_template_include_path();

		// Return template if exists, fallback to default template on error
		return file_exists( $yext_template ) ? $yext_template : $template;
	}

	/**
	 * Get the template path
	 *
	 * @return string $yext_template Full path and file for the template
	 */
	public function get_template_include_path() {
		$current_template = $this->get_template_file();
		// Allows filtering file path and file
		$filepath      = apply_filters( 'yext_template_include_dir_path', YEXT_TEMPLATES );
		$yext_template = apply_filters( 'yext_template_include', $filepath . $current_template, $current_template );
		return $yext_template;
	}
}

