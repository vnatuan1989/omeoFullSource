<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

?>

<a href="<?php echo esc_url(add_query_arg('add_to_wishlist', $product_id)) ?>" rel="nofollow"
   data-product-id="<?php echo absint($product_id) ?>" data-product-type="<?php echo esc_attr($product_type) ?>"
   class="<?php echo esc_attr($link_classes) ?>"
   title="<?php echo esc_html($label) ?>">
    <?php echo esc_html($label) ?>
</a>
<i class="fa fa-circle-o-notch fa-spin fa-spin"></i>