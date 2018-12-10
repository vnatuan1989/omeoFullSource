<?php

if (!defined('ABSPATH')) exit;

class Yetithemes_Push_Notifications
{

    public function __construct()
    {
        if (is_admin()) {
            $this->_admin_call();
        }
    }

    public function _admin_call()
    {
        add_filter('woocommerce_settings_tabs_array', array($this, 'setting_tab_array'), 50);
        add_action('woocommerce_settings_tabs_yeti_push_notify_tab', array($this, 'settings_tab'));
    }

    public function setting_tab_array($setting_tabs)
    {
        $setting_tabs['yeti_push_notify_tab'] = __('Push Notifications', 'yetithemes');
        return $setting_tabs;
    }

    public function settings_tab()
    {
        $settings = array(
            array(
                'title' => __('Push Notifications', 'yetithemes'),
                'type' => 'title',
                'desc' => '',
                'id' => 'yeti_push_notify_options'
            ),

            array(
                'title' => __('Enable Registration', 'yetithemes'),
                'desc' => __('Enable registration on the "Checkout" page', 'yetithemes'),
                'id' => 'woocommerce_enable_signup_and_login_from_checkout',
                'default' => 'yes',
                'type' => 'checkbox',
                'checkboxgroup' => 'start',
                'autoload' => false
            ),

        );

        woocommerce_admin_fields($settings);

    }
}

new Yetithemes_Push_Notifications();