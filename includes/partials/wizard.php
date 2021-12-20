<?php
/**
 * Setup Wizard template
 *
 * @package Yext
 */

use Yext\Admin\Settings;
use Yext\Admin\Tabs\Tab;

$plugin_settings = new Tab( Settings::PLUGIN_SETTINGS_SECTION_NAME, '' );

$core_search_bar_sections = [
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

$search_bar_core_settings = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $core_search_bar_sections );
$search_bar_plugin_settings = new Tab( Settings::SEARCH_BAR_SECTION_NAME, '', $plugin_search_bar_sections );
$search_results_settings = new Tab( Settings::SEARCH_RESULTS_SECTION_NAME, '' );

?>

<div class="yext-wizard" id="yext-wizard" data-step="0" data-progress-id="0">
	<div class="yext-wizard__header">
		<div class="yext-wizard__header-logo">
			<svg class="yext-logo" height="48" width="48" viewBox="0 0 720 720" xmlns="http://www.w3.org/2000/svg">
				<path d="M360 0C161.18 0 0 161.18 0 360s161.18 360 360 360 360-161.18 360-360S558.82 0 360 0Zm0 691.2C177.08 691.2 28.8 542.92 28.8 360S177.08 28.8 360 28.8 691.2 177.08 691.2 360 542.92 691.2 360 691.2Z" fill="currentColor"/>
				<path d="M370.8 399.6h64.8v129.6h28.8V399.6h64.8v-28.8H370.8v28.8Zm-38.37-32.4L270 429.64l-62.43-62.44-20.37 20.37L249.64 450l-62.44 62.43 20.37 20.37L270 470.36l62.43 62.44 20.37-20.37L290.36 450l62.44-62.43-20.37-20.37Zm115.77-18c44.73 0 81-36.27 81-81h-28.8c0 28.83-23.37 52.2-52.2 52.2-8.23 0-16.01-1.91-22.93-5.3l90.91-90.91c-14.44-22.25-39.48-36.98-67.98-36.98-44.74 0-81 36.27-81 81s36.26 80.99 81 80.99Zm0-133.2c10.12 0 19.56 2.89 27.56 7.88l-71.88 71.88c-4.99-8-7.87-17.44-7.87-27.56-.01-28.83 23.36-52.2 52.19-52.2ZM270 259.58l-60.74-72.38-22.06 18.51 68.4 81.52v61.97h28.8v-61.97l68.4-81.52-22.06-18.51L270 259.58Z" fill="currentColor"/>
			</svg>
			<h2><?php echo esc_html( 'Yext', 'yext' ); ?></h2>
		</div>
		<div class="yext-wizard__header-menu">
			<button>
				<svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M10 4a3.939 3.939 0 0 0-3.934 3.934h2C8.066 6.867 8.934 6 10 6c1.066 0 1.934.867 1.934 1.934 0 .598-.48 1.032-1.216 1.626-.24.188-.47.388-.69.599C9.028 11.156 9 12.215 9 12.333V13h2v-.633c0-.016.032-.386.44-.793.15-.15.34-.3.535-.458.78-.631 1.958-1.584 1.958-3.182A3.937 3.937 0 0 0 10 4ZM9 14h2v2H9v-2Z" fill="black"/>
					<path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0Zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8Z" fill="black"/>
				</svg>
				<span><?php echo esc_html( 'Help', 'yext' ); ?></span>
			</button>

			<button>
				<svg width="4" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M4 14.154c0 .49-.21.96-.586 1.305C3.04 15.806 2.53 16 2 16c-.53 0-1.04-.194-1.414-.54A1.777 1.777 0 0 1 0 14.153c0-.49.21-.96.586-1.306.375-.346.884-.54 1.414-.54.53 0 1.04.194 1.414.54.375.347.586.816.586 1.306ZM4 8c0 .49-.21.96-.586 1.305-.375.347-.884.541-1.414.541-.53 0-1.04-.194-1.414-.54A1.777 1.777 0 0 1 0 8c0-.49.21-.96.586-1.305.375-.347.884-.541 1.414-.541.53 0 1.04.194 1.414.54C3.79 7.042 4 7.51 4 8Zm0-6.154c0 .49-.21.96-.586 1.306-.375.346-.884.54-1.414.54-.53 0-1.04-.194-1.414-.54A1.777 1.777 0 0 1 0 1.846c0-.49.21-.96.586-1.305C.96.195 1.47 0 2 0c.53 0 1.04.195 1.414.54C3.79.888 4 1.358 4 1.847Z" fill="black"/>
				</svg>
			</button>
		</div>
	</div>

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
		<div class="yext-wizard__step yext-wizard__step--active" data-progress-id="0">
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

		<div class="yext-wizard__step yext-wizard__step--has-circle yext-wizard__step--hidden" data-progress-id="0">
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

		<div class="yext-wizard__step yext-wizard__step--has-circle yext-wizard__step--hidden" data-progress-id="0">
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

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="1">
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

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="2">
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

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="2">
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

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="3">
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

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="4">
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

		<div class="yext-wizard__footer">
			<button class="yext-wizard__footer-back yext-wizard__back">
				<svg width="6" height="10" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5.714 1.429 2.143 5l3.571 3.571L5 10 0 5l5-5 .714 1.429Z" fill="black"/>
				</svg>
				<?php echo esc_html( 'Back', 'yext' ); ?>
			</button>
			<?php submit_button( 'Save & Continue', [ 'yext-wizard__submit', 'yext-wizard__next' ], 'submit', false, null ); ?>
		</div>
	</form>
</div>
