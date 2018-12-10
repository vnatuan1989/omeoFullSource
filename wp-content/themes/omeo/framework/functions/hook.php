<?php
/**
 * Header HOOKS
 */
add_action('yesshop_header_init',   'yesshop_header_wrap_start',    10);
add_action('yesshop_header_init',   'yesshop_header_tablet',        20);
add_action('yesshop_header_init',   'yesshop_header_body',          20);
add_action('yesshop_header_init',   'yesshop_header_wrap_end',      30);
add_action('yesshop_footer_init',   'yesshop_footer',               10);
add_action('wp_head',               'yesshop_head_script',          1000);
add_action('wp_footer',             'yesshop_footer_script',        1000);
add_action('template_redirect',     'yesshop_template_redirect');

add_filter('body_class',            'yesshop_bodyClass',           10, 1);

add_filter('login_form_middle',     'yesshop_woo_lost_your_pass', 10, 1);
add_filter('yesshop_main_content_class',   'yesshop_main_content_class', 10, 2);
add_filter('yesshop_page_show_title',      'yesshop_page_show_title');


add_filter('yesshop_main_container',    'yesshop_main_container_class', 10);
add_filter('widget_text',               'do_shortcode');

/**
 * POST ARCHIVE HOOKS
 */
add_filter('excerpt_length', 'yesshop_excerpt_length', 10);
add_filter('excerpt_more', 'yesshop_excerpt_more', 10);

if (class_exists('WooCommerce')) {
    /** ARCHIVE PAGE **/

    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    //remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
    //remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
    remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 10);

    add_action('yeti_shop_before_main_content', 'yeti_woocommerce_shop_top_menu', 30);
    add_action('woocommerce_shop_loop_subcategory_title', 'yesshop_woo_loop_category_title', 10);
    add_action('woocommerce_archive_description', 'yesshop_woocommerce_product_archive_jumbotron', 9);
    add_action('yesshop_woocommerce_orderby_select_after', 'yesshop_woocommerce_orderby_form_extra', 10);
    add_action('woocommerce_output_content_wrapper', 'yesshop_woocommerce_output_content_wrapper', 1);

    add_filter('woocommerce_product_get_rating_html', 'yesshop_filter_woocommerce_product_get_rating_html', 10, 2);
    add_filter('loop_shop_per_page', 'yesshop_loop_shop_per_page');
    add_filter('woocommerce_breadcrumb_defaults', 'yesshop_woocommerce_breadcrumbs');
    add_filter('loop_shop_columns', 'yesshop_loop_columns');
    add_filter('yesshop_woocommerce_loop_start_class', 'yesshop_woocommerce_loop_start_class');

    // Fix woocommerce 3.3 by Robert
    remove_action('woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories');

    /** MY ACCOUNT **/
    if(!is_admin()) {
        add_filter('woocommerce_account_menu_items', 'yesshop_woocommerce_account_menu_items_filter', 10, 1);
    }
    add_filter('woocommerce_cross_sells_total', 'yesshop_woocommerce_cross_sells_total', 10);
    add_filter('woocommerce_cross_sells_columns', 'yesshop_woocommerce_cross_sells_columns', 10);

    add_action( 'woocommerce_register_form', 'yeti_register_term_condition_field' );
    add_filter( 'woocommerce_registration_errors', 'yeti_register_term_condition', 10, 3 );

    /** CART, CHECKOUT **/
    remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10);

    add_action('woocommerce_cart_actions', 'yesshop_update_shopping_cart_button', 1);
    add_action('yesshop_shopping_progress', 'yesshop_shopping_progress', 10);
    add_action('yesshop_woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10);

    add_filter('yesshop_page_title', 'yesshop_custom_thankyou_title', 10, 1);
    add_filter('woocommerce_cart_item_name', 'yesshop_woocommerce_cart_item_name', 10, 1);
    add_filter('woocommerce_checkout_cart_item_quantity', 'yesshop_woocommerce_checkout_cart_item_quantity', 10, 3);

    /** SINGLE PRODUCT **/
    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

    //woocommerce_single_product_summary
    //add_action('woocommerce_single_product_summary',            'yesshop_single_product_summary_title_cat', 1);

    add_action('woocommerce_share', 'yesshop_single_post_meta_bottom_sharing', 10);
    add_action('woocommerce_after_single_product_summary', 'yesshop_single_product_summary_footer_block', 30);

    add_filter('woocommerce_output_related_products_args', 'yesshop_woocommerce_output_related_products_args', 10, 1);
    add_filter('woocommerce_up_sells_columns', 'yesshop_woo_single_product_list_columns', 10);
    add_filter('yesshop_include_thumb_id', 'yesshop_include_thumb_id_to_gallery', 10, 1);

    add_filter('woocommerce_cart_item_remove_link', 'yesshop_woocommerce_cart_item_remove_link_callback', 10, 2);
    add_action('yesshop_toolbar_wishlist', 'yesshop_toolbar_wishlist_callback', 10);
    add_action('yesshop_toolbar_compare', 'yesshop_toolbar_compare_callback', 10);


    /* Added to cart */
    add_action('woocommerce_ajax_added_to_cart', 'yesshop_woocommerce_ajax_added_to_cart', 10);
}

if (class_exists('YITH_WCWL')) {
    add_filter('yith_wcwl_positions', 'yesshop_custom_yith_wishlist_position');
}

if (class_exists('YITH_Woocompare')) {
    add_action('init', 'yesshop_remove_compare_link', 20);
    function yesshop_remove_compare_link()
    {
        global $yith_woocompare;
        $fontend = $yith_woocompare->obj;
        remove_action('woocommerce_single_product_summary', array($fontend, 'add_compare_link'), 35);
        add_action('woocommerce_after_add_to_cart_button', 'yesshop_add_compare_link', 35);
    }
}

add_action('post_class', 'yesshop_post_class', 10);
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');


add_filter('yith_woocompare_view_table_url', 'yesshop_woocompare_view_table_url', 99);


/**
 * FOOTER
 */

add_action('yesshop_footer_before_body_endtag', 'yesshop_footer_newsletter');
add_action('yesshop_footer_before_body_endtag', 'yesshop_newsletter_popup_callback', 10);
add_action('yesshop_footer_before_body_endtag', 'yesshop_compare_popup', 20);
add_action('yesshop_footer_before_body_endtag', 'yesshop_back_to_top', 20);

/**
 * GALLERIES
 */
add_filter('yetithemes_galleries_columns', 'yesshop_galleries_columns');
add_filter('yetithemes_gallery_royaloptions', 'yesshop_gallery_royaloptions');


add_filter('revslider_printCleanFontImport', 'yesshop_disable_revolution_fonts', 10, 1);

/**
 * BODY SIDEBARS
 */

add_action('yesshop_footer_before_body_endtag', 'yesshop_main_right_sidebar', 10);