import searchBar from './search-bar';

/**
 * Initialize Yext Answers UI SDK
 *
 * @see {@link https://hitchhikers.yext.com/docs/answers-sdk/core-concepts/initialization/?target=answers-initialization}
 *
 * @param {Object} props Props.
 * @param {import('../../types').AnswersUIOptions} props.config Configuration options.
 * @param {import('../../types').YextComponents} props.components Answers UI SDK Components.
 *
 * @return {{init?: () => Promise<void>, error?: string}} Object with `init` method or `error` property.
 */
const Answers = ({ config, components }) => {
	/**
	 * Bail if credentials have not been configured
	 */
	if (!config.apiKey || !config.experienceKey || !config.businessId) {
		return {
			error: 'Missing one or more required credentials: apiKey, experienceKey, businessId',
		};
	}

	/** @typedef {import('../../types').AnswersUIOptions} AnswersUIOptions */

	/**
	 * @type {AnswersUIOptions}
	 */
	const options = {
		apiKey: config.apiKey,
		experienceKey: config.experienceKey,
		locale: config.locale,
		businessId: config.businessId,
		templateBundle: config.templateBundle,
	};

	const {
		searchBar: { props: searchBarProps },
	} = components;

	/**
	 * Invoked when the Answers component library is loaded/ready.
	 *
	 * Iterate over `components` property keys and dynamically import
	 * and instantiate the corresponsing component.
	 */
	const onReady = async () => {
		const SearchBar = searchBar(searchBarProps);
		SearchBar.register();
	};

	/**
	 * Initialize the library.
	 *
	 * @return {Promise<void>}
	 */
	const init = () => {
		return new Promise((resolve, reject) => {
			try {
				window.ANSWERS.init({
					...options,
					onReady: async () => {
						await onReady();
						resolve();
					},
				});
			} catch (error) {
				/* eslint-disable-next-line no-console */
				console.error(`Yext: Error initializing Answers UI SDK: ${error}`);
				reject();
			}
		});
	};

	return {
		init,
	};
};

export default Answers;
