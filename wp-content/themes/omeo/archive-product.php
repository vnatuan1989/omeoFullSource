<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop');

?>

<?php
/**
 * woocommerce_before_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action('woocommerce_before_main_content');
?>

<?php 
/**
* yeti_before_main_content hook
* 
* @hook yeti_woocommerce_shop_top_menu - 10
*/
do_action('yeti_shop_before_main_content');
?>

<?php
/**
 * Hook: woocommerce_archive_description.
 *
 * @hooked woocommerce_taxonomy_archive_description - 10
 * @hooked woocommerce_product_archive_description - 10
 */
do_action('woocommerce_archive_description');
?>

<?php

if(
    (is_shop() && 'subcategories' !== get_option( 'woocommerce_shop_page_display' )) ||
    (is_product_category() && 'subcategories' !== get_option( 'woocommerce_category_archive_display' ))
) {
    $sub_slider = true;
    $slide_ops = array(
        "items"				=> 4,
        "responsive"		=> array(
            0	=> array(
                'items'	=> 1,
            ),
            480	=> array(
                'items'	=> 2,
            ),
            769	=> array(
                'items'	=> 3,
            ),
            981	=> array(
                'items'	=> 3,
            ),
        )
    );
    $loop_html_start = sprintf('<div class="product-subcategories row"><div class="archive-product-subcategories yeti-owlCarousel yeti-loading light" data-options="%s" data-base="1"><div class="yeti-owl-slider">', esc_attr(json_encode($slide_ops)));
    $loop_html_end = '</div></div></div>';
    $loop_html = '';
} else {
    $sub_slider = false;
    $loop_html_start = '<div class="product-subcategories row"><div class="archive-product-subcategories">';
    $loop_html_end = '</div></div>';
    $loop_html = '';
}
if($sub_slider)
{
    echo $loop_html_start;
    echo woocommerce_maybe_show_product_subcategories($loop_html);
    echo $loop_html_end;
}

?>

<?php if (have_posts()) : ?>

    <div class="yeti-shop-meta-controls col-sm-24">
        <?php
        /**
         * woocommerce_before_shop_loop hook
         *
         * @hooked woocommerce_result_count - 20
         * @hooked woocommerce_catalog_ordering - 30
         */
        do_action('woocommerce_before_shop_loop');
        ?>
    </div>

    <?php yesshop_woocommerce_top_filter();?>

    <div class="row">
        <?php woocommerce_product_loop_start(); ?>

        <?php while (have_posts()) : the_post(); ?>

            <?php wc_get_template_part('content', 'product'); ?>

        <?php endwhile; // end of the loop. ?>

        <?php woocommerce_product_loop_end(); ?>
    </div>
    <?php
    /**
     * woocommerce_after_shop_loop hook
     *
     * @hooked woocommerce_pagination - 10
     */
    do_action('woocommerce_after_shop_loop');
    ?>

<?php else: ?>

    <?php
    /**
     * Hook: woocommerce_no_products_found.
     *
     * @hooked wc_no_products_found - 10
     */
    do_action( 'woocommerce_no_products_found' );
    ?>

<?php endif; ?>

<?php
/**
 * woocommerce_after_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>

<?php
/**
 * woocommerce_sidebar hook.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');
?>

<?php get_footer('shop'); ?>
