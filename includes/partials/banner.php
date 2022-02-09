<?php
/**
 * Yext Settings Banner
 *
 * @package Yext
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="yext-settings__banner banner">
	<div class="yext-settings__banner-content">
		<div class="yext-settings__banner-image">
			<img src="<?php echo esc_url( YEXT_URL . '/dist/images/yext-banner-thumbs-up.jpg' ); ?>" loading="lazy" alt="">
		</div>

		<div class="yext-settings__banner-copy">
			<h2><?php echo esc_html__( 'Yext Search is live on your site!', 'yext' ); ?></h2>
			<p><?php echo esc_html__( 'You can always tweak or make any changes using the settings below. For any advanced customisations please visit your Yext dashboard on Yext.com.', 'yext' ); ?></p>

			<button data-action="close" class="yext-settings__button yext-settings__button--primary is-style-outline">
				<?php echo esc_html__( 'Okay, got it', 'yext' ); ?>
			</button>
		</div>
	</div>

	<div class="yext-settings__banner-close">
		<button data-action="close" class="yext-settings__button--is-style-link">
			<svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M8 0c4.42 0 8 3.58 8 8s-3.58 8-8 8-8-3.58-8-8 3.58-8 8-8Zm5 11-3-3 3-3-2-2-3 3-3-3-2 2 3 3-3 3 2 2 3-3 3 3 2-2Z" fill="#0F70F0"/>
			</svg>
			<?php echo esc_html__( 'Dismiss', 'yext' ); ?>
		</button>
	</div>
</div>
