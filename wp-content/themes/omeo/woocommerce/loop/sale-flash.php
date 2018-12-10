<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
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
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post, $product;

$_output = '';



if(!$product->is_in_stock()) {
    $_output .= '<span class="outstock">' . esc_html__('Out of stock', 'omeo') . "</span>";
} else {
    if ($product->is_on_sale()) {
        if ($product->get_regular_price() > 0) {
            $_off_percent = (round($product->get_price() / $product->get_regular_price(), 2) - 1) * 100;
            $_label = esc_attr($_off_percent) . "&#37;";
        } else {
            $_label = esc_html__('Save', 'omeo');
        }
        $_output .= apply_filters('woocommerce_sale_flash', '<span class="onsale">' . esc_html($_label) . '</span>', $post, $product);
    }

    if ($product->is_featured()) {
        $_output .= '<span class="featured">' . esc_html__('New', 'omeo') . "</span>";
    }
}

if (!empty($_output)) echo '<div class="product-labels">' . $_output . '</div>';
?>
