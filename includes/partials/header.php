<?php
/**
 * Yext Header
 *
 * @package Yext
 */

use Yext\Admin\Settings;

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
		<h2><?php echo esc_html__( 'Yext', 'yext' ); ?></h2>
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
						<a href="https://yext.com/" rel="noopener">
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
						<?php
						// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
						if ( 'settings' === $view ) :
							?>
							<button class="yext-settings__button--is-style-link" data-action="restart" data-href="<?php echo esc_url( admin_url( 'admin.php?page=yext&restart_wizard=1' ) ); ?>">
								<?php echo esc_html__( 'Restart setup', 'yext' ); ?>
							</button>
						<?php else : ?>
							<button class="yext-settings__button--is-style-link" data-action="restart">
								<?php echo esc_html__( 'Restart setup', 'yext' ); ?>
							</button>
						<?php endif; ?>
					</li>
						<?php
						// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
						if ( 'wizard' === $view ) :
							?>
						<li class="yext-menu__dialog-list-item yext-menu__dialog-list-item--skip">
							<button class="yext-settings__button--is-style-link" data-action="skip" data-href="<?php echo esc_url( admin_url( 'admin.php?page=yext&skipped=1' ) ); ?>">
								<?php echo esc_html__( 'Skip setup', 'yext' ); ?>
							</button>
						</li>
					<?php endif; ?>
					<li class="yext-menu__dialog-list-item">
						<a href="https://yext.com/" rel="noopener">
							<?php echo esc_html__( 'Contact Support', 'yext' ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
