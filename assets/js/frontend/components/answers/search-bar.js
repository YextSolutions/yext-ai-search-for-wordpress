import Component from './component';

/**
 * @type {string}
 */
const DEFAULT_SEARCH_BAR_CLASS = '.yext-search-bar';

/** @typedef {import('../../types').SearchBarOptions} SearchBarOptions */

/**
 * Search Bar Yext Answers UI Component.
 */
class SearchBar extends Component {
	/**
	 * Construct the search bar component.
	 *
	 * @param {SearchBarOptions} props Search bar props.
	 */
	constructor(props = {}) {
		super('SearchBar', props);
	}
}

/**
 * Search bar component factory.
 *
 * @param {SearchBarOptions} props Default component props.
 *
 * @return {{register: () => void}} Object with `register` method.
 */
const searchBar = (props = {}) => {
	const { cssClass, labelText, placeholderText, submitText, redirectUrl } = props;
	const classnames = [
		DEFAULT_SEARCH_BAR_CLASS,
		...(cssClass ? cssClass.split(',').map((classname) => classname.trim()) : []),
	];

	/**
	 * Filter for valid classnames.
	 *
	 * @param {string[]} classnames List of classnames.
	 *
	 * @return {string[]} List of valid classnames.
	 */
	const getValidClassnames = (classnames) => {
		return (
			classnames
				/**
				 * Remove non-string types and empty strings.
				 */
				.filter((classname) => typeof classname === 'string' && classname.length)
				/**
				 * Prefix the string with a dot if one doesn't exist.
				 */
				.map((classname) => (classname.includes('.') ? classname : `.${classname}`))
		);
	};

	/**
	 * Creates a collection Search Bar components from classnames.
	 *
	 * @param {string[]} classnames A list of classnames.
	 * @param {SearchBarOptions} defaults Default Search Bar options.
	 *
	 * @return {SearchBar[]} A list of Search Bar components.
	 */
	const getSearchBars = (classnames = [], defaults = {}) => {
		/**
		 * @type {SearchBar[]}
		 */
		const searchBars = [];

		/* eslint-disable-next-line consistent-return */
		classnames.forEach((classname) => {
			/**
			 * @type {HTMLElement[]}
			 */
			const nodes = Array.from(document.querySelectorAll(classname));

			if (!nodes.length) {
				return searchBars;
			}

			nodes.forEach((node, index) => {
				/**
				 * @type {SearchBarOptions}
				 */
				const { redirectUrl, labelText, placeholderText, submitText } = node.dataset;
				let uid = classname.replace('.', '');

				/**
				 * Generate a unique identifier for each node
				 * to support mutliple search bars on the page.
				 *
				 * https://hitchhikers.yext.com/docs/answers-sdk/components/search-bar/?target=multiple-search-bars
				 */
				if (index > 0) {
					uid = `${uid}-${index}`;
					node.classList.remove(classname.replace('.', ''));
					node.classList.add(uid);
				}

				/**
				 * @type {SearchBarOptions}
				 */
				const searchBarProps = {
					container: `.${uid}`,
					name: uid,
					redirectUrl: redirectUrl || defaults.redirectUrl,
					labelText: labelText || defaults.labelText,
					placeholderText: placeholderText || defaults.placeholderText,
					submitText: submitText || defaults.submitText,
				};

				searchBars.push(new SearchBar(searchBarProps));
			});
		});

		return searchBars;
	};

	/**
	 * Register all Search Bars.
	 */
	const register = () => {
		/**
		 * @type {SearchBar[]}
		 */
		const searchBars = getSearchBars(getValidClassnames(classnames), {
			labelText,
			submitText,
			placeholderText,
			redirectUrl,
		});

		searchBars.forEach((searchBar) => {
			searchBar.register();
		});
	};

	return {
		register,
	};
};

export default searchBar;
