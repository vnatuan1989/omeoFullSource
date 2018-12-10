<?php
Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Extensions', 'omeo'),
    'id' => 'extensions',
    'desc' => '',
    'icon' => 'fa fa-plug',
    'class' => 'color1',
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Galleries', 'omeo'),
    'id' => 'extensions-gallery-subtab',
    'desc' => '',
    'icon' => 'fa fa-picture-o',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'extensions-gallery-info',
            'type' => 'info',
            'style' => 'info',
            'class' => 'yeti-info',
            'title' => esc_attr__('About Galleries!', 'omeo'),
            'desc' => esc_attr__("The Galleries is a featured of Yeti Extra plugin, it help you make your album and showing it as masonry grid or a slideshow. But if you don't want to use it, you can go to Yeti Extra > Settings and disable it.", 'omeo')
        ),

        array(
            'id' => 'galleries-columns',
            'type' => 'spinner',
            'title' => esc_html__('Galleries columns', 'omeo'),
            'desc' => esc_html__('Min: 3, max: 6, step: 1, default: 4', 'omeo'),
            'default' => 4,
            'min' => 3,
            'step' => 1,
            'max' => 6,
            'display_value' => 'text'
        ),

        array(
            'id' => 'gallery-fullscreen',
            'type' => 'switch',
            'title' => esc_html__('Fullscreen', 'omeo'),
            'desc' => esc_html__('Enabled/Disabled fullscreen buttom', 'omeo'),
            'default' => 1,
            'on' => 'Enabled',
            'off' => 'Disabled',
        ),
        array(
            'id' => 'gallery-loop',
            'type' => 'switch',
            'title' => esc_html__('Loop', 'omeo'),
            'desc' => esc_html__('Makes slider to go from last slide to first', 'omeo'),
            'default' => 0,
            'on' => 'Enabled',
            'off' => 'Disabled',
        ),
        array(
            'id' => 'gallery-height',
            'type' => 'slider',
            'title' => esc_html__('Gallery height', 'omeo'),
            'desc' => esc_html__('Min: 350px, max: 1170px, step: 10px, default: 670px', 'omeo'),
            'default' => 670,
            'min' => 350,
            'step' => 10,
            'max' => 1170,
            'display_value' => 'text'
        ),
        array(
            'id' => 'gallery-divide-1',
            'type' => 'divide'
        ),
        array(
            'id' => 'gallery-autoplay',
            'type' => 'switch',
            'title' => esc_html__('Auto Play', 'omeo'),
            'default' => 1,
            'on' => 'Enabled',
            'off' => 'Disabled',
        ),
        array(
            'id' => 'gallery-pauseonhover',
            'type' => 'switch',
            'title' => esc_html__('Pause On Hover', 'omeo'),
            'desc' => esc_html__('Pause autoplay on hover.', 'omeo'),
            'default' => 1,
            'on' => 'Enabled',
            'off' => 'Disabled',
            'required' => array('gallery-autoplay', '=', '1')
        ),
        array(
            'id' => 'gallery-autoplay-delay',
            'type' => 'slider',
            'title' => esc_html__('Delay', 'omeo'),
            'desc' => esc_html__('Min: 3000ms, max: 18000ms, step: 500ms, default: 5000ms', 'omeo'),
            'default' => 5000,
            'min' => 3000,
            'step' => 500,
            'max' => 18000,
            'display_value' => 'text',
            'required' => array('gallery-autoplay', '=', '1')
        ),
        array(
            'id' => 'gallery-divide-2',
            'type' => 'divide'
        ),
        array(
            'id' => 'gallery-thumnail-vertical',
            'type' => 'switch',
            'title' => esc_html__('Enable thumbnail vertical', 'omeo'),
            'default' => 0,
            'on' => 'Enabled',
            'off' => 'Disabled',
        ),
    )
));
