const { wp } = window;

const { __ } = wp.i18n;
const { BlockControls } = wp.blockEditor;
const { Button } = wp.components;

const Controls = (props) => {
	const { setAttributes } = props;

	return (
		<>
			<BlockControls group="other">
				<Button
					icon="edit"
					onClick={() => {
						setAttributes({ url: '' });
					}}
				>
					{__('Replace', 'yext')}
				</Button>
			</BlockControls>
		</>
	);
};

export default Controls;
