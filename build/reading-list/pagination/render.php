<?php
/**
 * Renders the Seer Pagination block.
 *
 * Reads pagination state from the query block context and renders Previous /
 * Next links. Renders nothing when there is only one page.
 *
 * @var WP_Block $block The block instance.
 */

$state = seer_get_current_pagination();

$page      = isset( $state['page'] ) ? (int) $state['page'] : 1;
$total     = isset( $state['total'] ) ? (int) $state['total'] : 1;
$page_arg  = isset( $state['page_arg'] ) ? (string) $state['page_arg'] : '';

if ( $total <= 1 || '' === $page_arg ) {
	return;
}

$size    = isset( $attributes['size'] ) ? (int) $attributes['size'] : 14;
$wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'seer-reading-list__pagination',
		'style' => '--srl-size:' . $size . 'px;',
	)
);
?>
<nav <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() escapes. ?>>
	<?php echo seer_render_pagination_links( $page, $total, $page_arg ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered markup. ?>
</nav>
