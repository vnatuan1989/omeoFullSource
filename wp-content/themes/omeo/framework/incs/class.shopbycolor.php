<?php

if (!class_exists('Yesshop_ShopByColor')) {

    class Yesshop_ShopByColor
    {

        private $woo_ready = false;
        private $color_ready = false;
        private $err_msg, $color_slug = '';
        private $_term_key = '_pa_color_data';

        public function __construct()
        {
            $this->check_woo();
            add_action('init', array($this, 'init'));
        }

        public function check_woo()
        {
            if (class_exists('WooCommerce')) {
                $this->woo_ready = true;
            } else {
                $this->woo_ready = false;
            }
        }

        public function init()
        {
            if ($this->woo_ready == false) return;

            $_color = 'color';
            $attribute_name = isset($_color) ? wc_sanitize_taxonomy_name(stripslashes((string)$_color)) : '';
            $attribute_name = wc_attribute_taxonomy_name($attribute_name);
            $attribute_name_array = wc_get_attribute_taxonomy_names();
            $taxonomy_exists = in_array($attribute_name, $attribute_name_array);

            if ($taxonomy_exists) {
                $this->color_slug = $attribute_name;
                add_action('admin_enqueue_scripts', array($this, 'enqueue_script'));
                $this->be_custom();
            }

        }

        public function enqueue_script()
        {
            wp_enqueue_style('wp-color-picker');
        }

        public function be_custom()
        {
            $_edit_hook = $this->color_slug . '_edit_form_fields';
            $_add_hook = $this->color_slug . '_add_form_fields';
            /** Add template **/
            add_action($_edit_hook, array($this, 'pa_edit_attribute'), 100000, 2);
            add_action($_add_hook, array($this, 'pa_add_attribute'), 100000);

            add_action('created_term', array($this, 'pa_color_fields_save'), 10, 3);
            add_action('edit_term', array($this, 'pa_color_fields_save'), 10, 3);
            add_action('delete_term', array($this, 'pa_color_fields_remove'), 10, 3);

            //table
            $_edit_table_hook = 'manage_edit-' . $this->color_slug . '_columns';
            $_edit_table_content_hook = 'manage_' . $this->color_slug . '_custom_column';

            add_filter($_edit_table_hook, array($this, "pa_edit_color_table_columns"));
            add_filter($_edit_table_content_hook, array($this, 'pa_edit_color_table_content'), 10, 3);
        }

        public function pa_edit_attribute($term, $taxonomy)
        {
            $datas = get_woocommerce_term_meta($term->term_id, $this->_term_key, true);
            if (!isset($datas) || strlen($datas) == 0) $datas = "#aaaaaa";
            ?>
            <tr class="form-field form-required">
                <th scope="row" valign="top"><label><?php esc_html_e('Color', 'omeo'); ?></label></th>
                <td>
                    <input name="<?php echo esc_attr($this->_term_key); ?>" id="hex-color" class="nth_colorpicker"
                           data-default-color="<?php echo esc_attr($datas); ?>" type="text"
                           value="<?php echo esc_attr($datas); ?>" size="40" aria-required="true">
                    <span class="description">Use color picker to pick one color.</span>
                </td>
            </tr>
            <?php
        }

        public function pa_add_attribute()
        {
            ?>
            <div class="form-field form-required">
                <label for="display_type"><?php esc_html_e('Color', 'omeo'); ?></label>
                <input name="<?php echo esc_attr($this->_term_key); ?>" id="hex-color" class="nth_colorpicker"
                       type="text" value="#aaaaaa" size="40" aria-required="true">
                <p>Use color picker to pick one color.</p>
            </div>
            <?php
        }

        public function pa_color_fields_save($term_id, $tt_id, $taxonomy)
        {
            $data = isset($_REQUEST[$this->_term_key]) ? esc_attr($_REQUEST[$this->_term_key]) : "#aaaaaa";
            update_woocommerce_term_meta($term_id, $this->_term_key, $data);
        }

        public function pa_color_fields_remove($term_id, $tt_id, $taxonomy)
        {
            delete_woocommerce_term_meta($term_id, $this->_term_key);
        }

        public function pa_edit_color_table_columns($columns)
        {
            $new_args = array(
                "cb" => $columns['cb'],
                "color" => esc_html__('Color', 'omeo')
            );
            unset($columns['cb']);
            return array_merge($new_args, $columns);
        }

        public function pa_edit_color_table_content($columns, $column, $id)
        {
            if (strcmp(trim($column), 'color') == 0) {
                $color = get_woocommerce_term_meta($id, $this->_term_key, true);
                $color = (isset($color) && strlen($color) > 0) ? $color : "#aaaaaa";
                ?>
                <div style="background-color: <?php echo esc_attr($color); ?>; font-size: 0; height: 22px; width: 22px; border-radius: 50%; -webkit-border-radius: 50%; box-shadow: 0 1px 1px rgba(0,0,0,0.35);">
                    NTH
                </div>
                <?php
            }
        }

    }

    new Yesshop_ShopByColor();

}