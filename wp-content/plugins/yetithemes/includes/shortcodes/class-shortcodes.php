<?php
// ! File Security Check
if (!defined('ABSPATH')) exit;


class Yetithemes_Shortcodes
{

    public function __construct()
    {
        add_action('init', array($this, 'init'));
    }

    public static function popString($content, $limit = 15)
    {
        if (strlen(trim($content)) == 0) return '';
        if (!is_numeric($limit)) return $content;

        $str_args = explode(' ', $content, ($limit + 1));
        if (count($str_args) > $limit) {
            array_pop($str_args);
            $str_args[$limit - 1] .= '...';
        }

        return implode(' ', $str_args);
    }

    public function init()
    {
        $shortcodes = array(
            'yesshop_banner'            => __CLASS__ . '::banners',
            'yesshop_brands'            => __CLASS__ . '::brands',
            'yesshop_feedburner'        => __CLASS__ . '::feedburner',
            'yesshop_infobox'           => __CLASS__ . '::infobox',
            'yesshop_recent_comments'   => __CLASS__ . '::recent_comments',
            'yesshop_recent_posts'      => __CLASS__ . '::recent_posts',
            'yesshop_pricing'           => __CLASS__ . '::pricing',
            'yesshop_action'            => __CLASS__ . '::action',
            'yesshop_maps'              => __CLASS__ . '::google_maps',
            'yesshop_button'            => __CLASS__ . '::buttons',
            'site_url'                  => __CLASS__ . '::site_url',
            'yesshop_head_top_login'    => __CLASS__ . '::head_top_login',
            'yesshop_head_top_cart'     => __CLASS__ . '::head_top_cart',
            'yesshop_head_top_search'   => __CLASS__ . '::head_top_search',
            'yesshop_social'            => __CLASS__ . '::social_network',
            'yesshop_qrcode'            => __CLASS__ . '::qrcode',
            'yesshop_store_location'    => __CLASS__ . '::store_location',
            'yesshop_tag_cloud'         => __CLASS__ . '::tag_cloud',
            'yesshop_heading'           => __CLASS__ . '::heading',
            'yesshop_icon'              => __CLASS__ . '::geticon',
            'yesshop_currency_switcher' => __CLASS__ . '::currency_switcher',
            'yesshop_multi_language'    => __CLASS__ . '::multi_language',
            'yesshop_galleries'         => __CLASS__ . '::yeti_galleries',
            'yeti_empty_space'         => __CLASS__ . '::yeti_empty_space',
        );

        if (class_exists('Yetithemes_Instagram')) {
            $shortcodes['yesshop_instagram'] = __CLASS__ . '::instagram';
        }

        if (class_exists('Yetithemes_StaticBlock')) {
            $shortcodes['yesshop_staticblock'] = __CLASS__ . '::staticblock';
        }

        if (class_exists('Yetithemes_TeamMembers') && class_exists('Yetithemes_TeamMembers_Front')) {
            $shortcodes['yesshop_teams'] = __CLASS__ . '::teammember';
        }

        if (class_exists('Woothemes_Testimonials')) {
            $shortcodes['yesshop_testimonials'] = __CLASS__ . '::testimonials';
        }

        if (class_exists('Woothemes_Features')) {
            $shortcodes['yesshop_features'] = __CLASS__ . '::features';
        }

        if (class_exists('Projects')) {
            $shortcodes['yesshop_single_project'] = __CLASS__ . '::woo_single_project';
        }

        foreach ($shortcodes as $shortcode => $function) {
            add_shortcode($shortcode, $function);
        }

    }

