<?php
/**
 * Abstract class for a tab within settings
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields;

use Yext\Admin\Settings;
use Yext\Utility;

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
				'id'       => 'experience_key',
				'title'    => __( 'Experience Key', 'yext' ),
				'type'     => 'InputField',
				'required' => 'true',
				'help'     => __( 'This can be found in the "Experience Details" section in the Answers tab. Make sure you’ve selected the correct Answers Experience if you have multiple.', 'yext' ),
			],
			[
				'id'       => 'api_key',
				'title'    => __( 'API Key', 'yext' ),
				'type'     => 'InputField',
				'required' => 'true',
				'help'     => __( 'Like the Experience Key, this can also be found under "Experience Details".', 'yext' ),
			],
			[
				'id'       => 'business_id',
				'title'    => __( 'Business ID', 'yext' ),
				'type'     => 'InputField',
				'required' => 'true',
				'help'     => __( 'Can also be found under "Experience Details", or in the URL of any page on your Yext account.', 'yext' ),
			],
			[
				'id'       => 'answers_iframe_url',
				'title'    => __( 'Answers iFrame URL', 'yext' ),
				'type'     => 'InputField',
				'required' => 'true',
				'help'     => __( 'This is the Production URL of your Answers experience, found in the Pages tab.', 'yext' ),
			],
			[
				'id'       => 'sdk_version',
				'title'    => __( 'SDK Version', 'yext' ),
				'type'     => 'SelectField',
				'required' => 'true',
				'options'  => [
					'' => 'Select a version',
				],
				'help'     => __( 'The version of the answers-search-bar JS/CSS bundle you would like to use for your experience.', 'yext' ),
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
			],
			[
				'id'       => 'placeholder_text',
				'parent'   => 'props',
				'title'    => __( 'Placeholder Text', 'yext' ),
				'type'     => 'InputField',
				'optional' => true,
				'help'     => __( 'This is the text that will appear by default in your search bar, e.g. "Search all posts here…"', 'yext' ),
			],
			[
				'id'       => 'prompt_header',
				'parent'   => 'props',
				'title'    => __( 'Autocomplete Heading', 'yext' ),
				'type'     => 'InputField',
				'optional' => true,
				'help'     => __( 'This is the text that will appear above the autocomplete suggestions in your search bar', 'yext' ),
			],
			[
				'id'       => 'submit_text',
				'parent'   => 'props',
				'title'    => __( 'Submit Text', 'yext' ),
				'type'     => 'InputField',
				'optional' => true,
				'help'     => __( 'The backend label of the submit button, used in assistive technology like screen readers.', 'yext' ),
			],
			[
				'id'       => 'label_text',
				'parent'   => 'props',
				'title'    => __( 'Label Text', 'yext' ),
				'type'     => 'InputField',
				'optional' => true,
				'help'     => __( 'The backend label of the search bar, used in assistive technology like screen readers.', 'yext' ),
			],
			[
				'id'       => 'css_class',
				'optional' => true,
				'parent'   => 'props',
				'title'    => __( 'CSS Class', 'yext' ),
				'type'     => 'InputField',
				'help'     => __( 'A comma separated list of CSS classnames to transform into Yext Search Bars.', 'yext' ),
			],
			[
				'id'       => 'submit_icon',
				'optional' => true,
				'parent'   => 'props',
				'title'    => __( 'Icon', 'yext' ),
				'type'     => 'SelectField',
				'options'  => Utility\build_icon_options(),
				'help'     => __( 'Choose an icon for the submit button, or select "Yext" to use the default.', 'yext' ),
			],
			[
				'id'       => 'font_size',
				'parent'   => 'style',
				'title'    => __( 'Font Size', 'yext' ),
				'type'     => 'NumberField',
				'variable' => '--yxt-searchbar-text-font-size',
			],
			[
				'id'       => 'font_weight',
				'parent'   => 'style',
				'title'    => __( 'Font Weight', 'yext' ),
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
				'title'    => __( 'Line Height', 'yext' ),
				'type'     => 'NumberField',
				'step'     => '0.1',
				'variable' => '--yxt-searchbar-text-line-height',
			],
			[
				'id'       => 'border_radius',
				'parent'   => 'style',
				'title'    => __( 'Border Radius', 'yext' ),
				'type'     => 'NumberField',
				'variable' => '--yxt-searchbar-form-border-radius',
			],
			[
				'id'       => 'color',
				'parent'   => 'style',
				'title'    => __( 'Text Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-text-color',
			],
			[
				'id'       => 'background_color',
				'parent'   => 'style',
				'title'    => __( 'Background Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-form-background-color',
			],
			[
				'id'       => 'border_color',
				'parent'   => 'style',
				'title'    => __( 'Border Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-form-outline-color-base',
			],
			[
				'id'       => 'placeholder_color',
				'parent'   => 'placeholder',
				'title'    => __( 'Text Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-placeholder-color',
			],
			[
				'id'       => 'placeholder_font_weight',
				'parent'   => 'placeholder',
				'title'    => __( 'Font Weight', 'yext' ),
				'type'     => 'SelectField',
				'options'  => [
					'400' => __( 'Normal', 'yext' ),
					'500' => __( 'Medium', 'yext' ),
					'600' => __( 'Semibold', 'yext' ),
					'700' => __( 'Bold', 'yext' ),
				],
				'variable' => '--yxt-searchbar-placeholder-font-weight',
			],
			[
				'id'       => 'button_background_color',
				'parent'   => 'button',
				'title'    => __( 'Background Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-button-background-color-base',
			],
			[
				'id'       => 'button_hover_background_color',
				'parent'   => 'button',
				'title'    => __( 'Focus Background Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-button-background-color-hover',
			],
			[
				'id'       => 'button_text_color',
				'parent'   => 'button',
				'title'    => __( 'Icon Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-button-text-color',
			],
			[
				'id'       => 'button_hover_text_color',
				'parent'   => 'button',
				'title'    => __( 'Focus Icon Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-searchbar-button-text-color-hover',
			],
			[
				'id'       => 'autocomplete_font_size',
				'parent'   => 'autocomplete',
				'title'    => __( 'Font Size', 'yext' ),
				'type'     => 'NumberField',
				'variable' => '--yxt-autocomplete-text-font-size',
			],
			[
				'id'       => 'autocomplete_font_weight',
				'parent'   => 'autocomplete',
				'title'    => __( 'Font Weight', 'yext' ),
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
				'id'       => 'autocomplete_line_height',
				'parent'   => 'autocomplete',
				'title'    => __( 'Line Height', 'yext' ),
				'type'     => 'NumberField',
				'step'     => '0.1',
				'variable' => '--yxt-autocomplete-text-line-height',
			],
			[
				'id'       => 'autocomplete_header_font_weight',
				'parent'   => 'autocomplete',
				'title'    => __( 'Header Font Weight', 'yext' ),
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
				'id'       => 'autocomplete_text_color',
				'parent'   => 'autocomplete',
				'title'    => __( 'Text Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-autocomplete-text-color',
			],
			[
				'id'       => 'autocomplete_background_color',
				'parent'   => 'autocomplete',
				'title'    => __( 'Background Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-autocomplete-background-color',
			],
			[
				'id'       => 'autocomplete_option_hover_background_color',
				'parent'   => 'autocomplete',
				'title'    => __( 'Hover Background Color', 'yext' ),
				'type'     => 'ColorField',
				'variable' => '--yxt-autocomplete-option-hover-background-color',
			],
			[
				'id'       => 'autocomplete_separator_color',
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
				'help'      => __( 'Select which page you wish to house your search results page from the dropdown list below.', 'yext' ),
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
				'title' => __( 'Enable Search', 'yext' ),
				'type'  => 'CheckboxField',
			],
			[
				'id'    => 'current_step',
				'title' => __( 'Current Step', 'yext' ),
				'type'  => 'HiddenField',
			],
			[
				'id'    => 'active',
				'title' => __( 'Skip Setup Wizard', 'yext' ),
				'type'  => 'HiddenField',
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
			'type'       => $field_config['type'] ?? '',
			'step'       => $field_config['step'] ?? '',
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
