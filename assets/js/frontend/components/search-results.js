/**
 * Initializes Search Results blocks.
 *
 * Handles cross-browser iframe resizing using IframeResizer.
 *
 * @see {@link https://github.com/davidjbradshaw/iframe-resizer}
 *
 * @param {string=} target HTML element selector.
 * @param {Object=} options IframeResizer options.
 *
 * @return {{init: () => void}} Init method.
 */
const SearchResults = (target = '.yext-search-results-iframe', options = {}) => {
	/**
	 * Resize iFrames.
	 */
	const resize = () => {
		import('iframe-resizer/js/iframeResizer').then(({ default: IframeResize }) => {
			IframeResize({ log: false, ...options }, target);
		});
	};

	/**
	 * Initialize Search Results.
	 */
	const init = () => {
		const targets = Array.from(document.querySelectorAll(target));

		if (targets.length) {
			resize();
		}
	};

	return {
		init,
	};
};

export default SearchResults;
