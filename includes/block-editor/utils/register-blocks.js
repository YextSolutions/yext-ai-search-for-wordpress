/**
 * registerBlockType wrapper
 * Optionally register child-blocks with the parent
 */

// @ts-ignore
const { wp } = window;
const { registerBlockType } = wp.blocks;

function registerBlocks(id, parent, children = false) {
	registerBlockType(id, parent);

	if (children) {
		Object.keys(children).forEach((key) => {
			registerBlockType(`${id}-${key}`, children[key]);
		});
	}
}

export { registerBlocks };
