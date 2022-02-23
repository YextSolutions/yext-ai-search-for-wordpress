<?php
/**
 * Admin settings
 *
 * @package Yext\Admin
 */

namespace Yext\Admin;

use Yext\Admin\Fields\SettingsFields;
use Yext\Admin\Tabs\Tab;
use Yext\Traits\Singleton;

/**
 * Settings for the plugin
 */
final class Settings {

	use Singleton;

	/**
	 * The key for storing setting values in the options table
	 */
	const SETTINGS_NAME = 'yext_plugin_settings';

	/**
	 * Plugin settings section name
	 */
	const PLUGIN_SETTINGS_SECTION_NAME = 'plugin';

	/**
	 * Search bar settings section name
	 */
	const SEARCH_BAR_SECTION_NAME = 'search_bar';

	/**
	 * Search bar settings section name
	 */
	const SEARCH_RESULTS_SECTION_NAME = 'search_results';

	/**
	 * Wizard settings section name
	 */
	const WIZARD_SECTION_NAME = 'wizard';

	/**
	 * Settings
	 *
	 * @var mixed
	 */
	private $settings;

	/**
	 * Tabs
	 *
	 * @var mixed
	 */
	private $tabs;

	/**
	 * Settings fields
	 * Instance of SettingsFields
	 *
	 * @var mixed
	 */
	private $settings_fields;

	/**
	 * base64 encoded svg icon for menu
	 *
	 * @var string
	 */
	private $menu_icon = 'data:image/svg+xml;base64,PHN2ZyBjbGFzcz0ieWV4dC1sb2dvIiBmaWxsPSJub25lIiB2aWV3Qm94PSIwIDAgNzIwIDcyMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KCTxwYXRoIGQ9Ik0zNjAgMEMxNjEuMTggMCAwIDE2MS4xOCAwIDM2MHMxNjEuMTggMzYwIDM2MCAzNjAgMzYwLTE2MS4xOCAzNjAtMzYwUzU1OC44MiAwIDM2MCAwWm0wIDY5MS4yQzE3Ny4wOCA2OTEuMiAyOC44IDU0Mi45MiAyOC44IDM2MFMxNzcuMDggMjguOCAzNjAgMjguOCA2OTEuMiAxNzcuMDggNjkxLjIgMzYwIDU0Mi45MiA2OTEuMiAzNjAgNjkxLjJaIiBmaWxsPSJjdXJyZW50Q29sb3IiLz4KCTxwYXRoIGQ9Ik0zNzAuOCAzOTkuNmg2NC44djEyOS42aDI4LjhWMzk5LjZoNjQuOHYtMjguOEgzNzAuOHYyOC44Wm0tMzguMzctMzIuNEwyNzAgNDI5LjY0bC02Mi40My02Mi40NC0yMC4zNyAyMC4zN0wyNDkuNjQgNDUwbC02Mi40NCA2Mi40MyAyMC4zNyAyMC4zN0wyNzAgNDcwLjM2bDYyLjQzIDYyLjQ0IDIwLjM3LTIwLjM3TDI5MC4zNiA0NTBsNjIuNDQtNjIuNDMtMjAuMzctMjAuMzdabTExNS43Ny0xOGM0NC43MyAwIDgxLTM2LjI3IDgxLTgxaC0yOC44YzAgMjguODMtMjMuMzcgNTIuMi01Mi4yIDUyLjItOC4yMyAwLTE2LjAxLTEuOTEtMjIuOTMtNS4zbDkwLjkxLTkwLjkxYy0xNC40NC0yMi4yNS0zOS40OC0zNi45OC02Ny45OC0zNi45OC00NC43NCAwLTgxIDM2LjI3LTgxIDgxczM2LjI2IDgwLjk5IDgxIDgwLjk5Wm0wLTEzMy4yYzEwLjEyIDAgMTkuNTYgMi44OSAyNy41NiA3Ljg4bC03MS44OCA3MS44OGMtNC45OS04LTcuODctMTcuNDQtNy44Ny0yNy41Ni0uMDEtMjguODMgMjMuMzYtNTIuMiA1Mi4xOS01Mi4yWk0yNzAgMjU5LjU4bC02MC43NC03Mi4zOC0yMi4wNiAxOC41MSA2OC40IDgxLjUydjYxLjk3aDI4Ljh2LTYxLjk3bDY4LjQtODEuNTItMjIuMDYtMTguNTFMMjcwIDI1OS41OFoiIGZpbGw9ImN1cnJlbnRDb2xvciIvPgo8L3N2Zz4=';

