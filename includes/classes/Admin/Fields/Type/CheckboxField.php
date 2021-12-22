<?php
/**
 * Base functions for creating a field for the admin settings page
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields\Type;

use Yext\Admin\Fields\Type\AbstractField;

/**
 * Field type checkbox
 */
class CheckboxField extends AbstractField {

	/**
	 * Array of value => text options for the select
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * The default value for checkboxes
	 *
	 * @var string
	 */
	protected $checkbox_default_value = '1';

	/**
	 * Field constructor
	 *
	 * @param string $id    Setting id
	 * @param string $title Setting title
	 * @param array  $args  Field args
	 */
	public function __construct( $id, $title, $args ) {
		$this->type = 'checkbox';
		parent::__construct( $id, $title, $args );
	}


	/**
	 * Render the field used on settings.
	 *
	 * @return void
	 */
	public function render() {
		$help = isset( $this->help ) ? $this->help : '';

		printf(
			'<input type="checkbox" name="%s" value="%s" %s>',
			esc_attr( $this->setting_name( $this->id ) ),
			esc_attr( $this->checkbox_default_value ),
			checked( $this->value, 1, false )
		);

		if ( $help ) {
			printf(
				'<p class="help-text">%s</p>',
				wp_kses_post( $help )
			);
		}
	}

	/**
	 * Sanitize field value
	 * Check if value matches with field options
	 *
	 * @param string $value  Field value
	 * @return string $value Sanitized fField value
	 */
	protected function sanitize_value( $value ) {
		$value = parent::sanitize_value( $value );
		return '1' === $value ? $value : '';
	}
}
