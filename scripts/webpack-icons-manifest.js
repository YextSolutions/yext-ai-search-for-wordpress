/* eslint-disable no-console */

const fs = require('fs');
const path = require('path');

const { getDirContents, getFileContents, writeDir, writeFile } = require('./util');

module.exports = class WebpackIconsManifest {
	constructor({
		iconDir = path.resolve(process.cwd(), './dist/svg'),
		output = path.resolve(process.cwd(), './dist/icons.json'),
		include = [],
		exclude = [],
		debug = false,
	} = {}) {
		this.iconDir = iconDir;
		this.output = output;
		this.include = include;
		this.exclude = exclude;
		this.debug = debug;
	}

	generateIconManifest() {
		const manifest = {};
		const files = getDirContents(this.iconDir);

		files.forEach((file) => {
			if (!file.includes('svg')) {
				return;
			}

			const iconName = file.replace('.svg', '');
			if (this.exclude.includes(file) || this.exclude.includes(iconName)) {
				return;
			}

			if (
				this.include.length &&
				!this.include.includes(file) &&
				!this.include.includes(iconName)
			) {
				return;
			}

			const iconContents = getFileContents(`${this.iconDir}/${file}`);

			// Format the file contents so that we don't end up with new line, tab,
			// and extra space characters in our output JSON file. This will handle
			// files with tab or space indentation with any tab size,
			// and elements with multiline attributes.
			const formattedContents = iconContents
				// Replace all tabs and new lines with an empty space
				.replace(/[\t\n\r]/gm, ' ')
				// Remove all empty spaces that are outside of an element
				.replace(/\s+(?![^<>]*>)|[\t\n\r]/gm, '')
				// Replace all double spaces with single spaces
				.replace(/ {2}/gm, ' ')
				// Remove the remaining space at the end of an element
				.replace(/ >/gm, '>');

			manifest[iconName] = formattedContents;

			if (this.debug && (this.debug === true || this.debug === iconName)) {
				console.log(`${iconName}\n`);
				console.log(`${formattedContents}\n`);
			}
		});

		const outputDir = this.output.split('/').slice(0, -1).join('/');
		if (!fs.existsSync(outputDir)) {
			writeDir(outputDir);
		}

		writeFile(this.output, JSON.stringify(manifest));
	}

	apply(compiler) {
		// Run this plugin after Webpack is done compiling so that our manifest file isn't deleted.
		// @see (@link https://webpack.js.org/api/compiler-hooks/#done)
		compiler.hooks.done.tap('WebpackIconsManifest', () => this.generateIconManifest());
	}
};
