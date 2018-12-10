<?php

global $woocommerce_loop;

$woocommerce_loop['columns'] = $columns;

$fills = array_map('trim', explode(',', $cat_fills));

$heading_start = '<div class="yeti-shortcode-header"><h3 class="heading-title ud-line">';
$heading_end = '</h3></div>';

$item_class = array('feature-cat');
$_wrap_class = array('yeti-woo-shortcode');
$_wrap_class[] = function_exists('vc_shortcode_custom_css_class')? vc_shortcode_custom_css_class($css): '';

switch ($style) {
    case 'none-style':
        $_s_img = false;
        break;
    default:
        $_s_img = true;
}

$item_class[] = esc_attr($style);

if($columns > 1) {
    $item_class[] = 'col-lg-' . round(24 / $columns);
    $item_class[] = 'col-md-' . round(24 / round($columns * 992 / 1200));
    $item_class[] = 'col-sm-' . round(24 / round($columns * 768 / 1200));
    $item_class[] = 'col-xs-' . round(24 / round($columns * 480 / 1200));
    $item_class[] = 'col-mb-24';
} else {
    $item_class[] = 'col-sm-24';
}

if (isset($is_slider) && absint($is_slider)) {

    if (absint($columns) > 1)
        $options = array(
            "items" => $columns,
            "responsive" => array(
                0 => array(
                    'items' => 2,
                    'loop' => false
                )
            ),
            "autoPlay" => isset($auto_play) && absint($auto_play) ? true : false,
        );
    else {
        $options = array(
            "items" => 3,
            "autoPlay" => isset($auto_play) && absint($auto_play) ? true : false,
        );
    }
    $options = YetiThemes_Extra()->get_owlResponsive($options);
    printf('<div class="'.esc_attr(implode(' ', $_wrap_class)).' yeti-owlCarousel yeti-loading light" data-options="%1$s" data-base="1">', esc_attr(json_encode($options)));
    YetiThemes_Extra()->get_yetiLoadingIcon();
} else {
    echo '<div class="'.esc_attr(implode(' ', $_wrap_class)).'">';

}
?>

    <div class="content-inner">
        <div class="row">
            <div class=" yeti-owl-slider feature-prod-cat-wrapper <?php echo esc_attr($style) ?>">

                <?php foreach ($cats_group as $category) {
                    $small_thumbnail_size = 'full';

                    if(empty($category['term'])) continue;

                    if($_s_img) {
                        if(empty($category['cat_image'])) {
                            $category['cat_image'] = get_term_meta($category['term']->term_id, 'thumbnail_id', true);
                            $small_thumbnail_size = 'shop_catalog';
                        }

                        if ($category['cat_image']) {
                            $image = wp_get_attachment_image($category['cat_image'], $small_thumbnail_size);
                        } else {
                            $image = '<img alt="Placeholder" src="' . wc_placeholder_img_src() . '"/>';
                        }
                    }

                    $before = '';
                    $after = '';
                    $head_before = '';
                    $head_after = '';
                    if (strcmp($style, 'inside-meta') == 0 || strcmp($style, 'inside-meta-2') == 0) {
                        $before .= sprintf('<a href="%s" title="%s">', esc_url(get_term_link($category['term']->slug, 'product_cat')), esc_attr($category['term']->name));
                        $after .= '</a>';
                    } elseif (in_array('link', $fills)) {
                        $head_before .= sprintf('<a href="%s" title="%s">', esc_url(get_term_link($category['term']->slug, 'product_cat')), esc_attr($category['term']->name));
                        $head_after .= '</a>';
                    }

                    switch ($style) {
                        case 'inside-meta':
                        case 'inside-meta-2':
                            $s_meta = false;
                            break;
                        default:
                            $s_meta = true;
                    }

                    ?>
                    <div class="<?php echo esc_attr(implode(' ', $item_class)) ?>">
                        <div class="feature-cat-inner">
                            <?php echo $before; ?>


                            <?php if (isset($image)): ?>
                                <?php echo $head_before; ?>
                                <div class="f-thumbnail">
                                    <?php echo $image; ?>
                                </div>
                                <?php echo $head_after; ?>
                            <?php endif; ?>


                            <div class="f-meta text-center">

                                <?php if(!in_array('title', $fills)): ?>
                                    <?php echo $head_before; ?>
                                    <h3><?php echo esc_html($category['term']->name) ?></h3>
                                    <?php echo $head_after; ?>
                                <?php endif;?>

                                <?php if (!in_array('count', $fills)) : ?>
                                    <p><?php printf(_n('%s product', '%s products', absint($category['term']->count), 'yetithemes'), absint($category['term']->count)) ?></p>
                                <?php endif; ?>

                                <?php if (!in_array('link', $fills)) : ?>
                                    <a href="<?php echo esc_url(get_term_link($category['term']->slug, 'product_cat')); ?>"
                                       title="<?php echo esc_attr($category['term']->name); ?>" class="btn"><?php _e('Shop Now', 'yetithemes'); ?></a>
                                <?php endif; ?>
                                    
                            </div>

                            <?php echo $after; ?>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>

<?php

echo "</div><!--.yeti-owlCarousel-->";

?>