 <?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

$_pos = Yesshop_Functions()->get_tooltip_pos();
$tooltip = ($_pos)? 'tooltip': 'false';

?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo absint($product_id) ?>" data-toggle="<?php echo esc_attr($tooltip);?>"
     data-placement="<?php echo esc_attr($_pos); ?>" title="<?php echo esc_attr('Add to Wishlist', 'omeo') ?>">
    <?php if (!($disable_wishlist && !is_user_logged_in())): ?>
        <div class="yith-wcwl-add-button <?php echo ($exists && !$available_multi_wishlist) ? 'hide' : 'show' ?>"
             style="display:<?php echo ($exists && !$available_multi_wishlist) ? 'none' : 'block' ?>">

            <?php yith_wcwl_get_template('add-to-wishlist-' . $template_part . '.php', $atts); ?>

        </div>

        <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
            <span class="feedback"><?php echo esc_attr($product_added_text) ?></span>
            <a href="<?php echo esc_url($wishlist_url) ?>">
                <?php echo apply_filters('yith-wcwl-browse-wishlist-label', esc_html($browse_wishlist_text)) ?>
            </a>
        </div>

        <div class="yith-wcwl-wishlistexistsbrowse <?php echo ($exists && !$available_multi_wishlist) ? 'show' : 'hide' ?>"
             style="display:<?php echo ($exists && !$available_multi_wishlist) ? 'block' : 'none' ?>">
            <span class="feedback"><?php echo esc_html($already_in_wishslist_text); ?></span>
            <a href="<?php echo esc_url($wishlist_url) ?>">
                <?php echo apply_filters('yith-wcwl-browse-wishlist-label', esc_html($browse_wishlist_text)) ?>
            </a>
        </div>

        <div style="clear:both"></div>
        <div class="yith-wcwl-wishlistaddresponse"></div>
    <?php else: ?>
        <a href="<?php echo esc_url(add_query_arg(array('wishlist_notice' => 'true', 'add_to_wishlist' => $product_id), get_permalink(wc_get_page_id('myaccount')))) ?>"
           rel="nofollow" class="<?php echo str_replace('add_to_wishlist', '', $link_classes) ?>">
            <?php echo esc_html($label) ?>
        </a>
    <?php endif; ?>

</div>

<!--div class="clear"></div-->