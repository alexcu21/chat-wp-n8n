# Chat for n8n - WordPress Plugin

WordPress plugin that integrates the n8n chat widget into your website, allowing you to connect automation and AI workflows directly with your visitors.

## 🚀 Installation

### From WordPress

1. Download the plugin or clone it from GitHub
2. Upload the `chat-for-n8n` folder to `/wp-content/plugins/`
3. Activate the plugin from the "Plugins" menu in WordPress
4. Go to **Chat for n8n → Settings** to configure it

### Quick Setup

1. **Create a workflow in n8n:**
   - Add a "Chat Trigger" node to your workflow
   - Activate the workflow
   - Copy the webhook URL (should end with `/chat`)

2. **Configure the plugin:**
   - Go to **Chat for n8n → Settings**
   - Paste the webhook URL
   - Configure appearance options
   - Save changes

3. **Done!** The widget will appear automatically on your site

## ⚙️ Configuration Options

### Main Settings

- **Webhook URL**: The URL from your n8n "Chat Trigger" node
  - Format: `https://your-n8n.app/webhook/your-id/chat`

### Appearance Settings

- **Widget Mode:**
  - **Floating Window**: Widget in the bottom right corner (default)
  - **Fullscreen**: Use the `[n8n_chat]` shortcode on a page

- **Language:** English, Spanish, German, French, Portuguese

- **Welcome Screen:** Show/hide welcome message

- **Initial Messages:** Customize the welcome message

- **Title & Subtitle:** Customize the chat header

- **Input Placeholder:** Custom placeholder text

### Color Customization

Customize 14 different colors with live preview:
- Background, Primary, and Text colors
- Bot and User message colors
- Header colors
- Input field colors

### Display Rules

Control where the widget appears:
- Display on all pages, selected pages only, or all except selected
- Page type targeting (Homepage, Posts, Pages, Archives, etc.)
- Specific page/post selection
- Category and tag targeting
- URL-based rules (contains, starts with, ends with, regex)

## 📝 Using the Shortcode

To insert the chat on a specific page:

```
[n8n_chat]
```

**Note:** Change the mode to "Fullscreen" in settings to use the shortcode.

## 🛠️ Technical Requirements

- **WordPress:** 5.8 or higher
- **PHP:** 7.4 or higher
- **n8n:** Instance with "Chat Trigger" node configured

## 🔧 Troubleshooting

### Widget doesn't appear

1. **Verify the webhook URL:**
   - Make sure it's correctly configured in **Chat for n8n → Settings**
   - Must be publicly accessible
   - Should end with `/chat`

2. **Check display rules:**
   - Go to **Chat for n8n → Display Rules**
   - Verify the widget is set to display on the current page

3. **Clear cache:**
   - Clear WordPress cache (if using a cache plugin)
   - Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)

4. **Check browser console:**
   - Press F12 to open developer tools
   - Go to "Console" tab
   - Look for errors related to "n8n Chat Widget"

5. **Verify scripts are loading:**
   - In developer tools, go to "Network" tab
   - Reload the page
   - Look for `main.js` and `chat-for-n8n.css`
   - Both should load with status 200

### Common Errors

**Error: "Webhook URL not configured"**
- Configure the URL in **Chat for n8n → Settings**

**Error: "createChat is not available"**
- Verify the @n8n/chat library is bundled (check dist/ folder)
- Check for conflicts with other plugins

**Widget doesn't connect to n8n**
- Verify your n8n workflow is active
- Make sure the webhook URL is correct
- Check n8n logs to see if requests are arriving

### Colors not applying

1. Clear browser cache
2. Check **Chat for n8n → Appearance** for saved colors
3. Inspect element to verify CSS variables are injected
4. Check for theme CSS conflicts

## 🎨 Customization

### Custom CSS

You can add custom CSS in your theme to modify the appearance:

```css
/* Change widget position */
.chat-window-wrapper {
    bottom: 30px !important;
    right: 30px !important;
}

/* Customize specific elements */
.n8n-chat .chat-header {
    font-size: 18px !important;
}
```

### Developer Hooks

#### Filters

