<?php
/*
Plugin Name: Cart Products for WooCommerce
Plugin URI:
Description: Extension for Woocommerce that allows you to add products quickly and easily to the cart straight from cart or checkout page. 
Author: BlueGlass
Version: 1.0.4
Author URI: http://blueglass.ee/en/

WC requires at least: 3.0
WC tested up to: 3.5.3
*/


if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    define('WCCP_VERSION', '1.0.4');
    define('WCCP_PATH', plugin_dir_path( __FILE__ ));
    define('WCCP_GUTEN_PATH', plugin_dir_path( __FILE__ ) . 'gutenberg/');
    define('WCCP_URL', plugin_dir_url(__FILE__));


    include_once('include/shortcodes.php');
    include_once('include/functions.php');
    // Initialise plugin
    WPCP_Functions::init();
    WCCP_Shortcode::init();

    /**
    * Gutenberg Block Initializer.
    */
    if ( version_compare( get_bloginfo( 'version' ), '5.0', '>=' ) ) {
        require_once WCCP_GUTEN_PATH . 'src/init.php';
    }

    /**
    * Elementor Block Initializer.
    */
    if ( in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        function elementor_controls_load_plugin() {
            require_once WCCP_PATH.'elementor/functions.php';
            require_once WCCP_PATH.'elementor/init.php';
        }
        add_action( 'plugins_loaded', 'elementor_controls_load_plugin' );
    }
}