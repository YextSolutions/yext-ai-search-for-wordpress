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
				let targetType = '';
				if (e.target.name.includes('[search_bar]')) {
					targetType = '';
					if (e.target.name.includes('[button]')) {
						targetType = 'button';
					}

					this.updatePreview(e.target.id, e.target.value, targetType);
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
	 * @param {string} type The field type.
	 * 
	 */
	updatePreview(target, value, type = '') {
		this.previewContainer.forEach((container) => {
			const cssValue =
				Number.isNaN(value) || value.includes('#') || ['font_weight'].includes(target)
					? value
					: `${value}px`;
			container.style.setProperty(`--yext-${type + target}`, cssValue);
		});
	}
}
