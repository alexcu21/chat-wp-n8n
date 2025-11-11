/**
 * Color Picker JavaScript
 * Handles color picker initialization and live preview updates
 * 
 * @package Chat_for_n8n
 */

(function($) {
	'use strict';

	/**
	 * Updates the preview widget with current colors
	 */
	function updatePreview() {
		const colors = {
			background: $('#color-background').val(),
			primary: $('#color-primary').val(),
			text: $('#color-text').val(),
			botMessageBg: $('#color-bot-message-bg').val(),
			botMessageText: $('#color-bot-message-text').val(),
			userMessageBg: $('#color-user-message-bg').val(),
			userMessageText: $('#color-user-message-text').val(),
			headerBg: $('#color-header-bg').val(),
			headerText: $('#color-header-text').val(),
			inputBg: $('#color-input-bg').val(),
			inputBorder: $('#color-input-border').val(),
			inputText: $('#color-input-text').val(),
			sendButton: $('#color-send-button').val(),
			placeholderText: $('#color-placeholder-text').val()
		};

		// Apply colors to preview (using actual n8n chat widget classes)
		const $preview = $('#chat-preview-container');
		
		// Main chat background
		$preview.css('background-color', colors.background);
		
		// Chat Header
		$preview.find('.chat-header').css({
			'background-color': colors.headerBg,
			'color': colors.headerText
		});
		
		// Header elements
		$preview.find('.chat-heading h1, .chat-heading p').css({
			'color': colors.headerText
		});
		
		// Close button
		$preview.find('.chat-close-button').css({
			'color': colors.headerText
		});
		
		// Chat Body (messages area background)
		$preview.find('.chat-body').css({
			'background-color': colors.background
		});
		
		// Bot messages
		$preview.find('.chat-message-from-bot').css({
			'background-color': colors.botMessageBg,
			'color': colors.botMessageText
		});
		
		// User messages
		$preview.find('.chat-message-from-user').css({
			'background-color': colors.userMessageBg,
			'color': colors.userMessageText
		});
		
		// Chat Footer
		$preview.find('.chat-footer').css({
			'background-color': colors.background
		});
		
		// Input textarea
		$preview.find('.chat-inputs textarea').css({
			'background-color': colors.inputBg,
			'border-color': colors.inputBorder,
			'color': colors.inputText
		});
		
		// Input placeholder (CSS injection)
		const placeholderStyle = `
			#chat-preview-container .chat-inputs textarea::placeholder {
				color: ${colors.placeholderText} !important;
				opacity: 1;
			}
			#chat-preview-container .chat-inputs textarea::-webkit-input-placeholder {
				color: ${colors.placeholderText};
			}
			#chat-preview-container .chat-inputs textarea::-moz-placeholder {
				color: ${colors.placeholderText};
				opacity: 1;
			}
		`;
		
		// Update or create style tag
		let $styleTag = $('#preview-placeholder-style');
		if ($styleTag.length === 0) {
			$styleTag = $('<style id="preview-placeholder-style"></style>');
			$('head').append($styleTag);
		}
		$styleTag.html(placeholderStyle);
		
		// Send button
		$preview.find('.chat-input-send-button').css({
			'background-color': 'transparent',
			'color': colors.sendButton
		});
		
		// Send button SVG icon
		$preview.find('.chat-input-send-button svg').css({
			'stroke': colors.sendButton
		});
	}

	/**
	 * Resets all colors to default values
	 */
	function resetColors() {
		if (!confirm(chatForN8nAdmin.resetConfirm || 'Reset all colors to defaults? This cannot be undone.')) {
			return;
		}

		// Reset each color picker to its default value
		$('.chat-color-picker').each(function() {
			const $input = $(this);
			const defaultColor = $input.data('default-color');
			
			if (defaultColor) {
				$input.val(defaultColor).change();
				$input.wpColorPicker('color', defaultColor);
			}
		});

		// Update preview
		updatePreview();
		
		// Show notice
		const $notice = $('<div class="notice notice-info is-dismissible"><p>' + 
			(chatForN8nAdmin.resetSuccess || 'Colors reset to defaults. Click "Save Colors" to apply the changes.') + 
			'</p></div>');
		$('.wrap > h1').after($notice);
		
		// Auto-dismiss after 5 seconds
		setTimeout(function() {
			$notice.fadeOut(function() {
				$(this).remove();
			});
		}, 5000);
	}

	/**
	 * Initialize on document ready
	 */
	$(document).ready(function() {
		// Initialize WordPress color pickers
		$('.chat-color-picker').wpColorPicker({
			change: function(event, ui) {
				// Update preview when color changes
				updatePreview();
			},
			clear: function() {
				// Update preview when color is cleared
				setTimeout(updatePreview, 50);
			}
		});

		// Initial preview update
		updatePreview();

		// Reset colors button
		$('#reset-colors').on('click', resetColors);

		// Add save animation
		$('#color-settings-form').on('submit', function() {
			$('.color-settings-panel').addClass('loading');
		});

		// Highlight preview on successful save
		const urlParams = new URLSearchParams(window.location.search);
		if (urlParams.get('settings-updated')) {
			$('.color-preview-panel').addClass('saved');
			setTimeout(function() {
				$('.color-preview-panel').removeClass('saved');
			}, 1000);
		}
	});

})(jQuery);

