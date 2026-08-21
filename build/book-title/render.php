<?php
/**
 * Renders the Seer Book Title block.
 *
 * @var WP_Block $block The block instance.
 */

$book  = seer_reading_list_get_book();
$title = isset( $book['title'] ) ? (string) $book['title'] : '';

if ( '' === $title ) {
	return;
}

$size   = isset( $attributes['size'] ) ? (int) $attributes['size'] : 16;
$wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'seer-reading-list__title',
		'style' => '--srl-size:' . $size . 'px;',
	)
);
?>
<span <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() escapes. ?>>
	<?php echo esc_html( $title ); ?>
</span>
