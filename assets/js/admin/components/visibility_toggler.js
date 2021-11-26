/**
 * CSS toggle class
 *
 * @type {string}
 */
const CSS_TOGGLE_CLASS = 'toggled-settings-hidden';

/**
 * Get all the toggleable elements
 *
 * @return {Array} Array of DOM nodes
 */
const getToggleables = () => {
	let toHide = [];
	// child sections
	const childSettingsSections = document.querySelectorAll(
		'[class^=" yext-child-settings-search_bar-"]',
	);
	// get inputs
	const inputs = [
		'input[name="yext_plugin_settings[search_bar][bg_color]"]',
		'input[name="yext_plugin_settings[search_bar][border_color]"]',
		'input[name="yext_plugin_settings[search_bar][border_radius]"]',
		'input[name="yext_plugin_settings[search_bar][text_color]"]',
		'input[name="yext_plugin_settings[search_bar][font_size]"]',
		'select[name="yext_plugin_settings[search_bar][font_weight]"]',
		'input[name="yext_plugin_settings[search_bar][line_height]"]',
	];
	const selectors = inputs.join(',');
	// add parent rows to the "toHide" array
	document.querySelectorAll(selectors).forEach((input) => {
		toHide = [input.closest('tr'), ...toHide];
	});
	return [...toHide, ...childSettingsSections];
};

/**
 * Store the toggleable elements
 *
 * @type {Array}
 */
const toggleables = getToggleables();

/**
 * Event handler for setting change
 *
 * @param  {event} e JS Event
 * @return {void}
 */
const toggleCustomCssSettings = (e) => {
	const isChecked = e.target.checked === true;
	if (isChecked) {
		toggleables.forEach((elem) => {
			elem.classList.remove(CSS_TOGGLE_CLASS);
		});
	} else {
		toggleables.forEach((elem) => {
			elem.classList.add(CSS_TOGGLE_CLASS);
		});
	}
};

/**
 * Init method for toggle settings visibility
 *
 * @return {void}
 */
const initToggler = () => {
	const useCustomCssToggler = document.querySelector(
		'input[name="yext_plugin_settings[search_bar][use_custom_style]"]',
	);
	if (!useCustomCssToggler) {
		return;
	}
	useCustomCssToggler.addEventListener('change', toggleCustomCssSettings);

	useCustomCssToggler.dispatchEvent(new Event('change'), { bubbles: false });
};

export default initToggler;
