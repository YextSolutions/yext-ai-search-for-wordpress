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

		$settings = $this->get_setting_config();
		foreach ( $settings as $tab => $fields ) {
			array_walk( $fields, [ $this, 'init_field' ], $tab );
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
				'type'  => 'InputFieldReadOnly',
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
	 * Initialize a field
	 *
	 * @param array  $field_config Config for the current field
	 * @param int    $index        Loop index
	 * @param string $section_id   The section the field belongs to
	 * @return object              A field instance
	 */
	protected function init_field( $field_config, $index, $section_id ) {
		$class_handler = 'Yext\\Admin\\Fields\\Type\\' . $field_config['type'];

		$field_args = [
			'parent'     => $field_config['parent'] ?? '',
			'section_id' => $section_id,
			'options'    => $field_config['options'] ?? '',
			'value'      => $this->values[ $field_config['id'] ] ?? '',
		];

		return new $class_handler(
			$field_config['id'],
			$field_config['title'],
			$field_args
		);
	}

}
