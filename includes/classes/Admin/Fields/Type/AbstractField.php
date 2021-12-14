<?php
/**
 * Base functions for creating a field for the admin settings page
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields\Type;

use Yext\Admin\Settings;

/**
 * Base functions for creating Fields
 */
abstract class AbstractField {


	/**
	 * Setting Id
	 *
	 * @var string id
	 */
	public $id;

	/**
	 * Setting title used in front-end
	 *
	 * @var string Setting title
	 */
	public $title;

	/**
	 * Type of field
	 *
	 * @var string Field type
	 */
	public $type;

	/**
	 * Section id
	 *
	 * Which setting section the field belongs to
	 *
	 * @var string Field type
	 */
	public $section_id;

	/**
	 * Allowed settings html tags for usage in wp_kses
	 *
	 * @var array
	 */
	protected $allowed_html_tags = [
		'option' => [
			'selected' => true,
			'value'    => true,
		],
	];

	/**
	 * Default constructor args
	 *
	 * @var array
	 */
	protected $default_args = [
		'parent_field' => '',
		'value'        => '',
		'section_id'   => '',
		'variable'     => '',
	];

	/**
	 * Field current value from options
	 *
	 * @var string
	 */
	protected $value = '';

	/**
	 * Field constructor
	 *
	 * @param string $id            Setting id
	 * @param string $title         Setting title
	 * @param array  $args {
	 *     Optional. Arguments for the field
	 *     Available arguments:
	 *
	 *     @type string $parent_field  Parent field
	 *     @type string $value         Setting current value if any
	 *     @type string $section_id    Section Id
	 * }
	 */
	public function __construct( $id, $title, $args ) {
		$args               = wp_parse_args( $args, $this->get_default_args() );
		$this->id           = $id;
		$this->title        = $title;
		$this->parent_field = $args['parent'];
		$this->section_id   = $args['section_id'];
		$this->value        = $args['value'];
		$this->variable     = $args['variable'];
		$this->setup();
	}

	/**
	 * Setup the field
	 */
	public function setup() {
		// Priority set to a higher value than the one used in Settings class
		add_action( 'admin_init', [ $this, 'add_field' ], 20 );
		add_filter( 'yext_sanitize_settings', [ $this, 'sanitize_field' ], 10, 2 );
	}

	/**
	 * Add the field to the section
	 */
	public function add_field() {
		if ( ! empty( $this->parent_field ) ) {
			add_settings_field(
				$this->parent_field . '-' . $this->id, // id
				$this->title, // title
				[ $this, 'add_field_callback' ], // callback
				"yext-settings-{$this->section_id}-{$this->parent_field}",
				"{$this->section_id}-{$this->parent_field}"
			);
		} else {
			add_settings_field(
				$this->id, // id
				$this->title, // title
				[ $this, 'add_field_callback' ], // callback
				"yext-settings-{$this->section_id}",
				$this->section_id // section
			);
		}
	}

	/**
	 * Render field callback
	 *
	 * @return void
	 */
	public function add_field_callback() {
		$this->render();
	}


	/**
	 * Convert input name to field name
	 *
	 * @return string            Field name for setting.
	 */
	public function setting_name() {
		return sprintf(
			'%s[%s]%s[%s]',
			Settings::SETTINGS_NAME,
			$this->section_id,
			$this->has_parent_field() ? "[{$this->parent_field}]" : '',
			$this->id
		);
	}

	/**
	 * Render an input text field used on settings.
	 *
	 * @return void
	 */
	abstract public function render();

	/**
	 * Getter for default field args
	 *
	 * @return array
	 */
	public function get_default_args() {
		return $this->default_args;
	}

	/**
	 * Return the list of allowed HTML tags for settings
	 *
	 * @return array
	 */
	public function allowed_html_tags() {
		return $this->allowed_html_tags;
	}

	/**
	 * Sanitize field value for saving
	 *
	 * @param  array $sanitized   Array of sanitized values
	 * @param  array $posted_data Values from $_POST
	 * @return array $sanitized   Sanitized values
	 */
	public function sanitize_field( $sanitized, $posted_data ) {
		$value = $this->get_posted_value( $posted_data );
		if ( $this->has_parent_field() ) {
			$sanitized[ $this->section_id ][ $this->parent_field ][ $this->id ] = $this->sanitize_value( $value );
		} else {
			$sanitized[ $this->section_id ][ $this->id ] = $this->sanitize_value( $value );
		}
		return $sanitized;
	}

	/**
	 * Return the field value from the values passed to 'setting_callback'
	 * Used for data sanitization before saving a setting
	 *
	 * @param  array $posted_data Values from $_POST
	 * @return string
	 */
	protected function get_posted_value( $posted_data ) {
		$value = '';
		if ( $this->has_parent_field() ) {
			$value = $posted_data[ $this->section_id ][ $this->parent_field ][ $this->id ] ?? '';
		} else {
			$value = $posted_data[ $this->section_id ][ $this->id ] ?? '';
		}
		return $value;
	}

	/**
	 * Check if fields has a parent field
	 *
	 * @return boolean
	 */
	protected function has_parent_field() {
		return ! empty( $this->parent_field );
	}

	/**
	 * Sanitize field value
	 *
	 * @param string $value  Field value
	 * @return string $value Sanitized fField value
	 */
	protected function sanitize_value( $value ) {
		return sanitize_text_field( $value );
	}
}
