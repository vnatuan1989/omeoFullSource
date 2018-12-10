<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 1/31/2016
 * Vertion: 1.0
 */
?>
<div class="wrap about-wrap yetithemes-wrap">

    <?php do_action('yetithemes_plugin_panel_header'); ?>

    <div class="nav-tab-conent">

        <div class="theme-importer-wrapper">

            <?php
            $dummy_installed = get_option('yeti_dummy_installed', false);
            $_class_dumm = array("importer-section main-dummydata import-dummy");
            $_homes_item_class = array('homepage-item-inner');
            $dummy_disabled = $home_disabled = '';

            if (absint($dummy_installed)) {
                $_class_dumm[] = 'disabled';
                $_main_icon = 'fa-check';
                $_main_icon2 = 'fa-ban';
                $_main_title = __('Dummy content had imported!', 'yetithemes');
                $_main_button = 'disabled';
            } else {
                $_homes_item_class[] = 'disabled';
                $_main_icon = 'fa-database';
                $_main_icon2 = 'fa-arrow-circle-right';
                $_main_title = __('Import Base Dummy Content', 'yetithemes');
                $_main_button = '';
            }

            $param = array(
                'action' => 'yetithemes_import_dummy',
                'security' => wp_create_nonce('__THEME_IMPORT_5362')
            );
            ?>

            <div class="<?php echo esc_attr(implode(' ', $_class_dumm)) ?>">
                <div class="base-dummy-action-wrap">
                    <i class="box-icon fa <?php echo esc_attr($_main_icon); ?> fa-5x" aria-hidden="true"></i>
                    <h2><?php echo esc_html($_main_title); ?></h2>
                    <p>Firstly, please import our Base dummy content, that are the content for all Demo version. Then you will get the the Home page list for installation.</p>
                    <button class="button yeti-ajax-call" <?php echo esc_attr($_main_button); ?> data-param="<?php echo esc_attr(wp_json_encode($param)) ?>" data-progress_text="<?php esc_attr_e('Please wait a moment...', 'yetithemes') ?>"><i class="fa <?php echo esc_attr($_main_icon2); ?> fa-2x" aria-hidden="true"></i> Import Dummy Data</button>
                </div>
            </div>

            <div class="importer-section homepage-import<?php if (!absint($dummy_installed)) echo ' disabled' ?>">
                <h2>Import Demo Version</h2>

                <div class="homepages-wrapper">
                    <?php

                    $import_arrs = Yetithemes_Importer()->getThemeHomepages();

                    $homepages = !empty($import_arrs['homepages']) ? $import_arrs['homepages'] : array();
                    $req_plugins = !empty($import_arrs['req_plugins']) ? $import_arrs['req_plugins'] : array();


                    $home_current = get_option('yeti_theme_current', false);

                    $home_install = get_option('yeti_theme_imported', true);

                    $ref_url = '';
                    if (class_exists('WooCommerce')) {
                        $woo_admin_notice = get_option('woocommerce_admin_notices', array());
                        if (in_array('install', $woo_admin_notice))
                            $ref_url = admin_url('admin.php?page=wc-setup');
                    }

                    foreach ($homepages as $slug => $home_arg) :
                        if (class_exists('Yetithemes_Importer')) $home_variable = Yetithemes_Importer::checkImportfiles($slug);
                        else $home_variable = false;

                        if ($home_variable == false) continue;

                        $home_img_url = esc_url(get_template_directory_uri() . "/framework/backend/images/imports/home-iwrap{$slug}.png");

                        $param = array(
                            'action' => 'yetithemes_import_home',
                            'security' => wp_create_nonce('__THEME_IMPORT_5362'),
                            'home' => $slug
                        );

                        $_home_wrapper = 'homepage-item-wrapper';
                        $home_title_rex = '%s';

                        if ($home_install && is_array($home_install) && in_array($slug, $home_install)) {
                            $home_title_rex = '%s <span class="imported">(%s)</span>';
                            if (absint($home_current) > 0 && absint($home_current) == absint($slug)) {
                                $_home_wrapper .= ' current_item';
                                $button_resetup = '<button class="button" disabled><i class="fa fa-check-square" aria-hidden="true"></i> ' . __('Applied', 'yetithemes') . '</button>';
                            } else {
                                $_home_wrapper .= ' imported_item';
                                $button_resetup = sprintf('<button class="yeti-ajax-call button" data-json="1" data-ref="%s" data-param="%s"><i class="fa fa-check-square-o" aria-hidden="true"></i> %s</button>', esc_attr($ref_url), esc_attr(wp_json_encode($param)), __('Apply', 'yetithemes'));
                            }
                        } else {
                            $button_resetup = sprintf('<button class="yeti-ajax-call button button-primary" data-json="1" data-ref="%s" data-param="%s"><i class="fa fa-download" aria-hidden="true"></i> %s</button>', esc_attr($ref_url), esc_attr(wp_json_encode($param)), __('Import', 'yetithemes'));
                        }

                        ?>
                        <div class="<?php echo esc_attr($_home_wrapper) ?>">
                            <div class="<?php echo esc_attr(implode(' ', $_homes_item_class)) ?>">

                                <div class="image-wrapper">
                                    <img src="<?php echo esc_url($home_img_url) ?>" alt="home-<?php echo absint($slug) ?>" title="Home page <?php echo absint($slug) ?>">
                                </div>
                                <?php
                                $req_pls_li = '';
                                foreach ($home_arg['pl_request'] as $pl_path) {
                                    if ($req_plugins[$pl_path]['status'] == true) {
                                        $rex_str = '<li class="active"><i class="fa fa-check-circle-o" aria-hidden="true"></i> %s</li>';
                                    } else {
                                        $rex_str = '<li class="request"><i class="fa fa-circle-o" aria-hidden="true"></i> %s</li>';
                                    }

                                    $req_pls_li .= sprintf($rex_str, esc_html($req_plugins[$pl_path]['name']));
                                }
                                ?>
                                <div class="meta-wrapper">
                                    <div class="heading-wrap">
                                        <h3 class="home-title"><?php printf($home_title_rex, esc_html($home_arg['name']), __('imported', 'yetithemes')) ?></h3>
                                        <ul class="pl-request"><?php echo $req_pls_li; ?></ul>
                                    </div>
                                    <div class="action-buttons">
                                        <a class="button" href="<?php echo esc_url("//demo.nexthemes.com/wordpress/yesshop/{$home_arg['url']}") ?>" target="_blank" title="<?php echo esc_attr($home_arg['name']) ?>">
                                            <i class="fa fa-external-link" aria-hidden="true"></i> <?php _e('Preview', 'yetithemes') ?>
                                        </a>
                                        <?php echo $button_resetup; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

        </div>

    </div>

</div>
