<?php
/**
 * Base functions for creating a field for the admin settings page
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields\Type;

use Yext\Admin\Fields\Type\AbstractField;

/**
 * Field type input
 */
class InputField extends AbstractField {

	/**
	 * Field constructor
	 *
	 * @param string $id    Setting id
	 * @param string $title Setting title
	 * @param array  $args  Field args
	 */
	public function __construct( $id, $title, $args ) {
		$this->type = 'input';
		parent::__construct( $id, $title, $args );
	}


	/**
	 * Render the field used on settings.
	 *
	 * @return void
	 */
	public function render() {
		$value    = $this->value;
		$variable = isset( $this->variable ) ? $this->variable : '';
		$required = isset( $this->required ) ? $this->required : false;
		$help     = isset( $this->help ) ? $this->help : '';

		if ( $help ) {
			printf(
				'<p class="help-text">%s</p>',
				wp_kses_post( $help )
			);
		}

		printf(
			'<input
				class="regular-text"
				type="text"
				name="%s"
				id="%s"
				value="%s"
				data-variable="%s"
				data-required="%s"
				autocomplete="off">',
			esc_attr( $this->setting_name( $this->id ) ),
			esc_attr( $this->id ),
			esc_attr( $value ),
			esc_attr( $variable ),
			esc_attr( $required ? '1' : '0' )
		);
	}
}
