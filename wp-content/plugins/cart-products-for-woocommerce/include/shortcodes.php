<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WCCP_Shortcode{
    public static function init(){
        add_shortcode('wc_cart_products', array('WCCP_Shortcode', 'do_wc_cart_products'));
    }

    public static function do_wc_cart_products($atts){
        global $current_screen;

        ob_start();

        if (!isset($current_screen) && is_admin()) {$current_screen = get_current_screen();}
        if ( ( method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor() )
        || ( function_exists('is_gutenberg_page') && is_gutenberg_page() ) ) {
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        if ( is_wc_endpoint_url( 'order-received' ) ) return;

        extract(shortcode_atts(
            array(
                'category'  => '',
                'orderby'   => 'name',
                'per_page'  => -1,
                'type'      => '',
                'actions'   => 'true',
                'show_thumb' => true,
                'footer_total' => true
        ), $atts));


        $show_thumb = $show_thumb == 'true' ? true:false;
        $show_thumb = apply_filters('wccp/product_table_thumbnail', $show_thumb);

        $footer_total = $footer_total == 'true' ? true:false;
        $footer_total = apply_filters('wccp/footer_total', $footer_total);

        if( $category && is_array($category) ){
            $category = implode(',', $category);
        }

        if( $category ){
            $category = preg_replace('/\s+/', '', $category);
        }

        $currently_in_cart = array();
        $cart_total = '';


        $pseudo_hash = '';
        if( isset($_GET['category']) && sanitize_key($_GET['category']) != '' ){
            $pseudo_hash = sanitize_key($_GET['category']);
        }


        // In Cart query
        if( WC()->cart ){
            $cart_total =  WC()->cart->get_cart_total(); 

            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $product_id = $cart_item['product_id'];
                $quantity   = $cart_item['quantity'];
                $currently_in_cart[$product_id] = $quantity;
            }
        }



        //Add opening div with a hook. 
        do_action( 'wccp_before_cart' );
        echo '<div class="woocommerce wccp">';
        wc_print_notices(); 

        echo '<form class="wccp-woocommerce-cart-form" action="'. esc_url( wc_get_cart_url() ) .'" method="post" data-cart-total="'. strip_tags($cart_total) .'">';

        // Product query
        $args = array();

        if( $orderby ) $args['orderby'] = $orderby;
        if( $per_page ) $args['posts_per_page'] = $per_page;



        if( $category && $type == 'bycategory' ){
            $cat_array = explode(',', $category);

            $h_tag = apply_filters('wccp/categoty_h_tag', 'h3');

            if( $pseudo_hash && $pseudo_hash != $cat_slug && count($cat_array) > 1 ) {
                echo '<div class="wccp_show_all_wrap">';
                    echo '<a href="#show_all_categories" class="wccp_show_all">'.__('Show all categories', 'wccp').'</a>';
                echo '</div>';
            }

            if($cat_array){
                foreach ($cat_array as $key => $cat_slug) {
                    $hide_category = '';
                    if( $pseudo_hash && $pseudo_hash != $cat_slug ) {
                        //continue;
                        $hide_category = 'wccp-hidden-category wccp-hide';
                    }

                    $term = get_term_by('slug', $cat_slug, 'product_cat');
                    echo '<div id="'.$cat_slug.'" class="wccp-product-list product_cat_'.$cat_slug.' '.$hide_category.'">';
                        echo '<'.$h_tag.' class="wccp-category-heading">';
                            echo $term->name;
                        echo '</'.$h_tag.'>';

                        $args['category'] = $cat_slug;
                        $args = apply_filters('wccp/products_query', $args);
                        $products = wc_get_products( $args );

                        self::get_product_list($products, $cart_total, $currently_in_cart, $show_thumb);
                    echo '</div>';
                }
            }
        }else{
            if( $category ) $args['category'] = explode(',', $category);
            $args = apply_filters('wccp/products_query', $args);
            $products = wc_get_products( $args );
        
            self::get_product_list($products, $cart_total, $currently_in_cart, $show_thumb);
        }


        // Coupons and total price below product list
        if( $actions == 'true' ) self::get_cart_actions($cart_total, $footer_total);

        echo '<input type="hidden" name="custom_ajax_addtocart" value="true">';

        echo '<button style="display: none;" type="submit" class="button" name="custom_update_cart" value="'. __( 'Update cart', 'woocommerce' ).'">'.__( 'Update cart', 'woocommerce' ) .'</button>';

        echo '</form>';
        echo '</div>';

        //Add opening div with a hook. 
        do_action( 'wccp_after_cart' );

        $output_string = ob_get_contents();
        ob_end_clean();
        return $output_string;
    }

    public static function get_product_list($products, $cart_total, $currently_in_cart, $show_thumb){

        ?>
            <?php 
                $custom_template = locate_template( array( 'wc-cart-products/products-list.php' ) );
                if ( '' != $custom_template ) {
                    include( $custom_template );
                }else{
                    $default_template = WCCP_PATH . 'templates/products-list.php';
                    include( $default_template );
                }
            ?>

        <?php
    }


    public static function get_cart_actions($cart_total, $footer_total){

        ?>
            <?php 
                $custom_template = locate_template( array( 'wc-cart-products/cart-actions.php' ) );
                if ( '' != $custom_template ) {
                    include( $custom_template );
                }else{
                    $default_template = WCCP_PATH . 'templates/cart-actions.php';
                    include( $default_template );
                }
            ?>

        <?php
    }
}
