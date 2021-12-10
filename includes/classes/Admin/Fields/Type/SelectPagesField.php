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
	 * Control link/button display pointing to the selected post
	 *
	 * @var array
	 */
	protected $show_link;

	/**
	 * Additional args for a field
	 *
	 * @var array
	 */
	protected $additional_args = [
		'show_link' => false,
	];

	/**
	 * Field constructor
	 *
	 * @param string $id    Setting id
	 * @param string $title Setting title
	 * @param array  $args  Field args
	 */
	public function __construct( $id, $title, $args ) {
		$args = wp_parse_args( $args, $this->get_default_args() );
		if ( isset( $args['show_link'] ) ) {
			$this->show_link = $args['show_link'];
		}
		parent::__construct( $id, $title, $args );
	}

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
		$this->render_link_button();
	}

	/**
	 * Render a link to the selected post from the dropdown
	 *
	 * @return void
	 */
	protected function render_link_button() {
		if ( ! $this->show_link ) {
			return;
		}
		$button_href = $this->value > 0 ? esc_html( get_permalink( $this->value ) ) : '#';
		printf(
			'<p><a class="button-secondary" href="%s" title="%s" target="_blank">%s</a></p>',
			esc_url( $button_href ),
			esc_attr__( 'Preview the page', 'yext' ),
			esc_html__( 'Preview the page', 'yext' )
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
