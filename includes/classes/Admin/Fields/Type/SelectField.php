<?php
/**
 * Base functions for creating a field for the admin settings page
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields\Type;

use Yext\Admin\Fields\Type\AbstractField;

/**
 * Field type select
 */
class SelectField extends AbstractField {

	/**
	 * Array of value => text options for the select
	 *
	 * @var array
	 */
	protected $options = [];


	/**
	 * Field constructor
	 *
	 * @param string $id    Setting id
	 * @param string $title Setting title
	 * @param array  $args  Field args
	 */
	public function __construct( $id, $title, $args ) {
		$this->type = 'select';
		if ( isset( $args['options'] ) ) {
			$this->options = $args['options'];
		}
		parent::__construct( $id, $title, $args );
	}


	/**
	 * Render the field used on settings.
	 *
	 * @return void
	 */
	public function render() {
		$variable = isset( $this->variable ) ? $this->variable : '';
		$help     = isset( $this->help ) ? $this->help : '';

		if ( $help ) {
			printf(
				'<p class="help-text">%s</p>',
				wp_kses_post( $help )
			);
		}

		printf(
			'<select
				name="%s"
				id="%s"
				data-variable="%s"
			>
				%s
			</select>',
			esc_attr( $this->setting_name( $this->id ) ),
			esc_attr( $this->id ),
			esc_attr( $variable ),
			wp_kses( $this->options_html(), $this->allowed_html_tags() )
		);
	}

	/**
	 * Return HTML for the options
	 *
	 * @return string
	 */
	protected function options_html() {
		$html = '';
		foreach ( $this->options as $value => $text ) {
			$html .= sprintf(
				'<option value="%s"%s>%s</option>',
				esc_attr( $value ),
				selected( $this->value, $value, false ),
				esc_attr( $text )
			);
		}
		return $html;
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
		return in_array( $value, array_keys( $this->options ), true ) ? $value : '';
	}

}
