import Accordion from '@10up/component-accordion';

const initAccordion = () => {
	const yextForm = document.querySelector('#yext-settings form');

	// do nothing if not Yext settings form
	if (!yextForm) {
		return;
	}

	const accordionElements = Array.from(document.querySelectorAll('#yext-settings .accordion'));
	const [firstAccordion] = accordionElements;

	accordionElements.forEach((accordion) => {
		const title = accordion.querySelector('h2');
		const content = accordion.querySelector('table');
		const label = title.cloneNode();

		content.classList.add('accordion-content');
		// @ts-ignore
		label.classList.add('accordion-label');
		label.textContent = title.textContent;
		content.prepend(label);

		title.outerHTML = `
			<button class="accordion-header" type="button">${title.textContent}</button>
		`;
	});

	// @ts-ignore
	// eslint-disable-next-line no-new
	new Accordion('#yext-settings .accordion');

	firstAccordion.querySelector('.accordion-header').classList.add('is-active');
	firstAccordion.querySelector('.accordion-content').classList.add('is-active');
};

export default initAccordion;
