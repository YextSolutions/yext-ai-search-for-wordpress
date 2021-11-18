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
	 * Settings name
	 */
	const SETTINGS_NAME = 'yext_plugin_settings';

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
	 * Return plugin options from the DB
	 *
	 * @return array
	 */
	public function get_settings() {
		return get_option( static::SETTINGS_NAME, [] );
	}

	/**
	 * Settings page Setup
	 */
	public function setup() {
		$this->settings = $this->get_settings();

		$plugin_tab     = new Tab( 'plugin-settings-tab', __( 'Plugin settings', 'yext' ) );
		$search_bar_tab = new Tab( 'search-bar-settings-tab', __( 'Search bar settings', 'yext' ) );
		$search_res_tab = new Tab( 'search-results-settings-tab', __( 'Search results settings', 'yext' ) );

		$this->tabs = [ $plugin_tab, $search_bar_tab, $search_res_tab ];

		add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );
		add_action( 'admin_init', [ $this, 'admin_page_init' ], 10 );
	}

	/**
	 * Add plugin page
	 *
	 * * @return void
	 */
	public function add_plugin_page() {
		add_options_page(
			'Yext connector', // page_title
			'Yext connector', // menu_title
			'manage_options', // capability
			'yext-connector', // menu_slug
			[ $this, 'create_admin_page' ] // function
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
			self::SETTINGS_NAME, // option_name
			[ __CLASS__, 'sanitize_setting_values' ] // sanitize_callback
		);

		$fields = new SettingsFields( $this->settings );
	}

	/**
	 * Render settings
	 *
	 * @return void
	 */
	public function enabled_setting_render() {
		$setting_name = 'enabled';
		printf(
			'<input
				type="checkbox"
				name="%s"
				id="%s"
				value="1" %s>
				<label for="%s">%s</label>',
			esc_attr( $this->setting_name( $setting_name ) ),
			esc_attr( $this->setting_name( $setting_name ) ),
			checked( $this->settings[ $setting_name ], 1, false ),
			esc_attr( $this->setting_name( $setting_name ) ),
			esc_html__( 'Enabled', 'yext' )
		);
	}

	/**
	 * Create admin page callback
	 *
	 * @return void
	 */
	public function create_admin_page() {

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
	 * Sanitize settings callback
	 *
	 * @param  array $input     New values
	 * @return array $sanitized Sanitized settings values
	 */
	public function sanitize_setting_values( $input ) {
		// TODO: sanitize values
		return $input;
	}
}
