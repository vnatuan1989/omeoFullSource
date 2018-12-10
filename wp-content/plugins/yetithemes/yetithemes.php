<?php
/**
 * Plugin Name: YetiThemes extra
 * Plugin URI: http://themeforest.net/user/themeyeti
 * Description: Unit Code Plugin of ThemeYeti
 * Version: 2.0.0
 * Author: Yetithemes
 * Author URI: http://themeforest.net/user/themeyeti
 *
 * License: GPLv2 or later
 * Text Domain: yetithemes
 * Domain Path: /languages/
 *
 * @package Yeti Themes
 * @author Yetithemes
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('YetiThemes_Extra')):

    final class YetiThemes_Extra
    {
        private $version = '2.0.0';
        private static $_instance;

        public static function get_instance()
        {
            if (self::$_instance === null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init()
        {
            add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'action_links'));
            add_action('plugins_loaded', array($this, 'define_constants'), 10);
            add_action('plugins_loaded', array($this, 'includes'), 20);
            add_action('plugins_loaded', array($this, 'init_hooks'), 30);
        }

        public function define_constants()
        {
            $this->define('YETI_PLUGIN_FILE', __FILE__);
            $this->define('YETI_PLUGIN_URL', plugin_dir_url(__FILE__));
            $this->define('YETI_PLUGIN_DIR', plugin_dir_path(__FILE__));
            $this->define('YETI_PLUGIN_TMPL_DIR', YETI_PLUGIN_DIR . 'templates/');
        }

        public function getVersion()
        {
            return $this->version;
        }

        private function define($name, $value)
        {
            if (!defined($name)) {
                define($name, $value);
            }
        }

        public function load_plugin_textdomain()
        {
            $locale = get_locale();

            load_textdomain('yetithemes', WP_LANG_DIR . '/yetithemes/yetithemes-' . $locale . '.mo');
            load_plugin_textdomain('yetithemes', false, plugin_basename(dirname(__FILE__)) . "/languages");
        }

        public function action_links($links)
        {
            $links[] = '<a href="' . menu_page_url('yetithemes', false) . '">' . __('Settings', 'yetithemes') . '</a>';
            return $links;
        }

        private function is_request($type)
        {
            switch ($type) {
                case 'admin' :
                    return is_admin();
                case 'ajax' :
                    return defined('DOING_AJAX');
                case 'cron' :
                    return defined('DOING_CRON');
                case 'frontend' :
                    return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
            }
        }

        public function includes()
        {
            include_once('includes/yeti-functions.php');
            include_once('includes/class-yeti-frontend-scripts.php');

            if ($this->is_request('admin')) {
                include_once('includes/class.envato_api.php');
                include_once('includes/class.youtube_api.php');
                include_once('includes/class.yeti-market.php');
                include_once('includes/class.plugin-panel.php');
                include_once('includes/class.admin-notices.php');

                include_once('includes/class.importer.php');
            }

            $features = maybe_unserialize($this->get_option('yeti_features', ''));

            if (empty($features['instagram'])) include_once('includes/instagram.php');

            if (empty($features['staticblock'])) $this->include_staticblocks();

            if (empty($features['portfolio'])) $this->include_portfolios();

            if (empty($features['teams'])) $this->include_members();

            if (empty($features['woovideos'])) $this->include_wooTabs();

            if (empty($features['ajaxsearch'])) $this->include_ajaxsearch();

            if (empty($features['galleries'])) $this->include_gallery();

            $this->include_shortcodes();

            if (class_exists('WooCommerce')) {
                if (empty($features['product_gift'])) include_once('includes/class.woocommerce_gift.php');
                if (empty($features['woo_accessories'])) include_once('includes/class.woocommerce_accessories.php');
                if (empty($features['gridlisttoggle'])) include_once('includes/woo-gridlisttoggle/class-gridlisttoggle.php');
            }
        }

        public function include_portfolios()
        {
            include_once('includes/portfolios/class-portfolios.php');
            if ($this->is_request('admin')) {
                include_once('includes/portfolios/class-portfolios-admin.php');
            } else {
                include_once('includes/portfolios/class-portfolios-front.php');
            }
        }

        public function include_staticblocks()
        {
            include_once('includes/staticblocks/class-staticblocks.php');
        }

        public function include_members()
        {
            include_once('includes/teams/class-team-members.php');
            if ($this->is_request('admin')) {
                include_once('includes/teams/class-team-members-admin.php');
            } else {
                include_once('includes/teams/class-team-members-front.php');
            }
        }

        public function include_wooTabs()
        {
            include_once('includes/woo-tabs/class-wooTabs.php');
        }

        public function include_gallery()
        {
            include_once('includes/gallery/class.gallery.php');
        }

        public function include_ajaxsearch()
        {
            include_once('includes/ajax-search/class-ajax-search.php');
        }

        public function include_shortcodes()
        {
            if ($this->is_request('frontend')) {
                include_once('includes/shortcodes/class-woo-shortcodes.php');
                include_once('includes/shortcodes/class-shortcodes.php');
            }
        }

        public function init_hooks()
        {
            register_activation_hook(__FILE__, array($this, 'installed_callback'));
            add_action('init', array($this, 'load_domain'), 0);
        }

        public function installed_callback()
        {
            flush_rewrite_rules();
        }

        public function load_domain()
        {
            $this->load_plugin_textdomain();
        }

        public function checkPlugin($path = '', $res = 'bool')
        {
            if (strlen($path) == 0) return false;
            $_actived = apply_filters('active_plugins', get_option('active_plugins'));
            if (in_array(trim($path), $_actived)) {
                switch ($res) {
                    case 'info':
                        return get_plugin_data(WP_PLUGIN_DIR . '/' . $path);
                    default:
                        return true;
                }
            } else return false;
        }

        public function get_owlResponsive($options = array())
        {
            $column = $options['items'];

            if (absint($column) > 1) {

                $_size = array(
                    0       => 280,
                    480     => 480,
                    550     => 550,
                    720     => 720,
                    940     => 940,
                    1140    => 1170,
                    1420    => 1430,
                    1560    => 1560,
                    1830    => 1920,
                );

                $resp = array();
                foreach ($_size as $k => $size) {
                    $_col = round($column * ($size / 1170));
                    if($_col < 1) $_col = 1;
                    $resp[$k] = array(
                        'items' => absint($_col),
                    );
                }

                if (isset($options['responsive']) && is_array($options['responsive'])) {
                    foreach ($options['responsive'] as $k => $arg) {
                        $resp[$k] = $arg;
                    }
                }
                $options['responsive'] = $resp;
            }


            return $options;
        }

        public function get_responseClass(&$class, $columns = 4)
        {
            if (absint($columns) > 1 && is_array($class)) {
                $class[] = 'col-lg-' . round(24 / $columns);
                $class[] = 'col-md-' . round(24 / round($columns * 992 / 1200));
                $class[] = 'col-sm-' . round(24 / round($columns * 768 / 1200));
                $class[] = 'col-xs-' . round(24 / round($columns * 480 / 1200));
            }
        }

        public function get_yetiLoadingIcon()
        {
            echo '<div class="yeti-spinner">' .
                '<div class="folding-cube">' .
                '<div class="cube1 cube"></div>' .
                '<div class="cube2 cube"></div>' .
                '<div class="cube3 cube"></div>' .
                '<div class="cube4 cube"></div>'
                . '</div></div>';
        }

        public function get_template($template_name, $args = array(), $products = null, $theme = false)
        {
            if ($args && is_array($args)) {
                extract($args);
            }

            $located = YETI_PLUGIN_TMPL_DIR . $template_name;

            if ($theme) {
                $tmp_f_arr = array_slice(explode('/', $template_name), 1);
                $tmp_f = implode('/', $tmp_f_arr);
                $theme_located = get_template_directory() . '/framework/backend/pl_tmps/' . $tmp_f;
                if (file_exists($theme_located)) $located = $theme_located;
            }

            if (!file_exists($located)) {
                _doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $located), '1.0');
                return;
            }

            include($located);
        }

        public function get_shortcode_template($template_name, $args = array(), $products = null)
        {
            if ($args && is_array($args)) {
                extract($args);
            }

            $located = get_theme_file_path('woocommerce/' . $template_name);

            if (!file_exists($located)) {
                $located = YETI_PLUGIN_TMPL_DIR . $template_name;
            }

            if (!file_exists($located)) {
                _doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $located), '1.0');
                return;
            }

            include($located);
        }

        public function get_option($k, $def = false)
        {
            $option = get_option($k);
            return isset($option) && !empty($option) ? $option : $def;
        }

        public function getThemeInfo()
        {
            $theme_datas = wp_get_theme();
            if ($theme_datas->parent_theme) {
                $template_dir = basename(get_template_directory());
                $theme_datas = wp_get_theme($template_dir);
            }
            return $theme_datas;
        }

        public function update_options($key, $val)
        {
            $data = get_option($key);
            if (isset($data)) update_option($key, $val);
            else add_option($key, $val);
        }

        public function redux_create_shortcode_param($_key, $_func){
            if(function_exists('vc_add_shortcode_param')) {
                vc_add_shortcode_param($_key, $_func);
            } else {
                return false;
            }

        }


    }

endif;

if (!function_exists('YetiThemes_Extra')) {
    function YetiThemes_Extra()
    {
        return YetiThemes_Extra::get_instance();
    }
}

YetiThemes_Extra()->init();

