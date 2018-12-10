<?php

vc_add_param('vc_row', array(
    'type' => 'dropdown',
    'heading' => esc_html__('Row style', 'omeo'),
    'param_name' => 'yesshop_row_style',
    'std' => '',
    'value' => array(
        esc_html__('Normal', 'omeo') => '',
        esc_html__('Container', 'omeo') => 'container',
        esc_html__('Container Extra', 'omeo') => 'extra_width',
        esc_html__('Container Fluid', 'omeo') => 'container-fluid',
    ),
    'dependency' => Array('element' => 'full_width', 'value' => array('')),
));

vc_add_param('vc_row_inner', array(
    'type' => 'dropdown',
    'heading' => esc_html__('Row style', 'omeo'),
    'param_name' => 'yesshop_row_style',
    'std' => '',
    'value' => array(
        esc_html__('Normal', 'omeo')             => '',
        esc_html__('Container', 'omeo')          => 'container',
        esc_html__('Container Extra', 'omeo')    => 'extra_width',
        esc_html__('Container Fluid', 'omeo')    => 'container-fluid',
    ),
));

vc_add_param('vc_section', array(
    'type' => 'dropdown',
    'heading' => esc_html__('Row style', 'omeo'),
    'param_name' => 'yesshop_row_style',
    'std' => '',
    'value' => array(
        esc_html__('Normal', 'omeo')             => '',
        esc_html__('Container Extra', 'omeo')    => 'extra_width',
    ),
));

$vc_tabs_pagrams = array(
    array(
        'type' => 'dropdown',
        'heading' => esc_html__('Tabs style', 'omeo'),
        'param_name' => 'yeti_tabs_style',
        'value' => array(
            esc_html__('Normal', 'omeo') => '',
            esc_html__('Boxed', 'omeo') => 'nth-boxed'
        ),
        'group' => 'Yetithemes'
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__("Columns", 'omeo'),
        'param_name' => 'tabs_columns',
        'value' => '2',
        'group' => 'Yetithemes',
        'dependency' => array('element' => 'yeti_tabs_style', 'value' => array('nth-boxed'))
    )
);
vc_add_params('vc_tabs', $vc_tabs_pagrams);


$vc_tta_tabs_pagrams = array(
    array(
        'type' => 'dropdown',
        'heading' => esc_html__("Tabs style", 'omeo'),
        'param_name' => 'yeti_tabs_style',
        'value' => array(
            esc_html__('VC Default', 'omeo') => '',
            esc_html__('YETI Tab Style 1', 'omeo') => 'yeti-tab-style1',
            esc_html__('YETI Tab Style 2', 'omeo') => 'yeti-tab-style2',
            esc_html__('YETI Tab Style 3', 'omeo') => 'yeti-tab-style3',
        ),
        'group' => 'Yetithemes',
        'dependency' => array('element' => 'style', 'value' => array('classic'))
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__('Columns', 'omeo'),
        'param_name' => 'tabs_columns',
        'value' => '2',
        'group' => 'Yetithemes',
        'dependency' => array('element' => 'yeti_tabs_style', 'value' => array('yeti-tab-style2'))
    ),
    array(
        'type' => 'dropdown',

        'heading' => esc_html__('Align', 'omeo'),
        'param_name' => 'yeti_tabs_align',
        'value' => array(
            esc_html__('Left', 'omeo') => 'text-left',
            esc_html__('Center', 'omeo') => 'text-center',
            esc_html__('Right', 'omeo') => 'text-right',
        ),
        'group' => 'Yetithemes',
        'dependency' => array('element' => 'style', 'value' => array('classic'))
    ),
);
vc_add_params('vc_tta_tabs', $vc_tta_tabs_pagrams);

$vc_tta_tour_pagrams = array(
    array(
        'type' => 'dropdown',
        'heading' => esc_html__('Section style', 'omeo'),
        'param_name' => 'yeti_tabs_style',
        'value' => array(
            esc_html__('VC Defaule', 'omeo') => '',
            esc_html__('NTH style', 'omeo') => 'nth-section-style1'
        ),
        'dependency' => array('element' => 'style', 'value' => array('classic'))
    )
);


vc_add_params('vc_tta_tour', $vc_tta_tour_pagrams);

