<?php
/**
 * Renders the Seer Book Author block.
 *
 * @var WP_Block $block The block instance.
 */

$book   = seer_get_current_book();
$author = isset( $book['author'] ) ? (string) $book['author'] : '';

if ( '' === $author ) {
	return;
}

$size    = isset( $attributes['size'] ) ? (int) $attributes['size'] : 14;
$wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'seer-reading-list__author',
		'style' => '--srl-size:' . $size . 'px;',
	)
);
?>
<span <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() escapes. ?>>
	<?php echo esc_html( $author ); ?>
</span>
