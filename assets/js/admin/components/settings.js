import apiFetch from '@wordpress/api-fetch';

import { getRequiredFields, updateRequiredFields } from '../utils/input';

const {
	YEXT: { settings: PLUGIN_SETTINGS, rest_url: REST_API_ROUTE },
} = window;

const initSettings = () => {
	const yextSettings = document.querySelector('#yext-settings');

	if (!yextSettings) {
		return;
	}

	const yextForm = yextSettings.querySelector('#yext-settings form');
	const banner = yextSettings.querySelector('#yext-settings .banner');
	const bannerClose = banner?.querySelector('button[data-action="close"]') ?? null;

	const handleFormSubmit = (event) => {
		event.preventDefault();

		const activeTab = yextForm.querySelector('.tab-content.is-active');
		const missingFields = getRequiredFields(activeTab).filter(
			(input) => !input.value.trim().length,
		);

		if (missingFields.length) {
			updateRequiredFields(missingFields);
			return;
		}

		event.target.submit();
	};

	const handleBannerClose = (event) => {
		event.preventDefault();

		const { target } = event;

		target.closest('.banner').outerHTML = '';
		apiFetch({
			path: REST_API_ROUTE,
			method: 'POST',
			data: {
				settings: {
					...PLUGIN_SETTINGS,
					...{
						banner_hidden: true,
					},
				},
			},
		}).catch((error) => {
			/* eslint-disable-next-line no-console */
			console.error(error);
		});
	};

	yextForm.addEventListener('submit', handleFormSubmit);
	bannerClose?.addEventListener('click', handleBannerClose);
};

export default initSettings;
