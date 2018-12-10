<?php
// ! File Security Check
if (!defined('ABSPATH')) exit;

if (!class_exists("Yesshop_VC_Elements") && class_exists('Yesshop_VC_Autocomplete')) {

    class Yesshop_VC_Elements extends Yesshop_VC_Autocomplete
    {

        private $vc_maps = array();

        function __construct()
        {

            $this->vc_maps = array(
                'yesshop_banner' => false,
                'yesshop_brands' => false,
                'yesshop_infobox' => false,
                'yesshop_recent_posts' => false,
                'yesshop_pricing' => false,
                'yesshop_action' => false,
                'yesshop_maps' => false,
                'yesshop_button' => false,
                'yesshop_social' => false,
                'yesshop_instagram' => false,
                'yesshop_qrcode' => false,
                'yesshop_store_location' => false,
                'yesshop_tag_cloud' => false,
                'yesshop_heading' => false,
                'yeti_empty_space' => false,
            );

            if (class_exists('YetiThemes_Extra')) {
                if (class_exists('Yetithemes_Portfolio')) $this->vc_maps['yesshop_portfolio'] = array('cats');
            }

            if (class_exists('Yetithemes_TeamMembers')) {
                $this->vc_maps['yesshop_teams'] = array('ids');
            }

            if (class_exists('Woothemes_Testimonials')) {
                $this->vc_maps['yesshop_testimonials'] = array('ids');
            }

            if(class_exists('Yetithemes_Gallery')) {
                $this->vc_maps['yesshop_galleries'] = false;
            }

            $this->init_maps();
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

        public static function yesshop_banner()
        {
            return array(
                'name' => 'Banners',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'vc_link',
                        'heading' => 'Banner Link',
                        'param_name' => 'link',
                        'value' => '#',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Background source',
                        'param_name' => 'bg_source',
                        'value' => array(
                            "Exteral link" => 'external',
                            "Media" => 'media',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Background image',
                        'param_name' => "bg_img",
                        'dependency' => array('element' => 'bg_source', 'value' => array('external')),
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_attr__('Icon image', 'omeo'),
                        'param_name' => 'bg_img_id',
                        'value' => '',
                        'dependency' => array('element' => 'bg_source', 'value' => 'media'),
                        'description' => esc_attr__('Select icon from media.', 'omeo'),
                    ),

                    array(
                        'type' => "textarea_html",
                        'heading' => 'Cotent',
                        'param_name' => "content",
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Display Inline',
                        'param_name' => "class",
                        'value' => array(
                            "No" => '',
                            'Yes' => 'pull-left',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Hidden on?',
                        'param_name' => "hidden_on",
                        'value' => array(
                            "None" => '',
                            "Tablet Medium" => 'hidden-md hidden-sm hidden-xs',
                            "Tablet Small" => 'hidden-sm hidden-xs',
                            "Mobile" => 'hidden-xs',
                        ),
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => esc_attr__('Css', 'omeo'),
                        'param_name' => 'css',
                        'group' => esc_attr__('Design options', 'omeo'),
                    ),
                )
            );
        }

        public static function yesshop_brands()
        {
            return array(
                'name' => 'Brands',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Heading',
                        'admin_label' => true,
                        'param_name' => 'title',
                        "description" => '',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => 'Style',
                        'param_name' => 'style',
                        'value' => array(
                            'Default' => '',
                            'Border' => 'border'
                        ),
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'param_group',
                        'heading' => esc_attr__('Brand items', 'omeo'),
                        'param_name' => 'items',
                        'value' => urlencode(json_encode(array())),
                        'params' => array(
                            array(
                                'type' => 'attach_image',
                                'class' => '',
                                'heading' => esc_attr__('Images', 'omeo'),
                                'param_name' => 'img_id',
                                'description' => ''
                            ),
                            array(
                                'type' => 'vc_link',
                                'heading' => esc_attr__('Link', 'omeo'),
                                'param_name' => 'link',
                                'value' => '',
                                'admin_label' => true,
                            ),
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Columns',
                        'admin_label' => true,
                        'param_name' => "column",
                        'value' => 6,
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => esc_attr__('Css', 'omeo'),
                        'param_name' => 'css',
                        'group' => esc_attr__('Design options', 'omeo'),
                    ),
                )
            );
        }

        public static function yesshop_infobox()
        {
            $group_1 = esc_html__('Icon options', 'omeo');
            $group_2 = esc_html__('Color options', 'omeo');

            return array(
                'name' => 'Infobox',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Title',
                        'param_name' => 'title',
                        'value' => 'Title',
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => 'Description',
                        'param_name' => 'desc',
                        'value' => '',
                    ),

                    // Icon options
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Use icon?', 'omeo'),
                        'value' => array(
                            'Yes' => 'yes',
                            "No" => 'no',
                        ),
                        'param_name' => 'use_icon',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Icon library', 'omeo'),
                        'value' => array(
                            esc_html__('Font Awesome', 'omeo') => 'fontawesome',
                            esc_html__('Open Iconic', 'omeo') => 'openiconic',
                            esc_html__('Typicons', 'omeo') => 'typicons',
                            esc_html__('Entypo', 'omeo') => 'entypo',
                            esc_html__('Linecons', 'omeo') => 'linecons',
                            esc_html__('Icon Image', 'omeo') => 'icon_img',
                        ),
                        'admin_label' => true,
                        'param_name' => 'type',
                        'description' => esc_attr__('Select icon library.', 'omeo'),
                        'dependency' => array('element' => "use_icon", 'value' => array('yes')),
                        'group' => $group_1,
                    ),
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_attr__('Icon', 'omeo'),
                        'param_name' => 'icon_fontawesome',
                        'value' => 'fa fa-adjust',
                        'settings' => array(
                            'emptyIcon' => false,
                            'iconsPerPage' => 4000,
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'fontawesome',
                        ),
                        'description' => esc_attr__('Select icon from library.', 'omeo'),
                        'group' => $group_1,
                    ),
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_attr__('Icon', 'omeo'),
                        'param_name' => 'icon_openiconic',
                        'value' => 'vc-oi vc-oi-dial',
                        'settings' => array(
                            'emptyIcon' => false,
                            'type' => 'openiconic',
                            'iconsPerPage' => 4000,
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'openiconic',
                        ),
                        'description' => esc_attr__('Select icon from library.', 'omeo'),
                        'group' => $group_1,
                    ),
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_attr__('Icon', 'omeo'),
                        'param_name' => 'icon_typicons',
                        'value' => 'typcn typcn-adjust-brightness',
                        'settings' => array(
                            'emptyIcon' => false,
                            'type' => 'typicons',
                            'iconsPerPage' => 4000,
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'typicons',
                        ),
                        'description' => esc_attr__('Select icon from library.', 'omeo'),
                        'group' => $group_1,
                    ),
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_attr__('Icon', 'omeo'),
                        'param_name' => 'icon_entypo',
                        'value' => 'entypo-icon entypo-icon-note',
                        'settings' => array(
                            'emptyIcon' => false,
                            'type' => 'entypo',
                            'iconsPerPage' => 4000,
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'entypo',
                        ),
                        'group' => $group_1,
                    ),
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_attr__('Icon', 'omeo'),
                        'param_name' => 'icon_linecons',
                        'value' => 'vc_li vc_li-heart',
                        'settings' => array(
                            'emptyIcon' => false,
                            'type' => 'linecons',
                            'iconsPerPage' => 4000,
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'linecons',
                        ),
                        'description' => esc_attr__('Select icon from library.', 'omeo'),
                        'group' => $group_1,
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_attr__('Icon image', 'omeo'),
                        'param_name' => 'icon_img',
                        'value' => '',
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'icon_img',
                        ),
                        'description' => esc_attr__('Select icon from media.', 'omeo'),
                        'group' => $group_1,
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Background Style', 'omeo'),
                        'param_name' => 'background_style',
                        'value' => array(
                            esc_attr__('None', 'omeo') => '',
                            esc_attr__('Circle', 'omeo') => 'rounded',
                            esc_attr__('Square', 'omeo') => 'boxed',
                            esc_attr__('Rounded', 'omeo') => 'rounded-less',
                        ),
                        'description' => esc_attr__('Background style for icon.', 'omeo'),
                        'group' => $group_1,
                    ),

                    /**
                     * COLOR OPTION
                     */
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Color', 'omeo'),
                        'param_name' => 'color',
                        'value' => Yesshop_VC_Autocomplete::getColors(1),
                        'description' => esc_attr__('Infobox color.', 'omeo'),
                        'param_holder_class' => 'vc_colored-dropdown',
                        'group' => $group_2,
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_attr__('Custom Color', 'omeo'),
                        'param_name' => 'custom_color',
                        'description' => esc_attr__('Select custom color.', 'omeo'),
                        'dependency' => array(
                            'element' => 'color',
                            'value' => 'custom',
                        ),
                        'group' => $group_2,
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Icon backgound', 'omeo'),
                        'param_name' => 'icon_background',
                        'value' => Yesshop_VC_Autocomplete::getColors(1),
                        'std' => 'grey',
                        'description' => esc_attr__('Background Color.', 'omeo'),
                        'param_holder_class' => 'vc_colored-dropdown',
                        'group' => $group_2,
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_attr__('Custom icon backgound', 'omeo'),
                        'param_name' => 'custom_icon_background',
                        'description' => esc_attr__('Select custom icon backgound.', 'omeo'),
                        'dependency' => array(
                            'element' => 'icon_background',
                            'value' => 'custom',
                        ),
                        'group' => $group_2,
                    ),
                )
            );
        }

        public static function yesshop_portfolio()
        {
            return array(
                'name' => 'Portfolio',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(

                    array(
                        'type' => 'textfield',
                        'class' => '',
                        'heading' => esc_attr__('Columns', 'omeo'),
                        'admin_label' => true,
                        'param_name' => 'columns',
                        'value' => '4',
                        'description' => '',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Per Page', 'omeo'),
                        'admin_label' => true,
                        'param_name' => 'limit',
                        'value' => '-1',
                        'description' => '',
                        'edit_field_class' => 'vc_col-sm-3 vc_column'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show Filter', 'omeo'),
                        'param_name' => 'filter_s',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                        'edit_field_class' => 'vc_col-sm-3 vc_column'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show Title', 'omeo'),
                        'admin_label' => true,
                        'param_name' => 'title_s',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show Excerpt', 'omeo'),
                        'admin_label' => true,
                        'param_name' => 'desc_s',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                    ),
                )
            );
        }

        public static function yesshop_recent_posts() {

            $image_size = array(
                'Blog Grid Thumbnail - Shortcode' => 'yesshop_blog_thumb_grid' ,
                'Blog Grid Thumbnail 2 - Shortcode' => 'yesshop_blog_thumb_grid_2',
                'Blog Grid Thumbnail 3 - Shortcode' => 'yesshop_blog_thumb_grid_3',
            );

            return array(
                'name' => esc_attr__('Recent posts', 'omeo'),
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Heading', 'omeo'),
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Content as Widget', 'omeo'),
                        'param_name' => 'as_widget',
                        'value' => array(
                            'No' => '0',
                            'Yes' => '1',
                        ),
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Styling', 'omeo'),
                        'param_name' => 'w_style',
                        'value' => array(
                            'Dark style' => 'dark-style',
                            'Light style' => 'light-style',
                        ),
                        'dependency' => array('element' => 'as_widget', 'value' => array('1')),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Limit',
                        'param_name' => "limit",
                        'value' => '5'
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => 'Excerpt Limit',
                        'param_name' => "excerpt_words",
                        'value' => '15',
                        'dependency' => array('element' => 'as_widget', 'value' => array('0')),
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__( 'Blog layout', 'omeo' ),
                        'param_name' => 'b_layout',
                        'value' => array(
                            esc_attr__('Default', 'omeo' ) 	=> '',
                            esc_attr__('Columns', 'omeo' )	=> 'columns',
                            esc_attr__('List mode', 'omeo' )	=> 'list-mode',
                        ),
                        'dependency' => array('element' => 'as_widget', 'value' => array('0')),
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__( 'Padding', 'omeo' ),
                        'param_name' => 'padding',
                        'value' => array(
                            esc_attr__('Theme default', 'omeo' ) 	=> '',
                            esc_attr__('None padding', 'omeo' )	=> 'none-padding',
                        ),
                        'dependency' => array('element' => 'as_widget', 'value' => array('0')),
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__( 'Image size', 'omeo' ),
                        'param_name' => 'thumb_size',
                        'value' => $image_size,
                        'dependency' => array('element' => 'as_widget', 'value' => array('0')),
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => 'Columns',
                        'param_name' => 'columns',
                        'value' => '1',
                        'dependency' => array('element' => 'as_widget', 'value' => array('0')),
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Order by', 'omeo'),
                        'param_name' => 'orderby',
                        'default' => '',
                        'value' => parent::getOrderBy(array('comment_count', 'modified', 'menu_order')),
                        'description' => sprintf(esc_html__('Select how to sort retrieved products. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Order way', 'omeo'),
                        'param_name' => 'order',
                        'value' => parent::getOrder(),
                        'description' => sprintf(esc_html__('Designates the ascending or descending order. More at %s.', 'omeo'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show cats', 'omeo'),
                        'param_name' => 's_cats',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                        'group' => parent::getVars('c3'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show Author', 'omeo'),
                        'param_name' => 's_author',
                        'value' => array(
                            'No' => '0',
                            'Yes' => '1'
                        ),
                        'group' => parent::getVars('c3'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show excerpt', 'omeo'),
                        'param_name' => 's_excerpt',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                        'group' => parent::getVars('c3'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Show read more', 'omeo'),
                        'param_name' => 's_button',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                        'group' => parent::getVars('c3'),
                    ),
                )
            );
        }

        public static function yesshop_staticblock()
        {
            if (!function_exists('Yetithemes_StaticBlock')) return false;

            $static_blocks = Yetithemes_StaticBlock()->getArgs(true);

            $pr_args = array();

            if (count($static_blocks) > 0) {
                foreach ($static_blocks as $val) {
                    $pr_args[$val['title']] = $val['slug'];
                }
            }

            return array(
                'name' => 'Static Block',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Static block',
                        'param_name' => "id",
                        'value' => $pr_args,
                        "default" => '',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Display',
                        'param_name' => 'style',
                        'value' => array(
                            'Normal' => '',
                            'As grid' => 'grid'
                        ),
                    ),
                ),
            );
        }

        public static function yesshop_teams()
        {
            return array(
                'name' => esc_attr__('Team Member', 'omeo'),
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Heading', 'omeo'),
                        'param_name' => 'title',
                        'value' => '',
                    ),

                    array(
                        'type' => 'autocomplete',
                        'heading' => esc_attr__('Members', 'omeo'),
                        'param_name' => 'ids',
                        'admin_label' => true,
                        'settings' => array(
                            'multiple' => true,
                            'sortable' => true,
                        ),
                        'description' => esc_attr__('Please type [name], [slug] or [id] of Team Members.', 'omeo'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Style', 'omeo'),
                        'param_name' => 'style',
                        'value' => array(
                            'Default' => '',
                            'Bounce' => 'bounce',
                            'Overlay' => 'overlay',
                            'Overlay social' => 'overlay-social',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Columns', 'omeo'),
                        'param_name' => 'columns',
                        'value' => '4',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Use Slider?', 'omeo'),
                        'param_name' => 'is_slider',
                        'value' => array(
                            'No' => '',
                            'Yes' => 'yes',
                        ),
                    ),
                )
            );
        }

        public static function yesshop_testimonials()
        {
            return array(
                'name' => 'Testimonials',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Heading',
                        'param_name' => 'title',
                        'value' => '',
                    ),

                    array(
                        'type' => 'checkbox',
                        'heading' => 'Use slider?',
                        'param_name' => 'use_slider',
                        'edit_field_class' => 'vc_col-sm-6 vc_column',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => 'Style',
                        'param_name' => 'style',
                        'value' => array(
                            "Style - 1" => '1',
                            "Style - 2" => '2',
                            'Style - 3' => '3',
                            'Style - 4' => '4',
                        ),
                        'edit_field_class' => 'vc_col-sm-6 vc_column',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => 'Show avatar?',
                        'param_name' => 's_avata',
                        'value' => array(
                            'Yes' => '1',
                            'No' => '0',
                        ),
                    ),

                    array(
                        'type' => 'autocomplete',
                        'heading' => esc_attr__('Testimonial', 'omeo'),
                        'param_name' => 'ids',
                        'admin_label' => true,
                        'settings' => array(
                            'multiple' => true,
                            'sortable' => true,
                        ),
                        'description' => esc_attr__('Please type [name], [slug] or [id] of testimonials.', 'omeo'),
                    )
                )
            );
        }

        public static function yesshop_pricing()
        {
            return array(
                'name' => 'Pricing',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => 'Heading',
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Type',
                        'param_name' => 'type',
                        'value' => array(
                            'Normal' => '',
                            'Popular' => 'popular'
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Style',
                        'param_name' => 'style',
                        'value' => array(
                            'Style 01' => '1',
                            'Style 02' => '2',
                            'Style 03' => '3',
                            'Style 04' => '4',
                            'Style 05' => '5',
                            'Style 06' => '6'
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Pricing', 'omeo'),
                        'param_name' => 'price',
                        'value' => '$|11.99|mo',
                        "description" => esc_attr__('Ex: $|11.99|mo, Free|30 days', 'omeo')
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_attr__('Description', 'omeo'),
                        'param_name' => 'desc',
                        'value' => '',
                    ),
                    array(
                        'type' => 'param_group',
                        'heading' => esc_attr__('Features', 'omeo'),
                        'param_name' => 'features',
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => esc_attr__('Value', 'omeo'),
                                'param_name' => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_attr__('Short description', 'omeo'),
                                'param_name' => 'tooltip',
                                'admin_label' => true
                            ),
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Button text',
                        'param_name' => 'bt_text',
                        'value' => 'Buy now',
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => 'Button link',
                        'param_name' => 'bt_link',
                    ),

                )
            );
        }

        public static function yesshop_action()
        {
            return array(
                'name' => 'Action',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Label',
                        'param_name' => 'label',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Button text',
                        'param_name' => 'bt_text',
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => 'Button link',
                        'param_name' => 'bt_link',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Use icon?', 'omeo'),
                        'value' => array(
                            'Yes' => '1',
                            "No" => '0',
                        ),
                        'param_name' => 'use_icon',
                    ),
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_attr__('Icon', 'omeo'),
                        'param_name' => 'bt_icon',
                        'value' => 'fa fa-adjust',
                        'settings' => array(
                            'emptyIcon' => false,
                            'iconsPerPage' => 4000,
                        ),
                        'dependency' => array(
                            'element' => 'use_icon',
                            'value' => '1',
                        ),
                        'description' => esc_attr__('Select icon from library.', 'omeo'),
                        'group' => 'Icon options',
                    ),
                )
            );
        }

        public static function yesshop_maps()
        {
            return array(
                'name' => 'Google maps',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Your Addpress',
                        'param_name' => 'address',
                        'admin_label' => true,
                        'description' => esc_attr__('Please type your address here.', 'omeo')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Style',
                        'param_name' => 'style',
                        'value' => array(
                            'Normal' => '',
                            'Facebook' => 'facebook',
                            'Gray' => 'gray',
                            'Light Gray' => 'lightgray',
                            'Custom color' => 'custom_color'
                        ),
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'textarea_raw_html',
                        'heading' => 'Map style JSON data',
                        'param_name' => 'm_color',
                        'value' => 'JTVCJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJhZG1pbmlzdHJhdGl2ZS5jb3VudHJ5JTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJsYWJlbHMlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9mZiUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIybGFuZHNjYXBlLm5hdHVyYWwubGFuZGNvdmVyJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyY29sb3IlMjIlM0ElMjAlMjIlMjNlYmU3ZDMlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlNUQlMEElMjAlMjAlMjAlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJmZWF0dXJlVHlwZSUyMiUzQSUyMCUyMmxhbmRzY2FwZS5tYW5fbWFkZSUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmVsZW1lbnRUeXBlJTIyJTNBJTIwJTIyYWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnZpc2liaWxpdHklMjIlM0ElMjAlMjJvZmYlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlNUQlMEElMjAlMjAlMjAlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJmZWF0dXJlVHlwZSUyMiUzQSUyMCUyMndhdGVyJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJnZW9tZXRyeS5maWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmNvbG9yJTIyJTNBJTIwJTIyJTIzODY5M2EzJTIyJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTVEJTBBJTIwJTIwJTIwJTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJyb2FkLmFydGVyaWFsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9mZiUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIycm9hZC5sb2NhbCUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmVsZW1lbnRUeXBlJTIyJTNBJTIwJTIyYWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnZpc2liaWxpdHklMjIlM0ElMjAlMjJvZmYlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJjb2xvciUyMiUzQSUyMCUyMiUyM2ViZTdkMyUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIyYWRtaW5pc3RyYXRpdmUubmVpZ2hib3Job29kJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9uJTIyJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTVEJTBBJTIwJTIwJTIwJTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJwb2klMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJlbGVtZW50VHlwZSUyMiUzQSUyMCUyMmFsbCUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnN0eWxlcnMlMjIlM0ElMjAlNUIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJ2aXNpYmlsaXR5JTIyJTNBJTIwJTIyb2ZmJTIyJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTVEJTBBJTIwJTIwJTIwJTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJ0cmFuc2l0JTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9mZiUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIycm9hZCUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmVsZW1lbnRUeXBlJTIyJTNBJTIwJTIyYWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnZpc2liaWxpdHklMjIlM0ElMjAlMjJvZmYlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlNUQlMEElMjAlMjAlMjAlMjAlN0QlMEElNUQ=',
                        'dependency' => array('element' => 'style', 'value' => array('custom_color')),
                        'description' => sprintf(esc_html__('You can get Map style JSON data in %1$sMapStylr%2$s', 'omeo'), '<a target="_blank" href="http://www.mapstylr.com/showcase/">', '</a>')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Zoom',
                        'param_name' => 'zoom',
                        'value' => 16,
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Height',
                        'param_name' => 'height',
                        'value' => '450px',
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => 'Marker icon',
                        'param_name' => 'mk_icon',
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'textarea_html',
                        'heading' => 'Widget content',
                        'param_name' => 'content',
                        'value' => 'Your description!',
                    ),
                    Yesshop_VC_Autocomplete::getVars('css_editor')
                )
            );
        }

        public static function yesshop_features()
        {
            return array(
                'name' => 'Features',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Heading',
                        'param_name' => 'title',
                        'admin_label' => true,
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => 'Features style',
                        'param_name' => 'style',
                        'value' => array(
                            'Normal' => '',
                            'Center' => 'text-center',
                            'Icon left' => 'icon-left'
                        ),
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Inside style',
                        'param_name' => "use_boxed",
                        'value' => array(
                            'No' => '0',
                            'Yes' => '1'
                        ),
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Simple features',
                        'param_name' => "simple",
                        'value' => array(
                            'No' => '0',
                            'Yes' => '1'
                        ),
                        'edit_field_class' => 'vc_col-sm-4 vc_column'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Per Row',
                        'param_name' => "per_row",
                        'admin_label' => true,
                        'edit_field_class' => 'vc_col-sm-4 vc_column',
                        'value' => 3
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Limit',
                        'param_name' => 'limit',
                        'admin_label' => true,
                        'value' => 5,
                        'edit_field_class' => 'vc_col-sm-4 vc_column',
                        'dependency' => array('element' => 'simple', 'value' => array('0'))
                    ),
                    array(
                        'type' => 'autocomplete',
                        'heading' => esc_attr__('Features id', 'omeo'),
                        'param_name' => 'id',
                        'admin_label' => true,
                        'settings' => array(
                            'multiple' => false,
                            'sortable' => false,
                        ),
                        'description' => esc_attr__('Please type [name], [slug] or [id] of Fatures.', 'omeo'),
                        'dependency' => array('element' => 'simple', 'value' => array('1'))
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => 'Excerpt limit',
                        'param_name' => "w_limit",
                        'admin_label' => true,
                        'value' => '-1'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Icon Size',
                        'param_name' => "size",
                        'admin_label' => true,
                        'value' => '150',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => 'Show the excerpt?',
                        'param_name' => 's_excerpt',
                        'edit_field_class' => 'vc_col-sm-6 vc_column',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => 'Show learn more link?',
                        'param_name' => 'learn_more',
                        'edit_field_class' => 'vc_col-sm-6 vc_column',
                    ),

                    array(
                        'type' => 'colorpicker',
                        'heading' => 'Title Color',
                        'param_name' => 't_color',
                        'group' => esc_attr__('Color & filter', 'omeo')
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => 'Excerpt Color',
                        'param_name' => 'color',
                        'dependency' => array('element' => 's_excerpt', 'value' => array('true')),
                        'group' => esc_attr__('Color & filter', 'omeo'),
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => 'Link Color',
                        'param_name' => 'l_color',
                        'dependency' => array('element' => 'learn_more', 'value' => array('true')),
                        'group' => esc_attr__('Color & filter', 'omeo'),
                        'edit_field_class' => 'vc_col-sm-6 vc_column',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Link text',
                        'param_name' => 'l_text',
                        'value' => 'Learn more',
                        'dependency' => array('element' => 'learn_more', 'value' => array('true')),
                        'group' => esc_attr__('Color & filter', 'omeo'),
                        'edit_field_class' => 'vc_col-sm-6 vc_column',
                    ),
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_attr__('Icon', 'omeo'),
                        'param_name' => 'icon',
                        'value' => 'fa fa-long-arrow-right',
                        'settings' => array(
                            'emptyIcon' => false,
                            'iconsPerPage' => 4000,
                        ),
                        'dependency' => array('element' => 'learn_more', 'value' => array('true')),
                        'description' => esc_attr__('Select icon from library.', 'omeo'),
                        'group' => esc_attr__('Color & filter', 'omeo')
                    ),
                )
            );
        }

        public static function yesshop_button()
        {
            $params = array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_attr__('Button text', 'omeo'),
                    'param_name' => 'text',
                    'admin_label' => true,
                    'value' => esc_attr__('Button text', 'omeo')
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Button style', 'omeo'),
                    'param_name' => 'style',
                    'value' => array(
                        'Default' => '',
                        'Effect' => 'effect',
                        'Outline' => 'outline',
                        'Gradient' => 'gradient',
                        '3D Style' => 'threed'
                    )
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Background color style', 'omeo'),
                    'param_name' => 'bgcl_style',
                    'value' => array(
                        'Default' => '',
                        'Primary' => 'primary',
                        'Success' => 'success',
                        'Error' => 'danger',
                        'Custom Color' => 'custom_color'
                    )
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_attr__('Custom Color', 'omeo'),
                    'param_name' => 'bg_color',
                    'value' => '#cccccc',
                    'dependency' => array(
                        'element' => 'bgcl_style',
                        'value' => 'custom_color',
                    )
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_attr__('Button color', 'omeo'),
                    'param_name' => 'color',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'bgcl_style',
                        'value' => 'custom_color',
                    )
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_attr__('Border color', 'omeo'),
                    'param_name' => 'border_color',
                    'value' => '#cccccc',
                    'dependency' => array(
                        'element' => 'style',
                        'value' => 'outline',
                    )
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_attr__('Button size', 'omeo'),
                    'param_name' => 'size',
                    'value' => array(
                        'Small size' => '',
                        'Medium size' => 'medium',
                        'Large size' => 'large'
                    )
                ),
                array(
                    'type' => "checkbox",
                    'heading' => 'Use icon',
                    'param_name' => "use_icon",
                    'value' => array(esc_html__('Button with icon.', 'omeo') => '1'),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_attr__('Icon', 'omeo'),
                    'param_name' => 'icon_fontawesome',
                    'value' => 'fa fa-adjust',
                    'settings' => array(
                        'emptyIcon' => false,
                        'iconsPerPage' => 4000,
                    ),
                    'dependency' => array(
                        'element' => 'use_icon',
                        'not_empty' => true,
                    ),
                    'description' => esc_attr__('Select icon from library.', 'omeo'),
                ),
            );
            array_push($params, parent::getVars('el_class'));
            return array(
                'name' => 'Button',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => $params
            );
        }

        public static function yesshop_social()
        {
            return array(
                'name' => 'Social network',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => 'Heading',
                        'param_name' => 'title',
                    ),

                    array(
                        'type' => 'param_group',
                        'heading' => esc_attr__('Social', 'omeo'),
                        'param_name' => 'item',
                        'value' => urlencode(json_encode(array(
                            array(
                                'icon' => 'fa fa-facebook-square',
                                'link' => '#',
                                'title' => 'facebook'
                            ),
                            array(
                                'icon' => 'fa fa-google-plus-square',
                                'link' => '#',
                                'title' => 'Google plug'
                            ),
                        ))),
                        'params' => array(
                            array(
                                'type' => 'iconpicker',
                                'heading' => esc_attr__('Icon', 'omeo'),
                                'param_name' => 'icon',
                                'value' => 'fa fa-adjust',
                                'settings' => array(
                                    'emptyIcon' => false,
                                    'iconsPerPage' => 4000,
                                ),
                                'description' => esc_attr__('Select icon from library.', 'omeo'),
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_attr__('Title', 'omeo'),
                                'param_name' => 'title',
                                'admin_label' => true,
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_attr__('Link', 'omeo'),
                                'param_name' => 'link'
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => esc_attr__('Color', 'omeo'),
                                'param_name' => 'color',
                                'value' => '#ff0000'
                            ),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Tooltip position', 'omeo'),
                        'param_name' => 'tt_location',
                        'value' => array(
                            'Top'       => 'top',
                            'Bottom'    => 'bottom',
                            'Left'      => 'left',
                            'Right'     => 'right'
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Apply color hover',
                        'param_name' => "color_hover",
                        'value' => array(
                            'No' => '0',
                            'Yes' => '1',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Icon size',
                        'param_name' => "ic_size",
                        'value' => array(
                            'Normal' => '',
                            '1x' => 'fa-1x',
                            '2x' => 'fa-2x',
                            '3x' => 'fa-3x',
                            '4x' => 'fa-4x'
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => 'Extra class name',
                        'param_name' => "class",
                    ),
                )
            );
        }

        public static function yesshop_instagram()
        {
            return array(
                'name' => 'Instagram',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => 'Heading',
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => esc_attr__('Username or Hashtag', 'omeo'),
                        'param_name' => 'key',
                        'value' => '',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Limit',
                        'param_name' => 'limit',
                        'value' => '6'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Columns',
                        'param_name' => 'columns',
                        'value' => '6'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Image size',
                        'param_name' => "image_size",
                        'value' => array(
                            'Thumbnail' => 'thumbnail',
                            'Medium' => 'small',
                            'Large' => 'large',
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Use Slider?', 'omeo'),
                        'param_name' => 'is_slider',
                        'value' => array(
                            'No' => '0',
                            'Yes' => '1',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Padding', 'omeo'),
                        'param_name' => 'padding',
                        'value' => '15px'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Cache time (hour)', 'omeo'),
                        'param_name' => 'time',
                        'value' => '2'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Follow button', 'omeo'),
                        'param_name' => 'f_button',
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => 'Button Link',
                        'param_name' => 'link',
                        'value' => '#',
                    ),
                )
            );
        }

        public static function yesshop_qrcode()
        {
            return array(
                'name' => 'QR_Code',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => 'Data',
                        'param_name' => "data",

                    ),
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => 'Data',
                        'param_name' => 'size',
                        'value' => '270x270',
                        'edit_field_class' => 'vc_col-sm-4 vc_column'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Box Style',
                        'param_name' => "ecc",
                        'value' => array(
                            'L' => 'L',
                            'M' => 'M',
                            'Q' => 'Q',
                            'H' => 'H',
                        ),
                        'edit_field_class' => 'vc_col-sm-4 vc_column'
                    ),
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => 'Margin',
                        'param_name' => 'margin',
                        'value' => '0',
                        'edit_field_class' => 'vc_col-sm-4 vc_column'
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_attr__('Color', 'omeo'),
                        'param_name' => 'color',
                        'value' => '000000',
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_attr__('Bg Color', 'omeo'),
                        'param_name' => 'bgcolor',
                        'value' => 'ffffff',
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                )
            );
        }

        public static function yesshop_store_location()
        {
            return array(
                'name' => 'Store Location',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Heading',
                        'param_name' => 'heading',
                        'admin_label' => true
                    ),

                    array(
                        'type' => 'param_group',
                        'heading' => esc_attr__('Store', 'omeo'),
                        'param_name' => 'stores',
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => esc_attr__('Store Name', 'omeo'),
                                'param_name' => 'name',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'place_autocomplete',
                                'heading' => esc_attr__('Store address', 'omeo'),
                                'param_name' => 'address',
                            ),
                            array(
                                'type' => 'vc_link',
                                'heading' => 'Store link',
                                'param_name' => 'link',
                                'value' => 'url:#|title:' . esc_attr('More infomation', 'omeo'),
                                'edit_field_class' => 'vc_col-sm-8 vc_column'
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_attr__('Zoom', 'omeo'),
                                'param_name' => 'zoom',
                                'edit_field_class' => 'vc_col-sm-4 vc_column',
                                'value' => '15'
                            ),
                            array(
                                'type' => 'param_group',
                                'heading' => esc_attr__('Store infomation', 'omeo'),
                                'param_name' => 'infos',
                                'params' => array(
                                    array(
                                        'type' => 'textfield',
                                        'heading' => esc_attr__('Line', 'omeo'),
                                        'param_name' => 'line',
                                        'admin_label' => true
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Map image size',
                        'param_name' => 'map_size',
                        'value' => '270x170',
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Columns',
                        'param_name' => 'columns',
                        'value' => 4,
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                )
            );
        }

        public static function yesshop_tag_cloud()
        {
            return array(
                'name' => 'Tag Cloud',
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Heading',
                        'param_name' => 'heading',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Taxonomy', 'omeo'),
                        'param_name' => 'taxonomy',
                        'value' => parent::list_taxonomies(),
                        'description' => esc_attr__('Select source for tag cloud.', 'omeo'),
                        'admin_label' => true,
                        'save_always' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Separator', 'omeo'),
                        'param_name' => 'sep',
                        'value' => ',',
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Limit', 'omeo'),
                        'param_name' => 'limit',
                        'value' => '45',
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_attr__('Extra class name', 'omeo'),
                        'param_name'    => 'css_class',
                        'value'         => '',
                        'description'   => esc_attr__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'omeo')
                    )
                )
            );
        }

        public static function yesshop_heading()
        {
            return array(
                'name' => esc_attr__('Heading', 'omeo'),
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Heading text', 'omeo'),
                        'param_name' => 'text',
                        'admin_label' => true,
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Heading', 'omeo'),
                        'param_name' => 'heading',
                        'value' => array(
                            'Heading 2' => 'h2',
                            'Heading 3' => 'h3',
                            'Heading 4' => 'h4',
                            'Heading 5' => 'h5',
                            'Heading 6' => 'h6',
                        ),
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => 'Heading style',
                        'param_name' => 'style',
                        'value' => array(
                            "None" => "",
                            "Underline" => "ud-line",
                            "Style 2" => "heading-style-2",
                            "Style 3" => "heading-style-3",
                            "Style 4" => "heading-style-4",
                            "Style 5" => "heading-style-5",
                            "Style 6 - Background" => "heading-style-6-background",
                        ),
                        'edit_field_class' => 'vc_col-sm-6 vc_column'
                    ),
                    array(
                                "type" => "textfield",
                                "heading" => __("Sub Heading (Optional)", 'omeo'),
                                "param_name" => "sub-heading",
                                "value" => "",
                                'admin_label' => true
                            ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Align', 'omeo'),
                        'param_name' => 'align',
                        'value' => array(
                            'Inherit' => '',
                            'Text Left' => 'text-left',
                            'Text Right' => 'text-right',
                            'Text Center' => 'text-center',
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Transformation', 'omeo'),
                        'param_name' => 'trans',
                        'value' => array(
                            'Inherit' => '',
                            'Text lowercase' => 'text-lowercase',
                            'Text uppercase' => 'text-uppercase',
                            'Text capitalize' => 'text-capitalize',
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Heading Color',
                        'param_name' => 'color',
                        'value' => array(
                            "Inherit" => "",
                            "Primary" => "color-primary",
                            "White" => "color-white",
                        )
                    ),
                )
            );
        }

        public static function yesshop_galleries(){
            return array(
                'name' => esc_attr__('Galleries', 'omeo'),
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(

                    array(
                        'type' => 'dropdown',
                        'heading' => esc_attr__('Use Slider?', 'omeo'),
                        'param_name' => 'is_slider',
                        'value' => array(
                            'Yes' => 1,
                            'No' => '0',
                        ),
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Columns', 'omeo'),
                        'param_name' => 'columns',
                        'value'   => '4'
                    ),
                )
            );
        }

        public static function yeti_empty_space()
        {
            return array(
                'name' => esc_attr__('Emty Space Only Desktop', 'omeo'),
                'base' => __FUNCTION__,
                'icon' => 'yeti-icon',
                'category' => parent::getVars('c2'),
                'params' => array(

                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Height', 'omeo'),
                        'param_name' => 'height',
                        'value'   => '30px',
                        'description' => esc_attr__('Enter empty space height (Note: CSS measurement units allowed).', 'omeo')
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Element ID', 'omeo'),
                        'param_name' => 'id',
                        'value'   => '',
                        'description' => esc_attr__('Enter element ID (Note: make sure it is unique and valid according to w3c specification).', 'omeo')
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => esc_attr__('Extra class name', 'omeo'),
                        'param_name' => 'class',
                        'value'   => '',
                        'description' => esc_attr__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'omeo')
                    ),

                )
            );
        }
    }

    new Yesshop_VC_Elements();

}

