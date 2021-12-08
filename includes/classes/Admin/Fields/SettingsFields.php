<?php
/**
 * Abstract class for a tab within settings
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields;

use Yext\Admin\Fields\Type\InputField;
use Yext\Admin\Settings;

/**
 * Fields class
 */
final class SettingsFields {

	/**
	 * Settings
	 *
	 * @var array
	 */
	public $fields;

	/**
	 * Setting values
	 *
	 * @var array
	 */
	protected $values;

	/**
	 * Fields constructor
	 *
	 * @param mixed $values Settings values from DB
	 */
	public function __construct( $values ) {
		$this->values = $values;
		$settings     = $this->get_setting_config();
		foreach ( $settings as $tab => $tab_fields ) {
			array_walk( $tab_fields, [ $this, 'init_field' ], $tab );
		}
	}

	/**
	 * Get all the sections and settings config array
	 *
	 * @return array
	 */
	protected function get_setting_config() {
		return [
			Settings::PLUGIN_SETTINGS_SECTION_NAME => $this->plugin_settings_fields(),
			Settings::SEARCH_BAR_SECTION_NAME      => $this->search_bar_settings_fields(),
			Settings::SEARCH_RESULTS_SECTION_NAME  => $this->search_results_settings_fields(),
		];
	}

	/**
	 * Fields for Plugin settings section
	 *
	 * @return array $fields Array for fields config.
	 */
	protected function plugin_settings_fields() {
		$fields = [
			[
				'id'    => 'api_key',
				'title' => __( 'Api Key', 'yext' ),
				'type'  => 'InputField',
			],
			[
				'id'    => 'experience_key',
				'title' => __( 'Experience Key', 'yext' ),
				'type'  => 'InputField',
			],
			[
				'id'    => 'business_id',
				'title' => __( 'Business ID', 'yext' ),
				'type'  => 'InputField',
			],
			[
				'id'    => 'answers_iframe_url',
				'title' => __( 'Answers iframe url', 'yext' ),
				'type'  => 'InputField',
			],
			[
				'id'      => 'answers_version',
				'title'   => __( 'Answers version', 'yext' ),
				'type'    => 'SelectField',
				'options' => [
					'v1' => __( 'Version 1.0', 'yext' ),
					'v2' => __( 'Version 2.0', 'yext' ),
				],
			],
		];
		return apply_filters( 'yext_section_settings', $fields, Settings::PLUGIN_SETTINGS_SECTION_NAME );
	}

