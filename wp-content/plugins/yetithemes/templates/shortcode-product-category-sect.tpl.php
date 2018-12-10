<?php
$_term_args = apply_filters('woocommerce_product_subcategories_args', array(
    'menu_order' => 'ASC',
    'hide_empty' => 0,
    'hierarchical' => 1,
    'taxonomy' => 'product_cat',
    'pad_counts' => 1,
));

if(!empty($category)) {
    $term = get_term_by("slug", $category, "product_cat");
    $_term_args['parent'] = $term->term_id;
}
if (absint($cat_limit) > 0) {
    $_term_args['number'] = absint($cat_limit);
}
$product_categories = get_categories($_term_args);

$_col_left = 'col-sm-16';
$_col_right = 'col-sm-8';

if ($style === 'small_section') {
    $_col_left = 'col-sm-12';
    $_col_right = 'col-sm-12';
}

?>
<article class="woocommerce-product-cat-section" id="<?php echo esc_attr($_shortcode_id) ?>">
    <header class="heading-wrap" style="border-color: <?php echo esc_attr($h_bg) ?>; ">
        <h3 style="color: <?php echo esc_attr($h_bg) ?>"><?php echo esc_html($title) ?></h3>

        <?php
        if (!empty($product_categories)) : ?>
            <ul class="list-inline pull-right">

                <?php foreach ($product_categories as $cat) : ?>

                    <li><a class="<?php echo esc_attr($h_color) ?>"
                           href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                           title="<?php echo esc_attr($cat->name) ?>"><?php echo esc_attr($cat->name) ?></a></li>

                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </header>

    <div class="<?php echo esc_attr($_col_left); ?> cat-section-left">
        <?php if (strlen($banner_bg) > 0) : ?>
            <div class="yeti-shortcode yeti-banner">
                <figure>
                    <?php
                    if(is_numeric($banner_bg)) {
                        echo wp_get_attachment_image($banner_bg, 'full');
                    } else {
                        printf('<img src="%s" alt="Banner bg" title="Banner bg">', esc_url($banner_bg));
                    }
                    ?>

                    <?php if (strlen(trim($content)) > 0) : ?>
                        <figcaption>
                            <p><?php echo do_shortcode($content); ?></p>
                        </figcaption>
                    <?php endif; ?>

                </figure>
            </div>
        <?php endif; ?>

        <?php if ($style !== 'small_section') : ?>
            <div class="product-tabs">
                <?php
                if(isset($prod_tabs) && absint($prod_tabs)) {
                    $shortcode_str =
                        '[vc_tta_tabs active_section="1" yeti_tabs_style="yeti-tab-style1"]' .
                        '[vc_tta_section title="' . esc_attr($new_t_title) . '" tab_id="' . esc_attr($_shortcode_id) . '-newitems"]' .
                        '[yesshop_recent_products category="' . esc_attr($category) . '" per_page="' . absint($per_page) . '" columns="' . absint($columns) . '" orderby="date" order="DESC"]' .
                        '[/vc_tta_section]' .
                        '[vc_tta_section title="' . esc_attr($top_rated_t_title) . '" tab_id="' . esc_attr($_shortcode_id) . '-toprate"]' .
                        '[yesshop_top_rated_products category="' . esc_attr($category) . '" per_page="' . absint($per_page) . '" columns="' . absint($columns) . '"]' .
                        '[/vc_tta_section]' .
                        '[vc_tta_section title="' . esc_attr($sale_t_title) . '" tab_id="1' . esc_attr($_shortcode_id) . '-saleoff"]' .
                        '[yesshop_sale_products category="' . esc_attr($category) . '" per_page="' . absint($per_page) . '" columns="' . absint($columns) . '"]' .
                        '[/vc_tta_section][/vc_tta_tabs]';
                } else {
                    $shortcode_str = '[yesshop_recent_products category="' . esc_attr($category) . '" per_page="' . absint($per_page) . '" columns="' . absint($columns) . '" orderby="date" order="DESC"]';
                }

                echo do_shortcode($shortcode_str);
                ?>
            </div>
        <?php endif; ?>

    </div>

    <div class="<?php echo esc_attr($_col_right); ?> cat-section-right">
        <h3 class="heading-title"><?php echo esc_attr('Top Rated', 'yetithemes'); ?></h3>
        <?php echo do_shortcode('[yesshop_top_rated_products columns="1" as_widget="1" category="' . esc_attr($category) . '" per_page="' . absint($per_page_v) . '" orderby="rand" order="ASC"]') ?>
    </div>


</article>
