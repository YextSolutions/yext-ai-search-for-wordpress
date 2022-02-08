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
		const help = accordion.querySelector('.data-tippy-content');
		const content = accordion.querySelector('table');
		const label = title.cloneNode();
		let helpText = '';

		content.classList.add('accordion-content');
		// @ts-ignore
		label.classList.add('accordion-label');
		label.textContent = title.textContent;
		content.prepend(label);

		if (help) {
			helpText = help.outerHTML;
			help.remove();
		}

		title.outerHTML = `
			<button class="accordion-header" type="button">${title.textContent} ${helpText}</button>
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
