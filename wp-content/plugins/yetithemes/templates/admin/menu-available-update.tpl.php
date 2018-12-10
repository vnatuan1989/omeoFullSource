<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 1/31/2016
 * Vertion: 1.0
 */

$envato_tokan = Yetithemes_Envato_Api()->checkTokan();

$param = array(
    'action' => 'yeti_market_getCurrentItem',
    'security' => wp_create_nonce('__YETI_MARKET')
);
?>
<div class="wrap about-wrap yetithemes-wrap">

    <?php do_action('yetithemes_plugin_panel_header'); ?>

    <div class="nav-tab-conent">

        <div class="white-bg two-col" style="margin-bottom: 55px">
            <div class="col">
                <h3>Update via WP or via FTP</h3>
                <a class="button button-primary" href="http://themeforest.net/downloads" target="_blank"
                   title="Download in themefores"><i class="fa fa-download"></i> Download In Themeforest</a>
                <p>
                    To know how to update our theme, please see <a href="#" target="_blank"
                                                                   title="How to update theme?">our document here</a>.
                </p>
            </div>
            <div class="col">
                <?php if ($envato_tokan): ?>
                    <h3>Update via Envato Market plugin</h3>
                    <p>You can add a global token to connect all your items from your account, and/or connect directly
                        with a specific item using a singe-use token & item ID. When the global token and single-use
                        token are set for the same item, the single-use token will be used to communicate with the
                        API.</p>
                    <p>
                        <?php
                        if (is_array($envato_tokan)) {
                            foreach ($envato_tokan['plugin_action'] as $action) echo wp_kses_post($action);
                        } else {
                            echo wp_kses_post($envato_tokan);
                        }
                        ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="yeti-items available-update-theme yeti-ajax-get-content"
             data-param="<?php echo esc_attr(wp_json_encode($param)) ?>"></div>

    </div>

</div>
