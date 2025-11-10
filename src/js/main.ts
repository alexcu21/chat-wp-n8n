/**
 * n8n Chat Widget - Widget Initialization
 * 
 * This file initializes the n8n chat widget using the @n8n/chat library.
 * The library is imported as an ES6 module.
 * 
 * @package N8n_Chat_Widget
 */

// Import SCSS styles
import '../scss/main.scss';

// Import types
import type {
	N8nChatConfig,
	ChatConfig,
	I18nTranslations,
	N8nChatWidgetAPI
} from '../types';

/**
 * Note: The createChat function is loaded from the @n8n/chat CDN library
 * via WordPress wp_enqueue_script in the PHP file.
 * It's available as window.createChat at runtime.
 */

/**
 * Default widget configuration
 */
const DEFAULT_CONFIG: Partial<ChatConfig> = {
	chatInputKey: 'chatInput',
	chatSessionKey: 'sessionId',
	metadata: {},
	showWindowCloseButton: true,
};

/**
 * Default translations
 */
const DEFAULT_I18N: Record<string, I18nTranslations> = {
	es: {
		title: 'Chat',
		subtitle: '¡Hola! ¿En qué puedo ayudarte?',
		footer: '',
		getStarted: 'Comenzar chat',
		inputPlaceholder: 'Escribe tu mensaje...',
	},
	en: {
		title: 'Chat',
		subtitle: 'Hi! How can I help you?',
		footer: '',
		getStarted: 'Start chat',
		inputPlaceholder: 'Type your message...',
	},
	de: {
		title: 'Chat',
		subtitle: 'Hallo! Wie kann ich Ihnen helfen?',
		footer: '',
		getStarted: 'Chat starten',
		inputPlaceholder: 'Schreiben Sie Ihre Nachricht...',
	},
	fr: {
		title: 'Chat',
		subtitle: 'Bonjour! Comment puis-je vous aider?',
		footer: '',
		getStarted: 'Démarrer le chat',
		inputPlaceholder: 'Tapez votre message...',
	},
	pt: {
		title: 'Chat',
		subtitle: 'Olá! Como posso ajudá-lo?',
		footer: '',
		getStarted: 'Iniciar chat',
		inputPlaceholder: 'Digite sua mensagem...',
	},
};

/**
 * Validates the widget configuration
 * @param config - Configuration to validate
 * @returns True if configuration is valid
 */
function validateConfig(config: N8nChatConfig | undefined): config is N8nChatConfig {
	if (typeof config === 'undefined') {
		console.error('n8n Chat Widget: Configuration not found.');
		return false;
	}

	if (!config.webhookUrl) {
		console.error('n8n Chat Widget: Webhook URL not configured.');
		return false;
	}

	// Validate URL
	try {
		new URL(config.webhookUrl);
	} catch (error) {
		console.error('n8n Chat Widget: Invalid webhook URL.', error);
		return false;
	}

	return true;
}

/**
 * Builds the chat configuration
 * @param config - User configuration
 * @returns Complete chat configuration or null if invalid
 */
function buildChatConfig(config: N8nChatConfig): ChatConfig | null {
	const language = config.language || 'es';
	const translations = DEFAULT_I18N[language] || DEFAULT_I18N.es;

	const chatConfig: ChatConfig = {
		...DEFAULT_CONFIG,
		webhookUrl: config.webhookUrl,
		mode: config.mode || 'window',
		showWelcomeScreen: config.showWelcomeScreen !== false,
		defaultLanguage: language,
		loadPreviousSession: config.loadPreviousSession || false,
		i18n: {
			[language]: {
				title: config.title || translations.title,
				subtitle: config.subtitle || translations.subtitle,
				footer: translations.footer,
				getStarted: translations.getStarted,
				inputPlaceholder: config.inputPlaceholder || translations.inputPlaceholder,
			},
		},
	} as ChatConfig;

	// If fullscreen mode, add target
	if (chatConfig.mode === 'fullscreen') {
		const container = document.getElementById('n8n-chat-container');
		if (container) {
			chatConfig.target = '#n8n-chat-container';
		} else {
			console.warn('n8n Chat Widget: Container #n8n-chat-container not found for fullscreen mode.');
			return null;
		}
	}

	// Add initial messages if configured
	if (config.initialMessages && config.initialMessages.length > 0) {
		chatConfig.initialMessages = config.initialMessages;
	}

	return chatConfig;
}

/**
 * Initializes the chat widget when DOM is ready
 */
function initN8nChat(): void {
	// Get configuration from window
	const config = window.n8nChatConfig;

	// Validate configuration
	if (!validateConfig(config)) {
		return;
	}

	// Build chat configuration
	const chatConfig = buildChatConfig(config);
	
	if (!chatConfig) {
		return;
	}

	try {
		// Create chat widget
		if (window.createChat) {
			window.createChat(chatConfig);
			console.log('n8n Chat Widget: Widget initialized successfully.');
			
			// Dispatch custom event
			window.dispatchEvent(new CustomEvent('n8nChatWidgetLoaded', {
				detail: { config: chatConfig }
			}));
		} else {
			throw new Error('createChat function not available');
		}
	} catch (error) {
		console.error('n8n Chat Widget: Error initializing widget:', error);
		
		// Dispatch error event
		window.dispatchEvent(new CustomEvent('n8nChatWidgetError', {
			detail: { error }
		}));
	}
}

/**
 * Initialization
 * Waits for DOM to be ready before initializing
 */
if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initN8nChat);
} else {
	// DOM is already ready, execute immediately
	initN8nChat();
}

/**
 * Expose public API (optional)
 */
const n8nChatWidgetAPI: N8nChatWidgetAPI = {
	version: '1.1.0',
	init: initN8nChat,
};

window.n8nChatWidget = n8nChatWidgetAPI;

// Export for potential module usage
export { initN8nChat, validateConfig, buildChatConfig };
