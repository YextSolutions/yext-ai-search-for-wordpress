/**
 * Internal dependencies
 */

const { __ } = wp.i18n;
const { useBlockProps } = wp.blockEditor;

const Edit = (props) => {
	const {
		attributes: {
			url,
		},
		setAttributes,
	} = props;

	const blockProps = useBlockProps({ className: 'yext-search-results' });

	return (
		<>
			<div {...blockProps}>
				Test
			</div>
		</>
	);
};

export default Edit;
