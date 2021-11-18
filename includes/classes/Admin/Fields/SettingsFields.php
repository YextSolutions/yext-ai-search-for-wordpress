<?php
/**
 * Abstract class for a tab within settings
 *
 * @package Yext\Admin\Fields
 */

namespace Yext\Admin\Fields;

use Yext\Admin\Fields\Type\InputField;

/**
 * Fields class
 */
final class SettingsFields {

	/**
	 * Settings
	 *
	 * @var mixed
	 */
	private $fields;

	/**
	 * Fields constructor
	 *
	 * @param mixed $settings Settings values from DB
	 */
	public function __construct( $settings ) {
		$this->fields = [
			'textfield' => new InputField( 'textfield', 'Text Field', $settings['textfield'], 'plugin-settings-tab' ),
		];
	}
}
