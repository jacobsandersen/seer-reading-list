<?php
/**
 * Renders the Seer Album Art block.
 *
 * @var WP_Block $block The block instance.
 */

$track = seer_get_current_track();

$sizes       = seer_get_now_listening_image_sizes();
$image_size  = isset( $attributes['imageSize'] ) ? (string) $attributes['imageSize'] : 'extralarge';
if ( ! in_array( $image_size, $sizes, true ) ) {
	$image_size = 'extralarge';
}

// Fall back through the size list from the requested size downward so art
// still renders when Last.fm is missing a particular bucket.
$art_url = '';
foreach ( array_slice( $sizes, array_search( $image_size, $sizes, true ) ) as $size_key ) {
	if ( ! empty( $track['images'][ $size_key ] ) ) {
		$art_url = (string) $track['images'][ $size_key ];
		break;
	}
}

// Fall back through the size list from the requested size downward so art
// still renders when Last.fm is missing a particular bucket.
$art_url = '';
foreach ( array_slice( $sizes, array_search( $image_size, $sizes, true ) ) as $size_key ) {
	if ( ! empty( $track['images'][ $size_key ] ) ) {
		$art_url = (string) $track['images'][ $size_key ];
		break;
	}
}

$image_width = isset( $attributes['imageWidth'] ) ? (int) $attributes['imageWidth'] : 200;

$wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'seer-now-listening__art',
		'style' => '--srl-image-width:' . $image_width . 'px;',
	)
);
?>
<figure <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() escapes. ?>>
	<?php if ( '' !== $art_url ) : ?>
		<img src="<?php echo esc_url( $art_url ); ?>" alt="" loading="lazy" />
	<?php else : ?>
		<span class="seer-now-listening__art-placeholder"></span>
	<?php endif; ?>
</figure>
