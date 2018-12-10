<?php

if (strlen($title) > 0) {
    $heading_class = array('heading-title');
    if (strlen(trim($h_style)) > 0) $heading_class[] = esc_attr($h_style);
    echo '<h3 class="' . esc_attr(implode(' ', $heading_class)) . '"><span>' . esc_html($title) . '</span></h3>';
}

$classes = array('yeti-team-members-wrapper');
if (isset($style) && strlen($style) > 0) $classes[] = $style;

$option = array();
if (isset($is_slider) && $is_slider == 'yes') {
    $classes[] = 'yeti-owlCarousel yeti-loading light';
    $options = array(
        "items" => $columns,
    );
    $options = YetiThemes_Extra()->get_owlResponsive($options);
    $columns = 1;
}

echo '<div class="row">';
echo '<div class="' . esc_attr(implode(' ', $classes)) . '" data-options="' . esc_attr(wp_json_encode($options)) . '" data-base="1">';
YetiThemes_Extra()->get_yetiLoadingIcon();
echo '<div class="yeti-owl-slider">';
$classes = array();

if (absint($columns) > 1) {
    $classes[] = 'col-lg-' . round(24 / absint($columns));
    $classes[] = 'col-md-' . round(24 / round(absint($columns) * 992 / 1200));
    $classes[] = 'col-sm-' . round(24 / round(absint($columns) * 768 / 1200));
    $classes[] = 'col-xs-' . round(24 / round(absint($columns) * 480 / 1200));
    $classes[] = 'col-mb-24';
} else {
    $classes[] = 'col-lg-24';
    $classes[] = 'col-md-24';
    $classes[] = 'col-sm-24';
    $classes[] = 'col-xs-24';
    $classes[] = 'col-mb-24';
}



switch ($style) {
    case 'overlay':
    case 'overlay-social':
        $social_class = array(
            'fb' => 'fa fa-facebook',
            'tw' => 'fa fa-twitter',
            'gg' => 'fa fa-google-plus',
            'pin' => 'fa fa-pinterest',
            'ins' => 'fa fa-instagram',
            'in' => 'fa fa-linkedin',
            'dr' => 'fa fa-dribbble',
        );
        break;
    default:
        $social_class = array(
            'fb' => 'fa fa-facebook-square',
            'tw' => 'fa fa-twitter-square',
            'gg' => 'fa fa-google-plus-square',
            'pin' => 'fa fa-pinterest-square',
            'ins' => 'fa fa-instagram',
            'in' => 'fa fa-linkedin-square',
            'dr' => 'fa fa-dribbble',
        );
}

while ($teams->have_posts()) {
    $teams->the_post();
    global $post;
    $meta = unserialize(get_post_meta($post->ID, 'nth_team_options', true));
    $social_args = array();
    if (isset($meta['fb_link']) && strlen($meta['fb_link']) > 0)
        $social_args['facebook'] = array($social_class['fb'], $meta['fb_link']);
    if (isset($meta['tw_link']) && strlen($meta['tw_link']) > 0)
        $social_args['twitter'] = array($social_class['tw'], $meta['tw_link']);
    if (isset($meta['goo_link']) && strlen($meta['goo_link']) > 0)
        $social_args['google'] = array($social_class['gg'], $meta['goo_link']);
    if (isset($meta['pin_link']) && strlen($meta['pin_link']) > 0)
        $social_args['pinterest'] = array($social_class['pin'], $meta['pin_link']);
    if (isset($meta['inst_link']) && strlen($meta['inst_link']) > 0)
        $social_args['instagram'] = array($social_class['ins'], $meta['inst_link']);
    if (isset($meta['in_link']) && strlen($meta['in_link']) > 0)
        $social_args['linkedin'] = array($social_class['in'], $meta['in_link']);
    if (isset($meta['drib_link']) && strlen($meta['drib_link']) > 0)
        $social_args['dribbble'] = array($social_class['dr'], $meta['drib_link']);

    $meta['pr_link'] = isset($meta['pr_link']) && strlen($meta['pr_link']) > 0 ? $meta['pr_link'] : '#';

    ?>
    <div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
        <div class="team-member post-<?php echo esc_attr($post->ID); ?>">

            <?php if (has_post_thumbnail()): ?>
                <div class="thumb">
                    <a title="<?php the_title(); ?>" href="<?php echo esc_url($meta['pr_link']); ?>">
                        <?php the_post_thumbnail('teams_thumb'); ?>
                    </a>

                    <?php if($style === 'overlay-social'): ?>
                        <ul class="yeti-social-network list-inline">
                            <?php foreach ($social_args as $key => $item): ?>
                                <li class="<?php echo esc_attr($key) ?>">
                                    <a href="<?php echo esc_url($item[1]) ?>" title="<?php echo esc_attr($key); ?>">
                                        <i class="<?php echo esc_attr($item[0]); ?>"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="info">
                <h3><a title="<?php the_title(); ?>" href="<?php echo esc_url($meta['pr_link']); ?>"><?php the_title(); ?></a></h3>

                <?php if (isset($meta['role']) && strlen($meta['role']) > 0): ?>
                    <em><?php echo $meta['role']; ?></em>
                <?php endif; ?>

                <?php if($style !== 'overlay-social'): ?>

                    <?php  the_excerpt();?>

                    <ul class="yeti-social-network">
                        <?php foreach ($social_args as $key => $item): ?>
                            <li class="<?php echo esc_attr($key) ?>">
                                <a href="<?php echo esc_url($item[1]) ?>" title="<?php echo esc_attr($key); ?>">
                                    <i class="<?php echo esc_attr($item[0]); ?>"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                <?php endif; ?>

            </div>
        </div><!-- .team-member -->
    </div>
    <?php

}

echo '</div></div></div>';

?>