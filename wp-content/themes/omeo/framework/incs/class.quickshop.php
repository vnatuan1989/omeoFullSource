<?php

if (!class_exists('Yesshop_Quickshop')) {
    class Yesshop_Quickshop
    {
        private $options = array();

        public function __construct()
        {
            $this->setOptions(array(
                "label" => esc_html__("Quick shop", 'omeo'),
            ));

            add_action('init', array($this, 'init_hook'));
            add_action('init', array($this, 'init_ajaxHandle'));
        }

        public function setOptions($options)
        {
            $this->options = $options;
        }

        public function init_hook()
        {
            global $yesshop_datas;
            if (isset($yesshop_datas['shop-quickshop']) && absint($yesshop_datas['shop-quickshop']) == 0) return;
            add_action('wp_enqueue_scripts', array($this, 'registerScript'));
            add_action('woocommerce_after_shop_loop_item_title', array(__CLASS__, 'quickshop_btn'), 15);
        }

        public function registerScript()
        {
            wp_enqueue_script('wc-add-to-cart-variation');
        }

        public function init_ajaxHandle()
        {
            global $yesshop_datas;
            if (isset($yesshop_datas['shop-quickshop']) && absint($yesshop_datas['shop-quickshop']) == 0) return;
            add_action('wp_ajax_quickshop_prod_content', array($this, 'ajax_callback_func'));
            add_action('wp_ajax_nopriv_quickshop_prod_content', array($this, 'ajax_callback_func'));
        }

        public function update_add_to_cart_button($atc_url)
        {
            $_url = wp_get_referer();
            $_url = remove_query_arg(array('added-to-cart', 'add-to-cart'), $_url);
            $_url = add_query_arg(array('add-to-cart' => $this->id), $_url);
            return $_url;
        }

        public function ajax_callback_func()
        {
            global $post, $product;
            $prod_id = absint($_REQUEST['product_id']);

            $post = get_post($prod_id);
            $product = wc_get_product($prod_id);
            if ($prod_id <= 0 || !isset($post->post_type) || strcmp($post->post_type, 'product') != 0)
                die("Invalid Products");

            add_filter('woocommerce_add_to_cart_url', array($this, 'update_add_to_cart_button'), 10);

            $_slider_wrap = array('p_image');
            $attachment_ids = apply_filters('yesshop_include_thumb_id', $product->get_gallery_image_ids());

            if (count($attachment_ids) > 1) {
                $_slider_wrap[] = 'yeti-owlCarousel';
                $_slider_wrap[] = 'yeti-loading';
                $_slider_wrap[] = 'light';
            }

            ob_start(); ?>
            <div class="woocommerce yeti-popup yeti-quickshop-wrapper animated zoomIn">

                <div class="product yeti-quickshop-product">

                    <div class="images">

                        <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $_slider_wrap ) ) ); ?>" data-options="<?php echo esc_attr(wp_json_encode(array('items' => 1, 'loop' => false, 'center' => true)))?>">

                            <?php Yesshop_Functions()->yt_get_yetiLoadingIcon();?>

                            <figure class="yeti-owl-slider">

                                <?php
                                if ( has_post_thumbnail() && $attachment_ids ) {

                                    foreach ( $attachment_ids as $attachment_id ) {
                                        $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
                                        $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
                                        $thumbnail_post   = get_post( $attachment_id );
                                        $image_title      = $thumbnail_post->post_content;

                                        $attributes = array(
                                            'title'                   => $image_title,
                                            'data-src'                => $full_size_image[0],
                                            'data-large_image'        => $full_size_image[0],
                                            'data-large_image_width'  => $full_size_image[1],
                                            'data-large_image_height' => $full_size_image[2],
                                        );

                                        $html  = '<div data-id="'.esc_attr($attachment_id).'" data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image"><a class="product-image" href="' . esc_url( $full_size_image[0] ) . '">';
                                        $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
                                        $html .= '</a></div>';

                                        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
                                    }
                                } else {
                                    $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                    $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'omeo' ) );
                                    $html .= '</div>';

                                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
                                }
                                ?>

                            </figure>

                        </div>

                    </div>

                    <div class="swiper-container col-sm-12 summary entry-summary" >
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <?php
                                /**
                                 * woocommerce_single_product_summary hook
                                 *
                                 * @hooked woocommerce_template_single_title - 5
                                 * @hooked woocommerce_template_single_rating - 10
                                 * @hooked woocommerce_template_single_price - 10
                                 * @hooked woocommerce_template_single_excerpt - 20
                                 * @hooked woocommerce_template_single_add_to_cart - 30
                                 * @hooked woocommerce_template_single_meta - 40
                                 * @hooked woocommerce_template_single_sharing - 50
                                 */
                                do_action('woocommerce_single_product_summary');
                                ?>
                                <a class="pull-right" href="<?php echo get_permalink($post)?>"><u><?php esc_html_e('View detail', 'omeo')?> <i class="fa fa-angle-double-right" aria-hidden="true"></i></u></a>
                            </div>
                        </div>
                        <!-- Add Scroll Bar -->
                        <div class="swiper-scrollbar"></div>
                    </div>

                </div>

            </div>

            <?php
            remove_filter('woocommerce_add_to_cart_url', array($this, 'update_add_to_cart_button'));
            $output = ob_get_clean();
            wp_die($output);
        }

        public static function quickshop_btn()
        {
            global $product;
            $query_args = array(
                'ajax' => 'true',
                'action' => 'quickshop_prod_content',
                'product_id' => absint($product->get_id())
            );
            $_link = add_query_arg($query_args, get_admin_url() . 'admin-ajax.php');

            $_pos = Yesshop_Functions()->get_tooltip_pos();
            $tooltip = ($_pos)? 'tooltip': 'false';

            ?>
            <a class="yeti_quickshop_link button hidden-xs" title="<?php esc_html_e('Quick shop', 'omeo'); ?>" href="<?php echo esc_url($_link); ?>" data-toggle="<?php echo esc_attr($tooltip);?>" data-placement="<?php echo esc_attr($_pos); ?>"><?php esc_html_e('Quick shop', 'omeo'); ?></a>
            <?php
        }

    }

    if (in_array("woocommerce/woocommerce.php", get_option('active_plugins'))) {
        $detect = new Mobile_Detect;
        if (!$detect->isMobile()) {
            new Yesshop_Quickshop();
        }
    }
}