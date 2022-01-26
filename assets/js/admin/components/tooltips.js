import tippy from 'tippy.js';

const initTooltips = () => {
	const tooltips = document.querySelectorAll('[data-tippy-content]');

	if (!tooltips.length) {
		return;
	}

	tooltips.forEach((tooltip) => {
		const input = tooltip.nextElementSibling;

		if (input instanceof HTMLInputElement || input instanceof HTMLSelectElement) {
			const [label] = Array.from(input.labels);

			if (label) {
				const clone = tooltip.cloneNode(true);
				label.parentElement.appendChild(clone);

				tooltip.outerHTML = '';
			}
		}
	});

	tippy('[data-tippy-content]', {
		placement: 'right',
	});

	tooltips.forEach((tooltip) => {
		tooltip.addEventListener('click', (event) => {
			event.preventDefault();
		});
	});
};

export default initTooltips;
