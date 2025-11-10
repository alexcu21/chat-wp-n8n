/**
 * n8n Chat Widget - Inicialización del Widget
 * 
 * Este archivo inicializa el widget de chat de n8n usando la librería @n8n/chat.
 * La librería se importa como módulo ES6.
 * 
 * @package N8n_Chat_Widget
 */

// Importar createChat desde la librería @n8n/chat
import { createChat } from 'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/chat.bundle.es.js';

/**
 * Inicializa el widget de chat cuando el DOM está listo.
 */
function initN8nChat() {
	// Verifica que la configuración esté disponible en window.
	if ( typeof window.n8nChatConfig === 'undefined' ) {
		console.error( 'n8n Chat Widget: Configuración no encontrada.' );
		return;
	}

	const config = window.n8nChatConfig;

	// Verifica que la URL del webhook esté configurada.
	if ( ! config.webhookUrl ) {
		console.error( 'n8n Chat Widget: URL del Webhook no configurada.' );
		return;
	}

	// Configuración del widget.
	const chatConfig = {
		webhookUrl: config.webhookUrl,
		mode: config.mode || 'window',
		showWelcomeScreen: config.showWelcomeScreen !== false,
		defaultLanguage: config.language || 'es',
		chatInputKey: 'chatInput',
		chatSessionKey: 'sessionId',
		metadata: {},
		showWindowCloseButton: true,
		loadPreviousSession: config.loadPreviousSession || false,
		i18n: {
			es: {
				title: config.title || 'Chat',
				subtitle: config.subtitle || '¡Hola! ¿En qué puedo ayudarte?',
				footer: '',
				getStarted: 'Comenzar chat',
				inputPlaceholder: config.inputPlaceholder || 'Escribe tu mensaje...',
			},
			en: {
				title: config.title || 'Chat',
				subtitle: config.subtitle || 'Hi! How can I help you?',
				footer: '',
				getStarted: 'Start chat',
				inputPlaceholder: config.inputPlaceholder || 'Type your message...',
			}
		}
	};

	// Si es modo fullscreen, añade el target.
	if ( chatConfig.mode === 'fullscreen' ) {
		const container = document.getElementById( 'n8n-chat-container' );
		if ( container ) {
			chatConfig.target = '#n8n-chat-container';
		} else {
			console.warn( 'n8n Chat Widget: No se encontró el contenedor #n8n-chat-container para el modo fullscreen.' );
			return;
		}
	}

	// Añade mensajes iniciales si están configurados.
	if ( config.initialMessages && config.initialMessages.length > 0 ) {
		chatConfig.initialMessages = config.initialMessages;
	}

	try {
		// Crea el widget de chat.
		createChat( chatConfig );
		console.log( 'n8n Chat Widget: Widget inicializado correctamente.' );
	} catch ( error ) {
		console.error( 'n8n Chat Widget: Error al inicializar el widget:', error );
	}
}

// Espera a que el DOM esté listo.
if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initN8nChat );
} else {
	// DOM ya está listo, ejecuta inmediatamente.
	initN8nChat();
}