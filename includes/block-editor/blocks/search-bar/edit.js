import Inspector from './inspector';

const { create } = YEXT_SETTINGS; // eslint-disable-line no-undef

/**
 * WordPress dependencies
 */

const { useBlockProps, RichText } = wp.blockEditor;

const Edit = (props) => {
	const { attributes, setAttributes } = props;

	let { buttonText, placeholder } = attributes;
	const blockProps = useBlockProps();

	if (!buttonText) {
		buttonText = create?.submit_text;
	}
	if (!placeholder) {
		placeholder = create?.placeholder;
	}

	return (
		<>
			<Inspector {...props} />
			<div {...blockProps}>
				<RichText
					className="components-text-control__input"
					value={placeholder}
					placeholder={placeholder}
					onChange={(newPlaceholder) => {
						setAttributes({ placeholder: newPlaceholder });
					}}
				/>
				<RichText
					tagName="button"
					className="wp-button"
					value={buttonText}
					onChange={(content) => {
						setAttributes({ buttonText: content });
					}}
				/>
			</div>
		</>
	);
};

export default Edit;
