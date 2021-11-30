/**
 * Register Custom Blocks
 */

// Registration Script
import { registerBlocks } from '../utils';

// Import Blocks
import { SearchResults } from './search-results';

// Register Blocks
registerBlocks('yext/search-results', SearchResults);
