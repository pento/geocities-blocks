<?php
/**
 * Plugin Name: GeoCities Blocks
 * Plugin URI: https://github.com/melchoyce/geocities-blocks
 * Description:
 * Version: 0.0.1
 * Author: TBD
 * Text Domain: geocities-blocks
 */

defined( 'ABSPATH' ) || die();

define( 'GEOCITIES_VERSION', '0.0.1' );
define( 'GEOCITIES_DEV_MODE', true );

require_once( 'assets/php/visitor-counter.php' );

/**
 * Load up the assets if Gutenberg is active.
 */
function geocities_initialize() {
	if ( function_exists( 'register_block_type' ) ) {
		add_action( 'init', 'geocities_register_block' );
	}
	add_action( 'init', 'geocities_gutenberg_scripts' );
}
add_action( 'plugins_loaded', 'geocities_initialize' );

/**
 * Register blocks with their scripts.
 */
function geocities_register_block() {
	register_block_type( 'geocities/example', array(
		'editor_script' => 'geocities-example-block',
		'editor_style'  => 'geocities-example-block',
	) );

	register_meta( 'post', 'geocities-blocks-visitor-count', array(
		'show_in_rest' => true,
		'single'       => true,
		'type'         => 'integer',
	) );

	register_block_type( 'geocities/visitor-counter', array(
		'attributes'      => array(
			'count' => array(
				'type'    => 'number',
				'default' => 0,
			),
		),
		'editor_script'   => 'geocities-visitor-counter',
		'render_callback' => 'render_block_geocities_visitor_counter',
		'style'           => 'geocities-visitor-counter',
	) );

	// Register more blocks here.
}

/**
 * Register the scripts & styles needed.
 */
function geocities_gutenberg_scripts() {
	wp_register_script(
		'geocities-example-block',
		plugins_url( 'build/example-block.js', __FILE__ ),
		array( 'wp-element', 'wp-blocks', 'wp-components', 'wp-i18n' ),
		geocities_get_file_version( 'build/example-block.js' )
	);
	wp_register_style(
		'geocities-example-block',
		plugins_url( 'build/example-block.css', __FILE__ ),
		array(),
		geocities_get_file_version( 'build/example-block.css' )
	);

	wp_register_script(
		'geocities-visitor-counter',
		plugins_url( 'build/visitor-counter.js', __FILE__ ),
		array( 'wp-element', 'wp-blocks', 'wp-components', 'wp-i18n' ),
		geocities_get_file_version( 'build/visitor-counter.js' )
	);
	wp_register_style(
		'geocities-visitor-counter',
		plugins_url( 'build/visitor-counter.css', __FILE__ ),
		array(),
		geocities_get_file_version( 'build/visitor-counter.css' )
	);

	// Register more block scripts & styles here.
}

/**
 * Get the file modified time if we're using SCRIPT_DEBUG.
 *
 * @param string $file Local path to the file.
 */
function geocities_get_file_version( $file ) {
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		return filemtime( plugin_dir_path( __FILE__ ) . $file );
	}
	return GEOCITIES_VERSION;
}

/**
 * Add a new category for Geocities blocks.
 */
function geocities_register_block_category( $categories ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'geocities',
				'title' => __( 'GeoCities', 'geocities-blocks' ),
			),
		)
	);
}
add_filter( 'block_categories', 'geocities_register_block_category' );