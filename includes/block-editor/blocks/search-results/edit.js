/**
 * External dependencies
 */
import camelcaseKeys from 'camelcase-keys';
import IframeResize from 'iframe-resizer/js/iframeResizer';

/**
 * Internal dependencies
 */
import Controls from './controls';

// @ts-ignore
const { wp, YEXT } = window;

const { config } = YEXT.settings;
const { answersIframeUrl } = camelcaseKeys(config);

const { useBlockProps } = wp.blockEditor;
const { __ } = wp.i18n;
const { isURL } = wp.url;
const { useState, useRef, useEffect } = wp.element;
const { Placeholder, Button } = wp.components;

const Edit = (props) => {
	const {
		setAttributes,
		attributes: { url = answersIframeUrl },
	} = props;

	const blockProps = useBlockProps();
	const iframeRef = useRef(null);
	const [pageUrl, setPageUrl] = useState(url);

	useEffect(() => {
		IframeResize({ log: false }, iframeRef.current);
	}, [url, pageUrl]);

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
						<form
							onSubmit={() => {
								setAttributes({ url: pageUrl });
								setPageUrl(pageUrl);
							}}
						>
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
							<Button type="submit" isPrimary>
								{__('Submit', 'yext')}
							</Button>
						</form>
					</Placeholder>
				)}

				{url && isURL(url) && (
					<iframe
						ref={iframeRef}
						title="Yext Search Results"
						src={url}
						frameBorder="0"
						style={{ width: '1px', minWidth: '100%' }}
					/>
				)}
			</div>
		</>
	);
};

export default Edit;
