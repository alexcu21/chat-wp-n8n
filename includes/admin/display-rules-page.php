<?php
/**
 * Display Rules Page - Page targeting configuration
 *
 * @package Chat_for_n8n
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the display rules page.
 */
function chat_for_n8n_display_rules_page() {
	// Check permissions.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Get current rules or defaults.
	$rules = get_option( 'chat_for_n8n_display_rules', chat_for_n8n_default_display_rules() );

	// Display success message if settings saved.
	if ( isset( $_GET['settings-updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		add_settings_error(
			'chat_for_n8n_messages',
			'chat_for_n8n_message',
			__( 'Display rules saved successfully.', 'chat-for-n8n' ),
			'updated'
		);
	}

	settings_errors( 'chat_for_n8n_messages' );
	?>
	<div class="wrap chat-for-n8n-display-rules">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p class="description">
			<?php esc_html_e( 'Control where the chat widget appears on your website.', 'chat-for-n8n' ); ?>
		</p>

		<form method="post" action="options.php" id="display-rules-form">
			<?php settings_fields( 'chat_for_n8n_display_group' ); ?>

			<!-- Display Mode -->
			<div class="rules-section">
				<h2><?php esc_html_e( 'Display Mode', 'chat-for-n8n' ); ?></h2>
				<table class="form-table">
					<tr>
						<th scope="row"><?php esc_html_e( 'Where to display widget', 'chat-for-n8n' ); ?></th>
						<td>
							<fieldset>
								<label>
									<input type="radio" 
										   name="chat_for_n8n_display_rules[mode]" 
										   value="all"
										   <?php checked( $rules['mode'], 'all' ); ?>>
									<?php esc_html_e( 'Display on all pages', 'chat-for-n8n' ); ?>
								</label>
								<br>
								<label>
									<input type="radio" 
										   name="chat_for_n8n_display_rules[mode]" 
										   value="selected"
										   <?php checked( $rules['mode'], 'selected' ); ?>>
									<?php esc_html_e( 'Display only on selected pages', 'chat-for-n8n' ); ?>
								</label>
								<br>
								<label>
									<input type="radio" 
										   name="chat_for_n8n_display_rules[mode]" 
										   value="excluded"
										   <?php checked( $rules['mode'], 'excluded' ); ?>>
									<?php esc_html_e( 'Display on all pages except selected', 'chat-for-n8n' ); ?>
								</label>
							</fieldset>
						</td>
					</tr>
				</table>
			</div>

			<!-- Page Types -->
			<div class="rules-section page-type-rules" style="display: none;">
				<h2><?php esc_html_e( 'Page Types', 'chat-for-n8n' ); ?></h2>
				<table class="form-table">
					<tr>
						<th scope="row"><?php esc_html_e( 'Include on these page types', 'chat-for-n8n' ); ?></th>
						<td>
							<fieldset>
								<label>
									<input type="checkbox" 
										   name="chat_for_n8n_display_rules[include_types][homepage]" 
										   value="1"
										   <?php checked( $rules['include_types']['homepage'], true ); ?>>
									<?php esc_html_e( 'Homepage', 'chat-for-n8n' ); ?>
								</label>
								<br>
								<label>
									<input type="checkbox" 
										   name="chat_for_n8n_display_rules[include_types][posts]" 
										   value="1"
										   <?php checked( $rules['include_types']['posts'], true ); ?>>
									<?php esc_html_e( 'Single Posts', 'chat-for-n8n' ); ?>
								</label>
								<br>
								<label>
									<input type="checkbox" 
										   name="chat_for_n8n_display_rules[include_types][pages]" 
										   value="1"
										   <?php checked( $rules['include_types']['pages'], true ); ?>>
									<?php esc_html_e( 'Pages', 'chat-for-n8n' ); ?>
								</label>
								<br>
								<label>
									<input type="checkbox" 
										   name="chat_for_n8n_display_rules[include_types][archives]" 
										   value="1"
										   <?php checked( $rules['include_types']['archives'], true ); ?>>
									<?php esc_html_e( 'Archives (Categories, Tags, Dates)', 'chat-for-n8n' ); ?>
								</label>
								<br>
								<label>
									<input type="checkbox" 
										   name="chat_for_n8n_display_rules[include_types][search]" 
										   value="1"
										   <?php checked( $rules['include_types']['search'], true ); ?>>
									<?php esc_html_e( 'Search Results', 'chat-for-n8n' ); ?>
								</label>
								<br>
								<label>
									<input type="checkbox" 
										   name="chat_for_n8n_display_rules[include_types][404]" 
										   value="1"
										   <?php checked( $rules['include_types']['404'], true ); ?>>
									<?php esc_html_e( '404 Error Pages', 'chat-for-n8n' ); ?>
								</label>
							</fieldset>
						</td>
					</tr>
				</table>
			</div>

			<!-- Specific Pages -->
			<div class="rules-section specific-pages" style="display: none;">
				<h2><?php esc_html_e( 'Specific Selection', 'chat-for-n8n' ); ?></h2>
				<table class="form-table">
					<!-- Pages -->
					<tr>
						<th scope="row">
							<label for="selected-pages"><?php esc_html_e( 'Select Pages', 'chat-for-n8n' ); ?></label>
						</th>
						<td>
							<select name="chat_for_n8n_display_rules[selected_pages][]" 
									id="selected-pages"
									multiple 
									class="chat-page-selector" 
									style="width: 100%; max-width: 500px;">
								<?php
								$pages = get_pages( array( 'number' => 500 ) );
								foreach ( $pages as $page ) {
									$selected = in_array( (int) $page->ID, $rules['selected_pages'], true );
									printf(
										'<option value="%d" %s>%s</option>',
										esc_attr( $page->ID ),
										selected( $selected, true, false ),
										esc_html( $page->post_title )
									);
								}
								?>
							</select>
							<p class="description"><?php esc_html_e( 'Choose specific pages where the widget should appear.', 'chat-for-n8n' ); ?></p>
						</td>
					</tr>

					<!-- Posts -->
					<tr>
						<th scope="row">
							<label for="selected-posts"><?php esc_html_e( 'Select Posts', 'chat-for-n8n' ); ?></label>
						</th>
						<td>
							<select name="chat_for_n8n_display_rules[selected_posts][]" 
									id="selected-posts"
									multiple 
									class="chat-page-selector" 
									style="width: 100%; max-width: 500px;">
								<?php
								$posts = get_posts(
									array(
										'numberposts' => 500,
										'post_status' => 'publish',
									)
								);
								foreach ( $posts as $post ) {
									$selected = in_array( (int) $post->ID, $rules['selected_posts'], true );
									printf(
										'<option value="%d" %s>%s</option>',
										esc_attr( $post->ID ),
										selected( $selected, true, false ),
										esc_html( $post->post_title )
									);
								}
								?>
							</select>
							<p class="description"><?php esc_html_e( 'Choose specific posts where the widget should appear.', 'chat-for-n8n' ); ?></p>
						</td>
					</tr>

					<!-- Categories -->
					<tr>
						<th scope="row">
							<label for="selected-categories"><?php esc_html_e( 'Select Categories', 'chat-for-n8n' ); ?></label>
						</th>
						<td>
							<select name="chat_for_n8n_display_rules[selected_categories][]" 
									id="selected-categories"
									multiple 
									class="chat-page-selector" 
									style="width: 100%; max-width: 500px;">
								<?php
								$categories = get_categories( array( 'hide_empty' => false ) );
								foreach ( $categories as $category ) {
									$selected = in_array( (int) $category->term_id, $rules['selected_categories'], true );
									printf(
										'<option value="%d" %s>%s (%d posts)</option>',
										esc_attr( $category->term_id ),
										selected( $selected, true, false ),
										esc_html( $category->name ),
										esc_html( $category->count )
									);
								}
								?>
							</select>
							<p class="description"><?php esc_html_e( 'Widget will appear on posts in these categories.', 'chat-for-n8n' ); ?></p>
						</td>
					</tr>

					<!-- Tags -->
					<tr>
						<th scope="row">
							<label for="selected-tags"><?php esc_html_e( 'Select Tags', 'chat-for-n8n' ); ?></label>
						</th>
						<td>
							<select name="chat_for_n8n_display_rules[selected_tags][]" 
									id="selected-tags"
									multiple 
									class="chat-page-selector" 
									style="width: 100%; max-width: 500px;">
								<?php
								$tags = get_tags( array( 'hide_empty' => false ) );
								foreach ( $tags as $tag ) {
									$selected = in_array( (int) $tag->term_id, $rules['selected_tags'], true );
									printf(
										'<option value="%d" %s>%s (%d posts)</option>',
										esc_attr( $tag->term_id ),
										selected( $selected, true, false ),
										esc_html( $tag->name ),
										esc_html( $tag->count )
									);
								}
								?>
							</select>
							<p class="description"><?php esc_html_e( 'Widget will appear on posts with these tags.', 'chat-for-n8n' ); ?></p>
						</td>
					</tr>
				</table>
			</div>

			<!-- Excluded Pages -->
			<div class="rules-section excluded-pages" style="display: none;">
				<h2><?php esc_html_e( 'Excluded Pages', 'chat-for-n8n' ); ?></h2>
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="excluded-pages"><?php esc_html_e( 'Exclude Pages', 'chat-for-n8n' ); ?></label>
						</th>
						<td>
							<select name="chat_for_n8n_display_rules[excluded_pages][]" 
									id="excluded-pages"
									multiple 
									class="chat-page-selector" 
									style="width: 100%; max-width: 500px;">
								<?php
								$pages = get_pages( array( 'number' => 500 ) );
								foreach ( $pages as $page ) {
									$excluded = in_array( (int) $page->ID, $rules['excluded_pages'], true );
									printf(
										'<option value="%d" %s>%s</option>',
										esc_attr( $page->ID ),
										selected( $excluded, true, false ),
										esc_html( $page->post_title )
									);
								}
								?>
							</select>
							<p class="description"><?php esc_html_e( 'Widget will NOT appear on these pages.', 'chat-for-n8n' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="excluded-posts"><?php esc_html_e( 'Exclude Posts', 'chat-for-n8n' ); ?></label>
						</th>
						<td>
							<select name="chat_for_n8n_display_rules[excluded_posts][]" 
									id="excluded-posts"
									multiple 
									class="chat-page-selector" 
									style="width: 100%; max-width: 500px;">
								<?php
								$posts = get_posts(
									array(
										'numberposts' => 500,
										'post_status' => 'publish',
									)
								);
								foreach ( $posts as $post ) {
									$excluded = in_array( (int) $post->ID, $rules['excluded_posts'], true );
									printf(
										'<option value="%d" %s>%s</option>',
										esc_attr( $post->ID ),
										selected( $excluded, true, false ),
										esc_html( $post->post_title )
									);
								}
								?>
							</select>
							<p class="description"><?php esc_html_e( 'Widget will NOT appear on these posts.', 'chat-for-n8n' ); ?></p>
						</td>
					</tr>
				</table>
			</div>

			<!-- URL Rules -->
			<div class="rules-section url-rules-section">
				<h2><?php esc_html_e( 'Advanced URL Rules', 'chat-for-n8n' ); ?></h2>
				<p class="description">
					<?php esc_html_e( 'Create custom rules based on URL patterns. These rules take priority over other settings.', 'chat-for-n8n' ); ?>
				</p>
				
				<div id="url-rules-container">
					<?php if ( ! empty( $rules['url_rules'] ) ) : ?>
						<?php foreach ( $rules['url_rules'] as $index => $rule ) : ?>
							<div class="url-rule-row">
								<select name="chat_for_n8n_display_rules[url_rules][<?php echo esc_attr( $index ); ?>][type]" class="url-rule-type">
									<option value="contains" <?php selected( $rule['type'], 'contains' ); ?>><?php esc_html_e( 'URL Contains', 'chat-for-n8n' ); ?></option>
									<option value="starts_with" <?php selected( $rule['type'], 'starts_with' ); ?>><?php esc_html_e( 'URL Starts With', 'chat-for-n8n' ); ?></option>
									<option value="ends_with" <?php selected( $rule['type'], 'ends_with' ); ?>><?php esc_html_e( 'URL Ends With', 'chat-for-n8n' ); ?></option>
									<option value="matches" <?php selected( $rule['type'], 'matches' ); ?>><?php esc_html_e( 'URL Matches (regex)', 'chat-for-n8n' ); ?></option>
								</select>
								<input type="text" 
									   name="chat_for_n8n_display_rules[url_rules][<?php echo esc_attr( $index ); ?>][value]" 
									   value="<?php echo esc_attr( $rule['value'] ); ?>"
									   placeholder="<?php esc_attr_e( 'Enter value...', 'chat-for-n8n' ); ?>"
									   class="regular-text url-rule-value">
								<select name="chat_for_n8n_display_rules[url_rules][<?php echo esc_attr( $index ); ?>][action]" class="url-rule-action">
									<option value="show" <?php selected( $rule['action'], 'show' ); ?>><?php esc_html_e( 'Show', 'chat-for-n8n' ); ?></option>
									<option value="hide" <?php selected( $rule['action'], 'hide' ); ?>><?php esc_html_e( 'Hide', 'chat-for-n8n' ); ?></option>
								</select>
								<button type="button" class="button remove-url-rule">
									<?php esc_html_e( 'Remove', 'chat-for-n8n' ); ?>
								</button>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				
				<p>
					<button type="button" class="button button-secondary" id="add-url-rule">
						<span class="dashicons dashicons-plus-alt"></span>
						<?php esc_html_e( 'Add URL Rule', 'chat-for-n8n' ); ?>
					</button>
				</p>

				<div class="url-rules-help" style="margin-top: 20px; padding: 15px; background: #f0f0f1; border-left: 4px solid #2271b1;">
					<strong><?php esc_html_e( 'URL Rule Examples:', 'chat-for-n8n' ); ?></strong>
					<ul style="margin: 10px 0;">
						<li><strong><?php esc_html_e( 'Contains:', 'chat-for-n8n' ); ?></strong> <?php esc_html_e( '"contact" - matches /contact, /contact-us, /about/contact', 'chat-for-n8n' ); ?></li>
						<li><strong><?php esc_html_e( 'Starts With:', 'chat-for-n8n' ); ?></strong> <?php esc_html_e( '"/shop" - matches /shop, /shop/product, but not /my-shop', 'chat-for-n8n' ); ?></li>
						<li><strong><?php esc_html_e( 'Ends With:', 'chat-for-n8n' ); ?></strong> <?php esc_html_e( '".html" - matches /page.html, /file.html', 'chat-for-n8n' ); ?></li>
						<li><strong><?php esc_html_e( 'Matches (regex):', 'chat-for-n8n' ); ?></strong> <?php esc_html_e( '"/product-\d+/" - matches /product-123/, /product-456/', 'chat-for-n8n' ); ?></li>
					</ul>
				</div>
			</div>

			<?php submit_button( __( 'Save Display Rules', 'chat-for-n8n' ) ); ?>
		</form>
	</div>

	<script type="text/html" id="url-rule-template">
		<div class="url-rule-row">
			<select name="chat_for_n8n_display_rules[url_rules][__INDEX__][type]" class="url-rule-type">
				<option value="contains"><?php esc_html_e( 'URL Contains', 'chat-for-n8n' ); ?></option>
				<option value="starts_with"><?php esc_html_e( 'URL Starts With', 'chat-for-n8n' ); ?></option>
				<option value="ends_with"><?php esc_html_e( 'URL Ends With', 'chat-for-n8n' ); ?></option>
				<option value="matches"><?php esc_html_e( 'URL Matches (regex)', 'chat-for-n8n' ); ?></option>
			</select>
			<input type="text" 
				   name="chat_for_n8n_display_rules[url_rules][__INDEX__][value]" 
				   placeholder="<?php esc_attr_e( 'Enter value...', 'chat-for-n8n' ); ?>"
				   class="regular-text url-rule-value">
			<select name="chat_for_n8n_display_rules[url_rules][__INDEX__][action]" class="url-rule-action">
				<option value="show"><?php esc_html_e( 'Show', 'chat-for-n8n' ); ?></option>
				<option value="hide"><?php esc_html_e( 'Hide', 'chat-for-n8n' ); ?></option>
			</select>
			<button type="button" class="button remove-url-rule">
				<?php esc_html_e( 'Remove', 'chat-for-n8n' ); ?>
			</button>
		</div>
	</script>

	<style>
		.chat-for-n8n-display-rules .rules-section {
			background: #fff;
			padding: 20px;
			margin-bottom: 20px;
			border: 1px solid #ccd0d4;
			border-radius: 4px;
		}

		.rules-section h2 {
			margin-top: 0;
			font-size: 16px;
			font-weight: 600;
			border-bottom: 1px solid #f0f0f1;
			padding-bottom: 10px;
		}

		.url-rule-row {
			display: flex;
			gap: 10px;
			align-items: center;
			margin-bottom: 10px;
			padding: 10px;
			background: #f9f9f9;
			border-radius: 4px;
		}

		.url-rule-type,
		.url-rule-action {
			min-width: 150px;
		}

		.url-rule-value {
			flex: 1;
		}

		.remove-url-rule {
			color: #d63638;
		}

		.url-rules-help ul {
			list-style-type: disc;
			padding-left: 25px;
		}

		.url-rules-help li {
			margin: 8px 0;
		}

		@media (max-width: 782px) {
			.url-rule-row {
				flex-direction: column;
				align-items: stretch;
			}

			.url-rule-type,
			.url-rule-action,
			.url-rule-value {
				width: 100%;
			}
		}
	</style>
	<?php
}
