// Components
import SearchBarPreview from './components/search-bar-preview';
import { initAccordion, initMenu, initTabs, initWizard } from './components';

// safe to ignore, this is not a react component
// eslint-disable-next-line @wordpress/no-global-event-listener
window.addEventListener('DOMContentLoaded', () => {
	initAccordion();
	initMenu();
	initTabs();
	initWizard();

	const preview = new SearchBarPreview();
	preview.init();
});
