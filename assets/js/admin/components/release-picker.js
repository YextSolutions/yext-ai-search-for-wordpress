// @ts-ignore
import { addQueryArgs } from '@wordpress/url';

const DEFAULT_VERSION = 'v1.2.1';
const RELEASE_ENDPOINT = 'https://api.github.com/repos/yext/answers-search-ui/releases';

const {
	YEXT: {
		settings: {
			plugin: { sdk_version: selectedVersion },
		},
	},
} = window;

export const initReleasePicker = () => {
	const picker = document.querySelector('#sdk_version');

	if (!picker || !(picker instanceof HTMLSelectElement)) {
		return;
	}

	/**
	 * @typedef {Object} SearchBarRelease - A release object from Github.
	 * @property {string} name - The name of the release.
	 * @property {string} version - The version of the release.
	 * @property {boolean} isPublished - Whether the release is published.
	 */

	/**
	 * Github Release API response.
	 *
	 * @param {{tag_name: string, draft: boolean, prerelease: boolean}} release - A release object from Github.
	 *
	 * @return {SearchBarRelease} - A formatted release object.
	 */
	const formatRelease = (release) => ({
		name: release.tag_name,
		version: release.tag_name.replace('search-bar-', ''),
		isPublished: release.draft === false && release.prerelease === false,
	});

	/**
	 * Check if a release is a published search bar.
	 *
	 * @param {SearchBarRelease} release - A formatted Github release.
	 *
	 * @return {boolean} - Whether the release is a search bar release.
	 */
	const isSearchBarRelease = ({ name, isPublished }) =>
		name.includes('search-bar-') && isPublished;

	/**
	 * Fetch releases from Github.
	 *
	 * @param {string} url - The endpoint to fetch from.
	 * @param {Object} params - The query parameters to send with the request.
	 * @param {Object} [options] - Options to pass to the fetch call.
	 *
	 * @return {Promise<{data: SearchBarRelease[], headers?: Headers}>} A promise that resolves to an array of releases.
	 */
	const fetchReleases = async (
		url = RELEASE_ENDPOINT,
		params = { per_page: 100 },
		options = {},
	) => {
		try {
			const response = await fetch(addQueryArgs(url, params), options);

			if (!response.ok) {
				throw new Error(`Failed to fetch releases from ${url}`);
			}

			const data = await response.json();

			return {
				data: data.map(formatRelease).filter(isSearchBarRelease),
				headers: response.headers,
			};
		} catch (error) {
			// eslint-disable-next-line no-console
			console.error(error);
			return {
				data: [
					{ version: DEFAULT_VERSION },
					{ version: 'v1.2.0' },
					{ version: 'v1.1.0' },
					{ version: 'v1.0.0' },
				].map((release) => ({
					...release,
					isPublished: true,
					name: `search-bar-${release.version}`,
				})),
				headers: null,
			};
		}
	};

	/**
	 * Fetch all pages of releases from Github.
	 *
	 * @param {string} url - The endpoint to fetch from.
	 * @param {SearchBarRelease[]} releases - The releases to add to the select.
	 *
	 * @return {Promise<SearchBarRelease[]>} A promise that resolves to an array of releases.
	 */
	const fetchReleasesWithPagination = async (url = RELEASE_ENDPOINT, releases = []) => {
		const nextReleases = await fetchReleases(url);
		const { data, headers } = nextReleases;

		if (headers) {
			const linkHeader = headers.get('link');
			const next = linkHeader?.match(/<([^>]+)>; rel="next"/);

			if (next) {
				return fetchReleasesWithPagination(next[1], [...releases, ...data]);
			}
		}

		return [...releases, ...data];
	};

	/**
	 * Build an option element.
	 *
	 * @param {SearchBarRelease} release - The release to build an option for.
	 *
	 * @return {HTMLOptionElement} - The option element.
	 */
	const buildOption = ({ version }) => {
		const option = document.createElement('option');
		option.value = version;
		option.textContent = version;
		return option;
	};

	/**
	 * Render the option elements.
	 *
	 * @param {SearchBarRelease[]} releases - The releases to render.
	 */
	const renderOptions = (releases) => {
		picker.remove(0);

		(Array.isArray(releases) ? releases : []).forEach((option) => {
			picker.add(buildOption(option));
		});
	};

	/**
	 * Set the selected version.
	 */
	const setSelectedVersion = () => {
		let version = DEFAULT_VERSION;
		const optionValues = Array.from(picker.options).map((option) => option.value);

		if (selectedVersion && optionValues.includes(selectedVersion)) {
			version = selectedVersion;
		}

		picker.value = version;
		picker.disabled = false;
	};

	(() => {
		picker.disabled = true;
		fetchReleasesWithPagination().then(renderOptions).then(setSelectedVersion);
	})();
};

export default initReleasePicker;
