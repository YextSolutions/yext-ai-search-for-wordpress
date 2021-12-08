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
	 * svg icon for menu
	 *
	 * @var string
	 */
	private $menu_icon = YEXT_URL . '/assets/images/menu-icon.svg';

	/**
	 * Return plugin options from the DB
	 *
	 * @return array
	 */
	public static function get_settings() {
		return get_option( static::SETTINGS_NAME, [] );
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
			'props'        => __( 'Display Settings', 'yext' ),
			'style'        => __( 'Base Styles', 'yext' ),
			'button'       => __( 'Button Styles', 'yext' ),
			'autocomplete' => __( 'Autocomplete Styles', 'yext' ),
		];
		$search_bar_tab = new Tab( self::SEARCH_BAR_SECTION_NAME, __( 'Search bar settings', 'yext' ), $child_sections );
		$search_res_tab = new Tab( self::SEARCH_RESULTS_SECTION_NAME, __( 'Search results settings', 'yext' ) );

		$this->tabs = [ $plugin_tab, $search_bar_tab, $search_res_tab ];

		add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );
		add_action( 'admin_init', [ $this, 'admin_page_init' ], 10 );
		add_action( 'admin_head', [ $this, 'print_css_variables' ], 10 );
		add_action( 'yext_after_plugin_settings', [ $this, 'after_plugin_settings' ], 10 );
	}

	/**
	 * Add plugin page
	 *
	 * @return void
	 */
	public function add_plugin_page() {
		add_menu_page(
			__( 'Yext', 'yext' ),
			__( 'Yext', 'yext' ),
			'manage_options',
			'yext',
			[ $this, 'render_settings_page' ],
			$this->menu_icon
		);
		add_submenu_page(
			'yext',
			__( 'Settings', 'yext' ),
			__( 'Settings', 'yext' ),
			'manage_options',
			'yext',
			[ $this, 'render_settings_page' ]
		);
		add_submenu_page(
			'yext',
			__( 'Wizard', 'yext' ),
			__( 'Wizard', 'yext' ),
			'manage_options',
			'yext-wizard',
			[ $this, 'render_wizard_page' ]
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
	 * Add style variables
	 *
	 * @return void
	 */
	public static function print_css_variables() {

		$settings        = self::get_settings();
		$settings_fields = new SettingsFields( $settings );

		if ( ! isset( $settings_fields->fields ) ) {
			return;
		}
		?>
		<style>
		:root {
			<?php
			foreach ( $settings_fields->fields as $field ) {
				if ( $field->variable ) {
					$value = isset( $field->parent_field ) && $field->parent_field
						? $settings[ $field->section_id ][ $field->parent_field ][ $field->id ]
						: $settings[ $field->section_id ][ $field->id ];
					self::variable_values( $field->variable, $value );
				}
			}
			?>
		}
		</style>
		<?php
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
		?>
		<div id="yext-settings">
			<h2>
				<?php
					echo esc_html__( 'Yext', 'yext' );
				?>
			</h2>
			<form method="post" action="options.php">
				<div class="tabs">
					<div class="tab-control">
						<ul class="tab-list" role="tablist">
							<?php
							foreach ( $this->tabs as $tab ) {
								$tab->render_tab_nav();
							}
							?>
						</ul>
					</div>
					<div class="tab-group">
						<?php
						foreach ( $this->tabs as $tab ) {
							$tab->render_tab_content();
						}
						?>
					</div><!-- /.tab-group -->
				</div><!-- /.tabs -->
				<?php
					settings_fields( 'yext_option_group' );
					submit_button();
				?>
			</form>
		</div>
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
			'--yxt-autocomplete-text-font-size',
		];

		if ( 'create' === $key ) {
			return;
		}

		if ( is_array( $value ) ) {
			foreach ( $value as $inner_key => $val ) {
				$css = self::variable_values( $inner_key, $val, $key . '-' );
				echo esc_html( $css );
			}
		} else {
			if ( in_array( $key, $pixel_value ) ) {
				$value = $value . 'px';
			}

			echo esc_html( sanitize_text_field( $key . ':' . $value . ';' ) );
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
		?>
		<div id="yext-settings-wizard">
			<form method="post" action="options.php">
				<?php
				foreach ( $this->tabs as $tab ) {
					$tab->render_content();
				}
				settings_fields( 'yext_option_group' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Called after plugin settings
	 *
	 * @param string $tab_id Tab id
	 * @return void
	 */
	public function after_plugin_settings( $tab_id ) {
		switch ( $tab_id ) {
			case 'search_bar':
				$this->search_bar_preview();
				break;
			default:
				break;
		}
	}

	/**
	 * Load the search bar preview
	 *
	 * @return void
	 */
	public function search_bar_preview() {
		include_once YEXT_INC . 'partials/preview/search-bar.php';
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

		return [
			'config'     => array_merge( $settings['plugin'], [ 'locale' => 'en' ] ),
			'components' => [
				'search_bar' => array_merge(
					$settings['search_bar'],
					[
						'props' => array_merge(
							$settings['search_bar']['props'],
							[
								'redirect_url' => get_post_field(
									'post_name',
									$settings['search_results']['results_page']
								),
							]
						),
					]
				),
			],
		];
	}
}
