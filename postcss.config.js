const path = require('path');

module.exports = ({ file, env }) => {
	const config = {
		plugins: {
			'postcss-import': {},
			'postcss-mixins': {},
			'postcss-nested': {},
			'postcss-preset-env': {
				stage: 0,
				autoprefixer: {
					grid: true,
				},
			},
		},
	};

	// Only load postcss-editor-styles plugin when we're processing the editor-style.css file.
	if (path.basename(file) === 'admin-style.css') {
		config.plugins['postcss-editor-styles'] = {
			scopeTo: 'body[class*="yext_page"]',
			ignore: [':root'],
			tags: ['button', 'input', 'label', 'select', 'textarea', 'form'],
			tagSuffix: '',
		};
	}

	config.plugins.cssnano =
		env === 'production'
			? {
					preset: [
						'default',
						{
							autoprefixer: false,
							calc: {
								precision: 8,
							},
							convertValues: true,
							discardComments: {
								remove: (comment) =>
									!comment.includes('critical:') && !comment.includes('global:'),
							},
							mergeLonghand: false,
							zindex: false,
						},
					],
			  }
			: false;

	return config;
};
