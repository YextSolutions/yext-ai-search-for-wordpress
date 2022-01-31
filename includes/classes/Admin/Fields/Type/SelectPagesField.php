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
		$help = isset( $this->help ) ? $this->help : '';

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

		wp_dropdown_pages(
			[
				'name'              => esc_attr( $this->setting_name( $this->id ) ),
				'id'                => esc_attr( $this->id ),
				'echo'              => 1,
				'show_option_none'  => esc_attr__( 'Select a page', 'yext' ),
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
		$class       = 'preview-link is-external mt-medium';
		$class      .= '#' === $button_href ? ' disabled' : '';

		printf(
			'<a class="%s" href="%s" target="_blank" rel="noopener nofollow">%s</a>',
			esc_attr( $class ),
			esc_url( $button_href ),
			esc_html__( 'Preview the page', 'yext' )
		);
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
		return self::POST_TYPE === get_post_type( $value ) && is_numeric( $value ) ? $value : '';
	}
}
