<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
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

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

global $product;

$classes = !empty($classes) ? $classes: array('product-item');
?>

<li class="<?php echo esc_attr(implode(' ', $classes))?>">

    <?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

    <a class="product-image" href="<?php echo esc_url(get_permalink($product->get_id())); ?>"
       title="<?php echo esc_attr($product->get_title()); ?>">
        <?php echo $product->get_image(); ?>

        <?php if(!empty($_num_order)) : ?>
            <span class="lb_num_order"><?php echo absint($_num_order);?></span>
        <?php endif?>
    </a>
    <div class="product-detail">
        <a class="product-title" href="<?php echo esc_url(get_permalink($product->get_id())); ?>" title="<?php echo esc_attr($product->get_title()); ?>"><?php echo $product->get_title(); ?></a>
        <?php echo $product->get_price_html(); ?>
        <?php if (!empty($show_rating)) echo wc_get_rating_html( $product->get_average_rating() ); ?>
    </div>

    <?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>

</li>
