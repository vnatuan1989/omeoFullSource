<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

global $product;

$attachment_ids = array();
if(!empty($prod_group)) {
    if(!empty($_trending_style) && $_thumb_style === 'gallery') {
        $post_thumbnail_id = get_post_thumbnail_id( $product->get_id() );
        $image = wp_get_attachment_image( $post_thumbnail_id , 'shop_single', false );
        $attachment_ids = apply_filters('yesshop_include_thumb_id', $product->get_gallery_image_ids());

    } else {
        $_thumb_id = 0;
        foreach ($prod_group as $data) {
            if(!empty($data['id']) && absint($data['id']) === $product->get_id()) {
                $_thumb_id = absint($data['thumb']);
            }
        }
        if($_thumb_id) {
            $image = wp_get_attachment_image($_thumb_id, 'full');
        } else {
            $post_thumbnail_id = get_post_thumbnail_id( $product->get_id() );
            $image = wp_get_attachment_image( $post_thumbnail_id , 'shop_single', false );
        }
    }

} else {
    $post_thumbnail_id = get_post_thumbnail_id( $product->get_id() );
    $image = wp_get_attachment_image( $post_thumbnail_id , 'shop_single', false );
    $attachment_ids = apply_filters('yesshop_include_thumb_id', $product->get_gallery_image_ids());
}

?>
    <div class="product">
        <div class="row">

            <div class="product-summary col-lg-10 col-md-24">

                <?php yesshop_single_product_summary_title_cat()?>

                <a href="<?php echo get_the_permalink();?>"><?php woocommerce_template_loop_product_title()?></a>

                <?php yesshop_the_excerpt();?>

                <?php Yesshop_CountDown::countdown_render(); ?>

                <div class="product-buttons">
                    <?php woocommerce_template_loop_add_to_cart();?>
                </div>
                <div class="product-buttons-extra">
                    <?php Yesshop_Quickshop::quickshop_btn(); ?>
                    <?php if(function_exists('yesshop_add_compare_link')) yesshop_add_compare_link();?>
                    <?php if (class_exists('YITH_WCWL')) echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );?>
                </div>
            </div>

            <div class="product-image  col-lg-14 hidden-sm hidden-md hidden-xs">
                <?php woocommerce_template_loop_price();?>
                <?php echo $image;?>
            </div>
        </div>
    </div>

