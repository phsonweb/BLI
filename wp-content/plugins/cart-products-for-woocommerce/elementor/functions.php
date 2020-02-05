<?php
namespace Elementor;

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

/**
 * Elementor category
 */
function bgi_cart_products_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'wccp-addons',
        [
            'title'  => 'Cart Products for Woocommerce',
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init','Elementor\bgi_cart_products_elementor_init');
