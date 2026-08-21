<?php
/**
 * Plugin Name:       Seer Reading List
 * Description:       Gutenberg block suite that renders a Seer-managed reading list via a query loop block with draggable item blocks.
 * Version:           1.0.1
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Author:            Jacob Andersen
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       seer-reading-list
 *
 * @package SeerReadingList
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/includes/settings.php';
require_once __DIR__ . '/includes/api.php';

/**
 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
 * based on the registered block metadata. Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function seer_reading_list_seer_reading_list_block_init() {
	wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
}
add_action( 'init', 'seer_reading_list_seer_reading_list_block_init' );
