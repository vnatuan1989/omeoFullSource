<?php
if (!class_exists('Yesshop_Options') && class_exists('Redux')) {

    class Yesshop_Options
    {

        private $sections;

        private $opt_name = 'yesshop_datas';

        private $_menu_slug = 'themes.php';

        private $less_options;

        private $path;

        public function __construct()
        {
            $this->init();
            add_action('after_setup_theme', array($this, 'load_config'));

            add_action('redux/loaded', array($this, 'remove_demo'));

            add_action("redux/extensions/" . OPS_THEME . "/before", array($this, 'registerCustomFields'), 0);
        }

        private function init()
        {
            if (class_exists('YetiThemes_Extra')) {
                $this->_menu_slug = 'yetithemes';
            }
            $this->contantPath();
            add_action('redux/page/' . $this->opt_name . '/enqueue', array($this, 'backendEnqueue'));
        }

        private function contantPath()
        {
            $this->path = array(
                'options' => THEME_FRAMEWORK_INCS . 'redux-framework/options/',
                'extensions' => THEME_FRAMEWORK_INCS . 'redux-framework/extensions/',
                'less_var_def' => THEME_DIR . 'less/typo_variables_default.less',
                'less_var_file' => THEME_DIR . 'less/typo_variables.less'
            );
        }

        public function backendEnqueue()
        {
            wp_enqueue_style('redux-font-awesome', THEME_CSS_URI . 'font-awesome.min.css', false, '4.4.0');
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        public function remove_demo()
        {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function load_config()
        {
            $theme = wp_get_theme();

            $this->sections = array('general', 'colors', 'woocommerce', 'blog', 'extensions', 'advanced', 'import-export');

            $args = array(
                'opt_name' => $this->opt_name,
                'display_name' => $theme->get('Name'),
                'display_version' => $theme->get('Version'),
                'allow_sub_menu' => true,
                'menu_title' => esc_html__('Theme Options', 'omeo'),
                'page_title' => esc_html__('Yetithemes Options', 'omeo'),
                'google_api_key' => 'AIzaSyBtYqnWT8z0QZ99U4I1g0diVWt9pu6I1Ug',
                'page_priority' => null,
                'page_slug' => 'theme-options',
                'page_parent' => $this->_menu_slug,
                'dev_mode' => false,
                'menu_type' => 'submenu',
                'customizer' => true,
                'footer_credit' => '&nbsp;',
                'show_import_export' => false,
                'templates_path' => THEME_FRAMEWORK_INCS . 'redux-framework/templates/',
            );

            Redux::setArgs($this->opt_name, $args);

            foreach ($this->sections as $section) {
                $_file = $section . '-options.php';
                require_once $this->path['options'] . $_file;
            }

            add_filter('redux/options/' . $this->opt_name . '/compiler', array($this, 'compiler_action'), 10, 3);
        }

        public function get_headerStyles($limit = 10)
        {
            $theme_headers = array();
            for ($i = 1; $i <= $limit; $i++) {
                if (file_exists(THEME_DIR . "images/theme-option-header{$i}.png")) {
                    $theme_headers[$i] = array(
                        'alt' => $i,
                        'img' => THEME_IMG_URI . "theme-option-header{$i}.png"
                    );
                }
            }
            return $theme_headers;
        }

        public function _rgb2hex($rgb)
        {
            $hex = "#";
            $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

            return $hex;
        }

        public function _hex2rgb($hex)
        {
            $hex = str_replace("#", "", $hex);

            if (strlen($hex) == 3) {
                $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
            } else {
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
            }
            $rgb = array($r, $g, $b);
            return $rgb;
        }

        public function compiler_action($options, $css, $changed_values)
        {
            global $wp_filesystem;

            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            if ($wp_filesystem) {
                $val_custom = $this->path['less_var_file'];
                $wp_filesystem->put_contents(
                    $val_custom,
                    $this->colorCompiler($options),
                    FS_CHMOD_FILE
                );

                $wp_filesystem->put_contents(
                    THEME_DIR . 'less/color-custom.less',
                    $this->colorCustomCompiler($options),
                    FS_CHMOD_FILE
                );
            }

            $less = new Yesshop_Less_Compiler();
            $less->compile('color-custom');
        }

        public function colorCustomCompiler($options)
        {
            $_var = "@import 'typo_variables';";
            $_var .= "@import 'yeti_icons';";
            $_var .= "@import 'element/effect';";
            $_var .= "@import 'rtl';";
            $_var .= "@import 'mixin_color';";
            $_var .= "@import 'color_typo';";
            $_var .= "@import 'element/button';";
            $_var .= "@import 'element/newsletter';";
            $_var .= "@import 'element/breadcrumb';";
            $_var .= "@import 'element/heading';";
            $_var .= "@import 'element/toolbar';";
            $_var .= "@import 'element/item_grid';";
            $_var .= "@import 'element/item_list';";
            $_var .= "@import 'element/menu';";
            $_var .= "@import 'element/sidebar';";
            $_var .= "@import 'element/sidebar';";
            $_var .= "@import 'element/pagging';";
            $_var .= "@import 'header/header';";
            for ($i = 1; $i < 13; $i++) {
                if (file_exists(THEME_DIR . 'less/header/header' . $i . '.less')) {
                    $_var .= "@import 'header/header{$i}';";
                }
            }

            $_var .= "@import 'footer/footer';";
            $_var .= "@import 'shortcode/sc_banner';";
            $_var .= "@import 'shortcode/sc_product_subcategories2';";
            $_var .= "@import 'shortcode/sc_brand';";
            $_var .= "@import 'shortcode/sc_tabs';";
            $_var .= "@import 'shortcode/sc_trending_section_products';";
            $_var .= "@import 'shortcode/sc_recently_post';";
            $_var .= "@import 'shortcode/sc_info_box';";
            $_var .= "@import 'shortcode/sc_best_selling_products';";
            $_var .= "@import 'shortcode/sc_product_tab_width_heading_icon';";
            $_var .= "@import 'shortcode/sc_product_categories_icon';";
            $_var .= "@import 'shortcode/sc_product_categories';";
            $_var .= "@import 'shortcode/sc_testimonials';";
            $_var .= "@import 'shortcode/sc_featured_products';";
            $_var .= "@import 'shortcode/sc_team_member';";
            $_var .= "@import 'shortcode/sc_galleries';";
            $_var .= "@import 'shortcode/sc_portfolio';";
            $_var .= "@import 'shortcode/sc_featured_products';";
            $_var .= "@import 'shortcode/sc_woo_cats';";
            $_var .= "@import 'shortcode/sc_product_category_section';";
            $_var .= "@import 'shortcode/sc_instagram';";
            $_var .= "@import 'shortcode/sc_pricing';";
            $_var .= "@import 'shortcode/sc_extra_class';";
            $_var .= "@import 'subpage/page_shop';";
            $_var .= "@import 'subpage/page_product_detail';";
            $_var .= "@import 'subpage/page_cart';";
            $_var .= "@import 'subpage/page_checkout';";
            $_var .= "@import 'subpage/page_account';";
            $_var .= "@import 'subpage/page_blog';";
            $_var .= "@import 'subpage/page_home';";
            $_var .= "@import 'subpage/page_about_us_1';";
            $_var .= "@import 'subpage/page_contact';";
            $_var .= "@import 'subpage/page_404';";


            return $_var;
        }

        public function colorCompiler($options)
        {
            global $wp_filesystem;

            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            if (empty($file)) {
                $file = $this->path['less_var_file'];
            }
            $file_data = $wp_filesystem->get_contents($file);

            $file_data = str_replace("\r", "\n", $file_data);
            $file_data = explode("\n", $file_data);

            foreach ($file_data as $k => $line) {
                if (strlen(trim($line)) == 0 || (preg_match('/^(\/\*|\/|\*| \*)/', $line, $match) && $match[1])) {
                    unset($file_data[$k]);
                    continue;
                }
                if (preg_match('/^\@(.*?)\:(.*?);/', $line, $match) && $match[0]) {
                    $_key = str_replace('@', '', $line);
                    $_key = str_replace(';', '', $_key);
                    $_key = array_map('trim', explode(':', $_key));
                    if (!empty($options[$_key[0]])) {
                        if (!is_array($options[$_key[0]])) {
                            $file_data[$k] = str_replace($_key[1], $options[$_key[0]], $line);
                        } elseif (isset($options[$_key[0]]['alpha'])) {
                            $rgb = $this->_hex2rgb($options[$_key[0]]['color']);
                            $rgb[] = $options[$_key[0]]['alpha'];
                            $rgba = sprintf('rgba(%s)', implode(',', $rgb));
                            $file_data[$k] = str_replace($_key[1], $rgba, $line);
                        } elseif (!empty($options[$_key[0]]['regular'])) {
                            $file_data[$k] = str_replace($_key[1], $options[$_key[0]]['regular'], $line);
                        } elseif (!empty($options[$_key[0]]['font-family'])) {
                            $_fonts = array_map('trim', explode(',', $options[$_key[0]]['font-family']));
                            if (count($_fonts) == 1 && strpos($_fonts[0], ' ') !== false) {
                                $_fonts[0] = "'" . $_fonts[0] . "'";
                            }
                            $file_data[$k] = str_replace($_key[1], implode(', ', $_fonts), $line);
                        } elseif(!empty($options[$_key[0]]['background-color'])){
                            $_prex_str = $options[$_key[0]]['background-color'];
                            if(!empty($options[$_key[0]]['background-image'])) {
                                $_img = substr($options[$_key[0]]['background-image'], strpos($options[$_key[0]]['background-image'], ":") + 1);
                                $_prex_str .= ' url('.esc_attr($_img).')';
                            }
                            if(!empty($options[$_key[0]]['background-repeat']))
                                $_prex_str .= ' ' . esc_attr($options[$_key[0]]['background-repeat']);
                            if(!empty($options[$_key[0]]['background-position']))
                                $_prex_str .= ' ' . esc_attr($options[$_key[0]]['background-position']);
                            if(!empty($options[$_key[0]]['background-size']))
                                $_prex_str .= ' ' . esc_attr($options[$_key[0]]['background-size']);

                            $file_data[$k] = str_replace($_key[1], $_prex_str, $line);
                        }
                    } elseif (preg_match('/(.*?)(_hover|_active|_weight|_style|_size|_trans)$/', trim($_key[0]), $match) && $match[0]) {
                        if (!empty($options[$match[1]])) {
                            switch ($match[2]) {
                                case '_weight':
                                    $options[$match[1]]['font-weight'] = empty($options[$match[1]]['font-weight']) ? 'inherit' : $options[$match[1]]['font-weight'];
                                    $file_data[$k] = str_replace($_key[1], $options[$match[1]]['font-weight'], $line);
                                    break;
                                case '_trans':
                                    $options[$match[1]]['text-transform'] = empty($options[$match[1]]['text-transform']) ? 'inherit' : $options[$match[1]]['text-transform'];
                                    $file_data[$k] = str_replace($_key[1], $options[$match[1]]['text-transform'], $line);
                                    break;
                                case '_style':
                                    $options[$match[1]]['font-style'] = empty($options[$match[1]]['font-style']) ? 'inherit' : $options[$match[1]]['font-style'];
                                    $file_data[$k] = str_replace($_key[1], $options[$match[1]]['font-style'], $line);
                                    break;
                                case '_size':
                                    $file_data[$k] = str_replace($_key[1], $options[$match[1]]['font-' . substr($match[2], 1)], $line);
                                    break;
                                default:
                                    $file_data[$k] = str_replace($_key[1], $options[$match[1]][substr($match[2], 1)], $line);
                            }
                        }
                    }
                } else continue;
            }

            return implode("\r", $file_data);
        }

        public function registerCustomFields($ReduxFramework)
        {
            $extensions = array('yeti_radio', 'yeti_dimensions', 'yeti_stylesheet');
            foreach ($extensions as $extension) {
                $extension_class = 'ReduxFramework_Extension_' . $extension;
                if (!class_exists($extension_class)) {
                    $class_file = $this->path['extensions'] . $extension . '/extension_' . $extension . '.php';
                    $class_file = apply_filters('redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $extension, $class_file);
                    if ($class_file) {
                        require_once($class_file);
                    }
                }
                if (!isset($ReduxFramework->extensions[$extension])) {
                    $ReduxFramework->extensions[$extension] = new $extension_class($ReduxFramework);
                }
            }
        }
    }

    new Yesshop_Options();

}