import Controls from './controls';

const { answers_iframe_url } = YEXT_SETTINGS; // eslint-disable-line no-undef

/**
 * Internal dependencies
 */
const { useBlockProps } = wp.blockEditor;
const { __ } = wp.i18n;
const { useState } = wp.element;
const { Placeholder, Button } = wp.components;

const Edit = (props) => {
	const { attributes, setAttributes } = props;

	const { url } = attributes;
	const blockProps = useBlockProps();

	const [pageUrl, setPageUrl] = useState(url ?? answers_iframe_url);
	return (
		<>
			<Controls {...props} />
			<div {...blockProps}>
				{!url && (
					<Placeholder
						icon="none"
						label={__('Yext Search Results Block', 'yext')}
						className="wp-block-embed"
						instructions={__('Add search results url.', 'yext')}
					>
						<form>
							<input
								type="url"
								value={pageUrl || ''}
								className="components-placeholder__input"
								onChange={(event) => {
									if (event) {
										event.preventDefault();
									}
									setPageUrl(event.target.value);
								}}
							/>
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
				)}

				{url && (
					<iframe
						title="Yext Search Results"
						src={url}
						height="500px"
						width="100%"
						frameBorder="0"
						scrolling="no"
					/>
				)}
			</div>
		</>
	);
};

export default Edit;
