<?php
/**
 * Yext Footer
 *
 * @package Yext
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="yext-settings__footer">
	<?php if ( 'wizard' === $view ) : ?>
	<button class="yext-settings__button yext-settings__button--is-style-link yext-wizard__back">
			<svg width="6" height="10" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M5.714 1.429 2.143 5l3.571 3.571L5 10 0 5l5-5 .714 1.429Z" fill="black"/>
			</svg>
			<?php echo esc_html__( 'Back', 'yext' ); ?>
		</button>
	<?php endif; ?>
	<?php
	submit_button(
		'wizard' === $view ? 'Save & Continue' : 'Save Settings',
		[
			'yext-settings__button',
			'yext-settings__button--primary',
			'yext-wizard__next',
		],
		'yext-submit',
		false,
		null
	);
	?>
</div>
