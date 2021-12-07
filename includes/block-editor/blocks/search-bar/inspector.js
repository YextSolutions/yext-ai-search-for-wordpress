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
			activeBackgroundColor: defaultButtonActiveBackgroundColor,
			color: defaultButtonTextColor,
			hoverColor: defaultButtonHoverTextColor,
			textActiveColor: defaultButtonActiveTextColor,
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
		setAttributes,
		attributes: {
			submitText = defaultSubmitText ?? null,
			placeholderText = defaultPlaceholderText ?? null,
			labelText = defaultLabelText ?? null,
			textColor = defaultTextColor ?? null,
			fontSize = defaultFontSize ? parseInt(defaultFontSize, 10) : FALLBACK_FONT_SIZE,
			fontWeight = defaultFontWeight ? parseInt(defaultFontWeight, 10) : null,
			lineHeight = defaultLineHeight ? parseInt(defaultLineHeight, 10) : null,
			borderRadius = defaultBorderRadius ?? null,
			borderColor = defaultBorderColor ?? null,
			backgroundColor = defaultBackgroundColor ?? null,
			buttonBackgroundColor = defaultButtonBackgroundColor ?? null,
			buttonHoverBackgroundColor = defaultButtonHoverBackgroundColor ?? null,
			buttonActiveBackgroundColor = defaultButtonActiveBackgroundColor ?? null,
			buttonTextColor = defaultButtonTextColor ?? null,
			buttonHoverTextColor = defaultButtonHoverTextColor ?? null,
			buttonActiveTextColor = defaultButtonActiveTextColor ?? null,
			autocompleteBackgroundColor = defaultAutocompleteBackgroundColor ?? null,
			autocompleteSeparatorColor = defaultAutocompleteSeparatorColor ?? null,
			autocompleteOptionHoverBackgroundColor = defaultAutocompleteOptionHoverBackgroundColor ??
				null,
			autocompleteOptionFontSize = defaultAutocompleteOptionFontSize ?? null,
			autocompleteOptionFontWeight = defaultAutocompleteOptionFontWeight ?? null,
			autocompleteOptionLineHeight = defaultAutocompleteOptionLineHeight ?? null,
			autocompleteHeaderFontWeight = defaultAutocompleteHeaderFontWeight ?? null,
		},
	} = props;
	const colors = useSetting('color.palette');

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
							setAttributes({ fontSize: newFontSize });
						}}
					/>
				</PanelRow>
				<SelectControl
					label={__('Font Weight', 'yext')}
					value={fontWeight}
					options={fontWeights}
					onChange={(newFontWeight) => {
						setAttributes({ fontWeight: newFontWeight });
					}}
				/>
				<LineHeightControl
					value={lineHeight}
					onChange={(newLineHeight) => {
						setAttributes({ lineHeight: newLineHeight });
					}}
				/>
				<RangeControl
					label={__('Border Radius', 'yext')}
					value={borderRadius}
					min={0}
					max={100}
					onChange={(newBorderRadius) => {
						setAttributes({ borderRadius: newBorderRadius });
					}}
				/>
				<BaseControl id="yext-text-color" label={__('Text Color', 'yext')}>
					<ColorPalette
						value={textColor}
						colors={colors}
						onChange={(color) => setAttributes({ textColor: color })}
					/>
				</BaseControl>
				<BaseControl id="yext-border-color" label={__('Border Color', 'yext')}>
					<ColorPalette
						colors={colors}
						value={borderColor}
						onChange={(color) => setAttributes({ borderColor: color })}
					/>
				</BaseControl>
				<BaseControl id="yext-background-color" label={__('Background Color', 'yext')}>
					<ColorPalette
						colors={colors}
						value={backgroundColor}
						onChange={(color) => setAttributes({ backgroundColor: color })}
					/>
				</BaseControl>
			</PanelBody>
			<PanelBody title={__('Button Styles', 'yext')} initialOpen={false}>
				<BaseControl id="yext-button-color" label={__('Button Text Color', 'yext')}>
					<ColorPalette
						colors={colors}
						value={buttonTextColor}
						onChange={(colorValue) => {
							setAttributes({ buttonTextColor: colorValue });
						}}
					/>
				</BaseControl>
				<BaseControl
					id="yext-button-hover-color"
					label={__('Button Text Hover Color', 'yext')}
				>
					<ColorPalette
						colors={colors}
						value={buttonHoverTextColor}
						onChange={(colorValue) => {
							setAttributes({ buttonHoverTextColor: colorValue });
						}}
					/>
				</BaseControl>
				<BaseControl
					id="yext-button-active-color"
					label={__('Button Text Active Color', 'yext')}
				>
					<ColorPalette
						colors={colors}
						value={buttonActiveTextColor}
						onChange={(colorValue) => {
							setAttributes({ buttonActiveTextColor: colorValue });
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
							setAttributes({ buttonBackgroundColor: colorValue });
						}}
					/>
				</BaseControl>
				<BaseControl
					id="yext-button-background-hover-color"
					label={__('Button Background Hover Color', 'yext')}
				>
					<ColorPalette
						colors={colors}
						value={buttonHoverBackgroundColor}
						onChange={(colorValue) => {
							setAttributes({ buttonHoverBackgroundColor: colorValue });
						}}
					/>
				</BaseControl>
				<BaseControl
					id="yext-button-background-active-color"
					label={__('Button Background Active Color', 'yext')}
				>
					<ColorPalette
						colors={colors}
						value={buttonActiveBackgroundColor}
						onChange={(colorValue) => {
							setAttributes({ buttonActiveBackgroundColor: colorValue });
						}}
					/>
				</BaseControl>
			</PanelBody>
			<PanelBody title={__('Autocomplete Styles', 'yext')} initialOpen={false}>
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
