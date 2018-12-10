<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$accessories = Yesshop_WC_Helper()->get_accessories($product);
if (sizeof($accessories) === 0 && !array_filter($accessories)) {
    return;
}

$__columns = 3;

$classes = array('accessory');
if (absint($__columns) > 1) {
    $classes[] = 'col-lg-' . round(24 / $__columns);
    $classes[] = 'col-md-' . round(24 / round($__columns * 992 / 1200));
    $classes[] = 'col-sm-' . round(24 / round($__columns * 768 / 1200));
    $classes[] = 'col-xs-' . round(24 / round($__columns * 480 / 1200));
    $classes[] = 'col-mb-12';
} else {
    $classes[] = 'col-sm-24';
}

$args = array(
    'post_type' => 'product',
    'ignore_sticky_posts' => 1,
    'no_found_rows' => 1,
    'posts_per_page' => 2,
    'orderby' => 'post__in',
    'post__in' => $accessories,
    'meta_query' => WC()->query->get_meta_query(),
);


$args['meta_query'][] = array(
    'key' => '_stock_status',
    'value' => 'instock'
);
$args['meta_query'][] = array(
    'key' => '_backorders',
    'value' => 'no'
);

$products = new WP_Query($args);

$list_product_html = '';
$total_price = 0;
?>

