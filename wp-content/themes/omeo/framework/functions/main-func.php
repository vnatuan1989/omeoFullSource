<?php

/**************
 * Header function
 *******************/
class Yesshop_Functions
{

    private static $instance = null;
    private $_data = array();

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get_menu($location, $class = '') {
        global $yesshop_datas;
        if($location === 'vertical-menu' && !empty($yesshop_datas['vertical-menu-limit-enable'])) $class .= ' vertical-limit-items';

        $output = wp_cache_get($location, 'yesshop_menu');
        if ($output === false) {
            ob_start();

            if (has_nav_menu($location)) {
                wp_nav_menu(array(
                    'container_class' => esc_attr($class),
                    'theme_location' => esc_attr($location),
                    'walker' => new Yesshop_Mega_Menu_Frontend(),
                    'items_wrap' => '<ul class="%1$s %2$s">%3$s</ul>'
                ));
            }

            $output = ob_get_clean();

            wp_cache_add($location, $output, 'yesshop_menu');
        }

        echo $output;
        return;
    }

    public function get_vertical_menu($class=''){
        global $yesshop_datas;

        if(isset($yesshop_datas['show-header-vertical']) && absint($yesshop_datas['show-header-vertical']) === 0) return;


    }

    public function getImage($atts, $echo = true)
    {
        $atts = wp_parse_args($atts, array(
            'alt' => esc_attr__('image alt', 'omeo'),
            'width' => '',
            'height' => '',
            'src' => '',
            'class' => 'yesshop-image'
        ));

        $src = esc_url($atts['src']);
        if (strlen(trim($src)) > 0) {
            $_img = '<img';
            foreach ($atts as $k => $v) {
                if (empty($v)) continue;
                $_img .= " {$k}=\"{$v}\"";
            }
            $_img .= '>';
            if ($echo) {
                echo wp_kses($_img, array(
                    'img' => array('alt' => array(), 'width' => array(), 'height' => array(), 'src' => array(), 'class' => array())
                ));
            } else {
                return wp_kses($_img, array(
                    'img' => array('alt' => array(), 'width' => array(), 'height' => array(), 'src' => array(), 'class' => array())
                ));
            }
        }
        return false;
    }

    public function getLogo($logo = false)
    {
        global $yesshop_datas;

        $title = !empty($yesshop_datas['logo-text']) ? esc_attr($yesshop_datas['logo-text']) : get_bloginfo('name');
        $logo_arg = array(
            'title' => esc_attr($title),
            'alt' => esc_attr($title)
        );

        $absolute_header = $yesshop_datas['absolute-header'];
        if(absint($absolute_header) == 1 && is_front_page()) {
            if (isset($yesshop_datas['logo-absolute']) && strlen(trim($yesshop_datas['logo-absolute']['url'])) > 0) {
                $logo_arg['src'] = esc_url($yesshop_datas['logo-absolute']['url']);
                $logo_arg['width'] = absint($yesshop_datas['logo-absolute']['width']);
                $logo_arg['height'] = absint($yesshop_datas['logo-absolute']['height']);
            }
        } else {

            if (isset($yesshop_datas['logo']) && strlen(trim($yesshop_datas['logo']['url'])) > 0) {
                $logo_arg['src'] = esc_url($yesshop_datas['logo']['url']);
                $logo_arg['width'] = absint($yesshop_datas['logo']['width']);
                $logo_arg['height'] = absint($yesshop_datas['logo']['height']);
            } else {
                if ($logo && file_exists(get_theme_file_path('images/' . $logo . '.png'))) {
                    $logo_arg['src'] = esc_url(THEME_IMG_URI . $logo . '.png');
                    $logo_arg['width'] = 401;
                    $logo_arg['height'] = 85;
                } else if (!empty($yesshop_datas['header-style']) && file_exists(get_theme_file_path('images/omeo-logo-' . $yesshop_datas['header-style'] . '.png'))) {
                    $logo_arg['src'] = esc_url(THEME_IMG_URI . 'omeo-logo-' . $yesshop_datas['header-style'] . '.png');
                    $logo_arg['width'] = 401;
                    $logo_arg['height'] = 85;
                } else {
                    $logo_arg['src'] = esc_url(THEME_IMG_URI . "omeo-logo-1.png");
                    $logo_arg['width'] = 472;
                    $logo_arg['height'] = 82;
                }

            }
        }

        echo '<div class="logo">';
        echo '<a href="' . esc_attr(home_url()) . '" title="' . esc_attr($title) . '">';
        Yesshop_Functions()->getImage($logo_arg);
        echo '</a>';
        echo '</div>';
    }

