<?php

class Yesshop_Mega_Menu_Frontend extends Walker_Nav_Menu {

    private $mega_menu, $theme_location;

    private $index = 0, $limit_item = 0;

    function __construct() {
        global $yesshop_datas;

        if( !empty($yesshop_datas['vertical-menu-limit-enable']) && !empty($yesshop_datas['vertical-menu-limit']) ) {
            $this->limit_item = absint($yesshop_datas['vertical-menu-limit']);
        }
    }

    public function start_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth > 2) return;
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth > 2) return;
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        if($depth === 0) {
            $this->index++;
        }
        /*get menu data*/
        $text_color = get_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_text_color', true);
        $font_icon  = get_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_font_icon', true);
        $icon_id    = get_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_icon_id', true);
        $backg_id   = get_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_backg_id', true);
        $mega       = get_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_mega', true);
        $f_label    = get_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_label', true);
        $width      = get_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_width', true);
        $widget     = get_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_widget', true);

        $dropdown_icon = '';

        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $classes[] = "menu-item-level-{$depth}";

        if($depth === 0 && $args->theme_location === 'vertical-menu' && $this->limit_item > 3 && $this->index > $this->limit_item) {
            $classes[] = 'hide';
        }

        $menu_label = '';

        if ($depth < 3) {
            if ($depth == 0) {
                if (absint($item->sub_count) > 0) {
                    $this->mega_menu = false;
                } else {
                    if (isset($mega) && absint($mega) == 1) {
                        $this->mega_menu = true;
                        $classes[] = "nth-mega-menu";
                        $classes[] = "nth-width-{$width}";
                        $classes[] = "menu-item-has-children";
                    } else {
                        $this->mega_menu = false;
                    }
                }

                if (isset($f_label) && strlen($f_label) > 0) {
                    $str_prf = '<span class="lb-menu ' . esc_attr($f_label) . '">%1$s</span>';
                    switch ($f_label) {
                        case 'lb_new':
                            $menu_label = sprintf($str_prf, esc_html__('New', 'omeo'));
                            break;
                        case 'lb_sale':
                            $menu_label = sprintf($str_prf, esc_html__('Sale', 'omeo'));
                            break;
                    }
                }

                if (absint($item->sub_count) > 0 || (isset($mega) && absint($mega) == 1)) {
                    $dropdown_icon = "{$indent}\t\t<a href='javascript:void(0)' class=\"fa fa-plus pull-right menu-drop-icon drop-icon-lv{$depth}\"></a>";
                }
            } else {
                if (absint($item->sub_count) > 0) {
                    $dropdown_icon = "{$indent}\t\t<a href='javascript:void(0)' class=\"fa fa-plus pull-right menu-drop-icon drop-icon-lv{$depth}\"></a>";
                }
            }
        }

        if ($depth > 3) return;


        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item The current menu item.
         * @param array $args An array of {@see wp_nav_menu()} arguments.
         * @param int $depth Depth of menu item. Used for padding.
         */
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        /**
         * Filter the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item The current menu item.
         * @param array $args An array of {@see wp_nav_menu()} arguments.
         * @param int $depth Depth of menu item. Used for padding.
         */
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        if (!empty($text_color)) $atts['style'] = "color: {$text_color}";

        $description = (!empty($item->description) && $depth == 0) ? '<small class="nav_desc">' . esc_attr($item->description) . '</small>' : '';

        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         * @type string $title Title attribute.
         * @type string $target Target attribute.
         * @type string $rel The rel attribute.
         * @type string $href The href attribute.
         * }
         * @param object $item The current menu item.
         * @param array $args An array of {@see wp_nav_menu()} arguments.
         * @param int $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        if (strlen($font_icon) > 0) {
            $item_output .= '<i class="' . esc_attr($font_icon) . '" aria-hidden="true"></i>';
        }

        /* icons */
        if (absint($icon_id) > 0) {
            $item_output .= wp_get_attachment_image($item->icon_id, 'yesshop_mega_menu_icon');
        }

        $item_output .= '<span>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $menu_label . $args->link_after;
        $item_output .= '</span>';

        $item_output .= $description;
        $item_output .= '</a>';
        $item_output .= $dropdown_icon;
        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param array $args An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = array()) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        if ($this->mega_menu) {
            $parent_id = $item->menu_item_parent;
            $side_bar = get_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_widget', true);
            $width = get_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_width', true);

            if ($depth == 0 && strlen($side_bar) > 0) {

                $style = '';
                if (absint($item->backg_id) > 0) {
                    $backg_src = wp_get_attachment_image_src($item->backg_id, 'full');
                    $style = " style=\"background: #ffffff url({$backg_src[0]}) bottom right no-repeat;\"";
                }

                $mega_content = function_exists('Yetithemes_StaticBlock') ?
                    Yetithemes_StaticBlock()->getContentByID($side_bar, true) : 'Please enable "Static Block"';

                $output .= "{$indent}<ul{$style} class=\"sub-menu yeti-width-{$width}\">\n";
                $output .= "{$indent}<li>";
                $output .= "{$indent}<div class=\"yeti-mega-menu-box\">" . $mega_content . "{$indent}</div>";
                $output .= "{$indent}</li>";
                $output .= "{$indent}</ul>\n";
                $output .= "{$indent}\t";

            }
        }

        $output .= "</li>\n";

        if($depth === 0 && $args->theme_location === 'vertical-menu' && $this->limit_item > 3 && $this->index === $this->limit_item) {
            $output .= '<li class="menu-more-action"><a href="#"><i class="fa fa-plus" aria-hidden="true"></i> <span>'.esc_attr__('More category', 'omeo').'</span></a></li>';
        }
    }

}

?>
