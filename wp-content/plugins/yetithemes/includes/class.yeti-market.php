<?php

if (!class_exists('Yetithemes_Market')) {

    class Yetithemes_Market extends Yetithemes_EnvatoApi
    {

        public function __construct($_token = '')
        {
            parent::__construct();
            $this->registerAjax();
        }

        public function registerAjax()
        {
            add_action('wp_ajax_yeti_market_get_new_items', array($this, 'ajaxGetNewItems'));
            add_action('wp_ajax_yeti_market_getCurrentItem', array($this, 'ajaxGetCurrentItem'));
            add_action('wp_ajax_yeti_market_get_badges', array($this, 'ajaxGetBadges'));
        }

        public function ajaxGetNewItems()
        {
            check_ajax_referer('__YETI_MARKET', 'security');
            set_time_limit(0);
            $themeyeti_items = $this->getListItems();

            if (!empty($themeyeti_items)) {
                foreach ($themeyeti_items as $item) {
                    $item['item_prices'] = $this->getItemPrices($item['id']);
                    echo YetiThemes_Extra()->get_template('admin/yeti-item.tpl.php', $item);
                }
            }

            wp_die();
        }

        public function ajaxGetCurrentItem()
        {
            check_ajax_referer('__YETI_MARKET', 'security');
            set_time_limit(0);
            $_current_item = Yetithemes_Envato_Api()->getCurrentItem();

            if ($_current_item) {
                echo YetiThemes_Extra()->get_template('admin/yeti-current-item.tpl.php', array('_current_item' => $_current_item));
            }
            wp_die();
        }

        public function ajaxGetBadges()
        {
            check_ajax_referer('__YETI_MARKET', 'security');
            set_time_limit(0);
            $_badges = $this->getUserBadges();
            foreach ($_badges as $item) {
                echo "<img src='{$item['image']}' alt='{$item['name']}' title='{$item['name']}' width='35' height='35'>";
            }

            wp_die();
        }

    }

    new Yetithemes_Market();

}