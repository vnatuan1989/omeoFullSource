<?php

if (strlen($title) > 0) {
    echo '<div class="yeti-shortcode-header">';
    $heading_class = array('heading-title');
    if (strlen(trim($h_style)) > 0) $heading_class[] = esc_attr($h_style);
    echo '<h3 class="' . esc_attr(implode(' ', $heading_class)) . '">' . esc_html($title) . '</h3>';
    echo '</div>';
}

$options = array(
    "items" => $column,
    'responsive' => array(
        0 => array(
            'items' => 2,
            'loop' => false,
            'autoplay' => false,
        ),
    )
);
$options = YetiThemes_Extra()->get_owlResponsive($options);

$ul_class = function_exists('vc_shortcode_custom_css_class')? vc_shortcode_custom_css_class($css): '';
if (strlen($style) > 0) {
    $ul_class .= ' style-' . esc_attr($style);
}

?>

<div class="row">

    <div class="yeti-owlCarousel yeti-loading light" data-options="<?php echo esc_attr(json_encode($options)); ?>"
         data-base="1">

        <?php YetiThemes_Extra()->get_yetiLoadingIcon(); ?>

        <div class="yeti-owl-slider <?php echo esc_attr($ul_class); ?>">

            <?php foreach ($items as $item): if (empty($item['img_id']) || absint($item['img_id']) == 0) continue; ?>

                <div class="col-sm-24">

                    <div class="item-inner">

                        <?php

                        if (!empty($item['link']) && !empty($item['link']['url'])) {
                            $_link_bf = '<a href="' . esc_url($item['link']['url']) . '"';
                            if (!empty($item['link']['title'])) $_link_bf .= ' title="' . esc_attr($item['link']['title']) . '"';
                            if (!empty($item['link']['target'])) $_link_bf .= ' target="' . esc_attr($item['link']['target']) . '"';
                            if (!empty($item['link']['rel'])) $_link_bf .= ' rel="' . esc_attr($item['link']['rel']) . '"';
                            $_link_bf .= '>';

                            echo wp_kses_post($_link_bf);
                        }
                        ?>

                        <?php echo wp_get_attachment_image($item['img_id'], 'full'); ?>

                        <?php if (!empty($item['link']) && !empty($item['link']['url'])) echo '</a>'; ?>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>