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

/* I - HEADER FUNCTION */

function yesshop_header_tablet()
{
    if (file_exists(THEME_DIR . 'framework/header_tpl/header-tablet.php'))
        get_template_part('framework/header_tpl/header', 'tablet');
}

if (!function_exists('yesshop_template_redirect')) {

    function yesshop_template_redirect()
    {
        global $yesshop_datas;

        if (is_tax('product_cat')) {
            global $wp_query;

            $term = $wp_query->queried_object;
            $datas = maybe_unserialize(get_woocommerce_term_meta($term->term_id, "yeti_woo_cat"));
            if (is_array($datas) && !empty($datas)) {
                foreach ($datas as $k => $v) {
                    if (!empty($v)) $yesshop_datas[$k] = $v;
                }
            }
        } else {
            $yesshop_datas['page-datas'] = wp_parse_args(Yesshop_Functions()->getOptions('page_options'), array(
                'page_show_title' => 1,
                'page_show_breadcrumb' => 1
            ));
        }

        $yesshop_datas['date-format'] = get_option( 'date_format' );

        foreach ($_REQUEST as $k => $v) {
            if (!empty($v)) $yesshop_datas[$k] = $v;
        }

        do_action('yesshop_template_redirect_preview');

        global $detect;
        if (!empty($detect) && $detect->isMobile() && !$detect->isTablet()) {
            $yesshop_datas['product-page-style'] = 1;
        }

        //Woocommerce

        if(class_exists('WooCommerce')) {
            if ( is_singular( 'product' ) && !is_active_widget( false, false, 'woocommerce_recently_viewed_products', true ) ) {
                global $post;

                if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) )
                    $viewed_products = array();
                else
                    $viewed_products = (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] );

                if ( ! in_array( $post->ID, $viewed_products ) ) {
                    $viewed_products[] = $post->ID;
                }

                if ( sizeof( $viewed_products ) > 15 ) {
                    array_shift( $viewed_products );
                }

                // Store for session only
                wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
            }
        }

    }
}

function yesshop_bodyClass($classes)
{
    global $detect, $yesshop_datas;

    if ($detect->isMobile()) {
        $classes[] = 'touch_device';
        if ($detect->isTablet()) $classes[] = 'tablet_device';
        else $classes[] = 'mobile_device';
    } else {
        $classes[] = 'notouch_device';
    }

    if (isset($yesshop_datas['pace-loader']) && absint($yesshop_datas['pace-loader']) !== 0) {
        $classes[] = 'pace-loading';
    }

    if (!empty($yesshop_datas['layout-main'])) {
        if (strcmp('container', trim($yesshop_datas['layout-main'])) == 0) {
            $classes[] = 'boxed';
        } else {
            $classes[] = esc_attr($yesshop_datas['layout-main']);
        }
    }

    if (!empty($yesshop_datas['header-style'])) {
        if(stripos($yesshop_datas['header-style'], 'vert') !== false) {
            $classes[] = 'header-vertical';
        }
    }

    if (!empty($yesshop_datas['page-datas']['one_page'])) {
        $classes[] = 'body-onepage';
    }

    if(!empty($yesshop_datas['page-datas']['slider_type'])) {
        $classes[] = 'has-slideshow slider-'. esc_attr($yesshop_datas['page-datas']['slider_type']);
    }

    if (function_exists('is_store_notice_showing') && is_store_notice_showing()) {
        $classes[] = 'woocommerce_demo_store';
    }

    if (!empty($yesshop_datas['woo-shop-page'])) {
       $classes[] = esc_attr($yesshop_datas['woo-shop-page']);
    }
    //Hugo add custom body class
    if (!empty($yesshop_datas['heading_align'])) {
        $classes[] = esc_attr($yesshop_datas['heading_align']);
    }



    return $classes;
}

function yesshop_main_content_class($_class, $_act)
{
    if (class_exists('WooCommerce') && (is_shop() || is_product_category() || is_product())) {
        $_data = Yesshop_Functions()->pages_sidebar_act('shop');
    } elseif ($_act == 'blog') {
        $_data = Yesshop_Functions()->pages_sidebar_act('blog');
    } else {
        $_data = Yesshop_Functions()->pages_sidebar_act();
    }

    $_class[] = $_data['_cont_class'];

    return $_class;
}


