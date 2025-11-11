<?php
/**
 * Appearance Page - Color customization
 *
 * @package Chat_for_n8n
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the appearance page with color customization.
 */
function chat_for_n8n_appearance_page() {
	// Check permissions.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Get current colors or defaults.
	$colors = get_option( 'chat_for_n8n_colors', chat_for_n8n_default_colors() );

	// Display success message if settings saved.
	if ( isset( $_GET['settings-updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		add_settings_error(
			'chat_for_n8n_messages',
			'chat_for_n8n_message',
			__( 'Colors saved successfully.', 'chat-for-n8n' ),
			'updated'
		);
	}

	settings_errors( 'chat_for_n8n_messages' );
	?>
	<div class="wrap chat-for-n8n-appearance">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p class="description">
			<?php esc_html_e( 'Customize the colors of your chat widget to match your brand.', 'chat-for-n8n' ); ?>
		</p>

		<div class="chat-appearance-container">
			<!-- Color Settings Form -->
			<div class="color-settings-panel">
				<form method="post" action="options.php" id="color-settings-form">
					<?php
					settings_fields( 'chat_for_n8n_appearance_group' );
					?>
					
					<!-- Primary Colors -->
					<div class="color-section">
						<h2><?php esc_html_e( 'Primary Colors', 'chat-for-n8n' ); ?></h2>
						<table class="form-table">
							<tr>
								<th scope="row">
									<label for="color-background"><?php esc_html_e( 'Background Color', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-background"
										   name="chat_for_n8n_colors[background]" 
										   value="<?php echo esc_attr( $colors['background'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['background'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Main chat window background', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="color-primary"><?php esc_html_e( 'Primary Color', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-primary"
										   name="chat_for_n8n_colors[primary]" 
										   value="<?php echo esc_attr( $colors['primary'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['primary'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Buttons and active states', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="color-text"><?php esc_html_e( 'Text Color', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-text"
										   name="chat_for_n8n_colors[text]" 
										   value="<?php echo esc_attr( $colors['text'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['text'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Main text color', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
						</table>
					</div>

					<!-- Message Colors -->
					<div class="color-section">
						<h2><?php esc_html_e( 'Message Colors', 'chat-for-n8n' ); ?></h2>
						<table class="form-table">
							<tr>
								<th scope="row">
									<label for="color-bot-message-bg"><?php esc_html_e( 'Bot Message Background', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-bot-message-bg"
										   name="chat_for_n8n_colors[bot_message_bg]" 
										   value="<?php echo esc_attr( $colors['bot_message_bg'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['bot_message_bg'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Background color for bot messages', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="color-bot-message-text"><?php esc_html_e( 'Bot Message Text', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-bot-message-text"
										   name="chat_for_n8n_colors[bot_message_text]" 
										   value="<?php echo esc_attr( $colors['bot_message_text'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['bot_message_text'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Text color in bot messages', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="color-user-message-bg"><?php esc_html_e( 'User Message Background', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-user-message-bg"
										   name="chat_for_n8n_colors[user_message_bg]" 
										   value="<?php echo esc_attr( $colors['user_message_bg'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['user_message_bg'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Background color for user messages', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="color-user-message-text"><?php esc_html_e( 'User Message Text', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-user-message-text"
										   name="chat_for_n8n_colors[user_message_text]" 
										   value="<?php echo esc_attr( $colors['user_message_text'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['user_message_text'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Text color in user messages', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
						</table>
					</div>

					<!-- Header Colors -->
					<div class="color-section">
						<h2><?php esc_html_e( 'Header Colors', 'chat-for-n8n' ); ?></h2>
						<table class="form-table">
							<tr>
								<th scope="row">
									<label for="color-header-bg"><?php esc_html_e( 'Header Background', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-header-bg"
										   name="chat_for_n8n_colors[header_bg]" 
										   value="<?php echo esc_attr( $colors['header_bg'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['header_bg'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Chat header background color', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="color-header-text"><?php esc_html_e( 'Header Text', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-header-text"
										   name="chat_for_n8n_colors[header_text]" 
										   value="<?php echo esc_attr( $colors['header_text'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['header_text'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Text color in header', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
						</table>
					</div>

					<!-- Input Colors -->
					<div class="color-section">
						<h2><?php esc_html_e( 'Input Colors', 'chat-for-n8n' ); ?></h2>
						<table class="form-table">
							<tr>
								<th scope="row">
									<label for="color-input-bg"><?php esc_html_e( 'Input Background', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-input-bg"
										   name="chat_for_n8n_colors[input_bg]" 
										   value="<?php echo esc_attr( $colors['input_bg'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['input_bg'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Message input field background', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="color-input-border"><?php esc_html_e( 'Input Border', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-input-border"
										   name="chat_for_n8n_colors[input_border]" 
										   value="<?php echo esc_attr( $colors['input_border'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['input_border'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Input field border color', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="color-input-text"><?php esc_html_e( 'Input Text', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-input-text"
										   name="chat_for_n8n_colors[input_text]" 
										   value="<?php echo esc_attr( $colors['input_text'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['input_text'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Text color in input field', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="color-placeholder-text"><?php esc_html_e( 'Placeholder Text', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-placeholder-text"
										   name="chat_for_n8n_colors[placeholder_text]" 
										   value="<?php echo esc_attr( $colors['placeholder_text'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['placeholder_text'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Input placeholder text color', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="color-send-button"><?php esc_html_e( 'Send Button', 'chat-for-n8n' ); ?></label>
								</th>
								<td>
									<input type="text" 
										   id="color-send-button"
										   name="chat_for_n8n_colors[send_button]" 
										   value="<?php echo esc_attr( $colors['send_button'] ); ?>"
										   class="chat-color-picker"
										   data-default-color="<?php echo esc_attr( chat_for_n8n_default_colors()['send_button'] ); ?>" />
									<p class="description"><?php esc_html_e( 'Send button color', 'chat-for-n8n' ); ?></p>
								</td>
							</tr>
						</table>
					</div>

					<!-- Form Actions -->
					<div class="form-actions">
						<button type="button" class="button button-secondary" id="reset-colors">
							<?php esc_html_e( 'Reset to Defaults', 'chat-for-n8n' ); ?>
						</button>
						<?php submit_button( __( 'Save Colors', 'chat-for-n8n' ), 'primary', 'submit', false ); ?>
					</div>
				</form>
			</div>

			<!-- Live Preview Panel -->
			<div class="color-preview-panel">
				<h2><?php esc_html_e( 'Live Preview', 'chat-for-n8n' ); ?></h2>
				<p class="description">
					<?php esc_html_e( 'See your color changes in real-time', 'chat-for-n8n' ); ?>
				</p>
				
				<div id="chat-preview-container" class="chat-window-wrapper n8n-chat">
				<div class="chat-window">
				<div class="chat-layout">
					<!-- Chat Header -->
					<div class="chat-header">
						<div class="chat-heading">
							<div>
								<h1 style="margin: 0; font-size: 1.2em; font-weight: 600;"><?php echo esc_html( get_option( 'n8n_chat_widget_title', 'Chat' ) ); ?></h1>
								<?php if ( get_option( 'n8n_chat_widget_subtitle' ) ) : ?>
									<p style="margin: 0; font-size: 0.9em; opacity: 0.9;"><?php echo esc_html( get_option( 'n8n_chat_widget_subtitle', '' ) ); ?></p>
								<?php endif; ?>
							</div>
							<button class="chat-close-button" type="button" disabled>
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M18 6L6 18M6 6l12 12"/>
								</svg>
							</button>
						</div>
					</div>
					
					<!-- Chat Body (Messages) -->
					<div class="chat-body">
						<div class="chat-messages-list">
							<!-- Bot Message -->
							<div class="chat-message chat-message-from-bot">
								<div class="chat-message-markdown">
									<p><?php esc_html_e( 'Hello! How can I help you today?', 'chat-for-n8n' ); ?></p>
								</div>
							</div>
							
							<!-- User Message -->
							<div class="chat-message chat-message-from-user">
								<div class="chat-message-markdown">
									<p><?php esc_html_e( 'I have a question about your services.', 'chat-for-n8n' ); ?></p>
								</div>
							</div>
							
							<!-- Bot Message -->
							<div class="chat-message chat-message-from-bot">
								<div class="chat-message-markdown">
									<p><?php esc_html_e( 'I\'d be happy to help! What would you like to know?', 'chat-for-n8n' ); ?></p>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Chat Footer (Input) -->
					<div class="chat-footer">
						<div class="chat-input">
							<div class="chat-inputs">
								<textarea placeholder="<?php echo esc_attr( get_option( 'n8n_chat_widget_input_placeholder', 'Type your message...' ) ); ?>" disabled rows="1"></textarea>
								<div class="chat-inputs-controls">
									<button class="chat-input-send-button" type="button" disabled>
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
										</svg>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
