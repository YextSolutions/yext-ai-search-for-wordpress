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
		'help'      => __( 'CSS settings for all search bar text (except autocomplete, which is configured below).', 'yext' ),
	],
	'placeholder'       => [
		'classname' => 'accordion',
		'title'     => __( 'Placeholder', 'yext' ),
		'help'      => __( 'CSS settings for the placeholder text which appears before a query is input.', 'yext' ),
	],
	'button'       => [
		'classname' => 'accordion',
		'title'     => __( 'Button', 'yext' ),
		'help'      => __( 'CSS settings for the search button.', 'yext' ),
	],
	'autocomplete' => [
		'classname' => 'accordion',
		'title'     => __( 'Autocomplete', 'yext' ),
		'help'      => __( 'CSS settings for the autocomplete options that appear below the user is typing.', 'yext' ),
	],
];

$step_progress_map = [
	'0',
	'0',
	'0',
	'1',
	'2',
	'2',
	'3',
	'4',
];

$plugin_settings                  = new Tab( Settings::PLUGIN_SETTINGS_SECTION_NAME, '' );
$search_bar_core_settings         = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $core_search_bar_sections );
$search_bar_plugin_settings       = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $plugin_search_bar_sections );
$search_bar_plugin_style_settings = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $plugin_search_bar_style_sections );
$search_results_settings          = new Tab( Settings::SEARCH_RESULTS_SECTION_NAME, '' );

$settings     = Settings::get_settings();
$current_step = isset( $settings['wizard'] ) && isset( $settings['wizard']['current_step'] ) ? $settings['wizard']['current_step'] : false;
$is_live      = isset( $settings['wizard'] ) ? $settings['wizard']['live'] : false;
?>

