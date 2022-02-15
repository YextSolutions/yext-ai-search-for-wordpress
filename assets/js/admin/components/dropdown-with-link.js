import { addQueryArgs } from '@wordpress/url';
import DOMPurify from 'dompurify';

const { site_url } = window.YEXT;

/**
 * Return the link for a given post Id
 * Adds p=[postId] to the site URL.
 * WordPress will take care of loading and redirecting properly
 *
 * @param  {number} postId Post Id
 * @return {string} url    The url for a post
 */
const buildUrlfromPostId = (postId) => {
	return addQueryArgs(site_url, { p: postId });
};

/**
 * Event handler for setting change
 *
 * @param  {Event} e JS Event
 * @return {void}
 */
const onDropDownChange = (e) => {
	const { target } = e;

	if (target instanceof HTMLSelectElement) {
		const { value } = target;
		const btnLink = target.parentElement.querySelector('a');
		if (value && btnLink) {
			btnLink.setAttribute('href', DOMPurify.sanitize(buildUrlfromPostId(Number(value))));
			btnLink.style.display = '';
		} else if (!value) {
			btnLink.style.display = 'none';
		}
	}
};

/**
 * Init method for the dropdown having a link button
 *
 * @return {void}
 */
const initDropdownWithLink = () => {
	const dropDownWithLink = document.querySelector(
		'select[name="yext_plugin_settings[search_results][results_page]"]',
	);

	if (!dropDownWithLink) {
		return;
	}

	dropDownWithLink.addEventListener('change', onDropDownChange);
};

export default initDropdownWithLink;
