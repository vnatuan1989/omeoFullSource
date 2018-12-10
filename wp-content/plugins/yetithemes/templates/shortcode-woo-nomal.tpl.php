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

$function = isset($woocommerce_loop['function']) ? $woocommerce_loop['function'] : 0;

if (isset($is_slider) && absint($is_slider)) {
    if (absint($columns) > 0) {

        if ($product_mode === 'grid' && absint($columns) === 1) $columns = 3;

        $options = array(
            'items' => absint($columns),
            'responsive' => array(
                0 => array(
                    'items' => 2,
                    'loop' => true
                )
            ),
        );
    }
    $options = YetiThemes_Extra()->get_owlResponsive($options);
    printf('<div class="%2$s yeti-owlCarousel yeti-loading light" data-options="%1$s" data-base="1">', esc_attr(json_encode($options)), $class1);
    YetiThemes_Extra()->get_yetiLoadingIcon();
} else {
    echo '<div class="' . esc_attr($class1) . '">';
}

$_loop_args = array('is_slider' => $is_slider, 'product_mode' => $product_mode, 'is_shortcode' => true);
?>

<?php if (strlen($title) > 0) : ?>

    <?php echo $heading_start . esc_attr($title) . $heading_end; ?>

<?php endif; ?>

<div class="content-inner">

    <div class="row">

        <?php wc_get_template('loop/loop-start.php', $_loop_args); ?>

        <?php if(!empty($bg_img_id)): ?>

            <section class="pull-left <?php echo esc_attr($b_class)?>"><?php echo do_shortcode('[yesshop_banner bg_source="media" bg_img_id="'.absint($bg_img_id).'"]'.wp_kses_post($content).'[/yesshop_banner]');?></section>

        <?php endif;?>

        <?php $i = 0;
        while ($products->have_posts()) : $products->the_post(); ?>

            <?php
            if (absint($is_slider) && absint($rows) > 1 && ($i % absint($rows)) === 0) {
                echo '<div class="row-item">';
            }
            ?>

            <?php wc_get_template_part('content', 'product'); ?>

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

<?php wc_reset_loop(); ?>

<?php

if(isset($step) && absint($step) && absint($is_slider) == 0 && isset($total) && $total > $products->post_count && absint($load_more) == 1) {

    $_offset = isset($products->query_vars['offset'])? absint($products->query_vars['offset']): 0;

    $atts['per_page'] = !empty($step)? absint($step): 4;
    $atts['offset'] = absint($products->post_count) + absint($_offset);
    $atts['action'] = 'yeti_woo_loadmore';
    $atts['context'] = 'frontend';
    $atts['function'] = $function;

    if(isset($cats)) $atts['cats'] = $cats;
    if(isset($item_style)) $atts['item_style'] =  $item_style;
    if(isset($head_style)) $atts['head_style'] = $head_style;
    if(isset($prod_filter)) $atts['prod_filter'] =  $prod_filter;
    if(isset($as_widget)) $atts['as_widget'] =  $as_widget;
    if(isset($columns)) $atts['columns'] =  $columns;
    if(isset($orderby)) $atts['orderby'] =  $orderby;
    if(isset($order))  $atts['order'] =  $order;
    if(isset($is_slider)) $atts['is_slider'] =  $is_slider;
    if(isset($step)) $atts['step'] =  $step;
    if(isset($use_ajax)) $atts['use_ajax'] =  $use_ajax;
    if(isset($slider_nav)) $atts['slider_nav'] =  $slider_nav;
    if(isset($content)) $atts['content'] = $content;
    if(isset($rows)) $atts['rows'] = $rows;
    if(isset($category)) $atts['category'] = $category;
    if(isset($btn_load_more_text) && !empty($btn_load_more_text))
        $atts['btn_load_more_text'] = $btn_load_more_text;
    else
        $atts['btn_load_more_text'] = esc_attr__('More Products', 'yetithemes');

    echo '<div class="woo-footer text-center">';
    printf('<a href="#" class="button yeti-woo-load-more" data-atts="%s">%s</a>', esc_attr(wp_json_encode($atts)), $atts['btn_load_more_text'] );
    echo '</div>';
}