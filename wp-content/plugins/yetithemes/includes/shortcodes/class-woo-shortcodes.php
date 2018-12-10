<?php
// ! File Security Check
if (!defined('ABSPATH')) exit;

class Yetithemes_Woo_Shortcodes
{

    private static $classes = array('woocommerce');

    public function __construct()
    {
        add_action('init', array($this, 'init'));

        add_action('wp_ajax_yeti_woo_get_product_by_cat', array(__CLASS__, 'woo_get_product_by_cat'));
        add_action('wp_ajax_nopriv_yeti_woo_get_product_by_cat', array(__CLASS__, 'woo_get_product_by_cat'));
    }

    public function init()
    {
        $shortcodes = array(
            'yesshop_top_rated_products'       => __CLASS__ . '::top_rated_products',
            'yesshop_best_selling_products'    => __CLASS__ . '::best_selling_products',
            'yesshop_recent_products'          => __CLASS__ . '::recent_products',
            'yesshop_sale_products'            => __CLASS__ . '::sale_products',
            'yesshop_featured_products'        => __CLASS__ . '::featured_products',
            'yesshop_products_category'        => __CLASS__ . '::products_category',
            'yesshop_products_category_sect'   => __CLASS__ . '::products_category_sect',
            'yesshop_products_cats_tabs'       => __CLASS__ . '::products_categories_tabs',
            'yesshop_products'                 => __CLASS__ . '::products',
            'yesshop_product_tags'             => __CLASS__ . '::product_tags',
            'yesshop_product_categories'       => __CLASS__ . '::product_categories',
            'yesshop_product_category_icon'    => __CLASS__ . '::product_cat_icon',
            'yesshop_product_subcaterories'    => __CLASS__ . '::product_subcaterories',
            'yesshop_featured_prod_cats'       => __CLASS__ . '::featured_prod_cats',
            'yesshop_woo_single_cat'           => __CLASS__ . '::woo_single_cat',
            'yesshop_woo_recently_viewed'      => __CLASS__ . '::woocommerce_recently_viewed',
            'yesshop_woo_attributes'           => __CLASS__ . '::woo_attributes',
            'yesshop_woo_cats'                 => __CLASS__ . '::woo_categories',
            'yesshop_trending_section_products'     => __CLASS__ . '::trending_section_products',
            'yesshop_compare_page'             => __CLASS__ . '::woo_compare_page',
            'yesshop_wishlist_link'            => __CLASS__ . '::woo_wishlist_link',
            'yesshop_compare_link'             => __CLASS__ . '::woo_compare_link',
        );

        foreach ($shortcodes as $shortcode => $function) {
            add_shortcode($shortcode, $function);

        }

        add_action('wp_ajax_yeti_woo_loadmore', array($this, 'woo_loadmore'));
        add_action('wp_ajax_nopriv_yeti_woo_loadmore', array($this, 'woo_loadmore'));
    }

    public function woo_loadmore(){
        $atts = $_REQUEST;
        $function = $atts['function'];
        unset($atts['function']);
        unset($atts['action']);
        if(isset($atts['content'])) {
            echo self::$function($atts, $atts['content']);
        } else {
            echo self::$function($atts);
        }
        wp_die();
    }

