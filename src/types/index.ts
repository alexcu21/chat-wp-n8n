/**
 * Type definitions for n8n Chat Widget
 * 
 * @package N8n_Chat_Widget
 */

/**
 * n8n Chat Widget Configuration
 */
export interface N8nChatConfig {
	webhookUrl: string;
	mode?: 'window' | 'fullscreen';
	language?: string;
	showWelcomeScreen?: boolean;
	title?: string;
	subtitle?: string;
	inputPlaceholder?: string;
	loadPreviousSession?: boolean;
	initialMessages?: string[];
}

/**
 * Chat Configuration passed to createChat function
 */
export interface ChatConfig {
	webhookUrl: string;
	mode: 'window' | 'fullscreen';
	showWelcomeScreen: boolean;
	defaultLanguage: string;
	chatInputKey: string;
	chatSessionKey: string;
	metadata: Record<string, unknown>;
	showWindowCloseButton: boolean;
	loadPreviousSession: boolean;
	i18n: Record<string, I18nTranslations>;
	target?: string;
	initialMessages?: string[];
}

/**
 * Translation strings for a language
 */
export interface I18nTranslations {
	title: string;
	subtitle: string;
	footer: string;
	getStarted: string;
	inputPlaceholder: string;
	closeButtonTooltip: string;
}

/**
 * n8n Chat Widget API
 */
export interface N8nChatWidgetAPI {
	version: string;
	init: () => void;
}

/**
 * Custom Events
 */
export interface N8nChatWidgetLoadedEvent extends CustomEvent {
	detail: {
		config: ChatConfig;
	};
}

export interface N8nChatWidgetErrorEvent extends CustomEvent {
	detail: {
		error: Error;
	};
}

/**
 * Window extensions
 */
declare global {
	interface Window {
		n8nChatConfig?: N8nChatConfig;
		n8nChatWidget?: N8nChatWidgetAPI;
		createChat?: (config: ChatConfig) => void;
	}
}

