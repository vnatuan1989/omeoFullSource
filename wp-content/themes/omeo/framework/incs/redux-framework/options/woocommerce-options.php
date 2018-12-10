<?php

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('E-Commerce', 'omeo'),
    'id' => 'woocommerce',
    'desc' => '',
    'icon' => 'fa fa-shopping-bag',
    'class' => 'color5',
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('General', 'omeo'),
    'id' => 'woo-general',
    'icon' => 'fa fa-tachometer',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'shop-quickshop',
            'type' => 'switch',
            'title' => esc_html__('Quickshop button', 'omeo'),
            'default' => 1,
            'on' => 'On',
            'off' => 'Off',
        ),

        array(
            'id' => 'product-deal-format',
            'type' => 'text',
            'title' => esc_html__('Product Deal format', 'omeo'),
            'desc' => sprintf(esc_html__('For full documentation on this format, visit: %sjQuery.countdown%s', 'omeo'), '<a target="_blank" href="http://hilios.github.io/jQuery.countdown/documentation.html#formatter">', '</a>'),
            'default' => '%D Days/%H Hours/%M Min/%S Sec',
        ),

        array(
            'id' => 'my-account-track-order',
            'type' => 'select',
            'title' => esc_html__('Track order page', 'omeo'),
            'desc' => '',
            'data' => 'page',
        ),

        array(
            'id' => 'cross-sells-number',
            'type' => 'spinner',
            'title' => esc_html__('Cross Sells Number', 'omeo'),
            'subtitle' => esc_html__('Cross-sells are products which you promote in the cart, based on the current product. Depending on your site\'s template they will display on the cart page underneath the cart products table with a thumbnail image.', 'omeo'),
            'default' => '9',
            'min' => '4',
            'step' => '1',
            'max' => '25',
        ),
        array(
            'id' => 'cross-sells-cols',
            'type' => 'spinner',
            'title' => esc_html__('Cross Sells Columns', 'omeo'),
            'default' => '4',
            'min' => '2',
            'step' => '1',
            'max' => '12',
        ),
    ),
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Page Sidebars', 'omeo'),
    'id' => 'woo-layout',
    'icon' => 'fa fa-exchange',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'woo-layout-archive-start',
            'type' => 'section',
            'title' => esc_html__('Archive Layout', 'omeo'),
            'indent' => true,
        ),
        array(
            'id' => 'shop-layout',
            'type' => 'image_select',
            'title' => esc_html__('Shop Layout', 'omeo'),
            'subtitle' => esc_html__('Main layout: none slidebar, left slidebar or right slidebar.', 'omeo'),
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
            'default' => '1-0'
        ),

        array(
            'id' => 'shop-left-sidebar',
            'type' => 'select',
            'title' => 'Select Left Sidebar',
            'data' => 'sidebars',
            'default' => 'shop-widget-area-left',
            'required' => array('shop-layout', '=', array('1-0', '1-1'))
        ),
        array(
            'id' => 'shop-right-sidebar',
            'type' => 'select',
            'title' => 'Select Right Sidebar',
            'data' => 'sidebars',
            'default' => 'shop-widget-area-right',
            'required' => array('shop-layout', '=', array('0-1', '1-1'))
        ),

        array(
            'id' => 'shop-top-filters',
            'type' => 'switch',
            'title' => esc_html__('Shop - Top Filter', 'omeo'),
            'default' => 0,
            'on' => 'Enable',
            'off' => 'Disable',
        ),

        array(
            'id' => 'shop-top-menu',
            'type' => 'switch',
            'title' => esc_html__('Shop - top category', 'omeo'),
            'default' => 0,
            'on' => 'Enable',
            'off' => 'Disable',
            'required' => array('shop-layout', '=', array('0-0'))
        ),

        array(
            'id' => 'shop-top-sidebar',
            'type' => 'select',
            'title' => 'Select Top Sidebar',
            'data' => 'sidebars',
            'default' => 'shop-widget-area-top',
            'required' => array('shop-top-filters', '=', array(1))
        ),

        array(
            'id' => 'woo-layout-archive-end',
            'type' => 'section',
            'indent' => false,
        ),

        array(
            'id' => 'woo-layout-detail-start',
            'type' => 'section',
            'title' => esc_html__('Product Detail Layout', 'omeo'),
            'indent' => true,
        ),

        array(
            'id' => 'product-page-layout',
            'type' => 'image_select',
            'title' => esc_html__('Product Page Layout', 'omeo'),
            'subtitle' => esc_html__('Main layout: none slidebar, left slidebar or right slidebar.', 'omeo'),
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
            'default' => '1-0'
        ),

        array(
            'id' => 'product-page-left-sidebar',
            'type' => 'select',
            'title' => 'Select Left Sidebar',
            'data' => 'sidebars',
            'default' => 'single-product-widget-area-left',
            'required' => array('product-page-layout', '=', array('1-0', '1-1'))
        ),

        array(
            'id' => 'product-page-right-sidebar',
            'type' => 'select',
            'title' => 'Select Right Sidebar',
            'data' => 'sidebars',
            'default' => 'single-product-widget-area-right',
            'required' => array('product-page-layout', '=', array('0-1', '1-1'))
        ),

        array(
            'id' => 'woo-layout-detail-end',
            'type' => 'section',
            'indent' => false,
        ),
    ),
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Product Archive', 'omeo'),
    'id' => 'woo-shop-page',
    'icon' => 'fa fa-archive',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'product_archive_layout',
            'type' => 'switch',
            'title' => esc_html__('Product Archive Layout', 'omeo'),
            'default' => 0,
            'on' => esc_attr__('Box', 'omeo'),
            'off' => esc_attr__('Fullwidth', 'omeo'),
        ),

        array(
            'id' => 'shop_per_page',
            'type' => 'spinner',
            'title' => esc_html__('Products Per Page', 'omeo'),
            'subtitle' => esc_html__('To change the number of WooCommerce products displayed per page.', 'omeo'),
            'default' => 12,
            'min' => 4,
            'step' => 1,
            'max' => 50,
        ),
        array(
            'id' => 'shop_columns',
            'type' => 'spinner',
            'title' => esc_html__('Shop Product Columns', 'omeo'),
            'desc' => esc_html__('Min: 2, max: 12, step:1, default value: 3', 'omeo'),
            'default' => '3',
            'min' => '2',
            'step' => '1',
            'max' => '12',
        ),

        array(
            'id' => 'shop-layout-opt-divide',
            'type' => 'divide'
        ),
        array(
            'id' => 'product-item-style',
            'type' => 'image_select',
            'title' => esc_html__('Catalog item style', 'omeo'),
            'options' => array(
                'classic-1' => array(
                    'alt' => 'product_style-1',
                    'img' => THEME_IMG_URI . 'product_style1.jpg',
                ),
                'classic-2' => array(
                    'alt' => 'product_style-2',
                    'img' => THEME_IMG_URI . 'product_style2.jpg',
                ),
            ),
            'default' => 'classic-1',
        ),

        array(
            'id' => 'products-thumb-style',
            'type' => 'yeti_radio',
            'title' => esc_html__('Product thumbnail style', 'omeo'),
            'options' => array(
                'default' => array(
                    'title' => esc_attr__('Single image', 'omeo'),
                ),
                'double_img_1' => array(
                    'title' => esc_attr__('Double images', 'omeo'),
                ),
            ),
            'default' => 'default'
        ),

        array(
            'id' => 'cat-jumbotron',
            'type' => 'select',
            'title' => 'Jumbotron',
            'data' => 'posts',
            'args' => array(
                'post_type' => 'static_block',
                'posts_per_page' => -1
            )
        ),
    ),
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Product detail', 'omeo'),
    'id' => 'woo-product-detail',
    'icon' => 'fa fa-product-hunt',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'product-detail-meta',
            'type' => 'switch',
            'title' => esc_html__('Product meta', 'omeo'),
            'subtitle' => esc_html__('It\'s SKU, product categories and product tags', 'omeo'),
            'default' => 1,
            'on' => 'On',
            'off' => 'Off',
        ),

        array(
            'id' => 'product-detail-social',
            'type' => 'switch',
            'title' => esc_html__('Product social', 'omeo'),
            'subtitle' => esc_html__('Share product with social network (facebook, google plus, twitter, pinterest).', 'omeo'),
            'default' => 1,
            'on' => 'On',
            'off' => 'Off',
        ),

        array(
            'id' => 'product-page-footer-block',
            'type' => 'select',
            'title' => 'Footer block',
            'data' => 'posts',
            'args' => array(
                'post_type' => 'static_block',
                'posts_per_page' => -1
            )
        ),

        array(
            'id' => 'custom_tab_title',
            'type' => 'text',
            'title' => esc_html__('Custom tab title', 'omeo'),
            'subtitle' => esc_html__('It will show at product tabs', 'omeo'),
            'default' => 'Custom tab',
        ),

        array(
            'id' => 'custom_tab_content',
            'type' => 'editor',
            'title' => esc_html__('Custom tab Content', 'omeo'),
            'default' => stripslashes(htmlspecialchars_decode("Custom tab content.")),
        ),

        array(
            'id' => 'product-page-style',
            'type' => 'image_select',
            'title' => 'Product page - Layout',
            'options' => array(
                '1' => array(
                    'alt' => esc_attr__('Section button', 'omeo'),
                    'img' => get_theme_file_uri('images/single-product-style1.png'),
                ),
                '2' => array(
                    'alt' => esc_attr__('Select input', 'omeo'),
                    'img' => get_theme_file_uri('images/single-product-style2.png'),
                ),
                '3' => array(
                    'alt' => esc_attr__('Select input', 'omeo'),
                    'img' => get_theme_file_uri('images/single-product-style3.png'),
                ),
                '4' => array(
                    'alt' => esc_attr__('Select input', 'omeo'),
                    'img' => get_theme_file_uri('images/single-product-style4.png'),
                ),
                '6' => array(
                    'alt' => esc_attr__('Select input', 'omeo'),
                    'img' => get_theme_file_uri('images/single-product-style5.png'),
                ),
            ),
            'default' => '1',
        ),

        array(
            'id' => 'single-addtocart-ajax-support',
            'type' => 'switch',
            'title' => esc_html__('Single Add To Cart ajax support', 'omeo'),
            'default' => 1,
            'on' => 'On',
            'off' => 'Off',
        ),

        array(
            'id' => 'product-page-variable-style',
            'type' => 'image_select',
            'title' => 'Variablion style',
            'options' => array(
                'section_button' => array(
                    'alt' => esc_attr__('Section button', 'omeo'),
                    'img' => THEME_IMG_URI . 'theme-option-variable-style1.jpg',
                ),
                'select_input' => array(
                    'alt' => esc_attr__('Select input', 'omeo'),
                    'img' => THEME_IMG_URI . 'theme-option-variable-style2.jpg',
                ),
            ),
            'default' => 'section_button',
        ),

        array(
            'id' => 'single-product-list',
            'type' => 'yeti_radio',
            'title' => esc_attr__('Product list', 'omeo'),
            'options' => array(
                '' => array(
                    'title' => esc_attr__('Hidden', 'omeo'),
                    'desc' => esc_attr__('Will hidden product lists in single product pages', 'omeo'),
                ),
                'related' => array(
                    'title' => esc_attr__('Related products list', 'omeo'),
                    'desc' => esc_attr__('Related products is a section on some templates that pulls other products from your store that share the same tags or categories as the current product. These products can not be specified in the admin, but can be influenced by grouping similar products in the same category or by using the same tags.', 'omeo'),
                ),
                'up-sells' => array(
                    'title' => esc_attr__('Up-Sells products list', 'omeo'),
                    'desc' => esc_attr__("Up-sells are products which you recommend instead of the currently viewed product, for example, products that are more profitable or better quality or more expensive.  Depending on your site's template these products will display on the single product page underneath the product's description.", 'omeo'),
                ),
                'both' => array(
                    'title' => esc_attr__('Both products list', 'omeo'),
                    'desc' => '',
                ),
            ),
            'default' => 'related'
        ),
        array(
            'id' => 'single-product-list-columns',
            'type' => 'spinner',
            'title' => esc_html__('Product list - Columns', 'omeo'),
            'subtitle' => esc_html__('The product list use responsive slider, so if you set it is 4, it may display only 3 columns if your product page have one of the sidebar.', 'omeo'),
            'desc' => esc_html__('Min: 2, max: 12, step:1, default value: 3', 'omeo'),
            'default' => 4,
            'min' => 2,
            'step' => 1,
            'max' => 6,
            'display_value' => 'number',
            'required' => array('single-product-list', '!=', '')
        ),

        array(
            'id' => 'product-advanced-review',
            'type' => 'switch',
            'title' => esc_html__('Product Advanced Review', 'omeo'),
            'default' => 1,
            'on' => 'On',
            'off' => 'Off',
        ),

        array(
            'id' => 'product-advanced-rating',
            'type' => 'switch',
            'title' => esc_html__('Product Advanced Rating', 'omeo'),
            'default' => 1,
            'on' => 'On',
            'off' => 'Off',
            'required' => array('product-advanced-review', '=', '1')
        )
    ),
));