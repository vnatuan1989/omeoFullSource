<?php

if (!class_exists('Yesshop_WooAttrBrand')) {

    class Yesshop_WooAttrBrand
    {

        private $woo_ready = false;
        private $_slug = '';
        private $_term_key = '_pa_brand_data';
        private static $_instance = null;

        public static function get_instance()
        {
            if (self::$_instance === null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

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

            $_slug = 'brand';
            $attribute_name = isset($_slug) ? wc_sanitize_taxonomy_name(stripslashes((string)$_slug)) : '';
            $attribute_name = wc_attribute_taxonomy_name($attribute_name);
            $attribute_name_array = wc_get_attribute_taxonomy_names();
            $taxonomy_exists = in_array($attribute_name, $attribute_name_array);

            if ($taxonomy_exists) {
                $this->_slug = $attribute_name;
                add_action('admin_enqueue_scripts', array($this, 'enqueue_script'));
                $this->be_custom();
            }

        }

        public function enqueue_script()
        {
        }

        public function be_custom()
        {
            $_edit_hook = $this->_slug . '_edit_form_fields';
            $_add_hook = $this->_slug . '_add_form_fields';
            /*Add template*/
            add_action($_edit_hook, array($this, 'pa_edit_attribute'), 100000, 2);
            add_action($_add_hook, array($this, 'pa_add_attribute'), 100000);

            add_action('created_term', array($this, 'pa_color_fields_save'), 10, 3);
            add_action('edit_term', array($this, 'pa_color_fields_save'), 10, 3);
            add_action('delete_term', array($this, 'pa_color_fields_remove'), 10, 3);

            //table
            $_edit_table_hook = 'manage_edit-' . $this->_slug . '_columns';
            $_edit_table_content_hook = 'manage_' . $this->_slug . '_custom_column';

            add_filter($_edit_table_hook, array($this, "pa_edit_brand_table_columns"));
            add_filter($_edit_table_content_hook, array($this, 'pa_edit_brand_table_content'), 10, 3);
        }

        public function pa_edit_attribute($term, $taxonomy)
        {
            $thumbnail_id = get_woocommerce_term_meta($term->term_id, $this->_term_key, true);

            if ($thumbnail_id) {
                $image = wp_get_attachment_thumb_url($thumbnail_id);
            } else {
                $image = wc_placeholder_img_src();
            }

            ?>
            <tr class="form-field">
                <th scope="row" valign="top"><label><?php esc_attr_e('Thumbnail', 'omeo'); ?></label></th>
                <td>
                    <div id="product_brand_thumbnail"><img src="<?php echo esc_url($image); ?>" width="60" height="60"/></div>
                    <div>
                        <input type="hidden" id="product_brand_thumbnail_id" name="<?php echo esc_attr($this->_term_key); ?>" value="<?php echo $thumbnail_id; ?>"/>
                        <button type="button" class="upload_image_button button"><?php esc_attr_e('Upload/Add image', 'omeo'); ?></button>
                        <button type="button" class="remove_image_button button"><?php esc_attr_e('Remove image', 'omeo'); ?></button>
                    </div>
                    <script type="text/javascript">

                        // Only show the "remove image" button when needed
                        if ('0' === jQuery('#product_brand_thumbnail_id').val()) {
                            jQuery('.remove_image_button').hide();
                        }

                        // Uploading files
                        var file_frame;

                        jQuery(document).on('click', '.upload_image_button', function (event) {

                            event.preventDefault();

                            // If the media frame already exists, reopen it.
                            if (file_frame) {
                                file_frame.open();
                                return;
                            }

                            // Create the media frame.
                            file_frame = wp.media.frames.downloadable_file = wp.media({
                                title: '<?php esc_attr_e("Choose an image", 'omeo'); ?>',
                                button: {
                                    text: '<?php esc_attr_e("Use image", 'omeo'); ?>'
                                },
                                multiple: false
                            });

                            // When an image is selected, run a callback.
                            file_frame.on('select', function () {
                                var attachment = file_frame.state().get('selection').first().toJSON();

                                jQuery('#product_brand_thumbnail_id').val(attachment.id);
                                jQuery('#product_brand_thumbnail').find('img').attr('src', attachment.sizes.thumbnail.url);
                                jQuery('.remove_image_button').show();
                            });

                            // Finally, open the modal.
                            file_frame.open();
                        });

                        jQuery(document).on('click', '.remove_image_button', function () {
                            jQuery('#product_brand_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                            jQuery('#product_brand_thumbnail_id').val('');
                            jQuery('.remove_image_button').hide();
                            return false;
                        });

                    </script>
                    <div class="clear"></div>
                </td>
            </tr>

            <?php
        }

        public function pa_add_attribute()
        {
            ?>
            <div class="form-field form-required">
                <label><?php esc_attr_e('Brand Thumbnail', 'omeo'); ?></label>
                <div id="product_brand_thumbnail"><img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" width="60" height="60"/></div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="product_brand_thumbnail_id"
                           name="<?php echo esc_attr($this->_term_key); ?>"/>
                    <button type="button"
                            class="upload_image_button button"><?php esc_attr_e('Upload/Add image', 'omeo'); ?></button>
                    <button type="button"
                            class="remove_image_button button"><?php esc_attr_e('Remove image', 'omeo'); ?></button>
                </div>
                <script type="text/javascript">

                    // Only show the "remove image" button when needed
                    if (!jQuery('#product_brand_thumbnail_id').val()) {
                        jQuery('.remove_image_button').hide();
                    }

                    // Uploading files
                    var file_frame;

                    jQuery(document).on('click', '.upload_image_button', function (event) {

                        event.preventDefault();

                        // If the media frame already exists, reopen it.
                        if (file_frame) {
                            file_frame.open();
                            return;
                        }

                        // Create the media frame.
                        file_frame = wp.media.frames.downloadable_file = wp.media({
                            title: '<?php esc_attr_e("Choose an image", 'omeo'); ?>',
                            button: {
                                text: '<?php esc_attr_e("Use image", 'omeo'); ?>'
                            },
                            multiple: false
                        });

                        // When an image is selected, run a callback.
                        file_frame.on('select', function () {
                            var attachment = file_frame.state().get('selection').first().toJSON();

                            jQuery('#product_brand_thumbnail_id').val(attachment.id);
                            jQuery('#product_brand_thumbnail').find('img').attr('src', attachment.sizes.thumbnail.url);
                            jQuery('.remove_image_button').show();
                        });

                        // Finally, open the modal.
                        file_frame.open();
                    });

                    jQuery(document).on('click', '.remove_image_button', function () {
                        jQuery('#product_brand_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                        jQuery('#product_brand_thumbnail_id').val('');
                        jQuery('.remove_image_button').hide();
                        return false;
                    });

                </script>
                <div class="clear"></div>

                <p>Use color picker to pick one color.</p>
            </div>
            <?php
        }

        public function pa_color_fields_save($term_id, $tt_id, $taxonomy)
        {
            $data = isset($_REQUEST[$this->_term_key]) ? esc_attr($_REQUEST[$this->_term_key]) : "";
            update_woocommerce_term_meta($term_id, $this->_term_key, $data);
        }

        public function pa_color_fields_remove($term_id, $tt_id, $taxonomy)
        {
            delete_woocommerce_term_meta($term_id, $this->_term_key);
        }

        public function pa_edit_brand_table_columns($columns)
        {
            $new_args = array();
            if(isset($columns['cb'])) {
                $new_args = array(
                    "cb" => $columns['cb'],
                    'thumbnail' => esc_html__('Thumbnail', 'omeo')
                );
                unset($columns['cb']);
            }
            return array_merge($new_args, $columns);
        }

        public function pa_edit_brand_table_content($columns, $column, $id)
        {
            if (strcmp(trim($column), 'thumbnail') == 0) {
                $thumbnail_id = get_woocommerce_term_meta($id, $this->_term_key, true);
                if ($thumbnail_id) {
                    $image = wp_get_attachment_thumb_url($thumbnail_id);
                } else {
                    $image = wc_placeholder_img_src();
                }
                $image = str_replace(' ', '%20', $image);

                $columns .= '<img src="' . esc_url($image) . '" alt="' . esc_attr__('Thumbnail', 'omeo') . '" class="wp-post-image" height="48" width="48" />';
            }
            return $columns;
        }

    }

    new Yesshop_WooAttrBrand();

}