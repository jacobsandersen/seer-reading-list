<?php
/**
 * Settings page and option storage for Seer Blocks.
 *
 * @package SeerBlocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const SEER_OPTION_URL   = 'seer_url';
const SEER_OPTION_TOKEN = 'seer_token';

// Legacy option keys from the pre-2.0 "Seer Reading List" plugin.
const SEER_LEGACY_OPTION_URL   = 'seer_reading_list_url';
const SEER_LEGACY_OPTION_TOKEN = 'seer_reading_list_token';

/**
 * Register the plugin settings.
 */
function seer_register_settings() {
	register_setting(
		'seer',
		SEER_OPTION_URL,
		array(
			'type'              => 'string',
			'sanitize_callback' => 'seer_sanitize_url',
		)
	);

	register_setting(
		'seer',
		SEER_OPTION_TOKEN,
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
}
add_action( 'admin_init', 'seer_register_settings' );

/**
 * Sanitize the Seer base URL.
 *
 * @param string $value Raw URL.
 * @return string Clean URL without a trailing slash.
 */
function seer_sanitize_url( $value ) {
	$value = esc_url_raw( $value );
	return $value ? untrailingslashit( $value ) : '';
}

/**
 * Register the settings page under Settings.
 */
function seer_register_settings_page() {
	add_options_page(
		__( 'Seer Blocks', 'seer' ),
		__( 'Seer Blocks', 'seer' ),
		'manage_options',
		'seer',
		'seer_render_settings_page'
	);
}
add_action( 'admin_menu', 'seer_register_settings_page' );

/**
 * Render the settings page.
 */
function seer_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Seer Blocks', 'seer' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'seer' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="seer_url"><?php esc_html_e( 'Seer URL', 'seer' ); ?></label>
					</th>
					<td>
						<input
							type="url"
							class="regular-text"
							id="seer_url"
							name="<?php echo esc_attr( SEER_OPTION_URL ); ?>"
							value="<?php echo esc_attr( get_option( SEER_OPTION_URL ) ); ?>"
							placeholder="https://seer.example.dev"
						/>
						<p class="description">
							<?php esc_html_e( 'The base URL of your Seer instance (no trailing slash).', 'seer' ); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="seer_token"><?php esc_html_e( 'Auth Token', 'seer' ); ?></label>
					</th>
					<td>
						<input
							type="password"
							class="regular-text"
							id="seer_token"
							name="<?php echo esc_attr( SEER_OPTION_TOKEN ); ?>"
							value="<?php echo esc_attr( get_option( SEER_OPTION_TOKEN ) ); ?>"
						/>
						<p class="description">
							<?php esc_html_e( 'Bearer token used to authenticate requests to Seer.', 'seer' ); ?>
						</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Get the configured Seer base URL.
 *
 * @return string
 */
function seer_get_url() {
	return (string) get_option( SEER_OPTION_URL, '' );
}

/**
 * Get the configured Seer auth token.
 *
 * @return string
 */
function seer_get_token() {
	return (string) get_option( SEER_OPTION_TOKEN, '' );
}

/**
 * Whether Seer connection settings have been configured.
 *
 * @return bool
 */
function seer_is_configured() {
	return '' !== seer_get_url() && '' !== seer_get_token();
}
