/**
 * External dependencies
 */
import camelcaseKeys from 'camelcase-keys';

// @ts-ignore
const { wp, YEXT } = window;

const { __ } = wp.i18n;
const { InspectorControls, LineHeightControl, useSetting } = wp.blockEditor;
const {
	PanelBody,
	PanelRow,
	FontSizePicker,
	RangeControl,
	ColorPalette,
	TextControl,
	SelectControl,
	BaseControl,
} = wp.components;
const { useEffect } = wp.element;

const { components } = YEXT.settings;
const {
	searchBar: {
		color: defaultTextColor,
		fontSize: defaultFontSize,
		fontWeight: defaultFontWeight,
		lineHeight: defaultLineHeight,
		borderRadius: defaultBorderRadius,
		borderColor: defaultBorderColor,
		backgroundColor: defaultBackgroundColor,
		props: {
			submitText: defaultSubmitText,
			placeholderText: defaultPlaceholderText,
			labelText: defaultLabelText,
		},
		button: {
			backgroundColor: defaultButtonBackgroundColor,
			hoverBackgroundColor: defaultButtonHoverBackgroundColor,
		},
		autocomplete: {
			backgroundColor: defaultAutocompleteBackgroundColor,
			separatorColor: defaultAutocompleteSeparatorColor,
			optionHoverBackgroundColor: defaultAutocompleteOptionHoverBackgroundColor,
			fontSize: defaultAutocompleteOptionFontSize,
			fontWeight: defaultAutocompleteOptionFontWeight,
			lineHeight: defaultAutocompleteOptionLineHeight,
			headerFontWeight: defaultAutocompleteHeaderFontWeight,
		},
	},
} = camelcaseKeys(components, { deep: true });

const FALLBACK_FONT_SIZE = 16;

const fontSizes = [
	{
		name: __('Small', 'yext'),
		slug: 'small',
		size: 13,
	},
	{
		name: __('Normal', 'yext'),
		slug: 'normal',
		size: 16,
	},
	{
		name: __('Medium', 'yext'),
		slug: 'medium',
		size: 20,
	},
	{
		name: __('Large', 'yext'),
		slug: 'large',
		size: 36,
	},
	{
		name: __('Huge', 'yext'),
		slug: 'huge',
		size: 42,
	},
];

const fontWeights = [
	{
		value: 300,
		label: __('Light', 'yext'),
	},
	{
		value: 400,
		label: __('Normal', 'yext'),
	},
	{
		value: 500,
		label: __('Medium', 'yext'),
	},
	{
		value: 600,
		label: __('Semibold', 'yext'),
	},
	{
		value: 700,
		label: __('Bold', 'yext'),
	},
];

/**
 * Search bar sidebar component.
 *
 * @param {Object} props Component props.
 * @return {Object} Sidebar component.
 */
