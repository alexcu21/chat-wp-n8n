/**
 * Display Rules JavaScript
 * Handles conditional display of sections and dynamic URL rules
 * 
 * @package Chat_for_n8n
 */

(function($) {
	'use strict';

	let urlRuleIndex = 1000; // Start high to avoid conflicts with existing rules

	/**
	 * Shows/hides sections based on display mode
	 */
	function updateSectionVisibility() {
		const mode = $('input[name="chat_for_n8n_display_rules[mode]"]:checked').val();

		// Hide all conditional sections first
		$('.page-type-rules, .specific-pages, .excluded-pages').hide();

		// Show relevant sections based on mode
		if (mode === 'selected') {
			$('.page-type-rules, .specific-pages').show();
		} else if (mode === 'excluded') {
			$('.excluded-pages').show();
		}
	}

	/**
	 * Adds a new URL rule row
	 */
	function addUrlRule() {
		const template = $('#url-rule-template').html();
		
		if (!template) {
			console.error('URL rule template not found');
			return;
		}

		// Replace __INDEX__ with unique index
		const html = template.replace(/__INDEX__/g, urlRuleIndex);
		urlRuleIndex++;

		$('#url-rules-container').append(html);
		
		// Show success feedback
		const $newRule = $('#url-rules-container .url-rule-row:last');
		$newRule.hide().slideDown(300);
	}

	/**
	 * Removes a URL rule row
	 */
	function removeUrlRule(event) {
		const $row = $(event.target).closest('.url-rule-row');
		
		if (confirm(chatForN8nDisplayRules.removeConfirm || 'Remove this URL rule?')) {
			$row.slideUp(300, function() {
				$(this).remove();
				
				// Show message if no rules left
				if ($('#url-rules-container .url-rule-row').length === 0) {
					showNoRulesMessage();
				}
			});
		}
	}

	/**
	 * Shows a message when no URL rules exist
	 */
	function showNoRulesMessage() {
		const message = chatForN8nDisplayRules.noRulesMessage || 'No URL rules defined. Click "Add URL Rule" to create one.';
		const $message = $('<p class="no-rules-message" style="color: #646970; font-style: italic;">' + message + '</p>');
		
		$('#url-rules-container').append($message);
	}

	/**
	 * Initializes enhanced select dropdowns (if Select2 is available)
	 */
	function initializeSelects() {
		// Check if Select2 is available
		if (typeof $.fn.select2 !== 'undefined') {
			$('.chat-page-selector').select2({
				placeholder: chatForN8nDisplayRules.selectPlaceholder || 'Select...',
				allowClear: true,
				width: '100%'
			});
		} else {
			// Fallback: make native select more user-friendly
			$('.chat-page-selector').attr('size', '8');
		}
	}

	/**
	 * Initialize on document ready
	 */
	$(document).ready(function() {
		// Initial section visibility
		updateSectionVisibility();

		// Listen for mode changes
		$('input[name="chat_for_n8n_display_rules[mode]"]').on('change', updateSectionVisibility);

		// Add URL rule button
		$('#add-url-rule').on('click', addUrlRule);

		// Remove URL rule button (delegated event)
		$(document).on('click', '.remove-url-rule', removeUrlRule);

		// Initialize selects
		initializeSelects();

		// Show no rules message if container is empty
		if ($('#url-rules-container').children().length === 0) {
			showNoRulesMessage();
		} else {
			$('.no-rules-message').remove();
		}

		// Add form submission feedback
		$('#display-rules-form').on('submit', function() {
			const $submitButton = $(this).find('#submit');
			$submitButton.prop('disabled', true).val(chatForN8nDisplayRules.saving || 'Saving...');
		});

		// Help text toggle for regex
		$(document).on('change', '.url-rule-type', function() {
			const $row = $(this).closest('.url-rule-row');
			const $input = $row.find('.url-rule-value');
			
			if ($(this).val() === 'matches') {
				$input.attr('placeholder', '/pattern/');
			} else {
				$input.attr('placeholder', chatForN8nDisplayRules.valuePlaceholder || 'Enter value...');
			}
		});
	});

})(jQuery);

