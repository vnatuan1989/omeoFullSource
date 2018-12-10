<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( $related_products ) :
    $options = array(
        'items' => apply_filters('woocommerce_up_sells_columns', 4),
        'responsive' => array(
            0 => array(
                'items' => 1,
                'loop' => false
            ),
        )
    );
    $options = Yesshop_Functions()->get_owlResponsive($options);
    ?>

    <section class="related products">

        <h3 class="heading-title"><span><?php esc_html_e('Related Products', 'omeo'); ?></span></h3>

        <div class="yeti-owlCarousel yeti-loading light" data-options="<?php echo esc_attr(json_encode($options)); ?>" data-base="1">

            <?php Yesshop_Functions()->yt_get_yetiLoadingIcon(); ?>

            <div class="row">

                <?php wc_get_template('loop/loop-start.php', array('is_slider' => true)); ?>

                <?php foreach ( $related_products as $related_product ) : ?>

                    <?php
                    $post_object = get_post( $related_product->get_id() );

                    setup_postdata( $GLOBALS['post'] =& $post_object );

                    wc_get_template_part( 'content', 'product' ); ?>

                <?php endforeach; ?>

                <?php woocommerce_product_loop_end(); ?>

            </div>

        </div>

    </section>

<?php endif;

wp_reset_postdata();
