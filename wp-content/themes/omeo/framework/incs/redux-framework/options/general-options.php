<?php
$_create_block_uri = add_query_arg(array(
    'post_type' => 'static_block'
), get_admin_url(null, 'post-new.php'));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('General', 'omeo'),
    'id' => 'general',
    'class' => 'color4',
    'icon' => 'fa fa-home',
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('General', 'omeo'),
    'id' => 'general-sub',
    'subsection' => true,
    'icon' => 'fa fa-tachometer',
    'fields' => array(

        array(
            'id' => 'pace-loader',
            'type' => 'switch',
            'title' => esc_html__('Pace loader', 'omeo'),
            'default' => 0,
            'on' => 'On',
            'off' => 'Off',
        ),

        array(
            'id' => 'general_radius',
            'type' => 'text',
            'title' => esc_html__('Radius', 'omeo'),
            'subtitle' => esc_html__('For Input, Select', 'omeo'),
            'desc' => 'Defined in pixels. Do not add the \'px\' unit.',
            'default' => 5,
            'compiler' => true,
        ),
    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('404 Page', 'omeo'),
    'id' => 'general-404page',
    'icon' => 'fa fa-chain-broken',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => '404-img',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('404 Image', 'omeo'),
        ),

        array(
            'id' => '404page-stblock',
            'type' => 'select',
            'title' => 'Static block for PAGE-404',
            'data' => 'posts',
            'args' => array(
                'post_type' => 'static_block',
                'posts_per_page' => -1
            )
        ),

    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Search form', 'omeo'),
    'id' => 'general-search',
    'icon' => 'fa fa-search',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'search-form-with-cat',
            'type' => 'switch',
            'title' => esc_html__('Search with product category', 'omeo'),
            'default' => 1,
            'on' => 'On',
            'off' => 'Off',
        ),

        array(
            'id' => 'search-form-cats',
            'type' => 'select',
            'title' => esc_attr__('Product categories', 'omeo'),
            'subtitle' => esc_html__('Leave empty to get all product categories. However, if you have many product categories, you should select some items in here', 'omeo'),
            'data' => 'terms',
            'args' => array(
                'taxonomies' => 'product_cat',
                'pad_counts' => 1,
                'show_count' => 0,
                'hierarchical' => 1,
                'hide_empty' => 0,
                'show_uncategorized' => 0,
                'menu_order' => false,
                'parent' => 0,
            ),
            'multi' => true,
            'required' => array('search-form-with-cat', '=', '1'),
        ),

        array(
            'id' => 'search-ajax-result-limit',
            'type' => 'slider',
            'title' => esc_html__('Result Limit', 'omeo'),
            'subtitle' => esc_html__('Min: 2, max: 12, step: 1, default: 3', 'omeo'),
            'desc' => '',
            'default' => 3,
            'min' => 2,
            'step' => 1,
            'max' => 12,
            'display_value' => 'text'
        ),
        array(
            'id' => 'search-ajax-min-char',
            'type' => 'slider',
            'title' => esc_html__('Min char', 'omeo'),
            'subtitle' => esc_html__('Min: 1, max: 5, step: 1, default: 3', 'omeo'),
            'desc' => '',
            'default' => 3,
            'min' => 1,
            'step' => 1,
            'max' => 5,
            'display_value' => 'text'
        ),
        array(
            'id' => 'header_border_search',
            'type' => 'color',
            'title' => 'Border Form Search',
            'default' => '#ebebeb',
            'compiler' => true
        ),

        array(
            'id' => 'header_bg_search',
            'type' => 'color',
            'title' => 'Background Form Search',
            'default' => '#fff',
            'compiler' => true
        ),

        array(
            'id' => 'header_but_search',
            'type' => 'color',
            'title' => 'Button Search Color',
            'default' => '#000',
            'compiler' => true
        ),

        array(
            'id' => 'header_text_search',
            'type' => 'color',
            'title' => 'Text Form Search',
            'default' => '#7d7d7d',
            'compiler' => true
        ),
    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Site Layout', 'omeo'),
    'id' => 'general-layout',
    'icon' => 'fa fa-columns',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'layout-main',
            'type' => 'button_set',
            'title' => esc_html__('Main Layout', 'omeo'),
            'subtitle' => esc_html__('Main layout: wide or boxed', 'omeo'),
            'desc' => '',
            'options' => array(
                'wide' => esc_attr__('Wide', 'omeo'),
                'boxed' => esc_attr__('Boxed', 'omeo')
            ),
            'default' => 'wide'
        ),

        array(
            'id' => 'boxed-layout-settings-start',
            'type' => 'section',
            'title' => esc_html__('Boxed Layout Settings', 'omeo'),
            'indent' => true,
            'required' => array('layout-main', '=', 'boxed'),
        ),

        array(
            'id' => 'site-padding',
            'type' => 'spacing',
            'title' => esc_html__('Site Padding', 'omeo'),
            'mode' => 'padding',
            'left' => false,
            'output'    => 'body.boxed',
            'right' => false,
            'units' => 'px',
            'default' => array(
                'padding-top' => '55px',
                'padding-bottom' => '55px',
            )
        ),

        array(
            'id' => 'boxed-layout-settings-end',
            'type' => 'section',
            'indent' => false,
            'required' => array('layout-main', '=', 'boxed'),
        ),

        array(
            'id' => 'sidebars-settings-start',
            'type' => 'section',
            'title' => esc_html__('Sidebars Settings', 'omeo'),
            'indent' => true,
        ),
        array(
            'id' => 'sidebars-width',
            'type' => 'slider',
            'title' => esc_attr__('Sidebars Width', 'omeo'),
            'subtitle' => esc_attr__('Set width for the sidebar (left/right) - Apply for PC device', 'omeo'),
            'default' => array(
                1 => 6,
                2 => 18,
            ),
            'min' => 0,
            'step' => 1,
            'max' => 24,
            'display_value' => 'none',
            'handles' => 2,
            'class' => 'yeti-sidebar-slider'
        ),
        array(
            'id' => 'sidebars-width-sm',
            'type' => 'slider',
            'title' => esc_html__('Sidebars Width - [sm]', 'omeo'),
            'subtitle' => esc_html__('Set width for the sidebar (left/right) - Apply for Tablet device', 'omeo'),
            'default' => array(
                1 => 7,
                2 => 17,
            ),
            'min' => 0,
            'step' => 1,
            'max' => 24,
            'display_value' => 'none',
            'handles' => 2,
            'class' => 'yeti-sidebar-slider'
        ),

        array(
            'id' => 'sidebars-settings-end',
            'type' => 'section',
            'indent' => false,
        ),
    )
));


