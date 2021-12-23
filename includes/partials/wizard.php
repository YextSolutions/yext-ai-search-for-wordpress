<?php
/**
 * Setup Wizard template
 *
 * @package Yext
 */

use Yext\Admin\Settings;
use Yext\Admin\Tabs\Tab;

$core_search_bar_sections   = [
	'core'         => [
		'classname' => '',
		'title'     => '',
	],
];

$plugin_search_bar_sections = [
	'props'        => [
		'classname' => '',
		'title'     => '',
	],
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

$plugin_settings            = new Tab( Settings::PLUGIN_SETTINGS_SECTION_NAME, '' );
$search_bar_core_settings   = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $core_search_bar_sections );
$search_bar_plugin_settings = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $plugin_search_bar_sections );
$search_results_settings    = new Tab( Settings::SEARCH_RESULTS_SECTION_NAME, '' );

$settings     = Settings::get_settings();
$current_step = $settings['wizard']['current_step'];
?>

<div class="yext-wizard" id="yext-wizard" data-step="<?php echo esc_attr( $current_step ); ?>" data-progress-id="<?php echo esc_attr( $step_progress_map[ $current_step ] ); ?>">
	<?php include_once YEXT_INC . 'partials/header.php'; ?>

	<div class="yext-wizard__timeline">
		<div class="yext-wizard__timeline-step yext-wizard__timeline-step--active" data-progress-id="0">
			<div class="yext-wizard__timeline-step-circle-wrapper">
				<div class="yext-wizard__timeline-step-circle"></div>
			</div>
			<div class="yext-wizard__timeline-step-title">
				<?php echo esc_html( 'Answers Experience', 'yext' ); ?>
			</div>
		</div>
		<div class="yext-wizard__timeline-step" data-progress-id="1">
			<div class="yext-wizard__timeline-step-circle-wrapper">
				<div class="yext-wizard__timeline-step-circle"></div>
			</div>
			<div class="yext-wizard__timeline-step-title">
				<?php echo esc_html( 'API Keys', 'yext' ); ?>
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
				<?php echo esc_html( 'Search Bar Results', 'yext' ); ?>
			</div>
		</div>
		<div class="yext-wizard__timeline-step" data-progress-id="4">
			<div class="yext-wizard__timeline-step-circle-wrapper">
				<div class="yext-wizard__timeline-step-circle"></div>
			</div>
			<div class="yext-wizard__timeline-step-title">
				<?php echo esc_html( 'Finish Setup', 'yext' ); ?>
			</div>
		</div>
	</div>

	<form class="yext-wizard__form" method="post" action="options.php">
		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[0] ); ?>">
			<div class="yext-wizard__step-card">
				<div class="yext-wizard__step-content yext-wizard__step-content--center">
					<div class="yext-wizard__step-banner banner">
						<div class="banner-edge-topleft"></div>
						<div class="banner-edge-topright"></div>
						<div class="banner-edge-bottomleft"></div>
						<div class="banner-edge-bottomright"></div>
						<svg class="yext-logo" height="130" width="130" viewBox="0 0 720 720" xmlns="http://www.w3.org/2000/svg">
							<path d="M360 0C161.18 0 0 161.18 0 360s161.18 360 360 360 360-161.18 360-360S558.82 0 360 0Zm0 691.2C177.08 691.2 28.8 542.92 28.8 360S177.08 28.8 360 28.8 691.2 177.08 691.2 360 542.92 691.2 360 691.2Z" fill="currentColor"/>
							<path d="M370.8 399.6h64.8v129.6h28.8V399.6h64.8v-28.8H370.8v28.8Zm-38.37-32.4L270 429.64l-62.43-62.44-20.37 20.37L249.64 450l-62.44 62.43 20.37 20.37L270 470.36l62.43 62.44 20.37-20.37L290.36 450l62.44-62.43-20.37-20.37Zm115.77-18c44.73 0 81-36.27 81-81h-28.8c0 28.83-23.37 52.2-52.2 52.2-8.23 0-16.01-1.91-22.93-5.3l90.91-90.91c-14.44-22.25-39.48-36.98-67.98-36.98-44.74 0-81 36.27-81 81s36.26 80.99 81 80.99Zm0-133.2c10.12 0 19.56 2.89 27.56 7.88l-71.88 71.88c-4.99-8-7.87-17.44-7.87-27.56-.01-28.83 23.36-52.2 52.19-52.2ZM270 259.58l-60.74-72.38-22.06 18.51 68.4 81.52v61.97h28.8v-61.97l68.4-81.52-22.06-18.51L270 259.58Z" fill="currentColor"/>
						</svg>
						<h1><?php echo esc_html( 'Keyword Search is the past. AI Search is the future.', 'yext' ); ?></h1>
						<p><?php echo esc_html( 'Welcome to Yext! Build amazing AI search experiences based on natural language understanding and using a multi-algorithm approach.', 'yext' ); ?></p>
					</div>
					<div class="yext-wizard__step-header">
						<h2>
							<?php echo esc_html( 'Do you have a Yext account?', 'yext' ); ?>
						</h2>
					</div>
					<div class="yext-wizard__step-form">
						<div class="yext-wizard__step-buttons yext-wizard__step-buttons--center">
							<button class="yext-wizard__step-button yext-wizard__next">
								<span>
									<?php
									echo sprintf(
										'<strong>%s</strong>, %s',
										esc_html( 'Yes', 'yext' ),
										esc_html( ' I have a Yext account', 'yext' )
									);
									?>
								</span>
								<svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M7 0 5.766 1.234l4.883 4.891H0v1.75h10.649l-4.883 4.891L7 14l7-7-7-7Z" fill="black"/>
								</svg>
							</button>
							<a href="<?php echo esc_url( 'https://yext.com' ); ?>" target="_blank" rel="noopener" class="yext-wizard__step-button">
								<span>
									<?php
									echo sprintf(
										'<strong>%s</strong>, %s',
										esc_html( 'No', 'yext' ),
										esc_html( 'I like to set one up', 'yext' )
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
			
			<div class="yext-wizard__step-footer">
				<img src="<?php echo esc_url( YEXT_URL . '/dist/images/yext-wizard__intro-footer.png' ); ?>" />
			</div>
		</div>

		<div class="yext-wizard__step yext-wizard__step--has-circle yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[1] ); ?>">
			<div class="yext-wizard__step-card">
				<div class="yext-wizard__step-content yext-wizard__step-content--width-75">
					<div class="yext-wizard__step-header">
						<h2>
							<?php echo esc_html( 'Do you want to connect this website to Yext’s knowledge graph?', 'yext' ); ?>
						</h2>
						<p>
							<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
						</p>
					</div>
					<div class="yext-wizard__step-form">
						<div class="yext-wizard__step-buttons">
							<a href="<?php echo esc_url( 'https://yext.com' ); ?>" target="_blank" rel="noopener" class="yext-wizard__step-button">
								<span>
									<?php
									echo sprintf(
										'<strong>%s</strong>, %s',
										esc_html( 'Yes', 'yext' ),
										esc_html( ' I want to connect my data', 'yext' )
									);
									?>
								</span>
								<svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M4.667 0v1.333H1.333v9.334h9.334V7.333H12v4a.666.666 0 0 1-.667.667H.667A.666.666 0 0 1 0 11.333V.667A.667.667 0 0 1 .667 0h4Zm5.057 1.333H6.667V0H12v5.333h-1.333V2.276L6 6.943 5.057 6l4.667-4.667Z" fill="black"/>
								</svg>
							</a>
							<button class="yext-wizard__step-button yext-wizard__next">
								<span>
									<?php
									echo sprintf(
										'<strong>%s</strong>, %s',
										esc_html( 'No', 'yext' ),
										esc_html( 'I have all the data I need', 'yext' )
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
			<div class="yext-wizard__step-card">
				<div class="yext-wizard__step-content yext-wizard__step-content--width-75">
					<div class="yext-wizard__step-header">
						<h2>
							<?php echo esc_html( 'Build answers experience on Yext', 'yext' ); ?>
						</h2>
						<p>
							<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
						</p>
					</div>
					<div class="yext-wizard__step-form">
						<div class="yext-wizard__step-buttons">
							<a href="<?php echo esc_url( 'https://yext.com' ); ?>" target="_blank" rel="noopener" class="yext-wizard__step-button">
								<span><?php echo esc_html( 'Build answers experience on Yext', 'yext' ); ?></span>
								<svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M4.667 0v1.333H1.333v9.334h9.334V7.333H12v4a.666.666 0 0 1-.667.667H.667A.666.666 0 0 1 0 11.333V.667A.667.667 0 0 1 .667 0h4Zm5.057 1.333H6.667V0H12v5.333h-1.333V2.276L6 6.943 5.057 6l4.667-4.667Z" fill="black"/>
								</svg>
							</a>
							<button class="yext-wizard__step-button yext-wizard__next">
								<span><?php echo esc_html( 'Answers experience already created', 'yext' ); ?></span>
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
			<div class="yext-wizard__step-card">
				<div class="yext-wizard__step-inner">
					<div class="yext-wizard__step-content">
						<div class="yext-wizard__step-header">
							<h2>
								<?php echo esc_html( 'Copy paste your Yext API keys and other properties', 'yext' ); ?>
							</h2>
							<p>
								<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
							</p>
						</div>
						<div class="yext-wizard__step-form">
							<?php $plugin_settings->render_content(); ?>
						</div>
					</div>
					<div class="yext-wizard__step-image">
						<img src="https://picsum.photos/260/260" alt="">
					</div>
				</div>
			</div>
		</div>

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[4] ); ?>">
			<div class="yext-wizard__step-card">
				<div class="yext-wizard__step-inner">
					<div class="yext-wizard__step-content">
						<div class="yext-wizard__step-header">
							<h2>
								<?php echo esc_html( 'Global search', 'yext' ); ?>
							</h2>
							<p>
								<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
							</p>
						</div>
						<div class="yext-wizard__step-form">
							<?php $search_bar_core_settings->render_content(); ?>
						</div>
					</div>
					<div class="yext-wizard__step-image">
						<img src="https://picsum.photos/260/260" alt="">
					</div>
				</div>
			</div>
		</div>

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[5] ); ?>">
			<div class="yext-wizard__step-card">
				<div class="yext-wizard__step-inner">
					<div class="yext-wizard__step-content">
						<div class="yext-wizard__step-header">
							<h2>
								<?php echo esc_html( 'Customize your search bar', 'yext' ); ?>
							</h2>
							<p>
								<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
							</p>
						</div>
						<div class="yext-wizard__step-form">
							<?php $search_bar_plugin_settings->render_content(); ?>
						</div>
					</div>
					<div class="yext-wizard__step-image">
						<img src="https://picsum.photos/260/260" alt="">
					</div>
				</div>
			</div>
		</div>

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[6] ); ?>">
			<div class="yext-wizard__step-card">
				<div class="yext-wizard__step-inner">
					<div class="yext-wizard__step-content">
						<div class="yext-wizard__step-header">
							<h2>
								<?php echo esc_html( 'Search results settings', 'yext' ); ?>
							</h2>
							<p>
								<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
							</p>
						</div>
						<div class="yext-wizard__step-form">
							<?php $search_results_settings->render_content(); ?>
						</div>
					</div>
					<div class="yext-wizard__step-image">
						<img src="https://picsum.photos/260/260" alt="">
					</div>
				</div>
			</div>
		</div>

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="<?php echo esc_attr( $step_progress_map[7] ); ?>">
			<div class="yext-wizard__step-card">
				<div class="yext-wizard__step-inner">
					<div class="yext-wizard__step-content">
						<div class="yext-wizard__step-header">
							<h2>
								<?php echo esc_html( 'Yext AI Search is configured and ready for use', 'yext' ); ?>
							</h2>
							<p>
								<?php echo esc_html( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt amet amet et ultricies felis mattis parturient vitae sed. Mauris laoreet.', 'yext' ); ?>
							</p>
						</div>
					</div>
					<div class="yext-wizard__step-image">
						<img src="https://picsum.photos/260/260" alt="">
					</div>
				</div>
				<div class="yext-wizard__step-footer">
					<a href="#" class="yext-wizard__submit">
						<?php echo esc_html( 'Finish setup', 'yext' ); ?>
					</a>
					<button class="yext-wizard__footer-back yext-wizard__back">
						<svg width="6" height="10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.714 1.429 2.143 5l3.571 3.571L5 10 0 5l5-5 .714 1.429Z" fill="black"/>
						</svg>
						<?php echo esc_html( 'Back', 'yext' ); ?>
					</button>
				</div>
			</div>
		</div>

		<?php include_once YEXT_INC . 'partials/footer.php'; ?>
	</form>
</div>
