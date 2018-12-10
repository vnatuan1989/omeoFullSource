<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

wc_print_notices();

do_action('woocommerce_before_cart'); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
     <?php do_action('woocommerce_before_cart_table'); ?>

        <div class="yeti-shop-table">

            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                <thead>
                <tr>
                    <th class="product-name" colspan="2"><?php esc_html_e('Product Name', 'omeo'); ?></th>
                    <th class="product-price"><?php esc_html_e('Price', 'omeo'); ?></th>
                    <th class="product-quantity"><?php esc_html_e('Quantity', 'omeo'); ?></th>
                    <th class="product-subtotal"><?php esc_html_e('Total', 'omeo'); ?></th>
                    <th class="product-remove">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php do_action('woocommerce_before_cart_contents'); ?>

                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                        $_tr_class = 'cart_item';
                        $_tr_class .= empty($cart_item['gift_for'])? '': ' free_gift';
                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                        ?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', $_tr_class, $cart_item, $cart_item_key)); ?>">

                            <td class="product-thumbnail">
                                <?php
                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                if ( ! $product_permalink ) {
                                    print $thumbnail;
                                } else {
                                    printf('<a href="%s">%s</a>', esc_url($_product->get_permalink($cart_item)), $thumbnail);
                                }
                                ?>
                            </td>

                            <td class="product-name" data-title="<?php esc_html_e('Product Name', 'omeo'); ?>">
                                <?php
                                if ( ! $product_permalink ) {
                                    echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key) . '&nbsp;';
                                } else {
                                    echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s </a>', esc_url( $product_permalink ), $_product->get_title()), $cart_item, $cart_item_key);
                                }

                                // Meta data
                                echo wc_get_formatted_cart_item_data( $cart_item );

                                // Backorder notification
                                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                    echo '<p class="backorder_notification">' . esc_html__('Available on backorder', 'omeo') . '</p>';
                                }
                                ?>
                            </td>

                            <td class="product-price" data-title="<?php esc_html_e('Price', 'omeo'); ?>">
                                <?php
                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                                ?>
                            </td>

                            <td class="product-quantity" data-product_id="<?php echo absint($_product->get_id()) ?>"
                                data-gift_for="<?php echo (!empty($cart_item['gift_for'])) ? absint($cart_item['gift_for']) : 0; ?>"
                                data-title="<?php esc_html_e('Quantity', 'omeo'); ?>">
                                <?php
                                if ($_product->is_sold_individually()) {
                                    $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                } elseif (!empty($cart_item['gift_for'])) {
                                    $product_quantity = sprintf('<span>%1$s</span> <input type="hidden" name="cart[%2$s][qty]" value="%1$s" />', absint($cart_item['quantity']), $cart_item_key);

                                } else {
                                    $product_quantity = woocommerce_quantity_input(array(
                                        'input_name' => "cart[{$cart_item_key}][qty]",
                                        'input_value' => $cart_item['quantity'],
                                        'max_value' =>  $_product->get_max_purchase_quantity(),
                                        'min_value' => '0',
                                        'product_name'  => $_product->get_name()
                                    ), $_product, false);
                                }

                                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key);
                                echo '<p class="show-mobile">' . apply_filters('woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_attr__('Remove this item', 'omeo')), $cart_item_key) . '</p>';
                                ?>
                            </td>

                            <td class="product-subtotal" data-title="<?php esc_html_e('Total', 'omeo'); ?>">
                                <?php
                                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                                ?>
                            </td>

                            <td class="product-remove">

                                <?php
                                echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                    esc_attr__( 'Remove this item', 'omeo' ),
                                    esc_attr( $product_id ),
                                    esc_attr( $_product->get_sku() )
                                ), $cart_item_key );
                                ?>

                            </td>
                        </tr>
                        <?php
                    }
                }

                do_action('woocommerce_cart_contents');
                ?>
                <tr>
                    <td colspan="6" class="actions">

                        <?php
                        $shop_link = get_permalink(wc_get_page_id('shop'));
                        printf('<a class="button" href="%1$s"><i class="fa fa-reply" aria-hidden="true"></i>%2$s</a>', esc_url($shop_link), esc_html__("Continue Shopping", 'omeo'));
                        ?>

                        <?php do_action('woocommerce_cart_actions'); ?>

                        <?php wp_nonce_field('woocommerce-cart'); ?>
                    </td>
                </tr>

                <?php do_action('woocommerce_after_cart_contents'); ?>
                </tbody>
            </table>
            <?php do_action('woocommerce_after_cart_table'); ?>
        </div>

        <div class="yeti-cart-totals">

            <?php
            /**
             * Cart collaterals hook.
             *
             * @hooked woocommerce_cross_sell_display
             * @hooked woocommerce_cart_totals - 10
             */
            do_action('yesshop_woocommerce_cart_collaterals');
            ?>

        </div>
</form>

<?php do_action('woocommerce_after_cart'); ?>
