=== Chat for n8n ===
Contributors: alexcu21
Tags: chat, n8n, automation, ai, chatbot
Requires at least: 5.8
Tested up to: 6.9
Stable tag: 1.1.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add the n8n-powered chat widget to your website, connecting automation and AI workflows.

== Description ==

Chat for n8n allows you to easily integrate the n8n chat widget into your WordPress site, connecting your automation and AI workflows directly with your visitors.

= Key Features =

* **Easy Integration**: Connect your WordPress site with n8n in minutes
* **Floating Window Mode**: Floating widget in the corner of your site
* **Fullscreen Mode**: Insert chat on any page using shortcodes
* **Multi-language**: Support for Spanish, English, German, French, and Portuguese
* **Color Customization**: Customize 14 different colors with live preview
* **Display Rules**: Control where the widget appears on your site
* **Customizable**: Configure welcome messages and appearance
* **Fully Responsive**: Works perfectly on all devices
* **Accessible**: Meets web accessibility standards
* **Top-Level Menu**: Organized admin interface with dashboard

= What is n8n? =

n8n is an extensible, open-source workflow automation platform. It allows you to connect anything to everything, including APIs, databases, AI services, and more.

= How It Works =

1. Create a workflow in n8n with a "Chat Trigger" node
2. Copy the webhook URL from the "Chat Trigger" node
3. Paste the URL in the plugin settings
4. The chat widget will appear automatically on your site!

= Use Cases =

* Virtual customer service assistants
* Sales and marketing chatbots
* Automated technical support systems
* Qualified lead generation
* Automated queries and bookings
* CRM system integration
* AI assistants (ChatGPT, Claude, etc.)

= Shortcode =

Use the `[n8n_chat]` shortcode to insert the chat on any page or post when using "Fullscreen" mode.

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Go to "Plugins" > "Add New"
3. Search for "Chat for n8n"
4. Click "Install Now" and then "Activate"

= Manual Installation =

1. Download the plugin
2. Upload the `chat-for-n8n` folder to the `/wp-content/plugins/` directory
3. Activate the plugin from the "Plugins" menu in WordPress

= Configuration =

1. Go to "Chat for n8n" in the WordPress admin menu
2. Click "Settings"
3. Enter the webhook URL from your n8n "Chat Trigger" node
4. Configure appearance options according to your preferences
5. Save changes

For more information on how to create a chat workflow in n8n, check the [official n8n documentation](https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/).

== Frequently Asked Questions ==

= Do I need an n8n account? =

Yes, you need to have n8n installed (either self-hosted or using n8n.cloud) and create a workflow with a "Chat Trigger" node.

= Is it free? =

The plugin is 100% free. n8n offers both free self-hosted versions and paid plans on n8n.cloud.

= Can I customize the chat design? =

Yes! Version 1.1.0 includes a complete color customization system with 14 customizable colors, live preview, and display rules to control where the widget appears.

= Does it work on mobile devices? =

Yes, the widget is fully responsive and works perfectly on smartphones and tablets.

= Can I use multiple widgets on different pages? =

Currently, the plugin supports one widget per site. You can control where it appears using the Display Rules feature.

= Where can I get support? =

You can get support in the WordPress.org forums or visit the [n8n documentation](https://docs.n8n.io/).

= Is it GDPR compliant? =

The plugin itself does not collect data. GDPR compliance will depend on how you configure your workflow in n8n. Make sure to review n8n's privacy policies and configure your workflow appropriately.

= Can I integrate AI like ChatGPT? =

Yes! n8n supports integration with multiple AI services including OpenAI (ChatGPT), Anthropic (Claude), and many more through its nodes.

== Screenshots ==

1. Dashboard page with widget status and quick actions
2. Settings page with webhook configuration
3. Color customization page with live preview
4. Display rules for page targeting
5. Floating chat widget on the website
6. Fullscreen chat using shortcode

== Changelog ==

= 1.1.0 =
* Added top-level admin menu with custom chat icon
* Added color customization system with 14 colors
* Added live preview for color changes
* Added display rules for page targeting
* Added dashboard page with widget status
* Reorganized admin interface for better UX
* Bundled @n8n/chat library (WordPress.org compliant)
* Improved security and sanitization
* All strings now in English (translatable to other languages)
* Fixed text domain consistency
* Fixed external resource loading issues

= 1.0.0 =
* Initial release
* Support for floating and fullscreen modes
* n8n webhook configuration
* Multi-language support (ES, EN, DE, FR, PT)
* Customizable welcome messages
* Complete integration with @n8n/chat library
* WPCS and PHPCS compliance
* Fully responsive and accessible

== Upgrade Notice ==

= 1.1.0 =
Major update with color customization, display rules, and improved admin interface. Fully backward compatible.

= 1.0.0 =
Initial plugin release. Install and start automating your conversations!

== Additional Information ==

= Technical Requirements =

* WordPress 5.8 or higher
* PHP 7.4 or higher
* An n8n workflow with "Chat Trigger" node configured

= Useful Resources =

* [n8n Website](https://n8n.io/)
* [n8n Documentation](https://docs.n8n.io/)
* [Chat Trigger Documentation](https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/)
* [GitHub Repository](https://github.com/alexcuadra/chat-for-n8n)

= Contributing =

This plugin is open source. If you want to contribute, report bugs, or request features, visit our GitHub repository.

= Privacy =

This plugin does not collect or store any personal data from your site's users. All conversations are processed through your n8n instance according to your workflow configuration.

= License =

This plugin is free software distributed under the GPL v2 or later license.
