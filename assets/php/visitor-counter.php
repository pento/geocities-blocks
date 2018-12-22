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

	$count = str_pad( $count, 8, '0', STR_PAD_LEFT );

	$content = <<<HTML
		<div class="wp-block-geocities-visitor-counter">
			<div class="visitor-counter-border visitor-counter-top-border"></div>
			<div class="visitor-counter-border visitor-counter-right-border"></div>
			<div class="visitor-counter-border visitor-counter-bottom-border"></div>
			<div class="visitor-counter-border visitor-counter-left-border"></div>
			<div class="visitor-counter-digits">$count</div>
		</div>
HTML;

	return $content;
}
