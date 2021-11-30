// import DOMPurify from 'dompurify';

/**
 * Search Bar Preview
 */
export default class YextSearchBarPreview {
	/**
	 * Init
	 */
	constructor() {
		this.previewContainer = Array.from(document.querySelectorAll('.yxt-SearchBar-wrapper'));
		this.settings = document.getElementById('yext-settings');

		if (!this.previewContainer.length || !this.settings) {
			return;
		}

		this.formChanged();
	}

	/**
	 * Form change listener
	 *
	 * @return {null} void
	 */
	formChanged() {
		const form = this.settings.querySelector('form');

		if (!form) {
			return false;
		}

		for (let i = 0; i < form.elements.length; i++) {
			form.elements[i].addEventListener('input', (e) => {
				const cssVariable = e.target.getAttribute('data-variable');

				if (cssVariable) {
					this.updateVariables(cssVariable, e.target.value);
				}
			});
		}
		return false;
	}

	/**
	 * Update CSS variable inline
	 *
	 * @param {string} key The CSS variable name.
	 * @param {string} value The new value.
	 *
	 */
	updateVariables(key, value) {
		this.previewContainer.forEach((container) => {
			const cssValue =
				Number.isNaN(value) || value.includes('#') || key.includes('font-weight')
					? value
					: `${value}px`;
			container.style.setProperty(key, cssValue);
		});
	}
}
