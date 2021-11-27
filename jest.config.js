module.exports = {
	setupFiles: ['dotenv/config', './assets/js/frontend/__tests__/utils/setup'],
	testRegex: '(/__tests__/.*|(\\.|/)(test|spec))\\.(j|t)sx?$',
	moduleFileExtensions: ['js', 'jsx'],
	testPathIgnorePatterns: ['/node_modules/', '/mocks/', '/vendor/', '/utils/'],
	moduleNameMapper: {
		'\\.css$': require.resolve('./assets/js/frontend/__tests__/utils/style-mock'),
	},
	moduleDirectories: ['node_modules', './'],
	collectCoverageFrom: [
		'**/*.{js,jsx}',
		'!**/node_modules/**',
		'!**/vendor/**',
		'!**/utils/**',
		'!**/dist/**',
		'!**/build/**',
		'!**/jest.config.{js,ts}',
		'!**/babel.config.{js,ts}',
	],
	globals: {},
};
