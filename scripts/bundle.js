/**
 * Bundle Script
 * Creates a distributable ZIP file of the plugin
 * 
 * @package N8n_Chat_Widget
 */

import archiver from 'archiver';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const pluginDir = path.resolve(__dirname, '..');
const outputDir = path.join(pluginDir, 'releases');
const pluginName = 'chat-for-n8n';
const version = process.env.npm_package_version || '1.1.0';
const outputFile = path.join(outputDir, `${pluginName}-v${version}.zip`);

// Files and directories to include
const includePatterns = [
	'dist/**/*',
	'*.php',
	'*.css',
	'*.js',
	'*.txt',
	'*.md',
	'LICENSE',
	'index.php',
];

// Files and directories to exclude
const excludePatterns = [
	'node_modules',
	'src',
	'scripts',
	'releases',
	'.git',
	'.github',
	'.vscode',
	'.idea',
	'.qodo',
	'.qodcache',
	'*.log',
	'*.lock',
	'package.json',
	'package-lock.json',
	'tsconfig.json',
	'vite.config.js',
	'postcss.config.js',
	'.eslintrc.json',
	'.prettierrc.json',
	'.editorconfig',
	'.nvmrc',
	'.gitignore',
	'.quick-start.md',
	'DEVELOPMENT.md',
];

/**
 * Check if a file should be included
 */
function shouldInclude(filePath) {
	const relativePath = path.relative(pluginDir, filePath);
	
	// Check exclude patterns
	for (const pattern of excludePatterns) {
		if (relativePath.includes(pattern)) {
			return false;
		}
	}
	
	return true;
}

/**
 * Create the bundle
 */
async function createBundle() {
	console.log('🎁 Creating plugin bundle...\n');
	
	// Create releases directory if it doesn't exist
	if (!fs.existsSync(outputDir)) {
		fs.mkdirSync(outputDir, { recursive: true });
	}
	
	// Create output stream
	const output = fs.createWriteStream(outputFile);
	const archive = archiver('zip', {
		zlib: { level: 9 } // Maximum compression
	});
	
	// Listen for errors
	archive.on('error', (err) => {
		throw err;
	});
	
	// Listen for completion
	output.on('close', () => {
		const sizeMB = (archive.pointer() / 1024 / 1024).toFixed(2);
		console.log(`\n✅ Bundle created successfully!`);
		console.log(`📦 File: ${outputFile}`);
		console.log(`📊 Size: ${sizeMB} MB`);
		console.log(`📝 Files: ${archive.pointer()} bytes\n`);
	});
	
	// Pipe archive to file
	archive.pipe(output);
	
	// Add files
	console.log('📁 Adding files...\n');
	
	// Add main plugin files
	const mainFiles = [
		'chat-for-n8n.php',
		'chat-for-n8n.js',
		'chat-for-n8n.css',
		'index.php',
		'LICENSE',
		'readme.txt',
		'README.md',
		'CHANGELOG.md',
	];
	
	for (const file of mainFiles) {
		const filePath = path.join(pluginDir, file);
		if (fs.existsSync(filePath)) {
			archive.file(filePath, { name: `${pluginName}/${file}` });
			console.log(`  ✓ ${file}`);
		}
	}
	
	// Add dist directory
	const distDir = path.join(pluginDir, 'dist');
	if (fs.existsSync(distDir)) {
		archive.directory(distDir, `${pluginName}/dist`);
		console.log(`  ✓ dist/`);
	}
	
	// Finalize the archive
	await archive.finalize();
}

// Run the bundler
createBundle().catch((err) => {
	console.error('❌ Error creating bundle:', err);
	process.exit(1);
});

