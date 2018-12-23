<?php
/**
 * Server-side rendering of the `geocities/visitor-counter` block.
 *
 * @package geocities-blocks
 */

/**
 * Renders the `geocities/visitor-counter` block on the server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
function render_block_geocities_visitor_counter( $attributes ) {
	global $wpdb;

	$meta_key = 'geocities-blocks-visitor-count';

	$count = get_post_meta( get_the_ID(), $meta_key, true );

	// If there's no value, initialise it.
	if ( ! $count ) {
		add_post_meta( get_the_ID(), $meta_key, 0, true );
	}

	// If we're on the front-end, increment the counter.
	if ( ! is_admin() ) {
		$count++;

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value=meta_value+1 WHERE meta_key=%s AND post_ID=%d", $meta_key, get_the_ID() ) );
	}

	$alt = _n(
		'There has been %d visitor to this page.',
		'There have been %d visitors to this page.',
		$count,
		'geocities-blocks'
	);
	$alt = sprintf( $alt, $count );

	$count = str_pad( $count, $attributes['padding'], '0', STR_PAD_LEFT );
	$background = str_repeat( '8', strlen( $count ) );

	$content = <<<HTML
		<div class="wp-block-geocities-visitor-counter">
			<div class="screen-reader-text">$alt</div>
			<div aria-hidden="true">
				<div class="visitor-counter-border visitor-counter-top-border"></div>
				<div class="visitor-counter-border visitor-counter-right-border"></div>
				<div class="visitor-counter-border visitor-counter-bottom-border"></div>
				<div class="visitor-counter-border visitor-counter-left-border"></div>
				<div class="visitor-counter-background-digits">$background</div>
				<div class="visitor-counter-digits">$count</div>
			</div>
HTML;

	// Hidden div to fool Twenty Nineteen, which messes with the bottom margin of the last block on the page.
	$content .= '<div hidden></div></div>';

	return $content;
}
