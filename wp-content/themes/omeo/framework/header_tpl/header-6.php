<?php
/**
 * Package: Yesshop.
 * User: Yeti - WP team
 * Vertion: 1.0
 */

?>
<div class="yeti_header_top hidden-xs hidden-sm hidden">
    <!-- <div class="container">
        <div class="row">
            <div class="col-sm-12"><?php Yesshop_Functions()->headerShippingText();?></div>
            <div class="col-sm-12"><?php Yesshop_Functions()->get_headerTop_sidebar(); ?></div>
        </div>
    </div> -->
</div>
<div class="yeti_header_middle hidden-xs hidden-sm extra_width">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-6">
                <?php Yesshop_Functions()->get_header_sidebar('','','left'); ?>
                <?php Yesshop_Functions()->headerShippingText();?>
            </div>
            <div class="col-sm-8 col-md-12"><?php Yesshop_Functions()->getLogo(); ?></div>
            <div class="col-sm-8 col-md-6 right-area">
                <div class="yeti-search-wrapper"><?php Yesshop_Functions()->search_form('non-cat'); ?></div> 
                <div class="yeti-tini-cart-wrapper"><?php Yesshop_Functions()->shoppingCart(null, false); ?></div>
            </div>
        </div>
    </div>
</div>

<div class="yeti_header_bottom hidden-xs hidden-sm<?php Yesshop_Functions()->get_stickyHeaderClass(true)?>">
    <div class="container">
        <?php Yesshop_Functions()->get_menu('primary-menu', 'main-menu pc-menu'); ?>
    </div>
</div>