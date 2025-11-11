# CI/CD Quick Start 🚀

## Test Locally Before Pushing

```bash
# Full quality check
npm run lint && composer lint:php && npm run build

# Or run individually:
composer lint:wpcs          # PHP coding standards
composer lint:php           # PHP syntax check
npm run type-check          # TypeScript check
npm run lint:scss           # SCSS linting
npm run lint:js             # JavaScript linting
npm run build               # Production build
npm run bundle              # Create ZIP
```

---

## Development Workflow

### 1. Create Feature Branch
```bash
git checkout -b feature/my-new-feature
```

### 2. Make Changes & Test
```bash
# Make your changes...
npm run lint
composer lint:php
```

### 3. Commit & Push
```bash
git add .
git commit -m "Add new feature"
git push origin feature/my-new-feature
```

### 4. Create Pull Request
- Go to GitHub
- Create PR from your branch to `main`
- **CI/CD will automatically run** ✅
- Wait for green checks
- Request review

### 5. Merge to Main
- After approval, merge PR
- **CI/CD will automatically:**
  - Build production bundle
  - Create ZIP file
  - Create GitHub release
  - Attach ZIP to release

---

## Creating a Release

### Option 1: Automatic (Recommended)

1. **Bump version** in 3 files:
   - `package.json` → `"version": "1.2.0"`
   - `chat-for-n8n.php` → `Version: 1.2.0` and `CHAT_FOR_N8N_VERSION`
   - `readme.txt` → `Stable tag: 1.2.0`

2. **Update CHANGELOG.md**

3. **Commit and push to main:**
```bash
git add package.json chat-for-n8n.php readme.txt CHANGELOG.md
git commit -m "Release v1.2.0"
git push origin main
```

4. **Done!** Release created automatically at:
   `https://github.com/YOUR-USERNAME/chat-for-n8n/releases`

### Option 2: Manual Release

1. Build locally: `npm run archive`
2. Go to GitHub Releases
3. Create release manually
4. Upload ZIP from `releases/` directory

---

## Workflow Status

### View Status
`https://github.com/YOUR-USERNAME/chat-for-n8n/actions`

### Status Badges
Add to README.md:
```markdown
![CI/CD](https://github.com/YOUR-USERNAME/chat-for-n8n/workflows/WordPress%20CI/CD%20Workflow/badge.svg)
```

---

## Troubleshooting

### ❌ Build Failed?

1. **Check the logs:**
   - Go to Actions tab
   - Click on failed run
   - Read error messages

2. **Common fixes:**
   - Run `npm run build` locally
   - Fix any TypeScript errors
   - Commit and push fixes

### ❌ Linting Failed?

```bash
# Fix PHP issues
composer format

# Fix JS/TS issues
npm run format
```

### ❌ No Release Created?

- Check if you're on `main` branch
- Check if version was bumped
- Check workflow logs for errors

---

## Quick Commands

```bash
# Install everything
composer install && npm install

# Lint everything
composer lint:wpcs && npm run lint

# Build and bundle
npm run archive

# Clean and rebuild
npm run clean && npm install && npm run build
```

---

**Remember:** The workflow runs automatically - you just push code! ✨