    public function headerShippingText(){
        global $yesshop_datas;
        if(!empty($yesshop_datas['header-shipping-text'])) {
            echo '<div class="yeti-sale-policy">' . do_shortcode(wp_kses_post(stripslashes(htmlspecialchars_decode($yesshop_datas['header-shipping-text'])))). '</div>';
        }
    }

    /**
     * Change get_headerTop_sidebar to get_header_sidebar
     * @param string $before
     * @param string $after
     * @param string $position
     */
    public function get_header_sidebar($before = '', $after = '', $position = 'top')
    {
        $sidebar_name = 'header-'.$position.'-widget-area';
        if (is_active_sidebar($sidebar_name)):?>
            <?php echo $before; ?>
            <ul class="widgets-sidebar">
                <?php dynamic_sidebar($sidebar_name); ?>
            </ul>
            <?php echo $after;?>
        <?php else:?>
            <?php
            $top_html = apply_filters('yesshop_header_top_html', '');
            if(strlen($top_html) > 0) {
                echo $before . $top_html . $after;
            }
            ?>
        <?php endif;
    }

    /**
     * Deprecated
     * @param string $before
     * @param string $after
     * @return mixed
     */
    public function get_headerTop_sidebar($before = '', $after = '')
    {
        if(function_exists('get_header_sidebar'))
        {
            return get_header_sidebar($before, $after, 'top');
        }
    }

    public function get_stickyHeaderClass($echo = false){
        global $yesshop_datas;
        if(!isset($yesshop_datas['sticky-header']) || absint($yesshop_datas['sticky-header'])) {
            $res = ' yeti-sticky animated t2';
        } else {
            $res = '';
        }

        if($echo) echo $res; else return $res;
    }

    public function getFontUrl()
    {
        global $yesshop_datas;
        $fonts_url = '';

        $font_families = array();


        if(empty($font_families)) return false;

        $poppins = esc_attr_x('on', 'Poppins font: on or off', 'omeo');

        if ('off' !== $poppins) {
            $query_args = array(
                'family' => urlencode(implode('|', $font_families)),
                'subset' => urlencode('latin'),
            );

            $fonts_url = add_query_arg($query_args, '//fonts.googleapis.com/css');
        }
        return esc_url_raw($fonts_url);
    }

    public function pageSlider($pos = null) {
        if (!is_page()) return '';

        global $yesshop_datas;

        if(isset($yesshop_datas['header-style']) && in_array(absint($yesshop_datas['header-style']), array(5)) && $pos !== 'header') return '';
        $yesshop_pages = $yesshop_datas['page-datas'];
        if (isset($yesshop_pages['slider_type']) && strlen($yesshop_pages['slider_type']) > 0) {

            $_extra_class = !empty($yesshop_pages['slider_swap'])? $yesshop_pages['slider_swap']: '';

            echo '<div class="slideshow-wrapper '. esc_attr($_extra_class) . '">';
            $yesshop_pages = Yesshop_Functions()->getOptions('page_options');
            switch (trim($yesshop_pages['slider_type'])) {
                case 'metaslider':
                    echo do_shortcode('[metaslider id="' . absint($yesshop_pages['meta_slider']) . '"]');
                    break;
                case "revolution":
                    if(function_exists('putRevSlider')) {
                        putRevSlider($yesshop_pages['rev_slider']);
                    }
                    break;
            }
            echo '</div>';
        }
    }

    public function get_owlResponsive($options = array())
    {
        $column = $options['items'];

        $resp = array(
            0 => array(
                'items' => round($column * (280 / 1200)),
                'loop' => false
            ),
            480 => array(
                'items' => round($column * (580 / 1200)),
                'loop' => false
            ),
            581 => array(
                'items' => round($column * (769 / 1200)),
                'loop' => false
            ),
            769 => array(
                'items' => round($column * (981 / 1200)),
                'loop' => false
            ),
            981 => array(
                'items' => round($column * (1170 / 1200)),
                'loop' => false
            )
        );
        if (isset($options['responsive']) && is_array($options['responsive'])) {
            foreach ($options['responsive'] as $k => $arg) {
                $resp[$k] = $arg;
            }
        }
        $options['responsive'] = $resp;

        return $options;
    }

    public function getThemeData($key = '', $def = false)
    {
        if (empty($key)) return false;

        global $yesshop_datas;

        return isset($yesshop_datas[$key]) ? $yesshop_datas[$key] : $def;
    }

