<?php


if (!class_exists('Yetithemes_List_Grid')) {

    class Yetithemes_List_Grid {

        public function __construct() {

            add_action('wp', array($this, 'setup_gridlist'), 20);

            // Init settings
            $this->settings = array(
                array(
                    'name' => __('Default catalog view', 'yetithemes'),
                    'type' => 'title',
                    'id' => 'wc_glt_options'
                ),
                array(
                    'name' => __('Default catalog view', 'yetithemes'),
                    'desc_tip' => __('Display products in grid or list view by default', 'yetithemes'),
                    'id' => 'wc_glt_default',
                    'type' => 'select',
                    'options' => array(
                        'grid' => __('Grid', 'yetithemes'),
                        'list' => __('List', 'yetithemes'),
                        'table' => __('Table', 'yetithemes')
                    )
                ),
                array('type' => 'sectionend', 'id' => 'wc_glt_options'),
            );

            // Default options
            add_option('wc_glt_default', 'grid');

            // Admin
            add_action('woocommerce_settings_image_options_after', array($this, 'admin_settings'), 20);
            add_action('woocommerce_update_options_catalog', array($this, 'save_admin_settings'));
            add_action('woocommerce_update_options_products', array($this, 'save_admin_settings'));
        }

        /*-----------------------------------------------------------------------------------*/
        /* Class Functions */
        /*-----------------------------------------------------------------------------------*/

        function admin_settings()
        {
            woocommerce_admin_fields($this->settings);
        }

        function save_admin_settings()
        {
            woocommerce_update_options($this->settings);
        }

        // Setup
        function setup_gridlist()
        {
            if (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy()) {
                add_action('woocommerce_before_shop_loop', array($this, 'gridlist_toggle_button'), 20);
                add_action('woocommerce_after_subcategory', array($this, 'gridlist_cat_desc'));

                add_filter('yesshop_woocommerce_loop_start_class', array($this, 'product_loop_class_filter'), 10);
            }
        }

        // Toggle button
        function gridlist_toggle_button() {
            $default = get_option('wc_glt_default', 'grid');
            if (empty($default)) $default = 'grid';
            if(trim($default) === 'grid') {
                $_grid_c = 'gridlist-btn active';
                $_list_c = 'gridlist-btn';
            } else {
                $_grid_c = 'gridlist-btn';
                $_list_c = 'gridlist-btn active';
            }
            ?>
            <!-- hugo grid/list toggle-->
            <div class="gridlist-toggle hidden-xs">
                <a href="#" class="<?php echo esc_attr($_grid_c)?>" id="grid" data-toggle="tooltip" title="<?php _e('Grid view', 'yetithemes'); ?>"><span class="th-grid"></span> <em><?php _e('Grid view', 'yetithemes'); ?></em></a>
                <a href="#" class="<?php echo esc_attr($_list_c)?>" id="list" data-toggle="tooltip" title="<?php _e('List view', 'yetithemes'); ?>"><span class="th-list"></span> <em><?php _e('List view', 'yetithemes'); ?></em></a>
            </div>
            <?php
        }

        // Button wrap
        function gridlist_buttonwrap_open() {
            echo '<div class="gridlist-buttonwrap">';
        }

        function gridlist_buttonwrap_close() {
            echo '</div>';
        }

        function gridlist_hr() {
            echo '<hr/>';
        }

        function product_loop_class_filter($classes)
        {
            $default = get_option('wc_glt_default');
            if (strlen(trim($default)) > 0) $classes .= ' gridlist-action ' . $default;

            return $classes;
        }

        function gridlist_cat_desc($category)
        {
            global $woocommerce;
            echo '<div class="loop-description">';
            echo $category->description;
            echo '</div>';

        }
    }

    new Yetithemes_List_Grid();
}

