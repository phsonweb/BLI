<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function wccp_block_assets() { // phpcs:ignore
	// Styles.
	wp_enqueue_style(
		'wccp-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array( 'wp-editor' ) // Dependency to include the CSS after it.
		// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);
}
// add_action( 'enqueue_block_assets', 'wccp_block_assets' );


function wccp_shortcode_block_init(){
	register_block_type( 'wccp/shortcode-block', array(
		'editor_script' => 'wccp-block-js',
		'attributes' => array(
	 		'type' => array('type' => 'string'),
	 		'category' => array('type' => 'array'),
			'actions' => array('type' => 'string'),
			'show_thumb' => false, 
	 		'footer_total' => array('type' => 'string')
		),
		'render_callback' => array('WCCP_Shortcode', 'do_wc_cart_products')
   	) );
}
if( !is_admin() ) add_action( 'init', 'wccp_shortcode_block_init' );

/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function wccp_shortcode_editor_assets() {
	wp_enqueue_script(
		'wccp-block-js',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		true
	);

	wp_enqueue_style(
		'wccp-editor-css',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' )
	);
}

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'wccp_shortcode_editor_assets' );
