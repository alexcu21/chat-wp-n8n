<?php
/**
 * Settings Page - Main settings configuration
 *
 * @package Chat_for_n8n
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the settings page.
 * This is the existing settings content moved to a submenu.
 */
function chat_for_n8n_settings_page() {
	// Check permissions.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Display update messages if settings have been saved.
	if ( isset( $_GET['settings-updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		add_settings_error(
			'chat_for_n8n_messages',
			'chat_for_n8n_message',
			__( 'Settings saved successfully.', 'chat-for-n8n' ),
			'updated'
		);
	}

	settings_errors( 'chat_for_n8n_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'chat_for_n8n_settings_group' );
			do_settings_sections( 'chat_for_n8n_settings' );
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

