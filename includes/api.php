<?php
/**
 * Seer API integration: configuration and fetching.
 *
 * @package SeerReadingList
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Seer components this plugin can render.
 *
 * @return array<string>
 */
function seer_reading_list_get_components() {
	return array( 'read', 'current', 'wanted' );
}

/**
 * The Seer books endpoint path.
 *
 * @return string
 */
function seer_reading_list_endpoint() {
	return '/hardcover/books';
}

/**
 * Fetch a page of books from Seer.
 *
 * @param string $component One of seer_reading_list_get_components().
 * @param int    $page      Page number (1-indexed).
 * @param int    $limit     Books per page.
 * @return array{books: array, pagination: array}|WP_Error
 */
function seer_reading_list_fetch_books( $component, $page, $limit ) {
	if ( ! seer_reading_list_is_configured() ) {
		return new WP_Error(
			'seer_not_configured',
			__( 'Seer has not been configured. Add the URL and auth token under Settings → Seer Reading List.', 'seer-reading-list' )
		);
	}

	if ( ! in_array( $component, seer_reading_list_get_components(), true ) ) {
		return new WP_Error( 'seer_invalid_component', __( 'Invalid Seer component.', 'seer-reading-list' ) );
	}

	$url = add_query_arg(
		array(
			'status' => $component,
			'page'   => max( 1, (int) $page ),
			'limit'  => max( 1, min( 50, (int) $limit ) ),
		),
		trailingslashit( seer_reading_list_get_url() ) . ltrim( seer_reading_list_endpoint(), '/' )
	);

	$response = wp_remote_get(
		$url,
		array(
			'timeout' => 15,
			'headers' => array(
				'Authorization' => 'Bearer ' . seer_reading_list_get_token(),
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
				__( 'Seer returned an unexpected status code: %d.', 'seer-reading-list' ),
				$code
			)
		);
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( ! is_array( $body ) || ! isset( $body['data']['books'] ) || ! is_array( $body['data']['books'] ) ) {
		return new WP_Error( 'seer_invalid_response', __( 'Seer returned an invalid response.', 'seer-reading-list' ) );
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
 * Get the current book being rendered inside the query loop.
 *
 * Set by the query block render before rendering each item's inner blocks.
 *
 * @return array
 */
function seer_reading_list_get_book() {
	return isset( $GLOBALS['seer_reading_list_book'] ) && is_array( $GLOBALS['seer_reading_list_book'] )
		? $GLOBALS['seer_reading_list_book']
		: array();
}

/**
 * Get the current pagination state for the query loop.
 *
 * Set by the query block render before rendering the pagination block.
 *
 * @return array
 */
function seer_reading_list_get_pagination() {
	return isset( $GLOBALS['seer_reading_list_pagination'] ) && is_array( $GLOBALS['seer_reading_list_pagination'] )
		? $GLOBALS['seer_reading_list_pagination']
		: array();
}

/**
 * Render pagination links (inner content only) for a query block instance.
 *
 * @param int    $page     Current page.
 * @param int    $total    Total pages.
 * @param string $page_arg The per-instance query arg name.
 * @return string
 */
function seer_reading_list_render_pagination( $page, $total, $page_arg ) {
	// Note: omit the second arg so add_query_arg() bases the URL on
	// $_SERVER['REQUEST_URI'] and preserves the other query args (passing ''
	// would start from an empty URL and drop e.g. another block's page arg).
	$prev_href = $page > 1 ? add_query_arg( array( $page_arg => $page - 1 ) ) : '';
	$next_href = $page < $total ? add_query_arg( array( $page_arg => $page + 1 ) ) : '';

	$prev = $prev_href
		? '<a class="seer-reading-list__prev" href="' . esc_url( $prev_href ) . '">' . esc_html__( 'Previous', 'seer-reading-list' ) . '</a>'
		: '<span class="seer-reading-list__prev" aria-disabled="true">' . esc_html__( 'Previous', 'seer-reading-list' ) . '</span>';

	$next = $next_href
		? '<a class="seer-reading-list__next" href="' . esc_url( $next_href ) . '">' . esc_html__( 'Next', 'seer-reading-list' ) . '</a>'
		: '<span class="seer-reading-list__next" aria-disabled="true">' . esc_html__( 'Next', 'seer-reading-list' ) . '</span>';

	return sprintf(
		'%1$s<span class="seer-reading-list__page">%2$s</span>%3$s',
		$prev,
		sprintf(
			/* translators: 1: current page, 2: total pages. */
			esc_html__( 'Page %1$d of %2$d', 'seer-reading-list' ),
			(int) $page,
			(int) $total
		),
		$next
	);
}
