<?php
/**
 * Plugin Name:       Seer Blocks
 * Description:       Gutenberg block suite for Seer: reading list query loop and Now Listening, with draggable item sub-blocks. Requests are proxied server-side so credentials never reach the browser.
 * Version:           2.0.0
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Author:            Jacob Andersen
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       seer
 *
 * @package SeerBlocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/includes/settings.php';
require_once __DIR__ . '/includes/seer-api.php';
require_once __DIR__ . '/includes/reading-list.php';
require_once __DIR__ . '/includes/now-listening.php';

/**
 * Register all block types found under build/.
 *
 * Blocks are organized in module sub-folders (reading-list/, now-listening/),
 * so instead of a single flat metadata manifest each block.json is discovered
 * recursively and registered individually. register_block_type() natively
 * resolves the "file:./..." script, style, and render references.
 */
function seer_register_blocks() {
	$iterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator(
			__DIR__ . '/build',
			FilesystemIterator::SKIP_DOTS
		)
	);

	foreach ( $iterator as $file ) {
		if ( 'block.json' === $file->getFilename() ) {
			register_block_type( $file->getPath() );
		}
	}
}
add_action( 'init', 'seer_register_blocks' );

/**
 * Migrate content and settings from the pre-2.0 "Seer Reading List" plugin.
 *
 * Runs once on activation. Block names in serialized post content are
 * rewritten from the seer-reading-list/* namespace to seer/reading-list/*,
 * block widget instances are rewritten in place, and the legacy settings
 * keys are carried over.
 */
function seer_migrate_v1_content_and_settings() {
	if ( get_option( 'seer_v2_migration_done' ) ) {
		return;
	}

	global $wpdb;

	// 1. Rewrite block names inside post content (posts, pages, reusable
	//    blocks, templates). Attributes inside the comments are untouched.
	$post_ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_content LIKE %s AND post_type != 'revision'",
			'%wp:seer-reading-list/%'
		)
	);

	$migrated_posts = 0;
	foreach ( $post_ids as $post_id ) {
		$content = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $post_id ) );
		$updated = str_replace( 'wp:seer-reading-list/', 'wp:seer/reading-list-', (string) $content );

		if ( $updated !== $content ) {
			$wpdb->update(
				$wpdb->posts,
				array( 'post_content' => $updated ),
				array( 'ID' => $post_id )
			);
			clean_post_cache( $post_id );
			++$migrated_posts;
		}
	}

	// 2. Rewrite block widget instances stored in the widget_block option.
	$migrated_widgets = 0;
	$widgets          = get_option( 'widget_block' );
	if ( is_array( $widgets ) ) {
		$widgets_json   = wp_json_encode( $widgets );
		$widgets_update = str_replace( 'wp:seer-reading-list/', 'wp:seer/reading-list-', (string) $widgets_json );

		if ( $widgets_update !== $widgets_json ) {
			update_option( 'widget_block', json_decode( $widgets_update, true ) );
			++$migrated_widgets;
		}
	}

	// 3. Carry over legacy settings keys.
	foreach (
		array(
			SEER_LEGACY_OPTION_URL   => SEER_OPTION_URL,
			SEER_LEGACY_OPTION_TOKEN => SEER_OPTION_TOKEN,
		) as $legacy_key => $new_key
	) {
		$legacy_value = get_option( $legacy_key );
		if ( false !== $legacy_value && null !== $legacy_value && '' === get_option( $new_key, '' ) ) {
			update_option( $new_key, $legacy_value );
		}
	}

	update_option( 'seer_v2_migration_done', true );
	update_option( 'seer_v2_migration_summary', array( 'posts' => $migrated_posts, 'widgets' => $migrated_widgets ) );
}
register_activation_hook( __FILE__, 'seer_migrate_v1_content_and_settings' );

/**
 * Show a one-time summary of what the activation migration changed.
 */
function seer_migration_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$summary = get_option( 'seer_v2_migration_summary' );
	if ( ! is_array( $summary ) || ! isset( $summary['posts'], $summary['widgets'] ) ) {
		return;
	}

	delete_option( 'seer_v2_migration_summary' );

	printf(
		'<div class="notice notice-info is-dismissible"><p>%1$s</p></div>',
		esc_html(
			sprintf(
				/* translators: 1: number of posts migrated, 2: number of widgets migrated. */
				_n(
					'Seer Blocks: migrated %1$d piece of content and %2$d widget to the new block names.',
					'Seer Blocks: migrated %1$d pieces of content and %2$d widgets to the new block names.',
					(int) $summary['posts'],
					'seer'
				),
				(int) $summary['posts'],
				(int) $summary['widgets']
			)
		)
	);
}
add_action( 'admin_notices', 'seer_migration_notice' );
