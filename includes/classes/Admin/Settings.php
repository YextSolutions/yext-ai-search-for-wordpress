<?php
/**
 * Admin settings
 *
 * @package Yext\Admin
 */

namespace Yext\Admin;

/**
 * Settings for the plugin
 */
final class Settings {

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
		$this->settings = $this->get_settings();
		add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );
		add_action( 'admin_init', [ $this, 'admin_page_init' ] );
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

		add_settings_section(
			'plugin-settings-tab', // id
			'', // title
			[ __CLASS__, 'section_info' ], // callback
			'yext-settings-plugin-settings-tab' // page
		);

		add_settings_field(
			'enabled', // id
			'Enabled', // title
			[ $this, 'enabled_setting_render' ], // callback
			'yext-settings-plugin-settings-tab', // page
			'plugin-settings-tab' // section
		);
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
								$this->render_tab_nav( 'plugin-settings-tab', __( 'Plugin settings', 'yext' ) );
								$this->render_tab_nav( 'search-bar-settings-tab', __( 'Search bar settings', 'yext' ) );
								$this->render_tab_nav( 'search-results-settings-tab', __( 'Search results settings', 'yext' ) );
							?>
						</ul>
					</div>
					<div class="tab-group">
						<?php
							$this->render_tab_content( 'plugin-settings-tab' );
							$this->render_tab_content( 'search-bar-settings-tab' );
							$this->render_tab_content( 'search-results-settings-tab' );
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
	 * Helper for rendering a tab nav item
	 *
	 * @param string $tab_id Tab ID
	 * @param string $title  Tab title
	 * @return void
	 */
	public function render_tab_nav( $tab_id, $title ) {
		printf(
			'<li class="tab-item"><a href="#%s" role="tab" aria-controls="%s">%s</a></li>',
			esc_attr( $tab_id ),
			esc_attr( $tab_id ),
			esc_html( $title )
		);
	}

	/**
	 * Helper for rendering a tab content
	 *
	 * @param string $tab_id Tab Id
	 * @return void
	 */
	public function render_tab_content( $tab_id ) {
		?>
		<div class="tab-content" id="<?php echo esc_attr( $tab_id ); ?>" role="tabpanel">
			<p><?php echo esc_html( $tab_id ); ?></p>
			<?php
			do_settings_sections( "yext-settings-{$tab_id}" )
			?>
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

	/**
	 * Settings section
	 *
	 * @return void
	 */
	public static function section_info() {}

	/**
	 * Render a checkbox field used on settings.
	 *
	 * @param string $setting_name The setting name
	 * @return void
	 */
	public function render_checkbox_field( $setting_name ) {
		$setting_name = 'enabled';
		printf(
			'<input
				type="checkbox"
				name="%s"
				id="%s"
				value="1" %s>',
			esc_attr( $this->setting_name( $setting_name ) ),
			esc_attr( $this->setting_name( $setting_name ) ),
			checked( $this->settings[ $setting_name ], 1, false )
		);
	}

	/**
	 * Render an input text field used on settings.
	 *
	 * @param  string $setting_name The setting name
	 * @return void
	 */
	public function render_input_field( $setting_name ) {
		$value = $this->settings[ $setting_name ];
		printf(
			'<input
				class="regular-text"
				type="text"
				name="%s"
				id="%s"
				value="%s"
				autocomplete="off">',
			esc_attr( $this->setting_name( $setting_name ) ),
			esc_attr( $setting_name ),
			esc_attr( $value )
		);
	}

	/**
	 * Convert input name to field name
	 *
	 * @param string $field_name Field internal name
	 * @return string            Field name for setting.
	 */
	public function setting_name( $field_name ) {
		return sprintf( '%s[%s]', self::SETTINGS_NAME, $field_name );
	}

	/**
	 * Helper function to prevent field value being exposed
	 *
	 * @param  string $str Entry string
	 * @return string      Masked string
	 */
	public function pad_string( string $str ) {
		return substr( $str, 0, 3 ) . str_pad( substr( $str, -3 ), strlen( $str ) - 3, '*', STR_PAD_LEFT );
	}
}