if(!function_exists('yesshop_main_container_class')) {
    function yesshop_main_container_class($class){
        global $yesshop_datas;

        if(isset($yesshop_datas['page-datas']) && !empty($yesshop_datas['page-datas']['one_page'])) {
            $class = 'container-fluid onepage-container';
        } elseif(isset($yesshop_datas['layout-main']) && $yesshop_datas['layout-main'] === 'boxed'
            && is_page() && !is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page()) {
            $class = 'container-fluid';
        }
        if(class_exists('WooCommerce') && is_product() && isset($yesshop_datas['product-page-style']) && in_array(absint($yesshop_datas['product-page-style']), array(2,3,4))) {
            $class = 'container-fluid';
        }

        if(class_exists('WooCommerce') && (is_product_category() || is_shop()) && isset($yesshop_datas['product_archive_layout']) && absint($yesshop_datas['product_archive_layout']) == 0) {
            $class = 'container-fluid';
        }

        return $class;
    }
}

/* I - FOOTER FUNCTION */

function yesshop_footer() {
    global $yesshop_datas;
    ?>
    <div class='footer-layout <?php echo isset($yesshop_datas["footer-stblock"]) ? $yesshop_datas["footer-stblock"] : ''; ?>'>
        <div class="container">
            <?php
            if (isset($yesshop_datas["footer-stblock"]) && strlen($yesshop_datas["footer-stblock"]) > 0 && class_exists("Yetithemes_StaticBlock")) {
                if (function_exists('Yetithemes_StaticBlock')) {
                    Yetithemes_StaticBlock()->getContentByID($yesshop_datas["footer-stblock"]);
                } else {
                    esc_html_e('Please enable "Static Block" on Yetithemes > settings.', 'omeo');
                }
            } else {
                ?>
                <div style="margin: 55px 0">
                    <p><?php esc_html_e('Please create a "Static Block" in "YETI Block" and select it in Theme options > Footer.', 'omeo');?></p>
                    <div class="footer-inline-list">
                        <div class="widget_nav_menu">
                            <ul>
                                <li><a target="_blank" href="http://demo.nexthemes.com/wordpress/yesshop/docs/#how_to_create_a_new_static_block"><?php esc_html_e('How to create static block?', 'omeo');?></a></li>
                                <li><a target="_blank" href="http://demo.nexthemes.com/wordpress/yesshop/docs/#theme_opt_general"><?php esc_html_e('Select it this block in Theme options', 'omeo');?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}

/**
 * BLOG FUNCTION
 */

if (class_exists('WooCommerce')) {

    if (!function_exists('yesshop_single_product_summary_footer_block')) {
        function yesshop_single_product_summary_footer_block()
        {
            global $yesshop_datas;
            if (function_exists('Yetithemes_StaticBlock') && !empty($yesshop_datas['product-page-footer-block'])) {
                Yetithemes_StaticBlock()->getContentByID($yesshop_datas['product-page-footer-block']);
            }
        }
    }


    if (!function_exists('yesshop_variable_option_html')) {
        function yesshop_variable_option_html($attribute_name, $options, $selected_attributes, $is_color = false)
        {
            global $product, $post;

            if (is_array($options)) {

                $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) ? wc_clean($_REQUEST['attribute_' . sanitize_title($attribute_name)]) : $product->get_variation_default_attribute($attribute_name);

                ob_start();
                ?>
                <div class="yeti-variable-attr-swapper<?php if ($is_color) echo " attr-color"; ?>"><?php
                if (taxonomy_exists($attribute_name)) {
                    $terms = wc_get_product_terms($post->ID, $attribute_name, array('fields' => 'all'));

                    foreach ($terms as $term) {
                        if (!in_array($term->slug, $options)) continue;
                        $_selected = strcmp(sanitize_title($selected), sanitize_title($term->slug)) == 0 ? " selected" : '';
                        if ($is_color) {
                            $datas = get_woocommerce_term_meta($term->term_id, "_pa_color_data", true);
                            $_style = isset($datas) && strlen($datas) > 0 ? "background-color: {$datas};" : "background-color: #aaa";
                        } else {
                            $_style = '';
                        }
                        ?>
                        <div class="select-option<?php echo esc_attr($_selected); ?>" style="<?php echo esc_attr($_style); ?>"
                             data-value="<?php echo esc_attr($term->slug); ?>"><?php echo apply_filters('woocommerce_variation_option_name', $term->name); ?></div>
                        <?php
                    }

                } else {

                    foreach ($options as $option) {
                        $_selected = strcmp(sanitize_title($selected), sanitize_title($option)) == 0 ? " selected" : '';
                        ?>
                        <div class="select-option<?php echo esc_attr($_selected); ?>"
                             data-value="<?php echo esc_attr(sanitize_title($option)); ?>"><?php echo esc_html(apply_filters('woocommerce_variation_option_name', $option)); ?></div>
                        <?php
                    }

                }
                ?></div><?php
                return ob_get_clean();
            }
        }
    }

    if (!function_exists('yesshop_woocommerce_orderby_form_extra')) {
        function yesshop_woocommerce_orderby_form_extra()
        {
            global $yesshop_datas;

            $default = !empty($yesshop_datas["shop_per_page"]) && absint($yesshop_datas["shop_per_page"]) > 0 ?
                absint($yesshop_datas["shop_per_page"]) : 12;
            $def_col = !empty($yesshop_datas["shop_columns"]) && absint($yesshop_datas["shop_columns"]) > 0 ?
                absint($yesshop_datas["shop_columns"]) : 3;
            $current_per_show = !empty($_GET['per_show']) ? $_GET['per_show'] : $default;

            $n = round($default / $def_col);
            $n = $n > 3 ? $n : 3;
            $per_show_args = array();
            for ($i = ($n - 2); $i < ($n + 3); $i++) {
                $per_show_args[] = $i * $def_col;
            }

            ?>
            <div class="form-group">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="per_show_dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="dropdown-text"><?php printf(esc_attr__('%d Items', 'omeo'), absint($current_per_show)); ?></span>
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="per_show_dropdown">
                        <li class="dropdown-item" data-val="<?php echo esc_attr($current_per_show) ?>">
                            <a href="#"><?php printf(esc_attr__('%d Items', 'omeo'), absint($current_per_show)); ?></a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <?php foreach ($per_show_args as $id) :
                            $_li_class = array('dropdown-item');
                            if (absint($current_per_show) === absint($id)) continue;
                            ?>
                            <li class="<?php echo esc_attr(implode(' ', $_li_class)); ?>"
                                data-val="<?php echo esc_attr($id) ?>">
                                <a href="#"><?php printf(esc_attr__('%d Items', 'omeo'), absint($id)); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <input type="hidden" name="per_show" class="per_show dropdown-value"
                           value="<?php echo absint($current_per_show); ?>">
                </div>
            </div>
            <?php
        }
    }

    if (!function_exists('yesshop_woocommerce_order_progressing')) {
        function yesshop_woocommerce_order_progressing($order_id)
        {
            $order = wc_get_order($order_id);
            echo '<pre>';
            print_r($order);
            echo '</pre>';
        }
    }

    if (!function_exists('yesshop_woocommerce_product_archive_jumbotron')) {
        function yesshop_woocommerce_product_archive_jumbotron()
        {
            global $yesshop_datas;

            if (!empty($yesshop_datas['cat-jumbotron'])) {
                echo '<div class="category-infomation col-sm-24">';
                Yetithemes_StaticBlock()->getContentByID($yesshop_datas['cat-jumbotron']);
                echo '</div>';
            }
        }
    }

    /*
     * PRODUCT STYLE 2: Shadow style
     * */

    if (!function_exists('yesshop_after_section_start')) {
        function yesshop_after_section_start()
        {
            echo '<div class="section-inner">';
        }
    }
}

