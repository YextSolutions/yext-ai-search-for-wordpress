const { button, font_size, line_height, border_radius } = YEXT_SETTINGS;

const { __ } = wp.i18n;
const { InspectorControls, PanelColorSettings, LineHeightControl } = wp.blockEditor;
const { PanelBody, PanelRow, FontSizePicker, RangeControl } = wp.components;

const Inspector = (props) => {
	const { setAttributes } = props;
	let {
		attributes: {
			fontSize,
			lineHeight,
			borderRadius,
			buttonBackgroundColor,
			buttonTextColor,
			buttonBorderColor,
			buttonHoverTextColor,
			buttonHoverBackgroundColor,
		},
	} = props;

	const fontSizes = [
		{
			name: __('Small', 'yext'),
			slug: 'small',
			size: 12,
		},
		{
			name: __('Big', 'yext'),
			slug: 'big',
			size: 26,
		},
	];

	const fallbackFontSize = 16;

	// Set values from Plugin Settings
	if (!fontSize && font_size) {
		fontSize = parseInt(font_size, 10);
	}
	if (!lineHeight && line_height) {
		lineHeight = parseInt(line_height, 10);
	}
	if (!borderRadius && border_radius) {
		borderRadius = parseInt(border_radius, 10);
	}
	if (!buttonBackgroundColor) {
		buttonBackgroundColor = button?.bg_color;
	}
	if (!buttonTextColor) {
		buttonTextColor = button?.text_color;
	}
	if (!buttonBorderColor) {
		buttonBorderColor = button?.border_color;
	}
	if (!buttonHoverTextColor) {
		buttonHoverTextColor = button?.hover_text_color;
	}
	if (!buttonHoverBackgroundColor) {
		buttonHoverBackgroundColor = button?.hover_bg_color;
	}

	return (
		<InspectorControls>
			<PanelBody title={__('Display Settings', 'yext')}>
				<PanelRow>
					<FontSizePicker
						fontSizes={fontSizes}
						fallbackFontSize={fallbackFontSize}
						value={fontSize}
						onChange={(newFontSize) => {
							setAttributes({ fontSize: newFontSize });
						}}
					/>
				</PanelRow>
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
			</PanelBody>
			<PanelColorSettings
				title={__('Button Color Settings', 'yext')}
				colorSettings={[
					{
						value: buttonTextColor,
						onChange: (colorValue) => {
							setAttributes({ buttonTextColor: colorValue });
						},
						label: __('Text Color', 'yext'),
					},
					{
						value: buttonBackgroundColor,
						onChange: (colorValue) => {
							setAttributes({ buttonBackgroundColor: colorValue });
						},
						label: __('Background Color', 'yext'),
					},
					{
						value: buttonBorderColor,
						onChange: (colorValue) => {
							setAttributes({ buttonBorderColor: colorValue });
						},
						label: __('Border Color', 'yext'),
					},
					{
						value: buttonHoverTextColor,
						onChange: (colorValue) => {
							setAttributes({ buttonHoverTextColor: colorValue });
						},
						label: __('Hover Text Color', 'yext'),
					},
					{
						value: buttonHoverBackgroundColor,
						onChange: (colorValue) => {
							setAttributes({ buttonHoverBackgroundColor: colorValue });
						},
						label: __('Hover Background Color', 'yext'),
					},
				]}
			/>
		</InspectorControls>
	);
};

export default Inspector;
