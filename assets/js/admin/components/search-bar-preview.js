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
			form.elements[i].addEventListener('change', (e) => {
				if (e.target.name.includes('search_bar')) {
					this.updatePreview(e.target.id, e.target.value);
				}
			});
		}
		return false;
	}

	/**
	 * Form change listener
	 *
	 * @param {string} target The target element.
	 * @param {string} value The new value.
	 * 
	 */
	updatePreview(target, value) {
		const previewContainer = this.previewContainer[0];
		const searchInputs = previewContainer.querySelectorAll('.yxt-SearchBar-input');
		const camelCased = target.replace(/_([a-z])/g, function (g) {
			return g[1].toUpperCase();
		});

		searchInputs.forEach((searchInput) => {
			searchInput.style[camelCased] = Number.isNaN(value) || ['font_weight'].includes(target) ? value : `${value}px`;
		});
	}
}
