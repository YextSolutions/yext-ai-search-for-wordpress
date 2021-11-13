const { __ } = wp.i18n;
const { InspectorControls, PanelColorSettings } = wp.blockEditor;

const Inspector = (props) => {
	const {
		setAttributes,
		attributes: {
			buttonBackgroundColor,
			buttonTextColor,
			buttonHoverTextColor,
			buttonHoverBackgroundColor,
		},
	} = props;

	return (
		<InspectorControls>
			<PanelColorSettings
				title={__('Button Settings', 'yext')}
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
