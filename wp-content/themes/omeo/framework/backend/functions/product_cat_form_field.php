<?php

$_actived = apply_filters('active_plugins', get_option('active_plugins'));
if (in_array("woocommerce/woocommerce.php", $_actived)) :

    if (!function_exists('yesshop_product_cat_add_form_fields')) {
        add_action('product_cat_add_form_fields', 'yesshop_product_cat_add_form_fields', 10);

        function yesshop_product_cat_add_form_fields()
        {
            $sidebars = Yesshop_Functions()->getSidebarArgs(array('' => esc_attr__('--Inherit Theme Options--', 'omeo')));

            if (function_exists('Yetithemes_StaticBlock')) {
                echo '<div class="form-field">';
                echo '<label for="yeti_cat_jumbotron">' . esc_html__('Jumbotron', 'omeo') . '</label>';
                Yetithemes_StaticBlock()->getSelected('yeti_cat_jumbotron', 'chosen_select');
                echo '</div>';
            }
            ?>
            <div class="form-field">
                <label for="yeti_cat_layout"><?php esc_html_e('Category page Layout', 'omeo') ?></label>
                <select id="yeti_cat_layout" name="yeti_cat_layout" class="postform">
                    <option value=""><?php esc_html_e('--Inherit Theme Options--', 'omeo') ?></option>
                    <option value="0-0"><?php esc_html_e('Full width', 'omeo') ?></option>
                    <option value="1-0"><?php esc_html_e('Left sidebar', 'omeo') ?></option>
                    <option value="0-1"><?php esc_html_e('Right Sidebar', 'omeo') ?></option>
                    <option value="1-1"><?php esc_html_e('Both sidebars', 'omeo') ?></option>
                </select>
            </div>

            <div class="form-field">
                <label for="yeti_cat_sidebarleft"><?php esc_html_e('Left sidebar', 'omeo') ?></label>
                <select id="yeti_cat_sidebarleft" name="yeti_cat_sidebarleft" class="postform">
                    <?php foreach ($sidebars as $k => $v): ?>
                        <option value="<?php echo esc_attr($k) ?>"><?php echo esc_html($v) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-field">
                <label for="yeti_cat_sidebarright"><?php esc_html_e('Right sidebar', 'omeo') ?></label>
                <select id="yeti_cat_sidebarright" name="yeti_cat_sidebarright" class="postform">
                    <?php foreach ($sidebars as $k => $v): ?>
                        <option value="<?php echo esc_attr($k) ?>"><?php echo esc_html($v) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-field">
                <label for="yeti_prod_columns"><?php esc_html_e('Product columns', 'omeo') ?></label>
                <select id="yeti_prod_columns" name="yeti_prod_columns" class="postform">
                    <option value=""><?php esc_html_e('--Inherit Theme Options--', 'omeo') ?></option>
                    <option value="2"><?php esc_html_e('2 Columns', 'omeo') ?></option>
                    <option value="3"><?php esc_html_e('3 Columns', 'omeo') ?></option>
                    <option value="4"><?php esc_html_e('4 Columns', 'omeo') ?></option>
                    <option value="6"><?php esc_html_e('6 Columns', 'omeo') ?></option>
                </select>
            </div>

            <?php
        }
    }


    if (!function_exists('yesshop_product_cat_edit_form_fields')) {

        add_action('product_cat_edit_form_fields', 'yesshop_product_cat_edit_form_fields', 10, 2);

        function yesshop_product_cat_edit_form_fields($term, $taxonomy)
        {
            $sidebars = Yesshop_Functions()->getSidebarArgs(array('' => esc_attr__('--Inherit Theme Options--', 'omeo')));
            $datas = maybe_unserialize(get_woocommerce_term_meta($term->term_id, "yeti_woo_cat"));
            $datas = wp_parse_args($datas, array(
                'cat-jumbotron' => '',
                'shop-layout' => '',
                'shop-left-sidebar' => '',
                'shop-right-sidebar' => '',
                'shop_columns'       => ''
            ));

            if (function_exists('Yetithemes_StaticBlock')):
                ?>
                <tr class="form-field">
                    <th scope="row" valign="top">
                        <label><?php esc_html_e('Jumbotron', 'omeo') ?></label>
                    </th>
                    <td><?php Yetithemes_StaticBlock()->getSelected('yeti_cat_jumbotron', 'chosen_select', $datas['cat-jumbotron']); ?></td>
                </tr>
                <?php
            endif;

            ?>
            <tr class="form-field">
                <th scope="row" valign="top">
                    <label for="yeti_cat_layout"><?php esc_html_e('Category page Layout', 'omeo') ?></label>
                </th>
                <td>
                    <select id="yeti_cat_layout" name="yeti_cat_layout" class="postform">
                        <option value=""><?php esc_html_e('--Inherit Theme Options--', 'omeo') ?></option>
                        <option value="0-0" <?php selected($datas['shop-layout'], '0-0') ?>><?php esc_html_e('Full width', 'omeo') ?></option>
                        <option value="1-0" <?php selected($datas['shop-layout'], '1-0') ?>><?php esc_html_e('Left sidebar', 'omeo') ?></option>
                        <option value="0-1" <?php selected($datas['shop-layout'], '0-1') ?>><?php esc_html_e('Right Sidebar', 'omeo') ?></option>
                        <option value="1-1" <?php selected($datas['shop-layout'], '1-1') ?>><?php esc_html_e('Both sidebars', 'omeo') ?></option>
                    </select>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row" valign="top">
                    <label for="yeti_cat_sidebarleft"><?php esc_html_e('Left sidebar', 'omeo') ?></label>
                </th>
                <td>
                    <select id="yeti_cat_sidebarleft" name="yeti_cat_sidebarleft" class="postform">
                        <?php foreach ($sidebars as $k => $v): ?>
                            <option value="<?php echo esc_attr($k) ?>" <?php selected($datas['shop-left-sidebar'], esc_attr($k)) ?>><?php echo esc_html($v) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row" valign="top">
                    <label for="yeti_cat_sidebarright"><?php esc_html_e('Right sidebar', 'omeo') ?></label>
                </th>
                <td>
                    <select id="yeti_cat_sidebarright" name="yeti_cat_sidebarright" class="postform">
                        <?php foreach ($sidebars as $k => $v): ?>
                            <option value="<?php echo esc_attr($k) ?>" <?php selected($datas['shop-right-sidebar'], esc_attr($k)) ?>><?php echo esc_html($v) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row" valign="top">
                    <label for="yeti_prod_columns"><?php esc_html_e('Product columns', 'omeo') ?></label>
                </th>
                <td>
                    <select id="yeti_prod_columns" name="yeti_prod_columns" class="postform">
                        <option value=""><?php esc_html_e('--Inherit Theme Options--', 'omeo') ?></option>
                        <option value="2" <?php selected($datas['shop_columns'], '2') ?>><?php esc_html_e('2 Columns', 'omeo') ?></option>
                        <option value="3" <?php selected($datas['shop_columns'], '3') ?>><?php esc_html_e('3 Columns', 'omeo') ?></option>
                        <option value="4" <?php selected($datas['shop_columns'], '4') ?>><?php esc_html_e('4 Columns', 'omeo') ?></option>
                        <option value="6" <?php selected($datas['shop_columns'], '6') ?>><?php esc_html_e('6 Columns', 'omeo') ?></option>
                    </select>
                </td>
            </tr>

            <?php
        }
    }

    if (!function_exists('yesshop_category_form_save')) {

        add_action('created_term', 'yesshop_category_form_save', 10, 3);
        add_action('edit_term', 'yesshop_category_form_save', 10, 3);

        function yesshop_category_form_save($term_id, $tt_id, $taxonomy)
        {
            if (isset($_POST['_inline_edit'])) return $term_id;
            if (strcmp(trim($taxonomy), "product_cat") !== 0) return $term_id;

            $datas = array();

            $datas['cat-jumbotron'] = !empty($_POST['yeti_cat_jumbotron']) ? esc_attr($_POST['yeti_cat_jumbotron']) : '';
            $datas['shop-layout'] = !empty($_POST['yeti_cat_layout']) ? esc_attr($_POST['yeti_cat_layout']) : '';
            $datas['shop-left-sidebar'] = !empty($_POST['yeti_cat_sidebarleft']) ? esc_attr($_POST['yeti_cat_sidebarleft']) : '';
            $datas['shop-right-sidebar'] = !empty($_POST['yeti_cat_sidebarright']) ? esc_attr($_POST['yeti_cat_sidebarright']) : '';
            $datas['shop_columns'] = !empty($_POST['yeti_prod_columns']) ? esc_attr($_POST['yeti_prod_columns']) : '';

            $result = update_woocommerce_term_meta($term_id, "yeti_woo_cat", maybe_serialize($datas));
        }

    }

    if (!function_exists('yesshop_category_form_remove')) {

        add_action('delete_term', 'yesshop_category_form_remove', 10, 3);

        function yesshop_category_form_remove($term_id, $tt_id, $taxonomy)
        {
            if (strcmp(trim($taxonomy), "product_cat") !== 0) return $term_id;
            delete_woocommerce_term_meta($term_id, "yeti_woo_cat");
        }
    }

endif;// check woocommerce;

