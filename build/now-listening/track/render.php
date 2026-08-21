<?php
/**
 * Renders the Seer Now Listening block on the front end.
 *
 * Fetches the current track from Seer and renders the saved inner item
 * blocks once, exposing the track through a request-scoped global.
 *
 * Behavior:
 * - API failure  -> visible error message.
 * - No track     -> configurable fallback text.
 * - Track found  -> inner blocks rendered with the track global set.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$fallback_text = isset( $attributes['fallbackText'] )
	? (string) $attributes['fallbackText']
	: __( 'Nothing playing right now', 'seer' );

$track = seer_fetch_now_listening();

if ( is_wp_error( $track ) ) {
	echo '<div ' . get_block_wrapper_attributes( array( 'class' => 'seer-now-listening' ) ) . '><p class="seer-now-listening__error">' . esc_html( $track->get_error_message() ) . '</p></div>';
	return;
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class'          => 'seer-now-listening',
		'data-fallback'  => $fallback_text,
	)
);

if ( empty( $track ) ) {
	echo '<div ' . $wrapper_attributes . '><p class="seer-now-listening__fallback">' . esc_html( $fallback_text ) . '</p></div>';
	return;
}

$GLOBALS['seer_current_track'] = $track;

$inner_html = '';
foreach ( $block->inner_blocks as $inner_block ) {
	// Pass the parsed block array: render_block() forwards its argument to
	// the pre_render_block filter, which core expects to be an array.
	$inner_html .= render_block( $inner_block->parsed_block );
}

unset( $GLOBALS['seer_current_track'] );

echo '<div ' . $wrapper_attributes . '>' . $inner_html . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered markup.
