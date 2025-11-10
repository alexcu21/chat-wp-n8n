<?php
/**
 * Plugin Name: Chat for n8n
 * Description: Add the n8n-powered chat widget to your website, connecting automation and AI workflows.
 * Version: 1.0.0
 * Author: Alex Cuadra
 * Author URI: https://alexcuadra.dev
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: chat-for-n8n
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 *
 * @package Chat_for_n8n
 */

// phpcs:set WordPress.NamingConventions.PrefixAllGlobals prefixes[] chat_for_n8n

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants.
define( 'CHAT_FOR_N8N_VERSION', '1.0.0' );
define( 'CHAT_FOR_N8N_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CHAT_FOR_N8N_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Registers the settings page in the admin menu.
 */
function chat_for_n8n_add_admin_menu() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
	add_options_page(
		__( 'n8n Chat Settings', 'chat-for-n8n' ),
		__( 'Chat for n8n', 'chat-for-n8n' ),
		'manage_options',
		'chat-for-n8n',
		'n8n_chat_widget_options_page'
	);
}
add_action( 'admin_menu', 'chat_for_n8n_add_admin_menu' );

/**
 * Displays the plugin settings page.
 */
function n8n_chat_widget_options_page() {
	// Check permissions.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Display update messages if settings have been saved.
	if ( isset( $_GET['settings-updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		add_settings_error(
			'chat_for_n8n_widget_messages',
			'chat_for_n8n_widget_message',
			__( 'Settings saved successfully.', 'chat-for-n8n' ),
			'updated'
		);
	}

	settings_errors( 'chat_for_n8n_widget_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'chat_for_n8n_widget_group' );
			do_settings_sections( 'n8n_chat_widget' );
			submit_button( __( 'Save Changes', 'chat-for-n8n' ) );
			?>
		</form>
		<hr>
		<h2><?php esc_html_e( 'How to Use This Plugin', 'chat-for-n8n' ); ?></h2>
		<ol>
			<li><?php esc_html_e( 'Create a workflow in n8n with a "Chat Trigger" node.', 'chat-for-n8n' ); ?></li>
			<li><?php esc_html_e( 'Copy the webhook URL from the "Chat Trigger" node.', 'chat-for-n8n' ); ?></li>
			<li><?php esc_html_e( 'Paste the URL in the field above and save the changes.', 'chat-for-n8n' ); ?></li>
			<li><?php esc_html_e( 'The chat widget will appear automatically on your website.', 'chat-for-n8n' ); ?></li>
		</ol>
		<p>
			<?php
			printf(
				/* translators: %s: n8n documentation URL */
				esc_html__( 'For more information, check the %s.', 'chat-for-n8n' ),
				'<a href="https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'official n8n documentation', 'chat-for-n8n' ) . '</a>'
			);
			?>
		</p>
	</div>
	<?php
}

/**
 * Registers the plugin settings.
 */
function n8n_chat_widget_settings_init() {
	// Register settings.
	register_setting(
		'n8n_chat_widget_group',
		'n8n_chat_webhook_url',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '',
		)
	);

	register_setting(
		'n8n_chat_widget_group',
		'n8n_chat_widget_mode',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'window',
		)
	);

	register_setting(
		'n8n_chat_widget_group',
		'n8n_chat_widget_language',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'es',
		)
	);

	register_setting(
		'n8n_chat_widget_group',
		'n8n_chat_widget_welcome_screen',
		array(
			'type'              => 'boolean',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => true,
		)
	);

	register_setting(
		'n8n_chat_widget_group',
		'n8n_chat_widget_initial_messages',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'wp_kses_post',
			'default'           => '',
		)
	);

	register_setting(
		'n8n_chat_widget_group',
		'n8n_chat_widget_title',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Chat',
		)
	);

	register_setting(
		'n8n_chat_widget_group',
		'n8n_chat_widget_subtitle',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
		)
	);

	register_setting(
		'n8n_chat_widget_group',
		'n8n_chat_widget_input_placeholder',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
		)
	);

	register_setting(
		'n8n_chat_widget_group',
		'n8n_chat_widget_load_session',
		array(
			'type'              => 'boolean',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => false,
		)
	);

	// Main Section.
	add_settings_section(
		'n8n_chat_widget_main_section',
		__( 'Widget Main Configuration', 'chat-for-n8n' ),
		'n8n_chat_widget_main_section_callback',
		'n8n_chat_widget'
	);

	// Field: Webhook URL.
	add_settings_field(
		'n8n_chat_webhook_url_field',
		__( 'n8n Chat Webhook URL', 'chat-for-n8n' ),
		'n8n_chat_webhook_url_render',
		'n8n_chat_widget',
		'n8n_chat_widget_main_section'
	);

	// Appearance Section.
	add_settings_section(
		'n8n_chat_widget_appearance_section',
		__( 'Appearance Configuration', 'chat-for-n8n' ),
		'n8n_chat_widget_appearance_section_callback',
		'n8n_chat_widget'
	);

	// Field: Widget Mode.
	add_settings_field(
		'n8n_chat_widget_mode_field',
		__( 'Widget Mode', 'chat-for-n8n' ),
		'n8n_chat_widget_mode_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Language.
	add_settings_field(
		'n8n_chat_widget_language_field',
		__( 'Language', 'chat-for-n8n' ),
		'n8n_chat_widget_language_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Welcome Screen.
	add_settings_field(
		'n8n_chat_widget_welcome_screen_field',
		__( 'Show Welcome Screen', 'chat-for-n8n' ),
		'n8n_chat_widget_welcome_screen_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Initial Messages.
	add_settings_field(
		'n8n_chat_widget_initial_messages_field',
		__( 'Initial Messages', 'chat-for-n8n' ),
		'n8n_chat_widget_initial_messages_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Title.
	add_settings_field(
		'n8n_chat_widget_title_field',
		__( 'Chat Title', 'chat-for-n8n' ),
		'n8n_chat_widget_title_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Subtitle.
	add_settings_field(
		'n8n_chat_widget_subtitle_field',
		__( 'Chat Subtitle', 'chat-for-n8n' ),
		'n8n_chat_widget_subtitle_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Input Placeholder.
	add_settings_field(
		'n8n_chat_widget_input_placeholder_field',
		__( 'Input Placeholder', 'chat-for-n8n' ),
		'n8n_chat_widget_input_placeholder_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Load Previous Session.
	add_settings_field(
		'n8n_chat_widget_load_session_field',
		__( 'Load Previous Session', 'chat-for-n8n' ),
		'n8n_chat_widget_load_session_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);
}
add_action( 'admin_init', 'n8n_chat_widget_settings_init' );

/**
 * Callback for the main section.
 */
function n8n_chat_widget_main_section_callback() {
	echo '<p>' . esc_html__( 'Enter the public URL of your n8n Chat Trigger Webhook to activate the widget.', 'chat-for-n8n' ) . '</p>';
}

/**
 * Callback for the appearance section.
 */
function n8n_chat_widget_appearance_section_callback() {
	echo '<p>' . esc_html__( 'Customize the appearance and behavior of the chat widget.', 'chat-for-n8n' ) . '</p>';
}

/**
 * Renders the webhook URL field.
 */
function n8n_chat_webhook_url_render() {
	$url = get_option( 'n8n_chat_webhook_url' );
	?>
	<input type="url" 
		   name="n8n_chat_webhook_url" 
		   value="<?php echo esc_attr( $url ); ?>" 
		   placeholder="<?php esc_attr_e( 'https://yourdomain.com/webhook/...', 'chat-for-n8n' ); ?>" 
		   size="60" 
		   class="regular-text">
	<p class="description">
		<?php esc_html_e( 'Make sure this URL comes from your "Chat Trigger" node in n8n.', 'chat-for-n8n' ); ?>
	</p>
	<?php
}

/**
 * Renders the widget mode field.
 */
function n8n_chat_widget_mode_render() {
	$mode = get_option( 'n8n_chat_widget_mode', 'window' );
	?>
	<select name="n8n_chat_widget_mode">
		<option value="window" <?php selected( $mode, 'window' ); ?>>
			<?php esc_html_e( 'Floating Window', 'chat-for-n8n' ); ?>
		</option>
		<option value="fullscreen" <?php selected( $mode, 'fullscreen' ); ?>>
			<?php esc_html_e( 'Fullscreen', 'chat-for-n8n' ); ?>
		</option>
	</select>
	<p class="description">
		<?php esc_html_e( 'Floating Window: widget in the bottom right corner. Fullscreen: use the shortcode [n8n_chat] on a page.', 'chat-for-n8n' ); ?>
	</p>
	<?php
}

/**
 * Renders the language field.
 */
function n8n_chat_widget_language_render() {
	$language = get_option( 'n8n_chat_widget_language', 'en' );
	?>
	<select name="n8n_chat_widget_language">
		<option value="en" <?php selected( $language, 'en' ); ?>>English</option>
		<option value="es" <?php selected( $language, 'es' ); ?>>Español</option>
		<option value="de" <?php selected( $language, 'de' ); ?>>Deutsch</option>
		<option value="fr" <?php selected( $language, 'fr' ); ?>>Français</option>
		<option value="pt" <?php selected( $language, 'pt' ); ?>>Português</option>
	</select>
	<p class="description">
		<?php esc_html_e( 'Default language for the chat widget.', 'chat-for-n8n' ); ?>
	</p>
	<?php
}

/**
 * Renders the welcome screen field.
 */
function n8n_chat_widget_welcome_screen_render() {
	$show_welcome = get_option( 'n8n_chat_widget_welcome_screen', true );
	?>
	<label>
		<input type="checkbox" 
			   name="n8n_chat_widget_welcome_screen" 
			   value="1" 
			   <?php checked( $show_welcome, true ); ?>>
		<?php esc_html_e( 'Show welcome screen when opening the chat', 'chat-for-n8n' ); ?>
	</label>
	<?php
}

/**
 * Renders the initial messages field.
 */
function n8n_chat_widget_initial_messages_render() {
	$initial_messages = get_option( 'n8n_chat_widget_initial_messages', '' );
	?>
	<textarea name="n8n_chat_widget_initial_messages" 
			  rows="3" 
			  cols="60" 
			  class="large-text"
			  placeholder="<?php esc_attr_e( 'Hi! How can I help you today?', 'chat-for-n8n' ); ?>"><?php echo esc_textarea( $initial_messages ); ?></textarea>
	<p class="description">
		<?php esc_html_e( 'Welcome message that users will see (optional).', 'chat-for-n8n' ); ?>
	</p>
	<?php
}

/**
 * Renders the chat title field.
 */
function n8n_chat_widget_title_render() {
	$title = get_option( 'n8n_chat_widget_title', 'Chat' );
	?>
	<input type="text" 
		   name="n8n_chat_widget_title" 
		   value="<?php echo esc_attr( $title ); ?>" 
		   class="regular-text"
		   placeholder="<?php esc_attr_e( 'Chat', 'chat-for-n8n' ); ?>">
	<p class="description">
		<?php esc_html_e( 'Title that will appear in the chat header.', 'chat-for-n8n' ); ?>
	</p>
	<?php
}

/**
 * Renders the chat subtitle field.
 */
function n8n_chat_widget_subtitle_render() {
	$subtitle = get_option( 'n8n_chat_widget_subtitle', '' );
	?>
	<input type="text" 
		   name="n8n_chat_widget_subtitle" 
		   value="<?php echo esc_attr( $subtitle ); ?>" 
		   class="regular-text"
		   placeholder="<?php esc_attr_e( 'How can I help you?', 'chat-for-n8n' ); ?>">
	<p class="description">
		<?php esc_html_e( 'Subtitle that will appear below the title (optional).', 'chat-for-n8n' ); ?>
	</p>
	<?php
}

/**
 * Renders the input placeholder field.
 */
function n8n_chat_widget_input_placeholder_render() {
	$placeholder = get_option( 'n8n_chat_widget_input_placeholder', '' );
	?>
	<input type="text" 
		   name="n8n_chat_widget_input_placeholder" 
		   value="<?php echo esc_attr( $placeholder ); ?>" 
		   class="regular-text"
		   placeholder="<?php esc_attr_e( 'Type your message...', 'chat-for-n8n' ); ?>">
	<p class="description">
		<?php esc_html_e( 'Text that appears in the input field before typing (optional).', 'chat-for-n8n' ); ?>
	</p>
	<?php
}

/**
 * Renders the load previous session field.
 */
function n8n_chat_widget_load_session_render() {
	$load_session = get_option( 'n8n_chat_widget_load_session', false );
	?>
	<label>
		<input type="checkbox" 
			   name="n8n_chat_widget_load_session" 
			   value="1" 
			   <?php checked( $load_session, true ); ?>>
		<?php esc_html_e( 'Keep conversation history between sessions', 'chat-for-n8n' ); ?>
	</label>
	<p class="description">
		<?php
		printf(
			/* translators: %s: Link to documentation */
			esc_html__( 'Requires setting up memory in your n8n workflow. %s', 'chat-for-n8n' ),
			'<a href="https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Learn more', 'chat-for-n8n' ) . '</a>'
		);
		?>
	</p>
	<?php
}

/**
 * Enqueues the necessary scripts and styles on the frontend.
 */
function n8n_chat_widget_enqueue_assets() {
	// Only enqueue if webhook URL is configured.
	$webhook_url = get_option( 'n8n_chat_webhook_url' );
	if ( empty( $webhook_url ) ) {
		return;
	}

	// Determine whether to use development or production files.
	$use_dev = defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'N8N_CHAT_WIDGET_DEV' ) && N8N_CHAT_WIDGET_DEV;
	
	// File directories.
	$js_file  = $use_dev ? 'src/js/main.js' : 'dist/main.js';
	$css_file = $use_dev ? 'src/scss/main.scss' : 'dist/chat-for-n8n.css';
	
	// Check if compiled file exists, otherwise use legacy.
	if ( ! file_exists( CHAT_FOR_N8N_PLUGIN_DIR . $js_file ) ) {
		$js_file = 'chat-for-n8n.js';
	}
	if ( ! file_exists( CHAT_FOR_N8N_PLUGIN_DIR . $css_file ) ) {
		$css_file = 'chat-for-n8n.css';
	}

	// 1. Load widget styles (includes bundled @n8n/chat CSS).
	wp_enqueue_style(
		'chat-for-n8n-css',
		CHAT_FOR_N8N_PLUGIN_URL . $css_file,
		array(),
		CHAT_FOR_N8N_VERSION
	);

	// 2. Load widget script (includes bundled @n8n/chat library).
	wp_enqueue_script(
		'chat-for-n8n',
		CHAT_FOR_N8N_PLUGIN_URL . $js_file,
		array(),
		CHAT_FOR_N8N_VERSION,
		true
	);

	// 3. Pass configuration to script as global variable.
	$mode             = get_option( 'n8n_chat_widget_mode', 'window' );
	$language         = get_option( 'n8n_chat_widget_language', 'en' );
	$welcome_screen   = get_option( 'n8n_chat_widget_welcome_screen', true );
	$initial_messages = get_option( 'n8n_chat_widget_initial_messages', '' );
	$title            = get_option( 'n8n_chat_widget_title', 'Chat' );
	$subtitle         = get_option( 'n8n_chat_widget_subtitle', '' );
	$placeholder      = get_option( 'n8n_chat_widget_input_placeholder', '' );
	$load_session     = get_option( 'n8n_chat_widget_load_session', false );

	$config = array(
		'webhookUrl'          => esc_url_raw( $webhook_url ),
		'mode'                => sanitize_text_field( $mode ),
		'language'            => sanitize_text_field( $language ),
		'showWelcomeScreen'   => rest_sanitize_boolean( $welcome_screen ),
		'title'               => sanitize_text_field( $title ),
		'loadPreviousSession' => rest_sanitize_boolean( $load_session ),
	);

	// Add subtitle if configured.
	if ( ! empty( $subtitle ) ) {
		$config['subtitle'] = sanitize_text_field( $subtitle );
	}

	// Add placeholder if configured.
	if ( ! empty( $placeholder ) ) {
		$config['inputPlaceholder'] = sanitize_text_field( $placeholder );
	}

	// Add initial messages if configured.
	if ( ! empty( $initial_messages ) ) {
		$config['initialMessages'] = array( wp_kses_post( $initial_messages ) );
	}

	// Inject configuration as inline script in the head so it's available to the module.
	wp_add_inline_script(
		'chat-for-n8n',
		'window.n8nChatConfig = ' . wp_json_encode( $config ) . ';',
		'before'
	);
}
add_action( 'wp_enqueue_scripts', 'n8n_chat_widget_enqueue_assets' );

/**
 * Adds the type="module" attribute to the widget script.
 *
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @param string $src    The script URL.
 * @return string The modified tag.
 */
function n8n_chat_widget_add_type_module( $tag, $handle, $src ) {
	// Only add type="module" to widget script.
	if ( 'chat-for-n8n' === $handle ) {
		// Replace type='text/javascript' with type='module'.
		$tag = str_replace( " type='text/javascript'", " type='module'", $tag );
		// Also handle double quotes.
		$tag = str_replace( ' type="text/javascript"', ' type="module"', $tag );
		// If it doesn't have type, add it.
		if ( strpos( $tag, "type='module'" ) === false && strpos( $tag, 'type="module"' ) === false ) {
			$tag = str_replace( '<script ', '<script type="module" ', $tag );
		}
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'n8n_chat_widget_add_type_module', 10, 3 );

/**
 * Shortcode to insert chat widget on a page.
 *
 * @return string HTML of the chat container.
 */
function n8n_chat_widget_shortcode() {
	$webhook_url = get_option( 'n8n_chat_webhook_url' );
	if ( empty( $webhook_url ) ) {
		return '<p>' . esc_html__( 'The chat widget is not configured. Please configure the webhook URL in the settings.', 'chat-for-n8n' ) . '</p>';
	}
	return '<div id="n8n-chat-container"></div>';
}
add_shortcode( 'n8n_chat', 'n8n_chat_widget_shortcode' );

/**
 * Adds useful links to the plugins page.
 *
 * @param array $links Existing links.
 * @return array Modified links.
 */
function n8n_chat_widget_plugin_action_links( $links ) {
	$settings_link = '<a href="' . esc_url( admin_url( 'options-general.php?page=chat-for-n8n' ) ) . '">' . __( 'Settings', 'chat-for-n8n' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'n8n_chat_widget_plugin_action_links' );