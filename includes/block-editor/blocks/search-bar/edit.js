/**
 * WordPress dependencies
 */

const { useBlockProps } = wp.blockEditor;
const { __ } = wp.i18n;
const { useState } = wp.element;
const { Placeholder, Button } = wp.components;

const Edit = (props) => {
	const { attributes, setAttributes } = props;

	const { url } = attributes;
	const blockProps = useBlockProps();

	const [pageUrl] = useState(url);
	return (
		<>
			<div {...blockProps}>
				<Placeholder
					icon="none"
					label={__('Yext Search Results Block', 'yext')}
					className="wp-block-embed"
					instructions={__('Add search results url.', 'yext')}
				>
					<form>
						<Button
							isPrimary
							onClick={() => {
								setAttributes({ url: pageUrl });
							}}
						>
							{__('Submit', 'yext')}
						</Button>
					</form>
				</Placeholder>
			</div>
		</>
	);
};

export default Edit;
