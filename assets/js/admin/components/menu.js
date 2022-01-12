import tippy from 'tippy.js';
import apiFetch from '@wordpress/api-fetch';

const {
	YEXT: { settings: PLUGIN_SETTINGS, rest_url: REST_API_ROUTE },
} = window;

/** @typedef {import('../types').YextWizard} YextWizard */

/**
 * @type {YextWizard}
 */
const wizard = document.querySelector('#yext-wizard');

const updateSettings = ({ live = false, active = false } = {}) => {
	if (wizard) {
		wizard.state.payload = {
			settings: {
				...wizard.state.payload.settings,
				wizard: {
					current_step: 0,
					active,
				},
				plugin: {
					live,
				},
			},
		};

		if (active) {
			wizard.state.step = 0;
		}
	}
};

const actions = {
	restart: (event) => {
		event.preventDefault();

		const {
			target: {
				dataset: { href },
			},
			target,
		} = event;

		if (
			/* eslint-disable-next-line no-alert */
			window.confirm(
				`Are you sure you would like to restart the setup wizard? ${
					!wizard || (wizard && wizard.getAttribute('data-is-live') === '1')
						? 'This will deactivate Yext search bar and search results from your site.'
						: ''
				}`,
			)
		) {
			if (href) {
				apiFetch({
					path: REST_API_ROUTE,
					method: 'POST',
					data: {
						settings: {
							...PLUGIN_SETTINGS,
							wizard: {
								active: true,
							},
						},
					},
				}).then(() => {
					import('dompurify').then(({ default: DOMPurify }) => {
						window.location.href = DOMPurify.sanitize(href);
					});
				});
			} else {
				updateSettings({ active: true });
			}
		}

		const tippyInstance = target.closest('[data-tippy-root]');
		if (tippyInstance) {
			tippyInstance?._tippy?.hide();
		}
	},
	skip: (event) => {
		event.preventDefault();

		const {
			target: {
				dataset: { href },
			},
			target,
		} = event;

		if (
			/* eslint-disable-next-line no-alert */
			window.confirm(
				`Are you sure you would like to skip the setup wizard? ${
					wizard && wizard.getAttribute('data-is-live') !== '1'
						? 'This will activate Yext search bar and search results on your site using the current configuration.'
						: ''
				}`,
			)
		) {
			updateSettings({ live: true });

			if (href) {
				import('dompurify').then(({ default: DOMPurify }) => {
					window.location.href = DOMPurify.sanitize(href);
				});
			}
		}

		const tippyInstance = target.closest('[data-tippy-root]');
		if (tippyInstance) {
			tippyInstance?._tippy?.hide();
		}
	},
};

const initMenu = () => {
	const menus = new Map();
	const menuButtons = Array.from(document.querySelectorAll('.yext-menu__opener'));

	menuButtons.forEach((button) => {
		const menuDialog = button.getAttribute('data-dialog-id');
		const menuDialogElement = document.getElementById(menuDialog);

		if (menuDialogElement) {
			menus.set(button, menuDialogElement);

			tippy(button, {
				content: menuDialogElement,
				interactive: true,
				delay: [0, 0],
				arrow: false,
				trigger: 'click',
				onShow: () => {
					// @ts-ignore
					[...menus.values()].forEach((dialog) => {
						dialog.classList.add('hidden');
					});
					menuDialogElement.classList.remove('hidden');

					const buttons = menuDialogElement.querySelectorAll('button');
					buttons.forEach((button) => {
						const action = button.getAttribute('data-action');
						if (action) {
							button.addEventListener('click', actions[action]);
						}
					});
				},
				onHidden: () => {
					menuDialogElement.classList.add('hidden');

					const buttons = menuDialogElement.querySelectorAll('button');
					buttons.forEach((button) => {
						const action = button.getAttribute('data-action');
						if (action) {
							button.removeEventListener('click', actions[action]);
						}
					});
				},
			});
		}
	});
};

export default initMenu;
