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
 * Field type input
 */
class InputFieldReadOnly extends AbstractField {

	/**
	 * Field constructor
	 *
	 * @param string $id    Setting id
	 * @param string $title Setting title
	 * @param array  $args  Field args
	 */
	public function __construct( $id, $title, $args ) {
		$this->type = 'input-read-only';
		parent::__construct( $id, $title, $args );
	}

	/**
	 * Render an input text field used on settings.
	 *
	 * @return void
	 */
	public function render() {
		$value = $this->value;
		printf(
			'<input
				class="regular-text"
				type="text"
				readonly="readonly"
				value="%s"
				autocomplete="off">',
			esc_attr( $value )
		);
	}

}
