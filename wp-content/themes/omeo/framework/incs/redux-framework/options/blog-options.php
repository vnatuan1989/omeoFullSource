<?php
Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Wordpress', 'omeo'),
    'id' => 'wordpress-page',
    'icon' => 'fa fa-wordpress',
    'class' => 'color2',
));


Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Page Sidebars', 'omeo'),
    'id' => 'wp-layout-tab',
    'icon' => 'fa fa-exchange',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'wp-layout-archive-start',
            'type' => 'section',
            'title' => esc_html__('Product Archive', 'omeo'),
            'indent' => true,
        ),
        array(
            'id' => 'blog-layout',
            'type' => 'image_select',
            'title' => esc_html__('Blog sidebar', 'omeo'),
            'subtitle' => esc_html__('Blog layout: none slidebar, left slidebar or right slidebar.', 'omeo'),
            'desc' => '',
            'options' => array(
                '0-0' => array(
                    'alt' => 'full_width',
                    'img' => ReduxFramework::$_url . 'assets/img/1col.png'
                ),
                '1-0' => array(
                    'alt' => 'left_sidebar',
                    'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
                ),
                '0-1' => array(
                    'alt' => 'right_sidebar',
                    'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
                ),
                '1-1' => array(
                    'alt' => 'all_sidebar',
                    'img' => ReduxFramework::$_url . 'assets/img/3cm.png'
                ),
            ),
            'default' => '0-1'
        ),
        array(
            'id' => 'blog-left-sidebar',
            'type' => 'select',
            'title' => 'Select Left Sidebar',
            'data' => 'sidebars',
            'default' => 'blog-page-widget-area-right'
        ),
        array(
            'id' => 'blog-right-sidebar',
            'type' => 'select',
            'title' => 'Select Right Sidebar',
            'data' => 'sidebars',
            'default' => 'blog-page-widget-area-right'
        ),

        array(
            'id' => 'wp-layout-archive-end',
            'type' => 'section',
            'indent' => false,
        ),
    ),
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Post Archive', 'omeo'),
    'id' => 'post-archive',
    'desc' => '',
    'icon' => 'fa fa-newspaper-o',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'blog-type',
            'type' => 'image_select',
            'title' => esc_attr__('Blog layout', 'omeo'),
            'options' => array(
                'default' => array(
                    'alt' => 'default',
                    'img' => get_theme_file_uri('images/blog-style1.png')
                ),
                'masonry' => array(
                    'alt' => 'masonry',
                    'img' => get_theme_file_uri('images/blog-style2.png')
                ),
                'sticky-columns' => array(
                    'alt' => 'masonry',
                    'img' => get_theme_file_uri('images/blog-style3.png')
                ),
                'columns' => array(
                    'alt' => 'masonry',
                    'img' => get_theme_file_uri('images/blog-style4.png')
                ),
                'list-mode' => array(
                    'alt' => 'masonry',
                    'img' => get_theme_file_uri('images/blog-style5.png')
                ),
            ),
            'default' => 'default'
        ),

        array(
            'id' => 'blog-columns',
            'type' => 'spinner',
            'title' => esc_html__('Blog Archive Columns', 'omeo'),
            'default' => '3',
            'min' => '2',
            'step' => '1',
            'max' => '4',
            'required' => array('blog-type', '!=', array('default'))
        ),

        array(
            'id' => 'blog-excerpt-length',
            'type' => 'spinner',
            'title' => esc_html__('Excerpt length', 'omeo'),
            'desc' => esc_html__("Min: 25, max: 255, step: 1, default: 55", 'omeo'),
            'default' => '55',
            'min' => '25',
            'step' => '1',
            'max' => '255',
        ),
        array(
            'id' => 'blog-excerpt-more',
            'type' => 'button_set',
            'title' => esc_html__('Excerpt more', 'omeo'),
            'default' => 'def',
            'options' => array(
                'def' => '[&hellip;]',
                'hellip' => '&hellip;',
            ),
        ),
        array(
            'id' => 'blog-readmore-button',
            'type' => 'switch',
            'title' => esc_html__('Read More button', 'omeo'),
            'default' => 1,
            'on' => 'Show',
            'off' => 'Hide',
        ),
    ),
));