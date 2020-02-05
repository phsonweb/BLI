<?php do_action('wccp/before_footer'); ?>

<table class="shop_table wccp_cart_footer shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
    <tbody>
        <?php do_action('wccp/footer_first_tr'); ?>
        <tr>
            <td class="actions">
                <?php do_action('wccp/footer_actions_left'); ?>
                <?php if ( wc_coupons_enabled() ) { ?>
                    <div class="coupon">
                        <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>" />
                        <?php do_action( 'woocommerce_cart_coupon' ); ?>
                    </div>
                <?php } ?>
            </td>
            <td class="actions-right">
                <?php do_action('wccp/footer_actions_right'); ?>
                <?php if( $footer_total ){ ?>
                    <div class="total">
                        <?php _e('Total', 'woocommerce') ?><span class="cart-total-price"><?php echo $cart_total; ?></span>
                    </div>
                <?php } ?>
            </td>
        </tr>
        <?php do_action('wccp/footer_last_tr'); ?>
    </tbody>
</table>

<?php do_action('wccp/after_footer'); ?>