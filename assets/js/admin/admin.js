// import foo from './bar'

// Components
import { initTabs, initToggler } from './components';

// safe to ignore, this is not a react component
// eslint-disable-next-line @wordpress/no-global-event-listener
window.addEventListener('DOMContentLoaded', () => {
	initTabs();
	initToggler();
});
