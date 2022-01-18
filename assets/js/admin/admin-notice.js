const {
	YEXT: { rest_url: REST_API_ROUTE },
} = window;

const hideActivationNotice = (event) => {
	const { target } = event;

	if (target instanceof HTMLButtonElement) {
		import('@wordpress/api-fetch').then(({ default: apiFetch }) => {
			apiFetch({
				path: `${REST_API_ROUTE}/activated`,
				method: 'POST',
				data: {
					activated: true,
				},
			}).catch((error) => {
				/* eslint-disable-next-line no-console */
				console.error(error);
			});
		});
	}
};

/* eslint-disable-next-line @wordpress/no-global-event-listener */
window.addEventListener('DOMContentLoaded', () => {
	const notice = document.querySelector('.yext-activated-notice');

	if (notice) {
		notice.addEventListener('click', hideActivationNotice);
	}
});