```php
// Modify default colors
add_filter( 'chat_for_n8n_default_colors', function( $colors ) {
    $colors['primary'] = '#ff0000';
    return $colors;
});

// Modify display logic
add_filter( 'chat_for_n8n_should_display', function( $should_display, $rules ) {
    // Custom logic here
    return $should_display;
}, 10, 2);

// Modify custom CSS
add_filter( 'chat_for_n8n_custom_css', function( $css, $colors ) {
    $css .= ".custom-class { color: {$colors['primary']}; }";
    return $css;
}, 10, 2);
```

### Advanced Configuration

The plugin follows WordPress best practices and is compatible with:
- ✅ Multisite
- ✅ Custom themes
- ✅ Page builders (Elementor, Divi, etc.)
- ✅ Cache plugins
- ✅ WPML and Polylang

## 📚 File Structure

```
chat-for-n8n/
├── assets/
│   └── admin/              # Admin page assets
│       ├── css/
│       │   └── appearance.css
│       └── js/
│           ├── color-picker.js
│           └── display-rules.js
├── dist/                   # Built production files
│   ├── main.js
│   └── chat-for-n8n.css
├── includes/
│   └── admin/              # Admin page templates
│       ├── dashboard-page.php
│       ├── settings-page.php
│       ├── appearance-page.php
│       └── display-rules-page.php
├── languages/              # Translation files
├── src/                    # Source files (TypeScript/SCSS)
│   ├── js/
│   │   └── main.ts
│   ├── scss/
│   └── types/
├── chat-for-n8n.php        # Main plugin file
├── readme.txt              # WordPress.org documentation
├── README.md               # This file
├── CHANGELOG.md            # Version history
├── LICENSE                 # GPL v2 license
└── index.php               # Security against direct access
```

## 🔐 Security

- ✅ All inputs are sanitized and validated
- ✅ All outputs use escaping functions
- ✅ Permission checks on admin pages
- ✅ Prevention of direct file access
- ✅ Compatible with WPCS and PHPCS
- ✅ No external dependencies (bundled library)

## 🎯 Features

### Version 1.1.0 (Current)

- 🎨 **Top-Level Admin Menu** - Better organization with custom icon
- 🌈 **Color Customization** - 14 customizable colors with live preview
- 🎯 **Display Rules** - Control where the widget appears
- 📊 **Dashboard** - Overview with widget status and quick actions
- 🔧 **Improved Interface** - Professional admin experience

### Version 1.0.0

- ✅ Complete integration with @n8n/chat library
- ✅ ES6 module support
- ✅ Admin configuration page
- ✅ Floating and fullscreen modes
- ✅ Multi-language support
- ✅ Fully responsive

## 📄 License

This plugin is licensed under GPL v2 or later.

## 🤝 Contributing

Contributions are welcome! If you find a bug or have a suggestion:

1. Open an issue on GitHub
2. Submit a pull request
3. Report issues in the WordPress forum

### Development Setup

```bash
# Install dependencies
npm install
composer install

# Development mode
npm run dev

# Build for production
npm run build

# Create distributable ZIP
npm run bundle

# Run linters
npm run lint
composer lint:wpcs
```

## 📞 Support

- **n8n Documentation:** https://docs.n8n.io/
- **Chat Trigger Docs:** https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/
- **Plugin Author:** https://alexcuadra.dev

## 🙏 Credits

Developed by Alex Cuadra
- Website: https://alexcuadra.dev
- Based on the @n8n/chat library

## 📋 Changelog

### 1.1.0 - 2025-11-11
- ✨ Added top-level admin menu with custom chat icon
- ✨ Added color customization system with 14 colors
- ✨ Added live preview for color changes
- ✨ Added display rules for page targeting
- ✨ Added dashboard page with widget status
- 🔧 Reorganized admin interface for better UX
- 🔧 Bundled @n8n/chat library (WordPress.org compliant)
- 🔧 Improved security and sanitization
- 🔧 All strings now in English (translatable)

### 1.0.0 - 2025-11-04
- 🎉 Initial release
- ✅ Complete @n8n/chat integration
- ✅ ES6 module support
- ✅ Admin configuration page
- ✅ Floating and fullscreen modes
- ✅ Multi-language support
- ✅ Fully responsive

---

**Love the plugin? Leave us a review! ⭐⭐⭐⭐⭐**
