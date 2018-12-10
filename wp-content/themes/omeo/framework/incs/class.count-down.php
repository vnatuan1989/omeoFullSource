<?php

if (!class_exists('Yesshop_CountDown')) {
    class Yesshop_CountDown
    {

        public function __construct()
        {
            add_action('wp', array($this, 'init'), 20);
        }

        public function init()
        {
            global $detect;
            if ($detect->isMobile() && !$detect->isTablet()) return;

            add_action('wp_enqueue_scripts', array($this, 'init_scripts'), 20);
            add_action('woocommerce_before_shop_loop_item_title', array(__CLASS__, 'countdown_render'), 90);
            add_action('woocommerce_single_product_summary', array(__CLASS__, 'countdown_render'), 23);
        }

        public function init_scripts()
        {
            wp_register_script('jquery.countdown.min', THEME_JS_URI . 'jquery.countdown.min.js', false, '2.0.5', true);
            wp_enqueue_script('jquery.countdown.min');
        }

        public static function countdown_render()
        {
            global $post, $product, $yesshop_datas, $detect;

            if ($detect->isMobile() && !$detect->isTablet()) return;

            $date_format = isset($yesshop_datas['product-deal-format']) ? $yesshop_datas['product-deal-format'] : '%D Days/%H Hours/%M Min/%S Sec';
            $date_format = array_map('trim', explode('/', wp_strip_all_tags($date_format)));
            $date_format_str = '';
            foreach ($date_format as $_str) {
                $_str = array_map('trim', explode(' ', $_str));
                $date_format_str .= sprintf('<div><span>%s</span>%s</div>', $_str[0], $_str[1]);
            }
            switch ($product->get_type()) {
                case 'external':
                case 'simple':
                    if (!$product->is_in_stock()) return false;

                    $sale_price = $product->get_price();
                    $regular_price = $product->get_regular_price();
                    if ($regular_price <= $sale_price) return false;

                    $__date_from = get_post_meta($post->ID, '_sale_price_dates_from', true);
                    $__date_to = get_post_meta($post->ID, '_sale_price_dates_to', true);

                    $__today = strtotime(date("m/d/Y H:i:s"));

                    $check_indeal = self::checkInDeals($__date_from, $__today, $__date_to);

                    if ($check_indeal) :
                        $data = array(
                            'dateTo' => esc_attr(date('Y', $__date_to) . '/' . date('m', $__date_to) . '/' . date('d', $__date_to)),
                            'format' => $date_format_str,
                        );
                        ?>
                        <div class="clear"></div>
                        <div class="yeti-countdown simple hidden-xs"
                             data-atts="<?php echo esc_attr(json_encode($data)); ?>"></div>

                        <?php
                    endif;

                    break;
                case 'variable':
                    $available_variations = $product->get_available_variations();
                    $__date_from = $__date_to = -1;
                    for ($i = 0; $i < count($available_variations); $i++) {
                        $variation_id = $available_variations[$i]['variation_id'];

                        $variable_product = new WC_Product_Variation($variation_id);
                        if (!$variable_product->is_in_stock()) continue;
                        $sale_price = $variable_product->get_sale_price();
                        $regular_price = $variable_product->get_regular_price();

                        if ($regular_price <= $sale_price) continue;
                        $date_from = get_post_meta($variable_product->get_id(), '_sale_price_dates_from', true);
                        $date_to = get_post_meta($variable_product->get_id(), '_sale_price_dates_to', true);

                        if ($__date_from == -1 || $__date_from > $date_from) $__date_from = $date_from;
                        if ($date_to > $__date_to) $__date_to = $date_to;

                    }

                    $__today = strtotime(date("m/d/Y H:i:s"));

                    $check_indeal = self::checkInDeals($__date_from, $__today, $__date_to);

                    if ($check_indeal) :
                        $_random_id = 'count_down_' . $post->ID . wp_rand();
                        $data = array(
                            'dateTo' => esc_attr(date('Y', $__date_to) . '/' . date('m', $__date_to) . '/' . date('d', $__date_to)),
                            'format' => $date_format_str,
                        );
                        ?>
                        <div class="clear"></div>
                        <div class="yeti-countdown variable hidden-xs"
                             data-atts="<?php echo esc_attr(json_encode($data)); ?>"></div>

                        <?php
                    endif;

                    break;
            }
        }

        public static function checkInDeals($from, $now, $to)
        {
            if ($from !== -1 && $now !== -1 && $to !== -1) {
                if ($to >= $now && $now >= $from) return true;
                else return false;
            }
        }


    }

    function Yesshop_CountDown()
    {
        return Yesshop_CountDown::get_instance();
    }

    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        new Yesshop_CountDown();
    }

}