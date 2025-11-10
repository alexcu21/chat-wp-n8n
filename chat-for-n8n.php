<?php
/**
 * Plugin Name: n8n Chat Widget
 * Description: Añade el widget de chat impulsado por n8n a tu sitio web, conectando flujos de trabajo de automatización e IA.
 * Version: 1.0.0
 * Author: Alex Cuadra
 * Author URI: https://alexcuadra.dev
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: n8n-chat-widget
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 *
 * @package N8n_Chat_Widget
 */

// Evita el acceso directo al archivo.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Definir constantes del plugin.
define( 'N8N_CHAT_WIDGET_VERSION', '1.0.0' );
define( 'N8N_CHAT_WIDGET_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'N8N_CHAT_WIDGET_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Registra la página de ajustes en el menú de administración.
 */
function n8n_chat_widget_add_admin_menu() {
	add_options_page(
		__( 'Ajustes del Chat n8n', 'n8n-chat-widget' ),
		__( 'n8n Chat Widget', 'n8n-chat-widget' ),
		'manage_options',
		'n8n-chat-widget',
		'n8n_chat_widget_options_page'
	);
}
add_action( 'admin_menu', 'n8n_chat_widget_add_admin_menu' );

/**
 * Muestra la página de ajustes del plugin.
 */
function n8n_chat_widget_options_page() {
	// Verifica permisos.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Muestra mensajes de actualización si se han guardado cambios.
	if ( isset( $_GET['settings-updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		add_settings_error(
			'n8n_chat_widget_messages',
			'n8n_chat_widget_message',
			__( 'Ajustes guardados correctamente.', 'n8n-chat-widget' ),
			'updated'
		);
	}

	settings_errors( 'n8n_chat_widget_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'n8n_chat_widget_group' );
			do_settings_sections( 'n8n_chat_widget' );
			submit_button( __( 'Guardar Cambios', 'n8n-chat-widget' ) );
			?>
		</form>
		<hr>
		<h2><?php esc_html_e( 'Cómo usar este plugin', 'n8n-chat-widget' ); ?></h2>
		<ol>
			<li><?php esc_html_e( 'Crea un workflow en n8n con un nodo "Chat Trigger".', 'n8n-chat-widget' ); ?></li>
			<li><?php esc_html_e( 'Copia la URL del webhook del nodo "Chat Trigger".', 'n8n-chat-widget' ); ?></li>
			<li><?php esc_html_e( 'Pega la URL en el campo de arriba y guarda los cambios.', 'n8n-chat-widget' ); ?></li>
			<li><?php esc_html_e( 'El widget de chat aparecerá automáticamente en tu sitio web.', 'n8n-chat-widget' ); ?></li>
		</ol>
		<p>
			<?php
			printf(
				/* translators: %s: URL de la documentación de n8n */
				esc_html__( 'Para más información, consulta la %s.', 'n8n-chat-widget' ),
				'<a href="https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'documentación oficial de n8n', 'n8n-chat-widget' ) . '</a>'
			);
			?>
		</p>
	</div>
	<?php
}

/**
 * Registra los ajustes del plugin.
 */
function n8n_chat_widget_settings_init() {
	// Registrar ajustes.
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

	// Sección Principal.
	add_settings_section(
		'n8n_chat_widget_main_section',
		__( 'Configuración Principal del Widget', 'n8n-chat-widget' ),
		'n8n_chat_widget_main_section_callback',
		'n8n_chat_widget'
	);

	// Campo: URL del Webhook.
	add_settings_field(
		'n8n_chat_webhook_url_field',
		__( 'URL del Webhook de n8n Chat', 'n8n-chat-widget' ),
		'n8n_chat_webhook_url_render',
		'n8n_chat_widget',
		'n8n_chat_widget_main_section'
	);

	// Sección de Apariencia.
	add_settings_section(
		'n8n_chat_widget_appearance_section',
		__( 'Configuración de Apariencia', 'n8n-chat-widget' ),
		'n8n_chat_widget_appearance_section_callback',
		'n8n_chat_widget'
	);

	// Campo: Modo del Widget.
	add_settings_field(
		'n8n_chat_widget_mode_field',
		__( 'Modo del Widget', 'n8n-chat-widget' ),
		'n8n_chat_widget_mode_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Campo: Idioma.
	add_settings_field(
		'n8n_chat_widget_language_field',
		__( 'Idioma', 'n8n-chat-widget' ),
		'n8n_chat_widget_language_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Campo: Pantalla de Bienvenida.
	add_settings_field(
		'n8n_chat_widget_welcome_screen_field',
		__( 'Mostrar Pantalla de Bienvenida', 'n8n-chat-widget' ),
		'n8n_chat_widget_welcome_screen_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Campo: Mensajes Iniciales.
	add_settings_field(
		'n8n_chat_widget_initial_messages_field',
		__( 'Mensajes Iniciales', 'n8n-chat-widget' ),
		'n8n_chat_widget_initial_messages_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Campo: Título.
	add_settings_field(
		'n8n_chat_widget_title_field',
		__( 'Título del Chat', 'n8n-chat-widget' ),
		'n8n_chat_widget_title_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Campo: Subtítulo.
	add_settings_field(
		'n8n_chat_widget_subtitle_field',
		__( 'Subtítulo del Chat', 'n8n-chat-widget' ),
		'n8n_chat_widget_subtitle_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Campo: Placeholder del Input.
	add_settings_field(
		'n8n_chat_widget_input_placeholder_field',
		__( 'Placeholder del Input', 'n8n-chat-widget' ),
		'n8n_chat_widget_input_placeholder_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);

	// Campo: Cargar Sesión Previa.
	add_settings_field(
		'n8n_chat_widget_load_session_field',
		__( 'Cargar Sesión Previa', 'n8n-chat-widget' ),
		'n8n_chat_widget_load_session_render',
		'n8n_chat_widget',
		'n8n_chat_widget_appearance_section'
	);
}
add_action( 'admin_init', 'n8n_chat_widget_settings_init' );

/**
 * Callback para la sección principal.
 */
function n8n_chat_widget_main_section_callback() {
	echo '<p>' . esc_html__( 'Introduce la URL pública de tu Webhook de n8n Chat Trigger para activar el widget.', 'n8n-chat-widget' ) . '</p>';
}

/**
 * Callback para la sección de apariencia.
 */
function n8n_chat_widget_appearance_section_callback() {
	echo '<p>' . esc_html__( 'Personaliza la apariencia y comportamiento del widget de chat.', 'n8n-chat-widget' ) . '</p>';
}

/**
 * Renderiza el campo de URL del webhook.
 */
function n8n_chat_webhook_url_render() {
	$url = get_option( 'n8n_chat_webhook_url' );
	?>
	<input type="url" 
		   name="n8n_chat_webhook_url" 
		   value="<?php echo esc_attr( $url ); ?>" 
		   placeholder="<?php esc_attr_e( 'https://tudominio.com/webhook/...', 'n8n-chat-widget' ); ?>" 
		   size="60" 
		   class="regular-text">
	<p class="description">
		<?php esc_html_e( 'Asegúrate de que esta URL provenga de tu nodo "Chat Trigger" en n8n.', 'n8n-chat-widget' ); ?>
	</p>
	<?php
}

/**
 * Renderiza el campo de modo del widget.
 */
function n8n_chat_widget_mode_render() {
	$mode = get_option( 'n8n_chat_widget_mode', 'window' );
	?>
	<select name="n8n_chat_widget_mode">
		<option value="window" <?php selected( $mode, 'window' ); ?>>
			<?php esc_html_e( 'Ventana Flotante', 'n8n-chat-widget' ); ?>
		</option>
		<option value="fullscreen" <?php selected( $mode, 'fullscreen' ); ?>>
			<?php esc_html_e( 'Pantalla Completa', 'n8n-chat-widget' ); ?>
		</option>
	</select>
	<p class="description">
		<?php esc_html_e( 'Ventana Flotante: widget en la esquina inferior derecha. Pantalla Completa: usa el shortcode [n8n_chat] en una página.', 'n8n-chat-widget' ); ?>
	</p>
	<?php
}

/**
 * Renderiza el campo de idioma.
 */
function n8n_chat_widget_language_render() {
	$language = get_option( 'n8n_chat_widget_language', 'es' );
	?>
	<select name="n8n_chat_widget_language">
		<option value="en" <?php selected( $language, 'en' ); ?>>English</option>
		<option value="es" <?php selected( $language, 'es' ); ?>>Español</option>
		<option value="de" <?php selected( $language, 'de' ); ?>>Deutsch</option>
		<option value="fr" <?php selected( $language, 'fr' ); ?>>Français</option>
		<option value="pt" <?php selected( $language, 'pt' ); ?>>Português</option>
	</select>
	<p class="description">
		<?php esc_html_e( 'Idioma predeterminado del widget de chat.', 'n8n-chat-widget' ); ?>
	</p>
	<?php
}

/**
 * Renderiza el campo de pantalla de bienvenida.
 */
function n8n_chat_widget_welcome_screen_render() {
	$show_welcome = get_option( 'n8n_chat_widget_welcome_screen', true );
	?>
	<label>
		<input type="checkbox" 
			   name="n8n_chat_widget_welcome_screen" 
			   value="1" 
			   <?php checked( $show_welcome, true ); ?>>
		<?php esc_html_e( 'Mostrar pantalla de bienvenida al abrir el chat', 'n8n-chat-widget' ); ?>
	</label>
	<?php
}

/**
 * Renderiza el campo de mensajes iniciales.
 */
function n8n_chat_widget_initial_messages_render() {
	$initial_messages = get_option( 'n8n_chat_widget_initial_messages', '' );
	?>
	<textarea name="n8n_chat_widget_initial_messages" 
			  rows="3" 
			  cols="60" 
			  class="large-text"
			  placeholder="<?php esc_attr_e( '¡Hola! ¿En qué puedo ayudarte hoy?', 'n8n-chat-widget' ); ?>"><?php echo esc_textarea( $initial_messages ); ?></textarea>
	<p class="description">
		<?php esc_html_e( 'Mensaje de bienvenida que verán los usuarios (opcional).', 'n8n-chat-widget' ); ?>
	</p>
	<?php
}

/**
 * Renderiza el campo de título del chat.
 */
function n8n_chat_widget_title_render() {
	$title = get_option( 'n8n_chat_widget_title', 'Chat' );
	?>
	<input type="text" 
		   name="n8n_chat_widget_title" 
		   value="<?php echo esc_attr( $title ); ?>" 
		   class="regular-text"
		   placeholder="<?php esc_attr_e( 'Chat', 'n8n-chat-widget' ); ?>">
	<p class="description">
		<?php esc_html_e( 'Título que aparecerá en la cabecera del chat.', 'n8n-chat-widget' ); ?>
	</p>
	<?php
}

/**
 * Renderiza el campo de subtítulo del chat.
 */
function n8n_chat_widget_subtitle_render() {
	$subtitle = get_option( 'n8n_chat_widget_subtitle', '' );
	?>
	<input type="text" 
		   name="n8n_chat_widget_subtitle" 
		   value="<?php echo esc_attr( $subtitle ); ?>" 
		   class="regular-text"
		   placeholder="<?php esc_attr_e( '¿En qué puedo ayudarte?', 'n8n-chat-widget' ); ?>">
	<p class="description">
		<?php esc_html_e( 'Subtítulo que aparecerá debajo del título (opcional).', 'n8n-chat-widget' ); ?>
	</p>
	<?php
}

/**
 * Renderiza el campo de placeholder del input.
 */
function n8n_chat_widget_input_placeholder_render() {
	$placeholder = get_option( 'n8n_chat_widget_input_placeholder', '' );
	?>
	<input type="text" 
		   name="n8n_chat_widget_input_placeholder" 
		   value="<?php echo esc_attr( $placeholder ); ?>" 
		   class="regular-text"
		   placeholder="<?php esc_attr_e( 'Escribe tu mensaje...', 'n8n-chat-widget' ); ?>">
	<p class="description">
		<?php esc_html_e( 'Texto que aparece en el campo de entrada antes de escribir (opcional).', 'n8n-chat-widget' ); ?>
	</p>
	<?php
}

/**
 * Renderiza el campo de cargar sesión previa.
 */
function n8n_chat_widget_load_session_render() {
	$load_session = get_option( 'n8n_chat_widget_load_session', false );
	?>
	<label>
		<input type="checkbox" 
			   name="n8n_chat_widget_load_session" 
			   value="1" 
			   <?php checked( $load_session, true ); ?>>
		<?php esc_html_e( 'Mantener el historial de conversaciones entre sesiones', 'n8n-chat-widget' ); ?>
	</label>
	<p class="description">
		<?php
		printf(
			/* translators: %s: Enlace a la documentación */
			esc_html__( 'Requiere configurar memoria en tu workflow de n8n. %s', 'n8n-chat-widget' ),
			'<a href="https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Más información', 'n8n-chat-widget' ) . '</a>'
		);
		?>
	</p>
	<?php
}

/**
 * Encola los scripts y estilos necesarios en el frontend.
 */
function n8n_chat_widget_enqueue_assets() {
	// Solo encola si la URL del webhook está configurada.
	$webhook_url = get_option( 'n8n_chat_webhook_url' );
	if ( empty( $webhook_url ) ) {
		return;
	}

	// Determinar si usamos archivos de desarrollo o producción.
	$use_dev = defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'N8N_CHAT_WIDGET_DEV' ) && N8N_CHAT_WIDGET_DEV;
	
	// Directorios de archivos.
	$js_file  = $use_dev ? 'src/js/main.js' : 'dist/main.js';
	$css_file = $use_dev ? 'src/scss/main.scss' : 'dist/chat-for-n8n.css';
	
	// Verificar si existe el archivo compilado, si no, usar el legacy.
	if ( ! file_exists( N8N_CHAT_WIDGET_PLUGIN_DIR . $js_file ) ) {
		$js_file = 'chat-for-n8n.js';
	}
	if ( ! file_exists( N8N_CHAT_WIDGET_PLUGIN_DIR . $css_file ) ) {
		$css_file = 'chat-for-n8n.css';
	}

	// 1. Cargar la biblioteca n8n Chat desde CDN.
	wp_enqueue_script(
		'n8n-chat-lib',
		'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/chat.bundle.es.js',
		array(),
		N8N_CHAT_WIDGET_VERSION,
		true
	);

	// 2. Cargar los estilos de la librería.
	wp_enqueue_style(
		'n8n-chat-lib-css',
		'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css',
		array(),
		N8N_CHAT_WIDGET_VERSION
	);

	// 3. Cargar estilos personalizados del widget.
	wp_enqueue_style(
		'n8n-chat-widget-css',
		N8N_CHAT_WIDGET_PLUGIN_URL . $css_file,
		array( 'n8n-chat-lib-css' ),
		N8N_CHAT_WIDGET_VERSION
	);

	// 4. Cargar el script de inicialización del widget.
	wp_enqueue_script(
		'n8n-chat-widget',
		N8N_CHAT_WIDGET_PLUGIN_URL . $js_file,
		array(),
		N8N_CHAT_WIDGET_VERSION,
		true
	);

	// 5. Pasar configuración al script como variable global.
	$mode             = get_option( 'n8n_chat_widget_mode', 'window' );
	$language         = get_option( 'n8n_chat_widget_language', 'es' );
	$welcome_screen   = get_option( 'n8n_chat_widget_welcome_screen', true );
	$initial_messages = get_option( 'n8n_chat_widget_initial_messages', '' );
	$title            = get_option( 'n8n_chat_widget_title', 'Chat' );
	$subtitle         = get_option( 'n8n_chat_widget_subtitle', '' );
	$placeholder      = get_option( 'n8n_chat_widget_input_placeholder', '' );
	$load_session     = get_option( 'n8n_chat_widget_load_session', false );

	$config = array(
		'webhookUrl'        => esc_url_raw( $webhook_url ),
		'mode'              => sanitize_text_field( $mode ),
		'language'          => sanitize_text_field( $language ),
		'showWelcomeScreen' => rest_sanitize_boolean( $welcome_screen ),
		'title'             => sanitize_text_field( $title ),
		'loadPreviousSession' => rest_sanitize_boolean( $load_session ),
	);

	// Añadir subtitle si está configurado.
	if ( ! empty( $subtitle ) ) {
		$config['subtitle'] = sanitize_text_field( $subtitle );
	}

	// Añadir placeholder si está configurado.
	if ( ! empty( $placeholder ) ) {
		$config['inputPlaceholder'] = sanitize_text_field( $placeholder );
	}

	// Añadir mensajes iniciales si están configurados.
	if ( ! empty( $initial_messages ) ) {
		$config['initialMessages'] = array( wp_kses_post( $initial_messages ) );
	}

	// Inyectar la configuración como script inline en el head para que esté disponible para el módulo.
	wp_add_inline_script(
		'n8n-chat-widget',
		'window.n8nChatConfig = ' . wp_json_encode( $config ) . ';',
		'before'
	);
}
add_action( 'wp_enqueue_scripts', 'n8n_chat_widget_enqueue_assets' );

/**
 * Añade el atributo type="module" al script de n8n chat.
 *
 * @param string $tag    El tag del script.
 * @param string $handle El handle del script.
 * @param string $src    La URL del script.
 * @return string El tag modificado.
 */
function n8n_chat_widget_add_type_module( $tag, $handle, $src ) {
	// Solo añadir type="module" a nuestros scripts específicos.
	if ( 'n8n-chat-lib' === $handle || 'n8n-chat-widget' === $handle ) {
		// Reemplazar type='text/javascript' con type='module'.
		$tag = str_replace( " type='text/javascript'", " type='module'", $tag );
		// También manejar comillas dobles.
		$tag = str_replace( ' type="text/javascript"', ' type="module"', $tag );
		// Si no tiene type, añadirlo.
		if ( strpos( $tag, "type='module'" ) === false && strpos( $tag, 'type="module"' ) === false ) {
			$tag = str_replace( '<script ', '<script type="module" ', $tag );
		}
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'n8n_chat_widget_add_type_module', 10, 3 );

/**
 * Shortcode para insertar el chat en una página.
 *
 * @return string HTML del contenedor del chat.
 */
function n8n_chat_widget_shortcode() {
	$webhook_url = get_option( 'n8n_chat_webhook_url' );
	if ( empty( $webhook_url ) ) {
		return '<p>' . esc_html__( 'El widget de chat no está configurado. Por favor, configura la URL del webhook en los ajustes.', 'n8n-chat-widget' ) . '</p>';
	}
	return '<div id="n8n-chat-container"></div>';
}
add_shortcode( 'n8n_chat', 'n8n_chat_widget_shortcode' );

/**
 * Añade enlaces útiles en la página de plugins.
 *
 * @param array $links Enlaces existentes.
 * @return array Enlaces modificados.
 */
function n8n_chat_widget_plugin_action_links( $links ) {
	$settings_link = '<a href="' . esc_url( admin_url( 'options-general.php?page=n8n-chat-widget' ) ) . '">' . __( 'Ajustes', 'n8n-chat-widget' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'n8n_chat_widget_plugin_action_links' );