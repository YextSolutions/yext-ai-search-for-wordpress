// @ts-nocheck
/* eslint-disable import/no-extraneous-dependencies */

const DEFAULT_CONFIG = require('10up-toolkit/config/webpack.config');
const WebpackIconsManifest = require('./scripts/webpack-icons-manifest');

module.exports = {
	...DEFAULT_CONFIG,
	plugins: [
		...DEFAULT_CONFIG.plugins,

		new WebpackIconsManifest({
			iconDir: './dist/svg/icons',
			include: [],
			output: './dist/icons.json',
		}),
	],
};
