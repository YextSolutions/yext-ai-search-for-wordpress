<?php
/**
 * Abstract class for a tab within settings
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields;

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
			Settings::WIZARD_SECTION_NAME          => $this->wizard_settings_fields(),
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
				'id'       => 'api_key',
				'title'    => __( 'API Key', 'yext' ),
				'type'     => 'InputField',
				'required' => 'true',
				'help'     => __( 'The unique credentials that will be used to embed your search experience onto WordPress. This can also be found in the “Experience Details” section of Answers on Yext.', 'yext' ),
			],
			[
				'id'       => 'experience_key',
				'title'    => __( 'Experience Key', 'yext' ),
				'type'     => 'InputField',
				'required' => 'true',
				'help'     => __( 'The unique key for your search experience, located under “Experience Details” within the Answers tab on the Yext Platform.', 'yext' ),
			],
			[
				'id'       => 'business_id',
				'title'    => __( 'Business ID', 'yext' ),
				'type'     => 'InputField',
				'required' => 'true',
				'help'     => __( 'The ID associated with your Yext account. This can be found in the “Experience Details” section or as a substring of any URL when you’re logged into the Yext platform.', 'yext' ),
			],
			[
				'id'       => 'answers_iframe_url',
				'title'    => __( 'Answers iFrame URL', 'yext' ),
				'type'     => 'InputField',
				'required' => 'true',
				'help'     => __( 'The Production URL of your Answers experience. This can be found in the Pages tab of your Yext account, in the Production Environment section.', 'yext' ),
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
				'parent' => 'core',
				'title'  => __( 'Enable Global Search', 'yext' ),
				'type'   => 'CheckboxField',
				'help'   => __( 'If you’d like your search bar to appear on every page on your WordPress site, enable global search below.', 'yext' ),
			],
			[
				'id'       => 'placeholder_text',
				'parent'   => 'props',
				'title'    => __( 'Placeholder text', 'yext' ),
				'type'     => 'InputField',
				'optional' => true,
				'help'     => __( 'This is the text that will appear by default in your search bar, e.g. "Search all posts here…"', 'yext' ),
			],
			[
				'id'       => 'submit_text',
				'parent'   => 'props',
				'title'    => __( 'Submit text', 'yext' ),
				'type'     => 'InputField',
				'optional' => true,
				'help'     => __( 'The backend label of the submit button, used in assistive technology like screen readers.', 'yext' ),
			],
			[
				'id'       => 'label_text',
				'parent'   => 'props',
				'title'    => __( 'Label text', 'yext' ),
				'type'     => 'InputField',
				'optional' => true,
				'help'     => __( 'The backend label of the search bar, used in assistive technology like screen readers.', 'yext' ),
			],
			[
				'id'       => 'css_class',
				'optional' => true,
				'parent'   => 'props',
				'title'    => __( 'CSS class', 'yext' ),
				'type'     => 'InputField',
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
					'500' => __( 'Medium', 'yext' ),
					'600' => __( 'Semibold', 'yext' ),
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
				'id'       => 'border_radius',
				'parent'   => 'style',
				'title'    => __( 'Border radius', 'yext' ),
				'type'     => 'NumberField',
				'variable' => '--yxt-searchbar-form-border-radius',
			],
			[
				'id'       => 'color',
				'parent'   => 'style',
				'title'    => __( 'Text color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-text-color',
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
				'id'       => 'background_color',
				'parent'   => 'button',
				'title'    => __( 'Background color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-button-background-color-base',
			],
			[
				'id'       => 'hover_background_color',
				'parent'   => 'button',
				'title'    => __( 'Focus background color', 'yext' ),
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
				'title'    => __( 'Focus text color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-button-text-color-hover',
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
					'500' => __( 'Medium', 'yext' ),
					'600' => __( 'Semibold', 'yext' ),
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
					'500' => __( 'Medium', 'yext' ),
					'600' => __( 'Semibold', 'yext' ),
					'700' => __( 'Bold', 'yext' ),
				],
				'variable' => '--yxt-autocomplete-prompt-header-font-weight',
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
				'title'    => __( 'Option hover background color', 'yext' ),
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
				'id'        => 'results_page',
				'title'     => __( 'Search Results Page', 'yext' ),
				'type'      => 'SelectPagesField',
				'show_link' => true,
				'help'      => __( 'Lorem ipsum dolor sit amet consectetur.', 'yext' ),
			],
		];
		return apply_filters( 'yext_section_settings', $fields, Settings::SEARCH_RESULTS_SECTION_NAME );
	}

	/**
	 * Fields for Plugin settings section
	 *
	 * @return array $fields Array for fields config.
	 */
	protected function wizard_settings_fields() {
		$fields = [
			[
				'id'    => 'live',
				'title' => __( 'Live', 'yext' ),
				'type'  => 'CheckboxField',
			],
			[
				'id'    => 'current_step',
				'title' => __( 'Current Step', 'yext' ),
				'type'  => 'InputField',
			],
			[
				'id'    => 'active',
				'title' => __( 'Skip Setup Wizard', 'yext' ),
				'type'  => 'CheckboxField',
			],
		];
		return apply_filters( 'yext_section_settings', $fields, Settings::WIZARD_SECTION_NAME );
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
			'show_link'  => $field_config['show_link'] ?? '',
			'required'   => $field_config['required'] ?? '',
			'optional'   => $field_config['optional'] ?? '',
			'help'       => $field_config['help'] ?? '',
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
