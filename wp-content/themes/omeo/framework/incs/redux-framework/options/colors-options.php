<?php
Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Styling scheme', 'omeo'),
    'id' => 'color_scheme',
    'desc' => '',
    'icon' => 'fa fa-magic',
    'class' => 'color6',
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('General color', 'omeo'),
    'id' => 'general-color',
    'desc' => '',
    'icon' => 'fa fa-angle-double-right',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'stylesheet-custom-reset',
            'title' => esc_attr__('Stylesheet reset', 'omeo'),
            'type' => 'yeti_stylesheet',
            'options'   => array(
                'home_1'           => 'Home 1',
                'home_2'          => 'Home 2',
                'home_3'          => 'Home 3',
                'home_4'        => 'Home 4',
                'home_5'       	=> 'Home 5',
                'home_6'         => 'Home 6',
                'home_7'     	=> 'Home 7',
                'home_8'    		=> 'Home 8',
                'home_9'        => 'Home 9',
                'home_10'       	=> 'Home 10'
            )
        ),

        array(
            'id' => 'general-color-info-body',
            'type' => 'section',
            'title' => esc_html__('BODY', 'omeo'),
            'indent' => true
        ),
        array(
            'id' => 'main_bg',
            'type' => 'background',
            'title' => 'Main - Background Image',
            'default' => array(
                'background-color'  => '#fff',
            ),
            'compiler' => true,
            'background-attachment' => false,
            'background-size'       => false
        ),
        array(
            'id' => 'main_box_bg',
            'type' => 'color',
            'title' => 'Main Background Color',
            'default' => '#fff',
            'compiler' => true
        ),

        array(
            'id' => 'general-color-info-box',
            'type' => 'section',
            'title' => esc_html__('GENERAL COLOR', 'omeo'),
            'indent' => true
        ),

        array(
            'id' => 'colorPrimary',
            'type' => 'color',
            'title' => 'Primary Color',
            'default' => '#acd373',
            'compiler' => true
        ),

        array(
            'id' => 'colorPrimaryText',
            'type' => 'color',
            'title' => 'Text On Background Primary Color',
            'default' => '#fff',
            'compiler' => true
        ),

        array(
            'id' => 'box_bg_color',
            'type' => 'color',
            'title' => 'Box Background Color',
            'subtitle' => 'Background color for &lt;input&gt;, &lt;box&gt;, &lt;select&gt; ...',
            'default' => '#f6f7fb',
            'compiler' => true
        ),

        array(
            'id' => 'main_text_color',
            'type' => 'color',
            'title' => 'Main Text Color',
            'subtitle' => 'Text color for &lt;p&gt;, &lt;body&gt;, &lt;div&gt; ...',
            'default' => '#7d7d7d',
            'compiler' => true
        ),

        array(
            'id' => 'main_title_color',
            'type' => 'color',
            'title' => 'Main Title Color',
            'default' => '#000',
            'subtitle' => 'Text color for Custom Heading, Page Heading, Sidebar Heading, ...',
            'compiler' => true
        ),

        array(
            'id' => 'main_title_color',
            'type' => 'color',
            'title' => 'Main Title Color',
            'default' => '#000',
            'subtitle' => 'Text color for Custom Heading, Page Heading, Sidebar Heading, ...',
            'compiler' => true
        ),

        array(
            'id' => 'dark_text_color',
            'type' => 'color',
            'title' => 'Dark Text Color',
            'default' => '#000',
            'compiler' => true
        ),

        array(
            'id' => 'light_text_color',
            'type' => 'color',
            'title' => 'Light Text Color',
            'subtitle' => 'Text color for note, small text',
            'default' => '#7d7d7d',
            'compiler' => true
        ),

        array(
            'id' => 'link_color',
            'type' => 'link_color',
            'title' => 'Link Color',
            'subtitle' => 'Text color for &lt;a&gt; elements',
            'default' => array(
                'regular' => '#000',
                'hover' => '#acd373'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),

        array(
            'id' => 'main_line_color',
            'type' => 'color',
            'title' => 'Main Line Color',
            'subtitle' => 'Border of input text, table, ...',
            'default' => '#ebebeb',
            'compiler' => true
        ),



        array(
            'id' => 'blog_name_color',
            'type' => 'color',
            'title' => 'Blog Name Color',
            'default' => '#000',
            'compiler' => true
        ),
    ),
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Font style', 'omeo'),
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
            'units' => 'px'
        ),
        array(
            'id' => 'special_font',
            'type' => 'typography',
            'title' => 'Special Font',
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
            'units' => 'px'
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
            'units' => 'px'
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
            'units' => 'px'
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
            'units' => 'px'
        ),

        array(
            'id' => 'h4_font',
            'type' => 'typography',
            'title' => 'H4 Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 700,
                'font-size' => '15px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px'
        ),
        array(
            'id' => 'h5_font',
            'type' => 'typography',
            'title' => 'H5 Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 600,
                'font-size' => '15px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px'
        ),
        array(
            'id' => 'h6_font',
            'type' => 'typography',
            'title' => 'H6 Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 400,
                'font-size' => '15px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'units' => 'px'
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
            'units' => 'px'
        ),


    ),
));


Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Header Layout', 'omeo'),
    'id' => 'general-header',
    'subsection' => true,
    'icon' => 'fa fa-arrow-circle-up',
    'fields' => array(
        array(
            'id' => 'logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Logo Image', 'omeo'),
            'subtitle' => esc_html__('Select/Upload an image for your logo', 'omeo'),
        ),

        array(
            'id' => 'logo-text',
            'type' => 'text',
            'title' => esc_html__('Logo text', 'omeo'),
            'default' => 'Default logo',
        ),
        array(
            'id' => 'header-style',
            'type' => 'image_select',
            'title' => esc_html__('Header Layout', 'omeo'),
            'options' => array(
                '1' => array(
                    'alt' => 1,
                    'img' => THEME_IMG_URI . "omeo-header-1.png"
                ),
                '2' => array(
                    'alt' => 2,
                    'img' => THEME_IMG_URI . "omeo-header-2.png"
                ),
                '3' => array(
                    'alt' => 3,
                    'img' => THEME_IMG_URI . "omeo-header-3.png"
                ),
                '4' => array(
                    'alt' => 4,
                    'img' => THEME_IMG_URI . "omeo-header-4.png"
                ),
                '5' => array(
                    'alt' => 5,
                    'img' => THEME_IMG_URI . "omeo-header-5.png"
                ),
                '6' => array(
                    'alt' => 6,
                    'img' => THEME_IMG_URI . "omeo-header-6.png"
                ),
                '7' => array(
                    'alt' => 7,
                    'img' => THEME_IMG_URI . "omeo-header-7.png"
                ),
            ),
            'default' => '1',
            'compiler' => true,
        ),

        array(
            'id' => 'absolute-header',
            'type' => 'switch',
            'title' => esc_html__('Absolute header', 'omeo'),
            'default' => 0,
            'on' => 'On',
            'off' => 'Off'
        ),

        array(
            'id' => 'logo-absolute',
            'type' => 'media',
            'title' => esc_html__('Logo absolute', 'omeo'),
            'subtitle' => esc_html__('Select/Upload an image for your logo in Absolute header', 'omeo'),
            'required' => array('absolute-header', '=', array('1'))
        ),

        array(
            'id' => 'fullwidth-header',
            'type' => 'switch',
            'title' => esc_html__('Full width header', 'omeo'),
            'default' => 0,
            'on' => 'On',
            'off' => 'Off'
        ),

        array(
            'id' => 'header-hide-login-bottom',
            'type' => 'switch',
            'title' => esc_html__('Hiden Login popup - Header bottom', 'omeo'),
            'default' => 0,
            'on' => 'On',
            'off' => 'Off',
            'required' => array('header-style', '=', array('13'))
        ),

        array(
            'id' => 'header-shipping-text',
            'type' => 'editor',
            'title' => esc_html__('Header Text / Number Phone', 'omeo'),
            'subtitle' => esc_html__('Use any of the features of WordPress editor inside your panel!', 'omeo'),
            'default' => '',
        ),
        array(
            'id' => 'sticky-header',
            'type' => 'switch',
            'title' => esc_html__('Sticky header', 'omeo'),
            'default' => 1,
            'on' => 'On',
            'off' => 'Off',
        ),
    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Header Color', 'omeo'),
    'id' => 'general-header-color',
    'subsection' => true,
    'icon' => 'fa fa-magic',
    'fields' => array(
        array(
            'id' => 'header_bg_color',
            'type' => 'color',
            'title' => 'Header Background Color',
            'default' => '#fff',
            'compiler' => true
        ),

        array(
            'id' => 'header_text_color',
            'type' => 'color',
            'title' => 'Header Text Color',
            'default' => '#000',
            'subtitle' => 'Text color of middle header',
            'compiler' => true
        ),

        array(
            'id' => 'header_top_bg_color',
            'type' => 'color',
            'title' => 'Header Top Background Color',
            'default' => '#252525',
            'compiler' => true
        ),

        array(
            'id' => 'header_top_text_color',
            'type' => 'color',
            'title' => 'Header Top Text Color',
            'default' => '#7d7d7d',
            'subtitle' => 'Text color of top header',
            'compiler' => true
        ),

        array(
            'id' => 'header_bottom_bg_color',
            'type' => 'color',
            'title' => 'Header Bottom Background Color',
            'default' => '#fff',
            'compiler' => true
        ),
        array(
            'id' => 'header_line_color',
            'type' => 'color',
            'title' => 'Header Line Color',
            'default' => '#eee',
            'compiler' => true
        ),


        array(
            'id' => 'header_cart_count_bg_color',
            'type' => 'color',
            'title' => 'Header Cart Count Background Color',
            'default' => '#acd373',
            'compiler' => true
        ),

        array(
            'id' => 'header_cart_count_color',
            'type' => 'color',
            'title' => 'Header Cart Count Color',
            'default' => '#fff',
            'compiler' => true
        ),

    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Header Menu', 'omeo'),
    'id' => 'general-menu',
    'subsection' => true,
    'icon' => 'fa fa-bars',
    'fields' => array(

        array(
            'id' => 'hide-header-vertical',
            'type' => 'switch',
            'title' => esc_attr__('Hidden vertical menu?', 'omeo'),
            'default' => 0,
            'on' => 'On',
            'off' => 'Off',
        ),
        array(
            'id' => 'header-vertical-style',
            'type' => 'button_set',
            'title' => esc_attr__('Vertical menu style', 'omeo'),
            'default' => 'default',
            'options' => array(
                'default' => esc_attr__('Default', 'omeo'),
                'big-icon-desc' => esc_attr__('Biggest style', 'omeo')
            ),
        ),
        array(
            'id' => 'vertical-menu-limit-enable',
            'type' => 'switch',
            'title' => esc_attr__('Enable limit for vertical menu?', 'omeo'),
            'default' => 0,
            'on' => 'On',
            'off' => 'Off',
        ),
        array(
            'id' => 'vertical-menu-limit',
            'type' => 'spinner',
            'title' => esc_html__('Limit vertical menu item', 'omeo'),
            'default' => '5',
            'min' => '3',
            'step' => '1',
            'max' => '30',
            'required' => array('vertical-menu-limit-enable', '=', array(1))
        ),

        array(
            'id' => 'header-color-menu-mobile',
            'type' => 'section',
            'title' => esc_html__('Menu Mobile', 'omeo'),
            'indent' => true
        ),
        array(
            'id' => 'menu_mobile_bar',
            'type' => 'color',
            'title' => 'Menu Bar Icon',
            'default' => '#000',
            'compiler' => true
        ),

        array(
            'id' => 'header-color-menu-section-start',
            'type' => 'section',
            'title' => esc_html__('MENU HORIZONTAL ', 'omeo'),
            'indent' => true
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
            'text-transform'   => true,
            'subsets' => false,
            'units' => 'px'
        ),

        array(
            'id' => 'menu_text_color',
            'type' => 'color',
            'title' => 'Menu Text Color',
            'default' => '#000000',
            'compiler' => true
        ),

        array(
            'id' => 'menu_hover_text_color',
            'type' => 'color',
            'title' => 'Menu Text Hover Color',
            'default' => '#acd373',
            'compiler' => true
        ),

        array(
            'id' => 'menu_border_color',
            'type' => 'color',
            'title' => 'Menu Line Color',
            'default' => '#acd373',
            'compiler' => true
        ),

        array(
            'id' => 'menu_dropdown_bkg_color',
            'type' => 'color',
            'title' => 'Menu Dropdown Background Color',
            'default' => '#fff',
            'compiler' => true
        ),

        array(
            'id' => 'menu_dropdown_title_color',
            'type' => 'color',
            'title' => 'Menu Dropdown Title Color',
            'default' => '#000',
            'compiler' => true
        ),

        array(
            'id' => 'menu_dropdown_text_color',
            'type' => 'color',
            'title' => 'Menu Dropdown Text Color',
            'default' => '#7d7d7d',
            'compiler' => true
        ),

        array(
            'id' => 'menu_dropdown_text_hover_color',
            'type' => 'color',
            'title' => 'Menu Dropdown Text Hover Color',
            'default' => '#acd373',
            'compiler' => true
        ),

        array(
            'id' => 'header-color-menu-section-end',
            'type' => 'section',
            'indent' => false
        ),

        array(
            'id' => 'header-color-vertical-menu-section-start',
            'type' => 'section',
            'title' => esc_html__('Vertical Menu color', 'omeo'),
            'indent' => true
        ),

        array(
            'id' => 'vertical_menu_bkg_title',
            'type' => 'color',
            'title' => 'Vertical Menu',
            'subtitle' => 'Background color title',
            'default' => '#0d51db',
            'compiler' => true
        ),

        array(
            'id' => 'vertical_menu_text_title',
            'type' => 'color',
            'title' => 'Vertical Menu Title Text',
            'default' => '#fff',
            'compiler' => true
        ),

        array(
            'id' => 'dropdown_menu_bkg',
            'type' => 'color',
            'title' => 'Dropdown Vertical Menu Background',
            'default' => '#fff',
            'compiler' => true
        ),
        array(
            'id' => 'dropdown_menu_text',
            'type' => 'color',
            'title' => 'Dropdown Vertical Menu Text',
            'default' => '#303030',
            'compiler' => true
        ),
        array(
            'id' => 'header-color-vertical-menu-section-end',
            'type' => 'section',
            'indent' => false
        ),
    )
));


Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Site Footer', 'omeo'),
    'id' => 'general-footer',
    'icon' => 'fa fa-arrow-circle-down',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'footer-stblock',
            'type' => 'select',
            'title' => 'Static block',
            'subtitle' => wp_kses_post(sprintf(__("If don't have your choice in this select field, please create a new %sstatic block%s, then come back to select here", 'omeo'), '<a href="' . esc_url($_create_block_uri) . '">', '</a>')),
            'data' => 'posts',
            'args' => array(
                'post_type' => 'static_block',
                'posts_per_page' => -1
            )
        ),

        array(
            'id' => 'footer-color-divider',
            'type' => 'divide'
        ),

        array(
            'id' => 'footer_title_font',
            'type' => 'typography',
            'title' => 'Footer Title Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 600,
                'font-size' => '13px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'text-transform'   => true,
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
            'text-transform'   => true,
            'subsets' => false,
            'units' => 'px',
        ),
        array(
            'id' => 'footer_bkg',
            'type' => 'color',
            'title' => 'Footer Main Background Color',
            'default' => '#fff',
            'compiler' => true
        ),

        array(
            'id' => 'footer_title_color',
            'type' => 'color',
            'title' => 'Footer Title Color',
            'default' => '#000000',
            'compiler' => true
        ),

        array(
            'id' => 'footer_text_color',
            'type' => 'color',
            'title' => 'Footer Text Color',
            'default' => '#7d7d7d',
            'compiler' => true
        ),

        array(
            'id' => 'footer_text_hover_color',
            'type' => 'color',
            'title' => 'Footer Text Hover Color',
            'default' => '#acd373',
            'compiler' => true
        ),

        array(
            'id' => 'footer_bottom_bg',
            'type' => 'color',
            'title' => 'Footer Bottom Background Color',
            'default' => '#eff6f6',
            'compiler' => true
        )


    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Newsletter', 'yesshop'),
    'id' => 'extensions-newsletter-subtab',
    'desc' => '',
    'icon' => 'fa fa-envelope-o',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'newsletter-info',
            'type' => 'info',
            'style' => 'info',
            'class' => 'yeti-info',
            'title' => esc_attr__('Newsletter!', 'yesshop'),
            'desc' => esc_attr__('You can use MailChimp for WordPress plugin to build your newsletter form register. Then build newsletter popup via static block, and apply it here.', 'yesshop')
        ),

        array(
            'id' => 'newsletter-popup',
            'type' => 'switch',
            'title' => esc_html__('Newsletter popup', 'yesshop'),
            'default' => 0,
            'on' => 'On',
            'off' => 'Off',
        ),

        array(
            'id' => 'newsletter-popup-content',
            'type' => 'select',
            'title' => esc_html__('Newsletter content - Popup', 'yesshop'),
            'data' => 'posts',
            'args' => array(
                'post_type' => 'static_block',
                'posts_per_page' => -1
            ),
            'required' => array('newsletter-popup', '=', '1'),
        ),

        array(
            'id' => 'newsletter-popup-width',
            'type' => 'slider',
            'title' => esc_html__('Newsletter content - Popup width', 'yesshop'),
            'desc' => esc_html__('Min: 550px, max: 1170px, step: 10px, default: 800px', 'yesshop'),
            'default' => 800,
            'min' => 550,
            'step' => 10,
            'max' => 1170,
            'display_value' => 'text'
        ),

        array(
            'id' => 'newsletter-footer-color-divider',
            'type' => 'divide'
        ),


        array(
            'id' => 'newsletter-footer-color-info',
            'type' => 'info',
            'style' => 'info',
            'title' => esc_attr__('Newsletter Color', 'yesshop'),
            'desc' => esc_attr__('The footer newsletter color options.', 'yesshop'),
        ),

        array(
            'id' => 'footer_newsletter_bkg_form',
            'type' => 'color',
            'title' => 'Background Form Newsletter',
            'default' => '#fff',
            'compiler' => true,
        ),

        array(
            'id' => 'footer_newsletter_text_form',
            'type' => 'color',
            'title' => 'Text Form Newsletter',
            'default' => '#000',
            'compiler' => true,
        ),

        array(
            'id' => 'footer_newsletter_border',
            'type' => 'color',
            'title' => 'Border Newsletter',
            'default' => '#ebebeb',
            'compiler' => true,
        ),

        array(
            'id' => 'footer_newsletter_button',
            'type' => 'color',
            'title' => 'Background Button Newsletter',
            'default' => 'transparent',
            'compiler' => true,
        ),

        array(
            'id' => 'footer_newsletter_button_arrow',
            'type' => 'color',
            'title' => 'Button Arrow',
            'default' => '#000',
            'compiler' => true,
        ),

        array(
            'id' => 'footer_newsletter_text_button',
            'type' => 'color',
            'title' => 'Text Button Newsletter',
            'default' => '#000',
            'compiler' => true,
        ),
    )
));
Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Button color', 'omeo'),
    'id' => 'subsection-button-colors',
    'desc' => '',
    'icon' => 'fa fa-angle-double-right',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'yt-border-radius-button',
            'type' => 'text',
            'title' => esc_html__('Radius', 'omeo'),
            'subtitle' => esc_html__('For Button', 'omeo'),
            'desc' => 'Defined in pixels. Do not add the \'px\' unit.',
            'default' => 5,
            'compiler' => true,
        ),
        array(
            'id' => 'yt-height-button',
            'type' => 'text',
            'title' => esc_html__('Height Button', 'omeo'),
            'subtitle' => esc_html__('For Button', 'omeo'),
            'desc' => 'Defined in pixels. Do not add the \'px\' unit.',
            'default' => 5,
            'compiler' => true,
        ),
        array(
            'id' => 'btn1_font',
            'type' => 'typography',
            'title' => 'Button',
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
            'text-transform'   => true,
            'subsets' => false,
            'units' => 'px'
        ),

        array(
            'id' => 'general-color-info-box-button-1',
            'type' => 'section',
            'title' => esc_html__('BUTTON 1 ', 'omeo'),
            'indent' => true
        ),
        array(
            'id' => 'btn1_text_color',
            'type' => 'link_color',
            'title' => 'Button Primary - Text',
            'subtitle' => 'Text color and hover color',
            'default' => array(
                'regular' => '#fff',
                'hover' => '#fff'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),

        array(
            'id' => 'btn1_bg_color',
            'type' => 'link_color',
            'title' => 'Button Primary - Background',
            'subtitle' => 'Background color and hover color',
            'default' => array(
                'regular' => '#acd373',
                'hover' => '#000'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),

        array(
            'id' => 'general-color-info-box-button-2',
            'type' => 'section',
            'title' => esc_html__('BUTTON 2 ', 'omeo'),
            'indent' => true
        ),

        array(
            'id' => 'btn2_text_color',
            'type' => 'link_color',
            'title' => 'Button Secondary - Text',
            'subtitle' => 'Text color and hover color',
            'default' => array(
                'regular' => '#fff',
                'hover' => '#fff'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),

        array(
            'id' => 'btn2_bg_color',
            'type' => 'link_color',
            'title' => 'Button Secondary - Background',
            'subtitle' => 'Background color and hover color',
            'default' => array(
                'regular' => '#000',
                'hover' => '#acd373'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),
        array(
            'id' => 'general-color-info-box-button-3',
            'type' => 'section',
            'title' => esc_html__('BUTTON 3', 'omeo'),
            'indent' => true
        ),
        array(
            'id' => 'btn3_text_color',
            'type' => 'link_color',
            'title' => 'Button Border - Text',
            'subtitle' => 'Text color and hover color',
            'default' => array(
                'regular' => '#000',
                'hover' => '#acd373'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),

        array(
            'id' => 'btn3_bg_color',
            'type' => 'link_color',
            'title' => 'Button Border - Background',
            'subtitle' => 'Background color and hover color',
            'default' => array(
                'regular' => '#fff',
                'hover' => '#fff'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),

        array(
            'id' => 'btn3_border_color',
            'type' => 'link_color',
            'title' => 'Button Border - Border',
            'subtitle' => 'Border color and hover color',
            'default' => array(
                'regular' => '#e1e1e1',
                'hover' => '#acd373'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),
        array(
            'id' => 'general-color-info-box-grid-action',
            'type' => 'section',
            'title' => esc_html__('PRODUCT GRID ACTION', 'omeo'),
            'indent' => true
        ),
        array(
            'id' => 'grid_action_bg_color',
            'type' => 'color',
            'title' => 'Product Grid Action - Background',
            'default' => '#000',
            'compiler' => true
        ),

        array(
            'id' => 'grid_action_text_color',
            'type' => 'link_color',
            'title' => 'Product Grid Action - Text',
            'subtitle' => 'Text color and hover color',
            'default' => array(
                'regular' => '#fff',
                'hover' => '#acd373'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),
        array(
            'id' => 'general-color-info-box-button-tag',
            'type' => 'section',
            'title' => esc_html__('BUTTON TAG', 'omeo'),
            'indent' => true
        ),
        array(
            'id' => 'btn_tags_color',
            'type' => 'link_color',
            'title' => 'Button Tags - Text',
            'default' => array(
                'regular' => '#7d7d7d',
                'hover' => '#fff'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),

        array(
            'id' => 'btn_tags_bg',
            'type' => 'link_color',
            'title' => 'Button Tags - Background',
            'default' => array(
                'regular' => '#f6f7fb',
                'hover' => '#acd373'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),

    ),
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Heading Block On Home', 'omeo'),
    'id' => 'general-heading',
    'subsection' => true,
    'icon' => 'fa fa-angle-double-right',
    'fields' => array(
        array(
            'id' => 'heading_align',
            'type' => 'select',
            'title' => esc_attr__('Heading Align', 'omeo'),
            'options' => array(
                'heading_align_left' => 'Left',
                'heading_align_right' => 'Right',
                'heading_align_center' => 'Center'
            ),
            'multi' => false,
            'default' => '1',
        ),
        array(
            'id' => 'custom_heading_font',
            'type' => 'typography',
            'title' => 'Heading Block On Home - Font',
            'default' => array(
                'font-family' => 'Playfair Display',
                'font-weight' => 700,
                'font-size' => '48px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => 'italic',
            'text-transform'   => true,
            'subsets' => false,
            'units' => 'px'
        ),
        array(
            'id' => 'heading_block',
            'type' => 'color',
            'title' => 'Heading Block On Home - Color',
            'default' => '#303030',
            'compiler' => true
        ),

        array(
            'id' => 'general-color-info-box-headding-tab',
            'type' => 'info',
            'style' => 'info',
            'class' => 'yeti-info-box',
            'title' => esc_attr__('HEADING TAB', 'omeo')
        ),
        array(
            'id' => 'yt_heading_tab_font',
            'type' => 'typography',
            'title' => 'Heading Tab',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 400,
                'font-size' => '16px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'text-transform'   => true,
            'subsets' => false,
            'units' => 'px'
        ),
        array(
            'id' => 'heading_tab_text',
            'type' => 'link_color',
            'title' => 'Heading Tab Text Color',
            'default' => array(
                'regular' => '#7d7d7d',
                'hover' => '#acd373'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),
    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Heading Page', 'omeo'),
    'id' => 'general-heading-page',
    'subsection' => true,
    'icon' => 'fa fa-angle-double-right',
    'fields' => array(

        array(
            'id' => 'page_heading_font',
            'type' => 'typography',
            'title' => 'Page Heading Font',
            'default' => array(
                'font-family' => 'Playfair Display',
                'font-weight' => 400,
                'font-size' => '36px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'subsets' => false,
            'text-transform'   => true,
            'units' => 'px'
        ),
        array(
            'id' => 'heading_page_color',
            'type' => 'color',
            'title' => 'Heading Page/Heading SideBar',
            'default' => '#000',
            'compiler' => true
        ),
    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Heading Block On SubPage', 'omeo'),
    'id' => 'general-heading-subpage',
    'subsection' => true,
    'icon' => 'fa fa-angle-double-right',
    'fields' => array(

        array(
            'id' => 'yt_heading_subpage_font',
            'type' => 'typography',
            'title' => 'Heading Block SubPage - Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 700,
                'font-size' => '17px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'text-transform'   => true,
            'subsets' => false,
            'units' => 'px'
        ),
    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Sidebar', 'omeo'),
    'id' => 'general-heading-sidebar',
    'subsection' => true,
    'icon' => 'fa fa-angle-double-right',
    'fields' => array(

        array(
            'id' => 'sidebar_heading_font',
            'type' => 'typography',
            'title' => 'Sidebar Heading Font',
            'default' => array(
                'font-family' => 'Playfair Display',
                'font-weight' => 400,
                'font-size' => '24px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'text-transform'   => true,
            'subsets' => false,
            'units' => 'px'
        ),
    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Product Item', 'omeo'),
    'id' => 'general-product-item',
    'subsection' => true,
    'icon' => 'fa fa-angle-double-right',
    'fields' => array(

        array(
            'id' => 'yt_product_item_name_font',
            'type' => 'typography',
            'title' => 'Product Name - Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 700,
                'font-size' => '15px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'text-transform'   => true,
            'subsets' => false,
            'units' => 'px'
        ),

        array(
            'id' => 'main_productname_color',
            'type' => 'link_color',
            'title' => 'Product Name Color',
            'default' => array(
                'regular' => '#000',
                'hover' => '#acd373'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
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
            'units' => 'px'
        ),

        array(
            'id' => 'main_price_color',
            'type' => 'color',
            'title' => 'Price Color',
            'default' => '#505050',
            'compiler' => true
        ),

        array(
            'id' => 'main_price_sale_color',
            'type' => 'color',
            'title' => 'Price Sale Color',
            'default' => '#ff6600',
            'compiler' => true
        ),

        array(
            'id' => 'main_price_old_color',
            'type' => 'color',
            'title' => 'Price Old Color',
            'default' => '#808080',
            'compiler' => true
        ),

        array(
            'id' => 'product_rating_color',
            'type' => 'color',
            'title' => 'Product Rating Color',
            'default' => '#acd373',
            'compiler' => true
        ),



        array(
            'id' => 'product_label_new_color',
            'type' => 'color',
            'title' => 'Product Label New',
            'default' => '#0088cc',
            'compiler' => true
        ),

        array(
            'id' => 'product_label_sale_color',
            'type' => 'color',
            'title' => 'Product Label Sale',
            'default' => '#f73232',
            'compiler' => true
        ),
    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Bread Crumb', 'omeo'),
    'id' => 'bread-crumb',
    'icon' => 'fa fa-link',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'breadcrumb-style',
            'type' => 'select',
            'title' => esc_attr__('Bread Crumb Style', 'omeo'),
            'options' => array(
                'style-1' => 'Style 1',
                'style-2' => 'Style 2'
            ),
            'multi' => false,
            'default' => '1',
        ),

        array(
            'id' => 'breadcrumb_bg_color',
            'type' => 'color',
            'title' => 'Bread Crumb - Background Color',
            'default' => '#fff',
            'compiler' => true
        ),

        array(
            'id' => 'breadcrumb_page_title_color',
            'type' => 'color',
            'title' => 'Bread Crumb - Page Title Color',
            'default' => '#000',
            'compiler' => true
        ),

        array(
            'id' => 'breadcrumb_link_color',
            'type' => 'link_color',
            'title' => 'Bread Crumb - Link Color',
            'default' => array(
                'regular' => '#acd373',
                'hover' => '#7d7d7d'
            ),
            'active' => false,
            'visited' => false,
            'compiler' => true
        ),
    )
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Blog', 'omeo'),
    'id' => 'general-blog',
    'subsection' => true,
    'icon' => 'fa fa-angle-double-right',
    'fields' => array(

        array(
            'id' => 'general-color-info-box-blog-item',
            'type' => 'info',
            'style' => 'info',
            'class' => 'yeti-info-box',
            'title' => esc_attr__('BLOG ITEM', 'omeo')
        ),
        array(
            'id' => 'yt_blog_item_font',
            'type' => 'typography',
            'title' => 'Blog Item - Font',
            'default' => array(
                'font-family' => 'Lato',
                'font-weight' => 400,
                'font-size' => '16px'
            ),
            'compiler' => true,
            'line-height' => false,
            'text-align' => false,
            'color' => false,
            'all_styles' => true,
            'font-style' => false,
            'text-transform'   => true,
            'subsets' => false,
            'units' => 'px'
        ),
        array(
            'id' => 'blog_name_color',
            'type' => 'color',
            'title' => 'Blog Name Color',
            'default' => '#222',
            'compiler' => true
        ),
    )
));



?>