<?php
Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Typography', 'omeo'),
    'id' => 'typography',
    'desc' => '',
    'class' => 'color3',
    'icon' => 'fa fa-font',
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('General font', 'omeo'),
    'id' => 'general-font',
    'desc' => '',
    'icon' => 'fa fa-angle-double-right',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'general_font',
            'type' => 'typography',
            'title' => 'General Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 400,
                'font-size' => '14px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'menu_font',
            'type' => 'typography',
            'title' => 'Menu Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 400,
                'font-size' => '14px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'h1_font',
            'type' => 'typography',
            'title' => 'H1 Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 600,
                'font-size' => '24px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'h2_font',
            'type' => 'typography',
            'title' => 'H2 Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 600,
                'font-size' => '20px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'h3_font',
            'type' => 'typography',
            'title' => 'H3 Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 600,
                'font-size' => '16px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),

        array(
            'id' => 'h4_font',
            'type' => 'typography',
            'title' => 'H4 Font / Product Name Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 500,
                'font-size' => '14px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'h5_font',
            'type' => 'typography',
            'title' => 'H5 Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 500,
                'font-size' => '13px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'h6_font',
            'type' => 'typography',
            'title' => 'H6 Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 500,
                'font-size' => '12px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'testimonial_font',
            'type' => 'typography',
            'title' => 'Testimonial Font',
            'default' => array(
                'font-family' => 'Playfair Display',
                'font-weight' => 400,
                'font-size' => '16px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'footer_title_font',
            'type' => 'typography',
            'title' => 'Footer Title Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 700,
                'font-size' => '13px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'footer_copyright_font',
            'type' => 'typography',
            'title' => 'Footer Copyright Font',
            'default' => array(
                'font-family' => 'Playfair Display',
                'font-weight' => 400,
                'font-size' => '14px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'price_font',
            'type' => 'typography',
            'title' => 'Product Price Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 700,
                'font-size' => '16px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        )

    ),
));


Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Button font', 'omeo'),
    'id' => 'button-font',
    'desc' => '',
    'icon' => 'fa fa-angle-double-right',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'btn1_font',
            'type' => 'typography',
            'title' => 'Button 1',
            'default' => array(
                'font-family' => 'Poppins',
                'font-weight' => 400,
                'font-size' => '14px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'btn2_font',
            'type' => 'typography',
            'title' => 'Button 2',
            'default' => array(
                'font-family' => 'Poppins',
                'font-weight' => 400,
                'font-size' => '14px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px',
        ),
    ),
));
