<?php

if (!function_exists('nth_help_tip')) {
    function nth_help_tip($tip, $allow_html = false)
    {
        $tip = esc_attr($tip);
        return '<span class="yeti-help-tip" data-tip="' . $tip . '">[?]</span>';
    }
}

if (!function_exists('nth_let_to_num')) {
    function nth_let_to_num($size)
    {
        $l = substr($size, -1);
        $ret = substr($size, 0, -1);
        switch (strtoupper($l)) {
            case 'P':
                $ret *= 1024;
            case 'T':
                $ret *= 1024;
            case 'G':
                $ret *= 1024;
            case 'M':
                $ret *= 1024;
            case 'K':
                $ret *= 1024;
        }
        return $ret;
    }
}

add_action('wp_ajax_yeti_features_enabled', 'yeti_ajax_features_enabled_option');

function yeti_ajax_features_enabled_option()
{
    check_ajax_referer('__YETI_SC_5362', 'security');
    $_data = $_REQUEST['yeti_features'];
    if (empty($_data)) {
        delete_option('yeti_features');
        wp_die(1);
    }
    YetiThemes_Extra()->update_options('yeti_features', maybe_serialize($_data));
    wp_die(1);
}

add_action('wp_ajax_yeti_product_data_action', 'yeti_product_data_action');

function yeti_product_data_action() {
    $_method = $_REQUEST['act'];

    switch ($_method) {
        case 'add_product_tab':
            $_save_key = 'yeti_product_custom_tab';
            $_datas = get_post_meta($_REQUEST['post_id'], $_save_key, true);
            if (isset($_REQUEST['title']) && isset($_REQUEST['content'])) {
                $_datas[] = array(
                    'custom_tab_title'      => esc_attr($_REQUEST['title']),
                    'custom_tab_content'    => esc_attr($_REQUEST['content']),
                    'custom_tab_hidden'     => esc_attr($_REQUEST['classes']),
                    'custom_tab_priority'   => !empty($_REQUEST['priority'])? absint($_REQUEST['priority']): 70
                );
            }
            update_post_meta($_REQUEST['post_id'], $_save_key, $_datas);

            echo yeti_product_data_table_html($_datas);
            break;
        case 'remove_product_tab':
            $_save_key = 'yeti_product_custom_tab';
            $_datas = get_post_meta($_REQUEST['post_id'], $_save_key, true);

            if(isset($_REQUEST['index'])) {
                $_index = $_REQUEST['index'];
                unset($_datas[$_index]);
                update_post_meta($_REQUEST['post_id'], $_save_key, $_datas);
            }

            echo yeti_product_data_table_html($_datas);

            break;
        case 'add_product_video':
            $_save_key = 'yeti_product_video';
            $_datas = get_post_meta($_REQUEST['post_id'], $_save_key, true);
            if (isset($_REQUEST['url'])) {
                $_datas[] = esc_url($_REQUEST['url']);
            }
            update_post_meta($_REQUEST['post_id'], $_save_key, $_datas);

            echo yeti_product_video_data_table_html($_datas);
            break;
        case 'remove_product_video':
            $_save_key = 'yeti_product_video';
            $_datas = get_post_meta($_REQUEST['post_id'], $_save_key, true);

            if(isset($_REQUEST['index'])) {
                $_index = $_REQUEST['index'];
                unset($_datas[$_index]);
                update_post_meta($_REQUEST['post_id'], $_save_key, $_datas);
            }

            echo yeti_product_video_data_table_html($_datas);
            break;
    }

    wp_die();
}

function yeti_product_data_table_html($_datas){
    ob_start();

    if(array_key_exists('specify', $_datas)) unset($_datas['specify']);

    if(!empty($_datas)) {
        foreach ($_datas as $k => $data) : if (empty($data['custom_tab_content'])) continue; ?>
            <tr data-index="<?php echo absint($k); ?>">
                <td><?php echo esc_attr($data['custom_tab_title'])?></td>
                <td><?php echo esc_html(get_the_title($data['custom_tab_content']))?></td>
                <td><span class="yeti-label"><?php echo absint($data['custom_tab_priority'])?></span></td>
                <td>
                    <?php
                    foreach (explode(' ', trim($data['custom_tab_hidden'])) as $v) {
                        switch ($v) {
                            case 'hidden-xs':
                                echo "<span class='yeti-label menu'>" . __('Mobile', 'yetithemes') . "</span>";
                                break;
                            case 'hidden-sm':
                                echo "<span class='yeti-label widget'>" . __('Tablet', 'yetithemes') . "</span>";
                                break;
                            case 'hidden-lg':
                                echo "<span class='yeti-label'>" . __('Desktop', 'yetithemes') . "</span>";
                                break;

                        }
                    }
                    ?>
                </td>
                <td><a href="#" title='Remove item' class="dashicons-before dashicons-trash remove"></a></td>
            </tr>
        <?php endforeach;
    } else {
        ?>
        <tr id="no_item"><td colspan='4'><small><?php esc_html_e('No single tab found!', 'yetithemes')?></small></td></tr>
        <?php
    }

    return ob_get_clean();
}

function yeti_product_video_data_table_html($_datas){
    ob_start();

    if(!empty($_datas)) {
        foreach ($_datas as $k => $data) : ?>
            <tr data-index="<?php echo absint($k); ?>">
                <td><span class="yeti-label"><?php echo esc_url($data);?></span></td>
                <td><a href="#" title='Remove item' class="dashicons-before dashicons-trash remove"></a></td>
            </tr>
        <?php endforeach;
    } else {
        ?>
        <tr id="no_item"><td colspan='4'><small><?php esc_html_e('No videos found!', 'yetithemes')?></small></td></tr>
        <?php
    }

    return ob_get_clean();
}

class Yeti_Functions
{

    private static $instance = null;

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function compare_page_link($_t = 'icon', $echo = true)
    {
        global $yesshop_datas;

        if (!class_exists('WooCommerce') || !class_exists('YITH_Woocompare')) return;

        if (empty($yesshop_datas['compare_page_id'])) {
            $_compare_link = get_permalink(get_page_by_path('compare'));
        } else {
            $_compare_link = get_permalink($yesshop_datas['compare_page_id']);
        }

        ob_start();
        switch ($_t) {
            default:
                ?>
                <a href="<?php echo esc_url($_compare_link); ?>"
                   title="<?php esc_attr_e('Compare page', 'yetithemes') ?>">
                    <i class="fa fa-exchange fa-2x" aria-hidden="true"></i>
                </a>
                <?php
        }
        if ($echo) echo ob_get_clean(); else return ob_get_clean();
    }

    public function wishlist_page_link($_t = 'icon', $echo = true)
    {
        $wishlist_page_url = get_option('yith_wcwl_wishlist_page_id');

        if (!isset($wishlist_page_url) || absint($wishlist_page_url) === 0) return;

        ob_start();

        switch ($_t) {
            default:
                ?>
                <a href="<?php echo esc_url(get_permalink($wishlist_page_url)); ?>"
                   title="<?php esc_attr_e('Wishlist page', 'yetithemes') ?>">
                    <i class="fa fa-heart-o fa-2x" aria-hidden="true"></i>
                </a>
                <?php
        }

        if ($echo) echo ob_get_clean(); else return ob_get_clean();
    }

    public function theme_endcode($str) {
        return base64_encode($str);
    }
}

function Yeti_Functions()
{
    return Yeti_Functions::get_instance();
}