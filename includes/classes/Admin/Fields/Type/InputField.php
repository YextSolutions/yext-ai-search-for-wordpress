<?php
/**
 * Base functions for creating a field for the admin settings page
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields\Type;

use Yext\Admin\Fields\Type\AbstractField;
use Yext\Admin\Settings;

/**
 * Base functions for creating taxonomy
 */
class InputField extends AbstractField {

	/**
	 * Field constructor
	 *
	 * @param string $id        Setting id
	 * @param string $title         Setting title
	 * @param string $current_value Setting title
	 * @param string $section_id    Section Id
	 */
	public function __construct( $id, $title, $current_value, $section_id ) {
		$this->type = 'input';
		parent::__construct( $id, $title, $current_value, $section_id );
	}


	/**
	 * Render an input text field used on settings.
	 *
	 * @return void
	 */
	public function render() {
		$value = $this->current_value;
		printf(
			'<input
				class="regular-text"
				type="text"
				name="%s"
				id="%s"
				value="%s"
				autocomplete="off">',
			esc_attr( $this->setting_name( $this->id ) ),
			esc_attr( $this->id ),
			esc_attr( $value )
		);
	}

}
