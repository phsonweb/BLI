<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPCP_Functions{
    public static function init(){
        
        //if( !is_admin() ) {
            add_action( 'wccp_before_cart', array('WPCP_Functions', 'add_open_div') );
            add_action( 'wccp_after_cart', array('WPCP_Functions', 'add_closing_div'), 1000 );
            add_action( 'wp', array('WPCP_Functions', 'add_to_cart') );
            add_action( 'wp_footer', array('WPCP_Functions', 'cart_refresh_update_qty') ); 
            add_action( 'wp_enqueue_scripts', array('WPCP_Functions', 'enqueue_scripts') );

            add_filter( 'woocommerce_checkout_redirect_empty_cart', function(){ return false; } );

            add_filter( 'woocommerce_checkout_update_order_review_expired', array('WPCP_Functions', 'update_order_review_expired') );

            add_filter( 'body_class', array('WPCP_Functions', 'add_body_class') );
            add_filter( 'wccp_item_quantity', array('WPCP_Functions', 'modernize_quantity_input'), 10, 3 );
        //}
    }

    public static function update_order_review_expired( ){
        return false;
    }

    public static function enqueue_scripts() {
        //CSS
        wp_enqueue_style( 'wccp-styles', WCCP_URL . 'css/wccp.css', false, WCCP_VERSION );

        //JS
        wp_enqueue_script('jquery');
        wp_enqueue_script( 'wccp-scripts', WCCP_URL.'js/wccp.js', array(), WCCP_VERSION, false );
    }

    public static function modernize_quantity_input($input, $cart_item_key, $cart_item){

        $minus_icon = apply_filters('wccp/minus-svg-icon', WCCP_PATH.'images/minus.svg' );
        $minus_icon = self::get_raw_svg($minus_icon);

        $plus_icon  = apply_filters('wccp/plus-svg-icon', WCCP_PATH.'images/plus.svg' );
        $plus_icon  = self::get_raw_svg($plus_icon);

        $new_input = '<div class="wccp-qty">';
            $new_input .= '<span class="wccp-qty-minus">'.$minus_icon.'</span>';
            $new_input .= $input;
            $new_input .= '<span class="wccp-qty-plus">'.$plus_icon.'</span>';
        $new_input .= '</div>';

        return $new_input;
    }

    public static function get_raw_svg($filepath){
        if(!$filepath) return;
	    $svg = file_get_contents( $filepath );
	    return preg_replace('/^.+\n/', '', $svg);
	}

    public static function add_body_class($classes){
        $classes[] = 'wccp-in';
        return $classes;
    }
    public static function add_open_div(){
        echo '<div class="wccp-wrap">';
    }
    public static function add_closing_div(){
        echo '</div>';
    }
    public static function add_to_cart() {
        // if ( ! is_page( 'checkout' ) ) {
        //     return;
        // }
     
        // if ( ! WC()->cart->is_empty() ) {
        //     return;
        // }
    
        if( isset($_POST['custom_ajax_addtocart']) && $_POST['custom_ajax_addtocart'] == true ){
            if( isset($_POST['cart']) && !empty($_POST['cart']) ){
    
                foreach($_POST['cart'] as $id => $item){
                    self::remove_from_cart( $id );
    
                    if($item['qty'] > 0) {
    
                        //Add item to cart
                        WC()->cart->add_to_cart( $id, $item['qty'] );
                    }
                }
            }
        }
    }

    public static function remove_from_cart( $id ){
        if( !$id ) return;
    
        // Remove item before updating quantity
        $cartId = WC()->cart->generate_cart_id( $id );
        $cartItemKey = WC()->cart->find_product_in_cart( $cartId );
        WC()->cart->remove_cart_item( $cartItemKey );
    }

    public static function cart_refresh_update_qty() { 
        //if (is_cart() || is_checkout()) { 
            $timeout = apply_filters('wccp/quantity_update_timeout', 800);
            $timeout = sanitize_key($timeout);
            ?> 
            <script type="text/javascript"> 
                var qty_timeout = setTimeout(function(){}, <?php echo $timeout ?>);
                jQuery('div.woocommerce').on('change', 'input.qty', function(){ 
                    clearTimeout(qty_timeout);
                    var update_cart_btn = jQuery(this).parents('.wccp-woocommerce-cart-form').find("[name='custom_update_cart']");
                    qty_timeout = setTimeout(function(){
                        update_cart_btn.trigger("click"); 
                    }, <?php echo $timeout ?>);
                }); 
            </script> 
            <?php 
        //} 
    }

}

