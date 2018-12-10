<?php
/**
 * Checkout Form
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('yesshop_shopping_progress');

wc_print_notices();



// If checkout registration is disabled and not logged in, the user cannot checkout
if (!$checkout->enable_signup && !$checkout->enable_guest_checkout && !is_user_logged_in()) {
    echo apply_filters('woocommerce_checkout_must_be_logged_in_message', esc_html__('You must be logged in to checkout.', 'omeo'));
    return;
}


// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters('woocommerce_get_checkout_url', wc_get_checkout_url() ); ?>

<div class="row">
    <div class="col-md-24">
        <div class="row">

            <div class="before-checkout-form">
                <?php do_action('woocommerce_before_checkout_form', $checkout); ?>
            </div>

            <form name="checkout" method="post" class="checkout woocommerce-checkout"
                  action="<?php echo esc_url($get_checkout_url); ?>" enctype="multipart/form-data">
                <div class="col-sm-24 col-md-14">

                    <?php if (sizeof($checkout->checkout_fields) > 0) : ?>

                        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                        <div id="customer_details">
                            <div class="col-1">
                                <?php do_action('woocommerce_checkout_billing'); ?>
                            </div>

                            <div class="woocommerce-additional-fields">
                                <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

                                <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

                                    <?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

                                        <h3><?php _e( 'Additional information', 'omeo' ); ?></h3>

                                    <?php endif; ?>

                                    <div class="woocommerce-additional-fields__field-wrapper">
                                        <?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
                                            <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                                        <?php endforeach; ?>
                                    </div>

                                <?php endif; ?>

                                <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
                            </div>

                            <?php do_action('woocommerce_checkout_shipping'); ?>

                        </div>

                        <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                    <?php endif; ?>

                </div>


                <div class="col-sm-24 col-md-10 yeti-sidebar">

                    <div class="widget_boxed">

                        <div class="widget-heading">
                            <h2 id="order_review_heading"><?php esc_html_e('Your order', 'omeo'); ?></h2>
                        </div>

                        <div class="content-inner">

                            <?php do_action('woocommerce_checkout_before_order_review'); ?>

                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <?php do_action('woocommerce_checkout_order_review'); ?>
                            </div>

                            <?php do_action('woocommerce_checkout_after_order_review'); ?>

                        </div>

                    </div>
                </div>
            </form>
        </div> <!-- end .row -->
    </div> <!-- end .col-md-24 -->
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
