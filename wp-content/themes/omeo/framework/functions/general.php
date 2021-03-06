<?php

if (!function_exists('yesshop_paging_nav')) :
    /**
     * Display navigation to next/previous set of posts when applicable.
     * Based on paging nav function from Twenty Fourteen
     */

    function yesshop_paging_nav()
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
endif;

if (!function_exists('yesshop_paginate_links')) {

    function yesshop_paginate_links($args = '')
    {
        global $wp_query, $wp_rewrite;

        // Setting up default values based on the current URL.
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $url_parts = explode('?', $pagenum_link);

        // Get max pages and current page out of the current query, if available.
        $total = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
        $current = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

        // Append the format placeholder to the base URL.
        $pagenum_link = trailingslashit($url_parts[0]) . '%_%';

        // URL base depends on permalink settings.
        $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

        $defaults = array(
            'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
            'format' => $format, // ?page=%#% : %#% is replaced by the page number
            'total' => $total,
            'current' => $current,
            'show_all' => false,
            'prev_next' => true,
            'prev_text' => esc_html__('Prev', 'omeo'),
            'next_text' => esc_html__('Next', 'omeo'),
            'end_size' => 1,
            'mid_size' => 2,
            'type' => 'plain',
            'add_args' => array(), // array of query args to add
            'add_fragment' => '',
            'before_page_number' => '',
            'after_page_number' => ''
        );

        $args = wp_parse_args($args, $defaults);

        if (!is_array($args['add_args'])) {
            $args['add_args'] = array();
        }

        //Hugo custom pagination here

        // Merge additional query vars found in the original URL into 'add_args' array.
        if (isset($url_parts[1])) {
            // Find the format argument.
            $format = explode('?', str_replace('%_%', $args['format'], $args['base']));
            $format_query = isset($format[1]) ? $format[1] : '';
            wp_parse_str($format_query, $format_args);

            // Find the query args of the requested URL.
            wp_parse_str($url_parts[1], $url_query_args);

            // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
            foreach ($format_args as $format_arg => $format_arg_value) {
                unset($url_query_args[$format_arg]);
            }

            $args['add_args'] = array_merge($args['add_args'], urlencode_deep($url_query_args));
        }

        // Who knows what else people pass in $args
        $total = (int)$args['total'];
        if ($total < 2) {
            return;
        }
        $current = (int)$args['current'];
        $end_size = (int)$args['end_size']; // Out of bounds?  Make it the default.
        if ($end_size < 1) {
            $end_size = 1;
        }
        $mid_size = (int)$args['mid_size'];
        if ($mid_size < 0) {
            $mid_size = 2;
        }
        $add_args = $args['add_args'];
        $r = '';
        $page_links = array();
        $dots = false;

        if ($args['prev_next'] && $current && 1 < $current) :
            $link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
            $link = str_replace('%#%', $current - 1, $link);
            if ($add_args)
                $link = add_query_arg($add_args, $link);
            $link .= $args['add_fragment'];

            /**
             * Filter the paginated links for the given archive pages.
             *
             * @since 3.0.0
             *
             * @param string $link The paginated link URL.
             */
            //hugo pre pagination
            $page_links[] = '<a class="prev page-numbers" href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $args['prev_text'] . '</a>';
        endif;
        for ($n = 1; $n <= $total; $n++) :
            $nth_pv_class = array("page-numbers");
            if ($n == 1) $nth_pv_class[] = "first";
            if ($n == $total) $nth_pv_class[] = "last";

            if ($n == $current) :
                $nth_pv_class[] = "current";
                $page_links[] = "<span class='" . esc_attr(implode(" ", $nth_pv_class)) . "'>" . $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number'] . "</span>";
                $dots = true;
            else :
                if ($args['show_all'] || ($n <= $end_size || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size) || $n > $total - $end_size)) :
                    $link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
                    $link = str_replace('%#%', $n, $link);
                    if ($add_args)
                        $link = add_query_arg($add_args, $link);
                    $link .= $args['add_fragment'];

                    /** This filter is documented in wp-includes/general-template.php */
                    $page_links[] = "<a class='" . esc_attr(implode(" ", $nth_pv_class)) . "' href='" . esc_url(apply_filters('paginate_links', $link)) . "'>" . $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number'] . "</a>";
                    $dots = true;
                elseif ($dots && !$args['show_all']) :
                    $nth_pv_class[] = "dots";
                    $page_links[] = '<span class="' . esc_attr(implode(" ", $nth_pv_class)) . '">&hellip;</span>';
                    $dots = false;
                endif;
            endif;
        endfor;
        if ($args['prev_next'] && $current && ($current < $total || -1 == $total)) :
            $link = str_replace('%_%', $args['format'], $args['base']);
            $link = str_replace('%#%', $current + 1, $link);
            if ($add_args)
                $link = add_query_arg($add_args, $link);
            $link .= $args['add_fragment'];

            //hugo pre pagination
            /** This filter is documented in wp-includes/general-template.php */
            $page_links[] = '<a class="next page-numbers" href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $args['next_text'] . '</a>';
        endif;
        switch ($args['type']) {
            case 'array' :
                return $page_links;

            case 'list' :
                $r .= "<ul class='page-numbers'>\n\t<li>";
                $r .= join("</li>\n\t<li>", $page_links);
                $r .= "</li>\n</ul>\n";
                break;

            default :
                $r = join("\n", $page_links);
                break;
        }
        return $r;
    }



}

