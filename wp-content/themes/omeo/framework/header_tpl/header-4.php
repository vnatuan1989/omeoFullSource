<?php
/**
 * Package: Yesshop.
 * User: Yeti - WP team
 * Vertion: 1.0
 */

?>
<div class="header-wrapper ">
    <div class="container">
        <div class="yt-display-table row">
            <div class="col-md-8 yt-display-table-cell yeti_header_menu hidden-xs hidden-sm">
                <a href="#" class="btn mobile-menu-btn" data-toggle=".mobile-menu-container"><i class="fa fa-bars"></i></a>
            </div>
            <div class="col-md-8 yt-display-table-cell yeti_header_logo yt-text-align-center hidden-xs hidden-sm">
                <?php Yesshop_Functions()->getLogo(); ?>
            </div>
            <div class="col-md-8 yt-display-table-cell yeti_header_right hidden-xs hidden-sm">
                <div class="yeti-tini-cart-wrapper"><?php Yesshop_Functions()->search_form('non-cat'); ?></div>
                <div class="yeti-tini-cart-wrapper"><?php Yesshop_Functions()->shoppingCart('mobile'); ?></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	jQuery(window).load(function(){
		jQuery('.main-sidebar.sidebar-left').removeClass('visible-xs visible-sm')
	})
</script>