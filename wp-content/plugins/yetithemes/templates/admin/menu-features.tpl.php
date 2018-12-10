<?php
$_yeti_feature_opt = get_option('yeti_features');
if (empty($_yeti_feature_opt)) $_yeti_feature_opt = array();
else $_yeti_feature_opt = maybe_unserialize($_yeti_feature_opt);

$_yeti_features = array(
    'staticblock' => 'Static block',
    'gridlisttoggle' => 'Woo Grid List Toggle',
    'portfolio' => 'Portfolio',
    'teams' => 'Team Members',
    'woovideos' => 'Woo Custom Tabs',
    'ajaxsearch' => 'Product Search Autocomplete',
    'brands' => 'Woo Brands',
    'galleries' => 'Yeti Galleries',
    'instagram' => 'Instagram shortcode',
    'product_gift' => 'Woo Product gift',
    'woo_accessories' => 'WooCommerce Accessories',
);

?>
<div class="wrap about-wrap yetithemes-wrap">

    <?php do_action('yetithemes_plugin_panel_header'); ?>

    <div class="nav-tab-conent">

        <form id="yeti_features_enable_form" method="post" action="#">
            <input type="hidden" name="action" value="yeti_features_enabled">
            <input type="hidden" name="security" value="<?php echo esc_attr(wp_create_nonce('__YETI_SC_5362')) ?>">

            <div class="yeti-items">

                <?php foreach ($_yeti_features as $k => $v) :
                    $_wrap = array('featured-enable-wrap');
                    $_option = empty($_yeti_feature_opt[esc_attr($k)]) ? 'on' : esc_attr($_yeti_feature_opt[esc_attr($k)]);
                    if ($_option === 'on') $_wrap[] = 'enabled'; ?>
                    <div class="yeti-item col-3">
                        <div class="<?php echo esc_attr(implode(' ', $_wrap)) ?>">
                            <input type="checkbox" name="yeti_features[<?php echo esc_attr($k) ?>]"
                                   id="yeti_features_<?php echo esc_attr($k) ?>" <?php checked($_option, 'off') ?>
                                   value="off">
                            <label for="yeti_features_<?php echo esc_attr($k) ?>"><?php echo esc_attr($v) ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
            <div class="clear"></div>
        </form>

    </div>

</div>
