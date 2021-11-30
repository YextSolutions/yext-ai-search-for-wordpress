<?php
/**
 * Base functions for creating a field for the admin settings page
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields\Type;

use Yext\Admin\Fields\Type\AbstractField;

/**
 * Field type select pages
 */
class SelectPagesField extends SelectField {

	/**
	 * The post type key used in the dropdown
	 */
	const POST_TYPE = 'page';

	/**
	 * Render the field used on settings.
	 *
	 * @return void
	 */
	public function render() {
		wp_dropdown_pages(
			[
				'name'              => esc_attr( $this->setting_name( $this->id ) ),
				'echo'              => 1,
				'show_option_none'  => esc_attr__( '&mdash; Select &mdash;', 'yext' ),
				'option_none_value' => '',
				'selected'          => esc_attr( $this->value ),
			]
		);
	}

	/**
	 * Sanitize field value
	 * Check if value matches with field options
	 *
	 * @param string $value  Field value
	 * @return string $value Sanitized fField value
	 */
	protected function sanitize_value( $value ) {
		return self::POST_TYPE === get_post_type( $value ) && is_numeric( $value ) ? $value : '';
	}
}
