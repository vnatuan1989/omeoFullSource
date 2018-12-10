<?php
$term = get_term_by("slug", $category, "product_cat");
$product_categories = get_categories(apply_filters('woocommerce_product_subcategories_args', array(
    'parent' => $term->term_id,
    'menu_order' => 'ASC',
    'hide_empty' => 0,
    'hierarchical' => 1,
    'taxonomy' => 'product_cat',
    'pad_counts' => 1,
)));

?>
<article class="woocommerce-product-cat-section" id="<?php echo esc_attr($_shortcode_id) ?>">
    <header class="heading-wrap" style="background-color: <?php echo esc_attr($h_bg) ?>; ">
        <h3 class="<?php echo esc_attr($h_color) ?>"><?php echo esc_html($title) ?></h3>

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

    <div class="col-sm-12 no-padding">
        <?php if (absint($banner_bg) > 0) : ?>
            <div class="yeti-shortcode yeti-banner">
                <figure>
                    <?php echo wp_get_attachment_image($banner_bg, 'full'); ?>

                    <?php if (strlen(trim($content)) > 0) : ?>
                        <figcaption>
                            <p><?php echo wp_kses_post($content) ?></p>
                        </figcaption>
                    <?php endif; ?>

                </figure>
            </div>
        <?php endif; ?>

        <div class="product-tabs">
            <?php
            $shortcode_str =
                '[vc_tta_tabs active_section="1" yeti_tabs_style="yeti-tab-style1"]' .
                '[vc_tta_section title="New Items" tab_id="' . esc_attr($_shortcode_id) . '-newitems"]' .
                '[yesshop_recent_products per_page="8" columns="5" orderby="date" order="DESC"]' .
                '[/vc_tta_section]' .
                '[vc_tta_section title="Top rated items" tab_id="' . esc_attr($_shortcode_id) . '-toprate"]' .
                '[yesshop_top_rated_products per_page="8" columns="5"]' .
                '[/vc_tta_section]' .
                '[vc_tta_section title="Sale-off items" tab_id="1' . esc_attr($_shortcode_id) . '-saleoff"]' .
                '[yesshop_sale_products per_page="8" columns="5"]' .
                '[/vc_tta_section][/vc_tta_tabs]';
            echo do_shortcode($shortcode_str);
            ?>
        </div>
    </div>

    <div class="col-sm-8 no-padding">
        <?php echo do_shortcode('[yesshop_products_category as_widget="1" category="' . esc_attr($category) . '" per_page="5" orderby="rand" order="ASC"]') ?>
    </div>


</article>
