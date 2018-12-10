<?php
/**
 * Cart totals
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.3.6
 */

if (!defined('ABSPATH')) {
    exit;
}

?>
<div class="row yeti-cart-collaterals">
    <?php if (wc_coupons_enabled()): ?>

    <div class="col-md-12 coupon widget-item">

        <div class="widget-heading"><h2 class="widget-title"><?php esc_html_e('Enter coupon', 'omeo'); ?></h2></div>

        <div class="content-inner">

            <?php
            printf('<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="%1$s" /> <input type="submit" class="button" name="apply_coupon" value="%2$s" />', esc_html__('Coupon code', 'omeo'), esc_html__('Apply Coupon', 'omeo'));
            do_action('woocommerce_cart_coupon');
            ?>

        </div>

    </div>

    <?php endif;?>

    <div class="col-md-12 cart_totals widget-item <?php if (WC()->customer->has_calculated_shipping()) echo 'calculated_shipping'; ?>">
        <div class="cart_totals-inner">

            <?php do_action('woocommerce_before_cart_totals'); ?>

            <div class="widget-heading"><h2 class="widget-title"><?php esc_html_e('Cart Totals', 'omeo'); ?></h2></div>

            <div class="content-inner">

                <table cellspacing="0">

                    <tr class="cart-subtotal">
                        <th><?php esc_html_e('Subtotal', 'omeo'); ?></th>
                        <td><?php wc_cart_totals_subtotal_html(); ?></td>
                    </tr>

                    <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                        <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                            <th><?php wc_cart_totals_coupon_label($coupon); ?></th>
                            <td><?php wc_cart_totals_coupon_html($coupon); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

                        <?php do_action('woocommerce_cart_totals_before_shipping'); ?>

                        <?php wc_cart_totals_shipping_html(); ?>

                        <?php do_action('woocommerce_cart_totals_after_shipping'); ?>

                    <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

                    <tr class="shipping">
                        <th><?php _e( 'Shipping', 'omeo' ); ?></th>
                        <td data-title="<?php esc_attr_e( 'Shipping', 'omeo' ); ?>"><?php woocommerce_shipping_calculator(); ?></td>
                    </tr>

                    <?php endif; ?>

                    <?php foreach (WC()->cart->get_fees() as $fee) : ?>
                        <tr class="fee">
                            <th><?php echo esc_html($fee->name); ?></th>
                            <td><?php wc_cart_totals_fee_html($fee); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (wc_tax_enabled() && WC()->cart->tax_display_cart == 'excl') : ?>
                        <?php if (get_option('woocommerce_tax_total_display') == 'itemized') : ?>
                            <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
                                <tr class="tax-rate tax-rate-<?php echo sanitize_title($code); ?>">
                                    <th><?php echo esc_html($tax->label); ?></th>
                                    <td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="tax-total">
                                <th><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
                                <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php do_action('woocommerce_cart_totals_before_order_total'); ?>

                    <tr class="order-total">
                        <th><?php esc_html_e('Total', 'omeo'); ?></th>
                        <td><?php wc_cart_totals_order_total_html(); ?></td>
                    </tr>

                    <?php do_action('woocommerce_cart_totals_after_order_total'); ?>

                </table>

                <?php if (WC()->cart->get_cart_tax()) : ?>
                    <p class="wc-cart-shipping-notice">
                        <small><?php

                            $estimated_text = WC()->customer->is_customer_outside_base() && !WC()->customer->has_calculated_shipping()
                                ? sprintf(' ' . esc_html__(' (taxes estimated for %s)', 'omeo'), WC()->countries->estimated_for_prefix() . WC()->countries->countries[WC()->countries->get_base_country()])
                                : '';

                            printf(esc_html__('Note: Shipping and taxes are estimated%s and will be updated during checkout based on your billing and shipping information.', 'omeo'), $estimated_text);

                            ?></small>
                    </p>
                <?php endif; ?>


            </div><!---div.content-inner-->

            <?php do_action('woocommerce_after_cart_totals'); ?>
            
            <div class="wc-proceed-to-checkout">

                <?php do_action('woocommerce_proceed_to_checkout'); ?>

            </div>

        </div>

    </div>
</div>


