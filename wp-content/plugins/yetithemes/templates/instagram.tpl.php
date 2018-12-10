<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 1/6/2016
 * Vertion: 1.0
 */


$options = array(
    'items' => $columns,
    'nav'   => false,
);
$options = YetiThemes_Extra()->get_owlResponsive($options);

$instagram = Yetithemes_Instagram()->get_media($key, $limit, $time);

if(empty($instagram)) return;

$_item_class = array('instagram-item');

$link_args = array(
    'url' => '#',
    'title' => 'Link',
    'target' => '_self'
);
if(!empty($f_button)) {
    $link_args = wp_parse_args(vc_build_link($link), $link_args);
}

?>

<?php if(!empty($title)):?>
    <h3 class="heading-title"><?php echo esc_html($title)?></h3>
<?php endif; ?>

<?php if(!isset($is_slider) || absint($is_slider)) : ?>

<div class="yeti-owlCarousel yeti-loading light" data-options="<?php echo esc_attr(wp_json_encode($options))?>" data-base="1" data-delay="1500">
    <?php YetiThemes_Extra()->get_yetiLoadingIcon();?>


    <?php else: ?>

    <?php
    if (absint($columns) > 1) {
        $_item_class[] = 'col-lg-' . round(24 / $columns);
        $_item_class[] = 'col-md-' . round(24 / $columns);
        $_item_class[] = 'col-sm-' . round(24 / round($columns * 768 / 1170));
        $_item_class[] = 'col-xs-' . round(24 / round($columns * 480 / 1170));
        $_item_class[] = 'col-mb-12';
    } else {
        $_item_class[] = 'col-sm-24';
    }

    ?>


<div class="yeti-shortcode-content row yeti-instag-<?php echo esc_attr($padding)?>">

<?php endif;?>

    <?php if(!empty($f_button)): ?>
    <a href="<?php echo esc_url($link_args['url'])?>" title="<?php echo esc_attr($link_args['title'])?>" target="<?php echo esc_attr($link_args['target'])?>" class="button"><?php echo esc_html($f_button);?></a>
    <?php endif;?>

    <div class="yeti-owl-slider">

        <?php foreach ($instagram as $item): ?>

            <div class="<?php echo esc_attr(implode(' ', $_item_class))?> <?php echo esc_attr($item['type'])?>">

                <a target="_blank" class="effect_color" href="<?php echo esc_url($item['link'])?>">

                    <img src="<?php echo esc_url($item[$image_size]['url'])?>" width="<?php echo absint($item[$image_size]['width'])?>" height="<?php echo absint($item[$image_size]['height'])?>" alt="instag image" />

                    <ul class="list-inline insta-meta">
                        <li><i class="fa fa-heart" aria-hidden="true"></i> <?php echo esc_html($item['likes'])?></li>
                        <li><i class="fa fa-comment" aria-hidden="true"></i> <?php echo esc_html($item['comments'])?></li>
                    </ul>
                </a>

            </div>

        <?php endforeach;?>

    </div>

</div>

    <?php if(absint($padding) !== 15): ?>

        <style type="text/css" scoped>
            .yeti-instag-<?php echo esc_attr($padding)?> {
                margin-left: -<?php echo absint($padding)?>px;
                margin-right: -<?php echo absint($padding)?>px;
            }
            .yeti-instag-<?php echo esc_attr($padding)?> .instagram-item {
                padding-left: <?php echo absint($padding)?>px;
                padding-right: <?php echo absint($padding)?>px;
                padding-bottom: <?php echo absint($padding)*2?>px;
            }
        </style>

    <?php endif;?>
