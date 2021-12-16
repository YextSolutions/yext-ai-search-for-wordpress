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
			<div class="yext-wizard__step-content">
				<div class="yext-wizard__step-header">
					<h2>
						<?php echo esc_html( 'Do you have an Yext account?', 'yext' ); ?>
					</h2>
				</div>
				<div class="yext-wizard__step-form">
					<div class="yext-wizard__step-buttons">
						<button class="yext-wizard__step-button yext-wizard__next">
							<?php echo esc_html( 'Yes, I have an Yext account', 'yext' ); ?>
							<svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M4.667 0v1.333H1.333v9.334h9.334V7.333H12v4a.666.666 0 0 1-.667.667H.667A.666.666 0 0 1 0 11.333V.667A.667.667 0 0 1 .667 0h4Zm5.057 1.333H6.667V0H12v5.333h-1.333V2.276L6 6.943 5.057 6l4.667-4.667Z" fill="black"/>
							</svg>
						</button>
						<a href="<?php echo esc_url( 'https://yext.com' ); ?>" target="_blank" rel="noopener" class="yext-wizard__step-button">
							<?php echo esc_html( 'No, I like to set one up', 'yext' ); ?>
							<svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M7 0 5.766 1.234l4.883 4.891H0v1.75h10.649l-4.883 4.891L7 14l7-7-7-7Z" fill="black"/>
							</svg>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="0">
			<div class="yext-wizard__step-content">
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
							<?php echo esc_html( 'Yes, I want to connect my data', 'yext' ); ?>
							<svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M4.667 0v1.333H1.333v9.334h9.334V7.333H12v4a.666.666 0 0 1-.667.667H.667A.666.666 0 0 1 0 11.333V.667A.667.667 0 0 1 .667 0h4Zm5.057 1.333H6.667V0H12v5.333h-1.333V2.276L6 6.943 5.057 6l4.667-4.667Z" fill="black"/>
							</svg>
						</a>
						<button class="yext-wizard__step-button yext-wizard__next">
							<?php echo esc_html( 'No, I have all the data I need', 'yext' ); ?>
							<svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M7 0 5.766 1.234l4.883 4.891H0v1.75h10.649l-4.883 4.891L7 14l7-7-7-7Z" fill="black"/>
							</svg>
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="0">
			<div class="yext-wizard__step-content">
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
							<?php echo esc_html( 'Build answers experience on Yext', 'yext' ); ?>
							<svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M4.667 0v1.333H1.333v9.334h9.334V7.333H12v4a.666.666 0 0 1-.667.667H.667A.666.666 0 0 1 0 11.333V.667A.667.667 0 0 1 .667 0h4Zm5.057 1.333H6.667V0H12v5.333h-1.333V2.276L6 6.943 5.057 6l4.667-4.667Z" fill="black"/>
							</svg>
						</a>
						<button class="yext-wizard__step-button yext-wizard__next">
							<?php echo esc_html( 'Answers experience already created', 'yext' ); ?>
							<svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M7 0 5.766 1.234l4.883 4.891H0v1.75h10.649l-4.883 4.891L7 14l7-7-7-7Z" fill="black"/>
							</svg>
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="1">
			<div class="yext-wizard__step-inne">
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

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="2">
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

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="2">
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

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="3">
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

		<div class="yext-wizard__step yext-wizard__step--hidden" data-progress-id="4">
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
				<a href="#" class="button button-primary yext-wizard__footer-submit">
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

		<div class="yext-wizard__footer">
			<button class="yext-wizard__footer-back yext-wizard__back">
				<svg width="6" height="10" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5.714 1.429 2.143 5l3.571 3.571L5 10 0 5l5-5 .714 1.429Z" fill="black"/>
				</svg>
				<?php echo esc_html( 'Back', 'yext' ); ?>
			</button>
			<?php submit_button( 'Save & Continue', [ 'primary', 'yext-wizard__footer-submit yext-wizard__next' ], 'submit', false, null ); ?>
		</div>
	</form>
</div>
