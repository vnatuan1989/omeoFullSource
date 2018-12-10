<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;;

// Ensure visibility
if (!$product || !$product->is_visible()) {
    return;
}

// Extra post classes
$classes = array('big-product');

//Bootstrap classes
$__columns = !empty($woocommerce_loop['columns']) ? $woocommerce_loop['columns'] : apply_filters('loop_shop_columns', 4);

$resp = array();
if (absint($__columns) > 1) {
    $resp[] = 'col-lg-' . round(24 / $__columns);
    $resp[] = 'col-md-' . round(24 / round($__columns * 992 / 1200));
    $resp[] = 'col-sm-' . round(24 / round($__columns * 768 / 1200));
    $resp[] = 'col-xs-' . round(24 / round($__columns * 480 / 1200));
    $resp[] = 'col-mb-12';
} else {
    $resp[] = 'col-sm-24';
}

$classes = array_merge($classes, $resp);

if (is_ajax()) $classes[] = 'product';

$attachment_ids = $product->get_gallery_image_ids();
if (is_array($attachment_ids) && !empty($attachment_ids)) array_shift($attachment_ids);

$attachment_ids = array_slice($attachment_ids, 0, 3);

?>
<section <?php post_class($classes); ?>>
    <div class="product-inner">
        <div class="product-thumbnail-wrapper">
            <?php
            /**
             * woocommerce_before_shop_loop_item hook.
             *
             * @hooked woocommerce_template_loop_product_link_open - 10
             */
            do_action('woocommerce_before_shop_loop_item'); ?>
            <?php
            /**
             * woocommerce_before_shop_loop_item_title hook.
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action('yesshop_bigproduct_before_shop_loop_item_title');
            yesshop_add_compare_link();
            yesshop_product_labels();
            echo '<a href="'.get_the_permalink().'" title="'.esc_attr(get_the_title()).'">';
            echo woocommerce_get_product_thumbnail('shop_single');
            echo '</a>';
            ?>
            </div>
            <?php if (!empty($attachment_ids)) : ?>
            <div class="thumbs">
                <ul class="list-inline">
                    <?php foreach ($attachment_ids as $attachment_id) : ?>
                        <li data-id="<?php echo absint($attachment_id); ?>"><?php echo wp_get_attachment_image($attachment_id, 'shop_thumbnail'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        </div><!--product-thumbnail-wrapper-->

    <div class="product-meta-wrapper">

        <?php
        /**
         * woocommerce_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action('woocommerce_shop_loop_item_title');

        /**
         * woocommerce_after_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action('woocommerce_after_shop_loop_item_title');

        /**
         * woocommerce_after_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action('woocommerce_after_shop_loop_item');

        Yesshop_CountDown::countdown_render();
        ?>

    </div>
    </div><!--.product-inner-->
</section>