	/**
	 * Fields for Search bar settings section
	 *
	 * @return array $fields Array for fields config.
	 */
	protected function search_bar_settings_fields() {
		$fields = [
			[
				'id'     => 'override_core_search',
				'parent' => 'props',
				'title'  => __( 'Override WordPress search', 'yext' ),
				'type'   => 'CheckboxField',
				'help'   => __( 'Enabling this will transform the search form and search block into Yext search bars, and the search results template into a Yext search results block.', 'yext' ),
			],
			[
				'id'     => 'placeholder_text',
				'parent' => 'props',
				'title'  => __( 'Placeholder text', 'yext' ),
				'type'   => 'InputField',
			],
			[
				'id'     => 'submit_text',
				'parent' => 'props',
				'title'  => __( 'Submit text', 'yext' ),
				'type'   => 'InputField',
			],
			[
				'id'     => 'label_text',
				'parent' => 'props',
				'title'  => __( 'Label text', 'yext' ),
				'type'   => 'InputField',
			],
			[
				'id'     => 'css_class',
				'parent' => 'props',
				'title'  => __( 'CSS class', 'yext' ),
				'type'   => 'InputField',
				'help'   => '',
			],
			[
				'id'       => 'color',
				'parent'   => 'style',
				'title'    => __( 'Text color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-text-color',
			],
			[
				'id'       => 'font_size',
				'parent'   => 'style',
				'title'    => __( 'Font size', 'yext' ),
				'type'     => 'NumberField',
				'variable' => '--yxt-searchbar-text-font-size',
			],
			[
				'id'       => 'font_weight',
				'parent'   => 'style',
				'title'    => __( 'Font weight', 'yext' ),
				'type'     => 'SelectField',
				'options'  => [
					'400' => __( 'Normal', 'yext' ),
					'700' => __( 'Bold', 'yext' ),
				],
				'variable' => '--yxt-searchbar-text-font-weight',
			],
			[
				'id'       => 'line_height',
				'parent'   => 'style',
				'title'    => __( 'Line height', 'yext' ),
				'type'     => 'NumberField',
				'variable' => '--yxt-searchbar-text-line-height',
			],
			[
				'id'       => 'background_color',
				'parent'   => 'style',
				'title'    => __( 'Background color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-form-background-color',
			],
			[
				'id'       => 'border_color',
				'parent'   => 'style',
				'title'    => __( 'Border color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-form-outline-color-base',
			],
			[
				'id'       => 'border_radius',
				'parent'   => 'style',
				'title'    => __( 'Border radius', 'yext' ),
				'type'     => 'NumberField',
				'variable' => '--yxt-searchbar-form-border-radius',
			],
			[
				'id'       => 'background_color',
				'parent'   => 'button',
				'title'    => __( 'Background color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-button-background-color-base',
			],
			[
				'id'       => 'hover_background_color',
				'parent'   => 'button',
				'title'    => __( 'Hover background color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-button-background-color-hover',
			],
			[
				'id'       => 'text_color',
				'parent'   => 'button',
				'title'    => __( 'Text color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-button-text-color',
			],
			[
				'id'       => 'hover_text_color',
				'parent'   => 'button',
				'title'    => __( 'Hover text color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-button-text-color-hover',
			],
			[
				'id'       => 'text_color',
				'parent'   => 'autocomplete',
				'title'    => __( 'Text color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-autocomplete-text-color',
			],
			[
				'id'       => 'background_color',
				'parent'   => 'autocomplete',
				'title'    => __( 'Background color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-autocomplete-background-color',
			],
			[
				'id'       => 'option_hover_background_color',
				'parent'   => 'autocomplete',
				'title'    => __( 'Option hovered background color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-autocomplete-option-hover-background-color',
			],
			[
				'id'       => 'separator_color',
				'parent'   => 'autocomplete',
				'title'    => __( 'Separator color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-autocomplete-separator-color',
			],
			[
				'id'       => 'font_size',
				'parent'   => 'autocomplete',
				'title'    => __( 'Font size', 'yext' ),
				'type'     => 'NumberField',
				'variable' => '--yxt-autocomplete-text-font-size',
			],
			[
				'id'       => 'font_weight',
				'parent'   => 'autocomplete',
				'title'    => __( 'Font weight', 'yext' ),
				'type'     => 'SelectField',
				'options'  => [
					'400' => __( 'Normal', 'yext' ),
					'700' => __( 'Bold', 'yext' ),
				],
				'variable' => '--yxt-autocomplete-text-font-weight',
			],
			[
				'id'       => 'line_height',
				'parent'   => 'autocomplete',
				'title'    => __( 'Line height', 'yext' ),
				'type'     => 'NumberField',
				'variable' => '--yxt-autocomplete-text-line-height',
			],
			[
				'id'       => 'header_font_weight',
				'parent'   => 'autocomplete',
				'title'    => __( 'Header font weight', 'yext' ),
				'type'     => 'SelectField',
				'options'  => [
					'400' => __( 'Normal', 'yext' ),
					'700' => __( 'Bold', 'yext' ),
				],
				'variable' => '--yxt-autocomplete-prompt-header-font-weight',
			],
		];
		return apply_filters( 'yext_section_settings', $fields, Settings::SEARCH_BAR_SECTION_NAME );
	}

	/**
	 * Fields for Plugin settings section
	 *
	 * @return array $fields Array for fields config.
	 */
	protected function search_results_settings_fields() {
		$fields = [
			[
				'id'    => 'results_page',
				'title' => __( 'Search results page', 'yext' ),
				'type'  => 'SelectPagesField',
			],
		];
		return apply_filters( 'yext_section_settings', $fields, Settings::SEARCH_RESULTS_SECTION_NAME );
	}

	/**
	 * Initialize a field
	 *
	 * @param array  $field_config Config for the current field
	 * @param int    $index        Loop index
	 * @param string $section_id   The section the field belongs to
	 * @return void
	 */
	protected function init_field( $field_config, $index, $section_id ) {
		$class_handler = 'Yext\\Admin\\Fields\\Type\\' . $field_config['type'];

		$field_args = [
			'parent'     => $field_config['parent'] ?? '',
			'section_id' => $section_id,
			'options'    => $field_config['options'] ?? '',
			'variable'   => $field_config['variable'] ?? '',
			'value'      => $this->return_field_value( $field_config, $section_id ),
		];

		$this->fields[] = new $class_handler(
			$field_config['id'],
			$field_config['title'],
			$field_args
		);
	}

	/**
	 * Helper method for getting the field value from the received stored option values
	 *
	 * @param array  $field_config Config for the current field
	 * @param string $section_id   The section the field belongs to
	 * @return string              The field value.
	 */
	public function return_field_value( $field_config, $section_id ) {
		// if has a parent, get the value from section > parent field > field value in array
		if ( ! empty( $field_config['parent'] ) ) {
			$value = $this->values[ $section_id ][ $field_config['parent'] ][ $field_config['id'] ] ?? '';
		} else {
			$value = $this->values[ $section_id ][ $field_config['id'] ] ?? '';
		}
		return $value;
	}
}
