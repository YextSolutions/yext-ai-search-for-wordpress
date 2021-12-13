/**
 * Core Search Bar Block
 */

import camelcaseKeys from 'camelcase-keys';

// @ts-ignore
const { wp, YEXT, _ } = window;
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
const { PanelBody, ToggleControl, Notice } = wp.components;
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
 * Add expandable image class to block editor
 */
const addSearchBarClass = createHigherOrderComponent((BlockListBlock) => {
	return (props) => {
		const {
			attributes: { useYextSearchBar },
		} = props;

		if (useYextSearchBar) {
			return <BlockListBlock {...props} className="yext-search-bar" />;
		}

		return <BlockListBlock {...props} />;
	};
}, 'addSearchBarClass');

addFilter(
	'editor.BlockListBlock',
	'yext/search-bar-filter/add-search-bar-class',
	addSearchBarClass,
);

/**
 * Add Underline Toggle Option
 */
const addSearchBarToggle = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		const {
			attributes: { useYextSearchBar },
			setAttributes,
			name,
		} = props;

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
					<PanelBody title={__('Yext Settings', 'yext')}>
						<ToggleControl
							label={__('Use Yext Search Bar', 'yext')}
							help={__('Transform into Yext search bar.', 'yext')}
							checked={useYextSearchBar}
							onChange={() => {
								setAttributes({ useYextSearchBar: !useYextSearchBar });
							}}
						/>
						{useYextSearchBar && !isValid && (
							<Notice status="warning" isDismissible={false}>
								<p>
									{__(
										'Please enter API Key, Experience Key, and Business ID in plugin settings.',
										'yext',
									)}
								</p>
							</Notice>
						)}
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'addSearchBarToggle');

addFilter('editor.BlockEdit', 'yext/search-bar-filter/add-search-bar-toggle', addSearchBarToggle);

/**
 * Add border attributes to block
 *
 * @param  {Object} settings Default Block Settings
 * @param  {string} name     Block Name
 * @return {Object}          Updated settings object
 */
function addSearchBarAttribute(settings, name) {
	if (!blocksWithFilter.includes(name)) {
		return settings;
	}

	if (settings.attributes) {
		settings.attributes.useYextSearchBar = {
			type: 'boolean',
			default: true,
		};
	}

	return settings;
}

addFilter(
	'blocks.registerBlockType',
	'yext/search-bar-filter/add-search-bar-attribute',
	addSearchBarAttribute,
);

/**
 * Save the isExpandable attribute information to the frontend
 *
 * @param  {Object} props      Block Props
 * @param  {Object} block      Block Object
 * @param  {Object} attributes Block Attributes
 * @return {Object}            Updated Object of Properties
 */
function saveSearchBarAttribute(props, block, attributes) {
	if (!blocksWithFilter.includes(block.name)) {
		return props;
	}

	const { className } = props;
	const { useYextSearchBar } = attributes;
	let classes = className || '';

	if (useYextSearchBar) {
		classes += ' yext-search-bar';
	}

	return _.assign(props, { className: classes });
}

addFilter(
	'blocks.getSaveContent.extraProps',
	'yext/search-bar-filter/save-search-bar-attribute',
	saveSearchBarAttribute,
);
