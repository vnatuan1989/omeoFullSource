<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Yetithemes_Plugin_Panel')) :

    class Yetithemes_Plugin_Panel
    {

        public $settings = array();

        public function __construct() {
            add_action('admin_init', array($this, 'settings_init'));
            add_action('admin_menu', array($this, 'add_menu_page'));
            add_action('admin_menu', array($this, 'edit_menu_page'));
        }

        public function settings_init()
        {
            if (current_user_can('edit_theme_options')) {
                if (isset($_GET['yeti-activate']) && $_GET['yeti-activate'] == 'activate-plugin') {
                    check_admin_referer('yeti-activate', 'yeti-activate-nonce');

                    $plugins = TGM_Plugin_Activation::$instance->plugins;

                    foreach ($plugins as $plugin) {
                        if ($plugin['slug'] == $_GET['plugin']) {
                            activate_plugin($plugin['file_path']);

                            wp_redirect(menu_page_url('yetithemes-update', false));
                            exit;
                        }
                    }
                }
            }

        }

        public function add_menu_page()
        {
            add_menu_page(__('Welcome to yesshop', 'yetithemes'), __('Yeti Extra', 'yetithemes'), 'manage_options', 'yetithemes', array($this, 'dashboard_panel'), YETI_PLUGIN_URL . 'assets/images/yeti_icon.png', 3); /*YETI_PLUGIN_URL . 'assets/images/yeti_icon.png'*/

            add_submenu_page('yetithemes', __('Supporting', 'yetithemes'), __('Support', 'yetithemes'), 'manage_options', 'yetithemes-support', array($this, 'support_panel'));
            add_submenu_page('yetithemes', __('Features', 'yetithemes'), __('Features', 'yetithemes'), 'manage_options', 'yetithemes-features', array($this, 'features_panel'));
            add_submenu_page('yetithemes', __('Theme Improter', 'yetithemes'), __('Importer', 'yetithemes'), 'manage_options', 'yetithemes-importer', array($this, 'importer_panel'));
            add_submenu_page('yetithemes', __('Our Items', 'yetithemes'), __('Our Items', 'yetithemes'), 'manage_options', 'yetithemes-items', array($this, 'themeforest_panel'));
            add_submenu_page('yetithemes', __('System status', 'yetithemes'), __('System status', 'yetithemes'), 'manage_options', 'yetithemes-sys', array($this, 'system_status_panel'));

            if (Yetithemes_Envato_Api()->checkUpdate()) {
                add_submenu_page('yetithemes', __('Available update', 'yetithemes'), __('New update', 'yetithemes'), 'manage_options', 'yetithemes-update', array($this, 'available_update_panel'));
            }
        }

        public function edit_menu_page()
        {
            global $submenu, $menu;
            if (current_user_can('edit_theme_options')) {
                $submenu['yetithemes'][0][0] = __("About", 'yetithemes');
            }

            $_available = Yetithemes_Envato_Api()->checkUpdate();
            if ($_available) {
                $count = 1;
                foreach ($menu as $k => $item) {
                    if (strcmp($item[2], 'yetithemes') == 0) {
                        $menu[$k][0] .= ' <span class="awaiting-mod count-1 version-' . esc_attr($_available) . '"><span class="pending-count">' . esc_html($count) . '</span></span>';
                        break;
                    }
                }

                foreach ($submenu['yetithemes'] as $k => $item) {
                    if (strcmp($item[2], 'yetithemes-update') == 0) {
                        $submenu['yetithemes'][$k][0] .= ' <span class="awaiting-mod count-1"><span class="pending-count">' . esc_html($_available) . '</span></span>';
                    }
                }
            }
        }

        public function randerTabHeader()
        {
            $theme_info = YetiThemes_Extra()->getThemeInfo();
            YetiThemes_Extra()->get_template('admin/header.tpl.php', array('theme_info' => $theme_info), null, true);
        }

        public function dashboard_panel()
        {
            $yetithemes = YetiThemes_Extra()->getThemeInfo();
            add_action('yetithemes_plugin_panel_header', array($this, 'randerTabHeader'));
            YetiThemes_Extra()->get_template('admin/dashboard.tpl.php', array('yetithemes' => $yetithemes), null, true);
        }

        public function support_panel()
        {
            add_action('yetithemes_plugin_panel_header', array($this, 'randerTabHeader'));
            YetiThemes_Extra()->get_template('admin/support.tpl.php', array(), null, true);
        }

        public function features_panel()
        {
            add_action('yetithemes_plugin_panel_header', array($this, 'randerTabHeader'));
            YetiThemes_Extra()->get_template('admin/menu-features.tpl.php', array(), null, true);
        }

        public function importer_panel()
        {
            add_action('yetithemes_plugin_panel_header', array($this, 'randerTabHeader'));
            YetiThemes_Extra()->get_template('admin/importer.tpl.php');
        }

        public function themeforest_panel()
        {
            add_action('yetithemes_plugin_panel_header', array($this, 'randerTabHeader'));
            YetiThemes_Extra()->get_template('admin/themeforest.tpl.php');
        }

        public function system_status_panel()
        {
            add_action('yetithemes_plugin_panel_header', array($this, 'randerTabHeader'));
            YetiThemes_Extra()->get_template('admin/system.tpl.php');
        }

        public function available_update_panel()
        {
            add_action('yetithemes_plugin_panel_header', array($this, 'randerTabHeader'));
            YetiThemes_Extra()->get_template('admin/menu-available-update.tpl.php');
        }

    }

endif;

new Yetithemes_Plugin_Panel();