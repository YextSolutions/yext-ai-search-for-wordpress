<?php
/**
 * Yext Header
 *
 * @package Yext
 */

use Yext\Admin\Settings;

$settings = Settings::get_settings();
$is_live  = isset( $settings['wizard'] ) ? $settings['wizard']['live'] : false;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="yext-settings__header">
	<div class="yext-settings__header-logo">
		<svg class="yext-logo" height="48" width="48" viewBox="0 0 720 720" focusable="false" xmlns="http://www.w3.org/2000/svg">
			<path d="M360 0C161.18 0 0 161.18 0 360s161.18 360 360 360 360-161.18 360-360S558.82 0 360 0Zm0 691.2C177.08 691.2 28.8 542.92 28.8 360S177.08 28.8 360 28.8 691.2 177.08 691.2 360 542.92 691.2 360 691.2Z" fill="currentColor"/>
			<path d="M370.8 399.6h64.8v129.6h28.8V399.6h64.8v-28.8H370.8v28.8Zm-38.37-32.4L270 429.64l-62.43-62.44-20.37 20.37L249.64 450l-62.44 62.43 20.37 20.37L270 470.36l62.43 62.44 20.37-20.37L290.36 450l62.44-62.43-20.37-20.37Zm115.77-18c44.73 0 81-36.27 81-81h-28.8c0 28.83-23.37 52.2-52.2 52.2-8.23 0-16.01-1.91-22.93-5.3l90.91-90.91c-14.44-22.25-39.48-36.98-67.98-36.98-44.74 0-81 36.27-81 81s36.26 80.99 81 80.99Zm0-133.2c10.12 0 19.56 2.89 27.56 7.88l-71.88 71.88c-4.99-8-7.87-17.44-7.87-27.56-.01-28.83 23.36-52.2 52.19-52.2ZM270 259.58l-60.74-72.38-22.06 18.51 68.4 81.52v61.97h28.8v-61.97l68.4-81.52-22.06-18.51L270 259.58Z" fill="currentColor"/>
		</svg>
		<svg width="20" height="20" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M18 0v38h2V0h-2ZM0 20h38v-2H0v2Z" fill="black"/>
		</svg>
		<svg height="48" width="48" xmlns="http://www.w3.org/2000/svg" focusable="false" viewBox="0 0 122.52 122.523">
			<path d="M8.708 61.26c0 20.802 12.089 38.779 29.619 47.298L13.258 39.872a52.354 52.354 0 0 0-4.55 21.388zM96.74 58.608c0-6.495-2.333-10.993-4.334-14.494-2.664-4.329-5.161-7.995-5.161-12.324 0-4.831 3.664-9.328 8.825-9.328.233 0 .454.029.681.042-9.35-8.566-21.807-13.796-35.489-13.796-18.36 0-34.513 9.42-43.91 23.688 1.233.037 2.395.063 3.382.063 5.497 0 14.006-.667 14.006-.667 2.833-.167 3.167 3.994.337 4.329 0 0-2.847.335-6.015.501L48.2 93.547l11.501-34.493-8.188-22.434c-2.83-.166-5.511-.501-5.511-.501-2.832-.166-2.5-4.496.332-4.329 0 0 8.679.667 13.843.667 5.496 0 14.006-.667 14.006-.667 2.835-.167 3.168 3.994.337 4.329 0 0-2.853.335-6.015.501l18.992 56.494 5.242-17.517c2.272-7.269 4.001-12.49 4.001-16.989z" fill="currentColor"/>
			<path d="m62.184 65.857-15.768 45.819a52.552 52.552 0 0 0 14.846 2.141c6.12 0 11.989-1.058 17.452-2.979a4.615 4.615 0 0 1-.374-.724zM107.376 36.046c.226 1.674.354 3.471.354 5.404 0 5.333-.996 11.328-3.996 18.824l-16.053 46.413c15.624-9.111 26.133-26.038 26.133-45.426.001-9.137-2.333-17.729-6.438-25.215z" fill="currentColor"/>
			<path d="M61.262 0C27.483 0 0 27.481 0 61.26c0 33.783 27.483 61.263 61.262 61.263 33.778 0 61.265-27.48 61.265-61.263C122.526 27.481 95.04 0 61.262 0zm0 119.715c-32.23 0-58.453-26.223-58.453-58.455 0-32.23 26.222-58.451 58.453-58.451 32.229 0 58.45 26.221 58.45 58.451 0 32.232-26.221 58.455-58.45 58.455z" fill="currentColor"/>
		</svg>
	</div>
	<div class="yext-settings__header-menu">
		<div class="yext-menu yext-settings__header-menu-item">
			<button class="yext-menu__opener" data-dialog-id="yext-menu-help">
				<svg width="20" height="20" fill="none" focusable="false" xmlns="http://www.w3.org/2000/svg">
					<path d="M10 4a3.939 3.939 0 0 0-3.934 3.934h2C8.066 6.867 8.934 6 10 6c1.066 0 1.934.867 1.934 1.934 0 .598-.48 1.032-1.216 1.626-.24.188-.47.388-.69.599C9.028 11.156 9 12.215 9 12.333V13h2v-.633c0-.016.032-.386.44-.793.15-.15.34-.3.535-.458.78-.631 1.958-1.584 1.958-3.182A3.937 3.937 0 0 0 10 4ZM9 14h2v2H9v-2Z" fill="black"/>
					<path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0Zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8Z" fill="black"/>
				</svg>
				<span class="visually-hidden"><?php echo esc_html__( 'Open', 'yext' ); ?></span>
				<?php echo esc_html__( 'Help', 'yext' ); ?>
				<span class="visually-hidden"><?php echo esc_html__( 'Menu', 'yext' ); ?></span>
			</button>

			<div id="yext-menu-help" class="yext-menu__dialog hidden">
				<ul>
					<li>
						<a href="https://hitchhikers.yext.com/community/" rel="noopener">
							<?php echo esc_html__( 'Contact Support', 'yext' ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="yext-menu yext-settings__header-menu-item">
			<button class="yext-menu__opener" data-dialog-id="yext-menu-more">
				<svg width="4" height="16" fill="none" focusable="false" xmlns="http://www.w3.org/2000/svg">
					<path d="M4 14.154c0 .49-.21.96-.586 1.305C3.04 15.806 2.53 16 2 16c-.53 0-1.04-.194-1.414-.54A1.777 1.777 0 0 1 0 14.153c0-.49.21-.96.586-1.306.375-.346.884-.54 1.414-.54.53 0 1.04.194 1.414.54.375.347.586.816.586 1.306ZM4 8c0 .49-.21.96-.586 1.305-.375.347-.884.541-1.414.541-.53 0-1.04-.194-1.414-.54A1.777 1.777 0 0 1 0 8c0-.49.21-.96.586-1.305.375-.347.884-.541 1.414-.541.53 0 1.04.194 1.414.54C3.79 7.042 4 7.51 4 8Zm0-6.154c0 .49-.21.96-.586 1.306-.375.346-.884.54-1.414.54-.53 0-1.04-.194-1.414-.54A1.777 1.777 0 0 1 0 1.846c0-.49.21-.96.586-1.305C.96.195 1.47 0 2 0c.53 0 1.04.195 1.414.54C3.79.888 4 1.358 4 1.847Z" fill="black"/>
				</svg>
				<span class="visually-hidden"><?php echo esc_html__( 'Open More Menu', 'yext' ); ?></span>
			</button>

			<div id="yext-menu-more" class="yext-menu__dialog hidden">
				<ul class="yext-menu__dialog-list">
					<li class="yext-menu__dialog-list-item yext-menu__dialog-list-item--restart">
						<?php if ( 'settings' === $view ) : ?>
							<button class="yext-settings__button--is-style-link" data-action="restart" data-href="<?php echo esc_url( admin_url( 'admin.php?page=yext-ai-search&restart_wizard=1' ) ); ?>">
								<?php echo esc_html__( 'Restart setup', 'yext' ); ?>
							</button>
						<?php else : ?>
							<button class="yext-settings__button--is-style-link" data-action="restart">
								<?php echo esc_html__( 'Restart setup', 'yext' ); ?>
							</button>
						<?php endif; ?>
					</li>
					<?php if ( 'wizard' === $view ) : ?>
						<li class="yext-menu__dialog-list-item yext-menu__dialog-list-item--skip">
							<button class="yext-settings__button--is-style-link" data-action="skip" data-href="<?php echo esc_url( admin_url( 'admin.php?page=yext-ai-search&skipped=1' ) ); ?>">
								<?php echo esc_html__( 'Skip setup', 'yext' ); ?>
							</button>
						</li>
					<?php endif; ?>
					<li class="yext-menu__dialog-list-item">
						<a href="https://hitchhikers.yext.com/community/" rel="noopener">
							<?php echo esc_html__( 'Contact Support', 'yext' ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
