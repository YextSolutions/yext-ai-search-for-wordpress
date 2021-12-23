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

<div class="yext-wizard__footer">
	<button class="yext-wizard__footer-back yext-wizard__back">
		<svg width="6" height="10" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M5.714 1.429 2.143 5l3.571 3.571L5 10 0 5l5-5 .714 1.429Z" fill="black"/>
		</svg>
		<?php echo esc_html( 'Back', 'yext' ); ?>
	</button>
	<?php submit_button( 'Save & Continue', [ 'yext-wizard__submit', 'yext-wizard__next' ], 'submit', false, null ); ?>
</div>