    public function get_vertical_toggle_class()
    {
        global $yesshop_datas;

        $toggle_class = '';

        if(!empty($yesshop_datas['header-vertical-style'])) $toggle_class .= ' ' . $yesshop_datas['header-vertical-style'];

        if (is_home() && !is_front_page()) {
            $toggle_class .= ' toggle';
        } else {
            $toggle = Yesshop_Functions()->getThemeData('page-datas');

            $toggle = !empty($toggle['page_show_vert_menu']) ? absint($toggle['page_show_vert_menu']) : false;

            $toggle_class .= absint($toggle)? ' no-toggle': ' toggle';
        }

        return $toggle_class;
    }

    public function getOptions($slug = 'page_options', $datas = array())
    {
        $options = maybe_unserialize(get_post_meta(get_the_id(), 'yesshop_' . $slug, true));

        if (isset($options) && is_array($options)) {
            foreach ($options as $key => $value) {
                if (isset($value) && strlen($value) > 0) $datas[$key] = $value;
            }
        }
        return $datas;
    }

    public function getSidebarArgs($sidebar_options = array())
    {
        global $wp_registered_sidebars;
        foreach ($wp_registered_sidebars as $sidebar) {
            $sidebar_options[$sidebar['id']] = $sidebar['name'];
        }
        return $sidebar_options;
    }

    public function yt_get_yetiLoadingIcon()
    {
        if (function_exists('YetiThemes_Extra')) YetiThemes_Extra()->get_yetiLoadingIcon();
    }

    public function get_404_img(){
        global $yesshop_datas;

        if(!isset($yesshop_datas['404-img']) || empty($yesshop_datas['404-img']['url'])) $yesshop_datas['404-img'] = array();
        $_args = wp_parse_args($yesshop_datas['404-img'], array(
            'src'       => THEME_IMG_URI . '404-img.png'
        ));

        printf('<img src="%s" alt="404 Image">', esc_url($_args['src']));
    }

    public function get_404_content()
    {
        global $yesshop_datas;
        if (!empty($yesshop_datas['404page-stblock']) && function_exists('Yetithemes_StaticBlock')) {
            Yetithemes_StaticBlock()->getContentByID($yesshop_datas['404page-stblock']);
        }
    }

    public function paging_nav()
    {
        global $wp_query;
        if (function_exists('wp_pagenavi')) {
            wp_pagenavi();
            return;
        }
        ?>
        <div class="wp-pagenavi">
            <?php
            $pagi_args = array(
                'total' => $wp_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
                'mid_size' => 3,
                'type' => 'list',
            );
            if (function_exists('yesshop_paginate_links'))
                echo yesshop_paginate_links($pagi_args);
            else
                echo paginate_links($pagi_args);
            ?>
        </div>
        <?php
    }

