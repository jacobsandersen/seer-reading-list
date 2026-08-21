<?php
/**
 * Renders the Seer Book Cover block.
 *
 * @var WP_Block $block The block instance.
 */

$book        = seer_get_current_book();
$image       = isset( $book['image'] ) ? (string) $book['image'] : '';
$image_width = isset( $attributes['imageWidth'] ) ? (int) $attributes['imageWidth'] : 200;

if ( '' === $image ) {
	$wrapper = get_block_wrapper_attributes(
		array(
			'class' => 'seer-reading-list__cover',
			'style' => '--srl-image-width:' . $image_width . 'px;',
		)
	);
	?>
	<figure <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() escapes. ?>>
		<span class="seer-reading-list__cover-placeholder"></span>
	</figure>
	<?php
	return;
}

$wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'seer-reading-list__cover',
		'style' => '--srl-image-width:' . $image_width . 'px;',
	)
);
?>
<figure <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() escapes. ?>>
	<img src="<?php echo esc_url( $image ); ?>" alt="" loading="lazy" />
</figure>
