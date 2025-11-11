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
define( 'CHAT_FOR_N8N_VERSION', '1.1.0' );
define( 'CHAT_FOR_N8N_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CHAT_FOR_N8N_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include admin page files.
require_once CHAT_FOR_N8N_PLUGIN_DIR . 'includes/admin/dashboard-page.php';
require_once CHAT_FOR_N8N_PLUGIN_DIR . 'includes/admin/settings-page.php';
require_once CHAT_FOR_N8N_PLUGIN_DIR . 'includes/admin/appearance-page.php';
require_once CHAT_FOR_N8N_PLUGIN_DIR . 'includes/admin/display-rules-page.php';

/**
 * Registers the admin menu and submenus.
 */
function chat_for_n8n_add_admin_menu() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
	// Main menu item (Dashboard).
	add_menu_page(
		__( 'Chat for n8n', 'chat-for-n8n' ),
		__( 'Chat for n8n', 'chat-for-n8n' ),
		'manage_options',
		'chat-for-n8n',
		'chat_for_n8n_dashboard_page',
		'dashicons-format-chat',
		30
	);

	// Submenu: Dashboard (same as main menu).
	add_submenu_page(
		'chat-for-n8n',
		__( 'Dashboard', 'chat-for-n8n' ),
		__( 'Dashboard', 'chat-for-n8n' ),
		'manage_options',
		'chat-for-n8n',
		'chat_for_n8n_dashboard_page'
	);

	// Submenu: Settings.
	add_submenu_page(
		'chat-for-n8n',
		__( 'Settings', 'chat-for-n8n' ),
		__( 'Settings', 'chat-for-n8n' ),
		'manage_options',
		'chat-for-n8n-settings',
		'chat_for_n8n_settings_page'
	);

	// Submenu: Appearance.
	add_submenu_page(
		'chat-for-n8n',
		__( 'Appearance', 'chat-for-n8n' ),
		__( 'Appearance', 'chat-for-n8n' ),
		'manage_options',
		'chat-for-n8n-appearance',
		'chat_for_n8n_appearance_page'
	);

	// Submenu: Display Rules.
	add_submenu_page(
		'chat-for-n8n',
		__( 'Display Rules', 'chat-for-n8n' ),
		__( 'Display Rules', 'chat-for-n8n' ),
		'manage_options',
		'chat-for-n8n-display-rules',
		'chat_for_n8n_display_rules_page'
	);
}
add_action( 'admin_menu', 'chat_for_n8n_add_admin_menu' );

/**
 * Returns default color values for the chat widget.
 *
 * @return array Default colors.
 */
function chat_for_n8n_default_colors() {
	return array(
		'background'        => '#ffffff',
		'primary'           => '#2563eb',
		'text'              => '#1f2937',
		'bot_message_bg'    => '#f3f4f6',
		'user_message_bg'   => '#2563eb',
		'bot_message_text'  => '#1f2937',
		'user_message_text' => '#ffffff',
		'header_bg'         => '#1f2937',
		'header_text'       => '#ffffff',
		'input_bg'          => '#ffffff',
		'input_border'      => '#d1d5db',
		'input_text'        => '#1f2937',
		'send_button'       => '#2563eb',
		'placeholder_text'  => '#9ca3af',
	);
}

/**
 * Sanitizes color settings.
 *
 * @param array $colors Color values to sanitize.
 * @return array Sanitized colors.
 */
function chat_for_n8n_sanitize_colors( $colors ) {
	$sanitized = array();
	$defaults  = chat_for_n8n_default_colors();

	foreach ( $defaults as $key => $default ) {
		if ( isset( $colors[ $key ] ) && ! empty( $colors[ $key ] ) ) {
			// Sanitize hex color.
			$color = sanitize_hex_color( $colors[ $key ] );
			$sanitized[ $key ] = $color ? $color : $default;
		} else {
			$sanitized[ $key ] = $default;
		}
	}

	return $sanitized;
}

/**
 * Registers the plugin settings.
 */
