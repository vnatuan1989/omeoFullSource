<?php
// ! File Security Check
if (!defined('ABSPATH')) exit;

if (!class_exists("Yesshop_VC_Woocommerce") && class_exists('Yesshop_VC_Autocomplete')) {

    class Yesshop_VC_Woocommerce extends Yesshop_VC_Autocomplete
    {

        private $vc_maps = array();

        private $data;

        private static $_rd_tab = 'ThemeYeti - Woo';

        function __construct() {
            if (class_exists('WooCommerce')) {
                $this->vc_maps = array(
                    'yesshop_featured_products'             => array('category'),
                    'yesshop_recent_products'               => array('category'),
                    'yesshop_sale_products'                 => array('category'),
                    'yesshop_best_selling_products'         => array('category'),
                    'yesshop_product_tags'                  => array('tags'),
                    'yesshop_product_category_icon'         => array('cats_cat'),
                    'yesshop_product_categories'            => false,
                    'yesshop_top_rated_products'            => array('category'),
                    'yesshop_products_category'             => array('category'),
                    'yesshop_products_category_sect'        => array('category'),
                    'yesshop_products_cats_tabs'            => array('category'),
                    'yesshop_products'                      => array('ids'),
                    'yesshop_product_subcaterories'         => array('cat_group_slug'),
                    'yesshop_featured_prod_cats'            => array('cats_group_slug'),
                    'yesshop_woo_attributes'                => array('slugs'),
                    'yesshop_woo_cats'                      => array('cats_group_slug'),
                    'yesshop_trending_section_products'     => array('prod_group_id'),
                );

                $this->init_maps();
            }
        }

        public function init_maps()
        {
            if (count($this->vc_maps) > 0) {
                foreach ($this->vc_maps as $k => $v) {
                    vc_map(call_user_func(__CLASS__ . '::' . $k));
                    if ($v && is_array($v)) {
                        $base = array(
                            'base' => $k,
                            'params' => $v
                        );
                        $this->createAutoComplete($base);
                    }
                }
            }
        }

        public static function fill_params($params = array()) {
            $return = array(
                array(
                    'type' => 'textfield',
                    'heading' => 'Heading',
                    'param_name' => "title",
                    'admin_label' => true,
                    'dependency' => array('element' => 'head_style', 'value_not_equal_to' => array('image')),
                ),

                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Content as Widget', 'omeo'),
                    'param_name' => 'as_widget',
                    'value' => array(
                        'No' => '0',
                        'Yes' => '1',
                    ),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Widget style', 'omeo'),
                    'param_name' => 'widget_style',
                    'value' => array(
                        'Default' => '',
                        "Boxed" => 'widget_boxed',
                        "Boxed 2" => 'widget_boxed style-2',
                    ),
                    'dependency' => array('element' => 'as_widget', 'value' => array('1')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Numerical order', 'omeo'),
                    'param_name' => 'num_order',
                    'value' => array(
                        'No' => '0',
                        'Yes' => '1',
                    ),
                    'dependency' => array('element' => 'as_widget', 'value' => array('1')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),

            );
            foreach ($params as $param) {
                $return[] = $param;
            }

            return $return;
        }

        public static function tmpObj($set = array(), $unset = array()) {
            $return = array(
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Use Big Product', 'omeo'),
                    'param_name' => 'is_biggest',
                    'value' => array(
                        'No' => '0',
                        'Left' => 'left',
                        'Right' => 'right'
                    ),
                    'dependency' => array('element' => 'as_widget', 'value' => array('0')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),

                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Products mode', 'omeo'),
                    'param_name' => 'product_mode',
                    'value' => array(
                        'Grid mode' => 'grid',
                        'List mode' => 'list',
                    ),
                    'dependency' => array('element' => 'as_widget', 'value' => array('0')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Except limit', 'omeo'),
                    'param_name' => 'excerpt_limit',
                    'value'     => '15',
                    'dependency' => array('element' => 'product_mode', 'value' => array('list')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Use slider', 'omeo'),
                    'param_name' => 'is_slider',
                    'value' => array(
                        'Yes' => '1',
                        'No' => '0',
                    ),
                    'dependency' => array('element' => 'as_widget', 'value' => array('0')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),

                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Auto play', 'omeo'),
                    'param_name' => 'auto_play',
                    'value' => array(
                        'No' => '0',
                        'Yes' => '1'
                    ),
                    'dependency' => array('element' => 'is_slider', 'value' => array('1')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),

                array(
                    'type' => 'attach_image',
                    'heading' => esc_attr__('Banner image', 'omeo'),
                    'param_name' => 'bg_img_id',
                    'value' => '',
                    'dependency' => array('element' => 'is_slider', 'value' => array('0')),
                    'description' => esc_attr__('Select icon from media.', 'omeo'),
                ),

                array(
                    'type' => 'textarea_html',
                    'heading' => esc_attr__('Banner content', 'omeo'),
                    'param_name' => 'content',
                    'dependency' => array('element' => 'is_slider', 'value' => array('0'))
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Banner classes', 'omeo'),
                    'param_name' => 'b_class',
                    'value'     => 'col-sm-12',
                    'dependency' => array('element' => 'is_slider', 'value' => array('0'))
                ),


                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Load more button', 'omeo'),
                    'param_name' => 'load_more',
                    'value' => array(
                        'No' => '0',
                        'Yes' => '1',
                    ),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Load more type', 'omeo'),
                    'param_name' => 'load_more_type',
                    'value' => array(
                        'Ajax' => 'ajax',
                        'Link' => 'link',
                    ),
                    'dependency' => array('element' => 'load_more', 'value' => array('1')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Load more button text', 'omeo'),
                    'param_name' => 'btn_load_more_text',
                    'value' => __('Load more', 'omeo'),
                    'dependency' => array('element' => 'load_more', 'value' => array('1')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Load more link', 'omeo'),
                    'param_name' => 'load_more_link',
                    'value' => '',
                    'dependency' => array('element' => 'load_more_type', 'value' => array('link')),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Load more step', 'omeo'),
                    'param_name' => 'step',
                    'value' => '4',
                    'group' => 'Woocommerce',
                    'dependency' => array('element' => 'load_more', 'value' => array('1')),
                ),

                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Per Page', 'omeo'),
                    'param_name' => "per_page",
                    'value' => 12,
                    'group' => 'Woocommerce'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Columns', 'omeo'),
                    'param_name' => 'columns',
                    'value' => 4,
                    'group' => 'Woocommerce'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Rows', 'omeo'),
                    'param_name' => 'rows',
                    'value' => '1',
                    'group' => 'Woocommerce'
                ),

                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Order by', 'omeo'),
                    'param_name' => 'orderby',
                    'value' => parent::getOrderBy(),
                    'description' => sprintf(esc_html__('Select how to sort retrieved products. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                    'group' => 'Woocommerce'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Order way', 'omeo'),
                    'param_name' => 'order',
                    'value' => parent::getOrder(),
                    'description' => sprintf(esc_html__('Designates the ascending or descending order. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                    'group' => 'Woocommerce'
                ),
            );

            $return = self::fill_params($return);

            if (count($unset) > 0) {
                foreach ($return as $k => $v) {
                    if (in_array(trim($v['param_name']), $unset)) {
                        unset($return[$k]);
                    }
                }
            }

            if (!empty($set)) {
                foreach ($set as $arg) {
                    $_pos = !empty($arg['_pos']) ? absint($arg['_pos']) : 0;
                    unset($arg['_pos']);
                    array_splice($return, $_pos, 0, array($arg));
                }
            }

            return $return;
        }

        public static function yesshop_featured_products()
        {
            $return = array(
                'name' => 'Featured Products',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => self::tmpObj(
                    array(
                        array(
                            'type' => 'autocomplete',
                            'heading' => esc_html__('Categories', 'omeo'),
                            'param_name' => 'category',
                            'settings' => array(
                                'multiple' => true,
                                'sortable' => true,
                            ),
                            'description' => esc_attr__('Leave empty this field filter in All categories.', 'omeo'),
                            '_pos' => 1
                        )
                    )
                )
            );

            return $return;
        }

        public static function yesshop_recent_products()
        {
            return array(
                'name' => 'Recent Products',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => self::tmpObj(
                    array(
                        array(
                            'type' => 'autocomplete',
                            'heading' => esc_html__('Categories', 'omeo'),
                            'param_name' => 'category',
                            'settings' => array(
                                'multiple' => true,
                                'sortable' => true,
                            ),
                            'description' => esc_attr__('Leave empty this field filter in All categories.', 'omeo'),
                            '_pos' => 1
                        )
                    )
                )
            );
        }

        public static function yesshop_sale_products() {
            return array(
                'name' => esc_attr__('Sale Products', 'omeo'),
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => self::tmpObj(
                    array(
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_attr__('Deal product', 'omeo'),
                            'param_name' => "is_deal",
                            'value' => array(
                                'No' => '0',
                                'Yes' => '1',
                            ),
                            '_pos' => 4,
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'autocomplete',
                            'heading' => esc_attr__('Categories', 'omeo'),
                            'param_name' => 'category',
                            'settings' => array(
                                'multiple' => true,
                                'sortable' => true,
                            ),
                            '_pos' => 6,
                            'description' => 'Leave empty this field filter in All categories'
                        ),
                    )
                )
            );
        }

        public static function yesshop_best_selling_products()
        {
            return array(
                'name' => 'Best selling products',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => self::tmpObj(array(
                    array(
                        'type' => 'autocomplete',
                        'heading' => esc_html__('Categories', 'omeo'),
                        'param_name' => 'category',
                        'settings' => array(
                            'multiple' => true,
                            'sortable' => true,
                        ),
                        'description' => esc_attr__('Leave empty this field filter in All categories.', 'omeo'),
                        '_pos' => 1
                    )
                ), array('orderby', 'order'))
            );
        }

        public static function yesshop_top_rated_products()
        {
            return array(
                'name' => 'Top rated products',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => self::tmpObj(
                    array(
                        array(
                            'type' => 'autocomplete',
                            'heading' => esc_html__('Categories', 'omeo'),
                            'param_name' => 'category',
                            'settings' => array(
                                'multiple' => true,
                                'sortable' => true,
                            ),
                            'description' => esc_attr__('Leave empty this field filter in All categories.', 'omeo'),
                            '_pos' => 1
                        )
                    )
                )
            );
        }

        public static function yesshop_product_tags()
        {
            $tag_edit_link = add_query_arg(array('taxonomy' => 'product_tag', 'post_type' => 'product'), admin_url('edit-tags.php'));
            return array(
                'name' => 'Product Tags',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Title',
                        'param_name' => "title",

                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_attr__('Title color', 'omeo'),
                        'param_name' => 't_color',
                        'value' => '#333333'
                    ),
                    array(
                        'type' => 'autocomplete',
                        'heading' => esc_attr__('Tags', 'omeo'),
                        'param_name' => 'tags',
                        'admin_label' => true,
                        'settings' => array(
                            'multiple' => true,
                            'sortable' => true,
                        ),
                        'description' => sprintf(wp_kses(__('Please make sure your tags were added in <a target="_blank" href="%s">here</a>', 'omeo'), array('a' => array('target' => array(), 'href' => array()))), $tag_edit_link),
                    ),

                ),
            );
        }

        public static function yesshop_product_categories() {
            return array(
                'name' => 'Product Categories',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Heading', 'omeo'),
                        'param_name' => 'title',
                        'value' => '',
                        'admin_label' => true
                    ),
                ),
            );
        }


        public static function yesshop_product_category_icon() {
            $_var = parent::getVars('woo');
            return array(
                'name' => 'Product Categories - Icon',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Heading', 'omeo'),
                        'param_name' => 'title',
                        'value' => '',
                        'admin_label' => true
                    ),

                    array(
                        'type' => 'param_group',
                        'heading' => esc_attr__('Categories', 'omeo'),
                        'param_name' => 'cats',
                        'params' => array(
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_attr__('Thumbnail image', 'omeo'),
                                'param_name' => 'icon',
                            ),

                            array(
                                'type' => 'autocomplete',
                                'heading' => esc_attr__('Category', 'omeo'),
                                'param_name' => 'cat',
                                'admin_label' => true,
                                'settings' => array(
                                    'multiple' => false,
                                    'sortable' => false,
                                ),
                                'description' => $_var['autocomplete'],
                            ),
                        ),
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Style', 'omeo'),
                        'param_name' => 'style',
                        'value' => array(
                            'Default' => '',
                            'Shadow style' => 'shadow-style'
                        ),
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show "See all" link', 'omeo'),
                        'param_name' => 'show_all',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                        'std'   => '0',
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show department', 'omeo'),
                        'param_name' => 'show_department',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Columns', 'omeo'),
                        'param_name' => 'columns',
                        'value' => '4',
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),

                ),
            );
        }

        public static function yesshop_products_category() {
            $_var = parent::getVars('woo');
            $params = self::fill_params(array(
                array(
                    'type' => 'autocomplete',
                    'heading' => esc_attr__('Category', 'omeo'),
                    'param_name' => 'category',
                    'admin_label' => true,
                    'settings' => array(
                        'multiple' => true,
                        'sortable' => true,
                    ),
                    'description' => $_var['autocomplete'],
                ),

                array(
                    'type' => 'dropdown',
                    'heading' => 'Use slider',
                    'param_name' => "is_slider",
                    'value' => array(
                        'Yes' => '1',
                        'No' => '0',
                    ),
                    'dependency' => array('element' => 'as_widget', 'value' => array('0')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Load more button', 'omeo'),
                    'param_name' => 'load_more',
                    'value' => array(
                        'No' => '0',
                        'Yes' => '1',
                    ),
                    'dependency' => array('element' => 'is_slider', 'value' => array('0')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Load more type', 'omeo'),
                    'param_name' => 'load_more_type',
                    'value' => array(
                        'Ajax' => 'ajax',
                        'Link' => 'link',
                    ),
                    'dependency' => array('element' => 'load_more', 'value' => array('1')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Load more button text', 'omeo'),
                    'param_name' => 'btn_load_more_text',
                    'value' => __('Load more', 'omeo'),
                    'dependency' => array('element' => 'load_more', 'value' => array('1')),
                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Load more link', 'omeo'),
                    'param_name' => 'load_more_link',
                    'value' => '',
                    'dependency' => array('element' => 'load_more_type', 'value' => array('link')),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Load more step', 'omeo'),
                    'param_name' => 'step',
                    'value' => '4',
                    'group' => 'Woocommerce',
                    'dependency' => array('element' => 'load_more', 'value' => array('1')),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Per Page',
                    'param_name' => "per_page",
                    'value' => 12,
                    'group' => 'Woocommerce'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Columns',
                    'param_name' => 'columns',
                    'value' => 4,
                    'dependency' => array(
                        'element' => 'as_widget',
                        'value' => array('0')
                    ),
                    'group' => 'Woocommerce'
                ),

                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Rows', 'omeo'),
                    'param_name' => 'rows',
                    'value' => '1',
                    'group' => 'Woocommerce'
                ),

                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Order by', 'omeo'),
                    'param_name' => 'orderby',
                    'value' => parent::getOrderBy(),
                    'description' => sprintf(esc_html__('Select how to sort retrieved products. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                    'group' => 'Woocommerce'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Order way', 'omeo'),
                    'param_name' => 'order',
                    'value' => parent::getOrder(),
                    'description' => sprintf(esc_html__('Designates the ascending or descending order. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                    'group' => 'Woocommerce'
                ),

            ));
            return array(
                'name' => 'Products Category',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => $params
            );
        }

        public static function yesshop_products_category_sect() {
            $_var = parent::getVars('woo');

            return array(
                'name' => 'Products Category - Section',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Heading', 'omeo'),
                        'param_name' => 'title',
                        'admin_label' => true,
                        'value' => '',
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_attr__('Heading color', 'omeo'),
                        'param_name' => 'h_bg',
                        'value' => '#f00000',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Style', 'omeo'),
                        'param_name' => 'style',
                        'value' => array(
                            'Big section style' => 'big_section',
                            'Small section style' => 'small_section',
                        ),
                    ),

                    array(
                        'type' => 'autocomplete',
                        'heading' => esc_attr__('Category', 'omeo'),
                        'param_name' => 'category',
                        'admin_label' => true,
                        'settings' => array(
                            'multiple' => false,
                            'sortable' => false,
                        ),
                        'description' => $_var['autocomplete'],
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_attr__('Banner background', 'omeo'),
                        'param_name' => 'banner_bg'
                    ),
                    array(
                        'type' => 'textarea_html',
                        'heading' => esc_attr__('Content', 'omeo'),
                        'param_name' => 'content',
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Sub-Cat limit', 'omeo'),
                        'param_name' => 'cat_limit',
                        'value' => '',
                        'group' => 'Woocommerce',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Per Page (for vertical list)', 'omeo'),
                        'param_name' => 'per_page_v',
                        'value' => '5',
                        'group' => 'Woocommerce',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Per Page', 'omeo'),
                        'param_name' => 'per_page',
                        'value' => '5',
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('big_section')
                        ),
                        'group' => 'Woocommerce',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Columns', 'omeo'),
                        'param_name' => 'columns',
                        'value' => '5',
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('big_section')
                        ),
                        'group' => 'Woocommerce',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Use product tab?', 'omeo'),
                        'param_name' => 'prod_tabs',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0',
                        ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('big_section')
                        ),
                        'group' => 'Woocommerce',
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('New product tab title', 'omeo'),
                        'param_name' => 'new_t_title',
                        'value' => 'New items',
                        'dependency' => array(
                            'element' => 'prod_tabs',
                            'value' => array('1')
                        ),
                        'group' => 'Woocommerce',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Top rated tab title', 'omeo'),
                        'param_name' => 'top_rated_t_title',
                        'value' => 'Top rated items',
                        'dependency' => array(
                            'element' => 'prod_tabs',
                            'value' => array('1')
                        ),
                        'group' => 'Woocommerce',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Sale product tab title', 'omeo'),
                        'param_name' => 'sale_t_title',
                        'value' => 'Sale-off items',
                        'dependency' => array(
                            'element' => 'prod_tabs',
                            'value' => array('1')
                        ),
                        'group' => 'Woocommerce',
                    ),
                )
            );
        }

        public static function yesshop_products_cats_tabs()
        {
            $_var = parent::getVars('woo');
            return array(
                'name' => esc_attr__('Product Categories - tab', 'omeo'),
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Use slider',
                        'param_name' => 'h_is_img',
                        'value' => array(
                            'Heading Text' => '0',
                            'Heading Image' => '1',
                        ),
                        'std' => '0'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Heading', 'omeo'),
                        'param_name' => 'title',
                        'admin_label' => true,
                        'value' => '',
                        'dependency' => array('element' => 'h_is_img', 'value' => array('0')),
                    ),

                    array(
                        'type' => 'attach_image',
                        'heading' => esc_attr__('Heading Image', 'omeo'),
                        'param_name' => 'h_img',
                        'dependency' => array('element' => 'h_is_img', 'value' => array('1')),
                    ),

                    array(
                        'type' => 'autocomplete',
                        'heading' => esc_attr__('Category', 'omeo'),
                        'param_name' => 'category',
                        'admin_label' => true,
                        'settings' => array(
                            'multiple' => true,
                            'sortable' => true,
                        ),
                        'description' => $_var['autocomplete'],
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => 'Tabs style',
                        'param_name' => "tabs_style",
                        'value' => array(
                            'Style 1' => '',
                            'Style 2' => 'style-2',
                            'Style 3' => 'style-3',
                            'Style 4 ' => 'style-4',
                        ),
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Product filter', 'omeo'),
                        'param_name' => 'prod_filter',
                        'value' => array(
                            'Recen product' => '',
                            'Best selling' => 'best_sell',
                            'Featured' => 'featured',
                        ),
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => 'Use slider',
                        'param_name' => "is_slider",
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0',
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Using ajax?',
                        'param_name' => "use_ajax",
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0',
                        ),
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => 'Limit',
                        'param_name' => "per_page",
                        'value' => 12,
                        'group' => 'Woocommerce'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Columns',
                        'param_name' => 'columns',
                        'value' => 4,
                        'group' => 'Woocommerce'
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Order by', 'omeo'),
                        'param_name' => 'orderby',
                        'value' => parent::getOrderBy(),
                        'description' => sprintf(esc_html__('Select how to sort retrieved products. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                        'group' => 'Woocommerce'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Order way', 'omeo'),
                        'param_name' => 'order',
                        'value' => parent::getOrder(),
                        'description' => sprintf(esc_html__('Designates the ascending or descending order. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                        'group' => 'Woocommerce'
                    ),

                ),
            );
        }

        public static function yesshop_products()
        {
            $_var = parent::getVars('woo');

            $params = self::fill_params(array(
                array(
                    'type' => 'autocomplete',
                    'heading' => esc_attr__('Products', 'omeo'),
                    'param_name' => 'ids',
                    'admin_label' => true,
                    'settings' => array(
                        'multiple' => true,
                        'sortable' => true,
                    ),
                    'description' => $_var['autocomplete'],
                ),

                array(
                    'type' => 'dropdown',
                    'heading' => 'Use slider',
                    'param_name' => "is_slider",
                    'value' => array(
                        'Yes' => '1',
                        'No' => '0',
                    ),
                    'dependency' => array(
                        'element' => 'as_widget',
                        'value' => array('0')
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Columns',
                    'param_name' => 'columns',
                    'value' => 4,
                    'dependency' => array(
                        'element' => 'as_widget',
                        'value' => array('0')
                    ),
                    'group' => 'Woocommerce'
                ),

                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Order by', 'omeo'),
                    'param_name' => 'orderby',
                    'value' => parent::getOrderBy(),
                    'description' => sprintf(esc_html__('Select how to sort retrieved products. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                    'group' => 'Woocommerce'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Order way', 'omeo'),
                    'param_name' => 'order',
                    'value' => parent::getOrder(),
                    'description' => sprintf(esc_html__('Designates the ascending or descending order. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                    'group' => 'Woocommerce'
                ),
            ));
            return array(
                'name' => 'Products',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => $params
            );
        }

        public static function yesshop_product_subcaterories()
        {
            $_var = parent::getVars('woo');
            return array(
                'name' => 'Product Sub Categories',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Heading', 'omeo'),
                        'param_name' => 'title',
                        'value' => '',
                    ),

                    array(
                        'type' 			=> 'param_group',
                        'heading' 		=> esc_attr__( 'Categories', 'omeo' ),
                        'param_name' 	=> 'cat_group',
                        'value'			=> urlencode( json_encode( array(
                            array(
                                'desc'		=> 'over %s products awaits you!'
                            )
                        ))),
                        'params'		=> array(
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_attr__( 'Background image', 'omeo' ),
                                'param_name' => 'bg_img',
                            ),
                            array(
                                'type' => 'autocomplete',
                                'heading' => esc_attr__( 'Category', 'omeo' ),
                                'param_name' => 'slug',
                                'admin_label'	=> true,
                                'settings' => array(
                                    'multiple' => false,
                                    'sortable' => false,
                                ),
                                'description' => $_var['autocomplete'],
                                'admin_label' 	=> true
                            ),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show Total Items?', 'yesshop'),
                        'param_name' => 's_total_items',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show Category title?', 'omeo'),
                        'param_name' => 's_cat_title',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show Sub Category?', 'omeo'),
                        'param_name' => 's_sub_cat',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('List two columns?', 'omeo'),
                        'param_name' => 'list_2_col',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0',
                        ),
                        'std'   => '0'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Use slider?', 'omeo'),
                        'param_name' => 'is_slider',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0',
                        ),
                        'std'   => '0'
                    ),


                    array(
                        'type' => 'textfield',
                        'heading' => 'Columns',
                        'param_name' => 'columns',
                        'value' => '3',
                        'description' => $_var['columns_txt'],
                        'group' => 'Woocommerce'
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => 'Limit',
                        'param_name' => "per_page",
                        'value' => 3,
                        'group' => 'Woocommerce'
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Order by', 'omeo'),
                        'param_name' => 'orderby',
                        'value' => parent::getOrderBy(),
                        'description' => sprintf(esc_html__('Select how to sort retrieved products. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                        'group' => 'Woocommerce'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Order way', 'omeo'),
                        'param_name' => 'order',
                        'value' => parent::getOrder(),
                        'description' => sprintf(esc_html__('Designates the ascending or descending order. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                        'group' => 'Woocommerce'
                    ),
                )
            );
        }

        public static function yesshop_featured_prod_cats()
        {
            $_var = parent::getVars('woo');
            return array(
                'name' => 'Featured Categories',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Heading',
                        'param_name' => "title",

                    ),

                    array(
                        'type' => 'param_group',
                        'heading' => esc_attr__('Categories', 'omeo'),
                        'param_name' => 'cats_group',
                        'value' => '',
                        'params' => array(
                            array(
                                'type' => 'autocomplete',
                                'heading' => esc_attr__('Category', 'omeo'),
                                'param_name' => 'slug',
                                'admin_label' => true,
                                'settings' => array(
                                    'multiple' => false,
                                    'sortable' => false,
                                ),
                                'description' => $_var['autocomplete'],
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_attr__('Category image', 'omeo'),
                                'param_name' => 'cat_image',
                            ),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Style',
                        'param_name' => 'style',
                        'value' => array(
                            'Default' => 'default',
                            'None Style' => 'none-style',
                            'Inside meta' => 'inside-meta',
                            'Inside meta 2' => 'inside-meta-2',
                        )
                    ),

                    array(
                        'type' => "checkbox",
                        'heading' => 'Hidden mega cat',
                        'param_name' => "cat_fills",
                        'value' => array(
                            esc_html__('Hidden Title?', 'omeo') => 'title',
                            esc_html__('Hidden counting?', 'omeo') => 'count',
                            esc_html__('Hidden category link?', 'omeo') => 'link',
                        ),
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => 'Columns',
                        'param_name' => 'columns',
                        'value' => 4,
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Use slider',
                        'param_name' => "is_slider",
                        'value' => array(
                            'Yes - Masonry' => '2',
                            'Yes' => '1',
                            'No' => '0',
                        )
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => esc_html__('Css', 'omeo'),
                        'param_name' => 'css',
                        'group' => esc_html__('Design options', 'omeo'),
                    )
                ),
            );
        }

        public static function yesshop_woo_single_cat()
        {
            $_var = parent::getVars('woo');
            return array(
                'name' => 'Woo Single Category',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'autocomplete',
                        'heading' => esc_attr__( 'Category', 'omeo' ),
                        'param_name' => 'slug',
                        'admin_label'	=> true,
                        'settings' => array(
                            'multiple' => false,
                            'sortable' => false,
                        ),
                        'description' => $_var['autocomplete'],
                    ),
                ),
            );
        }

        public static function yesshop_woo_attributes()
        {
            $_var = parent::getVars('woo');
            $attribute_array = array(esc_html__('--Select--', 'omeo') => '');
            $attribute_taxonomies = wc_get_attribute_taxonomies();
            if ($attribute_taxonomies) {
                foreach ($attribute_taxonomies as $tax) {
                    if (taxonomy_exists(wc_attribute_taxonomy_name($tax->attribute_name))) {
                        $key_attr = isset($tax->attribute_label) && strlen($tax->attribute_label) > 0 ? $tax->attribute_label : $tax->attribute_name;
                        $attribute_array[$key_attr] = $tax->attribute_name;
                    }
                }
            }

            return array(
                'name' => 'Woo Attributes',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Attribute', 'omeo'),
                        'param_name' => 'attribute',
                        'value' => $attribute_array
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Columns', 'omeo'),
                        'param_name' => 'columns',
                        'value' => '6'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Limit', 'omeo'),
                        'param_name' => 'limit',
                        'value' => '15'
                    ),
                ),
            );
        }

        public static function yesshop_woo_cats()
        {
            $_var = parent::getVars('woo');
            return array(
                'name' => 'Woo Categories',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Heading',
                        'param_name' => "title",

                    ),

                    array(
                        'type' => 'param_group',
                        'heading' => esc_attr__('Features', 'omeo'),
                        'param_name' => 'cats_group',
                        'value' => '',
                        'params' => array(
                            array(
                                'type' => 'autocomplete',
                                'heading' => esc_attr__('Category', 'omeo'),
                                'param_name' => 'slug',
                                'admin_label' => true,
                                'settings' => array(
                                    'multiple' => false,
                                    'sortable' => false,
                                ),
                                'description' => $_var['autocomplete'],
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_attr__('Category image', 'omeo'),
                                'param_name' => 'cat_image',
                            ),
                        ),
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => 'Button text',
                        'param_name' => 'button_txt',
                        'value' => 'Show now',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Shop all text',
                        'param_name' => "shop_all_text",
                    ),
                ),
            );
        }

        public static function yesshop_trending_section_products(){
            $_var = parent::getVars('woo');
            return array(
                'name' => esc_attr__('Trending products - Section', 'omeo'),
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => self::$_rd_tab,
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Heading', 'omeo'),
                        'param_name' => 'title',
                        'value' => '',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Sub Heading', 'yesshop'),
                        'param_name' => 'sub_title',
                        'value' => '',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Trending style', 'omeo'),
                        'param_name' => 'style',
                        'value' => array(
                            'External thumbnail' => 'external none',
                            'Gallery thumbnail' => 'gallery border',
                            'External thumbnail - Right' => 'external none yt-thumbnail-right',
                            'Overlay' => 'overlay-style-1 overlay  yt-trending-overlay',
                            'Overlay - Style 2' => 'overlay-style-2 overlay yt-trending-overlay',
                        ),
                    ),

                    array(
                        'type' => 'param_group',
                        'heading' => esc_attr__('Products list', 'omeo'),
                        'param_name' => 'prod_group',
                        'value' => '',
                        'params' => array(
                            array(
                                'type' => 'autocomplete',
                                'heading' => esc_attr__('Product', 'omeo'),
                                'param_name' => 'id',
                                'admin_label' => true,
                                'settings' => array(
                                    'multiple' => false,
                                    'sortable' => false,
                                ),
                                'description' => $_var['autocomplete'],
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_attr__('Product thumbnail', 'omeo'),
                                'param_name' => 'thumb',
                            ),
                        ),
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Excerpt words', 'omeo'),
                        'param_name' => 'words',
                        'value' => '18',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Use slider', 'omeo'),
                        'param_name' => 'is_slider',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0',
                        ),
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => 'Auto play',
                        'param_name' => "auto_play",
                        'value' => array(
                            'No' => '0',
                            'Yes' => '1'
                        ),
                        'dependency' => array('element' => 'is_slider', 'value' => array('1'))
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Per Page', 'omeo'),
                        'param_name' => 'per_page',
                        'value' => '12',
                        'group' => 'Woocommerce',
                        'dependency' => array('element' => 'filter', 'value' => array('filter'))
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Order by', 'omeo'),
                        'param_name' => 'orderby',
                        'value' => parent::getOrderBy(),
                        'description' => sprintf(esc_html__('Select how to sort retrieved products. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                        'group' => 'Woocommerce'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Order way', 'omeo'),
                        'param_name' => 'order',
                        'value' => parent::getOrder(),
                        'description' => sprintf(esc_html__('Designates the ascending or descending order. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                        'group' => 'Woocommerce'
                    ),
                ),
            );
        }
    }

    new Yesshop_VC_Woocommerce();

}