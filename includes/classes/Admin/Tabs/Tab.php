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
	 * Additional Child settings sections
	 * to rendering inside the tab
	 *
	 * @var array Tab title
	 */
	public $child_sections = [];

	/**
	 * Tab constructor
	 *
	 * @param string $tab_id         Tab id
	 * @param string $title          Tab title
	 * @param array  $child_sections Additional Child settings sections
	 *                               to rendering inside the tab
	 */
	public function __construct( $tab_id, $title, $child_sections = [] ) {
		$this->child_sections = $child_sections;
		$this->tab_id         = $tab_id;
		$this->title          = $title;
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
			$this->tab_id,
			$this->title,
			[ $this, 'section_info' ],
			'yext-settings-' . $this->tab_id
		);
		foreach ( $this->child_sections as $child_section_id => $args ) {
			add_settings_section(
				$this->tab_id . '-' . $child_section_id,
				$args['title'],
				[ $this, 'section_info' ],
				'yext-settings-' . $this->tab_id . '-' . $child_section_id
			);
		}
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
			$this->render_content();
			do_action( 'yext_after_plugin_settings', $this->tab_id );
			?>
		</div>
		<?php
	}

	/**
	 * Helper for render the settings
	 *
	 * @return void
	 */
	public function render_content() {
		do_settings_sections( "yext-settings-{$this->tab_id}" );
		$this->do_child_sections();
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

	/**
	 * Do the child sections for a tab
	 *
	 * @return void
	 */
	protected function do_child_sections() {
		foreach ( $this->child_sections as $id => $args ) {
			$wrapper_class = sprintf(
				'yext-child-settings-%s-%s',
				esc_attr( sanitize_title_with_dashes( $this->get_id() ) ),
				esc_attr( $id )
			);

			// Fixes for missing indexes
			if ( ! isset( $args['classname'] ) ) {
				$args['classname'] = '';
			}

			if ( ! isset( $args['help'] ) ) {
				$args['help'] = '';
			}

			echo '<div class="' . esc_attr( $wrapper_class ) . ' ' . esc_attr( $args['classname'] ) . '" data-help="' . esc_attr( $args['help'] ) . '">';
			do_settings_sections( "yext-settings-{$this->tab_id}-{$id}" );
			echo '</div>';
		}
	}
}
