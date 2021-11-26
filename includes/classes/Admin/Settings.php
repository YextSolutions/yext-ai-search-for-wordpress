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
			'button'       => __( 'Button', 'yext' ),
			'autocomplete' => __( 'Autocomplete', 'yext' ),
			'create'       => __( 'Create', 'yext' ),
		];
		$search_bar_tab = new Tab( self::SEARCH_BAR_SECTION_NAME, __( 'Search bar settings', 'yext' ), $child_sections );
		$search_res_tab = new Tab( self::SEARCH_RESULTS_SECTION_NAME, __( 'Search results settings', 'yext' ) );

		$this->tabs = [ $plugin_tab, $search_bar_tab, $search_res_tab ];

		add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );
		add_action( 'admin_init', [ $this, 'admin_page_init' ], 10 );
		add_action( 'yext_after_plugin_settings', [ $this, 'after_plugin_settings' ], 10 );
	}

	/**
	 * Add plugin page
	 *
	 * @return void
	 */
	public function add_plugin_page() {
		add_menu_page(
			__( 'Yext connector', 'yext' ),
			__( 'Yext connector', 'yext' ),
			'manage_options',
			'yext-connector',
			[ $this, 'render_settings_page' ],
			$this->menu_icon
		);
		add_submenu_page(
			'yext-connector',
			__( 'Settings', 'yext' ),
			__( 'Settings', 'yext' ),
			'manage_options',
			'yext-connector',
			[ $this, 'render_settings_page' ]
		);
		add_submenu_page(
			'yext-connector',
			__( 'Wizard', 'yext' ),
			__( 'Wizard', 'yext' ),
			'manage_options',
			'yext-connector-wizard',
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
					echo esc_html__( 'Yext connector', 'yext' );
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
		// TODO: review needed settings passed to FE
		return $settings['search_bar'];
	}
}
