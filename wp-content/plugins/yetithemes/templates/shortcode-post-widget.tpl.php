<?php if (strlen($title) > 0): ?>

<div class="yeti-shortcode-header">
    <?php $head_style = strlen($head_style) > 0 ? ' ' . $head_style : ''; ?>
    <h3 class="heading-title<?php echo esc_attr($head_style) ?>"><?php echo esc_html($title); ?></h3>
</div>

<?php endif; ?>

<?php
if (absint($as_widget)) {
    echo '<ul class="list-post-widget">';
} else {
    if (isset($is_slider) && absint($is_slider)) {
        $options = array(
            "items" => $columns,
        );
        $options = YetiThemes_Extra()->get_owlResponsive($options);
        $class = ' yeti-owl-slider';
        echo '<div class="yeti-owlCarousel yeti-loading light" data-options="' . esc_attr(json_encode($options)) . '" data-base="1">';
        YetiThemes_Extra()->get_yetiLoadingIcon();
    } else {
        $class = '';
    }
    echo '<ul class="row list-posts' . esc_attr($class) . '">';
}

?>

<?php while ($_post->have_posts()): $_post->the_post();
    global $post; ?>

    <?php if (absint($as_widget)): ?>

        <?php get_template_part('content', 'widget'); ?>

    <?php else: ?>

        <?php get_template_part('content', get_post_format()); ?>

    <?php endif; ?>

<?php endwhile; ?>

</ul>

<?php if (!absint($as_widget) && isset($is_slider) && absint($is_slider)) echo '</div>'; ?>
