<?php
global $woocommerce_loop;

$heading_start = '<div class="yeti-shortcode-header"><h3 class="heading-title ud-line">';
$heading_end = '</h3></div>';

$_big_width = 'col-md-12';
$_cont_width = 'col-md-12';

$_shortcode_class = 'big-product-wrapper';

if(!isset($is_deal)) $is_deal = false;
if(!isset($supper_style)) $supper_style = '';

if (absint($is_deal)) $_shortcode_class .= ' deal-products';
if (!empty($supper_style)) $_shortcode_class .= ' super-style-' . absint($supper_style);

if (absint($is_slider) && absint($rows) < 2) $rows = 2;
?>
<div class="yeti-woo-shortcode">

    <?php if (strlen($title) > 0): ?>

        <?php echo $heading_start . esc_attr($title) . $heading_end; ?>

    <?php endif; ?>

    <div class="content-inner">

        <div class="row">

            <div class="<?php echo esc_attr($_shortcode_class); ?>">

                <?php
                $i = 0;
                $is_first = true;
                $post_count = isset($products->post_count) ? $products->post_count : $per_page;

                wc_get_template('loop/loop-start.php', array('item_style' => 'grid'));
                while ($products->have_posts()) : $products->the_post();
                    if ($i === 0) {

                        $woocommerce_loop['columns'] = 1;
                        echo '<div class="big-product ' . esc_attr($is_biggest) . ' ' . esc_attr($_big_width) . '"><div class="row">';
                        wc_get_template_part('content', 'product-big');
                        echo '</div></div>';
                        if (absint($is_deal)) {
                            if (class_exists('Yesshop_CountDown')) {
                                add_action('woocommerce_before_shop_loop_item_title', array('Yesshop_CountDown', 'countdown_render'), 90);
                            }
                            remove_action('woocommerce_shop_loop_item_title', 'yesshop_sale_stock_progress', 6);
                        }
                    } else {
                        if ($i === 1) {
                            echo '<div class="' . esc_attr($_cont_width) . ' big-list-products"><div class="row">';

                            if (isset($is_slider) && absint($is_slider)) {
                                if (absint($columns) > 0) {

                                    if ($product_mode === 'grid' && absint($columns) === 1) $columns = 3;

                                    $options = array(
                                        'items' => absint($columns),
                                        'margin' => 0,
                                        'responsive' => array(
                                            0 => array(
                                                'items' => 1,
                                                'loop' => true
                                            )
                                        ),
                                    );
                                }
                                $options = YetiThemes_Extra()->get_owlResponsive($options);
                                printf('<div class="yeti-owlCarousel yeti-loading light" data-options="%1$s" data-base="1">', esc_attr(json_encode($options)));
                                YetiThemes_Extra()->get_yetiLoadingIcon();
                                echo '<div class="yeti-owl-slider">';
                            }
                        }

                        if (absint($is_slider)) {
                            if (absint($rows) > 1 && (($i - 1) % absint($rows)) === 0) {
                                echo '<div class="row-item">';
                            }
                        } else {
                            $woocommerce_loop['columns'] = $columns;
                        }

                        wc_get_template_part('content', 'product');

                        if (absint($is_slider) && absint($rows) > 1 && ($i % absint($rows) === 0 || $i === $products->post_count)) {
                            echo '</div>';
                        }


                        if ($i >= $post_count - 1) {
                            if (isset($is_slider) && absint($is_slider)) {
                                echo '</div></div>';
                            }
                            echo '</div></div>';
                        }
                    }

                    $i++;
                endwhile;

                woocommerce_product_loop_end();

                ?>

            </div>

        </div>

    </div>

</div><!-- END .yeti-woo-shortcode - kinhdon -->

