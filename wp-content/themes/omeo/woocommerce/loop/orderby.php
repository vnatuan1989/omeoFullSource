<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>
<form class="woocommerce-ordering form-inline sort-by" method="get">
    <div class="form-group">
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdown_orderby" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                <span class="dropdown-text"><?php echo esc_attr($catalog_orderby_options[$orderby]); ?></span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_orderby">
                <li class="dropdown-item" data-val="<?php echo esc_attr($orderby) ?>">
                    <a href="#"><?php echo esc_html($catalog_orderby_options[$orderby]) ?></a>
                </li>
                <li role="separator" class="divider"></li>
                <?php foreach ($catalog_orderby_options as $id => $name) : if (strcmp($id, $orderby) === 0) continue; ?>
                    <li data-val="<?php echo esc_attr($id); ?>"><a href="#"><?php echo esc_html($name); ?></a></li>
                <?php endforeach; ?>
            </ul>
            <input type="hidden" name="orderby" class="orderby dropdown-value"
                   value="<?php echo esc_attr($orderby); ?>">
            <input type="hidden" name="paged" value="1" />
            <?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
        </div>
    </div>

</form>


<form class="woocommerce-ordering form-inline show-by" method="get">
    <?php
    do_action('yesshop_woocommerce_orderby_select_after');
    // Keep query string vars intact
    foreach ($_GET as $key => $val) {
        if ('per_show' === $key || 'orderby' === $key || 'submit' === $key) {
            continue;
        }
        if (is_array($val)) {
            foreach ($val as $innerVal) {
                echo '<input type="hidden" name="' . esc_attr($key) . '[]" value="' . esc_attr($innerVal) . '" />';
            }
        } else {
            echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" />';
        }
    }
    ?>
</form>
