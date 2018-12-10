<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_account_navigation');


if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
}
?>

<nav class="col-sm-5 col-md-5 woocommerce-MyAccount-navigation">
    <ul>
        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
            <?php
            $src = '#';

            if (isset($label['icon'])) {
                $_icon_class = $label['icon'];
            } else {
                $_icon_class = 'fa fa-cog';
            }

            if (is_array($label)) {
                if (isset($label['url'])) {
                    $src = $label['url'];
                } else {
                    $src = wc_get_account_endpoint_url($endpoint);;
                }
                $label = $label['label'];
            } else {
                $src = wc_get_account_endpoint_url($endpoint);
            }
            ?>

            <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                <a href="<?php echo esc_url($src); ?>">
                    <?php
                    echo '<i class="' . esc_attr($_icon_class) . '" aria-hidden="true"></i>&nbsp';
                    echo esc_html($label); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
