import Accordion from '@10up/component-accordion';

const initAccordion = () => {
	const yextSettings = document.querySelector('#yext-settings');
	const yextWizard = document.querySelector('#yext-wizard');

	// do nothing if not Yext settings form
	if (!yextSettings && !yextWizard) {
		return;
	}

	/**
	 * @type {HTMLElement[]}
	 */
	const accordionElements = Array.from(document.querySelectorAll('.accordion'));
	const [firstAccordion] = accordionElements;

	accordionElements.forEach((accordion) => {
		const title = accordion.querySelector('h2');
		const content = accordion.querySelector('table');
		const label = title.cloneNode();
		const helpText = accordion.dataset.help;

		const helpNode = document.createElement('p');
		helpNode.textContent = helpText;

		content.classList.add('accordion-content');
		// @ts-ignore
		label.classList.add('accordion-label');
		label.textContent = title.textContent;
		content.prepend(helpNode);
		content.prepend(label);

		title.outerHTML = `
			<button class="accordion-header" type="button">${title.textContent}</button>
		`;
	});

	// @ts-ignore
	// eslint-disable-next-line no-new
	new Accordion('.accordion');

	if (firstAccordion) {
		firstAccordion.querySelector('.accordion-header').classList.add('is-active');
		firstAccordion.querySelector('.accordion-content').classList.add('is-active');
	}
};

export default initAccordion;
