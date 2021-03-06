<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package     ReduxFramework\Uninstall
 * @author      Dovy Paukstys <info@simplerain.com>
 * @since       3.0.0
 */


add_action('wp_update_nav_menu_item', 'yesshop_mega_nav_menu_update', 10, 3);

function yesshop_mega_nav_menu_update($menu_id, $menu_item_db_id, $args)
{

    if (isset($_REQUEST['menu-item-text-color']) && is_array($_REQUEST['menu-item-text-color'])) {
        $custom_value = $_REQUEST['menu-item-text-color'][$menu_item_db_id];
        update_post_meta($menu_item_db_id, yesshop_MEGA_MENU_K . '_menu_item_text_color', $custom_value);
    }

    if (isset($_REQUEST['menu-item-font-icon']) && is_array($_REQUEST['menu-item-font-icon'])) {
        $custom_value = $_REQUEST['menu-item-font-icon'][$menu_item_db_id];
        update_post_meta($menu_item_db_id, yesshop_MEGA_MENU_K . '_menu_item_font_icon', $custom_value);
    }

    if (isset($_REQUEST['menu-item-icon-id']) && is_array($_REQUEST['menu-item-icon-id'])) {
        $custom_value = $_REQUEST['menu-item-icon-id'][$menu_item_db_id];
        update_post_meta($menu_item_db_id, yesshop_MEGA_MENU_K . '_menu_item_icon_id', $custom_value);
    }

    if (isset($_REQUEST['menu-item-backg-id']) && is_array($_REQUEST['menu-item-backg-id'])) {
        $custom_value = isset($_REQUEST['menu-item-backg-id'][$menu_item_db_id]) ?
            $_REQUEST['menu-item-backg-id'][$menu_item_db_id] : '';
        update_post_meta($menu_item_db_id, yesshop_MEGA_MENU_K . '_menu_item_backg_id', $custom_value);
    }

    if (isset($_REQUEST['menu-item-mega']) && is_array($_REQUEST['menu-item-mega'])) {
        $custom_value = isset($_REQUEST['menu-item-mega'][$menu_item_db_id]) ? $_REQUEST['menu-item-mega'][$menu_item_db_id] : 0;
        update_post_meta($menu_item_db_id, yesshop_MEGA_MENU_K . '_menu_item_mega', $custom_value);
    } else {
        update_post_meta($menu_item_db_id, yesshop_MEGA_MENU_K . '_menu_item_mega', '');
    }

    if (isset($_REQUEST['menu-item-label']) && is_array($_REQUEST['menu-item-label'])) {
        $custom_value = isset($_REQUEST['menu-item-label'][$menu_item_db_id]) ? $_REQUEST['menu-item-label'][$menu_item_db_id] : 0;
        update_post_meta($menu_item_db_id, yesshop_MEGA_MENU_K . '_menu_item_label', $custom_value);
    } else {
        update_post_meta($menu_item_db_id, yesshop_MEGA_MENU_K . '_menu_item_label', '');
    }

    if (isset($_REQUEST['menu-item-width']) && is_array($_REQUEST['menu-item-width'])) {
        $custom_value = isset($_REQUEST['menu-item-width'][$menu_item_db_id]) ? $_REQUEST['menu-item-width'][$menu_item_db_id] : 1;
        update_post_meta($menu_item_db_id, yesshop_MEGA_MENU_K . '_menu_item_width', $custom_value);
    }

    if (isset($_REQUEST['menu-item-widget']) && is_array($_REQUEST['menu-item-widget'])) {
        $custom_value = isset($_REQUEST['menu-item-widget'][$menu_item_db_id]) ? $_REQUEST['menu-item-widget'][$menu_item_db_id] : '';
        update_post_meta($menu_item_db_id, yesshop_MEGA_MENU_K . '_menu_item_widget', $custom_value);
    }

}


add_filter('wp_setup_nav_menu_item', 'yesshop_set_nav_menu_item');

function yesshop_set_nav_menu_item($menu_item)
{
    $menu_item->text_color = get_post_meta($menu_item->ID, yesshop_MEGA_MENU_K . '_menu_item_text_color', true);
    $menu_item->font_icon = get_post_meta($menu_item->ID, yesshop_MEGA_MENU_K . '_menu_item_font_icon', true);
    $menu_item->icon_id = get_post_meta($menu_item->ID, yesshop_MEGA_MENU_K . '_menu_item_icon_id', true);
    $menu_item->backg_id = get_post_meta($menu_item->ID, yesshop_MEGA_MENU_K . '_menu_item_backg_id', true);
    $menu_item->mega = get_post_meta($menu_item->ID, yesshop_MEGA_MENU_K . '_menu_item_mega', true);
    $menu_item->f_label = get_post_meta($menu_item->ID, yesshop_MEGA_MENU_K . '_menu_item_label', true);
    $menu_item->width = get_post_meta($menu_item->ID, yesshop_MEGA_MENU_K . '_menu_item_width', true);
    $menu_item->widget = get_post_meta($menu_item->ID, yesshop_MEGA_MENU_K . '_menu_item_widget', true);

    return $menu_item;
}


function yesshop_menu_has_sub($menu_item_id, &$items)
{
    $sub_count = 0;
    foreach ($items as $item) {
        if ($item->menu_item_parent && $item->menu_item_parent == $menu_item_id) {
            $sub_count++;
        }
    }
    return $sub_count;
}

function yesshop_modify_nav_items($items)
{
    foreach ($items as $item) {
        if ($sub_count = yesshop_menu_has_sub($item->ID, $items)) {
            $item->sub_count = $sub_count;
        }
    }
    return $items;
}

add_filter('wp_nav_menu_objects', 'yesshop_modify_nav_items');

?>