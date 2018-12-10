<?php

if (strlen(trim($head_style)) > 0) $head_style = ' ' . $head_style;
$heading_start = '<div class="yeti-shortcode-header"><h3 class="heading-title' . esc_attr($head_style) . '">';
$heading_end = '</h3></div>';

if (isset($is_slider) && absint($is_slider)) {
    if (absint($columns) > 1) {
        $mb_column = isset($item_style) && strcmp($item_style, 'list') == 0 ? 1 : 2;
        $options = array(
            "items" => $columns,
            "responsive" => array(
                0 => array(
                    'items' => $mb_column,
                    'loop' => true
                )
            ),
            "autoPlay" => isset($auto_play) && absint($auto_play) ? true : false,
        );
    } else {
        $options = array(
            "items" => 3,
            "autoPlay" => isset($auto_play) && absint($auto_play) ? true : false,
        );
    }
    $options = YetiThemes_Extra()->get_owlResponsive($options);
    printf('<div class="yeti-woo-shortcode yeti-owlCarousel yeti-loading light" data-options="%1$s" data-base="1">', esc_attr(json_encode($options)));
    YetiThemes_Extra()->get_yetiLoadingIcon();
} else {
    echo '<div class="yeti-woo-shortcode>';
}

$classes = array();
if (absint($columns) > 1) {
    $classes[] = 'col-lg-' . round(24 / $columns);
    $classes[] = 'col-md-' . round(24 / round($columns * 992 / 1200));
    $classes[] = 'col-sm-' . round(24 / round($columns * 768 / 1200));
    $classes[] = 'col-xs-' . round(24 / round($columns * 480 / 1200));
    $classes[] = 'col-mb-12';
} else {
    $resp[] = 'col-lg-24';
    $resp[] = 'col-md-24';
    $resp[] = 'col-sm-24';
    $resp[] = 'col-xs-24';
    $resp[] = 'col-mb-24';
}

?>

<?php if (strlen($title) > 0): ?>

    <?php echo $heading_start . esc_attr($title) . $heading_end; ?>

<?php endif; ?>

    <div class="content-inner">

        <div class="row">

            <div class="products_super_deal yeti-owl-slider">
                <?php
                while ($products->have_posts()) :
                    $products->the_post();
                    global $product;

                    $attachment_ids = $product->get_gallery_image_ids();
                    if (!empty($attachment_ids)) {
                        $attachment_ids = end($attachment_ids);
                    }
                    ?>

                    <section <?php post_class($classes); ?>>
                        <a href="<?php the_permalink(); ?>">
                            <?php
                            if (!empty($attachment_ids)) {
                                echo wp_get_attachment_image($attachment_ids, 'yesshop_product_super_deal');
                            } else {
                                echo woocommerce_get_product_thumbnail('yesshop_product_super_deal');
                            }
                            ?>

                            <?php do_action('yesshop_woocommerce_super_deal_after_image'); ?>
                        </a>
                        <div class="product-meta">
                            <h3 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php if ($price_html = $product->get_price_html()) : ?>
                                <span class="price"><?php echo $price_html; ?></span>
                            <?php endif; ?>
                            <?php if (function_exists('yesshop_product_labels')) yesshop_product_labels(); ?>
                        </div>
                    </section>

                <?php endwhile; // end of the loop. ?>
            </div>

        </div><!-- END .yeti-woo-shortcode -->

    </div>

<?php echo "</div>"; ?>