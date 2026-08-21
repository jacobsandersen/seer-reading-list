<?php
/**
 * Settings page for the Seer Reading List plugin.
 *
 * Stores the Seer base URL and the bearer token used to authenticate requests.
 *
 * @package SeerReadingList
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const SEER_READING_LIST_OPTION_URL   = 'seer_reading_list_url';
const SEER_READING_LIST_OPTION_TOKEN = 'seer_reading_list_token';

/**
 * Register the plugin settings.
 */
function seer_reading_list_register_settings() {
	register_setting(
		'seer_reading_list',
		SEER_READING_LIST_OPTION_URL,
		array(
			'type'              => 'string',
			'sanitize_callback' => 'seer_reading_list_sanitize_url',
		)
	);

	register_setting(
		'seer_reading_list',
		SEER_READING_LIST_OPTION_TOKEN,
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
}
add_action( 'admin_init', 'seer_reading_list_register_settings' );

/**
 * Sanitize the Seer base URL.
 *
 * @param string $value Raw URL.
 * @return string Clean URL without a trailing slash.
 */
function seer_reading_list_sanitize_url( $value ) {
	$value = esc_url_raw( $value );
	return $value ? untrailingslashit( $value ) : '';
}

/**
 * Register the settings page under Settings.
 */
function seer_reading_list_register_settings_page() {
	add_options_page(
		__( 'Seer Reading List', 'seer-reading-list' ),
		__( 'Seer Reading List', 'seer-reading-list' ),
		'manage_options',
		'seer-reading-list',
		'seer_reading_list_render_settings_page'
	);
}
add_action( 'admin_menu', 'seer_reading_list_register_settings_page' );

/**
 * Render the settings page.
 */
function seer_reading_list_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Seer Reading List', 'seer-reading-list' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'seer_reading_list' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="seer_reading_list_url"><?php esc_html_e( 'Seer URL', 'seer-reading-list' ); ?></label>
					</th>
					<td>
						<input
							type="url"
							class="regular-text"
							id="seer_reading_list_url"
							name="<?php echo esc_attr( SEER_READING_LIST_OPTION_URL ); ?>"
							value="<?php echo esc_attr( get_option( SEER_READING_LIST_OPTION_URL ) ); ?>"
							placeholder="https://seer.example.dev"
						/>
						<p class="description">
							<?php esc_html_e( 'The base URL of your Seer instance (no trailing slash).', 'seer-reading-list' ); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="seer_reading_list_token"><?php esc_html_e( 'Auth Token', 'seer-reading-list' ); ?></label>
					</th>
					<td>
						<input
							type="password"
							class="regular-text"
							id="seer_reading_list_token"
							name="<?php echo esc_attr( SEER_READING_LIST_OPTION_TOKEN ); ?>"
							value="<?php echo esc_attr( get_option( SEER_READING_LIST_OPTION_TOKEN ) ); ?>"
						/>
						<p class="description">
							<?php esc_html_e( 'Bearer token used to authenticate requests to Seer.', 'seer-reading-list' ); ?>
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
function seer_reading_list_get_url() {
	return (string) get_option( SEER_READING_LIST_OPTION_URL, '' );
}

/**
 * Get the configured Seer auth token.
 *
 * @return string
 */
function seer_reading_list_get_token() {
	return (string) get_option( SEER_READING_LIST_OPTION_TOKEN, '' );
}

/**
 * Whether Seer connection settings have been configured.
 *
 * @return bool
 */
function seer_reading_list_is_configured() {
	return '' !== seer_reading_list_get_url() && '' !== seer_reading_list_get_token();
}
