/**
 * External dependencies
 */
import camelcaseKeys from 'camelcase-keys';

/**
 * Internal dependencies
 */
import ColorPicker from '../../components/color-picker';

const {
	// @ts-ignore
	wp,
	YEXT: { settings, iconOptions },
} = window;

const { __ } = wp.i18n;
const { InspectorControls, LineHeightControl, useSetting } = wp.blockEditor;
const { PanelBody, PanelRow, FontSizePicker, RangeControl, TextControl, SelectControl } =
	wp.components;
const { useEffect } = wp.element;
const { Notice } = wp.components;

const { config, components } = settings;
const { apiKey, experienceKey, businessId } = camelcaseKeys(config);
const isValid = apiKey && experienceKey && businessId;

const {
	searchBar: {
		style: {
			color: defaultTextColor,
			fontSize: defaultFontSize,
			fontWeight: defaultFontWeight,
			lineHeight: defaultLineHeight,
			borderRadius: defaultBorderRadius,
			borderColor: defaultBorderColor,
			backgroundColor: defaultBackgroundColor,
		},
		placeholder: {
			color: defaultPlaceholderTextColor,
			fontWeight: defaultPlaceholderFontWeight,
		},
		props: {
			submitText: defaultSubmitText,
			submitIcon: defaultSubmitIcon,
			placeholderText: defaultPlaceholderText,
			labelText: defaultLabelText,
			promptHeader: defaultPromptHeader,
		},
		button: {
			backgroundColor: defaultButtonBackgroundColor,
			hoverBackgroundColor: defaultButtonHoverBackgroundColor,
			textColor: defaultButtonTextColor,
			hoverTextColor: defaultButtonHoverTextColor,
		},
		autocomplete: {
			textColor: defaultAutocompleteTextColor,
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
			submitText = defaultSubmitText ?? 'Submit',
			submitIcon = defaultSubmitIcon ?? '',
			placeholderText = defaultPlaceholderText ?? '',
			promptHeader = defaultPromptHeader ?? '',
			labelText = defaultLabelText ?? 'Conduct a search',
			textColor = defaultTextColor ?? '#212121',
			fontSize = defaultFontSize ? parseInt(defaultFontSize, 10) : FALLBACK_FONT_SIZE,
			fontWeight = defaultFontWeight ?? '400',
			lineHeight = defaultLineHeight ?? '1.5',
			borderRadius = defaultBorderRadius ? parseInt(defaultBorderRadius, 10) : 6,
			borderColor = defaultBorderColor ?? '#dcdcdc',
			backgroundColor = defaultBackgroundColor ?? '#ffffff',
			placeholderTextColor = defaultPlaceholderTextColor ?? '#646970',
			placeholderFontWeight = defaultPlaceholderFontWeight ?? '400',
			buttonBackgroundColor = defaultButtonBackgroundColor ?? '#ffffff',
			buttonHoverBackgroundColor = defaultButtonHoverBackgroundColor ?? '#e9e9e9',
			buttonTextColor = defaultButtonTextColor ?? '#000000',
			buttonHoverTextColor = defaultButtonHoverTextColor ?? '#000000',
			autocompleteTextColor = defaultAutocompleteTextColor ?? '#212121',
			autocompleteBackgroundColor = defaultAutocompleteBackgroundColor ?? '#ffffff',
			autocompleteSeparatorColor = defaultAutocompleteSeparatorColor ?? '#dcdcdc',
			autocompleteOptionHoverBackgroundColor = defaultAutocompleteOptionHoverBackgroundColor ??
				'#f9f9f9',
			autocompleteOptionFontSize = defaultAutocompleteOptionFontSize
				? parseInt(defaultAutocompleteOptionFontSize, 10)
				: FALLBACK_FONT_SIZE,
			autocompleteOptionFontWeight = defaultAutocompleteOptionFontWeight
				? parseInt(defaultAutocompleteOptionFontWeight, 10)
				: '400',
			autocompleteOptionLineHeight = defaultAutocompleteOptionLineHeight
				? parseInt(defaultAutocompleteOptionLineHeight, 10)
				: '1.4',
			autocompleteHeaderFontWeight = defaultAutocompleteHeaderFontWeight
				? parseInt(defaultAutocompleteHeaderFontWeight, 10)
				: '300',
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
		placeholderTextColor: ['--yxt-searchbar-placeholder-color', placeholderTextColor],
		placeholderFontWeight: ['--yxt-searchbar-placeholder-font-weight', placeholderFontWeight],
		buttonBackgroundColor: [
			'--yxt-searchbar-button-background-color-base',
			buttonBackgroundColor,
		],
		buttonHoverBackgroundColor: [
			'--yxt-searchbar-button-background-color-hover',
			buttonHoverBackgroundColor,
		],
		buttonTextColor: ['--yxt-searchbar-button-text-color', buttonTextColor],
		buttonHoverTextColor: ['--yxt-searchbar-button-text-color-hover', buttonHoverTextColor],
		autocompleteTextColor: ['--yxt-autocomplete-text-color', autocompleteTextColor],
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
	 * @param {Function} formatter Value formatter used for CSS
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
	}, []); // eslint-disable-line react-hooks/exhaustive-deps

	return (
		<InspectorControls>
			<PanelBody title={__('Display Settings', 'yext')}>
				{!isValid && (
					<Notice status="warning" isDismissible={false}>
						<p>
							{__(
								'Please enter API Key, Experience Key, and Business ID in plugin settings.',
								'yext',
							)}
						</p>
					</Notice>
				)}
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
					<SelectControl
						label={__('Icon', 'yext')}
						value={submitIcon}
						help={__('', 'yext')}
						options={Object.keys(iconOptions).reduce((arr, icon) => {
							arr.push({
								label: iconOptions[icon],
								value: icon,
							});

							return arr;
						}, [])}
						onChange={(newSubmitIcon) => {
							setAttributes({ submitIcon: newSubmitIcon });
						}}
					/>
				</PanelRow>
				<PanelRow>
					<TextControl
						label={__('Autocomplete Heading', 'yext')}
						value={promptHeader}
						help={__('', 'yext')}
						onChange={(newPromptHeader) => {
							setAttributes({ promptHeader: newPromptHeader });
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
				<ColorPicker
					id="yext-text-color"
					label={__('Text Color', 'yext')}
					value={textColor}
					colors={colors}
					onChange={(color) => {
						handleStyleUpdate('textColor', color);
					}}
				/>
				<ColorPicker
					id="yext-border-color"
					label={__('Border Color', 'yext')}
					colors={colors}
					value={borderColor}
					onChange={(color) => {
						handleStyleUpdate('borderColor', color);
					}}
				/>
				<ColorPicker
					id="yext-background-color"
					label={__('Background Color', 'yext')}
					colors={colors}
					value={backgroundColor}
					onChange={(color) => {
						handleStyleUpdate('backgroundColor', color);
					}}
				/>
				<ColorPicker
					id="yext-button-background-color"
					label={__('Button Background Color', 'yext')}
					colors={colors}
					value={buttonBackgroundColor}
					onChange={(colorValue) => {
						handleStyleUpdate('buttonBackgroundColor', colorValue);
					}}
				/>
				<ColorPicker
					id="yext-button-background-hover-color"
					label={__('Button Background Focus Color', 'yext')}
					colors={colors}
					value={buttonHoverBackgroundColor}
					onChange={(colorValue) => {
						handleStyleUpdate('buttonHoverBackgroundColor', colorValue);
					}}
				/>
				<ColorPicker
					id="yext-button-text-color"
					label={__('Button Text Color', 'yext')}
					colors={colors}
					value={buttonTextColor}
					onChange={(colorValue) => {
						handleStyleUpdate('buttonTextColor', colorValue);
					}}
				/>
				<ColorPicker
					id="yext-button-text-hover-color"
					label={__('Button Text Focus Color', 'yext')}
					colors={colors}
					value={buttonHoverTextColor}
					onChange={(colorValue) => {
						handleStyleUpdate('buttonHoverTextColor', colorValue);
					}}
				/>
			</PanelBody>
			<PanelBody title={__('Placeholder Settings', 'yext')} initialOpen={false}>
				<ColorPicker
					id="yext-placeholder-text-color"
					label={__('Text Color', 'yext')}
					value={placeholderTextColor}
					colors={colors}
					onChange={(color) => {
						handleStyleUpdate('placeholderTextColor', color);
					}}
				/>
				<SelectControl
					label={__('Font Weight', 'yext')}
					value={placeholderFontWeight}
					options={fontWeights}
					onChange={(newFontWeight) => {
						handleStyleUpdate('placeholderFontWeight', newFontWeight);
					}}
				/>
			</PanelBody>
			<PanelBody title={__('Autocomplete Settings', 'yext')} initialOpen={false}>
				<PanelRow>
					<FontSizePicker
						fontSizes={fontSizes}
						fallbackFontSize={FALLBACK_FONT_SIZE}
						value={autocompleteOptionFontSize}
						onChange={(newFontSize) => {
							handleStyleUpdate('autocompleteOptionFontSize', newFontSize);
						}}
					/>
				</PanelRow>
				<SelectControl
					label={__('Font Weight', 'yext')}
					value={autocompleteOptionFontWeight}
					options={fontWeights}
					onChange={(newFontWeight) => {
						handleStyleUpdate('autocompleteOptionFontWeight', newFontWeight);
					}}
				/>
				<LineHeightControl
					value={autocompleteOptionLineHeight}
					onChange={(newLineHeight) => {
						handleStyleUpdate('autocompleteOptionLineHeight', newLineHeight);
					}}
				/>
				<SelectControl
					label={__('Header Font Weight', 'yext')}
					value={autocompleteHeaderFontWeight}
					options={fontWeights}
					onChange={(newFontWeight) => {
						handleStyleUpdate('autocompleteHeaderFontWeight', newFontWeight);
					}}
				/>
				<ColorPicker
					id="yext-autocomplete-text-color"
					label={__('Autocomplete Text Color', 'yext')}
					colors={colors}
					value={autocompleteTextColor}
					onChange={(colorValue) => {
						handleStyleUpdate('autocompleteTextColor', colorValue);
					}}
				/>
				<ColorPicker
					id="yext-autocomplete-background-color"
					label={__('Autocomplete Background Color', 'yext')}
					colors={colors}
					value={autocompleteBackgroundColor}
					onChange={(colorValue) => {
						handleStyleUpdate('autocompleteBackgroundColor', colorValue);
					}}
				/>
				<ColorPicker
					id="yext-autocomplete-separator-color"
					label={__('Autocomplete Separator Color', 'yext')}
					colors={colors}
					value={autocompleteSeparatorColor}
					onChange={(colorValue) => {
						handleStyleUpdate('autocompleteSeparatorColor', colorValue);
					}}
				/>
				<ColorPicker
					id="yext-autocomplete-option-background-hover-color"
					label={__('Autocomplete Option Background Hover Color', 'yext')}
					colors={colors}
					value={autocompleteOptionHoverBackgroundColor}
					onChange={(colorValue) => {
						handleStyleUpdate('autocompleteOptionHoverBackgroundColor', colorValue);
					}}
				/>
			</PanelBody>
		</InspectorControls>
	);
};

export default Inspector;
