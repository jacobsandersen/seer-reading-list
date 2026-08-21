<?php
/**
 * Renders the Seer Read Count block.
 *
 * @var WP_Block $block The block instance.
 */

$book       = seer_reading_list_get_book();
$times_read = isset( $book['times_read'] ) ? (int) $book['times_read'] : 0;

if ( $times_read < 1 ) {
	return;
}

$size    = isset( $attributes['size'] ) ? (int) $attributes['size'] : 12;
$wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'seer-reading-list__meta-line',
		'style' => '--srl-size:' . $size . 'px;',
	)
);
?>
<span <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() escapes. ?>>
	<?php
	echo esc_html(
		sprintf(
			/* translators: %d: number of times the book was read. */
			_n( 'Read %d time', 'Read %d times', $times_read, 'seer-reading-list' ),
			$times_read
		)
	);
	?>
</span>
