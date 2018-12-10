<?php

if (!class_exists('Yesshop_WC_Helper')) {
    class Yesshop_WC_Helper
    {
        private static $instance = null;
        private $_hooks = array();

        public static function get_instance()
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function init()
        {
            add_action('init', array($this, 'init_hook'), 99);
        }

        public function init_hook()
        {
            $this->build_product_loop_hooks();
            $this->build_single_hooks();
        }

        public function _get_product_view()
        {
            global $yesshop_datas;

            if (!empty($_REQUEST['products_view'])) {
                $_pro_view = trim($_REQUEST['products_view']);
                $yesshop_datas['product-item-style'] = $_pro_view;
            } elseif (!empty($yesshop_datas['product-item-style'])) {
                $_pro_view = $yesshop_datas['product-item-style'];
            } else $_pro_view = 'classic-1';

            return $_pro_view;
        }

        public function _callback_general()
        {
            remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'yesshop_woo_loop_product_thumbnail', 10);

            $this->_hooks['remove'] = array(
                array('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10),
                array('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10),
                array('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5)
            );

            $this->_hooks['add'] = array(
                array('woocommerce_before_shop_loop_item',          'yesshop_template_loop_product_image_wrap_open', 2),
                array('woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_product_link_open', 9),
                array('woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_product_link_close', 11),
                array('woocommerce_before_shop_loop_item_title',    'yesshop_template_loop_product_image_wrap_close', 999),
                array('woocommerce_shop_loop_item_title',           create_function('', 'echo "<div class=\"title-wrap\">";'), 1),
                array('woocommerce_shop_loop_item_title',           'yesshop_woocommerce_template_loop_product_title', 10),
                array('woocommerce_after_shop_loop_item_title',     'yesshop_woocommerce_loop_excerpt', 6),
                array('woocommerce_after_shop_loop_item_title',     create_function('', 'echo "<div class=\"price-buttons-wrap\">";'), 9),
                array('woocommerce_after_shop_loop_item',           create_function('', 'echo "</div>";'), 100)
            );
        }

        public function _callback_default()
        {
            $this->_callback_general();

            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', 'yesshop_wrap_close', 6);

            if (class_exists('YITH_Woocompare')) {
                $this->_hooks['add'][] = array('woocommerce_before_shop_loop_item_title', 'yesshop_add_compare_link', 20);
                $this->_hooks['add'][] = array('woocommerce_after_add_to_cart_button', 'yesshop_add_compare_link', 20);
            }
            if (class_exists('YITH_WCWL')) {
                $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', create_function('', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );'), 11);
            }
        }

        public function _callback_shadow_s1()
        {
            $this->_callback_general();

            $this->_hooks['add'][] = array('woocommerce_before_shop_loop_item', 'yesshop_after_section_start', 1);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_wrap_close', 99999);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);
            $this->_hooks['add'][] = array('woocommerce_shop_loop_item_title', 'yesshop_woocommerce_loop_cats', 9);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', create_function('', "echo '<div class=\"buttons-inner\">';"), 9);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_wrap_close', 101);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_wrap_close', 101);


            $this->_hooks['remove'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            $this->_hooks['remove'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

            if (class_exists('YITH_Woocompare')) {
                $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_add_compare_link', 8);
                $this->_hooks['add'][] = array('woocommerce_after_add_to_cart_button', 'yesshop_add_compare_link', 20);
            }

            if (class_exists('YITH_WCWL')) {
                $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', create_function('', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );'), 9);
            }
        }

        public function _callback_shadow_none(){
            $this->_callback_general();

            $this->_hooks['add'][] = array('woocommerce_before_shop_loop_item', 'yesshop_after_section_start', 1);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_wrap_close', 99999);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
            $this->_hooks['add'][] = array('woocommerce_shop_loop_item_title', 'yesshop_woocommerce_loop_cats', 9);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', create_function('', "echo '<div class=\"buttons-inner\">';"), 9);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_wrap_close', 101);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_wrap_close', 101);

            $this->_hooks['remove'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

            if (class_exists('YITH_Woocompare')) {
                $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_add_compare_link', 8);
                $this->_hooks['add'][] = array('woocommerce_after_add_to_cart_button', 'yesshop_add_compare_link', 20);
            }

            if (class_exists('YITH_WCWL')) {
                $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', create_function('', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );'), 9);
            }
        }

        public function _callback_classic_rounded(){
            $this->_callback_shadow_none();
        }

        public function _callback_border_rounded(){
            $this->_callback_general();

            $this->_hooks['add'][] = array('woocommerce_before_shop_loop_item', 'yesshop_after_section_start', 1);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_wrap_close', 99999);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', create_function('', "echo '<div class=\"buttons-inner\">';"), 9);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_wrap_close', 101);
            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_wrap_close', 101);


            $this->_hooks['remove'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            $this->_hooks['remove'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

            if (class_exists('YITH_Woocompare')) {
                $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', 'yesshop_add_compare_link', 8);
                $this->_hooks['add'][] = array('woocommerce_after_add_to_cart_button', 'yesshop_add_compare_link', 20);
            }

            if (class_exists('YITH_WCWL')) {
                $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item', create_function('', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );'), 9);
            }
        }

        /*YESSHOP STYLE*/
        public function _callback_classic_1(){
            remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'yesshop_woo_loop_product_thumbnail', 10);

            $this->_hooks['remove'] = array(
                array('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10),
                array('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10),
                array('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5)
            );

            //Before Shop Loop Item
            $this->_hooks['add'] = array(
                array('woocommerce_before_shop_loop_item', function () {echo '<div class="product-item-inner">';}, 1),
                array('woocommerce_before_shop_loop_item',          'yesshop_template_loop_product_image_wrap_open', 2),

                array('woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_product_link_open', 9),
                array('woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_product_link_close', 11),
                array('woocommerce_before_shop_loop_item_title',    'yesshop_template_loop_product_image_wrap_close', 999),

                array('woocommerce_shop_loop_item_title',           create_function('', 'echo "<div class=\"title-wrap\">";'), 10),
                array('woocommerce_shop_loop_item_title',           'yesshop_woocommerce_template_loop_product_title', 20),
                

                array('woocommerce_after_shop_loop_item_title',     'woocommerce_template_loop_price', 5),
                array('woocommerce_after_shop_loop_item_title',     'yesshop_woocommerce_loop_excerpt', 6),
                array('woocommerce_after_shop_loop_item_title', function () {echo '<div class="product-item-action">';}, 7),
                array('woocommerce_after_shop_loop_item_title', function () {echo '<div class="wp-table">';}, 8),
                array('woocommerce_after_shop_loop_item_title', function () {echo '<div class="wp-table-cell cell-add-to-cart">';}, 9),
                array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10),
                array('woocommerce_after_shop_loop_item_title', function () {echo '</div>';}, 11),
                array('woocommerce_after_shop_loop_item_title', function () {echo '<div class="wp-table-cell last">';}, 12),
                array('woocommerce_after_shop_loop_item_title', function () {echo '</div>';}, 18),
                array('woocommerce_after_shop_loop_item_title', function () {echo '</div>';}, 19),
                array('woocommerce_after_shop_loop_item_title', function () {echo '</div>';}, 20),

                array('woocommerce_after_shop_loop_item_title',           create_function('', 'echo "</div>";'), 30),
                array('woocommerce_after_shop_loop_item_title',           create_function('', 'echo "</div>";'), 40)
            );


            if (class_exists('YITH_Woocompare')) {
                $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', 'yesshop_add_compare_link', 14);
            }
            if (class_exists('YITH_WCWL')) {
                $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', create_function('', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );'), 13);
            }

            //Remove default element
            $this->_hooks['remove'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
            $this->_hooks['remove'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);
            $this->_hooks['remove'][] = array('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            $this->_hooks['remove'][] = array('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        }
		
		public function _callback_classic_2() {
            $this->_callback_classic_1();
        }

        public function _callback_classic_border() {
            $this->_callback_classic_1();
        }

        public function _callback_shadow_1() {
            $this->_callback_classic_1();
        }

        public function _callback_classic_round() {
            remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'yesshop_woo_loop_product_thumbnail', 10);

            $this->_hooks['remove'] = array(
                array('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10),
                array('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10),
                array('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5)
            );

            $this->_hooks['add'] = array(
                array('woocommerce_before_shop_loop_item',          'yesshop_template_loop_product_image_wrap_open', 2),
                array('woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_product_link_open', 9),
                array('woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_product_link_close', 11),
                array('woocommerce_before_shop_loop_item_title',    'yesshop_template_loop_product_image_wrap_close', 999),
                array('woocommerce_shop_loop_item_title',           create_function('', 'echo "<div class=\"title-wrap\">";'), 1),
                array('woocommerce_shop_loop_item_title',           'yesshop_woocommerce_template_loop_product_title', 10),
                array('woocommerce_after_shop_loop_item_title',     'yesshop_woocommerce_loop_excerpt', 6),
                array('woocommerce_before_shop_loop_item',          function() {echo '<div class="img-btns-wrap">';},  11),
                array('woocommerce_before_shop_loop_item',          function() {echo '</div>';},  16)
            );

            $this->_hooks['add'][] = array('woocommerce_after_shop_loop_item_title', function(){echo '</div><!--END .title-wrap-->';}, 10);
            if (class_exists('YITH_Woocompare')) {
                $this->_hooks['add'][] = array('woocommerce_before_shop_loop_item', 'yesshop_add_compare_link', 12);

            }
            if (class_exists('YITH_WCWL')) {
                $this->_hooks['add'][] = array('woocommerce_before_shop_loop_item', create_function('', 'echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );'), 14);
            }
        }

        public function clear_current_hooks()
        {
            //clear currently hook
            if (!empty($this->_hooks)) {
                foreach ($this->_hooks as $k => $_hooks) {
                    if ($k === 'remove') {
                        foreach ($_hooks as $_hook) {
                            add_action($_hook[0], $_hook[1], $_hook[2]);
                        }
                    } else {
                        foreach ($_hooks as $_hook) {
                            remove_action($_hook[0], $_hook[1], $_hook[2]);
                        }
                    }
                }
            }
        }

        public function restore_def_hooks()
        {
            $this->clear_current_hooks();

            $_prod_view = $this->_get_product_view();
            $_prod_view = str_replace('-', '_', $_prod_view);
            if (method_exists($this, '_callback_' . $_prod_view)) {
                call_user_func(array($this, '_callback_' . $_prod_view));
            }

            foreach ($this->_hooks as $k => $_hooks) {
                if ($k === 'add') {
                    foreach ($_hooks as $_hook) {
                        add_action($_hook[0], $_hook[1], $_hook[2]);
                    }
                } else {
                    foreach ($_hooks as $_hook) {
                        remove_action($_hook[0], $_hook[1], $_hook[2]);
                    }
                }
            }
        }

        public function build_product_loop_hooks($_prod_view = null, $_clear = false)
        {
            if ($_prod_view === null) {
                $_prod_view = $this->_get_product_view();
            } elseif ($_clear) {
                $this->clear_current_hooks();
            }

            if (method_exists($this, '_callback_' . $_prod_view)) {
                call_user_func(array($this, '_callback_' . $_prod_view));
            }

            foreach ($this->_hooks as $k => $_hooks) {
                if ($k === 'add') {
                    foreach ($_hooks as $_hook) {
                        add_action($_hook[0], $_hook[1], $_hook[2]);
                    }
                } else {
                    foreach ($_hooks as $_hook) {
                        remove_action($_hook[0], $_hook[1], $_hook[2]);
                    }
                }
            }
            if ($_prod_view !== null) {
                $this->restore_def_hooks();
            }
        }

        public function build_single_hooks()
        {
            global $yesshop_datas;

            if (isset($yesshop_datas['single-product-list'])) {
                switch ($yesshop_datas['single-product-list']) {
                    case 'related';
                        remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
                        break;
                    case 'up-sells':
                        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
                        break;
                    case 'both':
                        break;
                    default:
                        remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
                        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
                }
            }


            add_filter('woocommerce_related_products_columns', 'yesshop_woocommerce_detail_products_list_columns', 10);

            if (!empty($_REQUEST['product-page-style'])) $yesshop_datas['product-page-style'] = esc_attr($_REQUEST['product-page-style']);

            if (isset($yesshop_datas['product-page-style'])) {
                switch (absint($yesshop_datas['product-page-style'])) {
                    case 2:
                        add_action('woocommerce_single_product_summary', 'yesshop_single_product_summary_wrap_open', 1);
                        add_action('woocommerce_single_product_summary', 'yesshop_wrap_close', 21);
                        add_action('woocommerce_single_product_summary', 'yesshop_single_product_summary_wrap_open', 21);
                        add_action('woocommerce_single_product_summary', 'yesshop_wrap_close', 99);
                        break;
                    case 4:
                        add_action('woocommerce_after_single_product_summary', function () { echo '<div class="container">'; } ,9);
                        add_action('woocommerce_after_single_product_summary', function () { echo '</div>'; } ,11);
                        break;
                    case 6:
                        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
                        if(function_exists('is_product') && is_product()) { 
                            add_filter('yesshop_main_container', function(){return 'full-width-wrapper container-fluid';}, 99);
                        }
                        break;
                }

            }

            if (isset($yesshop_datas['product-detail-meta']) && absint($yesshop_datas['product-detail-meta']) === 0) {
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
            }
            if (isset($yesshop_datas['product-detail-social']) && absint($yesshop_datas['product-detail-social']) === 0) {
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
            }

            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 29);
            add_action('woocommerce_single_product_summary', 'yesshop_stock_catalog', 28);
            add_filter( 'woocommerce_get_stock_html', '__return_empty_string' );

            add_action('woocommerce_after_single_product', 'yesshop_woocommerce_single_product_links', 50);

            if(class_exists('WooCommerce')) {
                add_filter('next_post_link', 'yesshop_single_product_links_custom', 10, 5);
                add_filter('previous_post_link', 'yesshop_single_product_links_custom', 10, 5);
            }
        }

        public function get_accessories($product)
        {
            if (!$acc_ids = $product->get_meta('_accessory_ids'))  return array();
            return apply_filters('woocommerce_product_accessory_ids', (array)maybe_unserialize($acc_ids), $product);
        }
    }

}

function Yesshop_WC_Helper()
{
    return Yesshop_WC_Helper::get_instance();
}

Yesshop_WC_Helper()->init();