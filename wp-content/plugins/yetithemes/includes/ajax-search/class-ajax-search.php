<?php

/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 10/31/2015
 * Vertion: 1.0
 */
class AjaxSeach
{
    private $__default = array();

    function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_action('wp_ajax_yeti_ajax_search_products', array($this, 'ajax_search_products'));
        add_action('wp_ajax_nopriv_yeti_ajax_search_products', array($this, 'ajax_search_products'));
    }

    public function load_scripts()
    {
        wp_register_script('jquery.autocomplete.min', YETI_PLUGIN_URL . 'assets/js/jquery.autocomplete.min.js', array("jquery"), '1.2.24', true);
        wp_enqueue_script('jquery.autocomplete.min');
    }

    public function ajax_search_products()
    {
        global $woocommerce;

        $search_keyword = $_REQUEST['query'];
        $_limit = isset($_REQUEST['limit']) ? absint($_REQUEST['limit']) : 5;

        $ordering_args = $woocommerce->query->get_catalog_ordering_args('title', 'asc');
        $suggestions = array();

        $args = array(
            's' => $search_keyword,
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby' => $ordering_args['orderby'],
            'order' => $ordering_args['order'],
            'posts_per_page' => 5,
            'suppress_filters' => false,
        );

        $args['posts_per_page'] = absint($_limit);

        if (!empty($_REQUEST['product_cat'])) {
            $args['tax_query'] = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $_REQUEST['product_cat']
                ));
        }

        $product_visibility_term_ids = wc_get_product_visibility_term_ids();
        $args['tax_query'][] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'term_taxonomy_id',
            'terms'    => $product_visibility_term_ids['exclude-from-search'],
            'operator' => 'NOT IN',
        );

        $products = get_posts($args);

        if (!empty($products)) {
            foreach ($products as $post) {
                $product = wc_get_product($post);
                $thumb_id = get_post_thumbnail_id($product->get_id());
                $image = wp_get_attachment_image($thumb_id, 'thumbnail', 0, array("class" => "suggestion-thumbnail"));
                $suggestions[] = array(
                    'id' => $product->get_id(),
                    'value' => strip_tags($product->get_title()),
                    'url' => $product->get_permalink(),
                    'img' => $image,
                    'price' => '<div class="suggestion-prices">' . $product->get_price_html() . '</div>'
                );
            }
        } else {
            $suggestions[] = array(
                'id' => -1,
                'value' => __('No results', 'yetithemes'),
                'url' => '',
            );
        }
        wp_reset_postdata();

        $suggestions = array(
            'suggestions' => $suggestions
        );

        echo json_encode($suggestions);
        die();
    }

}

new AjaxSeach();