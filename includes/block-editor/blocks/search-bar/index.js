/**
 * Internal dependencies
 */
import edit from './edit';
import save from './save';
import metadata from './block.json';

const { __ } = wp.i18n;

metadata.title = __('Yext Search Bar', 'yext');
metadata.description = __('Display YEXT search bar.', 'yext');

// Main Block
const SearchBar = {
	...metadata,
	edit,
	save,
};

export { SearchBar };
