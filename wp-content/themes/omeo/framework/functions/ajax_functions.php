<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('Yesshop_Ajax')) {

    class Yesshop_Ajax
    {

        function __construct()
        {
            $this->init();
        }

        public function init()
        {
            $ajax_events = array(
                'add_widgetsidebar' => false,
                'del_widgetsidebar' => false,
                'get_newsletter_popup' => true,
                'ajax_login' => true,
                'update_cart' => true,
                'tta_tabs_content' => true,
                'reset_stylesheet'  => false
            );

            if (class_exists('WooCommerce')) {
                $ajax_events['woo_remove_cart_item'] = true;
                $ajax_events['woo_getproductinfo'] = true;

                if (class_exists('YITH_WCWL_UI') && class_exists('YITH_WCWL')) {
                    $ajax_events['added_to_wishlist'] = true;
                }

                if (class_exists('YITH_Woocompare')) {
                    $ajax_events['added_to_compare'] = true;
                }

                $ajax_events['accessories_checked_price'] = true;
                $ajax_events['accessories_add_to_cart'] = true;

            }

            foreach ($ajax_events as $ajax_event => $nopriv) {
                add_action('wp_ajax_yesshop_' . $ajax_event, array(__CLASS__, $ajax_event));
                if ($nopriv) {
                    add_action('wp_ajax_nopriv_yesshop_' . $ajax_event, array(__CLASS__, $ajax_event));
                }
            }

            /**
             * CUSTOM AJAX CART
             **/
            add_filter('woocommerce_add_to_cart_fragments', array(__CLASS__, 'woo_cart_fragments'));
        }

        public static function add_widgetsidebar()
        {
            $option_name = 'yesshop_custom_sidebars';
            $name = trim($_REQUEST['sidebar_name']);
            $desc = trim($_REQUEST['sidebar_desc']);
            $slug = sanitize_title($name);
            if (strlen($slug) == 0) die(esc_html__("Please enter your sidebar name!", 'omeo'));

            if (!wp_verify_nonce($_REQUEST['_wpnonce_nth_add_sidebar'], 'nth-add-sidebar-widgets')) die('Security check');

            if (!get_option($option_name) || get_option($option_name) == '') delete_option($option_name);

            if ($data = get_option($option_name)) {
                $data = unserialize($data);
                foreach ($data as $k => $v) {
                    if ($k == $slug) die(esc_html__("This name was used.", 'omeo'));
                }
                $data[$slug] = array(
                    'name' => $name,
                    'desc' => $desc
                );
                $result = update_option($option_name, serialize($data));
            } else {
                $data = array();
                $data[$slug] = array(
                    'name' => $name,
                    'desc' => $desc
                );
                $result = add_option($option_name, serialize($data));
            }

            if ($result) die("success"); else die("Update error!");
        }

        public static function del_widgetsidebar()
        {
            $id = trim($_REQUEST['sidebar_id']);
            if (strlen($id) == 0) die('error');
            $option_name = 'yesshop_custom_sidebars';

            if ($data = get_option($option_name)) {
                $data = unserialize($data);
                if (array_key_exists($id, $data)) {
                    unset($data[$id]);
                }
                if (count($data) > 0) $result = update_option($option_name, serialize($data));
                else delete_option($option_name);
            }
            die();
        }

        public static function _rgb2hex($rgb){
            $hex = "#";
            $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

            return $hex;
        }

        public static function reset_stylesheet(){
            global $wp_filesystem, $yesshop_datas;
            $options = $yesshop_datas;

            if(empty($_REQUEST['scheme'])) wp_die();
            $scheme = $_REQUEST['scheme'];

            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            if (empty($file)) {
                $file = THEME_DIR . 'less/typo_variables_'.esc_attr($scheme).'.less';
            }

            if(!file_exists($file)) wp_die();

            $file_data = $wp_filesystem->get_contents($file);

            $file_data = str_replace("\r", "\n", $file_data);
            $file_data = explode("\n", $file_data);

            foreach ($file_data as $k => $line) {
                if (strlen(trim($line)) == 0 || (preg_match('/^(\/\*|\/|\*| \*)/', $line, $match) && $match[1])) {
                    continue;
                }
                if (preg_match('/^\@(.*?)\:(.*?);/', $line, $match) && $match[0]) {
                    $_key = str_replace('@', '', $line);
                    $_key = str_replace(';', '', $_key);
                    $_key = array_map('trim', explode(':', $_key));
                    if (!empty($options[$_key[0]])) {
                        if (!is_array($options[$_key[0]])) {
                            $options[$_key[0]] = $_key[1];
                        } elseif (!empty($options[$_key[0]]['alpha'])) {
                            $rgb = str_replace('rgb(', '', $_key[1]);
                            $rgb = str_replace('rgba(', '', $rgb);
                            $rgb = str_replace(')', '', $rgb);
                            $rgb = array_map('trim', explode(',', $rgb));

                            $color = self::_rgb2hex($rgb);
                            if(isset($rgb[3])) $options[$_key[0]]['alpha'] = $rgb[3];
                            $options[$_key[0]]['color'] = $color;
                            $options[$_key[0]]['rgba']  = $_key[1];
                        } elseif (!empty($options[$_key[0]]['regular'])) {
                            $options[$_key[0]]['regular'] = $_key[1];
                        } elseif (!empty($options[$_key[0]]['font-family'])) {
                            if(strpos($_key[1], ',') === false) {
                                $_key[1] = str_replace("'", '', $_key[1]);
                            }
                            $options[$_key[0]]['font-family'] = $_key[1];
                        }
                    } elseif (preg_match('/(.*?)(_hover|_active|_weight|_style|_size|_trans)$/', trim($_key[0]), $match) && $match[0]) {
                        if (!empty($options[$match[1]])) {
                            switch ($match[2]) {
                                case '_weight':
                                    $options[$match[1]]['font-weight'] = absint($_key[1]);
                                    break;
                                case '_trans':
                                    $options[$match[1]]['text-transform'] = $_key[1];
                                    break;
                                case '_size':
                                    $options[$match[1]]['font-' . substr($match[2], 1)] = $_key[1];
                                    break;
                                default:
                                    $options[$match[1]][substr($match[2], 1)] = $_key[1];
                            }
                        }
                    }
                } else continue;
            }

            update_option('yesshop_datas', $options);

            wp_die();
        }

        public static function woo_remove_cart_item()
        {
            $key = $_REQUEST['key'];
            $nonce = $_REQUEST['nonce'];
            if (!wp_verify_nonce($nonce, '_remove_cart_item')) wp_die('Security check');
            $result = WC()->cart->remove_cart_item($key);
            WC_AJAX::get_refreshed_fragments();
            wp_die();
        }

        public static function woo_getproductinfo()
        {
            $pro_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : 0;
            $meta_query = WC()->query->get_meta_query();
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 1,
                'no_found_rows' => 1,
                'post_status' => 'publish',
                'meta_query' => $meta_query
            );
            $args['p'] = $pro_id;

            $products = new WP_Query($args);

            while ($products->have_posts()) : $products->the_post();
                global $product;

                printf('<div class="nth_add_to_cart_product_info"><a href="%s" title="%s">%s<span class="product-title">%s</span></a>%s</div>', esc_url(get_permalink($product->get_id())), esc_attr($product->get_title()), $product->get_image(), $product->get_title(), $product->get_price_html());

            endwhile;

            wp_reset_postdata();
            die();
        }

        public static function get_newsletter_popup()
        {
            if (!function_exists('Yetithemes_StaticBlock')) wp_die();
            $slug = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
            ob_start();
            ?>
            <div class="yeti-popup animated zoomIn" id="yeti_newsletter_popup">
                <div class="yeti-newsletter popup-wrapper">
                    <div class="popup-content">
                        <?php Yetithemes_StaticBlock()->getContentByID($slug); ?>
                    </div>
                    <div class="popup-footer">
                        <a href="#" class="popup-cookie-close"
                           title="<?php esc_attr_e("Don't show this again", 'omeo') ?>"
                           data-time="1"><?php esc_html_e("Don't show it again", 'omeo') ?></a>
                    </div>
                </div>
            </div>
            <?php

            echo ob_get_clean();
            die();
        }

        public static function ajax_login()
        {
            $creds = array();
            $creds['user_login'] = esc_attr($_POST['log']);
            $creds['user_password'] = esc_attr($_POST['pwd']);
            $creds['remember'] = isset($_POST['remember']) ? esc_attr($_POST['remember']) : false;
            $user = wp_signon($creds, false);

            $json = array('redirect_to' => esc_url($_POST['redirect_to']));
            $json['code'] = $user->get_error_code();
            if (is_wp_error($user)) {
                $json['mess'] = $user->get_error_message();
            } else {
                $json['mess'] = esc_html__('Login success!', 'omeo');
            }
            echo wp_json_encode($json);
            wp_die();
        }

        public static function added_to_wishlist()
        {
            $wishlist_count = yith_wcwl_count_products();
            $fragments = array();
            $fragments['.toolbar_item.nth-wishlist-item > a .nth-icon'] = sprintf('<span class="nth-icon icon-nth-heart" data-count="%s"></span>', absint($wishlist_count));
            ob_start(); ?>
            <div class="nth-toolbar-popup-cotent"><?php do_action('yesshop_toolbar_wishlist'); ?></div>
            <?php
            $fragments['.toolbar_item.nth-wishlist-item > .nth-toolbar-popup-cotent'] = ob_get_clean();
            wp_send_json($fragments);
        }

        public static function added_to_compare()
        {
            global $yith_woocompare;
            $fontend = $yith_woocompare->obj;
            $compare_count = count($fontend->products_list);
            $fragments = array();
            $fragments['.toolbar_item.yeti-compare-item > a .nth-icon'] = sprintf('<span class="nth-icon icon-nth-exchange" data-count="%s"></span>', absint($compare_count));
            ob_start(); ?>
            <div class="nth-toolbar-popup-cotent"><?php do_action('yesshop_toolbar_compare'); ?></div>
            <?php $fragments['.toolbar_item.yeti-compare-item > .nth-toolbar-popup-cotent'] = ob_get_clean();

            wp_send_json($fragments);
        }

        public static function woo_cart_fragments($fragments)
        {

            $fragments['.nth-shopping-hover .arrow_down'] = '<small class="arrow_down">' . sprintf(_n('%s item', '%s items', absint(WC()->cart->cart_contents_count), 'omeo'), absint(WC()->cart->cart_contents_count)) . '</small>';

            $fragments['.nth-shopping-hover i.yeti-icon'] = '<i class="yeti-icon yeti-shopping-bag" aria-hidden="true" data-count="'.absint(WC()->cart->cart_contents_count).'"></i>';

            $fragments['.nth-shopping-hover span.cart-total'] = '<span class="cart-total hidden-xs">' . WC()->cart->get_cart_total() . '</span>';

            $fragments['.main-sidebar.sidebar-right .offcanvas-heading .heading-title'] = '<h3 class="widget-title heading-title">' . sprintf(_n('%s item in the shopping bad', '%s items in the shopping bad', absint(WC()->cart->cart_contents_count), 'omeo'), absint(WC()->cart->cart_contents_count)) . '</h3>';

            return $fragments;
        }

        public static function update_cart()
        {
            if (!class_exists('WC_AJAX')) wp_die(0);
            WC_AJAX::get_refreshed_fragments();
            wp_die();
        }

        public static function tta_tabs_content()
        {
            $content = htmlspecialchars_decode(urldecode($_REQUEST['content']));
            $content = wpautop(preg_replace('/<\/?p\>/', "\n", $content) . "\n");
            echo do_shortcode(shortcode_unautop($content));
            wp_die();
        }

        public static function accessories_checked_price()
        {
            check_ajax_referer('__YESSHOP_NONCE_658', 'security');
            global $product;
            $ids = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : array();
            $_total = 0;

            foreach ($ids as $id) {
                $product = wc_get_product($id);
                $_total += absint($product->get_price());
            }
            $fragments = array(
                '.single-product .woocommerce-tabs .accessories .total-price .price' => '<span class="price">' . wc_price($_total) . $product->get_price_suffix() . '</span>',
                '.single-product .woocommerce-tabs .accessories .total-price .total-products' => '<span class="total-products">' . sprintf(esc_html__('for %s items', 'omeo'), count($ids)) . '</span>'
            );

            wp_send_json($fragments);
        }

        public static function accessories_add_to_cart()
        {
            check_ajax_referer('__YESSHOP_NONCE_658', 'security');

            $product_ids = apply_filters('woocommerce_add_to_cart_product_ids', $_POST['ids']);

            if (!empty($product_ids)) {

                foreach ($product_ids as $product_id) {
                    $product_status = get_post_status($product_id);

                    if (false !== WC()->cart->add_to_cart($product_id, 1) && 'publish' === $product_status) {
                        do_action('woocommerce_ajax_added_to_cart', $product_id);

                        if (get_option('woocommerce_cart_redirect_after_add') == 'yes') {
                            wc_add_to_cart_message(array($product_id => 1), true);
                        }
                    }
                }

                WC_AJAX::get_refreshed_fragments();
            } else {
                $data = array(
                    'error' => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_ids[0]), $product_ids[0])
                );

                wp_send_json($data);
            }

            die();
        }

    }

    new Yesshop_Ajax();

}

