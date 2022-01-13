/**
 * Yext plugin settings object.
 *
 * @typedef {Object} YextPluginSettings
 *
 * @property {import('./types').YextPluginConfig} config  Config.
 * @property {import('./types').YextComponents} components Components.
 */

interface Window {
	YEXT: {
		defaults: YextPluginSettings;
		settings: YextPluginSettings;
		settings_url: string;
		rest_url: string;
		siteUrl: string;
	};
	ANSWERS: {
		init: Function;
	};
	TemplateBundle: Object;
}
