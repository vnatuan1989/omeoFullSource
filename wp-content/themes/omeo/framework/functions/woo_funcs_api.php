<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 11/28/2015
 * Vertion: 1.0
 *
 *
 * I - HEADER FUNCTION
 */

if (!function_exists('yesshop_single_post_meta_bottom_sharing')) {
    function yesshop_single_post_meta_bottom_sharing() {
        $image_link = wp_get_attachment_url(get_post_thumbnail_id());
        $fa_url_pars = add_query_arg(array(
            'utm_campaign' => 'shareaholic',
            'utm_medium' => 'facebook',
            'utm_source' => 'socialnetwork'
        ), esc_url(get_permalink()));

        $social_args = array(
            array(
                'class' => 'facebook',
                'icon' => 'fa fa-facebook',
                'title' => esc_attr__('Share on Facebook', 'omeo'),
                'url' => add_query_arg(array(
                    'u' => urlencode($fa_url_pars)
                ), 'http://www.facebook.com/sharer.php')
            ),
            array(
                'class' => 'twitter',
                'icon' => 'fa fa-twitter',
                'title' => esc_attr__('Share on Twitter', 'omeo'),
                'url' => add_query_arg(array(
                    'url' => esc_url(get_permalink()),
                    'text' => get_the_title()
                ), 'https://twitter.com/intent/tweet')
            ),
            array(
                'class' => 'google_plus',
                'icon' => 'fa fa-google-plus',
                'title' => esc_attr__('Share on Google plus', 'omeo'),
                'url' => add_query_arg(array(
                    'url' => urlencode(esc_url(get_permalink()))),
                    'https://plus.google.com/share'
                )
            ),
            array(
                'class' => 'pinterest',
                'icon' => 'fa fa-pinterest-p',
                'title' => esc_attr__('Share on Pinterest', 'omeo'),
                'url' => add_query_arg(array(
                    'url' => urlencode(esc_url(get_the_permalink())),
                    'media' => urlencode(esc_url($image_link)),
                    'description' => urlencode(get_the_title())
                ), 'https://pinterest.com/pin/create/button/')
            )
        );

        echo '<div class="yeti-social-share"><span>'. __('Share: ') .'</span><ul class="nth-social-share-link list-inline">';

        foreach ($social_args as $social) {
            printf('<li class="%s"><a href="%s" title="%s" data-toggle="tooltip" data-placement="top"><i class="%s"></i></a></li>', esc_attr($social['class']), esc_url($social['url']), esc_attr($social['title']), esc_attr($social['icon']));
        }

        echo '</ul></div>';
    }

    function yesshop_single_post_meta_bottom_sharing_script(){
        ?>
        <ul class="yeti-social-share-script list-inline">
            <li>
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=803462639803811";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-share-button" data-href="<?php echo get_permalink();?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Share</a></div>
            </li>
            <li>
                <a href="https://twitter.com/share" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
            </li>
            <li>
                <script src="https://apis.google.com/js/platform.js" async defer></script>
                <div class="g-plusone" data-size="small" data-href="<?php echo get_permalink();?>"></div>
            </li>
        </ul>

        <?php

    }
}

