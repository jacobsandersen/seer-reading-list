<?php
/**
 * Renders the Seer Artist Name block.
 *
 * @var WP_Block $block The block instance.
 */

$track  = seer_get_current_track();
$artist = isset( $track['artist'] ) ? (string) $track['artist'] : '';

if ( '' === $artist ) {
	return;
}

$size    = isset( $attributes['size'] ) ? (int) $attributes['size'] : 14;
$wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'seer-now-listening__artist',
		'style' => '--srl-size:' . $size . 'px;',
	)
);
?>
<span <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() escapes. ?>>
	<?php echo esc_html( $artist ); ?>
</span>