    public function login_form($style = '')
    {
        if (!class_exists('WooCommerce')) return;

        $shop_myaccount_id = get_option('woocommerce_myaccount_page_id');
        if (isset($shop_myaccount_id) && absint($shop_myaccount_id) > 0) {
            $myaccount_url = get_permalink($shop_myaccount_id);
            $ac_link_title = esc_html__("My Account", 'omeo');
        } else return 'Woocommerce account page was not found!';

        switch ($style) {
            case 'icon':
                $_text = false;
                $_loged_icon = true;
                $_dropdown = true;
                $_style = 'icon-style';
                break;
            case 'mobile':
                $_text = true;
                $_loged_icon = false;
                $_dropdown = false;
                $_style = 'mobile-style';
                break;
            default:
                $_text = true;
                $_loged_icon = false;
                $_dropdown = true;
                $_style = 'default-style';
        }
        if (is_user_logged_in()) {

            ?>
            <div class="yeti-mini-popup blur-hover my-account <?php echo esc_attr($_style)?>">
                <div class="mini-popup-hover nth-login-hover">
                    <a href="<?php echo esc_url($myaccount_url); ?>" title="<?php echo esc_attr($ac_link_title); ?>">
                        <?php if($_loged_icon) echo '<i class="fa fa-user" aria-hidden="true"></i>'?>
                        <?php if($_text) echo '<span>' . esc_html__('My Account', 'omeo') . '</span>';?>
                    </a>
                </div>

                <?php if (function_exists('wc_get_account_menu_items') && $_dropdown) : ?>

                    <div class="yeti-mini-popup-cotent yeti-mini-login-content">
                        <ul class="list-unstyled">

                            <?php foreach (wc_get_account_menu_items() as $endpoint => $label):
                                $src = '#';

                                if (isset($label['icon'])) {
                                    $_icon_class = $label['icon'];
                                } else {
                                    $_icon_class = 'fa fa-cog';
                                }

                                if (is_array($label)) {
                                    if (isset($label['url'])) {
                                        $src = $label['url'];
                                    } else {
                                        $src = wc_get_account_endpoint_url($endpoint);;
                                    }
                                    $label = $label['label'];
                                } else {
                                    $src = wc_get_account_endpoint_url($endpoint);
                                }
                                ?>
                                <li><a href="<?php echo esc_url($src) ?>" title="<?php echo esc_attr($label); ?>"><i
                                                class="<?php echo esc_attr($_icon_class) ?>" aria-hidden="true"></i>&nbsp; <?php echo esc_attr($label); ?>
                                    </a></li>

                            <?php endforeach; ?>

                        </ul>
                    </div>

                <?php endif; ?>
            </div><!--yeti-mini-popup nth-mini-login-->
            <?php

        } else {
            $rand_id = mt_rand();
            $args = array(
                'echo' => true,
                'form_id' => 'header_loginform' . $rand_id,
                'label_username' => esc_html__('Username', 'omeo'),
                'label_password' => esc_html__('Password', 'omeo'),
                'label_remember' => esc_html__('Remember Me', 'omeo'),
                'label_log_in' => esc_html__('Log In', 'omeo'),
                'id_username' => 'user_login' . $rand_id,
                'id_password' => 'user_pass' . $rand_id,
                'id_remember' => 'rememberme' . $rand_id,
                'id_submit' => 'submit' . $rand_id,
                'remember' => false,
                'value_username' => '',
                'value_remember' => false
            );

            ?>
            <div class="yeti-mini-popup blur-hover mini-login <?php echo esc_attr($_style)?>">
                <div class="mini-popup-hover nth-login-hover">
                    <a href="<?php echo esc_url($myaccount_url); ?>" title="<?php echo esc_attr($ac_link_title); ?>">
                        <?php if($_text) echo '<span class="arrow_down">'.esc_html_e('Sign In', 'omeo').'</span>'?>
                        <span class="caret"></span>
                    </a>
                </div>

                <?php if ($_dropdown) : ?>
                    <div class="yeti-mini-popup-cotent yeti-mini-login-content">
                        <div class="yeti-ajax-login-wrapper">
                            <?php echo wp_login_form($args); ?>
                        </div>

                        <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes'): ?>
                            <div class="yeti-mini-popup-footer">
                                <p><?php esc_html_e('New customer?', 'omeo'); ?></p>
                                <?php printf('<a class="button" href="%1$s" title="%2$s">%2$s</a>', esc_url(esc_url($myaccount_url)), esc_attr__('Register an account', 'omeo')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
            <?php
        }
    }

    public function shoppingCart($style = '', $dropdown = true)
    {
        if (!class_exists('WooCommerce')) return;

        $_arrow_down = $dropdown? ' tini-dropdown': ' tini-offcanvas';

        switch ($style) :
            case 'icon':
                ?>
                <div class="yeti-mini-popup nth-shopping-cart">
                    <div class="mini-popup-hover nth-shopping-hover<?php echo esc_attr($_arrow_down)?>">
                        <a href="<?php echo esc_url(wc_get_cart_url()) ?>" title="<?php esc_attr_e('My Cart', 'omeo'); ?>">
                            <i class="yeti-icon yeti-shopping-bag" aria-hidden="true" data-count="<?php echo absint(WC()->cart->cart_contents_count)?>"></i>
                        </a>
                    </div>

                    <?php if($dropdown) :?>
                        <div class="yeti-mini-popup-cotent nth-shopping-cart-content">
                            <div class="widget_shopping_cart_content"></div>
                        </div>
                    <?php endif;?>

                </div>
                <?php
                break;
            case 'mobile':
                ?>
                <div class="yeti-mini-popup blur-hover nth-shopping-cart">
                    <div class="mini-popup-hover nth-shopping-hover">
                        <a href="<?php echo esc_url(wc_get_cart_url()) ?>" title="<?php esc_attr_e('My Cart', 'omeo'); ?>">
                            <i class="yeti-icon yeti-shopping-bag" aria-hidden="true"></i>
                            <p><span class="arrow_down"><?php printf(_n('%s item', '%s items', absint(WC()->cart->cart_contents_count), 'omeo'), absint(WC()->cart->cart_contents_count)); ?> </span></p>
                        </a>
                    </div>
                </div>
                <?php
                break;
            default:
                ?>
                <div class="yeti-mini-popup nth-shopping-cart">
                    <div class="mini-popup-hover nth-shopping-hover<?php echo esc_attr($_arrow_down)?>">
                        <a href="<?php echo esc_url(wc_get_cart_url()) ?>" title="<?php esc_attr_e('My Cart', 'omeo'); ?>">
                            <i class="yeti-icon yeti-shopping-bag" aria-hidden="true" data-count="<?php echo absint(WC()->cart->cart_contents_count)?>"></i>
                            <p>
                                <strong><?php esc_html_e('Cart', 'omeo');?></strong>
                                <small class="arrow_down"><?php printf(_n('%s item', '%s items', absint(WC()->cart->cart_contents_count), 'omeo'), absint(WC()->cart->cart_contents_count)); ?> </small>
                            </p>
                        </a>
                    </div>

                    <?php if($dropdown) :?>
                    <div class="yeti-mini-popup-cotent nth-shopping-cart-content">
                        <div class="widget_shopping_cart_content"></div>
                    </div>
                    <?php endif;?>

                </div>
                <?php
        endswitch;

    }

    public function video_id($link, $type = 'yt')
    {
        switch ($type) {
            case 'vm':
                if (preg_match('/^https:\/\/(?:www\.)?vimeo\.com\/(?:clip:)?(\d+)/', $link, $match)) {
                    return $match[1];
                } else return false;
                break;
            default:
                if (preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $link, $matches)) {
                    return $matches[1];
                } else return false;
        }
    }

