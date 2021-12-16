// Components
import SearchBarPreview from './components/search-bar-preview';
import { initTabs, initAccordion, initWizard } from './components';

// safe to ignore, this is not a react component
// eslint-disable-next-line @wordpress/no-global-event-listener
window.addEventListener('DOMContentLoaded', () => {
	initTabs();
	initAccordion();
	initWizard();

	const preview = new SearchBarPreview();
	preview.init();
});
