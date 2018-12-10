<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Yetithemes_Frontend_Scripts')) {

    class Yetithemes_Frontend_Scripts
    {

        public function __construct()
        {

        }

        public static function init()
        {
            add_action('wp_print_scripts', array(__CLASS__, 'localize_printed_scripts'), 5);
            add_action('wp_enqueue_scripts', array(__CLASS__, 'load_scripts'));
            add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_load_scripts'));
        }

        public static function load_scripts()
        {
            $_asset_version = YetiThemes_Extra()->getVersion();
            wp_enqueue_script('isotope.min', YETI_PLUGIN_URL . 'assets/js/isotope.min.js', false, '2.2.0', true);
            wp_enqueue_script('imagesloaded.pkgd.min', YETI_PLUGIN_URL . 'assets/js/imagesloaded.pkgd.min.js', false, '3.2.0', true);
            wp_enqueue_style('yetithemes-style', YETI_PLUGIN_URL . 'assets/css/style.css');

            if (is_singular('yeti_gallery') || true) {
                wp_enqueue_script('jquery.royalslider.min.js', YETI_PLUGIN_URL . 'assets/royalslider/jquery.royalslider.min.js', array('jquery'), $_asset_version, true);
                wp_enqueue_style('royalslider', YETI_PLUGIN_URL . 'assets/royalslider/royalslider.css', false, $_asset_version);
                wp_enqueue_style('rs-default', YETI_PLUGIN_URL . 'assets/royalslider/skins/default/rs-default.css', false, $_asset_version);
            }

            wp_enqueue_script('yetithemes-js', YETI_PLUGIN_URL . 'assets/js/yeti.js', array('jquery'), $_asset_version, true);
        }

        public static function localize_printed_scripts()
        {
            $localizes = array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('yeti_plugin_none_339419'),
                'data' => array(
                    'search' => array(),
                ),
            );

            wp_localize_script('yetithemes-js', 'YetiThemes', $localizes);
        }

        public static function admin_load_scripts()
        {
            wp_enqueue_style('nexthemes-adminstyle', YETI_PLUGIN_URL . 'assets/css/admin-style.css');

            wp_enqueue_script('jquery-tiptip', YETI_PLUGIN_URL . 'assets/js/jquery.tipTip.min.js', array('jquery'));

            wp_enqueue_script('yetithemes.admin.js', YETI_PLUGIN_URL . 'assets/js/yetithemes.admin.js', array('jquery', 'media-upload', 'thickbox'));
        }

    }

    Yetithemes_Frontend_Scripts::init();
}
