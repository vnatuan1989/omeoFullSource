<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 11/28/2015
 * Vertion: 1.0
 */
?>
<?php
$sidebar_name = "header-top-widget-area-mb";
if (is_active_sidebar($sidebar_name)):?>
    <div class="yeti_header_top header-tablet-top visible-xs visible-sm">
        <div class="container">
            <div>
                <ul class="widgets-sidebar text-center">
                    <?php dynamic_sidebar($sidebar_name); ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="yeti_header_middle header-tablet-middle visible-xs visible-sm">
    <div class="container">
        <div class="row">
            <!--<div class="visible-xs nth-phone-menu-icon"><i class="fa fa-bars"></i></div>-->
			<div class="col-sm-6 col-xs-6 mobile-menu-wrap">
				<a href="#" class="btn mobile-menu-btn" data-toggle=".mobile-menu-container"><i class="fa fa-bars"></i></a>
			</div>
            <div class="col-sm-12 col-xs-12"><?php Yesshop_Functions()->getLogo(); ?></div>
            <div class="col-sm-6 col-xs-6">
                <div class="yeti-tini-wrapper"><?php Yesshop_Functions()->shoppingCart('mobile'); ?></div>
            </div><!-- .col-sm-18 -->
        </div>
    </div>
</div>



