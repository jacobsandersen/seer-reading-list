<?php
/**
 * Renders the Seer Song Name block.
 *
 * @var WP_Block $block The block instance.
 */

$track = seer_get_current_track();
$title = isset( $track['title'] ) ? (string) $track['title'] : '';

if ( '' === $title ) {
	return;
}

$size          = isset( $attributes['size'] ) ? (int) $attributes['size'] : 16;
$link_to_last  = ! empty( $attributes['linkToLastFm'] );
$track_url     = isset( $track['url'] ) ? (string) $track['url'] : '';

$wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'seer-now-listening__song',
		'style' => '--srl-size:' . $size . 'px;',
	)
);
?>
<span <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() escapes. ?>>
	<?php if ( $link_to_last && '' !== $track_url ) : ?>
		<a href="<?php echo esc_url( $track_url ); ?>" target="_blank" rel="noopener noreferrer">
			<?php echo esc_html( $title ); ?>
		</a>
	<?php else : ?>
		<?php echo esc_html( $title ); ?>
	<?php endif; ?>
</span>
