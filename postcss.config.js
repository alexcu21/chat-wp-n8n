/**
 * PostCSS Configuration
 * 
 * @package N8n_Chat_Widget
 */

export default {
	plugins: {
		// Autoprefixer for vendor prefixes
		'autoprefixer': {
			overrideBrowserslist: [
				'> 1%',
				'last 2 versions',
				'not dead',
				'not ie 11',
			],
			grid: 'autoplace',
		},
		
		// PostCSS Preset Env for modern CSS features
		'postcss-preset-env': {
			stage: 3,
			features: {
				'nesting-rules': true,
				'custom-properties': true,
				'custom-media-queries': true,
			},
		},
		
		// CSS Nano for minification (only in production)
		...(process.env.NODE_ENV === 'production' ? {
			'cssnano': {
				preset: ['default', {
					discardComments: {
						removeAll: true,
					},
					normalizeWhitespace: true,
					colormin: true,
					minifyFontValues: true,
					minifySelectors: true,
				}],
			},
		} : {}),
	},
};

