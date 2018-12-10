<?php
/**
 * @package Yesshop
 */

if (!class_exists('YetiThemes')) {

    class YetiThemes
    {

        protected $func_args = array();
        protected $incs_args = array();
        protected $libs = array();
        protected $vc_args = array();
        protected $shortcode_args = array();
        private static $instance = null;
        public $funcs = null;

        function __construct()
        {
            $this->contant();

            $this->register_theme_activation_hook('omeo', array($this, 'themeActiveSetup'));

            $this->init_Incs_Args();

            add_action('after_setup_theme', array($this, 'c_setup'));

            $this->register_theme_deactivation_hook('omeo', array($this, 'themeDeactive'));

            add_action('wp_enqueue_scripts', array($this, 'frontendScripts'));

            add_action('admin_enqueue_scripts', array($this, 'backendScripts'));

            add_action('init', array($this, 'register_image_size'));


            if (is_admin()) {
                new Yesshop_MetaBox();
            }

            $this->vc_custom();
        }

        public static function get_instance()
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        private function checkConditions($conditions = '')
        {
            switch ($conditions) {
                case 'frontend':
                    $return = !is_admin() ? true : false;
                    break;
                case 'backend':
                    $return = is_admin() ? true : false;
                    break;
                default:
                    $return = true;
            }
            return $return;
        }

        private function init_Incs_Args()
        {

            $this->setFuncs_Args();
            $this->setIncs_Args();

            foreach ($this->libs as $k => $incs) {
                $conditions = $this->checkConditions($k);
                if ($conditions) {
                    foreach ($incs['args'] as $inc) {
                        include_once $incs['path'] . trim($inc) . ".php";
                    }
                }

            }

            foreach ($this->incs_args as $k => $incs) {
                $conditions = $this->checkConditions($k);
                if ($conditions) {
                    foreach ($incs['args'] as $inc) {
                        include_once $incs['path'] . trim($inc) . ".php";
                    }
                }

            }

            foreach ($this->func_args as $k => $incs) {
                $conditions = $this->checkConditions($k);
                if ($conditions) {
                    foreach ($incs['args'] as $inc) {
                        include_once $incs['path'] . trim($inc) . ".php";
                    }
                }

            }

            add_action('init', array($this, 'inc_extenxtion'));
        }

        public function inc_extenxtion()
        {
            global $yesshop_datas;
            if (class_exists('WooCommerce') && (!isset($yesshop_datas['product-advanced-review']) || absint($yesshop_datas['product-advanced-review']) === 1)) {
                include_once get_theme_file_path('framework/incs/class.advanced-reviews.php');
            }
        }

        private function setFuncs_Args()
        {
            $this->func_args = array(
                'backend' => array(
                    'path' => THEME_BACKEND_FUNC,
                    'args' => array('product_cat_form_field'),
                ),
                '' => array(
                    'path' => THEME_FRAMEWORK_FUNC,
                    'args' => array(
                        'function_api',
                        'woo_funcs_api',
                        'main-func',
                        'general',
                        'main',
                        'header',
                        'footer',
                        'hook',
                        'mega-menu',
                        'breadcrumb',
                        'ajax_functions',
                        'main-sidebar',
                        'preview'
                    ),
                ),
            );
        }

        private function setIncs_Args()
        {
            $this->incs_args = array(
                'all' => array(
                    'path' => THEME_FRAMEWORK_INCS,
                    'args' => array(
                        'lessc.inc',
                        'redux-framework/theme-options',
                        'mega-menu-action',
                        'class.woo_hook',
                        'class.quickshop',
                        'class.shopbycolor',
                        'class.wooattrbrand',
                        'class.widget_sidebars',
                        'widgets',
                        'widgets/class.abstract-widgets',
                        'widgets/class.banner',
                        'widgets/class.social',
                        'widgets/class.header-dropdown',
                        'widgets/class.product-category',
                        'widgets/class.product-categories',
                        'widgets/class.product-filters',
                        'widgets/class.recent-comments',
                        'widgets/class.recent-posts',
                        'widgets/class.staticblock',
                        'widgets/class.brand_single',
                        'widgets/class.woocommerce-products',
                        'class.count-down',
                        'class-tgm-plugin-activation',
                        'plugins-request'
                    )
                ),
                'backend' => array(
                    'path' => THEME_BACKEND_INCS,
                    'args' => array('mega-menu-backend', 'class.metabox.template', 'class.metabox'),
                )
            );

            $this->libs = array(
                'all' => array(
                    'path' => THEME_FRONTEND . 'libs/',
                    'args' => array('mobile_detect')
                )
            );
        }

        public function dequeue_style()
        {
            if (wp_style_is('yith-wcwl-font-awesome', 'enqueued')) {
                wp_dequeue_style('yith-wcwl-font-awesome');
                wp_deregister_style('yith-wcwl-font-awesome');
            }

            if (wp_style_is('woocommerce_prettyPhoto_css', 'enqueued')) {
                wp_dequeue_style('woocommerce_prettyPhoto_css');
            }

            if (wp_script_is('prettyPhoto', 'enqueued')) {
                wp_dequeue_script('prettyPhoto');
            }
        }

        public function frontendScripts()
        {
            global $yesshop_datas, $detect;

            if ($font_url = Yesshop_Functions()->getFontUrl()) {
                wp_enqueue_style('yesshop-fonts', esc_url_raw($font_url), array(), THEME_VERSION);
            }

            add_action('wp_print_styles', array($this, 'dequeue_style'));

            wp_dequeue_style('font-awesome');
            wp_deregister_style('font-awesome');

            wp_enqueue_style('bootstrap', get_theme_file_uri('css/bootstrap.min.css'));
            wp_enqueue_style('select2-min', get_theme_file_uri('css/select2.min.css'));
            wp_enqueue_style('magnific-popup', get_theme_file_uri('css/magnific-popup.css'), false, '1.1.0');
            wp_enqueue_style('owl-carousel', get_theme_file_uri('css/owl.carousel.min.css'));
            wp_enqueue_style('swiper-min', get_theme_file_uri('css/swiper.min.css'), false, '3.4.1');
            wp_enqueue_style('font-awesome', get_theme_file_uri('css/font-awesome.min.css'), false, '4.7.0');
            wp_enqueue_style('animate', get_theme_file_uri('css/animate.min.css'), false, '1.0.0');

            if (!empty($yesshop_datas['page-datas']['one_page']) && !$detect->isMobile()) {
                wp_enqueue_style('jquery-fullpage', get_theme_file_uri('css/jquery.fullPage.css'));
                wp_enqueue_script('jquery-fullpage', get_theme_file_uri('js/jquery.fullPage.min.js'), array('jquery'), '1.0.0', true);
                wp_add_inline_script('jquery-fullpage', "
                    (function ($) {
                        $(document).ready(function () {
                            if ($(window).width() > 768) {
                                $('.onepage-container .entry-content').fullpage({
                                    verticalCentered: false,
                                    css3: true,
                                    navigation: true,
                                    navigationPosition: 'right',
                                    onLeave: function(index, nextIndex, direction){
                                        console.log(index + '/' + nextIndex);
                                        if(nextIndex === 1) {
                                           
                                            $('header.dark-bg').removeClass('dark-bg');
                                        } else {
                                            $('header#header').addClass('dark-bg');
                                        }
                                    },
                                    scrollBar: true
                                });
                            }
                            
                        });
                    })(jQuery);
                ");
            }

            /*Visual composer plugin*/
            wp_enqueue_style('js_composer_front');

            wp_enqueue_style('yesshop-style', get_template_directory_uri() . '/style.css', false, '1.0.0');

            if(!empty($yesshop_datas['color-stylesheet'])
                && file_exists(get_theme_file_path('css/color-custom-' . esc_attr($yesshop_datas['color-stylesheet']) . '.css'))
            ) {
                wp_enqueue_style('yesshop-typo-custom', get_theme_file_uri('css/color-custom-' . esc_attr($yesshop_datas['color-stylesheet']) . '.css'), null, '1.0');
            } elseif (file_exists(get_theme_file_path('css/color-custom.css'))) {
                wp_enqueue_style('yesshop-typo-custom', get_theme_file_uri('css/color-custom.css'), null, time());
            }

            do_action('yesshop_child_style');

            if (!empty($yesshop_datas['css_editor'])) {
                wp_add_inline_style('yesshop-style', $yesshop_datas['css_editor']);
            }

            wp_enqueue_script('yesshop-libs-js', get_theme_file_uri('js/dist/yesshop-head.min.js'), array('jquery'), '1.0.0', true);
            wp_enqueue_script('owl-carousel-js', get_theme_file_uri('js/owl.carousel.min.js'), array('jquery'), '2.2.0', true);
            wp_enqueue_script('swiper-js', get_theme_file_uri('js/swiper.min.js'), array('jquery'), '3.3.4', true);
            wp_enqueue_script('jquery-history-js', get_theme_file_uri('js/jquery.history.js'), array('jquery'), '2.0', true);
            wp_enqueue_script('select2-js', get_theme_file_uri('js/select2.min.js'), array('jquery'), '1.0.0', true);
            wp_enqueue_script('jquery-magnific-popup-js', get_theme_file_uri('js/jquery.magnific-popup.min.js'), array('jquery'), '1.1.0', true);

            if(function_exists('vc_asset_url')) {
                wp_register_script('vc_masonry', vc_asset_url('lib/bower/masonry/dist/masonry.pkgd.min.js'), array(), WPB_VC_VERSION, true);
            }
            if (isset($yesshop_datas['pace-loader']) && absint($yesshop_datas['pace-loader']) && !$detect->isMobile()) {
                wp_enqueue_script('pace-js', get_theme_file_uri('js/pace.min.js'), array('jquery'), '1.0.0');
            }

            wp_register_script('yesshop-main-js', THEME_JS_URI . 'yesshop-main.js', false, false, true);


            $yesshop_data = array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'wpnonce' => wp_create_nonce('_nth_ajax_nonce_56672'),
                'loading_icon' => admin_url('images/spinner.gif'),
                'templ_url' => esc_url(get_template_directory_uri()),
                'rtl' => is_rtl() ? 1 : 0,
                'search' => array(
                    'cat' => isset($yesshop_datas['search-form-with-cat']) ? absint($yesshop_datas['search-form-with-cat']) : 1,
                    'param' => array(
                        'limit' => !empty($yesshop_datas['search-ajax-result-limit']) ? absint($yesshop_datas['search-ajax-result-limit']) : 5,
                        'action' => 'yeti_ajax_search_products',
                    ),
                    'min' => !empty($yesshop_datas['search-ajax-min-char']) ? absint($yesshop_datas['search-ajax-min-char']) : 3,
                ),
                'owl' => array(
                    'autoplay' => isset($yesshop_datas['owl_autoplay']) ? absint($yesshop_datas['owl_autoplay']) : 0,
                    'autoplayTimeout' => !empty($yesshop_datas['owl_autoplaytimeout']) ? absint($yesshop_datas['owl_autoplaytimeout']) : 5000,
                    'autoplayHoverPause' => isset($yesshop_datas['owl_autoplayhoverpause']) ? absint($yesshop_datas['owl_autoplayhoverpause']) : 0,
                ),
                'pace' => isset($yesshop_datas['pace-loader']) ? absint($yesshop_datas['pace-loader']) : 0,
            );

            if (isset($yesshop_datas['owl_autoplay']) && absint($yesshop_datas['owl_autoplay']) > 0) {
                $yesshop_data['owl']['loop'] = 1;
            }

            wp_localize_script('yesshop-main-js', 'yesshop_data', $yesshop_data);

            wp_enqueue_script('yesshop-main-js');

            if (is_singular() && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
        }

        public function backendScripts($hook_suffix)
        {
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
            wp_enqueue_script('media-upload');

            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');

            $screen = get_current_screen();
            if (strpos($screen->id, 'yetithemes') !== false) {
                wp_enqueue_style('font-awesome.min', THEME_CSS_URI . 'font-awesome.min.css', false, '4.7');
            }

            wp_enqueue_style('yesshop-menu', THEME_BACKEND_CSS_URI . 'menu.css');

            wp_enqueue_style('yesshop-admin-init', THEME_BACKEND_CSS_URI . 'init.css');

            wp_enqueue_script('yesshop-admin-js', THEME_BACKEND_JS_URI . 'admin.min.js', array('jquery'), false, true);

            $yesshop_data = array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'media' => array(
                    "images" => array("f_default" => THEME_BACKEND_URI . "images/placeholder.png"),
                ),
            );

            wp_localize_script('yesshop-admin-js', 'yesshop_data', $yesshop_data);
        }

        public function contant()
        {
            $yeti_get_theme = wp_get_theme();
            $this->define('THEME_VERSION', $yeti_get_theme->get('Version'));

            $this->define('OPS_THEME', 'yesshop_datas');
            $this->define('THEME_NAME', 'omeo');

            $this->define('THEME_DIR', get_template_directory() . '/');
            $this->define('THEME_URI', get_template_directory_uri() . '/');

            $this->define('THEME_IMG_URI', THEME_URI . 'images/');
            $this->define('THEME_CSS_URI', THEME_URI . 'css/');
            $this->define('THEME_JS_URI', THEME_URI . 'js/');

            $this->define('THEME_FRAMEWORK', THEME_DIR . 'framework/');
            $this->define('THEME_FRAMEWORK_INCS', THEME_FRAMEWORK . 'incs/');
            $this->define('THEME_FRAMEWORK_FUNC', THEME_FRAMEWORK . 'functions/');

            $this->define('THEME_FRONTEND', THEME_FRAMEWORK . 'frontend/');
            $this->define('THEME_FE_LIBS', THEME_FRONTEND . 'libs/');
            $this->define('THEME_FE_IMG', THEME_FRONTEND . 'images/');
            $this->define('THEME_FE_CSS', THEME_FRONTEND . 'css/');
            $this->define('THEME_FE_JS', THEME_FRONTEND . 'js/');

            $this->define('THEME_FRAMEWORK_URI', THEME_URI . 'framework/');
            $this->define('THEME_FRONTEND_URI', THEME_FRAMEWORK_URI . 'frontend/');
            $this->define('THEME_FE_CSS_URI', THEME_FRONTEND_URI . 'css/');
            $this->define('THEME_FE_JS_URI', THEME_FRONTEND_URI . 'js/');
            $this->define('THEME_FE_IMG_URI', THEME_FRONTEND_URI . 'images/');

            $this->define('THEME_BACKEND', THEME_FRAMEWORK . 'backend/');
            $this->define('THEME_BACKEND_CSS', THEME_BACKEND . 'css/');
            $this->define('THEME_BACKEND_INCS', THEME_BACKEND . 'incs/');
            $this->define('THEME_BACKEND_FUNC', THEME_BACKEND . 'functions/');

            $this->define('THEME_BACKEND_URI', THEME_FRAMEWORK_URI . 'backend/');
            $this->define('THEME_BACKEND_CSS_URI', THEME_BACKEND_URI . 'css/');
            $this->define('THEME_BACKEND_JS_URI', THEME_BACKEND_URI . 'js/');


            //backend
            $this->define('yesshop_MEGA_MENU_K', 'yesshop_MEGA');
        }

        private function define($name, $value)
        {
            if (!defined($name)) {
                define($name, $value);
            }
        }

        public function theme_slug_render_title()
        {
            ?>
            <title><?php wp_title('|', true, 'right'); ?></title>
            <?php
        }

        public function c_setup()
        {
            global $content_width;
            // This theme styles the visual editor with editor-style.css to match the theme style.
            add_editor_style();

            //title tag
            add_theme_support('title-tag');

            add_theme_support('wc-product-gallery-lightbox');
            add_theme_support( 'wc-product-gallery-zoom' );

            // This theme supports a variety of post formats.
            if (!function_exists('_wp_render_title_tag')) :
                add_action('wp_head', array($this, 'theme_slug_render_title'));
            endif;

            add_theme_support('post-formats', array('video', 'audio', 'gallery'));

            //support post thumbnails.
            add_theme_support('post-thumbnails');
            set_post_thumbnail_size(825, 510, true);

            //setup default background
            add_theme_support('custom-background', array(
                "default-color" => 'ffffff',
                "default-image" => '',
            ));
            //automatic feed RSS link to header.
            add_theme_support('automatic-feed-links');
            //Support woocommerce plugin
            add_theme_support('woocommerce');

            if (!isset($content_width)) {
                $content_width = 1170;
            }

            load_theme_textdomain('omeo', THEME_DIR . 'languages');

            //menu location.
            register_nav_menu('primary-menu', esc_html__('Primary Menu', 'omeo'));
            register_nav_menu('primary-menu-2', esc_html__('Primary Menu 2', 'omeo'));
            register_nav_menu('vertical-menu', esc_html__('Vertical Menu', 'omeo'));
            register_nav_menu('mobile-menu', esc_html__('Mobile Menu', 'omeo'));
            register_nav_menu('shop-top-menu', esc_html__('Shop top category', 'omeo'));

            global $detect;
            $detect = new Mobile_Detect;
        }

        public function wooProductSize()
        {
            update_option('shop_catalog_image_size', array(
                'width' => '360',
                'height' => '440',
                'crop' => 1
            ));

            update_option('shop_single_image_size', array(
                'width' => '585',
                'height' => '715',
                'crop' => 1
            ));

            update_option('shop_thumbnail_image_size', array(
                'width' => '130',
                'height' => '159',
                'crop' => 1
            ));
        }

        public function register_theme_activation_hook($code, $_call)
        {
            $optionKey = "theme_is_activated_" . $code;
            if (!get_option($optionKey)) {
                call_user_func($_call);
                update_option($optionKey, 1);
            }
        }

        public function themeActiveSetup()
        {
            $this->wooProductSize();
        }

        public function register_image_size()
        {
            if (function_exists('add_image_size')) {
                global $yesshop_datas;

                $blog_thumbnail = !empty($yesshop_datas['blog-thumbnail-size']) ?
                    $yesshop_datas['blog-thumbnail-size'] : array('width' => 850, 'height' => 460, 'drop' => 1);

                $blog_grid_thumbnail = !empty($yesshop_datas['blog-thumbnail-grid-size']) ?
                    $yesshop_datas['blog-thumbnail-grid-size'] : array('width' => 410, 'height' => 220, 'drop' => 1);

                $blog_widget_thumbnail = !empty($yesshop_datas['blog-thumbnail-widget-size']) ?
                    $yesshop_datas['blog-thumbnail-widget-size'] : array('width' => 270, 'height' => 155, 'drop' => 1);

                $shop_subcat = !empty($yesshop_datas['shop-subcat-size']) ?
                    $yesshop_datas['shop-subcat-size'] : array('width' => 100, 'height' => 100, 'drop' => 1);


                add_image_size('yesshop_mega_menu_icon', 30, 30, true);
                add_image_size('yesshop_blog_thumb', $blog_thumbnail['width'], $blog_thumbnail['height'], absint($blog_thumbnail['drop']));
                add_image_size('yesshop_blog_thumb_grid', $blog_grid_thumbnail['width'], $blog_grid_thumbnail['height'], absint($blog_grid_thumbnail['drop']));
                add_image_size('yesshop_blog_thumb_grid_o', $blog_grid_thumbnail['width']);

                if (!isset($yesshop_datas['blog-thumb-shortc-manager'])
                    || absint($yesshop_datas['blog-thumb-shortc-manager']['blog-thumbnail-grid-size-2']) === 1
                ) {
                    $blog_grid_thumbnail2 = !empty($yesshop_datas['blog-thumbnail-grid-size-2']) ?
                        $yesshop_datas['blog-thumbnail-grid-size-2'] : array('width' => 410, 'height' => 268, 'drop' => 1);
                    add_image_size('yesshop_blog_thumb_grid_2', $blog_grid_thumbnail2['width'], $blog_grid_thumbnail2['height'], absint($blog_grid_thumbnail2['drop']));
                }

                if (!isset($yesshop_datas['blog-thumb-shortc-manager'])
                    || absint($yesshop_datas['blog-thumb-shortc-manager']['blog-thumbnail-grid-size-2']) === 1
                ) {
                    $blog_grid_thumbnail3 = !empty($yesshop_datas['blog-thumbnail-grid-size-3']) ?
                        $yesshop_datas['blog-thumbnail-grid-size-3'] : array('width' => 360, 'height' => 540, 'drop' => 1);
                    add_image_size('yesshop_blog_thumb_grid_3', $blog_grid_thumbnail3['width'], $blog_grid_thumbnail3['height'], absint($blog_grid_thumbnail3['drop']));
                }


                add_image_size('yesshop_blog_thumb_widget', $blog_widget_thumbnail['width'], $blog_widget_thumbnail['height'], absint($blog_widget_thumbnail['drop']));
                add_image_size('yesshop_shop_subcat', $shop_subcat['width'], $shop_subcat['height'], absint($shop_subcat['drop']));
                add_image_size('yesshop_shop_subcat_large', 370, 400, true);
                add_image_size('yesshop_product_super_deal', 370, 200, true);

                if (class_exists('Yetithemes_Portfolio')) {
                    $portfolio_thumb = !empty($yesshop_datas['portfolio-thumb-size']) ?
                        $yesshop_datas['portfolio-thumb-size'] : array('width' => 560, 'height' => 560, 'drop' => 1);
                    $portfolio_thumb_big = !empty($yesshop_datas['portfolio-thumb-big-size']) ?
                        $yesshop_datas['portfolio-thumb-big-size'] : array('width' => 900, 'height' => 900, 'drop' => 1);

                    add_image_size('portfolio_thumb', $portfolio_thumb['width'], $portfolio_thumb['height'], absint($portfolio_thumb['drop']));
                    add_image_size('portfolio_thumb_big', $portfolio_thumb_big['width'], $portfolio_thumb_big['height'], absint($portfolio_thumb_big['drop']));
                }

                if (class_exists('Yetithemes_TeamMembers')) {
                    $teams_thumb = !empty($yesshop_datas['teams-thumb-size']) ?
                        $yesshop_datas['teams-thumb-size'] : array('width' => 580, 'height' => 388, 'drop' => 1);

                    add_image_size('teams_thumb', $teams_thumb['width'], $teams_thumb['height'], absint($teams_thumb['drop']));
                }

                if (class_exists('Yetithemes_Gallery')) {
                    $gallery_thumb_auto = !empty($yesshop_datas['gallery-thumb-auto-size']) ?
                        $yesshop_datas['gallery-thumb-auto-size'] : array('width' => 270);

                    add_image_size('gallery_thumb_auto', $gallery_thumb_auto['width']);
                    add_image_size('gallery_thumb_auto_width', 115, 75, true);
                }

            }
        }

        public function register_theme_deactivation_hook($code, $_call)
        {
            // store function in code specific global
            $GLOBALS["wp_register_theme_deactivation_hook_function" . $code] = $_call;

            // create a runtime function which will delete the option set while activation of this theme and will call deactivation function provided in $function
            $fn = create_function('$theme', ' call_user_func($GLOBALS["wp_register_theme_deactivation_hook_function' . $code . '"]); delete_option("theme_is_activated_' . $code . '");');

            add_action("switch_theme", $fn);
        }

        protected function vc_custom()
        {

            if (class_exists('Vc_Manager')) {
                add_action('vc_before_init', array($this, 'vc_set_as_theme'));
                add_action('vc_load_default_templates', array($this, 'vc_theme_temeplates'));
            }

            if (class_exists('WPBakeryVisualComposerAbstract')) {
                include_once THEME_BACKEND_INCS . 'vc_customs/class.autocomplete.query.php';
                include_once THEME_BACKEND_INCS . 'vc_customs/class.autocomplete.php';
                include_once THEME_BACKEND_INCS . 'vc_customs/pagrams.php';

                add_action('vc_build_admin_page', array($this, 'load_vc_map_custom'));
                add_action('vc_load_shortcode', array($this, 'load_vc_map_custom'));
            }
        }

        public function vc_set_as_theme(){
            if (function_exists('vc_set_as_theme')) vc_set_as_theme();
        }

        public function vc_theme_temeplates($data)
        {
            $data[] = array(
                'name' => esc_attr__('YetiThemes - Container extra section and content', 'omeo'),
                'weight' => 0,
                'content' => <<<CONTENT
                [vc_section full_width="stretch_row_content"][vc_row yesshop_row_style="extra_width" css=".vc_custom_1493191189148{background-color: #ededed !important;}"][vc_column][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/vc_column][/vc_row][/vc_section]
CONTENT
            );

            $data[] = array(
                'name' => esc_attr__('YetiThemes - Container extra section', 'omeo'),
                'weight' => 0,
                'content' => <<<CONTENT
                [vc_section full_width="stretch_row_content"][vc_row yesshop_row_style="extra_width" css=".vc_custom_1493193455901{background-color: #ededed !important;}"][vc_column][vc_row_inner yesshop_row_style="container" css=".vc_custom_1493193506050{padding-top: 150px !important;padding-right: 0px !important;padding-bottom: 115px !important;padding-left: 0px !important;}"][vc_column_inner][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][/vc_section]
CONTENT
            );
            return $data;
        }

        public function load_vc_map_custom()
        {
            include_once THEME_BACKEND_INCS . 'vc_customs/vc_maps/vc_new_param.php';
            include_once THEME_BACKEND_INCS . 'vc_customs/vc_maps/vc_elements.php';
            include_once THEME_BACKEND_INCS . 'vc_customs/vc_maps/vc_woocommerce.php';
        }

        public static function get_owlResponsive($options = array())
        {
            $column = $options['items'];

            $resp = array(
                0 => array(
                    'items' => round($column * (479 / 1200)),
                    'loop' => false
                ),
                480 => array(
                    'items' => round($column * (768 / 1200)),
                    'loop' => false
                ),
                769 => array(
                    'items' => round($column * (980 / 1200)),
                    'loop' => false
                ),
                981 => array(
                    'items' => round($column * (1199 / 1200)),
                    'loop' => false
                ),
            );
            if (isset($options['responsive']) && is_array($options['responsive'])) {
                foreach ($options['responsive'] as $k => $arg) {
                    $resp[$k] = $arg;
                }
            }
            $options['responsive'] = $resp;

            return $options;
        }

        public function themeDeactive()
        {
        }
    }

}

?>
