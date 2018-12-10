<?php

if (!defined('ABSPATH')) exit;

class Yetithemes_Ajax_ProductFilter
{

    protected static $instance = null;

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new Yetithemes_Admin_Notices();
        }

        return self::$instance;
    }

    public function __construct()
    {
        if (!is_admin()) {
            wp_enqueue_script('jquery.history', YETI_PLUGIN_URL . 'assets/js/jquery.history.js', array('jquery'), '2.0');
        }
    }

}

new Yetithemes_Ajax_ProductFilter();