    private static function product_query($query_args, $atts, $function){
        global $woocommerce_loop;

        $loop_name = 'yeti_' . $function;

        if (isset($atts['as_widget']) && absint($atts['as_widget'])) {
            if (!absint($atts['show_hidden'])) {
                $query_args['meta_query'][] = WC()->query->visibility_meta_query();
                $query_args['post_parent'] = 0;
            }

            if (absint($atts['hide_free'])) {
                $query_args['meta_query'][] = array(
                    'key' => '_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'DECIMAL',
                );
            }
        } else {
            if (!empty($atts['is_deal']) && absint($atts['is_deal'])) {
                $fil_date = strtotime("now");
                $query_args['meta_query'] = array(
                    array(
                        'key' => '_sale_price_dates_from',
                        'value' => $fil_date,
                        'compare' => '<=',
                        'type' => 'numeric'
                    ),
                    array(
                        'key' => '_sale_price_dates_to',
                        'value' => $fil_date,
                        'compare' => '>=',
                        'type' => 'numeric'
                    )
                );
            }

        }

        if (!empty($atts['category'])) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'terms' => array_map('sanitize_title', explode(',', $atts['category'])),
                    'field' => 'slug',
                    'operator' => empty($atts['operator']) ? 'IN' : $atts['operator']
                )
            );
        }

        if ($loop_name === 'yeti_top_rated_products') {
            add_filter('posts_clauses', array(__CLASS__, 'order_by_rating_post_clauses'));
        }
        $products = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $query_args, $atts, $loop_name));
        if ($loop_name === 'yeti_top_rated_products') {
            remove_filter('posts_clauses', array(__CLASS__, 'order_by_rating_post_clauses'));
        }

        $columns = isset($atts['columns'])? absint($atts['columns']): 1;
        $woocommerce_loop['columns'] = $columns;
        $woocommerce_loop['name'] = $loop_name;

        return $products;
    }

    private static function product_loop($query_args, $atts, $function)
    {
        global $woocommerce_loop;

        $loop_name = 'yeti_' . $function;

        if (absint($atts['as_widget'])) {
            if (!absint($atts['show_hidden'])) {
                $query_args['meta_query'] = array();
                $query_args['post_parent'] = 0;
            }

            if (absint($atts['hide_free'])) {
                $query_args['meta_query'][] = array(
                    'key' => '_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'DECIMAL',
                );
            }
        } else {
            if (!empty($atts['is_deal']) && absint($atts['is_deal'])) {
                $fil_date = strtotime("now");
                $query_args['meta_query'] = array(
                    array(
                        'key' => '_sale_price_dates_from',
                        'value' => $fil_date,
                        'compare' => '<=',
                        'type' => 'numeric'
                    ),
                    array(
                        'key' => '_sale_price_dates_to',
                        'value' => $fil_date,
                        'compare' => '>=',
                        'type' => 'numeric'
                    )
                );
            }
            $atts['num_order'] = '0';
        }

        if (!empty($atts['category'])) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'terms' => array_map('sanitize_title', explode(',', $atts['category'])),
                'field' => 'slug',
                'operator' => empty($atts['operator']) ? 'IN' : $atts['operator']
            );
        }

        if ($loop_name === 'yeti_top_rated_products') {
            add_filter('posts_clauses', array(__CLASS__, 'order_by_rating_post_clauses'));
        }
        $products = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $query_args, $atts, $loop_name));
        if ($loop_name === 'yeti_top_rated_products') {
            remove_filter('posts_clauses', array(__CLASS__, 'order_by_rating_post_clauses'));
        }

        $columns = absint($atts['columns']);
        $woocommerce_loop['columns'] = $columns;
        $woocommerce_loop['name'] = $loop_name;

        if(!isset($atts['excerpt_limit'])) $atts['excerpt_limit'] = 30;

        ob_start();

        if ($products->have_posts()) {
            if (absint($atts['as_widget']))
                YetiThemes_Extra()->get_shortcode_template('shortcode-woo-widget.tpl.php', $atts, $products);
            else {
                if ($atts['is_biggest'] !== '0') YetiThemes_Extra()->get_shortcode_template('shortcode-woo-big.tpl.php', $atts, $products);
                else {
                    set_query_var('yeti_excerpt_limit', $atts['excerpt_limit']);

                        YetiThemes_Extra()->get_shortcode_template('shortcode-woo-nomal.tpl.php', $atts, $products);
                }

                if(isset($atts['load_more']) && absint($atts['load_more'])) {
                    $atts['per_page'] = !empty($atts['step'])? absint($atts['step']): 5;
                    $_offset = isset($products->query_vars['offset'])? absint($products->query_vars['offset']): 0;
                    $atts['offset'] = absint($products->post_count) + absint($_offset);
                    $atts['action'] = 'yeti_woo_loadmore';
                    $atts['context'] = 'frontend';
                    $atts['function'] = esc_attr($function);
                    $atts['btn_load_more_text'] = (isset($atts['btn_load_more_text']) && !empty($atts['btn_load_more_text'])) ? esc_attr( $atts['btn_load_more_text'] ) : esc_attr__('Load more', 'yetithemes');
                    echo '<div class="woo-footer text-center">';
                    printf('<a href="#" class="button yeti-woo-load-more" data-atts="%s">%s</a>', esc_attr(wp_json_encode($atts)), $atts['btn_load_more_text'] );
                    echo '</div>';
                }
            }
        } else {
            do_action("woocommerce_shortcode_{$loop_name}_loop_no_results");
        }

        woocommerce_reset_loop();
        wp_reset_postdata();

        return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
    }

    public static function products($atts)
    {

        $atts = shortcode_atts(array(
            'title' => '',
            'item_style' => 'grid',
            'as_widget' => '0',
            'widget_style' => '',
            'head_style' => '',
            'is_slider' => '1',
            'is_biggest' => '0',
            'product_mode' => 'grid',
            'rows' => '1',
            'auto_play' => '0',
            'columns' => '4',
            'orderby' => 'title',
            'order' => 'asc',
            'ids' => '',
            'skus' => '',
            'load_more' => 0,
            'step' => 4,
            'offset'    => 0,
            'btn_load_more_text' => ''
        ), $atts);

        $query_args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
            'posts_per_page' => -1,
            'meta_query' => WC()->query->get_meta_query()
        );

        if (!empty($atts['skus'])) {
            $query_args['meta_query'][] = array(
                'key' => '_sku',
                'value' => array_map('trim', explode(',', $atts['skus'])),
                'compare' => 'IN'
            );
            $query_args['meta_query'] = array_merge($query_args['meta_query'], WC()->query->stock_status_meta_query());
        }

        if (!empty($atts['ids'])) {
            $query_args['post__in'] = array_map('trim', explode(',', $atts['ids']));
            $query_args['meta_query'] = array_merge($query_args['meta_query'], WC()->query->stock_status_meta_query());
        }

        return self::product_loop($query_args, $atts, __FUNCTION__);
    }

    private static $attr_def = array(
        'title' => '',
        'item_style' => 'grid',
        'as_widget' => '0',
        'widget_style' => '',
        'num_order'     => '0',
        'head_style' => '',
        'is_slider' => '1',
        'category' => '',
        'is_biggest' => '0',
        'bigprod_width' => '',
        'product_mode' => 'grid',
        'excerpt_limit'  => 15,
        'rows' => '1',
        'auto_play' => '0',
        'bg_img_id' => '0',
        'b_class'   => 'col-sm-12',
        'load_more' => 0,
        'step' => 4,
        'per_page' => '12',
        'columns' => '4',
        'orderby' => 'date',
        'order' => 'desc',
        'hide_free' => 0,
        'show_hidden' => 0,
        'offset'    => 0,
        'btn_load_more_text' => ''
    );

    public static function sale_products($atts, $content)
    {
        $_def = self::$attr_def;
        $_def['is_deal'] = 0;
        $_def['supper_style'] = '1';

        $atts = shortcode_atts($_def, $atts);

        $query_args = array(
            'posts_per_page'    => $atts['per_page'],
            'offset'            => $atts['offset'],
            'orderby'           => $atts['orderby'],
            'order'             => $atts['order'],
            'no_found_rows'     => 1,
            'post_status'       => 'publish',
            'post_type'         => 'product',
            'meta_query'        => WC()->query->get_meta_query(),
            'tax_query'         => WC()->query->get_tax_query(),
            'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() ),
        );

        $atts['content'] = strlen(trim($content)) > 0 ? $content : '';

        global $yesshop_datas;

        if(!empty($yesshop_datas['product-item-style']) && $yesshop_datas['product-item-style'] === 'shadow_s1') $atts['supper_style'] = 2;

        if (absint($atts['is_deal'])) {
            if (class_exists('Yesshop_CountDown')) {
                remove_action('woocommerce_before_shop_loop_item_title', array('Yesshop_CountDown', 'countdown_render'), 90);
            }
            add_action('woocommerce_shop_loop_item_title', 'yesshop_sale_stock_progress', 6);
        }

        $output = self::product_loop($query_args, $atts, __FUNCTION__);

        if (absint($atts['is_deal'])) {
            if (class_exists('Yesshop_CountDown')) {
                add_action('woocommerce_before_shop_loop_item_title', array('Yesshop_CountDown', 'countdown_render'), 90);
            }
            remove_action('woocommerce_shop_loop_item_title', 'yesshop_sale_stock_progress', 6);
        }

        return $output;
    }

    public static function recent_products($atts, $content)
    {
        $atts = shortcode_atts( self::$attr_def , $atts);

        $query_args = array(
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'no_found_rows'     => 1,
            'posts_per_page'    => $atts['per_page'],
            'orderby'           => $atts['orderby'],
            'order'             => $atts['order'],
            'offset'            => $atts['offset'],
            'meta_query'        => WC()->query->get_meta_query(),
            'tax_query'         => WC()->query->get_tax_query(),
        );

        $atts['content'] = strlen(trim($content)) > 0 ? $content : '';

        return self::product_loop($query_args, $atts, __FUNCTION__);
    }

    public static function best_selling_products($atts, $content)
    {
        $atts = shortcode_atts(self::$attr_def, $atts);

        $query_args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $atts['per_page'],
            'offset'                => $atts['offset'],
            'meta_key'              => 'total_sales',
            'orderby'               => 'meta_value_num',
            'meta_query'            => WC()->query->get_meta_query(),
            'tax_query'             => WC()->query->get_tax_query(),
        );

        $atts['content'] = strlen(trim($content)) > 0 ? $content : '';

        return self::product_loop($query_args, $atts, __FUNCTION__);
    }

    public static function featured_products($atts, $content)
    {
        $atts = shortcode_atts(self::$attr_def, $atts);

        $_meta_query = WC()->query->get_meta_query();
        $_tax_query = WC()->query->get_tax_query();
        $_tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
            'operator' => 'IN',
        );

        $query_args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $atts['per_page'],
            'orderby'               => $atts['orderby'],
            'order'                 => $atts['order'],
            'offset'                => $atts['offset'],
            'meta_query'            => $_meta_query,
            'tax_query'             => $_tax_query
        );

        $atts['content'] = strlen(trim($content)) > 0 ? $content : '';

        return self::product_loop($query_args, $atts, __FUNCTION__);
    }

    public static function top_rated_products($atts) {
        $atts = shortcode_atts( self::$attr_def , $atts);

        $query_args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'orderby'               => $atts['orderby'],
            'order'                 => $atts['order'],
            'posts_per_page'        => $atts['per_page'],
            'offset'                => $atts['offset'],
            'meta_query'            => WC()->query->get_meta_query(),
            'tax_query'             => WC()->query->get_tax_query(),
        );

        return self::product_loop($query_args, $atts, __FUNCTION__);
    }

    public static function products_category($atts)
    {
        $atts = shortcode_atts(array(
            "title" => '',
            "item_style" => 'grid',
            "as_widget" => '0',
            'widget_style' => '',
            "head_style" => '',
            "per_page" => '12',
            "is_slider" => '1',
            "is_biggest" => '0',
            'bigprod_width' => '',
            'product_mode' => 'grid',
            'rows' => '1',
            'auto_play' => '0',
            'columns' => '4',
            'orderby' => 'date',
            'order' => 'desc',
            'category' => '',
            'hide_free' => 0,
            'show_hidden' => 0,
            'load_more' => 0,
            'step' => 4,
            'offset'    => 0,
            'btn_load_more_text' => '',
            'num_order' => 0
        ), $atts);

        $ordering_args = WC()->query->get_catalog_ordering_args($atts['orderby'], $atts['order']);
        $meta_query = WC()->query->get_meta_query();

        $query_args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby' => $ordering_args['orderby'],
            'order' => $ordering_args['order'],
            'posts_per_page' => $atts['per_page'],
            'offset' => $atts['offset'],
            'meta_query' => $meta_query,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'terms' => array_map('sanitize_title', explode(',', $atts['category'])),
                    'field' => 'slug',
                    'operator' => 'IN'
                )
            )
        );

        if (isset($ordering_args['meta_key'])) {
            $query_args['meta_key'] = $ordering_args['meta_key'];
        }

        return self::product_loop($query_args, $atts, __FUNCTION__);
    }

    public static function products_category_sect($atts, $content)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'category' => '',
            'banner_bg' => '',
            'h_bg' => '#f00000',
            'per_page_v' => '5',
            'cat_limit' => '',
            'per_page' => '12',
            'columns' => '5',
            'orderby' => 'rand',
            'order' => 'ASC',
            'per_page' => '12',
            'h_color' => 'dark-color',
            'style' => 'big_section',
            'new_t_title' => 'New items',
            'top_rated_t_title' => 'Top rated items',
            'sale_t_title' => 'Sale-off items',
            'prod_tabs'     => 1
        ), $atts);

        $atts['_shortcode_id'] = 'woo_' . __FUNCTION__ . '-' . mt_rand();

        $atts['content'] = !empty($content) ? $content : null;

        ob_start();

        YetiThemes_Extra()->get_shortcode_template('shortcode-product-category-sect.tpl.php', $atts);

        return ob_get_clean();
    }

    public static function product_tags($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'tags' => '',
            't_color' => '#333333'
        ), $atts);

        if (strlen(trim($atts['tags'])) == 0) return;

        $tags = explode(',', $atts['tags']);

        ob_start();

        ?>
        <div class="yeti-product-taxs-wrapper yeti-product-categories-wrapper">
            <?php if (strlen($atts['title']) > 0): ?>
                <span style="color: <?php echo esc_attr($atts['t_color']); ?>"><?php echo esc_attr($atts['title']); ?></span>:
            <?php endif; ?>

            <?php foreach ($tags as $tag): ?>

                <?php if ($term_tag = get_term_by('slug', $tag, "product_tag")): ?>

                    <a href="<?php echo esc_url(get_term_link($term_tag->term_id, "product_tag")); ?>"><?php echo esc_attr($term_tag->name); ?></a>

                <?php endif; ?>

            <?php endforeach; ?>

        </div><!-- .yeti-product-categories-wrapper -->

        <?php

        return ob_get_clean();
    }

    public static function product_categories($atts) {
        $atts = shortcode_atts(array(
            'title' => '',
        ), $atts);

        $args = array(
            'before_widget' => '<div class="widget %s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-heading"><h3 class="widget-title heading-title">',
            'after_title' => '</h3></div>'
        );
        ob_start();
        the_widget('Yesshop_ProductCategories_Widget', $atts, $args);
        return ob_get_clean();
    }

    public static function product_cat_icon($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'cats' => '',
            'show_department' => 1,
            'show_all' => 0,
            'columns' => 4,
            'h_style' => '',
            'style'     => '',
            'show_link' => 0
        ), $atts);

        if (strlen(trim($atts['cats'])) == 0) return;

        $_cat_args = vc_param_group_parse_atts($atts['cats']);

        if (empty($_cat_args)) return;

        ob_start();

        if (!empty($atts['title'])) {

            echo '<div class="yeti-shortcode-header">';
            echo '<h3 class="heading-title ' . esc_attr($atts['h_style']) . '">' . esc_html($atts['title']) . '</h3>';
            echo '</div>';
        }

        $_li_class = array('cat-item');
        YetiThemes_Extra()->get_responseClass($_li_class, $atts['columns']);

        $_ul_class = 'product-category-icon list-inline list-nostyle';
        if(!empty($atts['style'])) {
            $_ul_class .= ' ' . $atts['style'];
        } else {
            $_ul_class .= ' no-padding';
        }

        echo '<ul class="'.esc_attr($_ul_class).'">';
        foreach ($_cat_args as $cat) {
            if(empty($cat['cat'])) continue;
            $category = get_term_by('slug', $cat['cat'], 'product_cat');
            if (empty($category)) continue;

            if(absint($atts['show_all'])) {
                $html = '%3$s<div class="cat-meta"><span class="cat-title">%2$s</span><a href="%1$s" title="%2$s">'.esc_html('See All', 'yetithemes').'</a></div>';
            } else {
                $html = '<a href="%1$s" title="%2$s">%3$s<span class="cat-title">%2$s</span></a>';
            }
            ?>
            <li class="<?php echo esc_attr(implode(' ', $_li_class)) ?>">
                <?php printf($html, esc_url(get_term_link($category)), esc_attr($category->name), wp_get_attachment_image($cat['icon'], 'full'))?>
            </li>
            <?php
        }

        if (absint($atts['show_department']) > 0) {
            echo '<li class="' . esc_attr(implode(' ', $_li_class)) . '">' .
                '<a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">' .
                esc_html__('All department', 'yetithemes') . ' <i class="fa fa-angle-right" aria-hidden="true"></i>' .
                '</a></li>';
        }

        echo '</ul>';

        $classes = self::pareShortcodeClass('columns-' . absint($atts['columns']));

        return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';
    }

    public static function products_categories_tabs($atts)
    {
        $atts = shortcode_atts(array(
            'h_is_img' => '0',
            'h_img' => '0',
            'title' => '',
            'h_style' => '',
            'tabs_style' => '',
            'prod_filter' => '',
            'item_style' => 'grid',
            'as_widget' => '0',
            'widget_style' => '',
            'head_style' => '',
            'per_page' => '12',
            'columns' => '4',
            'orderby' => 'date',
            'order' => 'desc',
            'category' => '',
            'use_ajax' => '1'
        ), $atts);

        if (!$atts['category']) return '';

        ob_start();

        $category = explode(',', $atts['category']);

        if (count($category) > 0):

            $tab_rand = 'tab_item_' . mt_rand();
            $tab_rand2 = 'tab_' . mt_rand(); ?>

            <div class="yeti_products_categories_shortcode <?php echo esc_attr($atts['tabs_style']) ?>"
                 data-atts="<?php echo esc_attr(json_encode($atts)); ?>" id="<?php echo esc_attr($tab_rand2); ?>">

                <div class="yeti-shortcode-header clearfix">
                    <?php if (strlen($atts['title']) > 0):
                        $heading_class = array('heading-title');
                        if (strlen($atts['h_style']) > 0) $heading_class[] = esc_attr($atts['h_style']);
                        ?>
                        <h3 class="<?php echo esc_attr(implode(' ', $heading_class)) ?>"><?php echo esc_attr($atts['title']); ?></h3>
                    <?php elseif (absint($atts['h_img']) > 0) :
                        echo wp_get_attachment_image(absint($atts['h_img']), 'full');
                    endif; ?>
                </div>

                <div class="yeti-shortcode-content">
                    <?php self::get_product_by_cat_tabs($atts, $tab_rand); ?>
                    <div class="tab-content-item show ajax-content"
                         id="<?php echo esc_attr($tab_rand) . '_ajax_content' ?>">
                        <?php echo self::get_product_by_cat_content($atts, $atts['category']); ?>
                    </div>
                </div>

            </div>

            <?php
            $classes = self::pareShortcodeClass('columns-' . absint($atts['columns']));

            return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>'; ?>

        <?php endif;
    }

    public static function product_subcaterories($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'h_style' => '',
            'ex_thumb'  => 0,
            'style' => 'style-2 list',
            'cat_group' => '',
            'slugs' => '',
            'orderby' => 'date',
            'order' => 'desc',
            'columns' => 3,
            'is_slider' => 0,
            'per_page' => 3,
            'list_2_col'  => 0,
            's_cat_title'   => 1,
            's_total_items' => 1,
            's_sub_cat' => 1,
        ), $atts);

        if (strlen($atts['cat_group']) === 0 && strlen($atts['slugs']) === 0) return '';

        $styles = explode(' ', $atts['style']);
        if (strlen($atts['slugs']) > 0) {
            $cats_ops = strlen($atts['slugs']) !== 0 ? explode(',', $atts['slugs']) : array();
        } else {
            $cats_ops = vc_param_group_parse_atts($atts['cat_group']);
        }

        $options = array(
            'items' => $atts['columns']
        );
        $options = YetiThemes_Extra()->get_owlResponsive($options);

        ob_start();

        if (strlen($atts['title']) > 0) {
            $head_class = array('heading-title');
            if (strlen($atts['h_style']) > 0) $head_class[] = esc_attr($atts['h_style']);
            echo '<div class="yeti-shortcode-header"><h3 class="' . esc_attr(implode(' ', $head_class)) . '">' . esc_attr($atts['title']) . '</h3></div>';
        }

        echo '<div class="yeti-shortcode-content">';

        if (absint($atts['is_slider']) == 1) {
            echo '<div class="yeti-owlCarousel yeti-loading light" data-options="' . esc_attr(json_encode($options)) . '" data-base="1">';
            YetiThemes_Extra()->get_yetiLoadingIcon();
            echo '<div class="yeti-owl-slider">';
        }
        $atts['i'] = 0;
        $total_items = 0;
        if(!empty($cats_ops)):
            foreach ($cats_ops as $ops) {
                $term = get_term_by("slug", $ops['slug'], "product_cat");
                if($term):
                    $total_items += $term->count;
                    if($atts['s_sub_cat']==1) {
                        $product_categories = get_categories(apply_filters('woocommerce_product_subcategories_args', array(
                            'parent' => $term->term_id,
                            'menu_order' => 'ASC',
                            'hide_empty' => 0,
                            'hierarchical' => 1,
                            'taxonomy' => 'product_cat',
                            'pad_counts' => 1,
                            'number' => 3
                        )));
                        foreach ($product_categories as $category) :
                            $total_items += $category->category_count;
                        endforeach;
                    }
                endif;
            }
            $desc = '<p class="description">' . $total_items. _n(" item", " items", $total_items) . '</p>';
            if($atts['s_total_items']==1) echo $desc;
            foreach ($cats_ops as $ops) {

                $atts['ops'] = $ops;
                if (in_array('list', $styles)) {
                    YetiThemes_Extra()->get_shortcode_template('shortcode-product-subcaterories2.tpl.php', $atts);
                } else {
                    YetiThemes_Extra()->get_shortcode_template('shortcode-product-subcaterories.tpl.php', $atts);
                }
                $atts['i']++;
            }

            if (absint($atts['is_slider']) == 1) echo '</div></div>';

            echo '</div>';
        endif;
        $classes = self::pareShortcodeClass(__FUNCTION__);

        return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';
    }

    public static function featured_prod_cats($atts)
    {
        global $woocommerce_loop;
        $atts = shortcode_atts(array(
            'title' => '',
            'h_style' => '',
            'slugs' => '',
            'cats_group'    => '',
            'columns' => 4,
            'style' => 'default',
            'is_slider' => 1,
            'hide_empty' => 1,
            'cat_fills' => '',
            'css'   => '',
        ), $atts);

        $slugs = array();

        $atts['cats_group'] = vc_param_group_parse_atts($atts['cats_group']);
        if(!empty($atts['cats_group'])) {
            foreach ($atts['cats_group'] as $item) {
                if (!array_key_exists('slug', $item)){
                    $item['slug'] = '';
                }
                $slugs[] = $item['slug'];
            }
        }

        $old_columns = $woocommerce_loop['columns'];

        foreach ($slugs as $k => $slug) {
            $_term = get_term_by('slug', $slug, 'product_cat');
            if($_term) $atts['cats_group'][$k]['term'] = $_term;
        }

        ob_start();

        if ($atts['cats_group']) :

            if (strlen($atts['title']) > 0) {
                $heading_class = array('heading-title');
                if (strlen($atts['h_style']) > 0) $heading_class[] = esc_attr($atts['h_style']);
                echo '<div class="yeti-shortcode-header"><h3 class="' . esc_attr(implode(' ', $heading_class)) . '">' . esc_attr($atts['title']) . '</h3></div>';
            }

            // echo 'Hugo'.$atts['is_slider'];
            // print_r($atts);

            if($atts['is_slider'] == 2)
                YetiThemes_Extra()->get_shortcode_template('shortcode-woo-cats-masonry.tpl.php', $atts);
            else
                YetiThemes_Extra()->get_shortcode_template('shortcode-woo-cats.tpl.php', $atts);

        endif;

        wp_reset_postdata();

        $woocommerce_loop['columns'] = $old_columns;

        $classes = self::pareShortcodeClass('columns-' . absint($atts['columns']));
        if (strlen($atts['style']) > 0) $classes[] = esc_attr($atts['style']);

        return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';
    }

    public static function woo_single_cat($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'style' => '1',
            'slug' => '',
            'hide_empty' => 0
        ), $atts);

        // get terms and workaround WP bug with parents/pad counts
        if (strlen($atts['slug']) == 0) return;

        $product_cat = get_term_by('slug', $atts['slug'], 'product_cat');

        if (empty($product_cat)) {
            return;
        }

        ob_start();

        echo '<div class="woo-single-cat-inner">';

        echo '<h3 class="text-uppercase">' . esc_html($product_cat->name) . '</h3>';

        echo '<p class="cat-count">' . sprintf(_n('%s Item', '%s Items', absint($product_cat->count), 'yetithemes'), absint($product_cat->count)) . '</p>';

        echo '<a href="' . esc_url(get_term_link($product_cat)) . '" title="' . __('shop now') . '" class="button medium outline">' . __('shop now') . '</a>';

        echo '</div>';

        $classes = self::pareShortcodeClass();

        $classes[] = "woo-single-cat style-{$atts['style']}";

        return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';
    }

    public static function get_product_by_cat_tabs($atts, $tab_rand)
    {
        $_tabs_li = '';
        $i = 0;
        $_ul_class = array('shortcode-woo-tabs', 'clearfix', 'hidden-xs');

        $category = explode(',', $atts['category']);
        $_tabs_li .= '<li class="tab-item-ajax active">';
        $_tabs_li .= '<a title="' . esc_attr__('All product', 'yetithemes') . '" href="javascript:void(0);" data-id="' . esc_attr($tab_rand . '_all') . '" data-slug="' . esc_attr($atts['category']) . '">';
        $_tabs_li .= esc_attr__('All', 'yetithemes') . '</a>';
        $_tabs_li .= "</li>";
        foreach ($category as $slug) {
            $term = get_term_by("slug", $slug, "product_cat");
            if ($term) {
                $_class = array('tab-item-ajax');
                $_tabs_li .= '<li class="' . esc_attr(implode(' ', $_class)) . '">';
                $_tabs_li .= '<a title="' . $term->name . '" href="javascript:void(0);" data-id="' . esc_attr($tab_rand . '_' . $term->term_id) . '" data-slug="' . esc_attr($term->slug) . '">';
                $_tabs_li .= esc_attr($term->name);
                $_tabs_li .= '</a>';
                $_tabs_li .= "</li>";
                $i++;
            }
        }
        ?>

        <ul class="<?php echo esc_attr(implode(' ', $_ul_class)); ?>">
            <?php echo $_tabs_li; ?>
        </ul>
        <?php
    }

    public static function get_product_by_cat_content($atts, $slug, $slide_id = '')
    {
        $ordering_args = WC()->query->get_catalog_ordering_args($atts['orderby'], $atts['order']);
        $meta_query = WC()->query->get_meta_query();

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby' => $ordering_args['orderby'],
            'order' => $ordering_args['order'],
            'posts_per_page' => $atts['per_page'],
            'meta_query' => $meta_query,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'terms' => explode(',', $slug),
                    'field' => 'slug',
                    'operator' => 'IN'
                )
            )
        );

        if (isset($ordering_args['meta_key'])) {
            $args['meta_key'] = $ordering_args['meta_key'];
        }

        switch ($atts['prod_filter']) {
            case 'best_sell':
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                break;
            case 'featured':
                $args['meta_query'][] = array(
                    'key' => '_featured',
                    'value' => 'yes'
                );
                break;
        }

        $products = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $args, $atts));

        ob_start();

        $atts['title'] = '';
        $atts['is_slider'] = 1;

        if ($products->have_posts()) :

            if (absint($atts['as_widget']))
                YetiThemes_Extra()->get_shortcode_template('shortcode-woo-widget.tpl.php', $atts, $products);
            else {
                YetiThemes_Extra()->get_shortcode_template('shortcode-woo-nomal.tpl.php', $atts, $products);
            }

        endif;

        woocommerce_reset_loop();

        wp_reset_postdata();

        $classes = self::pareShortcodeClass('columns-' . absint($atts['columns']));

        return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';
    }

    public static function order_by_rating_post_clauses($args)
    {
        global $wpdb;

        $args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

        $args['join'] .= "
			LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";

        $args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

        $args['groupby'] = "$wpdb->posts.ID";

        return $args;
    }

    private static function pareShortcodeClass($class = '')
    {
        $classes = self::$classes;
        if (strlen($class) > 0)
            $classes[] = $class;
        return $classes;
    }

    public static function woo_get_product_by_cat()
    {

        $atts = array();
        $cat_slug = '';

        if (isset($_POST['atts'])) {
            $atts = $_POST['atts'];
        }

        if (isset($_POST['cat_slug'])) {
            $cat_slug = $_POST['cat_slug'];
        }


        $atts = shortcode_atts(array(
            "title" => '',
            "item_style" => 'grid',
            "as_widget" => '0',
            'widget_style' => '',
            "head_style" => '',
            "per_page" => '12',
            "columns" => '4',
            'prod_filter' => '',
            "orderby" => 'date',
            "order" => 'desc',
            "category" => '',
            "use_ajax" => '1'
        ), $atts);

        $ordering_args = WC()->query->get_catalog_ordering_args($atts['orderby'], $atts['order']);
        $meta_query = WC()->query->get_meta_query();

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby' => $ordering_args['orderby'],
            'order' => $ordering_args['order'],
            'posts_per_page' => $atts['per_page'],
            'meta_query' => $meta_query,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'terms' => explode(',', $cat_slug),
                    'field' => 'slug',
                    'operator' => 'IN'
                )
            )
        );

        if (isset($ordering_args['meta_key'])) {
            $args['meta_key'] = $ordering_args['meta_key'];
        }

        switch ($atts['prod_filter']) {
            case 'best_sell':
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                break;
            case 'featured':
                $args['meta_query'][] = array(
                    'key' => '_featured',
                    'value' => 'yes'
                );
                break;
        }

        $products = new WP_Query($args);

        ob_start();

        $atts['title'] = '';
        $atts['is_slider'] = 1;

        if ($products->have_posts()) :

            if (absint($atts['as_widget']))
                YetiThemes_Extra()->get_shortcode_template('shortcode-woo-widget.tpl.php', $atts, $products);
            else {
                YetiThemes_Extra()->get_shortcode_template('shortcode-woo-nomal.tpl.php', $atts, $products);
            }

        endif;

        woocommerce_reset_loop();

        wp_reset_postdata();

        $classes = self::pareShortcodeClass('columns-' . absint($atts['columns']));

        echo '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';

        die();
    }

    public static function woo_compare_page()
    {
        ob_start();
        if (class_exists('YITH_Woocompare_Frontend')) {
            global $yith_woocompare;
            YetiThemes_Extra()->get_shortcode_template('compare.php', array(
                'products' => $yith_woocompare->obj->get_products_list(),
                'fields' => $yith_woocompare->obj->fields(),
                'repeat_price' => get_option('yith_woocompare_price_end'),
                'repeat_add_to_cart' => get_option('yith_woocompare_add_to_cart_end')
            ));
        } else {
            esc_html_e('This page request to install YITH Woocommerce Compare plugin, please check!', 'yetithemes');
        }

        return ob_get_clean();
    }

    public static function woo_wishlist_link()
    {
        $wishlist_page_url = get_option('yith_wcwl_wishlist_page_id');

        if (!isset($wishlist_page_url) || absint($wishlist_page_url) === 0) return;

        ob_start(); ?>
        <a href="<?php echo esc_url(get_permalink($wishlist_page_url)); ?>"
           title="<?php esc_attr_e('Wishlist page', 'yetithemes') ?>">
            <i class="fa fa-heart-o" aria-hidden="true"></i> <?php esc_attr_e('Wishlist', 'yetithemes') ?>
        </a>
        <?php
        return ob_get_clean();
    }

    public static function woo_compare_link()
    {
        global $yesshop_datas;

        if (empty($yesshop_datas['compare_page_id'])) {
            $_compare_link = get_permalink(get_page_by_path('compare'));
        } else {
            $_compare_link = get_permalink($yesshop_datas['compare_page_id']);
        }

        ob_start(); ?>
        <a href="<?php echo esc_url($_compare_link); ?>" title="<?php esc_attr_e('Compare page', 'yetithemes') ?>">
            <i class="fa fa-exchange" aria-hidden="true"></i> <?php esc_attr_e('Compare', 'yetithemes') ?>
        </a>
        <?php
        return ob_get_clean();
    }

    public static function woocommerce_recently_viewed($atts)
    {
        global $woocommerce_loop;
        $atts = shortcode_atts(array(
            'title' => '',
            'limit' => 1,
            'item_style' => 'grid',
            'columns' => 4
        ), $atts);
        $viewed_products = !empty($_COOKIE['woocommerce_recently_viewed']) ? (array)explode('|', $_COOKIE['woocommerce_recently_viewed']) : array();
        $viewed_products = array_filter(array_map('absint', $viewed_products));
        if (empty($viewed_products)) {
            return;
        }

        $query_args = array(
            'posts_per_page' => $atts['limit'],
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post__in' => $viewed_products,
            'orderby' => 'rand'
        );

        $query_args['meta_query'] = array();
        $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
        $query_args['meta_query'] = array_filter($query_args['meta_query']);

        ob_start();

        $products = new WP_Query($query_args);

        $old_columns = $woocommerce_loop['columns'];

        if ($products->have_posts()) :

            YetiThemes_Extra()->get_shortcode_template('shortcode-woo-nomal.tpl.php', $atts, $products);

        endif;

        wp_reset_postdata();

        $woocommerce_loop['columns'] = $old_columns;

        $classes = self::pareShortcodeClass('columns-' . absint($atts['columns']));

        return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';
    }

    public static function woo_attributes($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'limit' => 15,
            'attribute' => '',
            'columns' => 6
        ), $atts);


        if (empty($atts['attribute'])) return;
        $taxonomy = wc_attribute_taxonomy_name($atts['attribute']);
        if (!taxonomy_exists($taxonomy)) return;
        $get_terms_args = array(
            'hide_empty' => '0',
            'number' => $atts['limit'],
            'orderby' => 'name',
            'menu_order' => false
        );
        $terms = get_terms($taxonomy, $get_terms_args);
        $output = '';
        if (count($terms) > 0) {
            ob_start();
            $li_class = array('woo-attr-item text-center');
            $li_class[] = 'col-lg-' . round(24 / $atts['columns']);
            $li_class[] = 'col-md-' . round(24 / round($atts['columns'] * 992 / 1200));
            $li_class[] = 'col-sm-' . round(24 / round($atts['columns'] * 768 / 1200));
            $li_class[] = 'col-xs-' . round(24 / round($atts['columns'] * 480 / 1200));
            echo '<ul class="list-inline">';
            foreach ($terms as $term) {
                $link = get_post_type_archive_link('product');
                $link = add_query_arg('filter_' . esc_attr($atts['attribute']), $term->term_id, $link);

                echo '<li class="' . esc_attr(implode(' ', $li_class)) . '">';
                printf('<a href="%1$s" title="%2$s">%2$s</a>', $link, $term->name);
                echo '</li>';
            }
            echo '</ul>';
            $output = ob_get_clean();
        }

        return $output;

    }

    public static function woo_categories($atts)
    {
        $atts = shortcode_atts(array(
            'title' => '',
            'h_style' => '',
            'cats_group' => '',
            'button_txt' => 'Show now',
            'shop_all_text' => ''
        ), $atts);

        ob_start();

        YetiThemes_Extra()->get_shortcode_template("shortcode-woo-cats2.tpl.php", $atts);

        $classes = self::pareShortcodeClass(__FUNCTION__);

        return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';
    }

    public static function trending_section_products($atts){
        $atts = shortcode_atts(array(
            'title'         => '',
            'sub_title'         => '',
            'prod_group'    => '',
            'filter'        => 'ids',
            'filter_by'     => 'recent',
            'is_slider'     => 1,
            'auto_play'     => 0,
            'per_page'      => 12,
            'orderby'       => 'date',
            'order'         => 'DESC',
            'words'         => 18,
            'style'         => 'external none'
        ), $atts);


        if($atts['filter'] === 'ids') {
            $query_args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => -1,
                'meta_query' => WC()->query->get_meta_query()
            );

            $atts['prod_group'] = (array)vc_param_group_parse_atts($atts['prod_group']);

            $ids = array();
            foreach ($atts['prod_group'] as $prod) {
                $ids[] = $prod['id'];
            }

            if (!empty($ids)) {
                $query_args['post__in'] = array_map('trim', $ids);
                $query_args['meta_query'] = array_merge($query_args['meta_query'], WC()->query->stock_status_meta_query());
            }
        } else {
            $query_args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'no_found_rows' => 1,
                'posts_per_page' => esc_attr($atts['per_page']),
                'orderby' => esc_attr($atts['orderby']),
                'order' => esc_attr($atts['order']),
                'meta_query' => WC()->query->get_meta_query()
            );
            switch ($atts['filter_by']) {
                case 'sale':
                    $query_args['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
                    break;
                case 'deal':
                    $query_args['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
                    $fil_date = strtotime("now");
                    $query_args['meta_query'] = array(
                        array(
                            'key' => '_sale_price_dates_from',
                            'value' => $fil_date,
                            'compare' => '<=',
                            'type' => 'numeric'
                        ),
                        array(
                            'key' => '_sale_price_dates_to',
                            'value' => $fil_date,
                            'compare' => '>=',
                            'type' => 'numeric'
                        )
                    );
                    break;
            }
        }


        ob_start();

        $products = self::product_query($query_args, $atts, __FUNCTION__);

        $_change_post = create_function('', 'return "top";');

        add_filter('yesshop_product_button_tooltip_pos', $_change_post, 10, 1);

        YetiThemes_Extra()->get_shortcode_template('shortcode-trainding-section.php', $atts, $products);

        remove_filter('yesshop_product_button_tooltip_pos', $_change_post, 10, 1);

        $classes = self::pareShortcodeClass(__FUNCTION__);

        woocommerce_reset_loop();
        wp_reset_postdata();

        return '<div class="' . esc_attr(implode(' ', $classes)) . '">' . ob_get_clean() . '</div>';
    }

    public static function get_cached_shortcode($atts, $key)
    {
        $cache_id = md5(serialize($atts));
        $cache = wp_cache_get($key, 'shortcode');
        if (!is_array($cache)) $cache = array();
        if (isset($cache[$cache_id]))
            return $cache[$cache_id];
        else return $cache;
    }

    public static function cache_shortcode($atts, $key, $content, $cache)
    {
        $cache_id = md5(serialize($atts));
        $cache[$cache_id] = $content;
        wp_cache_set($key, $cache, 'shortcode');
        return $content;
    }
}

new Yetithemes_Woo_Shortcodes();