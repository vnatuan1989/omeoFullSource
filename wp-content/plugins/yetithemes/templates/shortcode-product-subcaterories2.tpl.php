<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 11/23/2015
 * Vertion: 1.0
 */


if(empty($ops['slug'])) return;
$term = get_term_by("slug", $ops['slug'], "product_cat");

if($term):

$classes = array('woo-subcat-item');
if (absint($columns) > 1 && absint($is_slider) == 0) {
    $classes[] = 'col-lg-' . round(24 / $columns);
    $classes[] = 'col-md-' . round(24 / round($columns * 992 / 1200));
    $classes[] = 'col-sm-' . round(24 / round($columns * 768 / 1200));
    $classes[] = 'col-xs-' . round(24 / round($columns * 480 / 1200));
}

if(!empty($ops['bg_img'])) {
    $image = wp_get_attachment_image($ops['bg_img'], 'full');
} else {
    $cat_thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
    if ($cat_thumb_id) {
        $image = wp_get_attachment_image($cat_thumb_id, 'thumbnail');
    } else {
        $image = false;
    }
}

$product_categories = get_categories(apply_filters('woocommerce_product_subcategories_args', array(
    'parent' => $term->term_id,
    'menu_order' => 'ASC',
    'hide_empty' => 0,
    'hierarchical' => 1,
    'taxonomy' => 'product_cat',
    'pad_counts' => 1,
    'number' => $per_page
)));

?>

<div class="<?php echo esc_attr(implode(' ', $classes))?>">
    <div class="woo-subcat-wrapper">
        <?php if($image): ?>
            <div class="image">
                <?php echo $image; ?>
            </div>
        <?php endif;?>
        <div class="cat-detail">
            <?php if(!isset($s_cat_title) || absint($s_cat_title)): ?>
                <h3 class="cat-title">
                    <a href="<?php echo esc_url(get_term_link($term->slug, 'product_cat')); ?>" title="<?php echo esc_attr($term->name); ?>">
                        <?php echo esc_html($term->name) ?>
                    </a>
                </h3>
            <?php endif;?>
            <?php
            $ul_class = 'sub-cat list';
            $li_class = 'sub-cat-item';
            if($list_2_col) {
                $li_class .= ' col-sm-12 col-xs-12';
                echo '<div class="row">';
            }
            ?>
            <ul class="sub-cat list">
                <?php
                foreach ($product_categories as $category) :
                    ?>
                    <li class="<?php echo esc_attr($li_class)?>">
                        <a href="<?php echo esc_url(get_term_link($category->slug, 'product_cat')); ?>"
                           title="<?php echo esc_attr($category->name); ?>">
                            <?php echo $category->name; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if ($list_2_col) echo '</div>'; ?>

        </div>

    </div>
</div>
<?php endif; ?>