function yesshop_custom_video_size($data)
{
    $yesshop_pages = Yesshop_Functions()->getOptions('page_options');
    $data['width'] = !empty($yesshop_pages['nth_blog_v_size']['width']) ? absint($yesshop_pages['nth_blog_v_size']['width']) : 370;
    $data['height'] = !empty($yesshop_pages['nth_blog_v_size']['height']) ? absint($yesshop_pages['nth_blog_v_size']['height']) : 225;
    return $data;
}


/***** COMPARE ****/


function yesshop_head_script()
{
    global $yesshop_datas;
    if (empty($yesshop_datas['js_editor_head'])) return;

    echo '<script class="yesshop-custom-head">';
    echo $yesshop_datas['js_editor_head'];
    echo '</script>';
}

function yesshop_footer_script() {
    global $yesshop_datas;
    if (empty($yesshop_datas['js_editor_footer'])) return;

    echo '<script class="yesshop-custom-footer">';
    echo $yesshop_datas['js_editor_footer'];
    echo '</script>';
}

function yesshop_post_class($classes) {
    if (function_exists('is_product') && is_product()) {
        $_pro_page_style = Yesshop_Functions()->getThemeData('product-page-style');
        if ($_pro_page_style) {
            $classes[] = 'product_style-' . esc_attr($_pro_page_style);
        }
    }

    return $classes;
}

function yesshop_galleries_columns($columns)
{
    $_columns = Yesshop_Functions()->getThemeData('galleries-columns');
    if ($_columns) $columns = $_columns;
    return $columns;
}

