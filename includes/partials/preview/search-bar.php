<?php
/**
 * Search bar preview HTML
 *
 * @package Yext
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="yxt-Answers-component yxt-SearchBar-wrapper">
	<div class="yxt-SearchBar">
		<div class="yxt-SearchBar-container">
			<div class="yxt-SearchBar-form">
				<input class="js-yext-query yxt-SearchBar-input" type="text" name="query" value="" aria-label="Conduct a search" autocomplete="off" autocorrect="off" spellcheck="false" placeholder="Search...">
				<button type="submit" class="js-yext-submit yxt-SearchBar-button">
					<div class="js-yxt-AnimatedForward component yxt-SearchBar-AnimatedIcon--inactive">
						<div class="Icon Icon--yext_animated_forward Icon--lg" aria-hidden="true"></div>

					</div>
					<div class="js-yxt-AnimatedReverse component" data-component="IconComponent">
						<div class="Icon Icon--yext_animated_reverse Icon--lg" aria-hidden="true">
							<img src ="<?php echo esc_url( YEXT_URL ); ?>/assets/svg/logo.svg"/>
						</div>

					</div>
					<span class="yxt-SearchBar-buttonText sr-only">
						<?php esc_html_e( 'Submit', 'yext' ); ?>
					</span>
				</button>
			</div>
			<div class="yxt-SearchBar-autocomplete yxt-AutoComplete-wrapper js-yxt-AutoComplete-wrapper component">
				<div class="yxt-AutoComplete">

					<ul class="yxt-AutoComplete-results">
						<li class="js-yext-autocomplete-option yxt-AutoComplete-option yxt-AutoComplete-option--item">
							<?php esc_html_e( 'Example autocomplete results', 'yext' ); ?>
						</li>

						<li class="js-yext-autocomplete-option yxt-AutoComplete-option yxt-AutoComplete-option--item">
							<?php esc_html_e( 'Search results dropdown example', 'yext' ); ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
