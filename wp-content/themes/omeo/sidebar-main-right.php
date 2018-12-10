<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Yesshop
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="main-sidebar sidebar-right">

    <div class="offcanvas-heading widget-heading">
        <h3 class="widget-title heading-title"><?php esc_html_e('Shopping cart', 'omeo');?></h3>

        <a href="#" class="offcanvas-close">Close</a>
    </div>

    <?php if(class_exists('WooCommerce')):?>
        <div class="widget_shopping_cart_content"></div>
    <?php endif?>

</div>

<div class="main-sidebar sidebar-left visible-xs visible-sm">

    <div class="mobile-menu-wrap">
        <div class="widget-heading">
            <h3 class="widget-title heading-title"><?php esc_html_e('Menu', 'omeo');?></h3>
            <a href="#" class="offcanvas-close">Close</a>
        </div>


        <ul class="widgets-sidebar list-inline">
            <?php $sidebar_name = 'mobile-menu-widget-area';
            if (is_active_sidebar($sidebar_name)): ?>
                <?php dynamic_sidebar($sidebar_name); ?>
            <?php endif;?>
            <li class="widget widget_text"><div class="yeti-tini-wrapper"><?php Yesshop_Functions()->login_form('mobile'); ?></div></li>
        </ul>


        <div class="mobile-menu-container">
            <?php Yesshop_Functions()->get_menu('mobile-menu'); ?>
        </div>
        <?php Yesshop_Functions()->search_form('non-cat'); ?>
    </div>

</div>
