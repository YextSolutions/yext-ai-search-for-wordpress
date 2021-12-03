// Components
import './components/tabs';
import YextSearchBarPreview from './components/search-bar-preview';
import { initTabs, initToggler } from './components';

// safe to ignore, this is not a react component
// eslint-disable-next-line @wordpress/no-global-event-listener
window.addEventListener('DOMContentLoaded', () => {
	initTabs();
	initToggler();
	new YextSearchBarPreview();
});
