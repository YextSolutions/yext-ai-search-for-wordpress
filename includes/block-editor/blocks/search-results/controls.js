// @ts-ignore
const { wp } = window;

const { __ } = wp.i18n;
const { BlockControls } = wp.blockEditor;
const { ToolbarButton } = wp.components;

const Controls = (props) => {
	const { setAttributes } = props;

	return (
		<>
			<BlockControls group="other">
				<ToolbarButton
					icon="edit"
					onClick={() => {
						setAttributes({ url: '' });
					}}
				>
					{__('Replace', 'yext')}
				</ToolbarButton>
			</BlockControls>
		</>
	);
};

export default Controls;
