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

        <div class="col-2">
            <?php
            $_section_class = array('yeti-section');
            $memory = nth_let_to_num(WP_MEMORY_LIMIT);
            if (function_exists('memory_get_usage')) {
                $system_memory = nth_let_to_num(@ini_get('memory_limit'));
                $memory = max($memory, $system_memory);
            }

            if ($memory < 67108864) {
                $memory = '<mark class="error">' . sprintf(__('%s - We recommend setting memory to at least 64MB. See: %s', 'yetithemes'), size_format($memory), '<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . __('Increasing memory allocated to PHP', 'yetithemes') . '</a>') . '</mark>';
                $_wp_environment_class[] = 'error';
            } else {
                $memory = '<mark class="yes">' . size_format($memory) . '</mark>';
            }
            ?>
            <section class="<?php echo esc_attr(implode(' ', $_section_class)) ?>">
                <header><?php _e('WordPress Environment', 'yetithemes'); ?></header>
                <table class="yeti_status_table widefat" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <td data-export-label="Home URL"><?php _e('Home URL', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('The URL of your site\'s homepage.', 'yetithemes')); ?></td>
                        <td><?php echo home_url(); ?></td>
                    </tr>
                    <tr>
                        <td data-export-label="Site URL"><?php _e('Site URL', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('The root URL of your site.', 'yetithemes')); ?></td>
                        <td><?php echo site_url(); ?></td>
                    </tr>
                    <tr>
                        <td data-export-label="WP Version"><?php _e('WP Version', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('The version of WordPress installed on your site.', 'yetithemes')); ?></td>
                        <td><?php bloginfo('version'); ?></td>
                    </tr>
                    <tr>
                        <td data-export-label="WP Multisite"><?php _e('WP Multisite', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('Whether or not you have WordPress Multisite enabled.', 'yetithemes')); ?></td>
                        <td><?php if (is_multisite()) echo '&#10004;'; else echo '&ndash;'; ?></td>
                    </tr>
                    <tr>
                        <td data-export-label="WP Memory Limit"><?php _e('WP Memory Limit', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('The maximum amount of memory (RAM) that your site can use at one time.', 'yetithemes')); ?></td>
                        <td><?php echo $memory; ?></td>
                    </tr>
                    <tr>
                        <td data-export-label="WP Debug Mode"><?php _e('WP Debug Mode', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('Displays whether or not WordPress is in Debug Mode.', 'yetithemes')); ?></td>
                        <td><?php if (defined('WP_DEBUG') && WP_DEBUG) echo '<mark class="yes">&#10004;</mark>'; else echo '<mark class="no">&ndash;</mark>'; ?></td>
                    </tr>
                    <tr>
                        <td data-export-label="Language"><?php _e('Language', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('The current language used by WordPress. Default = English', 'yetithemes')); ?></td>
                        <td><?php echo get_locale() ?></td>
                    </tr>
                    </tbody>
                </table>
            </section>

            <section class="yeti-section">
                <header><?php _e('Server Environment', 'yetithemes'); ?></header>
                <table class="yeti_status_table widefat" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <td data-export-label="Server Info"><?php _e('Server Info', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('Information about the web server that is currently hosting your site.', 'yetithemes')); ?></td>
                        <td><?php echo esc_html($_SERVER['SERVER_SOFTWARE']); ?></td>
                    </tr>
                    <tr>
                        <td data-export-label="PHP Version"><?php _e('PHP Version', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('The version of PHP installed on your hosting server.', 'yetithemes')); ?></td>
                        <td><?php
                            if (function_exists('phpversion')) {
                                $php_version = phpversion();
                                echo '<mark class="yes">' . esc_html($php_version) . '</mark>';
                            } else {
                                _e("Couldn't determine PHP version because phpversion() doesn't exist.", 'yetithemes');
                            }
                            ?></td>
                    </tr>
                    <?php if (function_exists('ini_get')) : ?>
                        <tr>
                            <td data-export-label="PHP Post Max Size"><?php _e('PHP Post Max Size', 'yetithemes'); ?>:
                            </td>
                            <td class="help"><?php echo nth_help_tip(__('The largest filesize that can be contained in one post.', 'yetithemes')); ?></td>
                            <td><?php echo size_format(nth_let_to_num(ini_get('post_max_size'))); ?></td>
                        </tr>
                        <?php
                        $time_limit = @ini_get('max_execution_time');
                        if ($time_limit < 300 && $time_limit != 0) {
                            $_row_ds = '<mark class="error">' . sprintf(__('%s - We recommend setting max execution time to at least 300. See: <a href="%s" target="_blank">Increasing max execution to PHP</a>', 'yetithemes'), $time_limit, 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded') . '</mark>';
                            $_row_class = 'error';
                        } else {
                            $_row_ds = '<mark class="yes">' . $time_limit . '</mark>';
                            $_row_class = 'success';
                        }
                        ?>
                        <tr class="<?php echo esc_attr($_row_class); ?>">
                            <td data-export-label="PHP Time Limit"><?php _e('PHP Time Limit', 'yetithemes'); ?>:</td>
                            <td class="help"><?php echo nth_help_tip(__('The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'yetithemes')); ?></td>
                            <td><?php echo $_row_ds; ?></td>
                        </tr>
                        <?php
                        $max_input_vars = ini_get('max_input_vars');
                        if (absint($max_input_vars) < 2000) {
                            $_row_ds = '<mark class="error">' . sprintf(__('%s - We recommend setting max input vars to at least 2000. See: <a href="%s" target="_blank">Increasing max input vars limit.</a>', 'Avada'), $max_input_vars, 'https://www.google.com/#q=max_input_vars') . '</mark>';
                            $_row_class = 'error';
                        } else {
                            $_row_ds = '<mark class="yes">' . $max_input_vars . '</mark>';
                            $_row_class = 'success';
                        }
                        ?>
                        <tr class="<?php echo esc_attr($_row_class); ?>">
                            <td data-export-label="PHP Max Input Vars"><?php _e('PHP Max Input Vars', 'yetithemes'); ?>
                                :
                            </td>
                            <td class="help"><?php echo nth_help_tip(__('The maximum number of variables your server can use for a single function to avoid overloads.', 'yetithemes')); ?></td>
                            <td><?php echo $_row_ds; ?></td>
                        </tr>
                        <tr>
                            <td data-export-label="SUHOSIN Installed"><?php _e('SUHOSIN Installed', 'yetithemes'); ?>:
                            </td>
                            <td class="help"><?php echo nth_help_tip(__('Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself. If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'yetithemes')); ?></td>
                            <td><?php echo extension_loaded('suhosin') ? '&#10004;' : '&ndash;'; ?></td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td data-export-label="ZipArchive"><?php _e('ZipArchive', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('ZipArchive is required for importing demos. They are used to import and export zip files specifically for sliders.', 'yetithemes')); ?></td>
                        <td><?php
                            if (class_exists('ZipArchive')) {
                                echo '<mark class="yes">&#10004;</mark>';
                            } else {
                                echo '<mark class="error">' . __('ZipArchive is not installed on your server, but is required if you need to import demo content', 'yetithemes') . '</mark>';
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td data-export-label="MySQL Version"><?php _e('MySQL Version', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('The version of MySQL installed on your hosting server.', 'yetithemes')); ?></td>
                        <td><?php
                            global $wpdb;
                            echo $wpdb->db_version();
                            ?></td>
                    </tr>
                    <tr>
                        <td data-export-label="Max Upload Size"><?php _e('Max Upload Size', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('The largest filesize that can be uploaded to your WordPress installation.', 'yetithemes')); ?></td>
                        <td><?php echo size_format(wp_max_upload_size()); ?></td>
                    </tr>
                    <tr>
                        <td data-export-label="DOMDocument"><?php _e('DOMDocument', 'yetithemes'); ?>:</td>
                        <td class="help"><?php echo nth_help_tip(__('HTML/Multipart emails use DOMDocument to generate inline CSS in templates.', 'yetithemes')); ?></td>
                        <td><?php
                            if (class_exists('DOMDocument')) {
                                echo '<mark class="yes">&#10004;</mark>';
                            } else {
                                echo '<mark class="error">' . __('Your server does not have the DOMDocument class enabled - HTML/Multipart emails, and also some extensions, will not work without DOMDocument.', 'yetithemes') . '</mark>';
                            }
                            ?></td>
                    </tr>
                    </tbody>
                </table>
            </section>

        </div>

        <div class="col-2 last">

            <?php
            $active_plugins = (array)get_option('active_plugins', array());
            if (is_multisite()) {
                $active_sitewide_plugins = (array)get_site_option('active_sitewide_plugins', array());
                $active_plugins = array_merge($active_plugins, $active_sitewide_plugins);
            }
            ?>

            <section class="yeti-section">
                <header style="color: #e74c3c;"><?php printf(__('Active Plugins (%d)', 'yetithemes'), count($active_plugins)); ?></header>
                <table class="yeti_status_table widefat" cellspacing="0" border="0">
                    <tbody>
                    <?php
                    $stt = 1;
                    foreach ($active_plugins as $plugin):
                        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin); ?>

                        <?php if (!empty($plugin_data['Title'])): ?>
                        <tr>
                            <td data-export-label="<?php echo esc_attr($plugin_data['Name']) ?>"><?php echo $plugin_data['Title']; ?></td>
                            <td class="help">&nbsp;</td>
                            <td><?php echo sprintf(__('by %s &ndash; %s', 'yetithemes'), $plugin_data['Author'], esc_html($plugin_data['Version'])); ?></td>
                        </tr>

                        <?php endif; ?>

                    <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <?php
            $import_arrs = Yetithemes_Importer()->getThemeHomepages();

            $home_k = isset($import_arrs['homepages']) ? $import_arrs['homepages'] : array();

            $homes_installed = (array)@unserialize(get_option('nth_theme_imported', array()));
            $home_current = get_option('nth_theme_current', false);
            $__preview_url = 'http://demo.nexthemes.com/wordpress/omeo/';

            if (count($home_k) > 0): ?>
                <section class="yeti-section">
                    <header><?php _e('Dummy homepage', 'yetithemes'); ?></header>
                    <table class="yeti_status_table widefat" cellspacing="0" border="0">
                        <tbody>
                        <tr><td>Coming soon!</td></tr>
                        </tbody>
                    </table>
                </section>
            <?php endif; ?>

        </div>
    </div>

</div>