<div class="yext-styles-wrapper">
	<div class="yext-container yext-container--wizard">
		<div
			id="yext-wizard"
			class="yext-wizard"
			data-step="<?php echo esc_attr( $current_step ); ?>"
			data-progress-id="<?php echo esc_attr( $step_progress_map[ $current_step ] ); ?>"
			data-is-live="<?php echo esc_attr( $is_live ); ?>"
			data-is-loaded="<?php echo esc_attr( '0' ); ?>"
		>
		<?php
		$view = 'wizard';
		include_once YEXT_INC . 'partials/header.php';
		?>

			<div class="yext-wizard__timeline" style="display:none">
				<div class="yext-wizard__timeline-step yext-wizard__timeline-step--active" data-progress-id="0">
					<div class="yext-wizard__timeline-step-circle-wrapper">
						<div class="yext-wizard__timeline-step-circle"></div>
					</div>
					<div class="yext-wizard__timeline-step-title">
						<?php echo esc_html__( 'Initial Questions', 'yext' ); ?>
					</div>
				</div>
				<div class="yext-wizard__timeline-step" data-progress-id="1">
					<div class="yext-wizard__timeline-step-circle-wrapper">
						<div class="yext-wizard__timeline-step-circle"></div>
					</div>
					<div class="yext-wizard__timeline-step-title">
						<?php echo esc_html__( 'Experience Details', 'yext' ); ?>
					</div>
				</div>
				<div class="yext-wizard__timeline-step" data-progress-id="2">
					<div class="yext-wizard__timeline-step-circle-wrapper">
						<div class="yext-wizard__timeline-step-circle"></div>
					</div>
					<div class="yext-wizard__timeline-step-title">
						<?php echo esc_html( 'Search Bar Settings', 'yext' ); ?>
					</div>
				</div>
				<div class="yext-wizard__timeline-step" data-progress-id="3">
					<div class="yext-wizard__timeline-step-circle-wrapper">
						<div class="yext-wizard__timeline-step-circle"></div>
					</div>
					<div class="yext-wizard__timeline-step-title">
						<?php echo esc_html( 'Search Results Settings', 'yext' ); ?>
					</div>
				</div>
				<div class="yext-wizard__timeline-step" data-progress-id="4">
					<div class="yext-wizard__timeline-step-circle-wrapper">
						<div class="yext-wizard__timeline-step-circle"></div>
					</div>
					<div class="yext-wizard__timeline-step-title">
						<?php echo esc_html( 'Go Live', 'yext' ); ?>
					</div>
				</div>
			</div>

			<form class="yext-settings__form" method="post" action="options.php">
				<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[0] ); ?>">
					<div class="yext-settings__card">
						<div class="yext-settings__card-content yext-settings__card-content--center">
							<div class="yext-wizard__banner banner" style="background-image: url(<?php echo esc_url( YEXT_URL . 'dist/images/yext-banner-background.jpeg' ); ?>)">
								<div class="banner-edge-topleft"></div>
								<div class="banner-edge-topright"></div>
								<div class="banner-edge-bottomleft"></div>
								<div class="banner-edge-bottomright"></div>
								<svg class="yext-logo" height="130" width="130" viewBox="0 0 720 720" xmlns="http://www.w3.org/2000/svg">
									<path d="M360 0C161.18 0 0 161.18 0 360s161.18 360 360 360 360-161.18 360-360S558.82 0 360 0Zm0 691.2C177.08 691.2 28.8 542.92 28.8 360S177.08 28.8 360 28.8 691.2 177.08 691.2 360 542.92 691.2 360 691.2Z" fill="currentColor"/>
									<path d="M370.8 399.6h64.8v129.6h28.8V399.6h64.8v-28.8H370.8v28.8Zm-38.37-32.4L270 429.64l-62.43-62.44-20.37 20.37L249.64 450l-62.44 62.43 20.37 20.37L270 470.36l62.43 62.44 20.37-20.37L290.36 450l62.44-62.43-20.37-20.37Zm115.77-18c44.73 0 81-36.27 81-81h-28.8c0 28.83-23.37 52.2-52.2 52.2-8.23 0-16.01-1.91-22.93-5.3l90.91-90.91c-14.44-22.25-39.48-36.98-67.98-36.98-44.74 0-81 36.27-81 81s36.26 80.99 81 80.99Zm0-133.2c10.12 0 19.56 2.89 27.56 7.88l-71.88 71.88c-4.99-8-7.87-17.44-7.87-27.56-.01-28.83 23.36-52.2 52.19-52.2ZM270 259.58l-60.74-72.38-22.06 18.51 68.4 81.52v61.97h28.8v-61.97l68.4-81.52-22.06-18.51L270 259.58Z" fill="currentColor"/>
								</svg>
								<h1>
									<?php echo esc_html__( 'Welcome to Yext AI Search', 'yext' ); ?>
								</h1>
								<p>
									<?php echo esc_html__( 'Eager to add or improve search on your WordPress site? Use this plugin to embed Answers, Yext’s AI-powered search experience, directly onto your site.', 'yext' ); ?>
								</p>
							</div>
							<div class="yext-settings__card-header">
								<h2>
									<?php echo esc_html__( 'Do you have a Yext account?', 'yext' ); ?>
								</h2>
							</div>
							<div class="yext-settings__form-content">
								<div class="yext-settings__button-cards yext-settings__button-cards--center">
									<button class="yext-settings__button yext-settings__button--primary is-style-outline with-icon yext-wizard__next">
										<span>
											<?php
											echo sprintf(
												'<strong>%s</strong>, %s',
												esc_html__( 'Yes', 'yext' ),
												esc_html__( "I'm all set", 'yext' )
											);
											?>
										</span>
										<svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M7 0 5.766 1.234l4.883 4.891H0v1.75h10.649l-4.883 4.891L7 14l7-7-7-7Z" fill="black"/>
										</svg>
									</button>
									<a href="<?php echo esc_url( 'https://www.yext.com/try/wordpress/?utm_source=wordpress&utm_medium=partner&utm_content=site_search_cms_wordpress_free_trial_web&utm_campaign=site_search_cms_wordpress' ); ?>" data-target="3" target="_blank" rel="noopener" class="yext-settings__button yext-settings__button--primary with-icon">
										<span>
											<?php
											echo sprintf(
												'<strong>%s</strong>, %s',
												esc_html__( 'No', 'yext' ),
												esc_html__( "Let's sign up", 'yext' )
											);
											?>
										</span>
										<svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M4.667 0v1.333H1.333v9.334h9.334V7.333H12v4a.666.666 0 0 1-.667.667H.667A.666.666 0 0 1 0 11.333V.667A.667.667 0 0 1 .667 0h4Zm5.057 1.333H6.667V0H12v5.333h-1.333V2.276L6 6.943 5.057 6l4.667-4.667Z" fill="black"/>
										</svg>
									</a>
								</div>
							</div>
						</div>
					</div>
					
					<div class="yext-settings__card-footer">
						<h1>
							<?php echo esc_html__( 'Thousands of brands deliver millions of answers with Yext. Hear some of their stories.', 'yext' ); ?>
						</h1>

						<div class="yext-settings__logo-grid logo-grid">
							<ul>
								<?php
									// Samsung
									printf(
										'<li><a href="%s" target="_blank"><img src="%s" loading="lazy" alt="%s"></a></li>',
										esc_url( 'https://www.yext.com/customers/samsung' ),
										esc_url( YEXT_URL . 'dist/images/logos/samsung.png' ),
										esc_html__( 'Samsung logo', 'yext' )
									);
									// People's United
									printf(
										'<li><a href="%s" target="_blank"><img src="%s" loading="lazy" alt="%s"></a></li>',
										esc_url( 'https://www.yext.com/customers/peoples-united-bank' ),
										esc_url( YEXT_URL . 'dist/images/logos/peoples_united_bank.png' ),
										esc_html__( 'People\'s United logo', 'yext' )
									);
									// Cox
									printf(
										'<li><a href="%s" target="_blank"><img src="%s" loading="lazy" alt="%s"></a></li>',
										esc_url( 'https://www.yext.com/customers/cox-communications' ),
										esc_url( YEXT_URL . 'dist/images/logos/cox.png' ),
										esc_html__( 'Cox logo', 'yext' )
									);
									// Fazoli's
									printf(
										'<li><a href="%s" target="_blank"><img src="%s" loading="lazy" alt="%s"></a></li>',
										esc_url( 'https://www.yext.com/customers/fazolis' ),
										esc_url( YEXT_URL . 'dist/images/logos/fazolis.png' ),
										esc_html__( 'Fazoli\'s logo', 'yext' )
									);
									// Cox
									printf(
										'<li><a href="%s" target="_blank"><img src="%s" loading="lazy" alt="%s"></a></li>',
										esc_url( 'https://www.yext.com/customers/marstons' ),
										esc_url( YEXT_URL . 'dist/images/logos/marstons.png' ),
										esc_html__( 'Marston\'s logo', 'yext' )
									);
									?>
							</ul>
							<p>
								<?php
								echo sprintf(
									'%s <a href="%s" target="_blank">%s</a>',
									esc_html__( 'Have questions or want to learn more?', 'yext' ),
									'https://hitchhikers-answers.yext.com/?query=answers+for+wordpress',
									esc_html__( 'Ask Yext!', 'yext' )
								);
								?>
							</p>
						</div>
					</div>
				</div>

				<div class="yext-wizard__step yext-wizard__step--has-circle yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[1] ); ?>">
					<div class="yext-settings__card">
						<button class="yext-settings__button yext-settings__button--is-style-link yext-wizard__back">
							<svg width="6" height="10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.714 1.429 2.143 5l3.571 3.571L5 10 0 5l5-5 .714 1.429Z" fill="black"/>
							</svg>
							<?php echo esc_html__( 'Back', 'yext' ); ?>
						</button>
						<div class="yext-settings__card-content yext-settings__card-content--width-75">
							<div class="yext-settings__card-header">
								<h2>
									<?php echo esc_html__( 'Do you need to pull data from WordPress into Yext?', 'yext' ); ?>
								</h2>
								<p>
									<?php echo esc_html__( 'Using built-in data connectors, you can pull in your posts, pages, and media from WordPress into the Yext platform. You can then use this data to power your search experience which will exist on your WordPress site.', 'yext' ); ?>
								</p>
							</div>
							<div class="yext-settings__form-content">
								<div class="yext-settings__button-cards">
									<a href="<?php echo esc_url( 'https://hitchhikers.yext.com/guides/answers-wordpressintegration-guide/01-pull-wordpress-data-into-yext/?utm_source=wordpress&utm_medium=partner&utm_content=site_search_cms_wordpress_pull_wordpress_data_web&utm_campaign=site_search_cms_wordpress' ); ?>" target="_blank" rel="noopener" class="yext-settings__button yext-settings__button--primary with-icon">
										<span>
											<?php
											echo sprintf(
												'<strong>%s</strong>, %s',
												esc_html__( 'Yes', 'yext' ),
												esc_html__( 'index data', 'yext' )
											);
											?>
										</span>
										<svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M4.667 0v1.333H1.333v9.334h9.334V7.333H12v4a.666.666 0 0 1-.667.667H.667A.666.666 0 0 1 0 11.333V.667A.667.667 0 0 1 .667 0h4Zm5.057 1.333H6.667V0H12v5.333h-1.333V2.276L6 6.943 5.057 6l4.667-4.667Z" fill="black"/>
										</svg>
									</a>
									<button class="yext-settings__button yext-settings__button--primary is-style-outline with-icon yext-wizard__next">
										<span>
											<?php
											echo sprintf(
												'<strong>%s</strong>, %s',
												esc_html__( 'No', 'yext' ),
												esc_html__( "I'm all set", 'yext' )
											);
											?>
										</span>
										<svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M7 0 5.766 1.234l4.883 4.891H0v1.75h10.649l-4.883 4.891L7 14l7-7-7-7Z" fill="black"/>
										</svg>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="yext-wizard__step yext-wizard__step--has-circle yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[2] ); ?>">
					<div class="yext-settings__card">
						<button class="yext-settings__button yext-settings__button--is-style-link yext-wizard__back">
							<svg width="6" height="10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.714 1.429 2.143 5l3.571 3.571L5 10 0 5l5-5 .714 1.429Z" fill="black"/>
							</svg>
							<?php echo esc_html__( 'Back', 'yext' ); ?>
						</button>
						<div class="yext-settings__card-content yext-settings__card-content--width-75">
							<div class="yext-settings__card-header">
								<h2>
									<?php echo esc_html__( 'Build Your Answers Experience', 'yext' ); ?>
								</h2>
								<p>
									<?php echo esc_html__( 'If you have not already configured an Answers experience, you\'ll first need to build one on the Yext Platform.', 'yext' ); ?>
									<?php
									printf(
										/* translators: 1: Learn how to do so using our Yext AI Search for WordPress guide URL  */
										__( '<a href="%1$s" class="is-external" target="_blank">Learn how to do so using our Yext AI Search for WordPress guide!</a>' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										// TODO: Yext to provide link.
										esc_url( 'https://hitchhikers.yext.com/guides/answers-wordpressintegration-guide/02-add-answers-to-wordpress/?target=step-3-create-an-answers-experience&utm_source=wordpress&utm_medium=partner&utm_content=site_search_cms_wordpress_create_answers_experience_web&utm_campaign=site_search_cms_wordpress' )
									);
									?>
								</p>
								<p>
									<?php echo esc_html__( 'If you\'ve already built an Answers experience, you can go to the next step.', 'yext' ); ?>
								</p>
							</div>
							<div class="yext-settings__form-content">
								<div class="yext-settings__button-cards">
									<a href="<?php echo esc_url( 'https://hitchhikers.yext.com/guides/answers-wordpressintegration-guide/02-add-answers-to-wordpress/?target=step-3-create-an-answers-experience&utm_source=wordpress&utm_medium=partner&utm_content=site_search_cms_wordpress_create_answers_experience_web&utm_campaign=site_search_cms_wordpress' ); ?>" target="_blank" rel="noopener" class="yext-settings__button yext-settings__button--primary with-icon">
										<span><?php echo esc_html__( 'Create Answers Experience', 'yext' ); ?></span>
										<svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M4.667 0v1.333H1.333v9.334h9.334V7.333H12v4a.666.666 0 0 1-.667.667H.667A.666.666 0 0 1 0 11.333V.667A.667.667 0 0 1 .667 0h4Zm5.057 1.333H6.667V0H12v5.333h-1.333V2.276L6 6.943 5.057 6l4.667-4.667Z" fill="black"/>
										</svg>
									</a>
									<button class="yext-settings__button yext-settings__button--primary is-style-outline with-icon yext-wizard__next">
										<span><?php echo esc_html__( 'Next', 'yext' ); ?></span>
										<svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M7 0 5.766 1.234l4.883 4.891H0v1.75h10.649l-4.883 4.891L7 14l7-7-7-7Z" fill="black"/>
										</svg>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[3] ); ?>">
					<div class="yext-settings__card">
						<div class="yext-settings__card-inner">
							<div class="yext-settings__card-content">
								<div class="yext-settings__card-header">
									<h2>
										<?php echo esc_html__( 'Input Experience Details', 'yext' ); ?>
									</h2>
									<p>
										<?php echo esc_html__( 'Copy the following experience details from your Yext account into the fields below.', 'yext' ); ?>
									</p>
								</div>
								<div class="yext-settings__form-content">
									<?php $plugin_settings->render_content(); ?>
								</div>
							</div>
							<div class="yext-settings__card-image">
								<img src="<?php echo esc_url( YEXT_URL . '/dist/images/yext-answers-dashboard-preview.png' ); ?>" loading="lazy" alt="">
							</div>
						</div>
					</div>
				</div>

				<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[4] ); ?>">
					<div class="yext-settings__card">
						<div class="yext-settings__card-inner">
							<div class="yext-settings__card-content">
								<div class="yext-settings__card-header">
									<h2>
										<?php echo esc_html__( 'Global Search', 'yext' ); ?>
									</h2>
									<p>
										<?php echo esc_html__( 'Check this box if you’d like to replace all instances of core WordPress search bars that get added throughout the site by the theme, plugins, and blocks.', 'yext' ); ?>
									</p>
								</div>
								<div class="yext-settings__form-content">
									<?php $search_bar_core_settings->render_content(); ?>
								</div>
							</div>
							<div class="yext-settings__card-image">
								<img src="<?php echo esc_url( YEXT_URL . '/dist/images/yext-global-search.jpeg' ); ?>" loading="lazy" alt="">
							</div>
						</div>
					</div>
				</div>

				<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[5] ); ?>">
					<div class="yext-settings__card">
						<div class="yext-settings__card-inner">
							<div class="yext-settings__card-content">
								<div class="yext-settings__card-header">
									<h2>
										<?php echo esc_html__( 'Customize Your Search Bar', 'yext' ); ?>
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
								</div>
							</div>
							<div class="yext-settings__card-preview">
								<h4>
									<?php echo esc_html( 'Preview of Search Bar', 'yext' ); ?>
								</h4>
								<?php include_once YEXT_INC . 'partials/preview/search-bar.php'; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[6] ); ?>">
					<div class="yext-settings__card">
						<div class="yext-settings__card-inner">
							<div class="yext-settings__card-content">
								<div class="yext-settings__card-header mb-default">
									<h2>
										<?php echo esc_html__( 'Search Results Settings', 'yext' ); ?>
									</h2>
								</div>
								<div class="yext-settings__form-content">
									<?php $search_results_settings->render_content(); ?>
								</div>
							</div>
							<div class="yext-settings__card-image">
								<img src="<?php echo esc_url( YEXT_URL . '/dist/images/yext-search-results.jpeg' ); ?>" loading="lazy" alt="">
							</div>
						</div>
					</div>
				</div>

				<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[7] ); ?>" data-last-step="1">
					<div class="yext-settings__card">
						<div class="yext-settings__card-inner">
							<div class="yext-settings__card-content">
								<div class="yext-settings__card-header">
									<h2>
										<?php echo esc_html__( 'Go Live!', 'yext' ); ?>
									</h2>
									<p>
										<?php echo esc_html__( 'Congratulations! You’ve finished setting up your Answers Experience on WordPress and are ready to go live. Click Publish to see Yext AI Search live on your site.', 'yext' ); ?>
									</p>
								</div>
							</div>
							<div class="yext-settings__card-image">
								<img src="<?php echo esc_url( YEXT_URL . 'dist/images/yext-live-thumbs-up.jpeg' ); ?>" loading="lazy" alt="">
							</div>
						</div>
						<div class="yext-settings__card-footer">
							<button class="yext-settings__button yext-settings__button--primary yext-wizard__next" data-is-live="1">
								<?php echo esc_html__( 'Publish', 'yext' ); ?>
							</button>
							<button class="yext-settings__button yext-settings__button--is-style-link yext-wizard__back">
								<svg width="6" height="10" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.714 1.429 2.143 5l3.571 3.571L5 10 0 5l5-5 .714 1.429Z" fill="black"/>
								</svg>
								<?php echo esc_html__( 'Back', 'yext' ); ?>
							</button>
						</div>
					</div>
				</div>

				<?php
				$view = 'wizard';
				include_once YEXT_INC . 'partials/footer.php';
				?>
			</form>
		</div>
	</div>
</div>
