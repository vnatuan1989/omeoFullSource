<?php

if (!class_exists('Yetithemes_EnvatoApi')) {
    class Yetithemes_EnvatoApi
    {
        private $_tokan = 'LEBnqnWTFzNJTn5fDPhIiCcqywAZkTsq';
        private $_author = 'themeyeti';
        private $_current_id = '0';
        protected static $instance;
        protected $_urls;
        protected $_update_version = null;

        public function __construct()
        {
            $this->_urls = array(
                'main' => 'https://api.envato.com/',
                'before_cart' => 'https://themeforest.net/cart/configure_before_adding/',
                'user_info' => "v1/market/user:{$this->_author}.json",
                'single_item' => 'v3/market/catalog/item?id=' . $this->_current_id,
                'list_items' => "v1/market/new-files-from-user:{$this->_author},themeforest.json",
                'item_prices' => "v1/market/item-prices:%s.json",
                'download' => "v3/market/buyer/download?item_id={$this->_current_id}&shorten_url=true",
                'user_badges' => "v1/market/user-badges:{$this->_author}.json"
            );
        }

        public static function get_instance()
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        private function request($url, $args = array())
        {
            $default = array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->_tokan,
                ),
                'timeout' => 20,
            );

            $url = $this->_urls['main'] . $url;

            $args = wp_parse_args($args, $default);
            $response = wp_remote_get(esc_url_raw($url), $args);

            // Check the response code.
            $response_code = wp_remote_retrieve_response_code($response);
            $response_message = wp_remote_retrieve_response_message($response);

            if (200 !== $response_code && !empty($response_message)) {
                return false;
            } elseif (200 !== $response_code) {
                return false;
            } else {
                $return = json_decode(wp_remote_retrieve_body($response), true);
                if (isset($return['error'])) return false;
                return $return;
            }
        }

        public function checkUpdate()
        {
            if ($this->_update_version !== null) return $this->_update_version;

            $this->_update_version = get_transient('yeti_yesshop_update_version');
            $theme_info = YetiThemes_Extra()->getThemeInfo();
            if ($this->_update_version === false) {
                $_current_item = $this->getCurrentItem();
                if (!empty($_current_item)) {
                    $this->_update_version = version_compare($theme_info->get('Version'), $_current_item['wordpress_theme_metadata']['version'], '<') ? $_current_item['wordpress_theme_metadata']['version'] : false;
                    set_transient('yeti_yesshop_update_version', $this->_update_version, 12 * HOUR_IN_SECONDS);
                } else {
                    $this->_update_version = false;
                }
            } else {
                $this->_update_version = version_compare($theme_info->get('Version'), $this->_update_version, '<') ? $this->_update_version : false;
            }

            return empty($this->_update_version) ? false : $this->_update_version;
        }

        public function checkTokan()
        {
            $_envato_not_active = $this->checkEnvatoMarketPlugin();
            if (!$_envato_not_active) {
                if (function_exists('envato_market')) {
                    $_option = envato_market()->get_option('token');
                    if (strlen($_option) > 0) return $_option;
                    else {
                        $_envato_link = menu_page_url('envato-market', false);
                        return sprintf('<a class="button" href="%1$s" title="%2$s">%2$s</a>', esc_url($_envato_link), __('Please add your envato tokan in here', 'yetithemes'));
                    }
                } else return false;
            } else {
                return $_envato_not_active;
            }
        }

        public function checkEnvatoMarketPlugin()
        {
            if (class_exists('TGM_Plugin_Activation') && !class_exists('Envato_Market')) {
                $plugins = TGM_Plugin_Activation::$instance->plugins;
                $plugins['envato-market']['plugin_action'] = $this->plugin_link($plugins['envato-market']);
                return $plugins['envato-market'];
            } else {
                return false;
            }
        }

        private function plugin_link($item)
        {
            $installed_plugins = get_plugins();
            if (!isset($installed_plugins[$item['file_path']])) {
                $actions = array(
                    'install' => sprintf(
                        '<a href="%1$s" class="button button-primary" title="Install %2$s"><i class="fa fa-plug" aria-hidden="true"></i> Install %2$s</a>',
                        esc_url(wp_nonce_url(
                            add_query_arg(
                                array(
                                    'page' => urlencode(TGM_Plugin_Activation::$instance->menu),
                                    'plugin' => urlencode($item['slug']),
                                    'plugin_name' => urlencode($item['name']),
                                    'plugin_source' => urlencode($item['source']),
                                    'tgmpa-install' => 'install-plugin',
                                    'return_url' => 'nexthemes-plugins'
                                ),
                                TGM_Plugin_Activation::$instance->get_tgmpa_url()
                            ),
                            'tgmpa-install',
                            'tgmpa-nonce'
                        )),
                        $item['name']
                    ),
                );
            } elseif (is_plugin_inactive($item['file_path'])) {
                $actions = array(
                    'activate' => sprintf(
                        '<a href="%1$s" class="button button-primary" title="Activate %2$s"><i class="fa fa-plug" aria-hidden="true"></i> Activate %2$s</a>',
                        esc_url(add_query_arg(
                            array(
                                'plugin' => urlencode($item['slug']),
                                'plugin_name' => urlencode($item['name']),
                                'yeti-activate' => 'activate-plugin',
                                'yeti-activate-nonce' => wp_create_nonce('yeti-activate'),
                            ),
                            menu_page_url('yetithemes-update', false)
                        )),
                        $item['name']
                    ),
                );
            }

            return $actions;
        }

        public function getDownloadUrl()
        {
            $return = $this->request($this->_urls['download']);
            return $return;
        }

        public function getUrl($k)
        {
            return !empty($this->_urls[$k]) ? $this->_urls[$k] : false;
        }

        public function getUserInfo()
        {
            $return = $this->request($this->_urls['user_info']);
            return !empty($return['user']) ? $return['user'] : array();
        }

        public function getUserBadges()
        {
            $return = $this->request($this->_urls['user_badges']);
            return !empty($return['user-badges']) ? $return['user-badges'] : array();
        }

        public function getListItems()
        {
            $return = $this->request($this->_urls['list_items']);
            return !empty($return['new-files-from-user']) ? $return['new-files-from-user'] : array();
        }

        public function getCurrentItem()
        {
            if (absint($this->_current_id) <= 0) return false;
            $return = $this->request($this->_urls['single_item']);
            return $return;
        }


        public function getItemPrices($id)
        {
            $url = sprintf($this->_urls['item_prices'], $id);
            $return = $this->request($url);
            return !empty($return['item-prices']) ? $return['item-prices'] : false;
        }
    }

    function Yetithemes_Envato_Api()
    {
        return Yetithemes_EnvatoApi::get_instance();
    }
}