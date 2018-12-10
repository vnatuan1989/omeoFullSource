<?php
global $woocommerce_loop;

$woocommerce_loop['columns'] = $columns;

if (strlen(trim($head_style)) > 0) $head_style = ' ' . $head_style;
$heading_start = '<div class="yeti-shortcode-header"><h3 class="heading-title' . esc_attr($head_style) . '">';
$heading_end = '</h3></div>';

if (empty($product_mode)) $product_mode = 'grid';
if (empty($rows)) $rows = 1;

$class1 = 'yeti-woo-shortcode';
if (isset($woocommerce_loop['name'])) {
    $class1 .= ' ' . $woocommerce_loop['name'];
}
if (isset($is_deal) && absint($is_deal)) {
    $class1 .= ' deal-products';
}


echo '<div class="' . esc_attr($class1) . ' yeti-featured-list-mode-2">';

$_loop_args = array('is_slider' => $is_slider, 'product_mode' => $product_mode, 'is_shortcode' => true);
?>

<?php if (strlen($title) > 0) : ?>

    <?php echo $heading_start . esc_attr($title) . $heading_end; ?>

<?php endif; ?>

<div class="content-inner">

    <div class="row">

        <?php wc_get_template('loop/loop-start.php', $_loop_args); ?>

        <?php $i = 0;
        while ($products->have_posts()) : $products->the_post(); ?>

            <?php
            if (absint($is_slider) && absint($rows) > 1 && ($i % absint($rows)) === 0) {
                echo '<div class="row-item">';
            }
            ?>

            <?php wc_get_template_part('content', 'product-featured'); ?>

            <?php
            if (absint($is_slider) && absint($rows) > 1 && (($i + 1) % absint($rows) === 0 || ($i + 1) === $products->post_count)) {
                echo '</div>';
            }
            $i++;
            ?>

        <?php endwhile; // end of the loop. ?>

        <?php woocommerce_product_loop_end(); ?>

    </div>

</div>

<?php echo "</div><!-- END .yeti-woo-shortcode -->"; ?>

<?php woocommerce_reset_loop(); ?>
