/**
 * Vite Configuration for n8n Chat Widget Plugin
 * 
 * @package N8n_Chat_Widget
 */

import { defineConfig } from 'vite';
import { resolve } from 'path';
import legacy from '@vitejs/plugin-legacy';

export default defineConfig({
	// Build configuration
	build: {
		// Output directory
		outDir: 'dist',
		
		// Clear output directory before build
		emptyOutDir: true,
		
		// Generate source maps for debugging
		sourcemap: process.env.NODE_ENV === 'development',
		
		// Minify in production
		minify: process.env.NODE_ENV === 'production' ? 'terser' : false,
		
		// Terser options
		terserOptions: {
			compress: {
				drop_console: process.env.NODE_ENV === 'production',
				drop_debugger: true,
			},
		},
		
		// Rollup options
		rollupOptions: {
			input: {
				// TypeScript entry point (imports CSS)
				main: resolve(__dirname, 'src/js/main.ts'),
			},
			output: {
				// Output format
				format: 'es',
				
				// Output file names
				entryFileNames: '[name].js',
				chunkFileNames: '[name]-[hash].js',
				assetFileNames: (assetInfo) => {
					// CSS files
					if (assetInfo.name && assetInfo.name.endsWith('.css')) {
						return 'chat-for-n8n.css';
					}
					// Other assets
					return '[name].[ext]';
				},
			},
		},
		
		// Target browsers
		target: 'es2020',
		
		// CSS code splitting
		cssCodeSplit: false,
	},
	
	// CSS configuration
	css: {
		preprocessorOptions: {
			scss: {
				// Additional data to prepend to every scss file
				additionalData: `@use "sass:math";\n`,
				// Modern API
				api: 'modern-compiler',
			},
		},
		postcss: './postcss.config.js',
	},
	
	// Plugins
	plugins: [
		// Legacy browser support
		legacy({
			targets: ['defaults', 'not IE 11'],
			modernPolyfills: true,
		}),
		
		// Note: Compression disabled for WordPress.org compliance
		// WordPress.org does not allow .gz or .br files in plugins
		// Server-side compression should be handled by hosting/CDN
	],
	
	// Server configuration for development
	server: {
		host: 'localhost',
		port: 3000,
		open: false,
		cors: true,
		hmr: {
			overlay: true,
		},
	},
	
	// Preview server configuration
	preview: {
		port: 3001,
	},
	
	// Resolve configuration
	resolve: {
		alias: {
			'@': resolve(__dirname, 'src'),
			'@js': resolve(__dirname, 'src/js'),
			'@scss': resolve(__dirname, 'src/scss'),
		},
	},
});

