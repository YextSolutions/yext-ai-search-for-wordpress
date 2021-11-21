<?php
/**
 * Abstract class for a tab within settings
 *
 * @package Yext\Admin\Tab
 */

namespace Yext\Admin\Tabs;

/**
 * Tab class
 */
final class Tab {

	/**
	 * Tab Id
	 *
	 * @var string Tab id
	 */
	public $tab_id;

	/**
	 * Tab title used in front-end for navigation
	 *
	 * @var string Tab title
	 */
	public $title;

	/**
	 * Tab constructor
	 *
	 * @param string $tab_id Tab id
	 * @param string $title  Tab title
	 */
	public function __construct( $tab_id, $title ) {
		$this->tab_id = $tab_id;
		$this->title  = $title;
		$this->setup();
	}


	/**
	 * Init the tab.
	 */
	public function setup() {
		// Piority set to a higher value than the one from Settings class
		add_action( 'admin_init', [ $this, 'register_setting_section' ], 15 );
	}

	/**
	 * Register a setting section for the current tab
	 *
	 * @return void
	 */
	public function register_setting_section() {
		add_settings_section(
			$this->tab_id, // id
			$this->title, // title
			[ $this, 'section_info' ], // callback
			'yext-settings-' . $this->tab_id // page
		);
	}

	/**
	 * Settings section
	 *
	 * @return void
	 */
	public static function section_info() {}

	/**
	 * Helper for rendering a tab nav item
	 *
	 * @return void
	 */
	public function render_tab_nav() {
		printf(
			'<li class="tab-item"><a href="#%s" role="tab" aria-controls="%s">%s</a></li>',
			esc_attr( $this->tab_id ),
			esc_attr( $this->tab_id ),
			esc_html( $this->title )
		);
	}

	/**
	 * Helper for rendering a tab content
	 *
	 * @return void
	 */
	public function render_tab_content() {
		?>
		<div class="tab-content" id="<?php echo esc_attr( $this->tab_id ); ?>" role="tabpanel">
			<?php
			do_settings_sections( "yext-settings-{$this->tab_id}" )
			?>
		</div>
		<?php
	}

	/**
	 * Getter for tab ID
	 *
	 * Used for registering field settings
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->tab_id;
	}
}
