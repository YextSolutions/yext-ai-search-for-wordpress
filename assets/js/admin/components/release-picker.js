const DEFAULT_VERSION = 'v1.2.0';
const RELEASE_ENDPOINT =
	'https://api.github.com/repos/yext/answers-search-ui/releases?per_page=100';

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
	 * Fetch releases from Github.
	 *
	 * @return {Promise<SearchBarRelease[]>} A promise that resolves to an array of releases.
	 */
	const fetchReleases = async () =>
		fetch(RELEASE_ENDPOINT)
			.then((response) => response.json())
			.then((response) =>
				response
					.map((release) => ({
						name: release.tag_name,
						version: release.tag_name.replace('search-bar-', ''),
						isPublished: release.draft === false && release.prerelease === false,
					}))
					.filter(({ name, isPublished }) => name.includes('search-bar') && isPublished),
			)
			.catch((error) => {
				// eslint-disable-next-line no-console
				console.error(error);
				return [{ version: DEFAULT_VERSION }, { version: 'v1.1.0' }, { version: 'v1.0.0' }];
			});

	/**
	 * Build an option element.
	 *
	 * @param {SearchBarRelease} release - The release to build an option for.
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
	};

	(() => {
		fetchReleases().then(renderOptions).then(setSelectedVersion);
	})();
};

export default initReleasePicker;