    public function video_player($params)
    {
        $defaults = array(
            'url' => "",
            'width' => 870,
            'height' => 560
        );
        $atts = wp_parse_args($params, $defaults);
        if (strstr($atts['url'], 'youtu')) {
            $v_id = $this->video_id($atts['url']);
            echo '<div class="embed-responsive embed-responsive-16by9">';
            printf('<iframe class="embed-responsive-item" src="%s"></iframe>', esc_url('https://www.youtube.com/embed/' . $v_id . '?autoplay=0&rel=0&enablejsapi=1&playerapiid=ytplayer&wmode=transparent'));
            echo '</div>';
        } elseif (strstr($atts['url'], 'vimeo.com')) {
            $v_id = $this->video_id($atts['url'], 'vm');
            echo '<div class="embed-responsive embed-responsive-16by9">';
            printf('<iframe class="embed-responsive-item" src="%s"></iframe>', esc_url('https://player.vimeo.com/video/' . $v_id));
            echo '</div>';
        }
    }

    public function video_local_player($params)
    {
        $defaults = array(
            'mp4' => "",
            'ogg' => "",
            'webm' => "",
            'width' => 830,
            'height' => 525
        );
        $atts = wp_parse_args($params, $defaults);
        if (strlen($atts['mp4']) > 0 || strlen($atts['ogg']) > 0 || strlen($atts['webm']) > 0): ?>
            <video width="<?php echo absint($atts['width']); ?>" height="<?php echo absint($atts['height']); ?>"
                   controls>
                <?php if (strlen($atts['mp4']) > 0): ?>
                    <source src="<?php echo esc_url($atts['mp4']); ?>" type="video/mp4">
                <?php endif; ?>
                <?php if (strlen($atts['ogg']) > 0): ?>
                    <source src="<?php echo esc_url($atts['ogg']); ?>" type="video/ogg">
                <?php endif; ?>
                <?php if (strlen($atts['webm']) > 0): ?>
                    <source src="<?php echo esc_url($atts['webm']); ?>" type="video/webm">
                <?php endif; ?>
                <?php esc_html_e("Your browser does not support the video tag.", 'omeo'); ?>
            </video>
        <?php endif;
    }

