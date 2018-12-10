<?php if (strlen(trim($title)) > 0):

    $heading_class = array('heading-title');
    if (strlen(trim($h_style)) > 0) $heading_class[] = esc_attr($h_style);
    echo '<div class="yeti-shortcode-header">';
    echo '<h3 class="' . esc_attr(implode(' ', $heading_class)) . '">' . esc_html($title) . '</h3>';
    echo '</div>';

endif;

$_wrap_class = array('testimonials-wrapper');
$options = array();
if (strcmp($use_slider, 'true') == 0) {
    $_wrap_class[] = 'yeti-owlCarousel yeti-loading light';
    $options = array(
        'items' => 1,
        'nav' => false,
        'dots' => true
    );
    $options = YetiThemes_Extra()->get_owlResponsive($options);
}

$filters = array(
    'image' => $s_avata,
    'desc' => 1,
    'author' => 1,
    'top_thumb' => false
);
switch ($style) {
    case '1':
        $_wrap_class[] = 'text-center';
        $filters['top_thumb'] = true;
        break;
    case '2':
        $filters['image'] = 1;
        break;
    case '3':
        $filters['image'] = 0;
        break;
    case '4':
        $_wrap_class[] = 'text-center';
        $filters['image'] = 1;
}
?>

<div class="<?php echo esc_attr(implode(' ', $_wrap_class)) ?>" data-options="<?php echo esc_attr(json_encode($options)); ?>" data-slider=".yeti-owl-slider" data-base="1">

    <?php YetiThemes_Extra()->get_yetiLoadingIcon(); ?>

    <div class="yeti-owl-slider">
        <?php foreach ($yetithemes_testimonials as $testimonial): ?>

            <?php $post = $testimonial; ?>

            <?php setup_postdata($post); ?>

            <div class="testimonials-item">

                <?php if($filters['top_thumb'] && absint($filters['image'])): ?>
                    <div class="image"><?php echo $testimonial->image; ?></div>
                <?php endif; ?>

                <?php if (absint($filters['desc'])) : ?>
                    <div class="description"><?php echo get_the_content(); ?></div>
                <?php endif; ?>

                <?php if (absint($filters['image']) && !$filters['top_thumb']) : ?>
                    <div class="image"><?php echo $testimonial->image; ?></div>
                <?php endif; ?>

                <?php if (absint($filters['author'])) : ?>
                    <h3 class="author"><?php echo $post->post_title; ?></h3>
                    <span class="byline"><?php echo $post->byline; ?></span>
                <?php endif; ?>

            </div>

        <?php endforeach; ?>
    </div>

</div>
