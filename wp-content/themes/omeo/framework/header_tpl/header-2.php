<?php
/**
 * Package: Yesshop.
 * User: Yeti - WP team
 * Vertion: 1.0
 */

?>
<div class="yeti_header_top hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-13 col-lg-12">
                <?php Yesshop_Functions()->headerShippingText();?>
            </div>
            <div class="col-sm-11 col-lg-12 yeti-header-dropdown">
                <?php Yesshop_Functions()->get_header_sidebar('','','top'); ?>
            </div>  
        </div>
    </div>
</div>
<div class="yeti_header_middle hidden-xs hidden-sm <?php Yesshop_Functions()->get_stickyHeaderClass(true)?>">
    <div class="container">
        <div class="row">
            <div class="col-sm-7 col-md-6"><?php Yesshop_Functions()->getLogo(); ?></div>
            <div class="col-sm-17 col-md-18">
                <div class="yeti-tini-cart-wrapper"><?php Yesshop_Functions()->search_form('non-cat'); ?></div>
                <div class="yeti-tini-cart-wrapper"><?php Yesshop_Functions()->shoppingCart(null, false); ?></div>
                <?php Yesshop_Functions()->get_menu('primary-menu', 'main-menu pc-menu'); ?>
            </div>
        </div>
    </div>
</div>