    public function pages_sidebar_act($file = 'archive')
    {
        global $yesshop_datas;

        $_left = $_right = false;
        $_cont_class = array('col-sm-24');
        $_left_class = $_right_class = array();

        $res = array();
        switch ($file) {
            case 'shop':
                if (is_product()) {
                    $_left_sidebar = isset($yesshop_datas['product-page-left-sidebar']) ? $yesshop_datas['product-page-left-sidebar'] : '';
                    $_right_sidebar = isset($yesshop_datas['product-page-right-sidebar']) ? $yesshop_datas['product-page-right-sidebar'] : '';
                    $_layout = !empty($yesshop_datas['product-page-layout']) ? explode('-', $yesshop_datas['product-page-layout']) : false;
                } else {
                    $_left_sidebar = isset($yesshop_datas['shop-left-sidebar']) ? $yesshop_datas['shop-left-sidebar'] : '';
                    $_right_sidebar = isset($yesshop_datas['shop-right-sidebar']) ? $yesshop_datas['shop-right-sidebar'] : '';
                    $_layout = !empty($yesshop_datas['shop-layout']) ? explode('-', $yesshop_datas['shop-layout']) : false;
                    $res['_prod_cat_infomation'] = !empty($yesshop_datas['cat-jumbotron']) ? $yesshop_datas['cat-jumbotron'] : '';
                }
                break;
            case 'blog':
                if (isset($yesshop_datas['page-datas']['page_leftsidebar'])) {
                    $_left_sidebar = $yesshop_datas['page-datas']['page_leftsidebar'];
                } elseif (isset($yesshop_datas['blog-left-sidebar'])) {
                    $_left_sidebar = $yesshop_datas['blog-left-sidebar'];
                } else $_left_sidebar = '';

                if (isset($yesshop_datas['page-datas']['page_rightsidebar'])) {
                    $_right_sidebar = $yesshop_datas['page-datas']['page_rightsidebar'];
                } elseif (isset($yesshop_datas['blog-right-sidebar'])) {
                    $_right_sidebar = $yesshop_datas['blog-right-sidebar'];
                } else $_right_sidebar = 'main-widget-area';

                if (!empty($yesshop_datas['page-datas']['page_layout']) && is_page()) {
                    $_layout_str = $yesshop_datas['page-datas']['page_layout'];
                } elseif (!empty($yesshop_datas['blog-layout'])) {
                    $_layout_str = $yesshop_datas['blog-layout'];
                } else $_layout_str = '0-1';

                $_layout = strlen($_layout_str) > 0 ? explode('-', $_layout_str) : false;

                $res['_blog_cols'] = !empty($yesshop_datas['page-datas']['yeti_blog_columns']) ? absint($yesshop_datas['page-datas']['yeti_blog_columns']) : 3;
                break;
            default:
                $_left_sidebar = isset($yesshop_datas['page-datas']['page_leftsidebar']) ? $yesshop_datas['page-datas']['page_leftsidebar'] : '';
                $_right_sidebar = isset($yesshop_datas['page-datas']['page_rightsidebar']) ? $yesshop_datas['page-datas']['page_rightsidebar'] : '';
                $_layout = !empty($yesshop_datas['page-datas']['page_layout']) ? explode('-', $yesshop_datas['page-datas']['page_layout']) : false;

        }

        if ($_layout) {
            if (empty($yesshop_datas['sidebars-width'])) $yesshop_datas['sidebars-width'] = array(1 => 6, 2 => 18);
            if (empty($yesshop_datas['sidebars-width-sm'])) $yesshop_datas['sidebars-width-sm'] = array(1 => 7, 2 => 17);

            if (absint($_layout[0])) {
                $_left = true;
                $_left_class[] = absint($yesshop_datas['sidebars-width'][1]) > 0 ?
                    'col-lg-' . absint($yesshop_datas['sidebars-width'][1]) : 'hidden-lg hidden-md';
                $_left_class[] = absint($yesshop_datas['sidebars-width-sm'][1]) > 0 ?
                    'col-sm-' . absint($yesshop_datas['sidebars-width-sm'][1]) : 'hidden-sm hidden-xs';
                $_cont_class = array('has-leftsidebar pull-right');
                $_cont_class[] = 'col-lg-' . (24 - absint($yesshop_datas['sidebars-width'][1]));
                $_cont_class[] = 'col-sm-' . (24 - absint($yesshop_datas['sidebars-width-sm'][1]));
                $_cont_class[] = 'col-xs-24';
            }
            if (absint($_layout[1])) {
                $_right = true;
                $_right_class[] = absint($yesshop_datas['sidebars-width'][2]) < 24 ?
                    'col-lg-' . (24 - absint($yesshop_datas['sidebars-width'][2])) : 'hidden-lg hidden-md';
                $_right_class[] = absint($yesshop_datas['sidebars-width-sm'][2]) < 24 ?
                    'col-sm-' . (24 - absint($yesshop_datas['sidebars-width-sm'][2])) : 'hidden-sm hidden-xs';
                $_cont_class = array('has-rightsidebar');
                $_cont_class[] = 'col-lg-' . absint($yesshop_datas['sidebars-width'][2]);
                $_cont_class[] = 'col-sm-' . absint($yesshop_datas['sidebars-width-sm'][2]);
            }
            if ($_right && $_left) {
                $_cont_class = array('has-leftsidebar has-rightsidebar');
                $_cont_class[] = 'col-lg-' . (absint($yesshop_datas['sidebars-width'][2]) - absint($yesshop_datas['sidebars-width'][1]));
                $_cont_class[] = 'col-sm-' . (absint($yesshop_datas['sidebars-width-sm'][2]) - absint($yesshop_datas['sidebars-width-sm'][1]));
            }
        }
        if (empty($_cont_class)) $_cont_class[] = 'col-sm-24';
        $res['_left_class'] = implode(' ', $_left_class);
        $res['_cont_class'] = implode(' ', $_cont_class);
        $res['_right_class'] = implode(' ', $_right_class);
        $res['_left_sidebar'] = $_left_sidebar;
        $res['_right_sidebar'] = $_right_sidebar;

        if (!empty($yesshop_datas['page-datas']["page_temp_per_page"])) {
            $res['_per_page'] = absint($yesshop_datas['page-datas']["page_temp_per_page"]);
        }
        if (!empty($yesshop_datas['page-datas']["album_style"])) $res['_album_style'] = $yesshop_datas['page-datas']["album_style"];

        return $res;
    }

