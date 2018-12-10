<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 12/11/2015
 * Vertion: 1.0
 */

if(!empty($item)) {
    if (function_exists('vc_param_group_parse_atts'))
        $items = (array)vc_param_group_parse_atts($item);
    else return;
} else {
    $_data = explode(',', $items);
    $items = array();
    foreach ($_data as $k => $item) {
        $item = array_map('trim', explode('|', $item));
        if(!empty($item[0])) $items[$k]['icon'] = $item[0];
        if(!empty($item[1])) $items[$k]['title'] = $item[1];
        if(!empty($item[2])) $items[$k]['link'] = $item[2];
        if(!empty($item[3])) $items[$k]['color'] = $item[3];
    }
}


$ul_classes = array('yeti-social-network');
$ul_classes[] = 'list-inline';
$ul_classes[] = 'yeti-social-' . mt_rand();
if (!empty($class)) $ul_classes[] = $class;
?>
<?php if (strlen(trim($title)) > 0): ?>

    <h3 class="heading-title ud-line"><?php echo esc_html($title); ?></h3>

<?php endif; ?>

<?php
$li_html = '';
$ct_css = '';
foreach ($items as $item) {
    $li_class = 'li-' . rand();
    $link = !empty($item['link']) ? $item['link'] : '#';
    $title = !empty($item['title']) ? $item['title'] : 'Facebook';
    $icon = !empty($item['icon']) ? $item['icon'] : 'fa fa-facebook-square';
    $color = !empty($item['color']) ? $item['color'] : '#6475c2';
    if (absint($color_hover)) $ct_css .= '.' . $li_class . ' a:hover {color: ' . $color . '}';
    else $ct_css .= '.' . $li_class . ' a {color: ' . $color . '}';
    $icon .= ' ' . $ic_size;

    $li_html .= '<li class="' . esc_attr($li_class) . '"><a style="color: '.$color.'" href="' . esc_url($link) . '" title="' . esc_attr($title) . '">';
    $li_html .= '<span data-toggle="tooltip" data-placement="' . esc_attr($tt_location) . '" title="' . esc_attr($title) . '" class="fa ' . esc_attr($icon) . '"></span>';
    $li_html .= '</a></li>';
}
?>


<ul class="<?php echo esc_attr(implode(' ', $ul_classes)); ?>">
    <?php echo $li_html; ?>
</ul>
