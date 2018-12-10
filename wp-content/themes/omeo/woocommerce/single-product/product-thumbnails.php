<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
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
 * @version     3.3.2
 */

if (!defined('ABSPATH')) {
    exit;
}

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
    return;
}

global $post, $product, $woocommerce;

$attachment_ids = apply_filters('yesshop_include_thumb_id', $product->get_gallery_image_ids());

if ($attachment_ids && count($attachment_ids) > 1) {
    $loop = 0;
    $columns = apply_filters('woocommerce_product_thumbnails_columns', 4);

    $_prod_page_style = Yesshop_Functions()->getThemeData('product-page-style');

    $options = array(
        'paginationClickable' => true,
        'slidesPerView' => $columns,
        'spaceBetween' => 0,
        'breakpoints' => array(
            320 => array(
                'slidesPerView' => round($columns * (480 / 1170)),
            ),
            480 => array(
                'slidesPerView' => round($columns * (768 / 1170)),
            ),
            640 => array(
                'slidesPerView' => $columns
            ),
        )
    );

    if (in_array(absint($_prod_page_style), array(4, 5))) {
        $columns = 8;
        $options = array(
            'paginationClickable' => true,
            'slidesPerView' => 'auto',
            'spaceBetween' => 0,
            'direction' => 'vertical',
            'scrollContainer' => true,
            'calculateHeight' => true
        );
    } else {
        $options = array(
            'paginationClickable' => true,
            'slidesPerView' => $columns,
            'spaceBetween' => 0,
            'breakpoints' => array(
                320 => array(
                    'slidesPerView' => round($columns * (480 / 1170)),
                ),
                480 => array(
                    'slidesPerView' => round($columns * (768 / 1170)),
                ),
                640 => array(
                    'slidesPerView' => $columns
                ),
            )
        );
    }

    ?>
    <div id="yeti_prod_thumbnail" class="swiper-container thumbnails loading <?php echo 'columns-' . $columns; ?>"
         data-params="<?php echo esc_attr(wp_json_encode($options)) ?>">

        <div class="swiper-wrapper">

            <?php

            foreach ($attachment_ids as $attachment_id) {

                $classes = array('img_thumb swiper-slide zoom1');
                if ($loop == 0) $classes[] = "open";
                $image_class = implode(' ', $classes);

                $attributes = array(
                    'title'                   => get_post_field( 'post_title', $attachment_id ),
                    'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
                );

                echo apply_filters(
                    'woocommerce_single_product_image_thumbnail_html',
                    sprintf(
                        '<div data-pos="%s" class="%s">%s</div>',
                        absint($loop),
                        esc_attr($image_class),
                        wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail'), 0, $attributes)
                    ),
                    $attachment_id,
                    $post->ID,
                    esc_attr($image_class)
                );

                $loop++;
            }

            ?>

        </div>

    </div>
    <?php
}

