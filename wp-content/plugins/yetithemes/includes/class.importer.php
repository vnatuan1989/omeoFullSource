<?php

if (!class_exists('Yetithemes_Importer')) {
    class Yetithemes_Importer
    {

        private $data_key,
            $_slider_download,
            $_download_dummy,
            $_local_dummy,
            $_api_uri = 'http://demo.nexthemes.com/verify_purchases/api',
            $_purchase_code = 'cykec1i0-hl35-3807-blic-pl9ns08684cb',
            $_upload_dir,
            $_local_dummy_uri,
            $server_ip,
            $_bg_color;

        public static $instance;

        public static function get_instance()
        {
            if (self::$instance === null) {
                self::$instance = new Yetithemes_Importer();
            }
            return self::$instance;
        }

        public function init()
        {
            $this->setDatas();
        }

        private function _setUploadDir()
        {
            $upload_dir = wp_upload_dir();
            $upload_dir = $upload_dir['basedir'] . '/omeo';
            if (!file_exists($upload_dir)) {
                wp_mkdir_p($upload_dir);
            }

            return $upload_dir;
        }

        public function setDatas()
        {
            $this->_slider_download = 'http://demo.nexthemes.com/wordpress/downloads/omeo/sliders/';
            $this->_download_dummy = 'http://demo.nexthemes.com/wordpress/downloads/omeo';
            $this->_local_dummy = get_template_directory() . '/framework/backend/incs/dummy';
            $this->_local_dummy_uri = get_template_directory_uri() . "/framework/backend/incs/dummy";
            $this->_upload_dir = $this->_setUploadDir();
            //$this->server_ip = '108.61.207.13';
            $this->server_ip = 'demo.nexthemes.com';

            $this->data_key = array(
                'dummy' => 'yeti_dummy_installed',
                'home_dmm' => 'yeti_home_dummy',
                'rev' => 'yeti_home_install_rev',
                'menu' => 'yeti_home_install_menu',
                'reading' => 'yeti_home_install_reading',
                'woo' => 'yeti_cofig_woo_page',
                'widget' => 'yeti_import_widgets',
                'home' => 'yeti_home_importing',
                'imported' => 'yeti_theme_imported',
                'current' => 'yeti_theme_current',
                'cms_imported'  => 'yeti_cms_imported'
            );

            $this->_bg_color = array(
                1 => array('background_color' => 'ffffff'),
                2 => array('background_color' => 'ffffff'),
                3 => array('background_color' => 'ffffff'),
                4 => array('background_color' => 'ffffff'),
                5 => array('background_color' => 'ffffff'),
                6 => array('background_color' => 'ffffff'),
                7 => array('background_color' => 'ffffff'),
                8 => array('background_color' => 'f4f4f4'),
                9 => array(
                    'background_color'      => 'ff9a6e',
                    'background_image'      => get_theme_file_uri('images/home9-background.jpg'),
                    'background_repeat'     => 'no-repeat',
                    'background_position_x' => 'center'
                ),
            );
        }

        public function resg_system()
        {
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
        }

        public static function checkImportfiles($slug, $path = 'homepage')
        {
            $return = false;
            $dumm_fol = get_template_directory() . "/framework/backend/incs/dummy";

            switch ($path) {
                case 'cms':
                    $dumm_home = $dumm_fol . "/cms/{$slug}.xml";
                    $image = get_template_directory() . "/framework/backend/images/imports/{$slug}.png";
                    if (file_exists($dumm_home) && file_exists($image)) $return = true;
                    break;
                default:
                    $dumm_home = $dumm_fol . "/dumm_home/home{$slug}.xml";
                    $redux_options = $dumm_fol . "/redux/redux_options_{$slug}.json";
                    $widgets = $dumm_fol . "/widgets/widget_home{$slug}.wie";
                    $image = get_template_directory() . "/framework/backend/images/imports/home-iwrap{$slug}.png";
                    if (file_exists($dumm_home) && file_exists($redux_options) && file_exists($widgets) && file_exists($image)) $return = true;
            }
            return $return;
        }

        public function getThemeHomepages() {
            $homepage_args = array(
                'homepages' => array(
                    1 => array(
                        'name' => 'Home page 1',
                        'pl_request' => array('woocommerce', 'js_composer', 'redux-framework'),
                        'url' => 'site/'
                    ),
                    2 => array(
                        'name' => 'Home page 2',
                        'pl_request' => array('woocommerce', 'js_composer', 'redux-framework'),
                        'url' => 'site/omeo-home-page-2/?preview=2'
                    ),
                    3 => array(
                        'name' => 'Home page 3',
                        'pl_request' => array('woocommerce', 'js_composer', 'redux-framework'),
                        'url' => 'site/omeo-home-page-3/?preview=3'
                    ),
                    4 => array(
                        'name' => 'Home page 4',
                        'pl_request' => array('woocommerce', 'js_composer', 'redux-framework'),
                        'url' => 'site/omeo-home-page-4/?preview=4'
                    ),
                    5 => array(
                        'name' => 'Home page 5',
                        'pl_request' => array('woocommerce', 'js_composer', 'redux-framework'),
                        'url' => 'site/omeo-home-page-5/?preview=5'
                    ),
                    6 => array(
                        'name' => 'Home page 6',
                        'pl_request' => array('woocommerce', 'js_composer', 'redux-framework'),
                        'url' => 'site/omeo-home-page-6/?preview=6'
                    ),
                    7 => array(
                        'name' => 'Home page 7',
                        'pl_request' => array('woocommerce', 'js_composer', 'redux-framework'),
                        'url' => 'site/omeo-home-page-7/?preview=7'
                    ),
                    8 => array(
                        'name' => 'Home page 8',
                        'pl_request' => array('woocommerce', 'js_composer', 'redux-framework'),
                        'url' => 'site/omeo-home-page-8/?preview=8'
                    ),
                    9 => array(
                        'name' => 'Home page 9',
                        'pl_request' => array('woocommerce', 'js_composer', 'redux-framework'),
                        'url' => 'site/omeo-home-page-9/?preview=9'
                    ),
                    10 => array(
                        'name' => 'Home page 10',
                        'pl_request' => array('woocommerce', 'js_composer', 'redux-framework'),
                        'url' => 'site/omeo-home-page-10/?preview=10'
                    )
                ),
                'req_plugins' => array(
                    'woocommerce' => array('class' => 'WooCommerce', 'name' => 'Woocommerce'),
                    'js_composer' => array('class' => 'Vc_Manager', 'name' => 'WPBakery Visual Composer'),
                    'redux-framework' => array('class' => 'ReduxFrameworkPlugin', 'name' => 'Redux Framework'),
                    'revslider' => array('class' => 'RevSliderFront', 'name' => 'Slider Revolution'),
                    'Ultimate_VC_Addons' => array('class' => 'Ultimate_VC_Addons', 'name' => 'Ultimate Addons for VC'),
                )
            );

            foreach ($homepage_args['req_plugins'] as $k => $plugin) {
                if (class_exists($plugin['class'])) {
                    $homepage_args['req_plugins'][$k]['status'] = true;
                } else {
                    $homepage_args['req_plugins'][$k]['status'] = false;
                }
            }

            return $homepage_args;
        }

        public function getCMSPages(){
            $cms = array();

            if(class_exists('Yetithemes_Gallery')) {
                $cms['cms-galleries'] = array(
                    'name'  => 'CMS - Galleries data',
                    'class_request' => array('Yetithemes_Gallery'),
                    'url'   => 'site/galleries'
                );
            }

            if(class_exists('Yetithemes_Portfolio')) {
                $cms['cms-portfolio'] = array(
                    'name'  => 'CMS - Portfolio data',
                    'class_request' => array('Yetithemes_Gallery'),
                    'url'   => 'site/portfolio'
                );
            }

            if(class_exists('WPCF7')) {
                $cms['cms-contacts'] = array(
                    'name'  => 'CMS - Contact Us',
                    'class_request' => array(),
                    'url'   => 'site/contact-us'
                );
            }

            if(class_exists('WPCF7')) {
                $cms['cms-contacts'] = array(
                    'name'  => 'CMS - Contact Us',
                    'class_request' => array(),
                    'url'   => 'site/contact-us'
                );
            }

            return $cms;
        }

        public function checkContention()
        {
            $fp = @fsockopen($this->server_ip, 80, $errno, $errstr, 30);
            if (!$fp) {
                return false;
            } else {
                @fclose($fp);
                return true;
            }
        }

        public function update_options($key, $val)
        {
            $data = get_option($key);
            if (isset($data)) update_option($key, $val);
            else add_option($key, $val);
        }

        public function wpImport()
        {
            $res = true;
            if (!class_exists('WP_Importer')) {
                $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
                if (file_exists($class_wp_importer)) {
                    include $class_wp_importer;
                } else {
                    $res = false;
                }
            }
            if (!class_exists('WP_Import')) {
                $class_wp_import = dirname(__FILE__) . '/wordpress-importer.php';
                if (file_exists($class_wp_import)) include $class_wp_import;
                else $res = false;
            }

            return $res;
        }

        public function import_dummy($dummy_xml)
        {
            if (!current_user_can('manage_options')) return 'permission denied';

            if (!defined('WP_LOAD_IMPORTERS')) define('WP_LOAD_IMPORTERS', true);

            $lib = $this->wpImport();

            if (!$lib) {
                return "The Auto importing script could't be loaded. Please use the wordpress importer and import the XML file.";
            } elseif (file_exists($dummy_xml)) {
                $importer = new WP_Import();
                $importer->fetch_attachments = true;
                ob_start();
                $importer->import($dummy_xml);
                return ob_end_clean();
            } else {
                return $dummy_xml . ' not exist!';
            }

        }

        private function available_widgets()
        {
            global $wp_registered_widget_controls;
            $widget_controls = $wp_registered_widget_controls;
            $available_widgets = array();
            foreach ($widget_controls as $widget) {
                if (!empty($widget['id_base']) && !isset($available_widgets[$widget['id_base']])) {
                    $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
                    $available_widgets[$widget['id_base']]['name'] = $widget['name'];
                }
            }

            return $available_widgets;
        }

        private function _del_hello_post(){
            wp_delete_post(1);
        }

        public function import_main_dummy()
        {
            check_ajax_referer('__THEME_IMPORT_5362', 'security');
            set_time_limit(0);

            $this->init();

            if (!$this->checkContention()) wp_die('connect_error');

            if (YetiThemes_Extra()->checkPlugin('wordpress-importer/wordpress-importer.php')) {
                wp_die('wp_import_exist');
            }

            $dummy_installed = get_option($this->data_key['dummy']);
            if (absint($dummy_installed)) wp_die('installed');
            $dummy_folder = get_template_directory() . "/framework/backend/incs/dummy";
            $dummy_xml = $dummy_folder . "/dummy_data.xml";

            if (class_exists('WooCommerce')) {
                $woopage = get_page_by_title('shop');
                if (!isset($woopage->ID) || absint($woopage->ID) <= 0) {
                    $dummy_xml = $dummy_folder . "/dummy_data_woo.xml";
                }
            }
            $this->update_options($this->data_key['dummy'], 1);
            $this->_del_hello_post();
            echo $this->import_dummy($dummy_xml);

            wp_die();
        }

        public function import_home_dummy($home = 1)
        {
            $page_title = 'Omeo Home page ' . $home;
            $homepage = get_page_by_title($page_title);
            if (!isset($homepage) || !$homepage->ID) {
                $xml_file = $this->_local_dummy . "/dumm_home/home{$home}.xml";
                if (strlen($xml_file) > 0) {
                    return $this->import_dummy($xml_file);
                }
            }
        }

        public function clearWidgets()
        {
            $sidebars_widgets = get_option('sidebars_widgets');
            foreach ($sidebars_widgets as $k => $v) {
                $sidebars_widgets[$k] = array();
            }

            update_option('sidebars_widgets', $sidebars_widgets);
        }

        public function import_widget($home = 1)
        {
            global $wp_registered_sidebars;
            switch (absint($home)) {
                default:
                    $file_num = $home;
            }
            $file = get_template_directory() . "/framework/backend/incs/dummy/widgets/widget_home{$file_num}.wie";
            $data = file_get_contents($file);
            $data = json_decode($data);
            if (empty($data) || !is_object($data)) {
                return "Import widgets data could not be read. Please contact to support team.";
            }

            $this->clearWidgets();

            $available_widgets = $this->available_widgets();

            $widget_instances = array();
            foreach ($available_widgets as $widget_data) {
                $widget_instances[$widget_data['id_base']] = get_option('widget_' . $widget_data['id_base']);
            }

            $results = array();
            foreach ($data as $sidebar_id => $widgets) {
                // Skip inactive widgets
                // (should not be in export file)
                if ('wp_inactive_widgets' == $sidebar_id) {
                    continue;
                }

                // Check if sidebar is available on this site
                // Otherwise add widgets to inactive, and say so
                if (isset($wp_registered_sidebars[$sidebar_id])) {
                    $sidebar_available = true;
                    $use_sidebar_id = $sidebar_id;
                    $sidebar_message_type = 'success';
                    $sidebar_message = '';
                } else {
                    $sidebar_available = false;
                    $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
                    $sidebar_message_type = 'error';
                    $sidebar_message = __('Sidebar does not exist in theme (using Inactive)', 'yetithemes');
                }

                // Result for sidebar
                $results[$sidebar_id]['name'] = !empty($wp_registered_sidebars[$sidebar_id]['name']) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
                $results[$sidebar_id]['message_type'] = $sidebar_message_type;
                $results[$sidebar_id]['message'] = $sidebar_message;
                $results[$sidebar_id]['widgets'] = array();

                // Loop widgets
                foreach ($widgets as $widget_instance_id => $widget) {
                    $fail = false;
                    // Get id_base (remove -# from end) and instance ID number
                    $id_base = preg_replace('/-[0-9]+$/', '', $widget_instance_id);
                    $instance_id_number = str_replace($id_base . '-', '', $widget_instance_id);

                    // Does site support this widget?
                    if (!$fail && !isset($available_widgets[$id_base])) {
                        $fail = true;
                        $widget_message_type = 'error';
                        $widget_message = __('Site does not support widget', 'yetithemes'); // explain why widget not imported
                    }

                    $widget = apply_filters('wie_widget_settings', $widget); // object

                    $widget = json_decode(json_encode($widget), true);
                    $widget = apply_filters('wie_widget_settings_array', $widget);

                    if (!$fail && isset($widget_instances[$id_base])) {
                        $sidebars_widgets = get_option('sidebars_widgets');
                        $sidebar_widgets = isset($sidebars_widgets[$use_sidebar_id]) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

                        $single_widget_instances = !empty($widget_instances[$id_base]) ? $widget_instances[$id_base] : array();
                        foreach ($single_widget_instances as $check_id => $check_widget) {
                            if (in_array("$id_base-$check_id", $sidebar_widgets) && (array)$widget == $check_widget) {
                                $fail = true;
                                $widget_message_type = 'warning';
                                $widget_message = __('Widget already exists', 'yetithemes'); // explain why widget not imported

                                break;
                            }
                        }

                    }

                    if (!$fail) {
                        // Add widget instance
                        $single_widget_instances = get_option('widget_' . $id_base); // all instances for that widget ID base, get fresh every time
                        $single_widget_instances = !empty($single_widget_instances) ? $single_widget_instances : array('_multiwidget' => 1); // start fresh if have to
                        $single_widget_instances[] = $widget; // add it

                        // Get the key it was given
                        end($single_widget_instances);
                        $new_instance_id_number = key($single_widget_instances);

                        // If key is 0, make it 1
                        // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
                        if ('0' === strval($new_instance_id_number)) {
                            $new_instance_id_number = 1;
                            $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
                            unset($single_widget_instances[0]);
                        }

                        // Move _multiwidget to end of array for uniformity
                        if (isset($single_widget_instances['_multiwidget'])) {
                            $multiwidget = $single_widget_instances['_multiwidget'];
                            unset($single_widget_instances['_multiwidget']);
                            $single_widget_instances['_multiwidget'] = $multiwidget;
                        }

                        // Update option with new widget
                        update_option('widget_' . $id_base, $single_widget_instances);

                        // Assign widget instance to sidebar
                        $sidebars_widgets = get_option('sidebars_widgets'); // which sidebars have which widgets, get fresh every time
                        $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
                        $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
                        update_option('sidebars_widgets', $sidebars_widgets); // save the amended data

                        // After widget import action
                        $after_widget_import = array(
                            'sidebar' => $use_sidebar_id,
                            'sidebar_old' => $sidebar_id,
                            'widget' => $widget,
                            'widget_type' => $id_base,
                            'widget_id' => $new_instance_id,
                            'widget_id_old' => $widget_instance_id,
                            'widget_id_num' => $new_instance_id_number,
                            'widget_id_num_old' => $instance_id_number
                        );
                        do_action('wie_after_widget_import', $after_widget_import);

                        // Success message
                        if ($sidebar_available) {
                            $widget_message_type = 'success';
                            $widget_message = __('Imported', 'yetithemes');
                        } else {
                            $widget_message_type = 'warning';
                            $widget_message = __('Imported to Inactive', 'yetithemes');
                        }

                    }

                    // Result for widget instance
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset($available_widgets[$id_base]['name']) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = !empty($widget['title']) ? $widget['title'] : __('No Title', 'yetithemes'); // show "No Title" if widget instance is untitled
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

                }
            }

            return "Widgets imported to Inactive!";

        }

        public function import_redux($home = 1)
        {
            global $yesshop_datas;
            $res = array();

            $import_url = $this->_local_dummy_uri . "/redux/redux_options_{$home}.json";

            if (strlen($import_url) > 0) {

                $import = wp_remote_retrieve_body(wp_remote_get($import_url));
                if (!empty ($import)) $im_import = json_decode($import, true);
                else $im_import = $yesshop_datas;

                $footer_home = $home;

                switch ($home) {
                    case 1:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-1.png');
                        $im_import['logo']['width'] = 114;
                        $im_import['logo']['height'] = 116;

                        $im_import['header-style'] = '1';
                        $im_import['fullwidth-header'] = '1';
                        break;
                    case 2:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-1.png');
                        $im_import['logo']['width'] = 96;
                        $im_import['logo']['height'] = 96;

                        $im_import['header-style'] = '2';
                        $im_import['fullwidth-header'] = '0';
                        $im_import['color-stylesheet'] = 'home-2';
                        break;
                    case 3:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-1.png');
                        $im_import['logo']['width'] = 135;
                        $im_import['logo']['height'] = 90;

                        $im_import['logo-absolute']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-3.png');
                        $im_import['logo-absolute']['width'] = 135;
                        $im_import['logo-absolute']['height'] = 90;

                        $im_import['header-style'] = '3';
                        $im_import['fullwidth-header'] = '1';
                        $im_import['absolute-header'] = '1';
                        $im_import['color-stylesheet'] = 'home-3';
                        break;
                    case 4:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-1.png');
                        $im_import['logo']['width'] = 324;
                        $im_import['logo']['height'] = 54;

                        $im_import['logo-absolute']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-3.png');
                        $im_import['logo-absolute']['width'] = 324;
                        $im_import['logo-absolute']['height'] = 54;

                        $im_import['header-style'] = '4';
                        $im_import['fullwidth-header'] = '1';
                        $im_import['absolute-header'] = '1';
                        $im_import['color-stylesheet'] = 'home-4';
                        $im_import['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                        break;
                    case 5:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-5.png');
                        $im_import['logo']['width'] = 86;
                        $im_import['logo']['height'] = 69;

                        $footer_home = 4;
                        $im_import['header-style'] = '5';
                        $im_import['fullwidth-header'] = '1';
                        $im_import['absolute-header'] = '0';
                        $im_import['color-stylesheet'] = 'home-5';
                        $im_import['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                        break;
                    case 6:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-5.png');
                        $im_import['logo']['width'] = 86;
                        $im_import['logo']['height'] = 69;

                        $im_import['header-style'] = '6';
                        $im_import['fullwidth-header'] = '0';
                        $im_import['absolute-header'] = '0';
                        $im_import['color-stylesheet'] = 'home-6';
                        $im_import['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                        break;
                    case 7:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-5.png');
                        $im_import['logo']['width'] = 86;
                        $im_import['logo']['height'] = 69;

                        $footer_home = 3;
                        $im_import['header-style'] = '5';
                        $im_import['fullwidth-header'] = '1';
                        $im_import['absolute-header'] = '0';
                        $im_import['color-stylesheet'] = 'home-7';
                        $im_import['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                        break;
                    case 8:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-5.png');
                        $im_import['logo']['width'] = 86;
                        $im_import['logo']['height'] = 69;

                        $im_import['logo-absolute']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-5.png');
                        $im_import['logo-absolute']['width'] = 86;
                        $im_import['logo-absolute']['height'] = 69;

                        $footer_home = 4;
                        $im_import['header-style'] = '5';
                        $im_import['fullwidth-header'] = '1';
                        $im_import['absolute-header'] = '1';
                        $im_import['color-stylesheet'] = 'home-8';
                        $im_import['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                        break;
                    case 9:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-1.png');
                        $im_import['logo']['width'] = 96;
                        $im_import['logo']['height'] = 99;

                        $im_import['header-style'] = '7';
                        $im_import['fullwidth-header'] = '0';
                        $im_import['absolute-header'] = '0';
                        $im_import['color-stylesheet'] = 'home-9';
                        $im_import['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><div><span>CALL US NOW</span></br><span class="yt-color-primary">034 2333 3444</span></div></div>';
                        break;
                    case 10:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-5.png');
                        $im_import['logo']['width'] = 86;
                        $im_import['logo']['height'] = 69;

                        $footer_home = 4;
                        $im_import['header-style'] = '5';
                        $im_import['fullwidth-header'] = '1';
                        $im_import['absolute-header'] = '0';
                        $im_import['color-stylesheet'] = 'home-10';
                        $im_import['header-shipping-text'] = '<div class="yt-phone"><i class="fa fa-phone"></i><span>034 2333 3444</span></div>';
                        $im_import['product-item-style'] = 'classic-2';
                        break;
                    default:
                        $im_import['logo']['url'] = esc_url(THEME_IMG_URI . 'omeo-logo-'.$home.'.png');
                        $im_import['logo']['width'] = 86;
                        $im_import['logo']['height'] = 69;

                }

                $footer_page = get_page_by_title('Omeo Footer Layout ' . absint($footer_home), OBJECT, 'static_block');
                if (isset($footer_page) && $footer_page->ID) {
                    $im_import['footer-stblock'] = $footer_page->ID;
                }

                update_option('yesshop_datas', $im_import);
                $res['msg'] .= 'Redux options imported!';
            }

           /* if(function_exists('bsf_update_option')) {
                bsf_update_option('ultimate_global_scripts', 'enable');
            }*/

            return $res;
        }

        public function _download_slider($slider_name)
        {
            $tmp_path = $this->_setUploadDir();
            $_request = wp_remote_post($this->_slider_download . "{$slider_name}.zip", array('timeout' => 45));
            if (isset($_request['response']) && strcmp(trim($_request['response']['code']), '200') == 0) {
                $_downslider_data = wp_remote_retrieve_body($_request);
                if (!empty($_downslider_data)) {
                    if (file_put_contents($tmp_path . "/{$slider_name}.zip", $_downslider_data)) {
                        return $tmp_path . "/{$slider_name}.zip";
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function import_revolution($home)
        {
            $res = array(
                'status' => true,
                'msg' => ''
            );

            // home 10 have not slider
            if( absint($home) == 10) return $res;

            if (class_exists('UniteFunctionsRev') && class_exists('ZipArchive')) {
                $updateAnim = true;
                $updateStatic = true;
                $slider_keys = array(
                    "omeo-revolution-{$home}"
                );

                $slider = new RevSlider();

                foreach ($slider_keys as $s_key) {
                    if ($slider->isAliasExists($s_key)) continue;

                    $exactfilepath = $this->_upload_dir . "/{$s_key}.zip";
                    if (!file_exists($exactfilepath)) {
                        $exactfilepath = $this->_download_slider($s_key);
                    }
                    if ($exactfilepath == false) {
                        if (strcmp($s_key, "omeo-revolution-{$home}") === 0) $res['status'] = false;
                        continue;
                    }
                    $response = $slider->importSliderFromPost($updateAnim, $updateStatic, $exactfilepath);

                    if ($response["success"] == false) {
                        if (strcmp($s_key, "omeo-revolution-{$home}") === 0) $res['status'] = false;
                        $message = $response["error"];
                        $res['msg'] .= "<b>Error: " . $message . "</b>";
                    } else {    //handle success, js redirect.
                        $res['msg'] .= __("Main Slider Import Success!", 'yetithemes');
                    }
                }

            } else {
                $res['msg'] .= __("Not found Revolution plugin", 'yetithemes');
            }
            return $res;
        }

        protected function _update_meta_menu($menu_id){
            $menu_items = get_posts(array(
                'post_type' => 'nav_menu_item',
                'posts_per_page'    => -1,
                'post_status'   => 'publish',
                'tax_query'     => array(
                    array(
                        'taxonomy'  => 'nav_menu',
                        'field'     => 'id',
                        'terms'     => absint($menu_id)
                    )
                )
            ));

            $_icons = array('fa fa-ravelry', 'fa fa-eercast', 'fa fa-meetup', 'fa fa-superpowers', 'fa fa-bicycle', 'fa fa-audio-description', 'fa fa-bicycle');
            foreach ($menu_items as $i => $item) {
                $_icon = empty($_icons[$i])? 'fa fa-ravelry': $_icons[$i];
                update_post_meta($item->ID, yesshop_MEGA_MENU_K . '_menu_item_font_icon', esc_attr($_icon));
            }
        }

        public function config_menu($home)
        {
            $locations = get_theme_mod('nav_menu_locations');
            $menus = wp_get_nav_menus();
            if ($menus) {
                foreach ($menus as $menu) {
                    switch ($menu->name) {
                        case 'Main menu right':
                            $locations['primary-menu-2'] = $menu->term_id;
                            break;
                        case 'Omeo Main menu':
                            $locations['primary-menu'] = $menu->term_id;
                            $locations['mobile-menu'] = $menu->term_id;
                            break;
                        case 'Omeo Main Menu Right':
                            $locations['primary-menu-2'] = $menu->term_id;
                            break;
                        case 'Omeo All Departments':
                            $locations['vertical-menu'] = $menu->term_id;
                            break;
                        case 'Omeo All Departments Mobile':
                            $locations['vertical-mb-menu'] = $menu->term_id;
                            break;
                    }
                }

                if(absint($home) === 12) {
                    foreach ($menus as $menu) {
                        if($menu->name === 'Main menu left') {
                            $locations['primary-menu'] = $menu->term_id;
                        }
                    }
                } elseif(absint($home) === 16) {
                    foreach ($menus as $menu) {
                        if($menu->name === 'All Departments 2') {
                            $locations['vertical-menu'] = $menu->term_id;
                            $this->_update_meta_menu($menu->term_id);
                        }
                    }
                }

                $res = '<p>Menu setting complete!</p>';
            } else {
                $res = "<p>Menu hadn't been created!!</p>";
            }
            set_theme_mod('nav_menu_locations', $locations);
            return $res;
        }

        public function update_setting_reading($h = 1)
        {
            $page_title = 'Omeo Home page ' . $h;
            $home = get_page_by_title($page_title);
            $blog = get_page_by_title('Blog');
            if (isset($home) && $home->ID) {
                update_option('show_on_front', 'page');
                update_option('page_on_front', $home->ID);
                update_option('posts_per_page', 5);
                update_option('posts_per_rss', 5);

                $page_conf = get_post_meta($home->ID, 'yesshop_page_options');

                switch (absint($h)) {
                    case 2:
                        $page_conf['slider_type'] = 'revolution';
                        $page_conf['rev_slider'] = 'omeo-revolution-2';
                        break;
                    default:
                        $page_conf['slider_type'] = '';
                        $page_conf['rev_slider'] = '';
                }
                update_post_meta($home->ID, 'yesshop_page_options', serialize($page_conf));
            }

            if (isset($blog) && $blog->ID) {
                update_option('page_for_posts', $blog->ID);
            }

            $this->_bg_color[$h] = wp_parse_args($this->_bg_color[$h], array(
                'background_color'      => false,
                'background_image'      => false,
                'background_repeat'     => false,
                'background_position_x' => false,
                'background_position_y' => false
            ));

            if(empty($this->_bg_color[$h]['background_color'])) {
                $this->_bg_color[$h]['background_color'] = '#ffffff';
            }

            foreach ($this->_bg_color[$h] as $k => $v) {
                if($v) {
                    set_theme_mod($k, $v);
                } else {
                    remove_theme_mod($k);
                }

            }

            //$this->update_options('yith_woocompare_compare_button_in_products_list', 'no');

            $this->update_options($this->data_key['reading'], 1);
            return "<p>Reading update complete!</p>";
        }

        public function config_woo_page()
        {
            if (class_exists('WooCommerce')) {
                update_option('shop_catalog_image_size', array(
                    'width' => '600',
                    'height' => '540',
                    'crop' => 1
                ));

                update_option('shop_single_image_size', array(
                    'width' => '600',
                    'height' => '540',
                    'crop' => 1
                ));

                update_option('shop_thumbnail_image_size', array(
                    'width' => '130',
                    'height' => '159',
                    'crop' => 1
                ));

                $woopages = array(
                    'woocommerce_shop_page_id' => 'Shop',
                    'woocommerce_cart_page_id' => 'Cart',
                    'woocommerce_checkout_page_id' => 'Checkout',
                    'woocommerce_myaccount_page_id' => 'My Account'
                );
                foreach ($woopages as $page_id => $page_title) {
                    $woopage = get_page_by_title($page_title);
                    if (isset($woopage->ID) && $woopage->ID) {
                        update_option($page_id, $woopage->ID);
                    }
                }

                $this->update_options('woocommerce_enable_myaccount_registration', 'yes');

                delete_transient('_wc_activation_redirect');

                flush_rewrite_rules();
            }
        }

        public function checkOption($key)
        {
            $check = get_option($key, 0);
            return absint($check);
        }

        public function check_requestPlugins($home)
        {
            $import_arrs = Yetithemes_Importer()->getThemeHomepages();
            $homepages = !empty($import_arrs['homepages']) ? $import_arrs['homepages'] : array();
            $req_plugins = !empty($import_arrs['req_plugins']) ? $import_arrs['req_plugins'] : array();
            foreach ($homepages[$home]['pl_request'] as $pl_path) {
                if ($req_plugins[$pl_path]['status'] !== true) return false;
            }
            return true;
        }

        public function import_home()
        {
            check_ajax_referer('__THEME_IMPORT_5362', 'security');
            $home = $_REQUEST['home'];

            $this->init();

            $res = array('msg' => '', 'status' => 0);

            if (!$this->checkContention()) {
                $res['status'] = 'connect_error';
                wp_send_json($res);
            }

            if (YetiThemes_Extra()->checkPlugin('wordpress-importer/wordpress-importer.php')) {
                $res['status'] = 'wp_import_exist';
                wp_send_json($res);
            }

            if (!$this->check_requestPlugins($home)) {
                $res['status'] = 'res_plugin_error';
                wp_send_json($res);
            }

            $imported = get_option($this->data_key['imported'], array());

            $revolution = $this->import_revolution($home);
            $res['msg'] .= $revolution['msg'];
            if ($revolution['status'] == false) {
                $res['status'] = 'rev_error';
                wp_send_json($res);
            }

            $res['msg'] .= $this->import_home_dummy($home);

            $res['msg'] .= $this->import_widget($home);

            $res['msg'] .= $this->config_woo_page();

            $res['msg'] .= $this->config_menu($home);

            $redux_imp = $this->import_redux($home);

            $res['msg'] .= $redux_imp['msg'];

            $res['msg'] .= $this->update_setting_reading($home);

            if (!is_array($imported)) $imported = array();

            $imported[] = $home;
            $this->update_options($this->data_key['imported'], $imported);

            $this->update_options($this->data_key['current'], $home);

            echo wp_json_encode($res);

            wp_die();
        }

        public function import_cms(){
            check_ajax_referer('__THEME_IMPORT_5362', 'security');
            $slug = $_REQUEST['slug'];

            $this->init();

            $res = array('msg' => '', 'status' => 0);

            $cms_imported = get_option( $this->data_key['cms_imported'], array() );

            if ($cms_imported && is_array($cms_imported) && in_array($slug, $cms_imported)) {
                $res['status'] = 'cms_imported';
            } else {
                $xml_file = $this->_local_dummy . "/cms/{$slug}.xml";
                if (strlen($xml_file) > 0) {
                    $cms_imported[] = $slug;
                    $this->update_options($this->data_key['cms_imported'], $cms_imported);
                    $res['msg'] = $this->import_dummy($xml_file);
                }
            }

        }

        public function _server_api()
        {
            check_ajax_referer('__THEME_IMPORT_5362', 'security');
            if(!is_array($_REQUEST) || empty($_REQUEST)) return false;

            set_time_limit(0);

            $tmp_path = $this->_setUploadDir();
            $zipfile = $tmp_path . "/{$_REQUEST['file']}";
            if(!file_exists($zipfile)) {
                $_server_api_uri = $this->_api_uri;
                $_args = $_REQUEST;
                $_args['code'] = $this->_purchase_code;
                $_server_api_uri = add_query_arg(array_map('urlencode', $_args), $_server_api_uri);

                $_request = wp_remote_post($_server_api_uri, array('timeout' => 45));
                if (isset($_request['response']) && strcmp(trim($_request['response']['code']), '200') == 0) {
                    $_downslider_data = wp_remote_retrieve_body($_request);
                    if (!empty($_downslider_data)) {
                        if (file_put_contents($tmp_path . "/{$_REQUEST['file']}", $_downslider_data)) {
                            echo 'Download success';
                        } else {
                            echo 'written failed'; wp_die();
                        }
                    } else {
                        echo 'download empty'; wp_die();
                    }
                } else {
                    print_r($_request); wp_die();
                }
            }
        }

    }

}

if (!function_exists('Yetithemes_Importer')) {
    function Yetithemes_Importer()
    {
        return Yetithemes_Importer::get_instance();
    }
}
add_action('wp_ajax_yetithemes_import_dummy', array(Yetithemes_Importer(), 'import_main_dummy'));
add_action('wp_ajax_yetithemes_import_home', array(Yetithemes_Importer(), 'import_home'));
add_action('wp_ajax_yetithemes_import_cms', array(Yetithemes_Importer(), 'import_cms'));