/**
 * IMAGE SIZE
 */

$_size_image_fields = array(
    array(
        'id' => 'blog-dimensions-section-start',
        'type' => 'section',
        'title' => esc_html__('Blog Images Size', 'omeo'),
        'indent' => true,
    ),

    array(
        'id' => 'blog-thumbnail-size',
        'type' => 'yeti_dimensions',
        'title' => esc_html__('Blog Thumbnail', 'omeo'),
        'subtitle' => esc_html__('Default: 850x460', 'omeo'),
        'desc' => '',
        'default' => array(
            'width' => '850',
            'height' => '460',
            'drop' => '1'
        ),
    ),

    array(
        'id' => 'blog-thumbnail-grid-size',
        'type' => 'yeti_dimensions',
        'title' => esc_html__('Blog Grid Thumbnail - Shortcode', 'omeo'),
        'subtitle' => esc_html__('Default: 410x220', 'omeo'),
        'default' => array(
            'width' => '410',
            'height' => '220',
            'drop' => '1'
        ),
    ),

    array(
        'id' => 'blog-thumbnail-grid-size-2',
        'type' => 'yeti_dimensions',
        'title' => esc_html__('Blog Grid Thumbnail 2 - Shortcode', 'omeo'),
        'subtitle' => esc_html__('Default: 410x468', 'omeo'),
        'default' => array(
            'width' => '410',
            'height' => '468',
            'drop' => '1'
        ),
    ),

    array(
        'id' => 'blog-thumbnail-grid-size-3',
        'type' => 'yeti_dimensions',
        'title' => esc_html__('Blog Grid Thumbnail 3 - Shortcode', 'omeo'),
        'subtitle' => esc_html__('Default: 360x540', 'omeo'),
        'default' => array(
            'width' => '360',
            'height' => '540',
            'drop' => '1'
        ),
    ),

    array(
        'id' => 'blog-thumbnail-widget-size',
        'type' => 'yeti_dimensions',
        'title' => esc_html__('Blog Widget Thumbnail', 'omeo'),
        'subtitle' => esc_html__('Default: 100x67', 'omeo'),
        'default' => array(
            'width' => '270',
            'height' => '155',
            'drop' => '1'
        ),
    ),

    array(
        'id'      => 'blog-thumb-shortc-manager',
        'type'    => 'checkbox',
        'title'   => esc_html__('Blog Image Size for Shortcode', 'omeo'),
        'options' => array(
            'blog-thumbnail-grid-size-2'   => 'Blog Grid Thumbnail 2',
            'blog-thumbnail-grid-size-3'   => 'Blog Grid Thumbnail 3'
        ),
        'default'   => array(
            'blog-thumbnail-grid-size-2'   => '1',
            'blog-thumbnail-grid-size-3'   => '1'
        )
    ),

    array(
        'id' => 'blog-dimensions-section-end',
        'type' => 'section',
        'indent' => false,
    ),

    array(
        'id' => 'woo-dimensions-section-start',
        'type' => 'section',
        'title' => esc_html__('Woocommerce Images Size', 'omeo'),
        'indent' => true,
    ),

    array(
        'id' => 'shop-subcat-size',
        'type' => 'yeti_dimensions',
        'title' => esc_html__('Shop Sub-Categories Image', 'omeo'),
        'subtitle' => esc_html__('Default: 100x100', 'omeo'),
        'default' => array(
            'width' => '100',
            'height' => '100',
            'drop' => '1'
        ),
    ),

    array(
        'id' => 'woo-dimensions-section-end',
        'type' => 'section',
        'indent' => false,
    ),


);

