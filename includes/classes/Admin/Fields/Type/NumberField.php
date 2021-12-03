<?php
/**
 * Base functions for creating a field for the admin settings page
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields\Type;

use Yext\Admin\Fields\Type\AbstractField;

/**
 * Field type number
 */
class NumberField extends AbstractField {

	/**
	 * Field constructor
	 *
	 * @param string $id    Setting id
	 * @param string $title Setting title
	 * @param array  $args  Field args
	 */
	public function __construct( $id, $title, $args ) {
		$this->type = 'color';
		parent::__construct( $id, $title, $args );
	}


	/**
	 * Render the field used on settings.
	 *
	 * @return void
	 */
	public function render() {
		$value = $this->value;
		$variable = isset( $this->variable ) ? $this->variable : '';
		printf(
			'<input
				class="small-text"
				type="number"
				name="%s"
				id="%s"
				value="%s"
				data-variable="%s"
				autocomplete="off">',
			esc_attr( $this->setting_name( $this->id ) ),
			esc_attr( $this->id ),
			esc_attr( $value ),
			esc_attr( $variable )
		);
	}

	/**
	 * Sanitize field value
	 * Check if value is a number
	 *
	 * @param string $value  Field value
	 * @return string $value Sanitized fField value
	 */
	protected function sanitize_value( $value ) {
		$value = parent::sanitize_value( $value );
		return is_numeric( $value ) ? $value : '';
	}

}
