<?php
/**
 * Base functions for creating a field for the admin settings page
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields\Type;

use Yext\Admin\Settings;

/**
 * Base functions for creating taxonomy
 */
abstract class AbstractField {


	/**
	 * Setting Id
	 *
	 * @var string id
	 */
	public $id;

	/**
	 * Setting title used in front-end
	 *
	 * @var string Setting title
	 */
	public $title;

	/**
	 * Field type
	 *
	 * @var string Field type
	 */
	public $field_type;

	/**
	 * Section id
	 *
	 * Which setting section the field belongs to
	 *
	 * @var string Field type
	 */
	public $section_id;

	/**
	 * Field current value from options
	 *
	 * @var string
	 */
	protected $current_value = '';

	/**
	 * Field constructor
	 *
	 * @param string $id            Setting id
	 * @param string $title         Setting title
	 * @param string $current_value Setting title
	 * @param string $section_id    Section Id
	 */
	public function __construct( $id, $title, $current_value, $section_id ) {
		$this->id            = $id;
		$this->title         = $title;
		$this->current_value = $current_value;
		$this->section_id    = $section_id;
		$this->setup();
	}

	/**
	 * Setup the field
	 */
	public function setup() {
		// Priority set to a higher value than the one used in Settings class
		add_action( 'admin_init', [ $this, 'add_field' ], 20 );
	}

	/**
	 * Add the field to the section
	 */
	public function add_field() {
		add_settings_field(
			$this->id, // id
			$this->title, // title
			[ $this, 'add_field_callback' ], // callback
			'yext-settings-plugin-settings-tab', // page
			$this->section_id // section
		);
	}

	/**
	 * Render field callback
	 *
	 * @return void
	 */
	public function add_field_callback() {
		$this->render();
	}


	/**
	 * Convert input name to field name
	 *
	 * @return string            Field name for setting.
	 */
	public function setting_name() {
		return sprintf( '%s[%s]', Settings::SETTINGS_NAME, $this->id );
	}

	/**
	 * Render an input text field used on settings.
	 *
	 * @return void
	 */
	abstract public function render();

}
