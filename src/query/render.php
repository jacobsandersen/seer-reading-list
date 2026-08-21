<?php
/**
 * Renders the Seer Book Query block on the front end.
 *
 * Fetches a page of books from Seer and renders the saved inner item blocks
 * once per book. Each book is exposed to item blocks through a request-scoped
 * global (mirroring how the core Query Loop passes the post via the global
 * `$post`), which avoids reconstructing WP_Block instances at render time.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$component = isset( $attributes['component'] ) ? (string) $attributes['component'] : 'current';
$limit     = isset( $attributes['limit'] ) ? (int) $attributes['limit'] : 10;
$columns   = isset( $attributes['columns'] ) ? (int) $attributes['columns'] : 1;

$instance = ( isset( $attributes['uid'] ) && '' !== $attributes['uid'] )
	? (string) $attributes['uid']
	: wp_unique_id( 'seer-reading-list-' );
$page_arg = 'seer-reading-list-page-' . $instance;
$page     = isset( $_GET[ $page_arg ] ) ? max( 1, (int) $_GET[ $page_arg ] ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

$result = seer_reading_list_fetch_books( $component, $page, $limit );

if ( is_wp_error( $result ) ) {
	echo '<div ' . get_block_wrapper_attributes( array( 'class' => 'seer-reading-list' ) ) . '><p class="seer-reading-list__error">' . esc_html( $result->get_error_message() ) . '</p></div>';
	return;
}

$total_pages = (int) $result['pagination']['total_pages'];

// Clamp to a valid page range (refetch only if the requested page was out of range).
if ( $page > $total_pages ) {
	$page = max( 1, $total_pages );
	$result = seer_reading_list_fetch_books( $component, $page, $limit );
	if ( is_wp_error( $result ) ) {
		echo '<div ' . get_block_wrapper_attributes( array( 'class' => 'seer-reading-list' ) ) . '><p class="seer-reading-list__error">' . esc_html( $result->get_error_message() ) . '</p></div>';
		return;
	}
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class'           => 'seer-reading-list',
		'style'           => '--srl-cols:' . $columns . ';',
		'data-component'  => $component,
		'data-page'       => $page,
		'data-total'      => $total_pages,
		'data-limit'      => $limit,
	)
);

$books = $result['books'];

if ( empty( $books ) ) {
	echo '<div ' . $wrapper_attributes . '><p class="seer-reading-list__empty">' . esc_html__( 'No books found.', 'seer-reading-list' ) . '</p></div>';
	return;
}


// Direct inner blocks, excluding the pagination block (rendered once after the loop).
$item_blocks = array();
$pagination_block = null;
foreach ( $block->inner_blocks as $inner_block ) {
	if ( 'seer-reading-list/pagination' === $inner_block->name ) {
		$pagination_block = $inner_block;
	} else {
		$item_blocks[] = $inner_block;
	}
}

$items = '';
foreach ( $books as $book ) {
	// Expose the current book to item blocks via a request-scoped global.
	$GLOBALS['seer_reading_list_book'] = $book;

	$inner_html = '';
	foreach ( $item_blocks as $item_block ) {
		// Pass the parsed block array: render_block() forwards its argument to
		// the pre_render_block filter, which core expects to be an array (a
		// WP_Block instance crashes _wp_add_block_level_preset_styles()).
		$inner_html .= render_block( $item_block->parsed_block );
	}

	$items .= '<li class="seer-reading-list__item">' . $inner_html . '</li>';
}

unset( $GLOBALS['seer_reading_list_book'] );

$html = '<ul class="seer-reading-list__grid">' . $items . '</ul>';

if ( $pagination_block ) {
	$GLOBALS['seer_reading_list_pagination'] = array(
		'page'     => $page,
		'total'    => $total_pages,
		'page_arg' => $page_arg,
	);

	$html .= render_block( $pagination_block->parsed_block );

	unset( $GLOBALS['seer_reading_list_pagination'] );
}

echo '<div ' . $wrapper_attributes . '>' . $html . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered markup.
