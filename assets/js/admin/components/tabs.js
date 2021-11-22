// Imports
import tabs from '@10up/component-tabs';

// eslint-disable-next-line new-cap, no-new
const init = () => new tabs('#yext-settings .tabs');

// safe to ignore, this is not a react component
// eslint-disable-next-line @wordpress/no-global-event-listener
window.addEventListener('DOMContentLoaded', () => {
	init();
});