const Inspector = (props) => {
	const {
		searchBar,
		setAttributes,
		attributes: {
			submitText = defaultSubmitText ?? null,
			placeholderText = defaultPlaceholderText ?? null,
			labelText = defaultLabelText ?? null,
			textColor = defaultTextColor ?? null,
			fontSize = defaultFontSize ? parseInt(defaultFontSize, 10) : FALLBACK_FONT_SIZE,
			fontWeight = defaultFontWeight ? parseInt(defaultFontWeight, 10) : null,
			lineHeight = defaultLineHeight ? parseInt(defaultLineHeight, 10) : null,
			borderRadius = defaultBorderRadius ? parseInt(defaultBorderRadius, 10) : null,
			borderColor = defaultBorderColor ?? null,
			backgroundColor = defaultBackgroundColor ?? null,
			buttonBackgroundColor = defaultButtonBackgroundColor ?? null,
			buttonHoverBackgroundColor = defaultButtonHoverBackgroundColor ?? null,
			autocompleteBackgroundColor = defaultAutocompleteBackgroundColor ?? null,
			autocompleteSeparatorColor = defaultAutocompleteSeparatorColor ?? null,
			autocompleteOptionHoverBackgroundColor = defaultAutocompleteOptionHoverBackgroundColor ??
				null,
			autocompleteOptionFontSize = defaultAutocompleteOptionFontSize
				? parseInt(defaultAutocompleteOptionFontSize, 10)
				: FALLBACK_FONT_SIZE,
			autocompleteOptionFontWeight = defaultAutocompleteOptionFontWeight
				? parseInt(defaultAutocompleteOptionFontWeight, 10)
				: null,
			autocompleteOptionLineHeight = defaultAutocompleteOptionLineHeight
				? parseInt(defaultAutocompleteOptionLineHeight, 10)
				: null,
			autocompleteHeaderFontWeight = defaultAutocompleteHeaderFontWeight
				? parseInt(defaultAutocompleteHeaderFontWeight, 10)
				: null,
		},
	} = props;

	const colors = useSetting('color.palette');

	const cssVariables = {
		fontSize: ['--yxt-searchbar-text-font-size', `${fontSize}px`],
		fontWeight: ['--yxt-searchbar-text-font-weight', fontWeight],
		lineHeight: ['--yxt-searchbar-text-line-height', lineHeight],
		textColor: ['--yxt-searchbar-text-color', textColor],
		borderColor: ['--yxt-searchbar-form-outline-color-base', borderColor],
		borderRadius: ['--yxt-searchbar-form-border-radius', `${borderRadius}px`],
		backgroundColor: ['--yxt-searchbar-form-background-color', backgroundColor],
		buttonBackgroundColor: [
			'--yxt-searchbar-button-background-color-base',
			buttonBackgroundColor,
		],
		buttonHoverBackgroundColor: [
			'--yxt-searchbar-button-background-color-hover',
			buttonHoverBackgroundColor,
		],
		autocompleteBackgroundColor: [
			'--yxt-autocomplete-background-color',
			autocompleteBackgroundColor,
		],
		autocompleteSeparatorColor: [
			'--yxt-autocomplete-separator-color',
			autocompleteSeparatorColor,
		],
		autocompleteOptionHoverBackgroundColor: [
			'--yxt-autocomplete-option-hover-background-color',
			autocompleteOptionHoverBackgroundColor,
		],
		autocompleteOptionFontSize: [
			'--yxt-autocomplete-text-font-size',
			`${autocompleteOptionFontSize}px`,
		],
		autocompleteOptionFontWeight: [
			'--yxt-autocomplete-text-font-weight',
			autocompleteOptionFontWeight,
		],
		autocompleteOptionLineHeight: [
			'--yxt-autocomplete-text-line-height',
			autocompleteOptionLineHeight,
		],
		autocompleteHeaderFontWeight: [
			'--yxt-autocomplete-prompt-header-font-weight',
			autocompleteHeaderFontWeight,
		],
	};

	/**
	 * Update search form CSS variable
	 *
	 * @param {string} attribute Block attribute.
	 * @param {string} value Attribute value.
	 */
	const updateCSSVariableFromAttribute = (attribute, value) => {
		const [variable] = cssVariables[attribute] ?? [];

		if (variable && value) {
			searchBar.current.style.setProperty(variable, value);
		}
	};

	/**
	 * Style attribute update handler.
	 *
	 * @param {string} attribute Block attribute.
	 * @param {string} value Attribute value.
	 * @param {Function} formatter Value formatter used for CSS values.
	 */
	const handleStyleUpdate = (attribute, value, formatter = null) => {
		setAttributes({ [attribute]: value });
		updateCSSVariableFromAttribute(
			attribute,
			typeof formatter === 'function' ? formatter(value) : value,
		);
	};

	useEffect(() => {
		Object.values(cssVariables).forEach(([key, value]) => {
			searchBar.current.style.setProperty(key, value);
		});
		/* eslint-disable-next-line react-hooks/exhaustive-deps */
	}, []);

	return (
		<InspectorControls>
			<PanelBody title={__('Display Settings', 'yext')}>
				<PanelRow>
					<TextControl
						label={__('Placeholder Text', 'yext')}
						value={placeholderText}
						help={__('', 'yext')}
						onChange={(newPlaceholderText) => {
							setAttributes({ placeholderText: newPlaceholderText });
						}}
					/>
				</PanelRow>
				<PanelRow>
					<TextControl
						label={__('Label Text', 'yext')}
						value={labelText}
						help={__('', 'yext')}
						onChange={(newLabelText) => {
							setAttributes({ labelText: newLabelText });
						}}
					/>
				</PanelRow>
				<PanelRow>
					<TextControl
						label={__('Submit Text', 'yext')}
						value={submitText}
						help={__('', 'yext')}
						onChange={(newSubmitText) => {
							setAttributes({ submitText: newSubmitText });
						}}
					/>
				</PanelRow>
				<PanelRow>
					<FontSizePicker
						fontSizes={fontSizes}
						fallbackFontSize={FALLBACK_FONT_SIZE}
						value={fontSize}
						onChange={(newFontSize) => {
							handleStyleUpdate('fontSize', newFontSize, (value) => `${value}px`);
						}}
					/>
				</PanelRow>
				<SelectControl
					label={__('Font Weight', 'yext')}
					value={fontWeight}
					options={fontWeights}
					onChange={(newFontWeight) => {
						handleStyleUpdate('fontWeight', newFontWeight);
					}}
				/>
				<LineHeightControl
					value={lineHeight}
					onChange={(newLineHeight) => {
						handleStyleUpdate('lineHeight', newLineHeight);
					}}
				/>
				<RangeControl
					label={__('Border Radius', 'yext')}
					value={borderRadius}
					min={0}
					max={30}
					onChange={(newBorderRadius) => {
						handleStyleUpdate('borderRadius', newBorderRadius, (value) => `${value}px`);
					}}
				/>
			</PanelBody>
			<PanelBody title={__('Color Settings', 'yext')}>
				<BaseControl id="yext-text-color" label={__('Text Color', 'yext')}>
					<ColorPalette
						value={textColor}
						colors={colors}
						onChange={(color) => {
							handleStyleUpdate('textColor', color);
						}}
					/>
				</BaseControl>
				<BaseControl id="yext-border-color" label={__('Border Color', 'yext')}>
					<ColorPalette
						colors={colors}
						value={borderColor}
						onChange={(color) => {
							handleStyleUpdate('borderColor', color);
						}}
					/>
				</BaseControl>
				<BaseControl id="yext-background-color" label={__('Background Color', 'yext')}>
					<ColorPalette
						colors={colors}
						value={backgroundColor}
						onChange={(color) => {
							handleStyleUpdate('backgroundColor', color);
						}}
					/>
				</BaseControl>
				<BaseControl
					id="yext-button-background-color"
					label={__('Button Background Color', 'yext')}
				>
					<ColorPalette
						colors={colors}
						value={buttonBackgroundColor}
						onChange={(colorValue) => {
							handleStyleUpdate('buttonBackgroundColor', colorValue);
						}}
					/>
				</BaseControl>
				<BaseControl
					id="yext-button-background-hover-color"
					label={__('Button Background Focus Color', 'yext')}
				>
					<ColorPalette
						colors={colors}
						value={buttonHoverBackgroundColor}
						onChange={(colorValue) => {
							handleStyleUpdate('buttonHoverBackgroundColor', colorValue);
						}}
					/>
				</BaseControl>
			</PanelBody>
			<PanelBody title={__('Autocomplete Settings', 'yext')} initialOpen={false}>
				<PanelRow>
					<FontSizePicker
						fontSizes={fontSizes}
						fallbackFontSize={FALLBACK_FONT_SIZE}
						value={autocompleteOptionFontSize}
						onChange={(newFontSize) => {
							setAttributes({ autocompleteOptionFontSize: newFontSize });
						}}
					/>
				</PanelRow>
				<SelectControl
					label={__('Font Weight', 'yext')}
					value={autocompleteOptionFontWeight}
					options={fontWeights}
					onChange={(newFontWeight) => {
						setAttributes({ autocompleteOptionFontWeight: newFontWeight });
					}}
				/>
				<LineHeightControl
					value={autocompleteOptionLineHeight}
					onChange={(newLineHeight) => {
						setAttributes({ autocompleteOptionLineHeight: newLineHeight });
					}}
				/>
				<SelectControl
					label={__('Header Font Weight', 'yext')}
					value={autocompleteHeaderFontWeight}
					options={fontWeights}
					onChange={(newFontWeight) => {
						setAttributes({ autocompleteHeaderFontWeight: newFontWeight });
					}}
				/>
				<BaseControl
					id="yext-autocomplete-background-color"
					label={__('Autocomplete Background Color', 'yext')}
				>
					<ColorPalette
						colors={colors}
						value={autocompleteBackgroundColor}
						onChange={(colorValue) => {
							setAttributes({ autocompleteBackgroundColor: colorValue });
						}}
					/>
				</BaseControl>
				<BaseControl
					id="yext-autocomplete-separator-color"
					label={__('Autocomplete Separator Color', 'yext')}
				>
					<ColorPalette
						colors={colors}
						value={autocompleteSeparatorColor}
						onChange={(colorValue) => {
							setAttributes({ autocompleteSeparatorColor: colorValue });
						}}
					/>
				</BaseControl>
				<BaseControl
					id="yext-autocomplete-option-background-hover-color"
					label={__('Autocomplete Option Background Hover Color', 'yext')}
				>
					<ColorPalette
						colors={colors}
						value={autocompleteOptionHoverBackgroundColor}
						onChange={(colorValue) => {
							setAttributes({ autocompleteOptionHoverBackgroundColor: colorValue });
						}}
					/>
				</BaseControl>
			</PanelBody>
		</InspectorControls>
	);
};

export default Inspector;
