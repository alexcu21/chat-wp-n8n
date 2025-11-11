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

		// Apply colors to preview
		const $preview = $('#chat-preview-container');
		
		// Widget background
		$preview.css('background-color', colors.background);
		
		// Header
		$preview.find('.preview-header').css({
			'background-color': colors.headerBg,
			'color': colors.headerText
		});
		
		// Messages container
		$preview.find('.preview-messages').css({
			'background-color': colors.background
		});
		
		// Bot messages
		$preview.find('.bot-message .message-bubble').css({
			'background-color': colors.botMessageBg,
			'color': colors.botMessageText
		});
		
		// User messages
		$preview.find('.user-message .message-bubble').css({
			'background-color': colors.userMessageBg,
			'color': colors.userMessageText
		});
		
		// Input field
		$preview.find('.preview-input input').css({
			'background-color': colors.inputBg,
			'border-color': colors.inputBorder,
			'color': colors.inputText
		});
		
		// Input placeholder (using a trick with ::placeholder)
		const placeholderStyle = `
			#chat-preview-container .preview-input input::placeholder {
				color: ${colors.placeholderText};
				opacity: 1;
			}
			#chat-preview-container .preview-input input::-webkit-input-placeholder {
				color: ${colors.placeholderText};
			}
			#chat-preview-container .preview-input input::-moz-placeholder {
				color: ${colors.placeholderText};
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
		$preview.find('.preview-send-button').css({
			'background-color': colors.sendButton
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

