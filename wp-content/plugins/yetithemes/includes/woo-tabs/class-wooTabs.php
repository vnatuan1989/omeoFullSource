<?php

if (!class_exists('Yetithemes_WooProductOptions')) {
    class Yetithemes_WooProductOptions
    {

        private $woo_data;
        private $customTabs;
        private $prod_video;

        public $data = array(
            'prod_tab_not_empty' => false
        );

        private $_data_key = '_yesshop_wootabs';

        public function __construct()
        {
            $this->init();
        }

        public function init()
        {
            if (is_admin()) {
                $this->backend_call();
            } else {
                $this->frontend_call();
            }
        }

        public function backend_call()
        {
            //add video tab
            add_filter('woocommerce_product_data_tabs', array($this, 'woocommerce_product_custom_tabs'), 10, 1);
            //add video tab panel
            add_action('woocommerce_product_data_panels', array($this, 'woocommerce_product_video_panels'), 10);
            //add custom tab panel
            add_action('woocommerce_product_data_panels', array($this, 'woocommerce_product_custom_tab_panels'), 11);
            //save video
            add_action('woocommerce_process_product_meta', array($this, 'save_video_data'), 10, 2);
        }

        public function frontend_call()
        {
            add_filter('woocommerce_product_tabs', array($this, 'woocommer_custom_tabs'));
            add_action('woocommerce_product_thumbnails', array($this, 'woocommerce_product_video_icon'), 1);
        }

        public function woocommerce_product_video_icon() {
            if (empty($this->prod_video)) {
                global $post;
                $this->prod_video = get_post_meta($post->ID, 'yeti_product_video', true);
            }

            if (empty($this->prod_video)) return '';

            echo '<div class="mass-video-gallery">';

            foreach ($this->prod_video as $k => $data) {
                $_class = array('prod-video');
                if ($k !== 0) {
                    $_class[] = 'hidden';
                } else {
                    $_class[] = 'btn btn-default';
                }
                printf('<a class="%s" href="%s"><i class="fa fa-play" aria-hidden="true"></i></a>', esc_attr(implode(' ', $_class)), esc_url($data));
            }

            echo '</div>';
        }

        public function woocommer_custom_tabs($tabs = array())
        {
            if (empty($this->customTabs)) {
                global $product;
                $_save_key = 'yeti_product_custom_tab';
                $this->customTabs = get_post_meta($product->get_id(), $_save_key, true);
            }

            if (!empty($this->customTabs)) {
                foreach ($this->customTabs as $k => $data) {
                    $id = 'yeti-customtab-' . $k;
                    $_priority = !empty($data['custom_tab_priority'])? $data['custom_tab_priority']: 70 + $k;
                    $tabs[$id] = array(
                        'title' => sprintf('%s', esc_html($data['custom_tab_title'])),
                        'priority' => $_priority,
                        'callback' => array($this, 'woocommer_custom_callback'),
                        'hidden' => isset($data['custom_tab_hidden']) ? esc_attr($data['custom_tab_hidden']) : ''
                    );
                }
                $this->data['prod_tab_not_empty'] = true;
                add_filter('yesshop_woo_custom_tabs_init', array($this, 'customTab_applies'), 10);
            }

            return $tabs;
        }

        public function customTab_applies()
        {
            return true;
        }

        public function woocommer_custom_callback($tabID)
        {
            if (empty($this->customTabs)) {
                global $post;
                $_save_key = 'yeti_product_custom_tab';
                $this->customTabs = get_post_meta($post->ID, $_save_key, true);
            }

            $k_ = explode('-', $tabID);
            $i = $k_[count($k_) - 1];

            if (!empty($this->customTabs[$i]['custom_tab_specify'])) {
                echo wp_kses_post(stripslashes(htmlspecialchars_decode($this->customTabs[$i]['custom_tab_specify'])));
            } elseif (function_exists('Yetithemes_StaticBlock')) {
                $stb_id = $this->customTabs[$i]['custom_tab_content'];
                Yetithemes_StaticBlock()->getContentByID($stb_id);
            }

        }

        public function woocommerce_product_custom_tabs($tabs) {
            $tabs['yeti_videos'] = array(
                'label' => __('Videos', 'yetithemes'),
                'target' => 'videos_product_data',
                'class' => array(),
            );
            $tabs['yeti_custom_tab'] = array(
                'label' => __('Single Tabs', 'yetithemes'),
                'target' => 'custom_tab_product_data',
                'class' => array(),
            );

            return $tabs;
        }

        public function woocommerce_product_video_panels() {

            if (empty($this->prod_video)) {
                global $post;
                $this->prod_video = get_post_meta($post->ID, 'yeti_product_video', true);
            }

            $tbody = '<tr id="no_item"><td colspan="2"><small>' . esc_attr__('No videos found!', 'yetithemes') . '</small></td></tr>';
            if (!empty($this->prod_video) && is_array($this->prod_video)) {
                $tbody = '';
                foreach ($this->prod_video as $k => $v) {
                    $tbody .= '<tr data-index="'.absint($k).'">';
                    $tbody .= '<td class="view_code">';
                    $tbody .= '<span class="yeti-label">' . esc_url($v) . '</span>';
                    $tbody .= '</td>';
                    $tbody .= '<td><a href="#" class="dashicons-before dashicons-trash remove"></a></td>';
                    $tbody .= '</tr>';
                }

            }

            if (strlen($tbody) > 0) $tbody = "<tbody>" . $tbody . "</tbody>";
            ?>

            <div id="videos_product_data" class="panel woocommerce_options_panel">
                <div class="options_group">
                    <p><?php _e("Attached videos"); ?></p>
                    <div style="margin: 10px 12px;">
                        <table id="table_videos_html" class="wp-list-table yeti-ad-table widefat wo_di_table_videos">
                            <thead>
                            <tr>
                                <th class="yeti-table-preview"><?php _e('Preview', 'yetithemes') ?></th>
                                <th class="yeti-table-action"></th>
                            </tr>
                            </thead>
                            <?php echo $tbody; ?>
                        </table>
                    </div>

                </div>

                <div class="options_group">

                    <?php
                    // External URL
                    woocommerce_wp_text_input(array(
                        'id' => 'yeti_embcode',
                        'label' => __('Video URL', 'yetithemes'),
                        'placeholder' => 'http://',
                        'desc_tip' => true,
                        'description' => __('Enter the external URL to the youtube or vimeo.', 'yetithemes')
                    ));
                    ?>

                </div>

                <div class="options_group">
                    <p class="form-field">
                        <button id="button_add_video" class="button button-primary"><i class="dashicons-before dashicons-plus"></i><?php _e("Add Video", 'yetithemes'); ?>
                        </button>
                    </p>
                </div>

            </div>

            <?php
        }

        public function woocommerce_product_custom_tab_panels()
        {
            global $post;

            $customtab_data = get_post_meta($post->ID, 'yeti_product_custom_tab', true);

            $static_block = Yetithemes_StaticBlock()->getArgs();

            $i = 0;
            if (!empty($customtab_data) && is_array($customtab_data)) {
                $tbody = '';
                foreach ($customtab_data as $k => $v) {
                    if (empty($v['custom_tab_content'])) continue;
                    $tbody .= "<tr data-index='{$k}'>";
                    $tbody .= "<td>{$v['custom_tab_title']}</td>";
                    $tbody .= "<td>" . esc_html(get_the_title($v['custom_tab_content'])) . '</td>';
                    $tbody .= "<td><span class='yeti-label'>{$v['custom_tab_priority']}</span></td>";
                    $tbody .= "<td>";
                    foreach (explode(' ', trim($v['custom_tab_hidden'])) as $v) {
                        $tbody .= '<span class=\'yeti-label menu\'>' . esc_attr($v) . '</span>';
                    }
                    $tbody .= "</td><td><a href=\"#\" title='Remove item' class=\"dashicons-before dashicons-trash remove\"></a></td>";
                    $tbody .= "</tr>";
                    $i++;
                }

            }

            if (empty($tbody)) $tbody = "<tr id=\"no_item\"><td colspan='4'><small>" . __("No single tab found!", 'yetithemes') . "</small></td></tr>";

            ?>

            <div id="custom_tab_product_data" class="panel woocommerce_options_panel">

                <div class="options_group">

                    <h4 style="margin-left: 12px"><?php _e('Specification', 'yetithemes'); ?></h4>


                    <div class="options_group">
                        <div class="form-field" style="padding: 10px 12px">
                            <?php
                            $specify_content = (!empty($customtab_data['specify']['custom_tab_specify'])) ? stripslashes(htmlspecialchars_decode($customtab_data['specify']['custom_tab_specify'])) : '';
                            wp_editor($specify_content, 'yeti_prod_tab_specification', array('editor_height' => 200)) ?>
                        </div>
                    </div>

                    <h4 style="margin-left: 12px"><?php _e('Single tabs', 'yetithemes'); ?></h4>
                    <div style="margin: 10px 12px;">
                        <table id="table_customtabs_html" class="yeti-ad-table wp-list-table widefat wo_di_table_tabs">
                            <thead>
                            <tr>
                                <th class="yeti-customtab-title"><?php _e('Title', '') ?></th>
                                <th class="yeti-customtab-staticblock"><?php _e('Static block', 'yetithemes') ?></th>
                                <th><?php esc_html_e('Priority', 'yetithemes')?></th>
                                <th class="yeti-customtab-staticblock" width="200"><?php _e('Classes', 'yetithemes') ?></th>
                                <th class="yeti-table-action"></th>
                            </tr>
                            </thead>
                            <tbody><?php echo wp_kses_post($tbody); ?></tbody>

                        </table>
                    </div>
                </div>

                <div class="options_group">
                    <p class="form-field">
                        <label><?php _e('Tab title', 'yetithemes'); ?></label>
                        <input type="text" id="yeti_prod_tab_title_adding"/>
                    </p>
                    <?php
                    $stb_args = array();
                    foreach ($static_block as $stb) {
                        $stb_args[$stb['id']] = esc_html($stb['title']);
                    }
                    woocommerce_wp_select(array(
                        'id' => 'yeti_prod_tab_content_adding',
                        'label' => __('Static block', 'yetithemes'),
                        'options' => $stb_args,
                        'desc_tip' => true,
                        'description' => __('Please create a Static Block before select it in here.', 'yetithemes')));

                    woocommerce_wp_text_input(array(
                        'id' => 'yeti_prod_tab_classes',
                        'label' => __('Extra classes', 'yetithemes'),
                        'placeholder' => 'hidden-xs, hidden-sm,...',
                    ));
                    ?>

                    <p class="form-field">
                        <label><?php _e('Priority', 'yetithemes'); ?></label>
                        <input type="number" placeholder="Default is 70" name="yeti_prod_tab_priority" id="yeti_prod_tab_priority">
                    </p>

                </div>

                <div class="options_group">
                    <p class="form-field">
                        <button id="button_add_customtab" class="button button-primary"><?php _e("Add Single Tab", 'yetithemes'); ?></button>
                    </p>
                </div>

            </div>

            <?php
        }

        public function save_video_data($post_id, $post)
        {
            $up_data = array(
                'woo_video' => array(),
                'custom_tab' => array()
            );

            if ($data = $_POST['yeti_woovideos']) {
                $up_data['woo_video'] = $data;
            }

            $_save_key = 'yeti_product_custom_tab';
            $_datas = get_post_meta($post_id, $_save_key, true);

            if (!empty($_POST['yeti_prod_tab_specification'])) {
                $_datas['specify'] = array(
                    'custom_tab_title' => esc_attr__('Specification', 'yetithemes'),
                    'custom_tab_specify' => wp_slash(esc_html($_POST['yeti_prod_tab_specification'])),
                    'custom_tab_priority' => 1
                );
            }

            update_post_meta($post_id, $_save_key, $_datas);

            update_post_meta($post_id, $this->_data_key, $up_data);
        }


    }

    new Yetithemes_WooProductOptions();
}