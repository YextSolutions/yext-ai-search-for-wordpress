import merge from 'deepmerge';

// @ts-ignore
import apiFetch from '@wordpress/api-fetch';

import { getRequiredFields, updateRequiredFields } from '../utils/input';

const {
	YEXT: {
		defaults: DEFAULT_PLUGIN_SETTINGS,
		settings: PLUGIN_SETTINGS,
		rest_url: REST_API_ROUTE,
	},
} = window;

const initSettings = () => {
	const yextSettings = document.querySelector('#yext-settings');

	if (!yextSettings) {
		return;
	}

	const yextForm = yextSettings.querySelector('#yext-settings form');
	const banner = yextSettings.querySelector('#yext-settings .banner');
	const bannerClose = banner?.querySelectorAll('button[data-action="close"]') ?? null;
	const resetCSS = yextForm.querySelector('button[data-action="reset-css"]');

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
			path: `${REST_API_ROUTE}/settings`,
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

	const handleResetCSS = (event) => {
		event.preventDefault();

		if (
			/* eslint-disable-next-line no-alert */
			window.confirm(
				'Are you sure you want to reset all search bar styles? This will restore all styles to the default settings.',
			)
		) {
			apiFetch({
				path: `${REST_API_ROUTE}/settings`,
				method: 'POST',
				data: {
					settings: merge(PLUGIN_SETTINGS, {
						search_bar: {
							style: DEFAULT_PLUGIN_SETTINGS.search_bar.style,
							button: DEFAULT_PLUGIN_SETTINGS.search_bar.button,
							autocomplete: DEFAULT_PLUGIN_SETTINGS.search_bar.autocomplete,
							placeholder: DEFAULT_PLUGIN_SETTINGS.search_bar.placeholder,
						},
					}),
				},
			})
				.then(() => {
					window.location.reload();
				})
				.catch((error) => {
					/* eslint-disable-next-line no-console */
					console.error(error);
				});
		}
	};

	yextForm.addEventListener('submit', handleFormSubmit);
	bannerClose?.forEach((button) => {
		button.addEventListener('click', handleBannerClose);
	});
	resetCSS?.addEventListener('click', handleResetCSS);

	yextSettings.setAttribute('data-is-loaded', '1');
};

export default initSettings;
