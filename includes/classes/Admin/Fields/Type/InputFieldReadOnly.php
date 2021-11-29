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
 * Field type input read only
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
	 * Render the field used on settings.
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

	/**
	 * Sanitize field value for saving
	 *
	 * @param  array $sanitized   Array of sanitized values
	 * @param  array $posted_data Values from $_POST
	 * @return array $sanitized   Sanitized values
	 */
	public function sanitize_field( $sanitized, $posted_data ) {
		// TODO: this should be updated based on other settings
		return $sanitized;
	}

}