    public static function head_top_login($atts)
    {
        global $detect;
        $atts = shortcode_atts(array(
            'popup' => '',
        ), $atts);

        $_class = array('valign_middle yeti-mini-popup');
        if (strlen($atts['popup']) > 0) $_class[] = 'popup_' . esc_attr($atts['popup']);

        if (!class_exists('WooCommerce')) return;

        $shop_myaccount_id = get_option('woocommerce_myaccount_page_id');
        if (isset($shop_myaccount_id) && absint($shop_myaccount_id) > 0) {
            $myaccount_url = get_permalink($shop_myaccount_id);
            $ac_link_title = esc_html__("My Account", 'yetithemes');
        } else return 'Woocommerce account page was not found!';

        ob_start();
        if (is_user_logged_in()) {

            ?>
            <div class="yeti-mini-popup blur-hover my-account yt-myaccount">
                <div class="mini-popup-hover nth-login-hover">
                    <a href="<?php echo esc_url($myaccount_url); ?>" title="<?php echo esc_attr($ac_link_title); ?>">
                        <span class="yt-label"><?php esc_html_e('My Account', 'yetithemes'); ?></span>
                        <span class="caret"></span>
                    </a>
                </div>

                <?php if (!$detect->isMobile() && function_exists('wc_get_account_menu_items')) : ?>

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
                'label_username' => esc_html__('Username', 'yetithemes'),
                'label_password' => esc_html__('Password', 'yetithemes'),
                'label_remember' => esc_html__('Remember Me', 'yetithemes'),
                'label_log_in' => esc_html__('Log In', 'yetithemes'),
                'id_username' => 'user_login' . $rand_id,
                'id_password' => 'user_pass' . $rand_id,
                'id_remember' => 'rememberme' . $rand_id,
                'id_submit' => 'submit' . $rand_id,
                'remember' => false,
                'value_username' => '',
                'value_remember' => false
            );

            ?>
            <div class="yeti-mini-popup blur-hover mini-login">
                <div class="mini-popup-hover nth-login-hover">
                    <a href="<?php echo esc_url($myaccount_url); ?>" title="<?php echo esc_attr($ac_link_title); ?>">
                        <span class="arrow_down"><?php esc_html_e("Sign In", 'yetithemes') ?></span>
                        <span class="caret"></span>
                    </a>
                </div>

                <?php if (!$detect->isMobile()) : ?>
                    <div class="yeti-mini-popup-cotent yeti-mini-login-content">
                        <div class="yeti-ajax-login-wrapper">
                            <?php wp_login_form($args); ?>
                        </div>

                        <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes'): ?>
                            <div class="yeti-mini-popup-footer">
                                <p><?php esc_html_e('New customer?', 'yetithemes'); ?></p>
                                <?php printf('<a class="button" href="%1$s" title="%2$s">%2$s</a>', esc_url(esc_url($myaccount_url)), esc_attr__('Register an account', 'yetithemes')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
            <?php
        }

        return '<div class="' . esc_attr(implode(' ', $_class)) . '">' . ob_get_clean() . '</div>';
    }

    public static function head_top_cart($atts)
    {
        $atts = shortcode_atts(array(
            'popup' => '',
        ), $atts);

        $_class = array('valign_middle yeti-mini-popup');
        if (strlen($atts['popup']) > 0) $_class[] = 'popup_' . esc_attr($atts['popup']);

        if (!class_exists('WooCommerce')) return;

        ob_start();

        echo '<div class="mini-popup-hover nth-shopping-hover tini-offcanvas"><a href="'.esc_url(wc_get_cart_url()).'"><i class="yeti-icon yeti-shopping-bag-o" aria-hidden="true"></i> <strong>' . __('Cart:', 'yetithemes') . '</strong> <span class="arrow_down">'.esc_attr('0 item', 'yetithemes').'</span></a></div>';

        return '<div class="' . esc_attr(implode(' ', $_class)) . '">' . ob_get_clean() . '</div>';
    }

    public static function head_top_search($atts)
    {
        $atts = shortcode_atts(array(
            'popup' => '',
        ), $atts);

        $rand_id = mt_rand();
        if (class_exists('WooCommerce')) {
            $_placeholder = esc_attr__("Search product...", 'yesshop');
        } else {
            $_placeholder = esc_attr__("Search anything...", 'yesshop');
        }

        $_form_class = 'searchform yeti-searchform';

        ob_start();

        ?>
        <form id="form_<?php echo esc_attr($rand_id) ?>" method="get" class="<?php echo esc_attr($_form_class)?>" action="<?php echo esc_url(home_url('/')); ?>">

            <label class="sr-only screen-reader-text" for="s_<?php echo esc_attr($rand_id) ?>"><?php esc_html_e('Search for:', 'yesshop'); ?></label>

            <div class="input-group">
                <input type="text" class="form-control" aria-label="Product Search" placeholder="<?php echo esc_attr($_placeholder); ?>" value="<?php echo get_search_query() ?>" name="s" id="s_<?php echo esc_attr($rand_id) ?>"/>
                <input type="hidden" value="product" name="post_type"/>
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>

        </form>
        <?php

        return ob_get_clean();
    }

    public static function site_url($atts)
    {
        $atts = shortcode_atts(array(
            'method' => 'return',
            'path' => '',
            'scheme ' => null
        ), $atts);

        if (strlen($atts['scheme']) > 0) $site = site_url($atts['path'], $atts['scheme']);
        else $site = site_url($atts['path'], $atts['scheme']);

        if (strcmp($atts['method'], 'return') == 0) return $site;
        else echo $site;
    }