function n8n_chat_widget_settings_init() {
	// Register settings.
	register_setting(
		'chat_for_n8n_settings_group',
		'n8n_chat_webhook_url',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '',
		)
	);

	register_setting(
		'chat_for_n8n_settings_group',
		'n8n_chat_widget_mode',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'window',
		)
	);

	register_setting(
		'chat_for_n8n_settings_group',
		'n8n_chat_widget_language',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'en',
		)
	);

	register_setting(
		'chat_for_n8n_settings_group',
		'n8n_chat_widget_welcome_screen',
		array(
			'type'              => 'boolean',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => true,
		)
	);

	register_setting(
		'chat_for_n8n_settings_group',
		'n8n_chat_widget_initial_messages',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'wp_kses_post',
			'default'           => '',
		)
	);

	register_setting(
		'chat_for_n8n_settings_group',
		'n8n_chat_widget_title',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Chat',
		)
	);

	register_setting(
		'chat_for_n8n_settings_group',
		'n8n_chat_widget_subtitle',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
		)
	);

	register_setting(
		'chat_for_n8n_settings_group',
		'n8n_chat_widget_input_placeholder',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
		)
	);

	register_setting(
		'chat_for_n8n_settings_group',
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
		'chat_for_n8n_settings'
	);

	// Field: Webhook URL.
	add_settings_field(
		'n8n_chat_webhook_url_field',
		__( 'n8n Chat Webhook URL', 'chat-for-n8n' ),
		'n8n_chat_webhook_url_render',
		'chat_for_n8n_settings',
		'n8n_chat_widget_main_section'
	);

	// Appearance Section.
	add_settings_section(
		'n8n_chat_widget_appearance_section',
		__( 'Appearance Configuration', 'chat-for-n8n' ),
		'n8n_chat_widget_appearance_section_callback',
		'chat_for_n8n_settings'
	);

	// Field: Widget Mode.
	add_settings_field(
		'n8n_chat_widget_mode_field',
		__( 'Widget Mode', 'chat-for-n8n' ),
		'n8n_chat_widget_mode_render',
		'chat_for_n8n_settings',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Language.
	add_settings_field(
		'n8n_chat_widget_language_field',
		__( 'Language', 'chat-for-n8n' ),
		'n8n_chat_widget_language_render',
		'chat_for_n8n_settings',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Welcome Screen.
	add_settings_field(
		'n8n_chat_widget_welcome_screen_field',
		__( 'Show Welcome Screen', 'chat-for-n8n' ),
		'n8n_chat_widget_welcome_screen_render',
		'chat_for_n8n_settings',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Initial Messages.
	add_settings_field(
		'n8n_chat_widget_initial_messages_field',
		__( 'Initial Messages', 'chat-for-n8n' ),
		'n8n_chat_widget_initial_messages_render',
		'chat_for_n8n_settings',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Title.
	add_settings_field(
		'n8n_chat_widget_title_field',
		__( 'Chat Title', 'chat-for-n8n' ),
		'n8n_chat_widget_title_render',
		'chat_for_n8n_settings',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Subtitle.
	add_settings_field(
		'n8n_chat_widget_subtitle_field',
		__( 'Chat Subtitle', 'chat-for-n8n' ),
		'n8n_chat_widget_subtitle_render',
		'chat_for_n8n_settings',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Input Placeholder.
	add_settings_field(
		'n8n_chat_widget_input_placeholder_field',
		__( 'Input Placeholder', 'chat-for-n8n' ),
		'n8n_chat_widget_input_placeholder_render',
		'chat_for_n8n_settings',
		'n8n_chat_widget_appearance_section'
	);

	// Field: Load Previous Session.
	add_settings_field(
		'n8n_chat_widget_load_session_field',
		__( 'Load Previous Session', 'chat-for-n8n' ),
		'n8n_chat_widget_load_session_render',
		'chat_for_n8n_settings',
		'n8n_chat_widget_appearance_section'
	);
}
add_action( 'admin_init', 'n8n_chat_widget_settings_init' );

/**
 * Registers color customization settings.
 */
function chat_for_n8n_register_color_settings() {
	register_setting(
		'chat_for_n8n_appearance_group',
		'chat_for_n8n_colors',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'chat_for_n8n_sanitize_colors',
			'default'           => chat_for_n8n_default_colors(),
		)
	);
}
add_action( 'admin_init', 'chat_for_n8n_register_color_settings' );

/**
 * Returns default display rules.
 *
 * @return array Default display rules.
 */
function chat_for_n8n_default_display_rules() {
	return array(
		'mode'                => 'all',
		'include_types'       => array(
			'homepage' => true,
			'posts'    => true,
			'pages'    => true,
			'archives' => true,
			'search'   => true,
			'404'      => false,
		),
		'selected_pages'      => array(),
		'selected_posts'      => array(),
		'excluded_pages'      => array(),
		'excluded_posts'      => array(),
		'selected_categories' => array(),
		'selected_tags'       => array(),
		'url_rules'           => array(),
	);
}

/**
 * Sanitizes display rules.
 *
 * @param array $rules Display rules to sanitize.
 * @return array Sanitized rules.
 */
function chat_for_n8n_sanitize_display_rules( $rules ) {
	$defaults  = chat_for_n8n_default_display_rules();
	$sanitized = array();

	// Sanitize mode.
	$sanitized['mode'] = isset( $rules['mode'] ) && in_array( $rules['mode'], array( 'all', 'selected', 'excluded' ), true )
		? $rules['mode']
		: 'all';

	// Sanitize include_types.
	$sanitized['include_types'] = array();
	if ( isset( $rules['include_types'] ) && is_array( $rules['include_types'] ) ) {
		foreach ( $defaults['include_types'] as $type => $default ) {
			$sanitized['include_types'][ $type ] = isset( $rules['include_types'][ $type ] ) && $rules['include_types'][ $type ];
		}
	} else {
		$sanitized['include_types'] = $defaults['include_types'];
	}

	// Sanitize ID arrays.
	$id_fields = array( 'selected_pages', 'selected_posts', 'excluded_pages', 'excluded_posts', 'selected_categories', 'selected_tags' );
	foreach ( $id_fields as $field ) {
		$sanitized[ $field ] = array();
		if ( isset( $rules[ $field ] ) && is_array( $rules[ $field ] ) ) {
			$sanitized[ $field ] = array_map( 'absint', $rules[ $field ] );
			$sanitized[ $field ] = array_filter( $sanitized[ $field ] ); // Remove zeros.
			$sanitized[ $field ] = array_values( $sanitized[ $field ] ); // Reindex.
		}
	}

	// Sanitize URL rules.
	$sanitized['url_rules'] = array();
	if ( isset( $rules['url_rules'] ) && is_array( $rules['url_rules'] ) ) {
		foreach ( $rules['url_rules'] as $rule ) {
			if ( ! isset( $rule['type'], $rule['value'], $rule['action'] ) ) {
				continue;
			}

			$type   = in_array( $rule['type'], array( 'contains', 'starts_with', 'ends_with', 'matches' ), true ) ? $rule['type'] : 'contains';
			$value  = sanitize_text_field( $rule['value'] );
			$action = in_array( $rule['action'], array( 'show', 'hide' ), true ) ? $rule['action'] : 'show';

			if ( ! empty( $value ) ) {
				$sanitized['url_rules'][] = array(
					'type'   => $type,
					'value'  => $value,
					'action' => $action,
				);
			}
		}
	}

	return $sanitized;
}

/**
 * Registers display rules settings.
 */
function chat_for_n8n_register_display_settings() {
	register_setting(
		'chat_for_n8n_display_group',
		'chat_for_n8n_display_rules',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'chat_for_n8n_sanitize_display_rules',
			'default'           => chat_for_n8n_default_display_rules(),
		)
	);
}
add_action( 'admin_init', 'chat_for_n8n_register_display_settings' );

/**
 * Determines if the chat widget should be displayed based on display rules.
 *
 * @return bool True if widget should be displayed, false otherwise.
 */
function chat_for_n8n_should_display_widget() {
	$rules = get_option( 'chat_for_n8n_display_rules', chat_for_n8n_default_display_rules() );

	// Allow developers to short-circuit.
	$pre_check = apply_filters( 'chat_for_n8n_pre_display_check', null, $rules );
	if ( null !== $pre_check ) {
		return (bool) $pre_check;
	}

	// Mode: all - always display.
	if ( 'all' === $rules['mode'] ) {
		return true;
	}

	$should_display = false;

	// Check page type rules.
	if ( is_front_page() && ! empty( $rules['include_types']['homepage'] ) ) {
		$should_display = true;
	} elseif ( is_single() && ! empty( $rules['include_types']['posts'] ) ) {
		$post_id = get_the_ID();
		$should_display = true;

		// Check category restrictions.
		if ( ! empty( $rules['selected_categories'] ) ) {
			$post_categories = wp_get_post_categories( $post_id );
			$should_display  = ! empty( array_intersect( $rules['selected_categories'], $post_categories ) );
		}

		// Check tag restrictions.
		if ( $should_display && ! empty( $rules['selected_tags'] ) ) {
			$post_tags      = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );
			$should_display = ! empty( array_intersect( $rules['selected_tags'], $post_tags ) );
		}

		// Check specific post selection (if mode is 'selected').
		if ( 'selected' === $rules['mode'] && ! empty( $rules['selected_posts'] ) ) {
			$should_display = in_array( $post_id, $rules['selected_posts'], true );
		}

		// Check excluded posts (if mode is 'excluded').
		if ( 'excluded' === $rules['mode'] && ! empty( $rules['excluded_posts'] ) ) {
			$should_display = ! in_array( $post_id, $rules['excluded_posts'], true );
		}
	} elseif ( is_page() && ! empty( $rules['include_types']['pages'] ) ) {
		$page_id = get_the_ID();

		// Mode: selected - only show on selected pages.
		if ( 'selected' === $rules['mode'] ) {
			$should_display = ! empty( $rules['selected_pages'] )
				? in_array( $page_id, $rules['selected_pages'], true )
				: true;
		} elseif ( 'excluded' === $rules['mode'] ) {
			// Mode: excluded - show on all except excluded pages.
			$should_display = ! in_array( $page_id, $rules['excluded_pages'], true );
		} else {
			$should_display = true;
		}
	} elseif ( is_archive() && ! empty( $rules['include_types']['archives'] ) ) {
		$should_display = true;
	} elseif ( is_search() && ! empty( $rules['include_types']['search'] ) ) {
		$should_display = true;
	} elseif ( is_404() && ! empty( $rules['include_types']['404'] ) ) {
		$should_display = true;
	}

	// Check URL rules (these take priority).
	if ( ! empty( $rules['url_rules'] ) ) {
		$current_url = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

		foreach ( $rules['url_rules'] as $url_rule ) {
			$matches = false;

			switch ( $url_rule['type'] ) {
				case 'contains':
					$matches = false !== strpos( $current_url, $url_rule['value'] );
					break;
				case 'starts_with':
					$matches = 0 === strpos( $current_url, $url_rule['value'] );
					break;
				case 'ends_with':
					$value_length = strlen( $url_rule['value'] );
					$matches      = substr( $current_url, -$value_length ) === $url_rule['value'];
					break;
				case 'matches':
					// Suppress errors for invalid regex.
					$matches = @preg_match( $url_rule['value'], $current_url );
					break;
			}

			if ( $matches ) {
				// URL rule matched - action determines display.
				$should_display = ( 'show' === $url_rule['action'] );
				break; // First matching rule wins.
			}
		}
	}

	return apply_filters( 'chat_for_n8n_should_display', $should_display, $rules );
}

/**
 * Enqueues admin assets for appearance page.
 *
 * @param string $hook_suffix The current admin page.
 */
function chat_for_n8n_enqueue_admin_assets( $hook_suffix ) {
	// Appearance page assets.
	if ( 'chat-for-n8n_page_chat-for-n8n-appearance' === $hook_suffix ) {
		// Enqueue WordPress color picker.
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		// Enqueue custom admin CSS.
		wp_enqueue_style(
			'chat-for-n8n-admin-appearance',
			CHAT_FOR_N8N_PLUGIN_URL . 'assets/admin/css/appearance.css',
			array( 'wp-color-picker' ),
			CHAT_FOR_N8N_VERSION
		);

		// Enqueue custom color picker JS.
		wp_enqueue_script(
			'chat-for-n8n-color-picker',
			CHAT_FOR_N8N_PLUGIN_URL . 'assets/admin/js/color-picker.js',
			array( 'jquery', 'wp-color-picker' ),
			CHAT_FOR_N8N_VERSION,
			true
		);

		// Localize script with translations.
		wp_localize_script(
			'chat-for-n8n-color-picker',
			'chatForN8nAdmin',
			array(
				'resetConfirm' => __( 'Reset all colors to defaults? This cannot be undone.', 'chat-for-n8n' ),
				'resetSuccess' => __( 'Colors reset to defaults. Click "Save Colors" to apply the changes.', 'chat-for-n8n' ),
			)
		);
	}

	// Display rules page assets.
	if ( 'chat-for-n8n_page_chat-for-n8n-display-rules' === $hook_suffix ) {
		// Enqueue display rules JS.
		wp_enqueue_script(
			'chat-for-n8n-display-rules',
			CHAT_FOR_N8N_PLUGIN_URL . 'assets/admin/js/display-rules.js',
			array( 'jquery' ),
			CHAT_FOR_N8N_VERSION,
			true
		);

		// Localize script with translations.
		wp_localize_script(
			'chat-for-n8n-display-rules',
			'chatForN8nDisplayRules',
			array(
				'removeConfirm'     => __( 'Remove this URL rule?', 'chat-for-n8n' ),
				'noRulesMessage'    => __( 'No URL rules defined. Click "Add URL Rule" to create one.', 'chat-for-n8n' ),
				'selectPlaceholder' => __( 'Select...', 'chat-for-n8n' ),
				'valuePlaceholder'  => __( 'Enter value...', 'chat-for-n8n' ),
				'saving'            => __( 'Saving...', 'chat-for-n8n' ),
			)
		);
	}
}
add_action( 'admin_enqueue_scripts', 'chat_for_n8n_enqueue_admin_assets' );

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
	// Check display rules first.
	if ( ! chat_for_n8n_should_display_widget() ) {
		return;
	}

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
 * Injects custom CSS with user-defined colors to the frontend.
 */
function chat_for_n8n_inject_custom_css() {
	// Get custom colors.
	$colors = get_option( 'chat_for_n8n_colors', chat_for_n8n_default_colors() );

	// Generate CSS with custom colors.
	$custom_css = "
		/* Chat for n8n - Custom Colors */
		:root {
			--cfn-background: {$colors['background']};
			--cfn-primary: {$colors['primary']};
			--cfn-text: {$colors['text']};
			--cfn-bot-message-bg: {$colors['bot_message_bg']};
			--cfn-user-message-bg: {$colors['user_message_bg']};
			--cfn-bot-message-text: {$colors['bot_message_text']};
			--cfn-user-message-text: {$colors['user_message_text']};
			--cfn-header-bg: {$colors['header_bg']};
			--cfn-header-text: {$colors['header_text']};
			--cfn-input-bg: {$colors['input_bg']};
			--cfn-input-border: {$colors['input_border']};
			--cfn-input-text: {$colors['input_text']};
			--cfn-send-button: {$colors['send_button']};
			--cfn-placeholder: {$colors['placeholder_text']};
		}

		/* Apply colors to n8n chat widget - Target only the chat window, not toggle button */
		.n8n-chat .chat-layout,
		.n8n-chat .chat-window {
			background-color: var(--cfn-background) !important;
			color: var(--cfn-text) !important;
		}

		/* Header styles */
		.n8n-chat .chat-header,
		.n8n-chat header {
			background-color: var(--cfn-header-bg) !important;
			color: var(--cfn-header-text) !important;
		}

		/* Bot messages */
		.n8n-chat .message.bot,
		.n8n-chat .message.assistant,
		.n8n-chat .chat-message-from-bot {
			background-color: var(--cfn-bot-message-bg) !important;
			color: var(--cfn-bot-message-text) !important;
		}

		/* User messages */
		.n8n-chat .message.user,
		.n8n-chat .chat-message-from-user {
			background-color: var(--cfn-user-message-bg) !important;
			color: var(--cfn-user-message-text) !important;
		}

		/* Input field */
		.n8n-chat input[type='text'],
		.n8n-chat textarea,
		.n8n-chat .chat-input textarea {
			background-color: var(--cfn-input-bg) !important;
			border-color: var(--cfn-input-border) !important;
			color: var(--cfn-input-text) !important;
		}

		/* Placeholder text */
		.n8n-chat input::placeholder,
		.n8n-chat textarea::placeholder {
			color: var(--cfn-placeholder) !important;
		}

		/* Send button */
		.n8n-chat button[type='submit'],
		.n8n-chat .send-button,
		.n8n-chat .chat-input-send-button {
			background-color: var(--cfn-send-button) !important;
			color: #ffffff !important;
		}

		/* Primary color for links and accents */
		.n8n-chat .chat-layout a,
		.n8n-chat .chat-window a,
		.n8n-chat .link {
			color: var(--cfn-primary) !important;
		}

		/* Close button in header */
		.n8n-chat .close-button,
		.n8n-chat .chat-close-button {
			color: var(--cfn-header-text) !important;
		}
		
		/* Ensure toggle button is NOT affected by background color */
		.n8n-chat .chat-window-toggle {
			background-color: var(--chat--toggle--background) !important;
			color: var(--chat--toggle--color) !important;
		}
	";

	// Allow developers to modify the custom CSS.
	$custom_css = apply_filters( 'chat_for_n8n_custom_css', $custom_css, $colors );

	// Inject CSS if widget styles are enqueued.
	if ( wp_style_is( 'chat-for-n8n-css', 'enqueued' ) ) {
		wp_add_inline_style( 'chat-for-n8n-css', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'chat_for_n8n_inject_custom_css', 20 );

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
	$settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=chat-for-n8n-settings' ) ) . '">' . __( 'Settings', 'chat-for-n8n' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'n8n_chat_widget_plugin_action_links' );