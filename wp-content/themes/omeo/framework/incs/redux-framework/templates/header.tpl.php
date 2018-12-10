<?php
/**
 * The template for the panel header area.
 * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
 *
 * @author      Redux Framework
 * @package     ReduxFramework/Templates
 * @version:    3.5.4.18
 */

$tip_title = esc_attr__('Developer Mode Enabled', 'omeo');

if ($this->parent->dev_mode_forced) {
    $is_debug = false;
    $is_localhost = false;

    $debug_bit = '';
    if (Redux_Helpers::isWpDebug()) {
        $is_debug = true;
        $debug_bit = esc_attr__('WP_DEBUG is enabled', 'omeo');
    }

    $localhost_bit = '';
    if (Redux_Helpers::isLocalHost()) {
        $is_localhost = true;
        $localhost_bit = esc_attr__('you are working in a localhost environment', 'omeo');
    }

    $conjunction_bit = '';
    if ($is_localhost && $is_debug) {
        $conjunction_bit = ' ' . esc_attr__('and', 'omeo') . ' ';
    }

    $tip_msg = esc_attr__('This has been automatically enabled because', 'omeo') . ' ' . $debug_bit . $conjunction_bit . $localhost_bit . '.';
} else {
    $tip_msg = esc_attr__('If you are not a developer, your theme/plugin author shipped with developer mode enabled. Contact them directly to fix it.', 'omeo');
}

?>
<div id="redux-header">
    <?php if (!empty($this->parent->args['display_name'])) { ?>
        <div class="display_header">
            <h2><?php echo wp_kses_post($this->parent->args['display_name']); ?></h2>

            <?php if (!empty($this->parent->args['display_version'])) { ?>
                <span><?php echo wp_kses_post($this->parent->args['display_version']); ?></span>
            <?php } ?>

        </div>
    <?php } ?>

    <div class="clear"></div>
</div>