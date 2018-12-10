<?php
/**
 * Package: Yesshop.
 * User: Yeti - WP team
 * Vertion: 1.0
 */

?>
<div class="yeti_header_middle extra_width hidden-xs hidden-sm <?php Yesshop_Functions()->get_stickyHeaderClass(true)?>">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-md-10">
                <?php Yesshop_Functions()->get_menu('primary-menu', 'main-menu pc-menu'); ?>
            </div>
            <div class="col-sm-4 col-md-4 text-center"><?php Yesshop_Functions()->getLogo(); ?></div>
            <div class="col-sm-10 col-md-10 yeti_header_middle_right">
                <div class="yeti-tini-cart-wrapper"><?php Yesshop_Functions()->search_form('non-cat'); ?></div>
                <div class="yeti-tini-cart-wrapper"><?php Yesshop_Functions()->shoppingCart(null, false); ?></div>
                <div class="yeti-tini-cart-wrapper yeti-header-dropdown"><?php Yesshop_Functions()->get_header_sidebar('','','top'); ?></div>
            </div>
        </div>
    </div>
</div>