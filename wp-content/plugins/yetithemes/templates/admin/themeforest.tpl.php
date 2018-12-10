<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 1/31/2016
 * Vertion: 1.0
 */

$param = array(
    'action' => 'yeti_market_get_new_items',
    'security' => wp_create_nonce('__YETI_MARKET')
);
?>

<div class="wrap about-wrap yetithemes-wrap">

    <?php do_action('yetithemes_plugin_panel_header'); ?>

    <div class="yeti-items yeti-ajax-get-content" data-param="<?php echo esc_attr(wp_json_encode($param)) ?>"></div>

</div>

