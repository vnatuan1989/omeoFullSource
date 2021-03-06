<?php
/**
 * Dimox Breadcrumbs
 * http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
 * Since ver 1.0
 * Add this to any template file by calling yesshop_dimox_breadcrumbs()
 * Changes: MC added taxonomy support
 */

if (!function_exists('yesshop_dimox_breadcrumbs')) {

    function yesshop_dimox_breadcrumbs()
    {
        global $post, $yesshop_datas;
        /* === OPTIONS === */
        $text = array(
            "home" => esc_html__('Home', 'omeo'),
            'category' => esc_html__('Archive by Category "%s"', 'omeo'),
            "tax" => esc_html__('Archive for "%s"', 'omeo'),
            "search" => esc_html__('Search Results for "%s" Query', 'omeo'),
            "tag" => esc_html__('Posts Tagged "%s"', 'omeo'),
            "author" => esc_html__('Articles Posted by %s', 'omeo'),
            "404" => esc_html__('Error 404', 'omeo')
        );

        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
        $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
        $delimiter = ''; // delimiter between crumbs
        $before = '%s'; // tag before the current crumb
        $after = '</li>'; // tag after the current crumb
        /* === END OF OPTIONS === */
        $breadBefore = '%s%s';
        $breadAfter = '%1$s%2$s';
        $homeLink = esc_url(home_url('/'));
        $linkBefore = '<li>';
        $linkAfter = '</li>';
        $linkAttr = '';

        if (isset($yesshop_datas['breadcrum-style'])) {
            switch ($yesshop_datas['breadcrum-style']) {
                case 'transparent':
                    $delimiter = '<span class="delimiter">&rarr;</span>';
                    $breadBefore = '%s';
                    $breadAfter = '%2$s';
                    $linkBefore = '';
                    $linkAfter = '';
                    $before = '';
                    $after = '';
                    break;
                default:
                    $delimiter = '';
            }
        }

        $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

        if (is_home()) {
            if (!is_front_page()) {
                echo '<nav id="crumbs"><ul>' .
                    '<li><a href="' . esc_url($homeLink) . '">' . $text['home'] . '</a></li>' .
                    '<li>' . single_post_title('', false) . '</li>' .
                    '</ul></nav>';
            }
        } else {

            echo sprintf($breadBefore, '<nav id="crumbs">', '<ul>') . sprintf($link, $homeLink, $text['home']) . $delimiter;

            if (is_category()) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    print $cats;
                }
                echo sprintf($before, '<li class="current">') . single_cat_title('', false) . $after;

            } elseif (is_tax() && false) {
                $thisCat = get_category(get_query_var('cat'), false);
                print_r(get_query_var('cat'));
                if ($thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    print $cats;
                }
                echo sprintf($before, '<li class="current">') . sprintf($text['tax'], single_cat_title('', false)) . $after;

            } elseif (is_search()) {
                echo sprintf($before, '<li class="current">') . sprintf($text['search'], get_search_query()) . $after;

            } elseif (is_day()) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
                echo sprintf($before, '<li class="current">') . get_the_time('d') . $after;

            } elseif (is_month()) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo sprintf($before, '<li class="current">') . get_the_time('F') . $after;

            } elseif (is_year()) {
                echo sprintf($before, '<li class="current">') . get_the_time('Y') . $after;

            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    $post_type_name = $post_type->labels->singular_name;

                    if (strcmp('Product', $post_type->labels->singular_name) == 0) {
                        $post_type_name = esc_html__('Shop', 'omeo');
                    }
                    printf($link, get_post_type_archive_link(get_post_type()), $post_type_name);
                    if ($showCurrent == 1) print $delimiter . sprintf($before, '<li class="current">') . get_the_title() . $after;
                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, $delimiter);
                    if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    print $cats;
                    if ($showCurrent == 1) echo sprintf($before, '<li class="current">') . get_the_title() . $after;
                }

            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                $post_type = get_post_type_object(get_post_type());
                $post_type_name = $post_type->labels->singular_name;

                if (strcmp('Product', $post_type->labels->singular_name) == 0) {
                    $post_type_name = esc_html__('Shop', 'omeo');
                }

                if (is_tag()) {
                    echo sprintf($before, '<li class="current">') . esc_html__('Tagged "', 'omeo') . single_tag_title('', false) . '"' . $after;

                } elseif (is_taxonomy_hierarchical(get_query_var('taxonomy'))) {
                    printf($link, get_post_type_archive_link(get_post_type()), $post_type_name);

                    $current_tax = get_query_var('taxonomy');
                    $term_slug = get_query_var('term');
                    $term = get_term_by("slug", $term_slug, $current_tax);
                    $term_cr = $term;
                    $ourputs = array();
                    while (absint($term->parent) > 0) {
                        $pe_term = get_term(absint($term->parent), get_query_var('taxonomy'));
                        array_push($ourputs, ' ' . $delimiter . '<a href="' . get_term_link(absint($pe_term->term_id), get_query_var('taxonomy')) . '">' . $pe_term->name . '</a>');

                        $term = get_term_by("slug", $pe_term->slug, get_query_var('taxonomy'));
                    }
                    $ourputs = array_reverse($ourputs);
                    $output_str = implode($ourputs);
                    print $output_str;
                    if ($showCurrent == 1) echo " " . $delimiter . ' ' . sprintf($before, '<li class="current">') . $term_cr->name . $after;
                } else {
                    printf($link, get_post_type_archive_link(get_post_type()), $post_type_name);
                }

            } elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID);
                $cat = $cat[0];
                if ($cat) {
                    $cats = get_category_parents($cat, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    print $cats;
                }
                printf($link, get_permalink($parent), $parent->post_title);
                if ($showCurrent == 1) print $delimiter . sprintf($before, '<li class="current">') . get_the_title() . $after;

            } elseif (is_page() && !$post->post_parent) {
                if ($showCurrent == 1) echo sprintf($before, '<li class="current">') . get_the_title() . $after;

            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_post($parent_id);
                    $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    print $breadcrumbs[$i];
                    if ($i != count($breadcrumbs) - 1) print $delimiter;
                }
                if ($showCurrent == 1) print $delimiter . sprintf($before, '<li class="current">') . get_the_title() . $after;

            } elseif (is_tag()) {
                echo sprintf($before, '<li class="current">') . sprintf($text['tag'], single_tag_title('', false)) . $after;

            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo sprintf($before, '<li class="current">') . sprintf($text['author'], $userdata->display_name) . $after;

            } elseif (is_404()) {
                echo sprintf($before, '<li class="current">') . $text['404'] . $after;
            }

            if (get_query_var('paged')) {
                echo sprintf($before, '<li class="current">') . esc_html__('Page', 'omeo') . ' ' . get_query_var('paged') . $after;
            }

            printf($breadAfter, '</ul>', '</nav>');

        }
    }


    add_action('yesshop_breadcrumb', 'yesshop_breadcrumb_function', 10);

    function yesshop_breadcrumb_function()
    {
        global $yesshop_datas;

        if (is_front_page() || (isset($yesshop_datas['page-datas']['page_show_breadcrumb']) && absint($yesshop_datas['page-datas']['page_show_breadcrumb']) === 0)) return '';
        $classes = array('breadcrumb yesshop-breadcrumb-wrapper');
        if (!empty($yesshop_datas['breadcrumb-style'])) $classes[] = esc_attr($yesshop_datas['breadcrumb-style']);

        echo '<div class="' . esc_attr(implode(' ', $classes)) . '"><div class="container">';
        if (class_exists('WooCommerce') && is_woocommerce()) {

            woocommerce_breadcrumb();
            if (is_product()) {
                echo '<h2 class="page-title">' . get_the_title() . '</h2>';
            } elseif (apply_filters('woocommerce_show_page_title', true)) {
                if (is_shop() || is_product_category()) {
                    echo '<h1 class="page-title">' . woocommerce_page_title(false) . '</h1>';
                } else {
                    echo '<h1 class="page-title">' . get_the_title() . '</h1>';
                }

            }
            
        } elseif (is_home() && !is_front_page()) {
            yesshop_dimox_breadcrumbs();
            echo '<h1 class="page-title">' . single_post_title('', false) . '</h1>';
            
        } elseif (is_archive()) {
            yesshop_dimox_breadcrumbs();
            the_archive_title('<h1 class="page-title">', '</h1>');
            
        } elseif(is_404()){
            yesshop_dimox_breadcrumbs();
            echo '<h1 class="page-heading page-title">'.esc_html__('404 Page Not Found', 'omeo').'</h1>';
        } else {
            $_page_datas = $yesshop_datas['page-datas'];
            if (absint($_page_datas['page_show_breadcrumb']) !== 0)
                yesshop_dimox_breadcrumbs();
            if (absint($_page_datas['page_show_title']) !== 0)
                echo '<h1 class="page-title">' . get_the_title() . '</h1>';
            
        }
        echo '</div></div>';
    }

}