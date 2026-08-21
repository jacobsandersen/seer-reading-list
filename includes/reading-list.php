<?php
/**
 * Reading list module: renderers and per-request data globals.
 *
 * @package SeerBlocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Seer reading list components this plugin can render.
 *
 * @return array<string>
 */
function seer_get_reading_list_components() {
	return array( 'read', 'current', 'wanted' );
}

/**
 * Get the current book being rendered inside the query loop.
 *
 * Set by the query block render before rendering each item's inner blocks.
 *
 * @return array
 */
function seer_get_current_book() {
	return isset( $GLOBALS['seer_current_book'] ) && is_array( $GLOBALS['seer_current_book'] )
		? $GLOBALS['seer_current_book']
		: array();
}

/**
 * Get the current pagination state for the query loop.
 *
 * Set by the query block render before rendering the pagination block.
 *
 * @return array
 */
function seer_get_current_pagination() {
	return isset( $GLOBALS['seer_current_pagination'] ) && is_array( $GLOBALS['seer_current_pagination'] )
		? $GLOBALS['seer_current_pagination']
		: array();
}

/**
 * Render a single book.
 *
 * @param array $book Book data from Seer.
 * @return string
 */
function seer_render_book_item( $book ) {
	$title  = isset( $book['title'] ) ? (string) $book['title'] : '';
	$author = isset( $book['author'] ) ? (string) $book['author'] : '';
	$image  = isset( $book['image'] ) ? (string) $book['image'] : '';

	ob_start();
	?>
	<li class="seer-reading-list__book">
		<figure class="seer-reading-list__cover">
			<?php if ( $image ) : ?>
				<img src="<?php echo esc_url( $image ); ?>" alt="" loading="lazy" />
			<?php endif; ?>
		</figure>
		<div class="seer-reading-list__meta">
			<?php if ( $title ) : ?>
				<span class="seer-reading-list__title"><?php echo esc_html( $title ); ?></span>
			<?php endif; ?>
			<?php if ( $author ) : ?>
				<span class="seer-reading-list__author"><?php echo esc_html( $author ); ?></span>
			<?php endif; ?>
		</div>
	</li>
	<?php
	return ob_get_clean();
}

// Kept for backwards compatibility with any custom code referencing it.
function seer_reading_list_render_book( $book ) {
	return seer_render_book_item( $book );
}

/**
 * Render pagination links (inner content only) for a query block instance.
 *
 * @param int    $page     Current page.
 * @param int    $total    Total pages.
 * @param string $page_arg The per-instance query arg name.
 * @return string
 */
function seer_render_pagination_links( $page, $total, $page_arg ) {
	// Note: omit the second arg so add_query_arg() bases the URL on
	// $_SERVER['REQUEST_URI'] and preserves the other query args (passing ''
	// would start from an empty URL and drop e.g. another block's page arg).
	$prev_href = $page > 1 ? add_query_arg( array( $page_arg => $page - 1 ) ) : '';
	$next_href = $page < $total ? add_query_arg( array( $page_arg => $page + 1 ) ) : '';

	$prev = $prev_href
		? '<a class="seer-reading-list__prev" href="' . esc_url( $prev_href ) . '">' . esc_html__( 'Previous', 'seer' ) . '</a>'
		: '<span class="seer-reading-list__prev" aria-disabled="true">' . esc_html__( 'Previous', 'seer' ) . '</span>';

	$next = $next_href
		? '<a class="seer-reading-list__next" href="' . esc_url( $next_href ) . '">' . esc_html__( 'Next', 'seer' ) . '</a>'
		: '<span class="seer-reading-list__next" aria-disabled="true">' . esc_html__( 'Next', 'seer' ) . '</span>';

	return sprintf(
		'%1$s<span class="seer-reading-list__page">%2$s</span>%3$s',
		$prev,
		sprintf(
			/* translators: 1: current page, 2: total pages. */
			esc_html__( 'Page %1$d of %2$d', 'seer' ),
			(int) $page,
			(int) $total
		),
		$next
	);
}
