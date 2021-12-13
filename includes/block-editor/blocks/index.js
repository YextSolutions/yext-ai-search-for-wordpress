/**
 * Register Custom Blocks
 */

// Registration Script
import { registerBlocks } from '../utils';

// Import Blocks
import { SearchBar } from './search-bar';
import { SearchResults } from './search-results';

// Register Blocks
registerBlocks('yext/search-bar', SearchBar);
registerBlocks('yext/search-results', SearchResults);
