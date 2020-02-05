<?php  

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
    <thead>
        <tr>
            <?php if($show_thumb) echo '<th class="product-thumbnail">&nbsp;</th>'; ?>
            <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
            <th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
            <th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ( $products as $cart_item_key => $cart_item ) {
            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item, $cart_item, $cart_item_key );
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item->get_id(), $cart_item, $cart_item_key );

            $cart_item_key = $product_id;

            if ( $_product && $_product->exists() && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                ?>
                <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                    <?php if($show_thumb){ ?>
                        <td class="product-thumbnail"><?php
                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                        if ( ! $product_permalink ) {
                            echo $thumbnail;
                        } else {
                            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                        }
                        ?></td>
                    <?php } ?>

                    <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>"><?php
                    if ( ! $product_permalink ) {
                        echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
                    } else {
                        echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
                    }

                    // Meta data.
                    //echo wc_get_formatted_cart_item_data( $cart_item );

                    // Backorder notification.
                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( 0 ) ) {
                        echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
                    }
                    ?></td>

                    <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                        <?php
                            echo apply_filters( 'x_woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                        ?>
                    </td>

                    <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>"><?php

                    $current_qty = isset($currently_in_cart[$product_id]) ? $currently_in_cart[$product_id] : 0;
                    
                    $product_quantity = woocommerce_quantity_input( array(
                            'input_name'    => "cart[{$cart_item_key}][qty]",
                            'input_value'   => $current_qty,
                            'max_value'     => $_product->get_max_purchase_quantity(),
                            'min_value'     => '0',
                            'product_name'  => $_product->get_name(),
                        ), $_product, false );
                    

                    $product_quantity = apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                    echo apply_filters( 'wccp_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                    ?></td>

                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>