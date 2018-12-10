<?php
/**
 * Package: Yesshop.
 * User: Yeti - WP team
 * Vertion: 1.0
 */
?>
<div class="yeti_header_vertical hidden-xs hidden-sm">
    <?php Yesshop_Functions()->getLogo()?>

    <?php Yesshop_Functions()->get_menu('primary-menu', 'main-menu pc-menu'); ?>

    <div class="yeti-tini-cart-wrapper"><?php Yesshop_Functions()->shoppingCart(null, false); ?></div>

</div>

<div class="yeti_header_vertical_footer hidden-xs hidden-sm">
    <?php Yesshop_Functions()->search_form('non-cat', false); ?>

    <?php if ($shipping_text = Yesshop_Functions()->getThemeData('header-shipping-text')): ?>
        <div class="yeti-sale-policy">
            <?php echo do_shortcode(wp_kses_post(stripslashes(htmlspecialchars_decode($shipping_text)))); ?>
        </div>
    <?php endif;?>
</div>