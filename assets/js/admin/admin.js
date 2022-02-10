// Components
import SearchBarPreview from './components/search-bar-preview';
import {
	initAccordion,
	initMenu,
	initSettings,
	initTabs,
	initTooltips,
	initWizard,
	initDropdownWithLink,
	initReleasePicker,
} from './components';

// safe to ignore, this is not a react component
// eslint-disable-next-line @wordpress/no-global-event-listener
window.addEventListener('DOMContentLoaded', () => {
	initAccordion();
	initMenu();
	initSettings();
	initTabs();
	initTooltips();
	initWizard();
	initDropdownWithLink();
	initReleasePicker();

	const preview = new SearchBarPreview();
	preview.init();
});
