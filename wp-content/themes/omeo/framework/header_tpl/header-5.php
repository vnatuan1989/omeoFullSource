<?php
/**
 * Package: Yesshop.
 * User: Yeti - WP team
 * Vertion: 1.0
 */

?>
<div class="hidden-xs hidden-sm extra_width">
    <div class="yeti_header_bottom hidden-xs hidden-sm">
        <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <?php Yesshop_Functions()->get_header_sidebar('','','left'); ?>
                <?php Yesshop_Functions()->headerShippingText();?>
            </div>
            <div class="col-sm-16 text-center main-menu-logo">
                <?php Yesshop_Functions()->get_menu('primary-menu', 'main-menu main-menu-left pc-menu'); ?>
                <?php Yesshop_Functions()->getLogo(); ?>
                <?php Yesshop_Functions()->get_menu('primary-menu-2', 'main-menu main-menu-right pc-menu'); ?>
            </div>
            <div class="col-sm-4 text-right">
                <?php Yesshop_Functions()->search_form('non-cat');?>
                <div class="yeti-tini-cart-wrapper"><?php Yesshop_Functions()->shoppingCart(null, false);?></div>

            </div>
        </div>
        </div>
    </div>

</div>

<?php Yesshop_Functions()->pageSlider('header');?>
