<?php
/**
 * Dashboard Page - Main overview page for Chat for n8n
 *
 * @package Chat_for_n8n
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the dashboard page.
 */
function chat_for_n8n_dashboard_page() {
	// Check permissions.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$webhook_url = get_option( 'n8n_chat_webhook_url' );
	$is_configured = ! empty( $webhook_url );
	$widget_mode = get_option( 'n8n_chat_widget_mode', 'window' );
	?>
	<div class="wrap chat-for-n8n-dashboard">
		<h1><?php esc_html_e( 'Chat for n8n Dashboard', 'chat-for-n8n' ); ?></h1>
		
		<div class="chat-dashboard-grid">
			<!-- Widget Status Card -->
			<div class="chat-dashboard-card">
				<h2><?php esc_html_e( 'Widget Status', 'chat-for-n8n' ); ?></h2>
				
				<?php if ( $is_configured ) : ?>
					<div class="status-indicator status-active">
						<span class="dashicons dashicons-yes-alt"></span>
						<strong><?php esc_html_e( 'Active', 'chat-for-n8n' ); ?></strong>
					</div>
					<p><?php esc_html_e( 'Your chat widget is configured and ready.', 'chat-for-n8n' ); ?></p>
					<ul class="widget-info">
						<li>
							<strong><?php esc_html_e( 'Webhook URL:', 'chat-for-n8n' ); ?></strong>
							<br>
							<code><?php echo esc_html( substr( $webhook_url, 0, 50 ) . '...' ); ?></code>
						</li>
						<li>
							<strong><?php esc_html_e( 'Display Mode:', 'chat-for-n8n' ); ?></strong>
							<?php echo esc_html( ucfirst( $widget_mode ) ); ?>
						</li>
					</ul>
				<?php else : ?>
					<div class="status-indicator status-inactive">
						<span class="dashicons dashicons-warning"></span>
						<strong><?php esc_html_e( 'Not Configured', 'chat-for-n8n' ); ?></strong>
					</div>
					<p><?php esc_html_e( 'Please configure your webhook URL to activate the chat widget.', 'chat-for-n8n' ); ?></p>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=chat-for-n8n-settings' ) ); ?>" class="button button-primary">
						<?php esc_html_e( 'Configure Now', 'chat-for-n8n' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<!-- Quick Actions Card -->
			<div class="chat-dashboard-card">
				<h2><?php esc_html_e( 'Quick Actions', 'chat-for-n8n' ); ?></h2>
				<div class="quick-actions">
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=chat-for-n8n-settings' ) ); ?>" class="quick-action-link">
						<span class="dashicons dashicons-admin-settings"></span>
						<?php esc_html_e( 'Settings', 'chat-for-n8n' ); ?>
					</a>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=chat-for-n8n-appearance' ) ); ?>" class="quick-action-link">
						<span class="dashicons dashicons-admin-appearance"></span>
						<?php esc_html_e( 'Appearance', 'chat-for-n8n' ); ?>
					</a>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=chat-for-n8n-display-rules' ) ); ?>" class="quick-action-link">
						<span class="dashicons dashicons-visibility"></span>
						<?php esc_html_e( 'Display Rules', 'chat-for-n8n' ); ?>
					</a>
				</div>
			</div>

			<!-- Getting Started Card -->
			<div class="chat-dashboard-card">
				<h2><?php esc_html_e( 'Getting Started', 'chat-for-n8n' ); ?></h2>
				<ol class="getting-started-steps">
					<li>
						<strong><?php esc_html_e( 'Create n8n Workflow', 'chat-for-n8n' ); ?></strong>
						<p><?php esc_html_e( 'Set up a workflow in n8n with a "Chat Trigger" node.', 'chat-for-n8n' ); ?></p>
					</li>
					<li>
						<strong><?php esc_html_e( 'Configure Webhook', 'chat-for-n8n' ); ?></strong>
						<p><?php esc_html_e( 'Copy the webhook URL and paste it in Settings.', 'chat-for-n8n' ); ?></p>
					</li>
					<li>
						<strong><?php esc_html_e( 'Customize Appearance', 'chat-for-n8n' ); ?></strong>
						<p><?php esc_html_e( 'Personalize colors and styling to match your brand.', 'chat-for-n8n' ); ?></p>
					</li>
					<li>
						<strong><?php esc_html_e( 'Set Display Rules', 'chat-for-n8n' ); ?></strong>
						<p><?php esc_html_e( 'Choose where the widget appears on your site.', 'chat-for-n8n' ); ?></p>
					</li>
				</ol>
			</div>

			<!-- Documentation Card -->
			<div class="chat-dashboard-card">
				<h2><?php esc_html_e( 'Documentation & Support', 'chat-for-n8n' ); ?></h2>
				<div class="documentation-links">
					<a href="https://docs.n8n.io/integrations/builtin/core-nodes/n8n-nodes-langchain.chattrigger/" target="_blank" rel="noopener noreferrer">
						<span class="dashicons dashicons-book"></span>
						<?php esc_html_e( 'n8n Chat Trigger Documentation', 'chat-for-n8n' ); ?>
					</a>
					<a href="https://n8n.io/" target="_blank" rel="noopener noreferrer">
						<span class="dashicons dashicons-external"></span>
						<?php esc_html_e( 'Visit n8n.io', 'chat-for-n8n' ); ?>
					</a>
					<a href="https://alexcuadra.dev" target="_blank" rel="noopener noreferrer">
						<span class="dashicons dashicons-admin-users"></span>
						<?php esc_html_e( 'Plugin Author', 'chat-for-n8n' ); ?>
					</a>
				</div>
			</div>
		</div>

		<style>
			.chat-for-n8n-dashboard {
				max-width: 1200px;
			}
			.chat-dashboard-grid {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
				gap: 20px;
				margin-top: 20px;
			}
			.chat-dashboard-card {
				background: #fff;
				border: 1px solid #ccd0d4;
				border-radius: 4px;
				padding: 20px;
				box-shadow: 0 1px 1px rgba(0,0,0,0.04);
			}
			.chat-dashboard-card h2 {
				margin-top: 0;
				font-size: 16px;
				border-bottom: 1px solid #eee;
				padding-bottom: 10px;
			}
			.status-indicator {
				display: flex;
				align-items: center;
				gap: 10px;
				padding: 15px;
				border-radius: 4px;
				margin: 15px 0;
			}
			.status-active {
				background: #d4edda;
				color: #155724;
			}
			.status-inactive {
				background: #fff3cd;
				color: #856404;
			}
			.status-indicator .dashicons {
				font-size: 24px;
				width: 24px;
				height: 24px;
			}
			.widget-info {
				list-style: none;
				padding: 0;
				margin: 15px 0;
			}
			.widget-info li {
				padding: 10px 0;
				border-bottom: 1px solid #eee;
			}
			.widget-info li:last-child {
				border-bottom: none;
			}
			.quick-actions {
				display: grid;
				gap: 10px;
				margin-top: 15px;
			}
			.quick-action-link {
				display: flex;
				align-items: center;
				gap: 10px;
				padding: 12px 15px;
				background: #f0f0f1;
				border-radius: 4px;
				text-decoration: none;
				color: #2271b1;
				transition: background 0.2s;
			}
			.quick-action-link:hover {
				background: #e5e5e5;
			}
			.quick-action-link .dashicons {
				color: #2271b1;
			}
			.getting-started-steps {
				padding-left: 20px;
				margin: 15px 0;
			}
			.getting-started-steps li {
				margin-bottom: 15px;
			}
			.getting-started-steps strong {
				display: block;
				margin-bottom: 5px;
			}
			.getting-started-steps p {
				margin: 0;
				color: #646970;
				font-size: 13px;
			}
			.documentation-links {
				display: flex;
				flex-direction: column;
				gap: 10px;
				margin-top: 15px;
			}
			.documentation-links a {
				display: flex;
				align-items: center;
				gap: 8px;
				padding: 10px;
				text-decoration: none;
				color: #2271b1;
				border-left: 3px solid #2271b1;
				background: #f6f7f7;
				transition: all 0.2s;
			}
			.documentation-links a:hover {
				background: #e5e5e5;
				padding-left: 15px;
			}
		</style>
	</div>
	<?php
}

