<?php
/**
 * Renders the Seer Last Read block.
 *
 * @var WP_Block $block The block instance.
 */

$book      = seer_reading_list_get_book();
$last_read = isset( $book['last_read'] ) ? (string) $book['last_read'] : '';

$time = $last_read ? strtotime( $last_read ) : false;
if ( '' === $last_read || false === $time ) {
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
			/* translators: %s: date the book was last read. */
			__( 'Last read %s', 'seer-reading-list' ),
			date_i18n( get_option( 'date_format' ), $time )
		)
	);
	?>
</span>