    public function get_post_options($post_id, $slug = 'yesshop_post_options')
    {
        global $yesshop_datas;
        if ($post_options = get_post_meta($post_id, $slug, true)) {
            $res = maybe_unserialize($post_options);
        } else $res = array('null');

        $_date_format = str_replace(',', ' ', $yesshop_datas['date-format']);
        $_date_format = str_replace('/', ' ', $_date_format);
        $_date_format = trim(str_replace('-', ' ', $_date_format));
        $_date_format = explode(' ', $_date_format);
        $res['date-format'] = array();

        foreach ($_date_format as $k) {
            if(in_array($k, array('F', 'm', 'n', 'M'))) {
                $res['date-format']['m'] = $k;
            } elseif(in_array($k, array('d', 'j', 'S'))) {
                $res['date-format']['d'] = $k;
            }
        }

        return $res;
    }

    public function compare_object()
    {
        $fontend = array();
        if (class_exists('YITH_Woocompare')) {
            global $yith_woocompare;
            $fontend = $yith_woocompare->obj;
        }
        return $fontend;
    }

    private function search_cat_select($term_ids = array())
    {
        global $wp_query;

        $current_product_cat = isset($wp_query->query_vars['product_cat']) ? $wp_query->query_vars['product_cat'] : '';

        $args = array(
            'pad_counts' => 1,
            'show_count' => 0,
            'hierarchical' => 1,
            'hide_empty' => 1,
            'show_uncategorized' => 0,
            'orderby' => 'name',
            'selected' => $current_product_cat,
            'menu_order' => false,
            'parent' => 0,
        );

        if (count($term_ids) > 0) $args['include'] = $term_ids;

        $terms = get_terms('product_cat', $args);

        if (!empty($terms)) {
            $current_term = get_term_by('slug', $current_product_cat, 'product_cat');
            if (!empty($current_term)) {
                $current_cat = array(
                    'slug' => $current_term->slug,
                    'name' => $current_term->name
                );
            } else {
                $current_cat = array(
                    'slug' => '',
                    'name' => esc_attr__('All categories', 'omeo')
                );
            }

            ?>
            <div class="dropdown input-group-addon">
                <a class="dropdown-toggle" id="search_prod_cats" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="true">
                    <span class="dropdown-text"><?php echo esc_html($current_cat['name']) ?></span>
                    <input type="hidden" class="dropdown-value" name="product_cat"
                           value="<?php echo esc_attr($current_cat['slug']); ?>">
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="search_prod_cats">
                    <li data-val=""><a href="#"><?php esc_attr_e('All categories', 'omeo'); ?></a></li>
                    <li role="separator" class="divider"></li>
                    <?php foreach ($terms as $term) :
                        printf('<li data-val="%s"><a href="#">%s</a></li>', esc_attr($term->slug), esc_attr($term->name));
                    endforeach; ?>
                </ul>
            </div>

            <?php
        }
    }

