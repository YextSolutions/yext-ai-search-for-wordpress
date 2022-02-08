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
			echo '<div class="' . esc_attr( $wrapper_class ) . ' ' . esc_attr( $args['classname'] ) . '">';

			if ( isset( $args['help'] ) ) {
				printf(
					'<button class="data-tippy-content" data-tippy-content="%s" type="button">
						<span class="visually-hidden">%s</span>
						<svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M8 16A8 8 0 1 0 8-.001 8 8 0 0 0 8 16Zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287H8.93ZM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" fill="currentColor"/>
						</svg>
					</button>',
					esc_attr( $args['help'] ),
					esc_html( 'Toggle tooltip', 'yext' )
				);
			}
			do_settings_sections( "yext-settings-{$this->tab_id}-{$id}" );
			echo '</div>';
		}
	}
}
