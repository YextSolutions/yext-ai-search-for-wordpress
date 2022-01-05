<?php
/**
 * Setup Wizard template
 *
 * @package Yext
 */

use Yext\Admin\Settings;
use Yext\Admin\Tabs\Tab;

$core_search_bar_sections         = [
	'core'         => [
		'classname' => '',
		'title'     => '',
	],
];
$plugin_search_bar_sections       = [
	'props'        => [
		'classname' => '',
		'title'     => '',
	],
];
$plugin_search_bar_style_sections = [
	'style'        => [
		'classname' => 'accordion',
		'title'     => __( 'General', 'yext' ),
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

$plugin_settings                  = new Tab( Settings::PLUGIN_SETTINGS_SECTION_NAME, 'API & Properties' );
$search_bar_core_settings         = new Tab( Settings::SEARCH_BAR_SECTION_NAME, 'Search Bar', $core_search_bar_sections );
$search_bar_plugin_settings       = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $plugin_search_bar_sections );
$search_bar_plugin_style_settings = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $plugin_search_bar_style_sections );
$search_results_settings          = new Tab( Settings::SEARCH_RESULTS_SECTION_NAME, 'Search Results' );
$wizard_settings                  = new Tab( Settings::WIZARD_SECTION_NAME, 'Wizard Results' );

$tabs = [ $search_bar_core_settings, $search_results_settings, $plugin_settings ];
?>

<div class="yext-styles-wrapper">
	<div class="yext-container">
		<div id="yext-settings">
		<?php
		$view = 'settings';
		include_once YEXT_INC . 'partials/header.php';
		?>

			<h1><?php echo esc_html( 'Settings', '' ); ?></h1>

			<form method="post" action="options.php">
				<div class="tabs">
					<div class="tab-control">
						<ul class="tab-list" role="tablist">
							<?php
							foreach ( $tabs as $tab ) {
								$tab->render_tab_nav();
							}
							?>
						</ul>
					</div>
					<div class="tab-group">
						<div class="tab-content" id="<?php echo esc_attr( Settings::SEARCH_BAR_SECTION_NAME ); ?>" role="tabpanel">
							<div class="yext-settings__card mb-medium">
								<div class="yext-settings__card-inner">
									<div class="yext-settings__card-content">
										<div class="yext-settings__card-header">
											<h2>
												<?php echo esc_html( 'Global search', 'yext' ); ?>
											</h2>
											<p>
												<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
											</p>
										</div>
										<div class="yext-settings__form-content">
											<?php $search_bar_core_settings->render_content(); ?>
											<?php do_action( 'yext_after_plugin_settings', Settings::SEARCH_BAR_SECTION_NAME ); ?>
										</div>
									</div>
									<div class="yext-settings__card-image">
										<img src="https://via.placeholder.com/260/C2D1D9" alt="">
									</div>
								</div>
							</div>

							<div class="yext-settings__card mb-medium">
								<div class="yext-settings__card-inner">
									<div class="yext-settings__card-content">
										<div class="yext-settings__card-header">
											<h2>
												<?php echo esc_html( 'Customize your search bar', 'yext' ); ?>
											</h2>
											<p>
												<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
											</p>
										</div>
										<div class="yext-settings__form-content">
											<?php $search_bar_plugin_settings->render_content(); ?>

											<h3>
												<?php echo esc_html( 'CSS Styles', 'yext' ); ?>
											</h3>

											<?php $search_bar_plugin_style_settings->render_content(); ?>
										</div>
									</div>
									<div class="yext-settings__card-preview">
										<?php include_once YEXT_INC . 'partials/preview/search-bar.php'; ?>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-content" id="<?php echo esc_attr( Settings::SEARCH_RESULTS_SECTION_NAME ); ?>" role="tabpanel">
							<div class="yext-settings__card mb-medium">
								<div class="yext-settings__card-inner">
									<div class="yext-settings__card-content">
										<div class="yext-settings__card-header">
											<h2>
												<?php echo esc_html( 'Search results settings', 'yext' ); ?>
											</h2>
											<p>
												<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
											</p>
										</div>
										<div class="yext-settings__form-content">
											<?php $search_results_settings->render_content(); ?>
											<?php do_action( 'yext_after_plugin_settings', Settings::SEARCH_RESULTS_SECTION_NAME ); ?>
										</div>
									</div>
									<div class="yext-settings__card-image">
										<img src="https://via.placeholder.com/260/C2D1D9" alt="">
									</div>
								</div>
							</div>
						</div>

						<div class="tab-content" id="<?php echo esc_attr( Settings::PLUGIN_SETTINGS_SECTION_NAME ); ?>" role="tabpanel">
							<div class="yext-settings__card mb-medium">
								<div class="yext-settings__card-inner">
									<div class="yext-settings__card-content">
										<div class="yext-settings__card-header">
											<h2>
												<?php echo esc_html( 'Copy paste your Yext API keys and other properties', 'yext' ); ?>
											</h2>
											<p>
												<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
											</p>
										</div>
										<div class="yext-settings__form-content">
											<?php $plugin_settings->render_content(); ?>
											<?php do_action( 'yext_after_plugin_settings', Settings::PLUGIN_SETTINGS_SECTION_NAME ); ?>
										</div>
									</div>
									<div class="yext-settings__card-image">
										<img src="https://via.placeholder.com/260/C2D1D9" alt="">
									</div>
								</div>
							</div>
						</div>

						<div class="tab-content" id="<?php echo esc_attr( Settings::WIZARD_SECTION_NAME ); ?>" role="tabpanel">
							<div class="yext-settings__card mb-medium">
								<div class="yext-settings__card-inner">
									<div class="yext-settings__card-content">
										<div class="yext-settings__form-content">
											<?php $wizard_settings->render_content(); ?>
											<?php do_action( 'yext_after_plugin_settings', Settings::WIZARD_SECTION_NAME ); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
					settings_fields( 'yext_option_group' );
					include_once YEXT_INC . 'partials/footer.php';
				?>
			</form>
		</div>
	</div>
</div>
