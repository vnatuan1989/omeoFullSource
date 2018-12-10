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
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}

$__columns = !empty($woocommerce_loop['columns']) ? $woocommerce_loop['columns'] : apply_filters('loop_shop_columns', 4);

$classes = array();
if (absint($__columns) > 1) {
    if($__columns === 5) $__columns = 4;
    $classes[] = 'col-lg-' . round(24 / $__columns);
    foreach (array('md' => 992, 'sm' => 768, 'xs' => 480) as $k => $d) {
        $_c = round($__columns * $d / 1200);
        if(absint($_c) === 5) $_c = 4;
        $classes[] = 'col-'.$k.'-' . round(24 / $_c);
    }

} else {
    $classes[] = 'col-sm-24';
}

if (!isset($woocommerce_loop['loop']) || absint($woocommerce_loop['loop']) < absint($__columns)) {
    $classes[] = 'first-row';
}

if (is_ajax()) $classes[] = 'product';

?>
<section <?php post_class($classes); ?>>
    <?php
    /**
     * woocommerce_before_shop_loop_item hook.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    do_action('woocommerce_before_shop_loop_item');

    /**
     * woocommerce_before_shop_loop_item_title hook.
     *
     * @hooked woocommerce_show_product_loop_sale_flash - 10
     * @hooked woocommerce_template_loop_product_thumbnail - 10
     */
    do_action('woocommerce_before_shop_loop_item_title');

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
    ?>
</section>
