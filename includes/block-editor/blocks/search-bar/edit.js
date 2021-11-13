import Inspector from './inspector';

/**
 * WordPress dependencies
 */

const { __ } = wp.i18n;
const { useBlockProps, RichText } = wp.blockEditor;

const Edit = (props) => {
	const { attributes, setAttributes } = props;

	const { buttonText, placeholder } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<Inspector {...props} />
			<div {...blockProps}>
				<RichText
					className="components-text-control__input"
					value={placeholder}
					placeholder={__('Add placeholder text..', 'yext')}
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
