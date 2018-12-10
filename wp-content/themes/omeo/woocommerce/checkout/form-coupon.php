<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
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

if (!wc_coupons_enabled()) {
    return;
}

echo '<div class="col-sm-24">';
if (empty(WC()->cart->applied_coupons)) {
    $info_message = apply_filters('woocommerce_checkout_coupon_message', esc_attr__('Have a coupon?', 'omeo') . ' <a href="#" class="showcoupon">' . esc_attr__('Click here to enter your code', 'omeo') . '</a>');
    wc_print_notice($info_message, 'notice');
}
?>
<form class="checkout_coupon" method="post" style="display:none">

    <p class="form-row form-row-button">
        <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'omeo' ); ?>"><?php esc_html_e( 'Apply coupon', 'omeo' ); ?></button>
    </p>

    <p class="form-row form-row-text">
        <input type="text" name="coupon_code" class="input-text"
               placeholder="<?php esc_attr_e('Coupon code', 'omeo'); ?>" id="coupon_code" value=""/>
    </p>

    <div class="clear"></div>
</form>
</div>
