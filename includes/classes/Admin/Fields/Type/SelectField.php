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
				'<button data-tippy-content="%s" type="button">
					<span class="visually-hidden">%s</span>
					<svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M8 16A8 8 0 1 0 8-.001 8 8 0 0 0 8 16Zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287H8.93ZM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" fill="currentColor"/>
					</svg>
				</button>',
				esc_attr( $help ),
				esc_html( 'Toggle tooltip', 'yext' )
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
	 * @param string $id     Field ID
	 * @return string $value Sanitized fField value
	 */
	protected function sanitize_value( $value, $id = '' ) {
		$value = parent::sanitize_value( $value, $id );

		if ( 'sdk_version' === $id ) {
			return sanitize_text_field( $value );
		}

		return in_array( $value, array_keys( $this->options ), false ) ? $value : '';
	}

}