    public static function banners($atts, $content)
    {
        $atts = shortcode_atts(array(
            'link' => '',
            'bg_source' => 'external',
            'bg_img_id' => '',
            'bg_image' => '',
            'bg_img' => '',
            'hidden_on' => '',
            'class' => '',
            'css' => ''
        ), $atts);

        $atts['content'] = strlen(trim($content)) > 0 ? $content : '';

        $classes = array('yeti-shortcode', 'yeti-banner');
        if (strlen($atts['class']) > 0) $classes[] = $atts['class'];

        if (strlen(trim($atts['hidden_on'])) > 0) $classes[] = $atts['hidden_on'];
        $atts['class'] = implode(' ', $classes);

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('shortcode-banners.tpl.php', $atts);

        return ob_get_clean();
    }

    public static function brands($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'h_style' => '',
            'style' => '',
            'items' => '',
            'column' => 6,
            'css' => ''
        ), $atts);

        if (strlen(trim($atts['items'])) == 0) return;

        $atts['items'] = (array)vc_param_group_parse_atts($atts['items']);
        foreach ($atts['items'] as $k => $v) {
            if (isset($v['link'])) $atts['items'][$k]['link'] = self::convert_VC_link($v['link']);
        }

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('shortcode-brands.tpl.php', $atts);

        $classes = array('yeti-shortcode yeti-' . __FUNCTION__);

        return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';
    }

    public static function feedburner($atts)
    {
        $atts = shortcode_atts(array(
            'fb_id' => 'kinhdon/Ahzl',
        ), $atts);

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('shortcode-feedburner.tpl.php', $atts);

        return '<div class="yeti-shortcode ' . __FUNCTION__ . '">' . ob_get_clean() . '</div>';
    }

    public static function infobox($atts)
    {

        $atts = shortcode_atts(array(
            "title" => 'title',
            "desc" => '',
            "use_icon" => 'yes',
            "type" => 'fontawesome',
            "icon_fontawesome" => 'fa fa-adjust',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-note',
            "icon_linecons" => 'vc_li vc_li-heart',
            "background_style" => '',
            "color" => 'black',
            "custom_color" => 'inherit',
            "icon_background" => 'white',
            "custom_icon_background" => '#ededed',
            "icon_img" => ''
        ), $atts);

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('shortcode-infobox.tpl.php', $atts);

        return '<div class="yeti-shortcode yeti-' . __FUNCTION__ . '">' . ob_get_clean() . '</div>';
    }

    public static function recent_comments($atts)
    {
        $atts = shortcode_atts(array(
            "title" => '',
            "limit" => 5,
            "excerpt_words" => 15,
            "as_widget" => 0,
        ), $atts);

        $comments = get_comments(apply_filters('widget_comments_args', array(
            'number' => $atts['limit'],
            'status' => 'approve',
            'post_status' => 'publish'
        )));

        ob_start();

        if ($comments) {

            $atts['comments'] = $comments;

            YetiThemes_Extra()->get_shortcode_template('shortcode-comments.tpl.php', $atts);

        }

        return '<div class="yeti-shortcode recent-comments">' . ob_get_clean() . '</div>';
    }

    public static function recent_posts($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'cats' => '',
            'head_style' => '',
            'limit' => 5,
            'is_slider' => 1,
            'excerpt_words' => 15,
            'as_widget' => 0,
            'w_style' => 'dark-style',
            'hidden_date' => 0,
            's_cats' => 1,
            's_button' => 1,
            's_thumb' => 1,
            's_author' => 0,
            's_excerpt' => 1,
            'orderby' => '',
            'order' => 'DESC',
            'columns' => '1',
            'b_layout'  => 'default',
            'thumb_size'    => 'yesshop_blog_thumb_grid',
            'padding'   => ''
        ), $atts);

        $args = array(
            'post_type' => 'post',
            'ignore_sticky_posts' => 1,
            'showposts' => $atts['limit'],
            'meta_query' => array()
        );

        if (isset($atts['has_img']) && absint($atts['has_img']) === 1) {
            $args['meta_query'][] = array(
                'key' => '_thumbnail_id',
            );
        }

        if (!empty($atts['orderby'])) {
            $args['orderby'] = esc_attr($atts['orderby']);
            $args['order'] = esc_attr($atts['order']);
        }

        if (strlen($atts['cats']) > 0) {
            $args['category__in '] = explode(',', $atts['cats']);
        }

        ob_start();

        $_post = new WP_Query($args);

        set_query_var('__post_datas', $atts);

        if ($_post->have_posts()) {
            global $yesshop_datas;
            $_old_btype = !empty($yesshop_datas['blog-type'])? $yesshop_datas['blog-type']: 'default';

            $yesshop_datas['blog-type'] = $atts['b_layout'];

            $atts['_post'] = $_post;
            $call_excerpt_lenght = create_function('$res', "return {$atts['excerpt_words']};");
            add_filter('excerpt_length', $call_excerpt_lenght, 999);

            YetiThemes_Extra()->get_shortcode_template('shortcode-post-widget.tpl.php', $atts);

            remove_filter('excerpt_length', $call_excerpt_lenght, 999);

            $yesshop_datas['blog-type'] = $_old_btype;
        }

        wp_reset_postdata();

        $classes = array('yeti-shortcode recent-post');
        if(!empty($atts['padding'])) $classes[] = esc_attr($atts['padding']);

        if(absint($atts['as_widget']) && !empty($atts['w_style'])) {
            $classes[] = $atts['w_style'];
        }

        return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';
    }

    public static function staticblock($atts)
    {
        if (!function_exists('Yetithemes_StaticBlock')) return '';
        $atts = shortcode_atts(array(
            "title" => '',
            "h_style" => '',
            "id" => '',
            "style" => '',
        ), $atts);

        ob_start();

        if (strcmp($atts['style'], 'grid') == 0) {
            Yetithemes_StaticBlock()->getImage($atts['id']);
        }

        echo '<div class="shortcode-content">';

        Yetithemes_StaticBlock()->getContentByID($atts['id']);

        echo '</div>';

        $class = (strcmp($atts['style'], 'grid') == 0) ? 'widget_boxed' : '';

        return self::beforeShortcode($atts, 'yesshop_' . __FUNCTION__, $class) . ob_get_clean() . self::afterShortcode();
    }

    public static function testimonials($atts)
    {
        $atts = shortcode_atts(array(
            "title" => '',
            "h_style" => '',
            "use_slider" => '',
            "ids" => '',
            'style' => '1',
            's_avata'   => '1'
        ), $atts);

        if (strlen(trim($atts['ids'])) == 0) return '';

        $yetithemes_testimonials = woothemes_get_testimonials(array('id' => $atts['ids'], 'limit' => 10, 'size' => '100x100'));

        ob_start();

        if (!empty($yetithemes_testimonials) && count($yetithemes_testimonials) > 0) {

            $atts['yetithemes_testimonials'] = $yetithemes_testimonials;

            YetiThemes_Extra()->get_shortcode_template('shortcode-testimonials.tpl.php', $atts);

        }
        //rewind_posts();
        wp_reset_postdata();

        return self::beforeShortcode($atts, 'yesshop_' . __FUNCTION__, 'testimonials-style-' . esc_attr($atts['style'])) . ob_get_clean() . self::afterShortcode();
    }

    public static function features($atts)
    {
        $atts = shortcode_atts(array(
            "title" => '',
            "h_style" => '',
            "id" => 0,
            "per_row" => 3,
            "limit" => 5,
            "size" => 150,
            "color" => '',
            "t_color" => '',
            "l_color" => '',
            "style" => '',
            "w_limit" => -1,
            "use_boxed" => '0',
            "learn_more" => 'false',
            "s_excerpt" => 'false',
            "l_text" => 'Learn more',
            "icon" => 'fa fa-long-arrow-right'
        ), $atts);

        if (strlen(trim($atts['id'])) == 0) return '';

        $yesshop_features = woothemes_get_features(array('id' => $atts['id'], 'limit' => $atts['limit'], 'size' => $atts['size']));

        ob_start();

        if (!empty($yesshop_features) && count($yesshop_features) > 0) {

            $atts['yesshop_features'] = $yesshop_features;

            YetiThemes_Extra()->get_shortcode_template('shortcode-features.tpl.php', $atts);

        }

        wp_reset_postdata();
        $class = 'widget widget_woothemes_features';
        return self::beforeShortcode($atts, 'yesshop_' . __FUNCTION__, $class) . ob_get_clean() . self::afterShortcode();
    }

    public static function teammember($atts)
    {
        $atts = shortcode_atts(array(
            'title'     => '',
            'h_style'   => '',
            'ids'       => '',
            'columns'   => 4,
            'style'     => '',
            'is_slider' => 'yes',
        ), $atts);

        if (strlen(trim($atts['ids'])) == 0) return '';
        $ids = array_map('trim', explode(',', $atts['ids']));

        if (!class_exists('Yetithemes_TeamMembers_Front')) return;

        $front = new Yetithemes_TeamMembers_Front;
        $teams = $front->getByIds($ids);

        ob_start();

        if ($teams->have_posts()) {

            $atts['teams'] = $teams;

            YetiThemes_Extra()->get_shortcode_template('team-members.tpl.php', $atts);

        }

        wp_reset_postdata();

        return self::beforeShortcode($atts, 'yesshop_' . __FUNCTION__) . ob_get_clean() . self::afterShortcode();
    }

    public static function pricing($atts, $content)
    {
        $atts = shortcode_atts(array(
            "title" => 'Basic',
            "price" => '$|10.99|mo',
            "desc" => '',
            "features" => '',
            "type" => '',
            "style" => '1',
            "bt_text" => 'Buy now',
            "bt_link" => '#',
        ), $atts);

        $atts['content'] = $content;

        $bt_link = self::convert_VC_link($atts['bt_link']);
        if (!isset($bt_link['title'])) $bt_link['title'] = esc_attr($atts['bt_text']);
        $bt_link['target'] = isset($bt_link['target']) && strlen($bt_link['target']) > 0 ? 'target="' . esc_attr($bt_link['target']) . '"' : '';
        if (!isset($bt_link['url']) || strlen($bt_link['url']) == 0) $bt_link['url'] = '#';
        $atts['bt_link'] = $bt_link;

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('pricing.tpl.php', $atts);

        return '<div class="yeti-shortcode yeti-' . __FUNCTION__ . '">' . ob_get_clean() . '</div>';
    }

    public static function action($atts)
    {
        $atts = shortcode_atts(array(
            "label" => 'Message here...',
            "bt_text" => 'Button text',
            "bt_link" => '#',
            "bt_icon" => '',
            "use_icon" => 0,
            "bg_color" => '#ededed',
            "bt_color" => '#5a9e74',
        ), $atts);

        $icon = '';
        if (absint($atts['use_icon'])) {
            $icon = strlen($atts['bt_icon']) > 0 ? '<i class="' . esc_attr($atts['bt_icon']) . '"></i>' : '';
        }

        $bt_link = self::convert_VC_link($atts['bt_link']);

        if (!isset($bt_link['title'])) $bt_link['title'] = esc_attr($atts['bt_text']);

        $bt_link['target'] =
            isset($bt_link['target']) && strlen($bt_link['target']) > 0 ?
                'target="' . esc_attr($bt_link['target']) . '"' : '';

        $bt_link['url'] = !isset($bt_link['url']) || strlen($bt_link['url']) == 0 ? '#' : urldecode($bt_link['url']);

        ob_start(); ?>

        <span class="yeti-label"><?php echo $atts['label'] ?></span>
        <a <?php echo $bt_link['target']; ?> title="<?php echo esc_attr(urldecode($bt_link['title'])); ?>"
                                             href="<?php echo esc_url($bt_link['url']); ?>"><?php echo esc_attr($atts['bt_text']); ?>
            &nbsp;&nbsp;<?php echo $icon; ?></a>
        <?php
        return '<div class="yeti-shortcode yeti-' . __FUNCTION__ . '">' . ob_get_clean() . '</div>';
    }

    public static function google_maps($atts, $content)
    {
        global $yesshop_datas;

        $atts = shortcode_atts(array(
            'title' => '',
            'address' => 'Quan 1, Ho Chi Minh, Viet Nam',
            'zoom' => '16',
            'height' => '450px',
            'style' => '',
            'mk_icon' => '',
            'css' => '',
            'm_color' => 'JTVCJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJhZG1pbmlzdHJhdGl2ZS5jb3VudHJ5JTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJsYWJlbHMlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9mZiUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIybGFuZHNjYXBlLm5hdHVyYWwubGFuZGNvdmVyJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyY29sb3IlMjIlM0ElMjAlMjIlMjNlYmU3ZDMlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlNUQlMEElMjAlMjAlMjAlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJmZWF0dXJlVHlwZSUyMiUzQSUyMCUyMmxhbmRzY2FwZS5tYW5fbWFkZSUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmVsZW1lbnRUeXBlJTIyJTNBJTIwJTIyYWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnZpc2liaWxpdHklMjIlM0ElMjAlMjJvZmYlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlNUQlMEElMjAlMjAlMjAlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJmZWF0dXJlVHlwZSUyMiUzQSUyMCUyMndhdGVyJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJnZW9tZXRyeS5maWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmNvbG9yJTIyJTNBJTIwJTIyJTIzODY5M2EzJTIyJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTVEJTBBJTIwJTIwJTIwJTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJyb2FkLmFydGVyaWFsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9mZiUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIycm9hZC5sb2NhbCUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmVsZW1lbnRUeXBlJTIyJTNBJTIwJTIyYWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnZpc2liaWxpdHklMjIlM0ElMjAlMjJvZmYlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJjb2xvciUyMiUzQSUyMCUyMiUyM2ViZTdkMyUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIyYWRtaW5pc3RyYXRpdmUubmVpZ2hib3Job29kJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9uJTIyJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTVEJTBBJTIwJTIwJTIwJTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJwb2klMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJlbGVtZW50VHlwZSUyMiUzQSUyMCUyMmFsbCUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnN0eWxlcnMlMjIlM0ElMjAlNUIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJ2aXNpYmlsaXR5JTIyJTNBJTIwJTIyb2ZmJTIyJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTVEJTBBJTIwJTIwJTIwJTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJ0cmFuc2l0JTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9mZiUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIycm9hZCUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmVsZW1lbnRUeXBlJTIyJTNBJTIwJTIyYWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnZpc2liaWxpdHklMjIlM0ElMjAlMjJvZmYlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlNUQlMEElMjAlMjAlMjAlMjAlN0QlMEElNUQ='
        ), $atts);

        ob_start();

        $atts['map_id'] = rand();
        $atts['content'] = $content;
        $atts['api'] = '';
        if (!empty($yesshop_datas['google-map-api'])) {
            $atts['api'] = esc_attr($yesshop_datas['google-map-api']);
        }

        YetiThemes_Extra()->get_shortcode_template('google-maps.tpl.php', $atts);

        return '<div class="yeti-shortcode yeti-' . __FUNCTION__ . '">' . ob_get_clean() . '</div>';
    }

    public static function convert_VC_link($link_str)
    {
        if (strlen(trim($link_str)) == 0) return '#';
        $link_rgs = array_map('trim', explode('|', $link_str));
        $return = array();
        foreach ($link_rgs as $var) {
            $vars = array_map('trim', explode(':', $var));
            if (isset($vars[1]) && strlen(trim($vars[1])) > 0) $return[$vars[0]] = urldecode($vars[1]);
        }
        return $return;
    }

    public static function buttons($atts)
    {

        $atts = shortcode_atts(array(
            'text' => 'Button text',
            'link' => '',
            'style' => '',
            'bgcl_style' => '',
            'bg_color' => '#cccccc',
            'border_color' => '#cccccc',
            'color' => '',
            'use_icon' => 0,
            'icon_fontawesome' => 'fa fa-adjust',
            'size' => '',
            'el_class' => ''
        ), $atts);

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('shortcode-button.tpl.php', $atts);

        return ob_get_clean();
    }

    public static function social_network($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'h_style' => '',
            'item' => '',
            'items' => '',
            'ic_size' => '',
            'tt_location' => 'top',
            'class' => '',
            'color_hover' => 0,
        ), $atts);

        if (empty($atts['item']) && empty($atts['items'])) return;

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('social.tpl.php', $atts);

        return self::beforeShortcode($atts, 'yesshop_' . __FUNCTION__) . ob_get_clean() . self::afterShortcode();
    }

    public static function beforeShortcode($atts, $__name, $__class = '')
    {
        $classes = array("yeti-shortcode {$__name}");
        if (strlen(trim($__class)) > 0) $classes[] = $__class;
        return '<div class="' . esc_attr(implode(' ', $classes)) . '">';
    }

    public static function afterShortcode()
    {
        return '</div>';
    }

    public static function instagram($atts)
    {
        $atts = shortcode_atts(array(
            'title'         => '',
            'h_style'       => '',
            'key'           => '',
            'limit'         => 6,
            'columns'       => 6,
            'is_slider'     => 0,
            'time'          => 2,
            'f_button'      => '',
            'link'          => '#',
            'padding'       => '15px',
            'image_size' => 'thumbnail', //thumbnail - low_resolution - standard_resolution
        ), $atts);

        if(strlen(trim($atts['padding'])) === 0 ) $atts['padding'] = '15px';

        $_padding = explode(' ', $atts['padding']);
        $atts['padding'] = $_padding[0];

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('instagram.tpl.php', $atts, $atts);

        $output = self::beforeShortcode($atts, 'yesshop_' . __FUNCTION__) . ob_get_clean() . self::afterShortcode();

        return $output;
    }

    public static function qrcode($atts)
    {
        $atts = shortcode_atts(array(
            "data" => '',
            "size" => '270x270',
            "charset-source" => '',
            "charset-target" => '',
            "ecc" => 'Q',
            "color" => '000',
            "bgcolor" => 'fff',
            "margin" => '0',
            "format" => 'png'
        ), $atts);

        $atts['color'] = str_replace('#', '', $atts['color']);
        $atts['bgcolor'] = str_replace('#', '', $atts['bgcolor']);

        if (empty($atts['data'])) {
            global $wp;
            $atts['data'] = home_url(add_query_arg(array(), $wp->request));
        }

        $atts = array_filter($atts, 'strlen');
        $atts = array_map('urlencode', $atts);

        $qr_src = add_query_arg($atts, 'http://api.qrserver.com/v1/create-qr-code/');

        list($width, $height) = explode('x', $atts['size']);

        ob_start();

        echo '<img src="' . esc_url($qr_src) . '" alt="QR-code for' . esc_attr($atts['data']) . '" width="' . absint($width) . '" height="' . absint($height) . '">';

        return ob_get_clean();
    }

    public static function store_location($atts)
    {
        $atts = shortcode_atts(array(
            "heading" => '',
            "h_style" => '',
            "stores" => '',
            "map_size" => '270x170',
            "columns" => 4,
        ), $atts);

        if (!empty($atts['stores'])) {
            $atts['stores'] = (array)vc_param_group_parse_atts($atts['stores']);
            foreach ($atts['stores'] as $k => $store) {
                $atts['stores'][$k]['link'] = self::convert_VC_link($store['link']);

                if (!empty($atts['stores'][$k]['infos'])) {
                    $atts['stores'][$k]['infos'] = (array)vc_param_group_parse_atts($store['infos']);
                }
            }

        }

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('shortcode-store-locations.tpl.php', $atts);

        return self::beforeShortcode($atts, 'yesshop_' . __FUNCTION__) . ob_get_clean() . self::afterShortcode();
    }

    public static function tag_cloud($atts)
    {
        $atts = shortcode_atts(array(
            'heading'   => '',
            'h_style'   => '',
            'mode_view' => 'def',
            'taxonomy'  => '',
            'sep'       => ',',
            'limit'     => '45',
            'css_class' => '',
        ), $atts);

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('shortcode-tag-cloud.tpl.php', $atts);

        return self::beforeShortcode($atts, 'yesshop_' . __FUNCTION__) . ob_get_clean() . self::afterShortcode();

    }

    public static function woo_single_project($atts)
    {
        $atts = shortcode_atts(array(
            "heading" => '',
            "h_style" => '',
            "limit" => '1'
        ), $atts);

        $args = array(
            'post_type' => 'project',
            'post_status' => 'publish',
            'posts_per_page' => $atts['limit'],
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $project = new WP_Query($args);

        ob_start();

        if ($project->have_posts()) {
            YetiThemes_Extra()->get_shortcode_template('shortcode-single-project.tpl.php', $atts, $project);
        }

        wp_reset_postdata();

        return self::beforeShortcode($atts, 'yesshop_' . __FUNCTION__) . ob_get_clean() . self::afterShortcode();
    }

    public static function heading($atts)
    {
        $atts = shortcode_atts(array(
            'text' => 'Custom heading',
            'style' => '',
            'align' => '',
            'heading' => 'h2',
            'sub-heading' =>'',
            'trans'     => '',
            'color'     => '',

        ), $atts);

        $_heading_class = 'heading-title';
        if (!empty($atts['style'])) $_heading_class .= ' ' . $atts['style'];
        if (!empty($atts['align'])) $_heading_class .= ' ' . $atts['align'];
        if (!empty($atts['trans'])) $_heading_class .= ' ' . $atts['trans'];
        if (!empty($atts['color'])) $_heading_class .= ' ' . $atts['color'];

        if (!empty($atts['sub-heading'])) $sub_heading = esc_html($atts['sub-heading']);
        else
            $sub_heading = '';

        $return_html  =  '<'.esc_attr($atts['heading']).' class="'.esc_attr($_heading_class).'">';
        if($atts['style']=='heading-style-5')
        {
            $return_html = $return_html.'<small class="sub-heading-title">'.$sub_heading.'</small>';
            $return_html =$return_html.'<span>'.esc_html($atts['text']).'</span>';
        }
        else
        {

            $return_html =$return_html.'<span>'.esc_html($atts['text']).'</span>';
            $return_html = $return_html.'<small class="sub-heading-title">'.$sub_heading.'</small>';
        }
        
        $return_html =$return_html.'</'.esc_attr($atts['heading']).'>';


        return $return_html;
    }

    public static function geticon($atts){
        $atts = shortcode_atts(array(
            'icon' => 'yeti-letter',
            'size'  => 1
        ), $atts);

        return '<i class="yeti-icon '.esc_attr($atts['icon']).' fa-'.absint($atts['size']).'x"></i>';
    }

    public static function currency_switcher( $atts ) {
        $atts = shortcode_atts(array(
            'currency' => 'USD|Dollar, GBP|British Pound, AUD|Aus Dollar',
            'popup'   => 'left',
            'request'   => 'currency'
        ), $atts);

        $_class = 'valign_middle yeti-mini-popup';
        if (!empty($atts['popup'])) $_class .= ' popup_' . esc_attr($atts['popup']);

        if (empty($atts['currency'])) return;

        $args = array_map('trim', explode(',', $atts['currency']));
        $_request_k = esc_attr($atts['request']);

        $_current = !empty($_REQUEST[$_request_k])? esc_attr($_REQUEST[$_request_k]): '';

        $_li_html = '';
        $_c_li_html = '';
        foreach ($args as $k => $currency) {
            if (empty($currency)) continue;

            $currency = array_map('trim', explode('|', $currency));

            if ($k === 0 && empty($_current)) $_current = $currency[0];

            $_var = $currency[0];
            if (!empty($currency[1])) $_var .= ' - ' . $currency[1];

            $_url = add_query_arg(array(
                'currency'  => esc_attr($currency[0])
            ));
            $_li_html .= '<li><a href="'.esc_url($_url).'">'.esc_html($_var).'</a></li>';
        }

        ob_start();

        ?>

        <div class="<?php echo esc_attr($_class)?>">
            <div class="yeti-mini-popup my-account">
                <div class="mini-popup-hover nth-login-hover">
                    <a href="#"><?php echo esc_attr($_current); ?> <span class="caret"></span></a>
                </div>

                <div class="yeti-mini-popup-cotent yeti-mini-login-content">
                    <ul class="list-unstyled">
                        <?php  echo wp_kses_post($_li_html); ?>
                    </ul>
                </div>
            </div>

        </div>

        <?php


        return ob_get_clean();
    }

    public static function multi_language( $atts ) {
        $atts = shortcode_atts(array(
            'languages' => 'us|en_US|English, fr|fr_FR|French, it|it_IT|Italian',
            'popup'   => 'left',
            'request'   => 'lang'
        ), $atts);

        $_class = 'valign_middle yeti-mini-popup';
        if (strlen($atts['popup']) > 0) $_class .= ' popup_' . esc_attr($atts['popup']);

        if (empty($atts['languages'])) return;

        $args = array_map('trim', explode(',', $atts['languages']));
        $_request_k = esc_attr($atts['request']);

        $_current = !empty($_REQUEST[$_request_k])? esc_attr($_REQUEST[$_request_k]): '';

        $_li_html = '';
        $_c_li_html = '';
        foreach ($args as $k => $item) {
            if (empty($item)) continue;

            $item = array_map('trim', explode('|', $item));

            $_flag = '//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.8.0/flags/4x3/'.$item[0].'.svg';
            $_flag_img = '<img width="16" height="11" src="'.esc_url($_flag).'" alt="'.esc_attr($item[2]).'" title="'.esc_attr($item[2]).'"> &nbsp;';

            if ($k === 0 && empty($_current))  {
                $_current = $_flag_img.'<span class="yt-label">'.$item[2].'</span>';
            } elseif($item[1] === $_current) {
                $_current = $_flag_img.'<span class="yt-label">'.$item[2].'</span>';
            }

            $_var = $_flag_img;
            if (!empty($item[1])) $_var .= $item[2];

            $_url = add_query_arg(array(
                'lang'  => esc_attr($item[1])
            ));

            $_li_html .= '<li><a href="'.esc_url($_url).'">'.wp_kses_post($_var).'</a></li>';
        }

        ob_start();

        ?>

        <div class="<?php echo esc_attr($_class)?>">
            <div class="yeti-mini-popup my-account yt-language">
                <div class="mini-popup-hover nth-login-hover">
                    <a href="#"><?php echo wp_kses_post($_current); ?> <span class="caret"></span></a>
                </div>

                <div class="yeti-mini-popup-cotent yeti-mini-login-content">
                    <ul class="list-unstyled">
                        <?php  echo wp_kses_post($_li_html); ?>
                    </ul>
                </div>
            </div>

        </div>

        <?php


        return ob_get_clean();
    }

    public static function yeti_galleries( $atts ){
        $atts = shortcode_atts(array(
            'is_slider' => 1,
            'columns'   => 4
        ), $atts);

        ob_start(); ?>
        <div class="yeti-galleries-wrap">
            <div class="galleries-filters-wrap container">
                <?php Yetithemes_Gallery()->getFilters(); ?>
            </div>

            <div class="galleries-content">
                <?php Yetithemes_Gallery()->getContent($atts); ?>
            </div>

        </div>
        <?php
        return ob_get_clean();
    }

    public static function yeti_empty_space( $atts )
    {
        $atts = shortcode_atts(
                array(
                    'height' => '30px',
                    'id' => '',
                    'class' => '',
                ),
                $atts
        );

        ob_start(); ?>
        <div class="yeti-empty-space-only-desktop <?php echo esc_attr($atts['class']); ?>" id="<?php echo esc_attr($atts['id']); ?>" style="height: <?php echo esc_attr( $atts['height'] ); ?>">
            <span class="yeti-empty-space-inner"></span>
        </div>
        <?php
        return ob_get_clean();
    }
}

new Yetithemes_Shortcodes();