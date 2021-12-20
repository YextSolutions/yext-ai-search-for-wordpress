import Accordion from '@10up/component-accordion';

const initAccordion = () => {
	const yextSettings = document.querySelector('#yext-settings');
	const yextWizard = document.querySelector('#yext-wizard');

	// do nothing if not Yext settings form
	if (!yextSettings && !yextWizard) {
		return;
	}

	const accordionElements = Array.from(document.querySelectorAll('.accordion'));
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
	new Accordion('.accordion');

	firstAccordion.querySelector('.accordion-header').classList.add('is-active');
	firstAccordion.querySelector('.accordion-content').classList.add('is-active');
};

export default initAccordion;
