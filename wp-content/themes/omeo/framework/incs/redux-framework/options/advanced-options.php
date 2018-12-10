<?php
Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Advanced', 'omeo'),
    'id' => 'advanced-page',
    'desc' => '',
    'icon' => 'el el-file-edit',
    'class' => 'color7'
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('General', 'omeo'),
    'id' => 'advanced-api-subtab',
    'desc' => '',
    'icon' => 'fa fa-share-alt',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'google-map-api',
            'type' => 'text',
            'subtitle' => esc_attr__('Enter your google API here, it will be used for Google Map and Place-Autocomplete feature', 'omeo'),
            'title' => esc_attr__('Google maps API', 'omeo'),
            'desc' => sprintf(esc_attr__('Get Google map API, visit: %sGoogle docs%s', 'omeo'), '<a target="_blank" href="//developers.google.com/maps/documentation/javascript/get-api-key">', '</a>')
        ),

        array(
            'id' => 'dis_rev_font',
            'type' => 'switch',
            'title' => esc_html__('Disable Slider revolution fonts', 'omeo'),
            'default' => 0,
            'on' => 'On',
            'off' => 'Off',
        ),

        array(
            'id' => 'instagram-tokan',
            'type' => 'text',
            'title' => esc_html__('Instagram Tokan', 'omeo'),
            'subtitle' => esc_html__('Enter your Access Tokan for Instagram shortcode here. Remember to keep your access token private and never paste it in a location where others might can access it.', 'omeo'),
            'desc' => sprintf(esc_html__('%sGenerate Access Tokan%s', 'omeo'), '<a target="_blank" href="http://instagramwordpress.rafsegat.com/docs/get-access-token/">', '</a>')
        ),
    ),
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Custom CSS', 'omeo'),
    'id' => 'advanced-css-subtab',
    'desc' => '',
    'icon' => 'fa fa-css3',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'css_editor',
            'type' => 'ace_editor',
            'title' => esc_html__('CSS Code', 'omeo'),
            'mode' => 'css',
            'subtitle' => esc_attr('Enter your CSS code in this field. Custom CSS intered here will overwrite the theme CSS.', 'omeo'),
            'full_width' => true,
            'options' => array(
                'minLines' => 30,
                'maxLines' => 50
            )
        ),
    ),
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Custom JS', 'omeo'),
    'id' => 'advanced-js-subtab',
    'desc' => '',
    'icon' => 'fa fa-code',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'js_editor_head',
            'type' => 'ace_editor',
            'title' => 'JS Code - Header',
            'mode' => 'javascript',
            'subtitle' => 'Enter your JS code in this field. The JS code you enter here will be added before </head>.',
            'theme' => 'chrome',
            'full_width' => true,
            'options' => array(
                'minLines' => 20,
                'maxLines' => 30
            )
        ),
        array(
            'id' => 'js_editor_footer',
            'type' => 'ace_editor',
            'title' => 'JS Code - Footer',
            'mode' => 'javascript',
            'subtitle' => 'Enter your JS code in this field. The JS code you enter here will be added before </body>.',
            'theme' => 'chrome',
            'full_width' => true,
            'options' => array(
                'minLines' => 20,
                'maxLines' => 30
            )
        ),
    ),
));