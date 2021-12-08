// Imports
import Tabs from '@10up/component-tabs';
import { addQueryArgs, getQueryArg, hasQueryArg } from '@wordpress/url';

const TAB_QUERY_VAR = 'tab-selected';

/**
 * Return the index for a tab
 *
 * @param  {Object} node DOM node element
 * @return {number}      Index
 */
function getTabIndex(node) {
	return [...node.parentElement.children].indexOf(node);
}

const initTabs = () => {
	const yextForm = document.querySelector('#yext-settings form');

	// do nothing if no Yext settings form
	if (!yextForm) {
		return;
	}

	// update the referer hidden field and include the current active tab
	/**
	 * @type {HTMLInputElement}
	 */
	const refererInputField = yextForm.querySelector('input[name="_wp_http_referer"]');
	const refererUrl = refererInputField.value;

	// @ts-ignore
	// eslint-disable-next-line new-cap, no-unused-vars, no-new
	new Tabs('#yext-settings .tabs', {
		onCreate: () => {
			if (!hasQueryArg(window.location.href, TAB_QUERY_VAR)) {
				return;
			}

			const selectedTab = parseInt(
				String(getQueryArg(window.location.href, TAB_QUERY_VAR)),
				10,
			);

			// eslint-disable-next-line jsdoc/no-undefined-types
			/**
			 * @type {NodeListOf<HTMLElement>}
			 */
			const tabLinks = yextForm.querySelectorAll('.tab-list [role="tab"]');

			if (selectedTab <= tabLinks.length) {
				tabLinks[selectedTab].click();
			}
		},
		onTabChange: () => {
			const currentTab = yextForm.querySelector('.tab-group [aria-hidden="false"]');
			refererInputField.value = addQueryArgs(refererUrl, {
				'tab-selected': getTabIndex(currentTab),
			});
		},
	});
};

export default initTabs;