<?php if ($products->have_posts()) : ?>

    <div class="accessories">
        <div class="row">
            <div class="col-xs-24 col-sm-18 col-left">

                <div class="row">
                    <?php woocommerce_product_loop_start(); ?>

                    <section <?php post_class($classes) ?> data-id="<?php echo absint($product->get_id()) ?>">
                        <div class="section-inner">
                            <a href="<?php echo esc_url($product->get_permalink()); ?>">
                                <div class="product-thumbnail">
                                    <?php echo $product->get_image('shop_catalog'); ?>
                                </div>
                            </a>
                        </div>
                    </section>
                    <?php
                    $total_price += $product->get_price();
                    $price_html = '';
                    $count = 1;
                    ob_start();
                    ?>
                    <div class="checkbox accessory-checkbox">
                        <label>
                            <input checked disabled type="checkbox" class="product-item"
                                   data-product_id="<?php echo absint($product->get_id()) ?>"
                                   data-product_type="<?php echo esc_attr($product->get_type()) ?>">
                            <span class="product-title"><strong><?php esc_html_e('This product: ', 'omeo') ?></strong><?php echo get_the_title(); ?></span>
                            - <?php echo $product->get_price_html(); ?>
                        </label>
                    </div>

                    <?php $list_product_html = ob_get_clean(); ?>

                    <?php while ($products->have_posts()) : $products->the_post();
                        global $product; ?>

                        <section <?php post_class($classes) ?> data-id="<?php echo absint($product->get_id()) ?>">
                            <div class="section-inner">
                                <a href="<?php echo esc_url($product->get_permalink()); ?>">
                                    <div class="product-thumbnail">
                                        <?php echo $product->get_image('shop_catalog'); ?>
                                    </div>
                                </a>
                            </div>
                        </section>
                        <?php
                        $total_price += $product->get_price();
                        $price_html = '';
                        $count++;
                        ob_start();
                        ?>
                        <div class="checkbox accessory-checkbox">
                            <label>
                                <input checked type="checkbox" class="product-item"
                                       data-product_id="<?php echo absint($product->get_id()) ?>"
                                       data-product_type="<?php echo esc_attr($product->get_type()) ?>">
                                <span class="product-title"><?php echo get_the_title(); ?></span>
                                - <?php echo $product->get_price_html(); ?>
                            </label>
                        </div>

                        <?php $list_product_html .= ob_get_clean(); ?>

                    <?php endwhile; // end of the loop. ?>

                    <?php woocommerce_product_loop_end(); ?>

                </div>

                <div class="check-products">
                    <?php echo $list_product_html; ?>
                </div>

            </div>
            <div class="col-xs-24 col-sm-24 col-md-6 col-right">
                <div class="total-price">
                    <span class="price"><?php echo wc_price($total_price) . $product->get_price_suffix() ?></span>
                    <span class="total-products"><?php printf(esc_html__('for %s items', 'omeo'), absint($count)); ?></span>
                </div>
                <a class="button ajax_add_all_to_cart" title="<?php esc_attr_e('Add to cart', 'omeo') ?>"
                   href="#"><i class="fa fa-cart-plus"
                               aria-hidden="true"></i> <?php esc_html_e('Add to cart', 'omeo') ?></a>
            </div>
        </div>

        <script type="text/javascript">
            (function ($) {
                "use strict";

                $(document).on('change', '.single-product .woocommerce-tabs .accessories .check-products input[type=checkbox]', function (e) {
                    e.preventDefault();
                    var $this = $(this),
                        $checked = $this.parents('.accessories').find('.accessory-checkbox input:checked'),
                        $wrapper = $('.single-product .woocommerce-tabs .accessories'),
                        _ids = [];

                    $checked.each(function (e, i) {
                        var id = $(this).data('product_id');
                        if (id > 0) _ids.push(id);
                    });

                    $.ajax({
                        type: 'POST',
                        url: yesshop_data.ajax_url,
                        data: {
                            ids: _ids,
                            action: 'yesshop_accessories_checked_price',
                            security: '<?php echo esc_js(wp_create_nonce('__YESSHOP_NONCE_658'))?>'
                        },
                        dataType: 'json',
                        beforeSend: function () {
                            $wrapper.yesshop_loading();
                        },
                        error: function () {
                            $wrapper.yesshop_unlock();
                        },
                        success: function (response) {
                            $wrapper.yesshop_unlock();
                            if (response) {
                                $.each(response, function (key, value) {
                                    $(key).replaceWith(value);
                                });
                            }

                            $wrapper.find('.products .accessory').each(function (e, i) {
                                var _id = $(this).data('id');

                                if ($.inArray(parseInt(_id), _ids) < 0) {
                                    $(this).hide();
                                } else {
                                    $(this).show();
                                }
                            });

                        }
                    });

                });

                $(document).on('click', '.single-product .woocommerce-tabs .accessories .ajax_add_all_to_cart', function (e) {
                    e.preventDefault();
                    var $btn = $(this),
                        $wrap = $btn.parents('.accessories'),
                        $checked = $wrap.find('.check-products input[type=checkbox]:checked'),
                        _ids = [];

                    $checked.each(function (e, i) {
                        var id = $(this).data('product_id');
                        if (id > 0) _ids.push(id);
                    });

                    $.ajax({
                        type: 'POST',
                        url: yesshop_data.ajax_url,
                        data: {
                            ids: _ids,
                            action: 'yesshop_accessories_add_to_cart',
                            security: '<?php echo esc_js(wp_create_nonce('__YESSHOP_NONCE_658'))?>'
                        },
                        dataType: 'json',
                        beforeSend: function () {
                            $wrap.yesshop_loading();
                        },
                        error: function () {
                            $wrap.yesshop_unlock();
                        },
                        success: function (response) {
                            if (!response) return;

                            var this_page = window.location.toString();

                            var fragments = response.fragments;
                            if (fragments) {
                                $.each(fragments, function (key, value) {
                                    $(key).addClass('updating');
                                });
                            }

                            // Block widgets and fragments
                            $('.shop_table.cart, .updating, .cart_totals').yesshop_loading();

                            // Replace fragments
                            if (fragments) {
                                $.each(fragments, function (key, value) {
                                    $(key).replaceWith(value);
                                });
                            }

                            // Unblock
                            $('.widget_shopping_cart, .updating').stop(true).css('opacity', '1').yesshop_unlock();

                            // Cart page elements
                            $('.shop_table.cart').load(this_page + ' .shop_table.cart:eq(0) > *', function () {
                                $('.shop_table.cart').stop(true).css('opacity', '1').yesshop_unlock();
                                $('body').trigger('cart_page_refreshed');
                            });

                            $('.cart_totals').load(this_page + ' .cart_totals:eq(0) > *', function () {
                                $('.cart_totals').stop(true).css('opacity', '1').yesshop_unlock();
                            });
                            $wrap.yesshop_unlock();
                        }
                    });
                });
            })(jQuery);
        </script>
    </div>

<?php endif;

wp_reset_postdata();


