<?php
/**
 * Setup Wizard template
 *
 * @package Yext
 */

use Yext\Admin\Settings;
use Yext\Admin\Tabs\Tab;

$core_search_bar_sections         = [
	'core' => [
		'classname' => '',
		'title'     => '',
	],
];
$plugin_search_bar_sections       = [
	'props' => [
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

$plugin_settings                  = new Tab( Settings::PLUGIN_SETTINGS_SECTION_NAME, __( 'API & Properties', 'yext' ) );
$search_bar_core_settings         = new Tab( Settings::SEARCH_BAR_SECTION_NAME, __( 'Search Bar', 'yext' ), $core_search_bar_sections );
$search_bar_plugin_settings       = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $plugin_search_bar_sections );
$search_bar_plugin_style_settings = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $plugin_search_bar_style_sections );
$search_results_settings          = new Tab( Settings::SEARCH_RESULTS_SECTION_NAME, __( 'Search Results', 'yext' ) );
$wizard_settings                  = new Tab( Settings::WIZARD_SECTION_NAME, __( 'Wizard Results', 'yext' ) );

$tabs = [ $search_bar_core_settings, $search_results_settings, $plugin_settings ];

$settings         = Settings::get_settings();
$is_live          = isset( $settings['wizard'] ) ? true === $settings['wizard']['live'] : false;
$is_banner_hidden = true === $settings['banner_hidden'];
?>

<div class="yext-styles-wrapper">
	<div class="yext-container">
		<div id="yext-settings">
			<?php
			$view = 'settings'; // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
			require_once YEXT_INC . 'partials/header.php';
			?>

			<?php
			if ( $is_live && ! $is_banner_hidden ) :
				include_once YEXT_INC . 'partials/banner.php';
			endif;
			?>

			<h1><?php echo esc_html__( 'Settings', 'yext' ); ?></h1>

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
										<div class="yext-settings__card-header mb-default">
											<h2>
												<?php echo esc_html__( 'Global search', 'yext' ); ?>
											</h2>
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
												<?php echo esc_html__( 'Customize your search bar', 'yext' ); ?>
											</h2>
											<p>
												<?php echo esc_html__( ' Design your search bar by adding some of the details below. See the diagram below for questions about what each input refers to.', 'yext' ); ?>
											</p>
										</div>
										<div class="yext-settings__form-content">
											<?php $search_bar_plugin_settings->render_content(); ?>

											<h3>
												<?php echo esc_html__( 'CSS Styles', 'yext' ); ?>
											</h3>

											<?php $search_bar_plugin_style_settings->render_content(); ?>

											<button class="yext-settings__button--is-style-link is-color-blue mt-large" data-action="reset-css">
												<?php echo esc_html__( 'Reset all custom CSS', 'yext' ); ?>
											</button>
										</div>
									</div>
									<div class="yext-settings__card-preview">
										<h4>
											<?php echo esc_html__( 'Preview of Search Bar', 'yext' ); ?>
										</h4>
										<?php require_once YEXT_INC . 'partials/preview/search-bar.php'; ?>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-content" id="<?php echo esc_attr( Settings::SEARCH_RESULTS_SECTION_NAME ); ?>" role="tabpanel">
							<div class="yext-settings__card mb-medium">
								<div class="yext-settings__card-inner">
									<div class="yext-settings__card-content">
										<div class="yext-settings__card-header mb-default">
											<h2>
												<?php echo esc_html__( 'Search results settings', 'yext' ); ?>
											</h2>
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
												<?php echo esc_html__( 'Input Experience Details', 'yext' ); ?>
											</h2>
											<p>
												<?php
												printf(
													/* translators: 1: Javascript Version article URL */
													__( 'In your Yext account, navigate to your <strong>Answers</strong> experience details by clicking Answers on the Navigation Bar. If you have multiple experiences, click <strong>View Experience</strong> and choose which one you’d like to bring to WordPress. Click <strong>Experience Details</strong> on the left-side panel, and copy the <strong>Experience Key</strong>, <strong>API Key</strong>, and <strong>Business ID</strong> below. The <strong>Locale</strong> for English sites will always be ‘en’, and the latest <strong>Javascript Version</strong> (ex v1.7) can be found <a href="%1$s" target="_blank">here</a>' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													esc_url( 'https://hitchhikers.yext.com/community/t/answers-search-ui-changelog/579' )
												);
												?>
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
					$view = 'settings';// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
					require_once YEXT_INC . 'partials/footer.php';
				?>
			</form>
		</div>
	</div>
</div>
