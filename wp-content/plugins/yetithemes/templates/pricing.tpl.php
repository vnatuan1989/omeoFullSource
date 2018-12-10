<?php
$ul_class = 'yeti-pricing-ul list-unstyled';
$_wrap_class = 'yeti-pricing-wrapper';
if (strlen($type) > 0) $_wrap_class .= ' ' . esc_attr($type);
if (absint($style) > 0) $_wrap_class .= ' style-' . absint($style);

?>

<div class="<?php echo esc_attr($_wrap_class) ?>">
    <ul class="yeti-pricing-ul list-unstyled">
        <li class="widget-heading">
            <h3 class="heading-title"><?php echo esc_attr($title); ?></h3>
        </li>
        <li class="prices">
			<span class="price_table">
				<?php
                $prices = array_map('trim', explode('|', $price));
                if (count($prices) == 2) array_unshift($prices, "");
                ?>
                <sup class="currency_symbol"><?php echo esc_attr($prices[0]); ?></sup>
				<span class="pricing"><?php echo esc_attr($prices[1]); ?></span>
				<sub class="mark"><?php printf(__('/%s', 'yetithemes'), esc_attr($prices[2])); ?></sub>
			</span>
        </li>
        <?php if (strlen($desc) > 0): ?>
            <li class="desc"><?php echo esc_attr($desc); ?></li>
        <?php endif; ?>

        <?php
        if (strlen($features) > 0):
            $features = (array)vc_param_group_parse_atts($features);
            //$features = array_map( 'trim', explode(',', wp_strip_all_tags($features)) );
            ?>
            <?php
            foreach ($features as $feature):
                if (isset($feature['title']) && strlen($feature['title']) > 0):
                    ?>
                    <li class="feature">
                        <strong><?php echo do_shortcode($feature['title']); ?></strong>
                        <?php if (isset($feature['tooltip']) && strlen($feature['tooltip']) > 0) {
                            echo esc_attr($feature['tooltip']);
                        }
                        ?></li>
                    <?php
                endif;
            endforeach;
            ?>
        <?php endif; ?>

        <li class="price-buttons">
            <?php printf('<a class="btn btn-primary" href="%1$s" title="%2$s" %3$s>%4$s</a>', esc_url($bt_link['url']), esc_attr($bt_link['title']), $bt_link['target'], esc_html($bt_text)); ?>
        </li>
    </ul>
</div>