$_size_image_fields = array_merge($_size_image_fields, array(
    array(
        'id' => 'plugin-dimensions-section-start',
        'type' => 'section',
        'title' => esc_html__('Plugin Images Size', 'omeo'),
        'indent' => true,
    ),
));

if (class_exists('Yetithemes_Portfolio')) {
    $_size_image_fields = array_merge($_size_image_fields, array(
        array(
            'id' => 'portfolio-thumb-size',
            'type' => 'yeti_dimensions',
            'title' => esc_html__('Portfolio thumbnail', 'omeo'),
            'subtitle' => esc_html__('Default: 560x560', 'omeo'),
            'default' => array(
                'width' => '560',
                'height' => '560',
                'drop' => '1'
            ),
        ),

        array(
            'id' => 'portfolio-thumb-big-size',
            'type' => 'yeti_dimensions',
            'title' => esc_html__('Portfolio thumbnail - big size', 'omeo'),
            'subtitle' => esc_html__('Default: 900x900', 'omeo'),
            'default' => array(
                'width' => '900',
                'height' => '900',
                'drop' => '1'
            ),
        ),
    ));
}

if (class_exists('Yetithemes_TeamMembers')) {
    $_size_image_fields = array_merge($_size_image_fields, array(
        array(
            'id' => 'teams-thumb-size',
            'type' => 'yeti_dimensions',
            'title' => esc_html__('Team Thumbnail', 'omeo'),
            'subtitle' => esc_html__('Default: 580x388', 'omeo'),
            'desc' => '',
            'default' => array(
                'width' => '580',
                'height' => '388',
                'drop' => '1'
            ),
        ),
    ));
}

if (class_exists('Yetithemes_Gallery')) {
    $_size_image_fields = array_merge($_size_image_fields, array(
        array(
            'id' => 'gallery-thumb-auto-size',
            'type' => 'yeti_dimensions',
            'title' => esc_html__('Gallery thumbnail (auto height)', 'omeo'),
            'subtitle' => esc_html__('Default: 270 for width', 'omeo'),
            'desc' => '',
            'height' => false,
            'drop' => false,
            'default' => array(
                'width' => '270'
            ),
        ),
    ));
}

$_size_image_fields = array_merge($_size_image_fields, array(
    array(
        'id' => 'plugin-dimensions-section-end',
        'type' => 'section',
        'indent' => false,
    ),
));


Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Image size', 'omeo'),
    'id' => 'general-image-size',
    'desc' => '',
    'icon' => 'fa fa-object-ungroup',
    'subsection' => true,
    'fields' => $_size_image_fields
));


Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Slider option', 'omeo'),
    'id' => 'general-slider-options',
    'icon' => 'fa fa-exchange',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'general-slider-options-info',
            'type' => 'info',
            'style' => 'info',
            'class' => 'yeti-info',
            'title' => esc_attr__('OwlCarousel slider!', 'omeo'),
            'desc' => esc_attr__("Our theme use OwlCarousel library for slider, such as: product slider, image slider, etc", 'omeo')
        ),

        array(
            'id' => 'owl_autoplay',
            'type' => 'switch',
            'title' => esc_html__('Auto Play', 'omeo'),
            'default' => 0,
            'on' => 'Enabled',
            'off' => 'Disabled',
        ),

        array(
            'id' => 'owl_autoplaytimeout',
            'type' => 'slider',
            'title' => esc_html__('Auto Play Timeout', 'omeo'),
            'desc' => esc_html__('Min: 3000ms, max: 18000ms, step: 500ms, default: 5000ms', 'omeo'),
            'default' => 5000,
            'min' => 3000,
            'step' => 500,
            'max' => 18000,
            'display_value' => 'text',
        ),

        array(
            'id' => 'owl_autoplayhoverpause',
            'type' => 'switch',
            'title' => esc_html__('Pause when hover', 'omeo'),
            'default' => 0,
            'on' => 'Enabled',
            'off' => 'Disabled',
        ),
    )
));
