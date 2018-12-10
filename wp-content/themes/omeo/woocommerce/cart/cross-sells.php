<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
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

if ( $cross_sells ) :

    $options = array(
        'items' => apply_filters('woocommerce_cross_sells_columns', 4),
        'responsive' => array()
    );

    $options = Yesshop::get_owlResponsive($options);
    ?>

    <div class="cross-sells">

        <h3 class="heading-title ud-line"><span><?php esc_html_e('You may be interested in&hellip;', 'omeo') ?></span></h3>

        <div class="yeti-owlCarousel yeti-loading light" data-base="1" data-options="<?php echo esc_attr(json_encode($options)) ?>">

            <?php Yesshop_Functions()->yt_get_yetiLoadingIcon(); ?>

            <div class="row">

                <?php wc_get_template('loop/loop-start.php', array('is_slider' => 1)); ?>

                <?php foreach ( $cross_sells as $cross_sell ) : ?>

                    <?php
                    $post_object = get_post( $cross_sell->get_id() );

                    setup_postdata( $GLOBALS['post'] =& $post_object );

                    wc_get_template_part( 'content', 'product' ); ?>

                <?php endforeach; ?>

                <?php woocommerce_product_loop_end(); ?>

            </div>

        </div>

    </div>

<?php endif;

wp_reset_postdata();
