# GitHub Actions Workflows

This directory contains automated CI/CD workflows for the Chat for n8n plugin.

## Workflows

### `wordpress-ci-cd.yml`

Main CI/CD pipeline that runs on pull requests and pushes to main.

#### Pull Request Workflow
**Triggered on:** Pull requests to `main` branch

**Steps:**
1. **PHP Setup** - PHP 8.2 with Composer
2. **PHP Linting** - WordPress Coding Standards (WPCS)
3. **PHP Syntax Check** - Validates PHP syntax
4. **Node.js Setup** - Node 20.x
5. **TypeScript Check** - Type validation
6. **SCSS Linting** - Stylelint validation
7. **JavaScript Linting** - ESLint validation
8. **Build Test** - Ensures production build works

#### Main Branch Workflow
**Triggered on:** Push to `main` branch

**Steps:**
1. **PHP Setup** - PHP 8.2 with Composer
2. **Install Dependencies** - Production-only (no dev dependencies)
3. **Node.js Setup** - Node 20.x
4. **Build** - Creates production bundle
5. **Create ZIP** - Packages plugin for distribution
6. **Release** - Creates GitHub release with ZIP attachment

#### Release Versioning
- Version is automatically extracted from `package.json`
- Release tag format: `v1.1.0`
- ZIP filename: `chat-for-n8n-v1.1.0.zip`
- Release is created in `releases/` directory

---

## Configuration

### Required Secrets
- `GITHUB_TOKEN` - Automatically provided by GitHub Actions

### Required Files
- `composer.json` - PHP dependencies and scripts
- `package.json` - Node dependencies and scripts
- `scripts/bundle.js` - ZIP creation script

---

## Local Testing

### Test PHP Linting
```bash
composer install
composer lint:wpcs
composer lint:php
```

### Test JavaScript/TypeScript Linting
```bash
npm install
npm run type-check
npm run lint:scss
npm run lint:js
```

### Test Build
```bash
npm run build
npm run bundle
```

This will create a ZIP file in `releases/` directory.

---

## Workflow Status

Check workflow status at:
`https://github.com/YOUR-USERNAME/chat-for-n8n/actions`

### Success Criteria

**Pull Request:**
- ✅ All PHP files pass syntax check
- ✅ TypeScript compiles without errors
- ✅ SCSS lints without critical errors
- ✅ JavaScript lints without critical errors
- ✅ Production build completes successfully

**Main Branch:**
- ✅ All of the above
- ✅ ZIP file is created
- ✅ GitHub release is published
- ✅ ZIP is attached to release

---

## Troubleshooting

### Workflow Fails on PHP Linting
- Check `composer lint:wpcs` locally
- Fix coding standard violations
- Commit and push fixes

### Workflow Fails on TypeScript
- Run `npm run type-check` locally
- Fix type errors
- Commit and push fixes

### Workflow Fails on Build
- Run `npm run build` locally
- Check for build errors
- Ensure all dependencies are in package.json

### ZIP Not Created
- Check `scripts/bundle.js` for errors
- Ensure `releases/` directory is created
- Verify file patterns in bundle script

---

## Maintenance

### Updating PHP Version
Edit `wordpress-ci-cd.yml`:
```yaml
php-version: 8.3  # Change version here
```

### Updating Node Version
Edit `wordpress-ci-cd.yml`:
```yaml
node-version: 21  # Change version here
```

### Updating Release Notes
Edit the release body in `wordpress-ci-cd.yml` under the "Create GitHub Release" step.

---

## Best Practices

1. **Always run linting locally** before pushing
2. **Test build locally** before merging to main
3. **Review workflow logs** if builds fail
4. **Keep dependencies updated** regularly
5. **Tag releases** with semantic versioning

---

**Last Updated:** November 10, 2025

