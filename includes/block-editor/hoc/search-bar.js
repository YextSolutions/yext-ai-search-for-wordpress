/**
 * Core Search Bar Block
 */

import camelcaseKeys from 'camelcase-keys';

// @ts-ignore
const { wp, YEXT } = window;
const { components, config } = YEXT.settings;
const {
	searchBar: {
		props: { overrideCoreSearch },
	},
} = camelcaseKeys(components, { deep: true });
const { apiKey, experienceKey, businessId } = camelcaseKeys(config);
const isValid = apiKey && experienceKey && businessId;

const { __ } = wp.i18n;
const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { Notice } = wp.components;
const { addFilter } = wp.hooks;

/**
 * Blocks containing a border filter. Any block in this array will be
 * preceeded by this higher order component.
 */
const blocksWithFilter = [
	// Core blocks
	'core/search',
];

/**
 * Add Underline Toggle Option
 */
const addSearchBarToggle = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		const { name } = props;

		if (!blocksWithFilter.includes(name)) {
			// @ts-ignore
			return <BlockEdit {...props} />;
		}

		if (!overrideCoreSearch) {
			// @ts-ignore
			return <BlockEdit {...props} />;
		}

		return (
			<Fragment>
				<BlockEdit {...props} />
				<InspectorControls>
					{!isValid ? (
						<Notice status="warning" isDismissible={false}>
							<p>
								{__(
									'Please enter API Key, Experience Key, and Business ID in plugin settings.',
									'yext',
								)}
							</p>
						</Notice>
					) : (
						<Notice status="warning" isDismissible={false}>
							<p>
								{__(
									'Override WordPress Search is enabled in Yext plugin settings. This block will be transformed into a Yext Search Bar. Consider using the Yext Search Bar block for more customization options.',
									'yext',
								)}
							</p>
						</Notice>
					)}
				</InspectorControls>
			</Fragment>
		);
	};
}, 'addSearchBarToggle');

addFilter('editor.BlockEdit', 'yext/search-bar-filter/add-search-bar-toggle', addSearchBarToggle);