add_action('template_redirect', 'yesshop_page_template_redirect');

function yesshop_page_template_redirect()
{
    global $content_width, $yesshop_datas;

    $content_width = 1170;

    if (is_singular('product')) {
        $yesshop_datas = Yesshop_Functions()->getOptions('product_options', $yesshop_datas);
    }

    if (is_single()) {
        $post_data = Yesshop_Functions()->getOptions('post_options');
        if (isset($post_data['blog_layout']) && strlen($post_data['blog_layout']) > 0)
            $yesshop_datas['blog-layout'] = $post_data['blog_layout'];
        if (isset($post_data['post_leftsidebar']) && strlen($post_data['post_leftsidebar']) > 0)
            $yesshop_datas['blog-left-sidebar'] = $post_data['post_leftsidebar'];
        if (isset($post_data['post_rightsidebar']) && strlen($post_data['post_rightsidebar']) > 0)
            $yesshop_datas['blog-right-sidebar'] = $post_data['post_rightsidebar'];
    }
}

add_filter('woocommerce_product_tabs', 'yesshop_woocommer_custom_tabs', 10);

function yesshop_woocommer_custom_tabs($tabs = array())
{
    global $yesshop_datas;

    $woo_customtabs = apply_filters('yesshop_woo_custom_tabs_init', false);

    if (!$woo_customtabs && isset($yesshop_datas['custom_tab_title']) && strlen($yesshop_datas['custom_tab_title'])) {
        $tabs['yeti_custom'] = array(
            'title' => sprintf('%s', stripslashes(esc_html($yesshop_datas['custom_tab_title']))),
            'priority' => 70,
            'callback' => 'yesshop_print_custom_tab'
        );
    }

    if (isset($tabs['additional_information'])) {
        unset($tabs['additional_information']);
    }

    return $tabs;
}


if (!function_exists('yesshop_the_excerpt')) {
    function yesshop_the_excerpt($limit = 25)
    {
        $excerpt = get_the_excerpt();

        $words = explode(' ', $excerpt, ($limit + 1));
        if (count($words) > $limit) array_pop($words);

        echo implode(' ', $words);
    }
}

if (!function_exists('yesshop_loadmore_btn')) {
    function yesshop_loadmore_btn($icon_class = '', $tag = 'button', $atts = array())
    {
        $attr = '';
        $atts = wp_parse_args($atts, array(
            'class' => '',
            'data-loading_text' => esc_html__('Loading...', 'omeo'),
            'id' => '',
            'title' => ''
        ));
        foreach ($atts as $k => $v) {
            if (!empty($v)) $attr .= " {$k}='{$v}'";
        }
        $text = '';
        if (strlen($icon_class) > 0) {
            $text .= "<i class='{$icon_class}'></i>";
        }
        $text .= '<span>' . esc_html__('Load more', 'omeo') . '</span>';

        printf('<%1$s %2$s>%3$s</%1$s>', $tag, $attr, $text);
    }
}