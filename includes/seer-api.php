<?php
/**
 * Generic authenticated client for the Seer API.
 *
 * @package SeerBlocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Perform an authenticated GET request against a Seer API path.
 *
 * @param string $path API path beginning with a slash, e.g. "/hardcover/books".
 * @param array  $args Query arguments appended to the URL.
 * @return array{message: string, data: mixed}|WP_Error Decoded response body.
 */
function seer_api_get( $path, $args = array() ) {
	if ( ! seer_is_configured() ) {
		return new WP_Error(
			'seer_not_configured',
			__( 'Seer has not been configured. Add the URL and auth token under Settings → Seer Blocks.', 'seer' )
		);
	}

	$url = add_query_arg( $args, trailingslashit( seer_get_url() ) . ltrim( $path, '/' ) );

	$response = wp_remote_get(
		$url,
		array(
			'timeout' => 15,
			'headers' => array(
				'Authorization' => 'Bearer ' . seer_get_token(),
				'Accept'        => 'application/json',
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$code = wp_remote_retrieve_response_code( $response );
	if ( $code < 200 || $code >= 300 ) {
		return new WP_Error(
			'seer_http_error',
			sprintf(
				/* translators: %d: HTTP status code. */
				__( 'Seer returned an unexpected status code: %d.', 'seer' ),
				$code
			)
		);
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( ! is_array( $body ) || ! isset( $body['message'] ) ) {
		return new WP_Error( 'seer_invalid_response', __( 'Seer returned an invalid response.', 'seer' ) );
	}

	return $body;
}

/**
 * Fetch a page of books from Seer.
 *
 * @param string $component One of seer_get_reading_list_components().
 * @param int    $page      Page number (1-indexed).
 * @param int    $limit     Books per page.
 * @return array{books: array, pagination: array}|WP_Error
 */
function seer_fetch_books( $component, $page, $limit ) {
	if ( ! in_array( $component, seer_get_reading_list_components(), true ) ) {
		return new WP_Error( 'seer_invalid_component', __( 'Invalid Seer component.', 'seer' ) );
	}

	$body = seer_api_get(
		'/hardcover/books',
		array(
			'status' => $component,
			'page'   => max( 1, (int) $page ),
			'limit'  => max( 1, min( 50, (int) $limit ) ),
		)
	);

	if ( is_wp_error( $body ) ) {
		return $body;
	}

	if ( ! isset( $body['data']['books'] ) || ! is_array( $body['data']['books'] ) ) {
		return new WP_Error( 'seer_invalid_response', __( 'Seer returned an invalid response.', 'seer' ) );
	}

	return array(
		'books'      => $body['data']['books'],
		'pagination' => isset( $body['data']['pagination'] ) && is_array( $body['data']['pagination'] )
			? $body['data']['pagination']
			: array(
				'current_page' => 1,
				'total_pages'  => 1,
			),
	);
}

/**
 * Fetch the track currently being listened to.
 *
 * Returns a normalized track payload, an empty array when nothing is playing
 * (the API responds successfully with null data), or WP_Error on failure.
 *
 * @return array{title: string, url: string, artist: string, images: array<string,string>}|array|WP_Error
 */
function seer_fetch_now_listening() {
	$body = seer_api_get( '/lastfm' );

	if ( is_wp_error( $body ) ) {
		return $body;
	}

	if ( empty( $body['data'] ) || empty( $body['data']['name'] ) ) {
		return array();
	}

	$data   = $body['data'];
	$images = array();
	foreach ( (array) ( $data['image'] ?? array() ) as $image ) {
		if ( ! empty( $image['size'] ) && isset( $image['#text'] ) && '' !== $image['#text'] ) {
			$images[ $image['size'] ] = (string) $image['#text'];
		}
	}

	return array(
		'title'  => (string) $data['name'],
		'url'    => isset( $data['url'] ) ? (string) $data['url'] : '',
		'artist' => isset( $data['artist']['#text'] ) ? (string) $data['artist']['#text'] : '',
		'images' => $images,
	);
}
