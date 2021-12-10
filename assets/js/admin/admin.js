// Components
import './components/tabs';
import YextSearchBarPreview from './components/search-bar-preview';
import { initTabs, initToggler, initDropdownWithLink } from './components';

// safe to ignore, this is not a react component
// eslint-disable-next-line @wordpress/no-global-event-listener
window.addEventListener('DOMContentLoaded', () => {
	initTabs();
	initToggler();
	initDropdownWithLink();
	// eslint-disable-next-line no-new
	new YextSearchBarPreview();
});
