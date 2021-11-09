/**
 * Internal dependencies
 */
import edit from './edit';
import save from './save';
import metadata from './block.json';

const { __ } = wp.i18n;

metadata.title = __('Yext Search Results', 'yext');
metadata.description = __('Display YEXT search results via iFrame.', 'yext');

// Main Block
const SearchResults = {
	...metadata,
	edit,
	save,
};

export { SearchResults };
