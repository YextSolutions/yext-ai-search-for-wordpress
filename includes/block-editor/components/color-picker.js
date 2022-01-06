// @ts-ignore
const { wp } = window;
const { BaseControl, ColorPalette } = wp.components;

const ColorPicker = ({ id, label, colors, value, onChange }) => {
	return (
		<BaseControl id={id} label={label}>
			<span
				style={{
					backgroundColor: value,
					borderRadius: '30px',
					border: '1px solid',
					height: '20px',
					marginLeft: '12px',
					position: 'absolute',
					width: '20px',
				}}
			/>
			<ColorPalette clearable={false} colors={colors} value={value} onChange={onChange} />
		</BaseControl>
	);
};

export default ColorPicker;
