<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
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
    exit;
}
global $woocommerce_loop;
$__columns = !empty($woocommerce_loop['columns']) ? $woocommerce_loop['columns'] : apply_filters('loop_shop_columns', 4);

if (absint($__columns) > 1) {
    $classes[] = 'col-lg-' . round(24 / $__columns);
    $classes[] = 'col-md-' . round(24 / round($__columns * 992 / 1200));
    $classes[] = 'col-sm-' . round(24 / round($__columns * 768 / 1200));
    $classes[] = 'col-xs-' . round(24 / round($__columns * 480 / 1200));
    $classes[] = 'col-mb-12';
} else {
    $classes[] = 'col-sm-24';
}

if (!isset($woocommerce_loop['loop']) || absint($woocommerce_loop['loop']) < absint($__columns)) {
    $classes[] = 'first-row';
}

$classes[] = 'loop-' . $woocommerce_loop['loop'];


if (is_ajax()) $classes[] = 'product';
?>

<section <?php wc_product_cat_class(implode(' ', $classes), $category); ?>>

    <?php
    /**
     * woocommerce_before_subcategory hook.
     *
     * @hooked woocommerce_template_loop_category_link_open - 10
     */
    do_action('woocommerce_before_subcategory', $category);

    /**
     * woocommerce_before_subcategory_title hook.
     *
     * @hooked woocommerce_subcategory_thumbnail - 10
     */
    do_action('woocommerce_before_subcategory_title', $category);

    /**
     * woocommerce_shop_loop_subcategory_title hook.
     *
     * @hooked woocommerce_template_loop_category_title - 10
     */
    do_action('woocommerce_shop_loop_subcategory_title', $category);

    /**
     * woocommerce_after_subcategory_title hook.
     */
    do_action('woocommerce_after_subcategory_title', $category);

    /**
     * woocommerce_after_subcategory hook.
     *
     * @hooked woocommerce_template_loop_category_link_close - 10
     */
    do_action('woocommerce_after_subcategory', $category); ?>
</section>