function yesshop_gallery_royaloptions($options)
{
    global $yesshop_datas;

    if (isset($yesshop_datas['gallery-fullscreen']) && strcmp($yesshop_datas['gallery-fullscreen'], '0') === 0) {
        $options['fullscreen'] = array('enabled' => 0);
    }

    if (isset($yesshop_datas['gallery-loop']) && absint($yesshop_datas['gallery-loop']) === 1) {
        $options['loop'] = 1;
    }

    if (!isset($yesshop_datas['gallery-autoplay']) || absint($yesshop_datas['gallery-autoplay']) === 1) {
        $options['autoPlay'] = array('enabled' => 1);

        $options['autoPlay']['pauseOnHover'] =
            (isset($yesshop_datas['gallery-pauseonhover']) && absint($yesshop_datas['gallery-pauseonhover']) === 0) ? 0 : 1;

        $options['autoPlay']['delay'] =
            empty($yesshop_datas['gallery-autoplay-delay']) ? 5000 : absint($yesshop_datas['gallery-autoplay-delay']);
    } else {
        $options['autoPlay'] = array('enabled' => 0);
    }

    if (isset($yesshop_datas['gallery-thumnail-vertical']) && absint($yesshop_datas['gallery-thumnail-vertical']) === 1) {
        $options['thumbs'] = array(
            'appendSpan' => 1,
            'orientation' => 'vertical',
            'paddingBottom' => 4
        );
    }

    return $options;
}

function yesshop_footer_newsletter()
{
    global $yesshop_datas;
    if (!class_exists('Yetithemes_StaticBlock') || (isset($yesshop_datas['newsletter-footer']) && absint($yesshop_datas['newsletter-footer']) === 0)) return;
    if (empty($yesshop_datas['newsletter-footer-content'])) return;
    ?>
    <div class="footer-newsletter-wrap hidden">
        <div class="newsletter-content container">
            <?php Yetithemes_StaticBlock()->getContentByID($yesshop_datas['newsletter-footer-content']) ?>
            <a href="#" title="<?php esc_html_e('Close newsletter', 'omeo') ?>"
               class="close-btn"><?php esc_html_e('Close', 'omeo') ?></a>
        </div>
    </div>
    <?php
}

function yesshop_back_to_top()
{
    ?>
    <a href="#" id="back_to_top" class="button backtotop-btn" title="<?php echo esc_attr('Back to top', 'omeo') ?>"><i
                class="fa fa-angle-up" aria-hidden="true"></i></a>
    <?php
}

function yesshop_getPhotoSwipeDOM(){
    ?>
    <button id="pswp_button">Open image</button>

    <!-- Root element of PhotoSwipe. Must have class pswp. -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

        <!-- Background of PhotoSwipe.
             It's a separate element as animating opacity is faster than rgba(). -->
        <div class="pswp__bg"></div>

        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">

            <!-- Container that holds slides.
                PhotoSwipe keeps only 3 of them in the DOM to save memory.
                Don't modify these 3 pswp__item elements, data is added later on. -->
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">

                    <!--  Controls are self-explanatory. Order can be changed. -->

                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                    <button class="pswp__button pswp__button--share" title="Share"></button>

                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                    <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                    <!-- element will get class pswp__preloader--active when preloader is running -->
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>

                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>

                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>

            </div>

        </div>

    </div>

    <?php
}

if(!function_exists('yesshop_disable_revolution_fonts')) {
    function yesshop_disable_revolution_fonts($url){
        global $yesshop_datas;
        if(isset($yesshop_datas['dis_rev_font']) && absint($yesshop_datas['dis_rev_font'])) return '';
        else return $url;
    }
}

if(!function_exists('yesshop_woocommerce_ajax_added_to_cart')) {
    function yesshop_woocommerce_ajax_added_to_cart($product_id){
        if(!class_exists('WooCommerce')) return false;

        WC()->session->set('product_added_id', $product_id);
    }
}


function yesshop_main_right_sidebar() {
    get_sidebar('main-right');
}

function yesshop_excerpt_length($length) {
    global $yesshop_datas;

    if(!empty($yesshop_datas['blog-excerpt-length'])) {
        $length = absint($yesshop_datas['blog-excerpt-length']);
    }

    return $length;
}

function yesshop_excerpt_more($more){
    global $yesshop_datas;

    if(!empty($yesshop_datas['blog-excerpt-more'])){
        switch($yesshop_datas['blog-excerpt-more']){
            case 'hellip':
                $more = ' &hellip;';
                break;
            case 'fa-arrow':
                $more = ' <i class="fa fa-long-arrow-right" aria-hidden="true"></i>';
                break;
        }
    }

    return $more;
}