if (class_exists('WooCommerce')) {

    if (!function_exists('yesshop_loop_shop_per_page')) {
        function yesshop_loop_shop_per_page()
        {
            global $yesshop_datas;

            if (is_archive('product')) {
                if (!empty($_REQUEST['per_show']) && absint($_REQUEST['per_show']) > 0) {
                    return absint($_REQUEST['per_show']);
                } elseif (isset($yesshop_datas['shop_per_page']) && absint($yesshop_datas['shop_per_page']) > 0) {
                    return absint($yesshop_datas['shop_per_page']);
                } else {
                    return 12;
                }
            }
        }
    }

    if (!function_exists('yesshop_page_show_title')) {
        function yesshop_page_show_title($res)
        {
            global $yesshop_datas;
            if (isset($yesshop_datas['page-datas']['page_show_title']))
                $res = absint($yesshop_datas['page-datas']['page_show_title']) == 0 ? false : true;
            return $res;
        }
    }

    if (!function_exists('yesshop_woocommerce_breadcrumbs')) {
        function yesshop_woocommerce_breadcrumbs($defaults)
        {
            global $yesshop_datas;

            if (isset($yesshop_datas['breadcrum-style'])) {
                switch ($yesshop_datas['breadcrum-style']) {
                    case 'transparent':
                        $defaults["delimiter"] = '<span class="delimiter">&rarr;</span>';
                        break;
                    default:
                        $defaults["wrap_before"] = "<nav id=\"crumbs\" class=\"woocommerce-breadcrumb\"><ul>";
                        $defaults["wrap_after"] = "</ul></nav>";
                        $defaults["before"] = "<li>";
                        $defaults["after"] = "</li>";
                        $defaults["delimiter"] = '';
                }
            } else {
                $defaults["wrap_before"] = "<nav id=\"crumbs\" class=\"woocommerce-breadcrumb\"><ul>";
                $defaults["wrap_after"] = "</ul></nav>";
                $defaults["before"] = "<li>";
                $defaults["after"] = "</li>";
                $defaults["delimiter"] = '';
            }
            return $defaults;
        }
    }

    if (!function_exists('yesshop_loop_columns')) {
        function yesshop_loop_columns()
        {
            global $yesshop_datas;
            if (isset($yesshop_datas["shop_columns"]) && absint($yesshop_datas["shop_columns"]) > 0)
                return absint($yesshop_datas['shop_columns']);
            else return 4;
        }
    }

    function yesshop_shop_loop_item_class($classes)
    {
        global $post;
        if ($post->post_type === 'product') {
            global $woocommerce_loop;
            $__columns = !empty($woocommerce_loop['columns']) ? $woocommerce_loop['columns'] : apply_filters('loop_shop_columns', 4);

            if (absint($__columns) > 1) {
                $classes[] = 'col-lg-' . round(24 / $__columns);
                $classes[] = 'col-md-' . round(24 / round($__columns * 992 / 1200));
                $classes[] = 'col-sm-' . round(24 / round($__columns * 768 / 1200));
                $classes[] = 'col-xs-' . round(24 / round($__columns * 480 / 1200));
                $classes[] = 'col-mb-12';
            } else {
                $classes[] = 'col-sm-24';
            }

            if (!isset($woocommerce_loop['loop']) || absint($woocommerce_loop['loop']) < absint($__columns)) {
                $classes[] = 'first-row';
            }

            $classes[] = 'loop-' . $woocommerce_loop['loop'];


            if (is_ajax()) $classes[] = 'product';
        }

        return $classes;
    }

    if (!function_exists('yesshop_woocommerce_cross_sells_total')) {
        function yesshop_woocommerce_cross_sells_total()
        {
            global $yesshop_datas;
            return isset($yesshop_datas['cross-sells-number']) ? absint($yesshop_datas['cross-sells-number']) : 9;
        }
    }

    function yesshop_woocommerce_cross_sells_columns() {
        global $yesshop_datas;
        return isset($yesshop_datas['cross-sells-cols']) ? absint($yesshop_datas['cross-sells-cols']) : 4;
    }

    if (!function_exists('yesshop_shop_loop_title')) {
        function yesshop_shop_loop_title()
        {
            printf('<h3 class="product-title"><a href="%1$s" title="%2$s">%2$s</a></h3>', esc_url(get_the_permalink()), esc_attr(get_the_title()));
        }
    }

    function yesshop_filter_woocommerce_product_get_rating_html($rating_html, $rating)
    {
        global $product;
        $rating_html = '';
        if (!is_numeric($rating)) {
            $rating = $product->get_average_rating();
        }
        if ($rating > 0) {

            $rating_html = '<div class="star-rating" data-count="' . absint($product->get_rating_count()) . '" title="' . sprintf(__('Rated %s out of 5', 'omeo'), $rating) . '">';

            $rating_html .= '<span style="width:' . (($rating / 5) * 100) . '%"><strong class="rating">' . $rating . '</strong> ' . esc_attr__('out of 5', 'omeo') . '</span>';

            $rating_html .= '</div>';
        }
        return $rating_html;
    }

    if (!function_exists('yesshop_shop_buttons_div_start')) {
        function yesshop_shop_buttons_div_start()
        {
            echo '<div class="product_buttons"><div class="product_buttons_inner">';
        }
    }

    if (!function_exists('yesshop_shop_buttons_div_end')) {
        function yesshop_shop_buttons_div_end()
        {
            echo '</div></div>';
        }
    }

    if (!function_exists('yesshop_add_to_wishlist')) {
        function yesshop_add_to_wishlist()
        {
            echo do_shortcode('[yith_wcwl_add_to_wishlist]');
        }
    }

    if (!function_exists('yesshop_custom_yith_wishlist_position')) {
        function yesshop_custom_yith_wishlist_position($yith_position)
        {
            $yith_position["add-to-cart"] = array('hook' => 'woocommerce_after_add_to_cart_button', 'priority' => 31);
            return $yith_position;
        }
    }

    if (!function_exists('yesshop_shop_loop_relative_div_start')) {
        function yesshop_shop_loop_relative_div_start()
        {
            echo '<div class="prod-meta-relative">';
            echo '<div class="prod-meta-relative-wrapper">';
            echo '<div class="prod-meta-relative-inner">';
        }
    }

    if (!function_exists('yesshop_shop_loop_relative_div_end')) {
        function yesshop_shop_loop_relative_div_end()
        {
            echo '</div><!--prod-meta-relative-inner-->';
            echo '</div><!--prod-meta-relative-wrapper-->';
            echo '</div><!--prod-meta-relative-->';
        }
    }

    if (!function_exists('yesshop_shop_loop_hover_div_start')) {
        function yesshop_shop_loop_hover_div_start()
        {
            echo '<div class="prod-meta-hover">';
            echo '<div class="prod-meta-hover-wrapper">';
            echo '<div class="prod-meta-hover-inner">';
        }
    }

    if (!function_exists('yesshop_shop_loop_hover_div_end')) {
        function yesshop_shop_loop_hover_div_end()
        {
            echo '</div><!--prod-meta-hover-inner-->';
            echo '</div><!--prod-meta-hover-wrapper-->';
            echo '</div><!--prod-meta-hover-->';
        }
    }

    if (!function_exists('yesshop_shop_loop_div_end')) {
        function yesshop_shop_loop_div_end()
        {
            echo '</div><!-- yesshop_shop_loop_div_end -->';
        }
    }

    function yesshop_template_loop_product_image_wrap_open()
    {
        echo '<div class="image-wrap">';
    }

    function yesshop_template_loop_product_image_wrap_close()
    {
        echo '</div><!--END .image-wrap-->';
    }

    function yesshop_woocommerce_template_loop_product_title()
    {
        $_title = get_the_title();
        echo '<h3><a href="' . get_permalink() . '" title="' . esc_attr($_title) . '">' . esc_html($_title) . '</a></h3>';
    }

    function yesshop_woocommerce_loop_product_title_open()
    {
        echo '<div class="title-wrap">';
    }

    function yesshop_woo_loop_category_title($category)
    {
        ?>
        <h3><?php echo $category->name; ?></h3>
        <?php
        if ($category->count > 0) {
            echo apply_filters('woocommerce_subcategory_count_html', ' <span class="count">' . sprintf(_n('%s product', '%s products', absint($category->count), 'omeo'), absint($category->count)) . '</span>', $category);
        }

    }

    function yesshop_sale_stock_count()
    {
        global $product;
        if ($product->is_purchasable() && $product->is_in_stock()) {
            $stock_available = $product->get_stock_quantity();
            $stock_sold = ($total_sales = get_post_meta($product->get_id(), 'total_sales', true)) ? round($total_sales) : 0;
            $percen = ($stock_available > 0) ? round($stock_sold / ($stock_sold + $stock_available) * 100) : 0;
            echo '<span class="deal-stock-count">';
            if (absint($stock_available) > 0) {
                printf(_n('Only %s product left!', 'Only %s products left!', absint($stock_available), 'omeo'), $stock_available);
            } else {
                esc_html_e('No limit products left!', 'omeo');
            }
            echo '</span>';
        }
    }

    function yesshop_sale_stock_progress() {
        global $product;
        if ($product->is_purchasable() && $product->is_in_stock()) {
            $stock_available = $product->get_stock_quantity();
            $stock_sold = ($total_sales = get_post_meta($product->get_id(), 'total_sales', true)) ? round($total_sales) : 0;
            $percen = ($stock_available > 0) ? round($stock_sold / ($stock_sold + $stock_available) * 100) : 0;
            ?>
            <div class="prod-stock-progress">
                <?php if (absint($stock_sold) > 0): ?>
                    <span class="already-sold"><?php printf(esc_attr__('Already sold: %d', 'omeo'), absint($stock_sold)); ?></span>
                <?php endif; ?>

                <?php
                if (absint($stock_available) > 0) {
                    $available_str = sprintf(esc_attr__('Available: %d', 'omeo'), absint($stock_available));
                } else {
                    $available_str = esc_attr__('Available: No limit', 'omeo');
                }
                ?>

                <span class="available"><?php echo esc_html($available_str) ?></span>

                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo esc_attr($percen) ?>"
                         aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($percen) ?>%;">
                        <span class="sr-only"><?php echo esc_attr($percen) ?>%</span>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    function yesshop_woocommerce_top_filter()
    {
        if (!class_exists('WooCommerce')) return;
        global $yesshop_datas;

        if (empty($yesshop_datas['shop-top-filters']) || absint($yesshop_datas['shop-top-filters']) === 0) return;

        if (is_shop() || is_product_category()) {

            $_sidebar = !empty($yesshop_datas['shop-top-sidebar']) ? $yesshop_datas['shop-top-sidebar'] : 'shop-widget-area-top';
            ?>
            <div class="shop-filter-top-area">
                <div class="row">
                    <?php
                    if (is_active_sidebar($_sidebar)) {
                        echo '<ul class="widgets-sidebar list-nostyle">';
                        dynamic_sidebar($_sidebar);
                        echo '</ul>';
                    }
                    ?>
                </div>

            </div>
            <?php
        }
    }

    function yeti_woocommerce_shop_top_menu() {
        global $yesshop_datas;
        if($yesshop_datas['shop-top-menu'] == '1'){
			if(has_nav_menu('shop-top-menu')) {
				wp_nav_menu(array(
						'container_class' => 'yeti-shop-top-menu',
						'theme_location' => 'shop-top-menu',
						'walker' => new Yesshop_Mega_Menu_Frontend(),
						'items_wrap' => '<ul class="%1$s %2$s">%3$s</ul>'
				));
			}
        }
    }

    if (!function_exists('yesshop_woocommerce_subcategory_thumbnail')) {
        function yesshop_woocommerce_subcategory_thumbnail($category)
        {
            $small_thumbnail_size = apply_filters('single_product_small_thumbnail_size', 'yesshop_shop_subcat');
            $dimensions = wc_get_image_size($small_thumbnail_size);
            $thumbnail_id = get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);
            if ($thumbnail_id) {
                $image = wp_get_attachment_image_src($thumbnail_id, $small_thumbnail_size);
                $dimensions = array(
                    "width" => $image[1],
                    "height" => $image[2]
                );
                $image = $image[0];
            } else {
                $image = wc_placeholder_img_src();
            }

            if ($image) {
                $image = str_replace(' ', '%20', $image);
                echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($category->name) . '" width="' . esc_attr($dimensions['width']) . '" height="' . esc_attr($dimensions['height']) . '" />';
            }
        }
    }

    if (!function_exists('yesshop_product_labels')) {
        function yesshop_product_labels()
        {
            global $product;
            $resq = false;
            $sale_classes = array('product-labels');
            $output = '';

            if(!$product->is_in_stock()) {
                $output .= "<span class=\"outstock product_label\">" . esc_html__('Out of stock', 'omeo') . "</span>";
                $resq = true;
            } else {
                if ($product->is_on_sale()) {
                    $output .= "<span class=\"onsale show_off product_label\">";
                    if ($product->get_regular_price() > 0) {
                        $_off_percent = (round($product->get_price() / $product->get_regular_price(), 2) - 1) * 100;
                        $output .= esc_attr($_off_percent) . "&#37;";
                    } else {
                        $output .= esc_html__("Save", 'omeo');
                    }
                    $output .= "</span>";
                    $sale_classes[] = "onsale";
                    $resq = true;
                }

                if ($product->is_featured()) {
                    $output .= "<span class=\"featured product_label\">" . esc_html__('New', 'omeo') . "</span>";
                    $sale_classes[] = "featured";
                    $resq = true;
                }
            }

            if ($resq) {
                echo "<div class='" . esc_attr(implode(' ', $sale_classes)) . "'>" . $output . "</div>";
            }

        }
    }

    if (!function_exists('yesshop_single_product_summary_div_end')) {
        function yesshop_single_product_summary_div_end()
        {
            echo '</div><!--End class woocommerce-product-box-wrapper-->';
        }
    }

    if (!function_exists('yesshop_custom_variable_sale_prices')) {
        function yesshop_custom_variable_sale_prices($price, $product)
        {
            if (is_product()) return $price;

            // Main price
            $prices = array($product->get_variation_price('min', true), $product->get_variation_price('max', true));
            $price = $prices[0] !== $prices[1] ? sprintf('%1$s %2$s', wc_price($prices[0]), wc_price($prices[1])) : wc_price($prices[0]);

            // Sale
            $prices = array($product->get_variation_regular_price('min', true), $product->get_variation_regular_price('max', true));
            sort($prices);
            $saleprice = $prices[0] !== $prices[1] ? sprintf('%1$s %2$s', wc_price($prices[0]), wc_price($prices[1])) : wc_price($prices[0]);

            if ($price !== $saleprice) {
                $price = $product->get_price_html_from_to($saleprice, $price) . $product->get_price_suffix();
            }

            return $price;
        }
    }

    if (!function_exists('yesshop_woocommerce_output_related_products_args')) {
        function yesshop_woocommerce_output_related_products_args($args)
        {
            $args['posts_per_page'] = 10;
            return $args;
        }
    }

    if (!function_exists('yesshop_woocommerce_cart_item_remove_link_callback')) {
        function yesshop_woocommerce_cart_item_remove_link_callback($res, $cart_item_key)
        {
            $nonce = wp_create_nonce('_remove_cart_item');
            return sprintf('<a href="%s" class="remove yeti_remove_cart" title="%s" data-key="%s" data-nonce="%s">' . esc_html__('Remove', 'omeo') . '</a>', esc_url(wc_get_cart_remove_url($cart_item_key)), esc_attr__('Remove this item', 'omeo'), $cart_item_key, $nonce);
        }
    }

    if (!function_exists('yesshop_toolbar_wishlist_callback')) {

        function yesshop_toolbar_wishlist_callback()
        {
            add_filter('yith_wcwl_wishlist_params', 'yesshop_yith_wcwl_wishlist_params_callback', 10, 1);
            echo do_shortcode('[yith_wcwl_wishlist]');
            remove_filter('yith_wcwl_wishlist_params', 'yesshop_yith_wcwl_wishlist_params_callback', 10, 1);
        }

        function yesshop_yith_wcwl_wishlist_params_callback($additional_params)
        {
            $additional_params['template_part'] = 'toolbar';
            return $additional_params;
        }
    }

    function yesshop_woocommerce_account_menu_items_filter($items)
    {
        $wl_id = get_option('yith_wcwl_wishlist_page_id', false);
        if (is_array($items) && $wl_id) {
            $wl_arr = array(
                'wishlist' => array(
                    'label' => esc_attr__("My Wishlist", 'omeo'),
                    'url' => get_permalink($wl_id)
                )
            );
            $_before = array_slice($items, 0, 2);
            $_after = array_slice($items, 2);
            $items = array_merge($_before, $wl_arr);
            $items = array_merge($items, $_after);
        }

        foreach ($items as $k => $item) {
            if (is_array($item)) {
                $items[$k]['icon'] = 'fa fa-heart';
            } else {
                switch ($k) {
                    case 'dashboard':
                        $_icon_class = 'fa fa-tachometer';
                        break;
                    case 'orders':
                        $_icon_class = 'fa fa-list';
                        break;
                    case 'downloads':
                        $_icon_class = 'fa fa-download';
                        break;
                    case 'edit-address':
                        $_icon_class = 'fa fa-address-card';
                        break;
                    case 'edit-account':
                        $_icon_class = 'fa fa-user';
                        break;
                    case 'customer-logout':
                        $_icon_class = 'fa fa-sign-out';
                        break;
                    default:
                        $_icon_class = 'fa fa-cog';
                }

                $items[$k] = array(
                    'label' => $item,
                    'icon' => $_icon_class
                );
            }
        }

        return $items;
    }

    if (!function_exists('yesshop_update_shopping_cart_button')) {
        function yesshop_update_shopping_cart_button()
        {
            echo '<input type="submit" class="button" name="update_cart" value="' . esc_html__('Update Cart', 'omeo') . '" />';
        }
    }

    if (!function_exists('yesshop_coupons_form')) {
        function yesshop_coupons_form()
        {
            if (wc_coupons_enabled()) {
                echo '<div class="coupon">';
                printf('<label for="coupon_code">%1$s:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="%2$s" /> <input type="submit" class="button" name="apply_coupon" value="%3$s" />', esc_html__('Coupon', 'omeo'), esc_html__('Coupon code', 'omeo'), esc_html__('Apply Coupon', 'omeo'));
                do_action('woocommerce_cart_coupon');
                echo '</div>';
            }
        }
    }

    if (!function_exists('yesshop_shopping_progress')) {
        function yesshop_shopping_progress()
        {
            $shop_class = $checkout_class = $complete_class = array('progress-item');
            if (is_cart()) $shop_class[] = 'active current-item';
            elseif (is_checkout()) {
                if (!is_order_received_page()) {
                    $shop_class[] = 'active';
                    $checkout_class[] = 'active current-item';
                } else {
                    $shop_class[] = 'active';
                    $checkout_class[] = 'active';
                    $complete_class[] = 'active current-item';
                }
            }

            echo '<div class="nth-shopping-progress-wrapper">';
            echo '<ul class="list-inline">';
            printf('<li class="%1$s">%2$s</li>', esc_attr(implode(' ', $shop_class)), esc_html__("Shopping cart", 'omeo'));
            printf('<li class="%1$s">%2$s</li>', esc_attr(implode(' ', $checkout_class)), esc_html__("Checkout", 'omeo'));
            printf('<li class="%1$s">%2$s</li>', esc_attr(implode(' ', $complete_class)), esc_html__("Order Complete", 'omeo'));
            echo '</ul>';
            echo '</div>';
        }

    }

    if (!function_exists('yesshop_custom_thankyou_title')) {
        function yesshop_custom_thankyou_title($title)
        {
            if (is_checkout() && is_order_received_page()) {
                return esc_html__('Thank you. Your order has been received.', 'omeo');
            } else {
                return $title;
            }
        }
    }

    if (!function_exists('yesshop_woocommerce_cart_item_name')) {
        function yesshop_woocommerce_cart_item_name($title)
        {
            return '<span class="product-title">' . $title . '</span>';
        }
    }

    function yesshop_woo_lost_your_pass($html)
    {
        $html .= '<p class="lost_password">';
        $html .= sprintf('<a href="%1$s" title="%2$s">%2$s</a>', esc_url(wp_lostpassword_url()), esc_html__('Lost your password?', 'omeo'));
        $html .= '</p>';
        return $html;
    }

    function yesshop_woocommerce_checkout_cart_item_quantity($html, $cart_item, $cart_item_key)
    {
        $car_quant = $cart_item['quantity'];
        return '<p><strong class="product-quantity">' . sprintf(_n('%s item', '%s items', $car_quant, 'omeo'), $car_quant) . '</strong></p>';
    }

    function yesshop_toolbar_compare_callback()
    {
        if (!class_exists('YITH_Woocompare')) return;
        wc_get_template('compare-toolbar.php');
    }

    function yesshop_woo_single_product_list_columns($columns)
    {
        global $yesshop_datas;
        if (!empty($yesshop_datas['single-product-list-columns'])) $columns = absint($yesshop_datas['single-product-list-columns']);
        return $columns;
    }

    function yesshop_woocommerce_detail_products_list_columns()
    {
        global $yesshop_datas;
        return !empty($yesshop_datas['single-product-list-columns']) ? absint($yesshop_datas['single-product-list-columns']) : 4;
    }

    function yesshop_single_product_summary_wrap_open()
    {
        echo '<div class="col-md-12 col-sm-24">';
    }

    function yesshop_woocommerce_loop_list_col3_open()
    {
        echo '<div class="price-buttons-wrap">';
    }


    function yesshop_wrap_close()
    {
        echo '</div>';
    }

    function yesshop_woocommerce_loop_excerpt($limit = false)
    {
        global $post;

        if(!$limit) {
            $_var = get_query_var('yeti_excerpt_limit', $limit);
            $limit = (int) $_var < 1 ? false: $_var;
        }

        if (!$post->post_excerpt) return;

        $post_excerpt = $limit? wp_trim_words($post->post_excerpt, $limit): $post->post_excerpt;

        ?>
        <div class="description">
            <?php echo apply_filters('woocommerce_short_description', $post_excerpt); ?>
        </div>
        <?php
    }

    function yesshop_woo_loop_product_thumbnail()
    {
        global $post, $product, $detect;

        $image_size = apply_filters('single_product_archive_thumbnail_size', 'shop_catalog');

        if (has_post_thumbnail()) {
            $props = wc_get_product_attachment_props(get_post_thumbnail_id(), $post);
            echo get_the_post_thumbnail($post->ID, $image_size, array(
                'title' => esc_attr(get_the_title()),
                'alt' => $props['alt'],
            ));

            if ($product->is_in_stock() && Yesshop_Functions()->getThemeData('products-thumb-style') === 'double_img_1' && !$detect->isMobile()) {
                $_galleries = $product->get_gallery_image_ids();
                if (isset($_galleries[0]) && absint($_galleries[0]) > 0) {
                    echo '<div class="prod_hover_images">';
                    $props = wc_get_product_attachment_props($_galleries[0], $post);
                    echo wp_get_attachment_image($_galleries[0], $image_size);
                    echo '</div>';
                }
            }
        } elseif (wc_placeholder_img_src()) {
            echo wc_placeholder_img($image_size);
        }
    }

    function yesshop_include_thumb_id_to_gallery($attachment_ids) {
        global $post, $product;

        array_unshift($attachment_ids, get_post_thumbnail_id($post));
        if ($product->is_type('variable')) {
            $_variations = $product->get_available_variations();
            foreach ($_variations as $data) {
                $_id = get_post_thumbnail_id($data['variation_id']);
                if ($_id && absint($_id) > 0) array_push($attachment_ids, get_post_thumbnail_id($data['variation_id']));
            }
        }
        return array_unique($attachment_ids);
    }

    function yesshop_woocommerce_loop_start_class($class)
    {
        global $yesshop_datas;

        $_style = empty($yesshop_datas['product-item-style']) ? 'classic-1' : $yesshop_datas['product-item-style'];
        switch ($_style) {
            case 'classic-1':
                $class .= ' products-none-style actions-vertical classic-1';
                break;
            case 'classic-2':
                $class .= ' classic-2';
                break;
            default:
                $class .= ' products-none-style actions-vertical classic-1';
        }

        return esc_attr($class);
    }

    function yesshop_woocommerce_loop_cats()
    {
        global $product;
        $terms = get_the_terms( $product->get_id(), 'product_cat' );
        if ( is_wp_error( $terms ) )
            return $terms;

        if ( empty( $terms ) )
            return false;

        $links = array();

        $i = 0;
        foreach ( $terms as $term ) {
            if($i === 2) break;
            $link = get_term_link( $term, 'product_cat' );
            if ( is_wp_error( $link ) ) {
                return $link;
            }
            $links[] = '<a href="' . esc_url( $link ) . '" rel="tag">' . $term->name . '</a>';
            $i++;
        }

        $term_links = apply_filters( "term_links-product_cat", $links );

        echo '<div class="meta-cats">' . join( ' / ', $term_links ) . '</div>';
    }

    function yesshop_print_custom_tab()
    {
        global $yesshop_datas;
        echo do_shortcode(stripslashes(htmlspecialchars_decode($yesshop_datas['custom_tab_content'])));
    }

    function yesshop_print_product_accessories_tab()
    {
        wc_get_template('single-product/tabs/accessories.php');
    }

    function yesshop_single_product_summary_title_cat(){
        global $post;
        $cats = get_the_terms($post->ID, 'product_cat');
        if(!empty($cats)) {
            echo '<span class="product-cat-lable">'.esc_html($cats[0]->name).'</span>';
        }
    }

    function yesshop_woocommerce_single_product_links(){
        ?>
        <div class="yeti-product-navi-links hidden-xs hidden-sm">
            <?php next_post_link('%link', '%title', TRUE, '', 'product_cat');?>
            <?php previous_post_link('%link', '%title', TRUE, '', 'product_cat');?>
        </div>
        <?php
    }

    function yesshop_single_product_links_custom($output, $format, $link, $post, $adjacent){
        if($post && get_post_type($post) === 'product') {
            $product = wc_get_product($post);

            if($image = $product->get_image()) {
                if($adjacent === 'next') {
                    $output = '<div class="next-link pull-right">' . $output . $image . '</div>';
                } else {
                    $output = '<div class="prev-link pull-left">' . $image . $output . '</div>';
                }
            }

        }
        return $output;
    }

    function yesshop_stock_catalog() {
        global $product;
        if ( $product->is_in_stock() ) {
            echo '<div class="stock"><strong>' . __( 'Availability:', 'omeo' )  . '</strong>' .__( 'In stock', 'omeo' ) . '</div>';
        } else {
            echo '<div class="out-of-stock"><strong>' . __( 'Availability:', 'omeo' ). '</strong>'.__( 'Out of stock', 'omeo' ) . '</div>';
        }
    }
}

if (class_exists('YITH_Woocompare_Frontend') && class_exists('YITH_Woocompare')) {

    if (!function_exists('yesshop_add_compare_link')) {
        function yesshop_add_compare_link()
        {

            global $yith_woocompare, $product;
            $fontend = $yith_woocompare->obj;
            $product_id = $product->get_id();

            $_pos = Yesshop_Functions()->get_tooltip_pos();
            $tooltip = ($_pos)? 'tooltip': 'false';

            printf('<a href="%s" class="%s" data-product_id="%d" title="%s" data-toggle="%s" data-placement="%s">%s</a>',
                $fontend->add_product_url($product_id),
                'yeti-compare button',
                $product_id,
                esc_attr__('Add to compare', 'omeo'),
                esc_attr($tooltip),
                esc_attr($_pos),
                esc_attr__('Compare', 'omeo')
            );
        }
    }

    function yesshop_woocompare_view_table_url() {
        global $yesshop_datas;

        if (empty($yesshop_datas['compare_page_id'])) {
            return get_permalink(get_page_by_path('compare'));
        } else {
            return get_permalink($yesshop_datas['compare_page_id']);
        }
    }
}