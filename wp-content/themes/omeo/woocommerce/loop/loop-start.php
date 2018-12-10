<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

$_classes = apply_filters('yesshop_woocommerce_loop_start_class', 'products');
if (isset($is_slider) && absint($is_slider) > 0) {
    $_classes .= ' yeti-owl-slider';
}
if (!empty($product_mode)) $_classes .= ' ' . $product_mode;
if (!empty($item_style)) $_classes .= ' ' . $item_style;

?>
<div class="<?php echo esc_attr($_classes) ?> columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>">
