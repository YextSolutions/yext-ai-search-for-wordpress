/* global YEXT */
import { addQueryArgs } from '@wordpress/url';
import DOMPurify from 'dompurify';

const { siteUrl } = YEXT;

/**
 * Return the link for a given post Id
 * Adds p=[postId] to the site URL.
 * WordPress will take care of loading and redirecting properly
 *
 * @param  {number} postId Post Id
 * @return {string} url    The url for a post
 */
const buildUrlfromPostId = (postId) => {
	return addQueryArgs(siteUrl, { p: postId });
};

/**
 * Event handler for setting change
 *
 * @param  {event} e JS Event
 * @return {void}
 */
const onDropDownChange = (e) => {
	const {
		target,
		target: { value },
	} = e;
	const btnLink = target.parentElement.querySelector('a');
	if (value > 0 && btnLink) {
		btnLink.setAttribute('href', DOMPurify.sanitize(buildUrlfromPostId(value)));
		btnLink.style.display = 'inline-block';
	} else if (!value) {
		btnLink.style.display = 'none';
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
