<?php
global $woocommerce_loop;

$head_class = array('heading-title');
if (strlen(trim($head_style)) > 0) $head_class[] = esc_attr($head_style);
$heading_start = '<div class="yeti-shortcode-header"><h3 class="' . esc_attr(implode(' ', $head_class)) . '">';
$heading_end = '</h3></div>';

$function = isset($woocommerce_loop['function']) ? $woocommerce_loop['function'] : 0;

$_shortcode_class = 'yeti-woo-shortcode';
if (!empty($widget_style)) $_shortcode_class .= ' ' . $widget_style;
?>
<div class="<?php echo esc_attr($_shortcode_class) ?> shortcode-widget-product">

    <?php if (strlen($title) > 0): ?>

        <?php echo $heading_start; ?><?php echo esc_html($title); ?><?php echo $heading_end; ?>

    <?php endif ?>

    <div class="content-inner">

        <?php echo apply_filters('woocommerce_before_widget_product_list', '<ul class="product_list_widget ' . esc_attr($item_style) . '">'); ?>

        <?php
        $classes = array();
        if (absint($columns) > 1) {
            $classes[] = 'col-lg-' . round(24 / $columns);
            $classes[] = 'col-md-' . round(24 / round($columns * 992 / 1200));
            $classes[] = 'col-sm-' . round(24 / round($columns * 768 / 1200));
            $classes[] = 'col-xs-' . round(24 / round($columns * 480 / 1200));
            $classes[] = 'col-mb-12';
        } else {
            $classes[] = 'col-sm-24';
        }

        $num = 1;
        ?>

        <?php while ($products->have_posts()) : $products->the_post(); ?>

            <?php wc_get_template('content-widget-product.php', array('show_rating' => true, '_num_order' => absint($num_order)?$num++:0, 'classes' => $classes)); ?>

        <?php endwhile; ?>

        <?php echo apply_filters('woocommerce_after_widget_product_list', '</ul>'); ?>

    </div>

</div>