$vc_tta_section_pagrams = array(
    array(
        'type' => 'checkbox',
        'heading' => esc_attr__('Using ajax content', 'omeo'),
        'param_name' => 'use_ajax',
        'value' => array(__('Yes', 'omeo') => 'yes'),
        'save_always' => true,
    ),
);
vc_add_params('vc_tta_section', $vc_tta_section_pagrams);

add_filter('vc-tta-get-params-tabs-list', 'yesshop_vc_tta_tabs_list', 10, 4);

function yesshop_vc_tta_tabs_list($html, $atts, $content, $shortcode)
{

    $classes = array();
    if (isset($atts['tabs_columns']) && absint($atts['tabs_columns']) > 0) {
        $columns = absint($atts['tabs_columns']);
        $classes[] = 'col-lg-' . round(24 / $columns);
        $classes[] = 'col-md-' . round(24 / round($columns * 992 / 1170));
        $classes[] = 'col-sm-' . round(24 / round($columns * 768 / 1170));
        $classes[] = 'col-xs-' . round(24 / round($columns * 480 / 1170));
    }

    foreach ($html as $k => $val) {
        if (strpos($val, '<li') !== false && count($classes) > 0) {
            $html[$k] = str_replace('<li class="', '<li class="' . implode(' ', $classes) . ' ', $val);
        } elseif (strpos($val, '<ul') !== false && !empty($atts['nth_tabs_align'])) {
            $html[$k] = str_replace('<ul class="', '<ul class="' . $atts['nth_tabs_align'] . ' ', $val);
        }
    }
    return $html;
}

add_filter('vc_shortcodes_css_class', 'yesshop_vc_shortcodes_css_class', 10, 3);

function yesshop_vc_shortcodes_css_class($class_to_filter, $base, $atts)
{
    $classes = array($class_to_filter);

    switch ($base) {
        case 'vc_tta_tabs':
        case 'vc_tta_tour':
            if (!empty($atts['yeti_tabs_style'])) {
                $classes[] = esc_attr($atts['yeti_tabs_style']);
            }
            if (!empty($atts['use_ajax']) && $atts['use_ajax'] == 'yes') {
                $classes[] = 'tab_ajax_content';
            }
            break;
        case 'vc_row':
        case 'vc_row_inner':
            if (!empty($atts['yesshop_row_style'])) $classes[] = esc_attr($atts['yesshop_row_style']);
        if (!empty($atts['yeti_row_bg_effect'])) $classes[] = esc_attr($atts['yeti_row_bg_effect']);
            break;
        case 'vc_section':
            $classes[] = 'section';
            if (!empty($atts['yesshop_row_style'])) $classes[] = esc_attr($atts['yesshop_row_style']);
            break;
    }

    return implode(' ', $classes);
}


$vc_progress_bar = array(
    array(
        'type' => 'dropdown',

        'heading' => esc_html__('Style', 'omeo'),
        'param_name' => 'pb_style',
        'value' => array(
            esc_html__('VC Defaule', 'omeo') => '',
            esc_html__('NTH Style', 'omeo') => 'nth-pb-style',
        ),
        'group' => 'Yetithemes',
    ),
    array(
        'type' => 'dropdown',
        'heading' => esc_html__('Border radius', 'omeo'),
        'param_name' => 'pb_radius_style',
        'value' => array(
            esc_html__('VC Defaule', 'omeo') => '',
            esc_html__('NTH Style', 'omeo') => 'nth-pb-radius-style',
        ),
        'group' => 'Yetithemes',
    ),

);

vc_add_params('vc_progress_bar', $vc_progress_bar);

if (defined('VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG')) {
    add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'yesshop_vc_shortcoe_custom_css', 10, 3);

    function yesshop_vc_shortcoe_custom_css($class_to_filter, $base, $atts)
    {
        if (strcmp($base, 'vc_progress_bar') == 0) {
            if (isset($atts['pb_style']) && strlen($atts['pb_style']) > 0) {
                $class_to_filter .= ' ' . esc_attr($atts['pb_style']);
            }
            if (isset($atts['pb_radius_style']) && strlen($atts['pb_radius_style']) > 0) {
                $class_to_filter .= ' ' . esc_attr($atts['pb_radius_style']);
            }
        }

        return $class_to_filter;
    }
}