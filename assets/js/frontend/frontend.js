const DEFAULT_CSS_CLASS = '.yext-search-bar';

/**
 * Initialize Yext
 */
/* eslint-disable-next-line @wordpress/no-global-event-listener, no-use-before-define */
window.addEventListener('DOMContentLoaded', yextInit);

/**
 * Setup Yext UI
 *
 * @return {void}
 */
function yextInit() {
	if (!window.YEXT) {
		/* eslint-disable-next-line no-console */
		console.error('Yext: Missing plugin configuration options.');
		return;
	}

	if (!window.ANSWERS) {
		/* eslint-disable-next-line no-console */
		console.error('Yext: Answers UI SDK not loaded.');
		return;
	}

	if (!window.TemplateBundle) {
		/* eslint-disable-next-line no-console */
		console.error('Yext: Answers UI Template bundle not loaded.');
		return;
	}

	const {
		settings: {
			plugin: {
				api_key: apiKey,
				business_id: businessId,
				experience_key: experienceKey,

				/**
				 * 🚨🚨  ***** TODO ***** 🚨🚨
				 *
				 * Need to add locale option to plugin settings.
				 */
				locale,
			} = {},
			search_bar: {
				create: {
					css_class: cssClass,
					label_text: labelText,
					placeholder: placeholderText,
					redirect_url: redirectUrl,
					submit_text: submitText,
				} = {},
				override_core_search: overrideCoreSearch,
			} = {},
		},
	} = window.YEXT;

	// Bail if credentials have not been configured
	if (!apiKey || !experienceKey || !businessId) {
		return;
	}

	/**
	 * The only component rendered with
	 * Yext Answers UI SDK at this time
	 * is the Search Bar, so let's bail
	 * if search bar is not enabled.
	 */
	if (!overrideCoreSearch && !cssClass) {
		return;
	}

	/** @typedef {import('./types').AnswersUIOptions} AnswersUIOptions */

	/**
	 * @type {AnswersUIOptions}
	 */
	const options = {
		apiKey,
		experienceKey,
		locale,
		businessId,
		templateBundle: window.TemplateBundle,
		onReady: () => {
			/* eslint-disable-next-line no-use-before-define */
			registerSearchBars([DEFAULT_CSS_CLASS, cssClass], {
				redirectUrl,
				labelText,
				placeholderText,
				submitText,
			});
		},
	};

	try {
		window.ANSWERS.init(options);
	} catch (error) {
		/* eslint-disable-next-line no-console */
		console.error(`Yext: Error initializing Answers UI SDK: ${error}`);
	}
}

/** @typedef {import('./types').SearchBarOptions} SearchBarOptions */

/**
 * Turns HTMLElements into Yext Search Bars
 *
 * @param {string[]} classes Classnames to transform into search bars.
 * @param {SearchBarOptions} defaults Default options. Used when registering the search bar.
 *
 * @return {SearchBarOptions[]}
 */
function registerSearchBars(classes = [DEFAULT_CSS_CLASS], defaults = {}) {
	const searchBars = [];
	const searchBarClasses = classes
		/**
		 * Remove non-string types and empty strings.
		 */
		.filter((classname) => typeof classname === 'string' && classname.length)
		/**
		 * Prefix the string with a dot if one doesn't exist.
		 */
		.map((classname) => (classname.includes('.') ? classname : `.${classname}`));

	searchBarClasses.forEach((classname) => {
		const nodes = Array.from(document.querySelectorAll(classname));

		if (!nodes.length) {
			return;
		}

		nodes.forEach((node, index) => {
			const { redirectUrl, labelText, placeholderText, submitText } = node.dataset;
			let uid = classname;

			/**
			 * Generate a unique identifier for each node
			 * to support mutliple search bars on the page
			 *
			 * https://hitchhikers.yext.com/docs/answers-sdk/components/search-bar/?target=multiple-search-bars
			 */
			if (index > 0) {
				uid = `${classname}-${index}`;
				node.className.add(uid);
			}

			/**
			 * @type {SearchBarOptions}
			 */
			const searchBar = {
				container: uid,
				name: uid,
				redirectUrl: redirectUrl || defaults.redirectUrl,
				labelText: labelText || defaults.labelText,
				placeholderText: placeholderText || defaults.placeholderText,
				submitText: submitText || defaults.submitText,
			};

			searchBars.push(searchBar);
		});
	});

	if (!window.ANSWERS) {
		return searchBars;
	}

	searchBars.forEach((searchBar) => {
		window.ANSWERS.addComponent('SearchBar', searchBar);
	});
}
