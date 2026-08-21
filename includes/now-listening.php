<?php
/**
 * Now Listening module: track data global access.
 *
 * @package SeerBlocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The image sizes offered by the Last.fm artwork endpoint, in ascending order.
 *
 * @return array<string>
 */
function seer_get_now_listening_image_sizes() {
	return array( 'small', 'medium', 'large', 'extralarge' );
}

/**
 * Get the current track being rendered inside the Now Listening block.
 *
 * Set by the track block render before rendering its inner blocks.
 *
 * @return array{title: string, url: string, artist: string, images: array<string,string>}
 */
function seer_get_current_track() {
	static $default = null;

	if ( null === $default ) {
		$default = array(
			'title'  => '',
			'url'    => '',
			'artist' => '',
			'images' => array(),
		);
	}

	return isset( $GLOBALS['seer_current_track'] ) && is_array( $GLOBALS['seer_current_track'] )
		? array_merge( $default, $GLOBALS['seer_current_track'] )
		: $default;
}