    public function search_form($style = '', $ajax = true)
    {
        global $yesshop_datas;
        $rand_id = mt_rand();
        $check_woo = class_exists('WooCommerce');
        if ($check_woo) {
            $_placeholder = esc_attr__("Search product...", 'omeo');
        } else {
            $_placeholder = esc_attr__("Search anything...", 'omeo');
        }

        $_cat_ids = empty($yesshop_datas['search-form-cats']) ? array() : $yesshop_datas['search-form-cats'];
        $_form_class = 'searchform';
        if($ajax) {
            $_form_class .= ' yeti-searchform';
        }
        ?>
        <form id="form_<?php echo esc_attr($rand_id) ?>" method="get" class="<?php echo esc_attr($_form_class)?>" action="<?php echo esc_url(home_url('/')); ?>">

            <label class="" for="s_<?php echo esc_attr($rand_id) ?>"><?php esc_html_e('Search for:', 'omeo'); ?></label>

            <div class="input-group">
                <input type="text" class="form-control" aria-label="Product Search"
                       placeholder="<?php echo esc_attr($_placeholder); ?>" value="<?php echo get_search_query() ?>"
                       name="s" id="s_<?php echo esc_attr($rand_id) ?>"/>
                <input type="hidden" value="product" name="post_type"/>
                <?php if ($style !== 'non-cat' && !empty($yesshop_datas['search-form-with-cat']) && absint($yesshop_datas['search-form-with-cat']) > 0) $this->search_cat_select($_cat_ids); ?>
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>

        </form>
        <?php
    }

    public function archive_item_action(&$__post_datas, &$_class)
    {
        $__post_datas['type'] = Yesshop_Functions()->getThemeData('blog-type');
        if (!$__post_datas['type']) $__post_datas['type'] = 'default';


        switch ($__post_datas['type']) {
            case 'sticky-columns':
                if(is_sticky()) $__post_datas['style'] = 'overlay-style';
                else $__post_datas['style'] = 'default-style';
                break;
            case 'columns':
                $__post_datas['style'] = 'overlay-style';
                break;
            case 'list-mode':
                $__post_datas['style'] = 'list-style';
                break;
            default:
                $__post_datas['style'] = 'default-style';
        }
        $__post_datas['columns'] = absint(Yesshop_Functions()->getThemeData('blog-columns'));
        if ($__post_datas['columns'] === 0 || $__post_datas['type'] === 'default' || (is_sticky() && $__post_datas['type'] === 'sticky-columns')) {
            $__post_datas['columns'] = 1;
        }

        if (absint($__post_datas['is_shortcode'])) {
            if(empty($__post_datas['thumb_size'])) $__post_datas['thumb_size'] = 'yesshop_blog_thumb_grid';
        } else {
            if ($__post_datas['type'] == 'masonry' && !is_sticky()) {
                $__post_datas['s_cats'] = $__post_datas['s_tags'] = false;
                $__post_datas['thumb_size'] = 'yesshop_blog_thumb_grid_o';
            } else {
                $__post_datas['thumb_size'] = 'yesshop_blog_thumb';
            }
        }

        $__post_datas['thumb_size'] = apply_filters('yesshop_archive_thumbnail', $__post_datas['thumb_size']);

        $_class[] = 'post-' . esc_attr($__post_datas['style']);
        if ((isset($__post_datas['columns']) && absint($__post_datas['columns']) > 1)) {
            $_class[] = 'col-lg-' . round(24 / $__post_datas['columns']);
            $_class[] = 'col-md-' . round(24 / round($__post_datas['columns'] * 992 / 1200));
            $_class[] = 'col-sm-' . round(24 / round($__post_datas['columns'] * 768 / 1200));
            $_class[] = 'col-xs-' . round(24 / round($__post_datas['columns'] * 480 / 1200));
            $_class[] = 'col-mb-24';
        } else {
            $_class[] = 'col-sm-24';
        }
    }

    public function get_tooltip_pos(){
        global $yesshop_datas;

        if( function_exists('is_product') && is_product()) {
            return 'top';
        }
        if(empty($yesshop_datas['product-item-style'])) return 'top';

        switch ($yesshop_datas['product-item-style']) {
            case 'shadow_s1':
            case 'shadow_none':
            case 'classic-round':
                return false;
                break;
            case 'border_rounded':
                return false;
                break;
            default:
                $_pos = 'top';
        }

        return apply_filters('yesshop_product_button_tooltip_pos', $_pos);
    }
}

function Yesshop_Functions()
{
    return Yesshop_Functions::get_instance();
}