	/**
	 * Return plugin options from the DB
	 *
	 * @return array
	 */
	public static function get_settings() {
		return get_option( static::SETTINGS_NAME, [] );
	}

	/**
	 * Update plugin options
	 * The param '$settings' must follow the settings array structure in order to not break
	 * how the settings are stored.
	 * Ex:
	 *    For updating the 'redirect_url' on the 'search_results' settings group the following format is expected
	 *    $settings = [ 'search_results' =>  [ 'redirect_url' => '111', ] ]
	 *
	 * @param array $settings New settings, partial or full array of settings
	 * @return array $updated_settings Updated Settings
	 */
	public static function update_settings( $settings ) {
		// Merge current with new values
		$updated_settings = array_replace_recursive( self::get_settings(), $settings );
		update_option( static::SETTINGS_NAME, $updated_settings, false );

		// Remove temporary option
		delete_option( 'yext_plugin_activated' );

		return $updated_settings;
	}

	/**
	 * Set wizard setup to live/finished
	 *
	 * @return array $updated_settings Updated Settings
	 */
	public static function go_live() {
		$updated_settings = array_merge( [ 'wizard' => [ 'live' => true ] ], self::get_settings() );
		self::update_settings( $updated_settings );

		return $updated_settings;
	}

	/**
	 * Settings page Setup
	 */
	public function setup() {
		$this->settings = self::get_settings();

		$plugin_tab = new Tab( self::PLUGIN_SETTINGS_SECTION_NAME, __( 'Plugin settings', 'yext' ) );
		// Child sections for this tab
		// Array of slug => title to display in front end
		$child_sections = [
			'core'         => [
				'classname' => '',
				'title'     => '',
			],
			'props'        => [
				'classname' => '',
				'title'     => '',
			],
			'style'        => [
				'classname' => 'accordion',
				'title'     => __( 'General', 'yext' ),
				'help'      => __( 'CSS settings for all search bar text (except autocomplete, which is configured below).', 'yext' ),
			],
			'placeholder'        => [
				'classname' => 'accordion',
				'title'     => __( 'Placeholder', 'yext' ),
			],
			'button'       => [
				'classname' => 'accordion',
				'title'     => __( 'Button', 'yext' ),
			],
			'autocomplete' => [
				'classname' => 'accordion',
				'title'     => __( 'Autocomplete', 'yext' ),
			],
		];
		$search_bar_tab = new Tab( self::SEARCH_BAR_SECTION_NAME, __( 'Search bar settings', 'yext' ), $child_sections );
		$search_res_tab = new Tab( self::SEARCH_RESULTS_SECTION_NAME, __( 'Search results settings', 'yext' ) );
		$wizard_tab     = new Tab( self::WIZARD_SECTION_NAME, '' );

		$this->tabs = [ $plugin_tab, $search_bar_tab, $search_res_tab, $wizard_tab ];

		add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );
		add_action( 'rest_api_init', [ $this, 'rest_api_init' ] );
		add_action( 'admin_init', [ $this, 'admin_page_init' ], 10 );
	}

	/**
	 * Add plugin page
	 *
	 * @return void
	 */
	public function add_plugin_page() {

		$force_skipped = isset( $_GET['skipped'] ) ? sanitize_text_field( $_GET['skipped'] ) : false;
		$skipped       = $force_skipped || ( isset( $this->settings['wizard'] ) && isset( $this->settings['wizard']['active'] ) && ! $this->settings['wizard']['active'] );

		add_menu_page(
			__( 'Yext', 'yext' ),
			__( 'Yext', 'yext' ),
			'manage_options',
			'yext-ai-search',
			$skipped ? [ $this, 'render_settings_page' ] : [ $this, 'render_wizard_page' ],
			$this->menu_icon
		);
	}

	/**
	 * Add settings to plugin administration page
	 *
	 * @return void
	 */
	public function admin_page_init() {
		register_setting(
			'yext_option_group', // option_group
			static::SETTINGS_NAME, // option_name
			[ $this, 'sanitize_setting_values' ] // sanitize_callback
		);
		$this->settings_fields = new SettingsFields( $this->settings );
	}

	/**
	 * Registers the API endpoint to save setup wizard
	 */
	public function rest_api_init() {
		$permission = current_user_can( 'manage_options' );

		register_rest_route(
			'yext/v1',
			'settings',
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'handle_setup_wizard' ],
				'permission_callback' => function () use ( $permission ) {
					return $permission;
				},
				'args'                => [
					'settings' => [
						'validate_callback' => function ( $param ) {
							return ! empty( $param );
						},
						'required'          => true,
					],
				],
			]
		);

		register_rest_route(
			'yext/v1',
			'activated',
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'handle_activation_notice' ],
				'permission_callback' => function () use ( $permission ) {
					return $permission;
				},
				'args'                => [
					'activated' => [
						'validate_callback' => function ( $param ) {
							return ! empty( $param );
						},
						'required'          => true,
					],
				],
			]
		);
	}

	/**
	 * Handles the setup wizard settings
	 *
	 * @param \WP_REST_Request $request Rest request
	 * @return array
	 */
	public function handle_setup_wizard( $request ) {
		$settings = $request->get_param( 'settings' );

		if ( empty( $settings ) || ! is_array( $settings ) ) {
			return new \WP_Error( 400 );
		}

		$updated_settings = $this->update_settings( $settings );

		return $updated_settings;
	}

	/**
	 * Handles plugin activation
	 *
	 * @param \WP_REST_Request $request Rest request
	 * @return null
	 */
	public function handle_activation_notice( $request ) {
		$settings = $request['activated'];

		if ( empty( $settings ) ) {
			return new \WP_Error( 400 );
		}

		// Remove temporary option
		delete_option( 'yext_plugin_activated' );
	}

	/**
	 * Add style variables
	 *
	 * @return string
	 */
	public static function print_css_variables() {

		$css             = '';
		$settings        = self::get_settings();
		$settings_fields = new SettingsFields( $settings );

		if ( ! isset( $settings_fields->fields ) ) {
			return $css;
		}

		$css .= ':root {';

		foreach ( $settings_fields->fields as $field ) {
			if ( $field->variable ) {
				$value = isset( $field->parent_field ) && $field->parent_field
					? $settings[ $field->section_id ][ $field->parent_field ][ $field->id ]
					: $settings[ $field->section_id ][ $field->id ];

				if ( $value ) {
					$css .= self::variable_values( $field->variable, $value );
				}
			}
		}

		$css .= '}';

		return $css;
	}

	/**
	 * Sanitize settings callback
	 *
	 * @param  array $input     New values
	 * @return array $sanitized Sanitized settings values
	 */
	public function sanitize_setting_values( $input ) {
		$sanitized = [];
		$sanitized = apply_filters( 'yext_sanitize_settings', $sanitized, $input );
		return $sanitized;
	}

	/**
	 * Admin settings page callback
	 *
	 * @return void
	 */
	public function render_settings_page() {
			settings_errors( static::SETTINGS_NAME );
			settings_errors( 'general' );

			include_once YEXT_INC . 'partials/settings.php';
		?>
		
		<?php
	}

	/**
	 * Add style variables
	 *
	 * @param string $key   The variable key
	 * @param string $value The value
	 *
	 * @return string Valid CSS variable and value
	 */
	public static function variable_values( $key, $value ) {
		$pixel_value = [
			'--yxt-searchbar-form-border-radius',
			'--yxt-searchbar-text-font-size',
			'--yxt-searchbar-placeholder-font-size',
			'--yxt-autocomplete-text-font-size',
		];

		if ( 'create' === $key ) {
			return '';
		}

		if ( is_array( $value ) ) {
			foreach ( $value as $inner_key => $val ) {
				$css = self::variable_values( $inner_key, $val, $key . '-' );
				return esc_html( $css );
			}
		} else {
			if ( in_array( $key, $pixel_value, true ) ) {
				$value = $value . 'px';
			}

			return esc_html( sanitize_text_field( $key . ':' . $value . ';' ) );
		}
	}

	/**
	 * Wizard admin page callback
	 *
	 * @return void
	 */
	public function render_wizard_page() {
		settings_errors( static::SETTINGS_NAME );
		settings_errors( 'general' );

		include_once YEXT_INC . 'partials/wizard.php';
	}

	/**
	 * Localized settings passed to front-end
	 *
	 * @return array $settings
	 */
	public static function localized_settings() {
		$settings = self::get_settings();

		if ( ! isset( $settings['plugin'] ) || ! isset( $settings['search_bar'] ) ) {
			return $settings;
		}

		// Merge existing settings and new props
		$props      = array_merge(
			$settings['search_bar']['props'],
			$settings['search_bar']['core'],
			[
				'redirect_url' => get_permalink( intval( $settings['search_results']['results_page'] ) ),
			]
		);
		$components = [
			'search_bar' => array_merge(
				$settings['search_bar'],
				[
					'props' => $props,
				]
			),
		];

		return [
			'config'     => array_merge( $settings['plugin'], [ 'locale' => 'en' ] ),
			'components' => $components,
		];
	}
}
