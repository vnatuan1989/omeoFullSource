<?php

if (!class_exists('Yesshop_MetaBox')) {
    class Yesshop_MetaBox extends Yesshop_MetaBox_Template
    {

        private $page_options = array();
        private $post_options = array();

        public function __construct()
        {
            add_action("admin_init", array($this, "register_metabox"));
            add_action('save_post', array($this, 'save_options'));
        }

        public function register_metabox()
        {
            add_meta_box('yesshop_page_config', esc_attr__('Page Options', 'omeo'), array($this, "page_options"), "page", "normal", "high");
            add_meta_box('yesshop_post_config', esc_attr__('Post Options', 'omeo'), array($this, "post_options"), "post", "normal", "high");

            if(class_exists('Yetithemes_TeamMembers_Admin')) {
                add_meta_box('yesshop_team_config', esc_attr__('Member infomations', 'omeo'), array($this, 'member_options'), 'team', 'normal', 'high');
            }

        }

        private function get_allMetaSlider()
        {
            $res_args = array();
            if (class_exists('MetaSliderPlugin')) {
                $args = array(
                    'post_type' => 'ml-slider',
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'suppress_filters' => 1, // wpml, ignore language filter
                    'order' => 'ASC',
                    'posts_per_page' => -1
                );
                $all_sliders = get_posts($args);

                foreach ($all_sliders as $slideshow) {
                    $id = $slideshow->ID;
                    $res_args[$id] = $slideshow->post_title;
                }
            }
            return $res_args;
        }

        private function get_revolutionSliders()
        {
            $arrShort = array();
            if (class_exists('RevSlider') && class_exists('UniteFunctionsRev')) {
                $slider = new RevSlider();
                $arrSliders = $slider->getArrSliders();
                if (!empty($arrSliders)) {
                    foreach ($arrSliders as $slider) {
                        $title = $slider->getTitle();
                        $alias = $slider->getAlias();
                        $arrShort[$alias] = $title;
                    }
                }
            }
            return $arrShort;
        }

        private function get_allSidebar($sidebar_options)
        {
            global $wp_registered_sidebars;
            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebar_options[$sidebar['id']] = $sidebar['name'];
            }
            return $sidebar_options;
        }

        public function page_options()
        {
            global $post;
            $page_options = unserialize(get_post_meta($post->ID, 'yesshop_page_options', true));

            $meta_slider_args = $this->get_allMetaSlider();

            $rev_slider_args = $this->get_revolutionSliders();

            $tmp_options = array(
                array(
                    'type' => 'tabs',
                    'pagram' => array(
                        array(
                            'id' => 'tab_general',
                            'title' => esc_html__('General', 'omeo'),
                            'class' => "dashicons-before dashicons-desktop",
                            'pagram' => array(
                                array(
                                    'type' => 'checkbox',
                                    'label' => esc_html__('Page Title', 'omeo'),
                                    'name' => 'page_show_title',
                                    'ntd' => isset($page_options['page_show_title']) ? $page_options['page_show_title'] : 1,
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'label' => esc_attr__('Page Vertical Menu', 'omeo'),
                                    'name' => 'page_show_vert_menu',
                                    'desc' => esc_attr__('Alway open vertical menu', 'omeo'),
                                    'ntd' => isset($page_options['page_show_vert_menu']) ? $page_options['page_show_vert_menu'] : 0,
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'label' => esc_html__('Page Breadcrumb', 'omeo'),
                                    'name' => 'page_show_breadcrumb',
                                    'class' => 'yeti-field-hr',
                                    'ntd' => isset($page_options['page_show_breadcrumb']) ? $page_options['page_show_breadcrumb'] : 1,
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'label' => esc_html__('One page', 'omeo'),
                                    'name' => 'one_page',
                                    'ntd' => isset($page_options['one_page']) ? $page_options['one_page'] : 0,
                                )
                            ),
                        ),
                        array(
                            'id' => 'tab_layout',
                            'title' => esc_html__('Layout', 'omeo'),
                            'class' => "dashicons-before dashicons-align-right",
                            'pagram' => array(
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Page Layout', 'omeo'),
                                    'name' => 'page_layout',
                                    'ntd' => isset($page_options['page_layout']) ? $page_options['page_layout'] : '0-0',
                                    'class' => 'yeti-field-hr',
                                    'value' => array(
                                        '0-0' => esc_attr__('Full width', 'omeo'),
                                        '1-0' => esc_attr__('Left sidebar', 'omeo'),
                                        '0-1' => esc_attr__('Right Sidebar', 'omeo'),
                                        '1-1' => esc_attr__('Left & Right Sidebar', 'omeo'),
                                    ),
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Left sidebar', 'omeo'),
                                    'name' => 'page_leftsidebar',
                                    'ntd' => isset($page_options['page_leftsidebar']) ? $page_options['page_leftsidebar'] : '',
                                    'value' => $this->get_allSidebar(array('' => esc_attr__('--Select a sidebar--', 'omeo'))),
                                    'request' => array(
                                        'element' => 'page_layout',
                                        'values' => array('1-0', '1-1')
                                    )
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Right sidebar', 'omeo'),
                                    'name' => 'page_rightsidebar',
                                    'ntd' => isset($page_options['page_rightsidebar']) ? $page_options['page_rightsidebar'] : '',
                                    'value' => $this->get_allSidebar(array('' => esc_attr__('--Select a sidebar--', 'omeo'))),
                                    'request' => array(
                                        'element' => 'page_layout',
                                        'values' => array('0-1', '1-1')
                                    )
                                ),
                            ),
                        ),
                        array(
                            'id' => 'tab_slideshow',
                            'title' => esc_html__('Slideshow', 'omeo'),
                            'class' => "dashicons-before dashicons-images-alt2",
                            'pagram' => array(
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Slider type', 'omeo'),
                                    'name' => 'slider_type',
                                    'class' => 'yeti-field-hr',
                                    'ntd' => isset($page_options['slider_type']) ? $page_options['slider_type'] : '',
                                    'value' => array(
                                        '' => "No Slider",
                                        'metaslider' => "Meta slider",
                                        'revolution' => "Revolution slider",
                                    ),
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Meta Slider', 'omeo'),
                                    'name' => 'meta_slider',
                                    'ntd' => isset($page_options['meta_slider']) ? $page_options['meta_slider'] : '',
                                    'value' => $meta_slider_args,
                                    'empty_mess' => esc_html__("Empty value or Meta Slider not exist!", 'omeo'),
                                    'request' => array(
                                        'element' => 'slider_type',
                                        'values' => array('metaslider')
                                    )
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Revolution Slider', 'omeo'),
                                    'name' => 'rev_slider',
                                    'ntd' => isset($page_options['rev_slider']) ? $page_options['rev_slider'] : '',
                                    'value' => $rev_slider_args,
                                    'empty_mess' => esc_html__("Empty value or SliderRevolution not exist!", 'omeo'),
                                    'request' => array(
                                        'element' => 'slider_type',
                                        'values' => array('revolution')
                                    )
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Slider swapper', 'omeo'),
                                    'name' => 'slider_swap',
                                    'class' => 'yeti-field-hr',
                                    'ntd' => isset($page_options['slider_swap']) ? $page_options['slider_swap'] : '',
                                    'value' => array(
                                        ''              => 'Container fluid',
                                        'extra_width'   => 'Container Extra',
                                        'container'     => 'Container',
                                    ),
                                ),
                            ),
                        ),
                        array(
                            'id' => 'tab_custom_template',
                            'title' => esc_html__('Page template', 'omeo'),
                            'class' => "dashicons-before dashicons-editor-quote",
                            'pagram' => array(
                                array(
                                    'type' => 'subtabs',
                                    'class' => 'yeti-field-hr',
                                    'pagram' => array(
                                        array(
                                            'id' => 'subtab_blogtemplare',
                                            'title' => esc_html__('Blog Grid', 'omeo'),
                                            'pagram' => array(
                                                array(
                                                    'type' => 'select',
                                                    'label' => esc_html__('Blog Columns', 'omeo'),
                                                    'name' => 'yeti_blog_columns',
                                                    'ntd' => isset($page_options['yeti_blog_columns']) ? $page_options['yeti_blog_columns'] : '',
                                                    'value' => array(
                                                        '' => "Default",
                                                        '2' => "2 Columns",
                                                        '3' => "3 Columns",
                                                        '4' => "4 Columns",
                                                    ),
                                                    'desc' => esc_html__("This use only for Blog Grid page template", 'omeo')
                                                ),
                                                array(
                                                    'type' => 'size',
                                                    'label' => esc_html__('Video size', 'omeo'),
                                                    'name' => 'nth_blog_v_size',
                                                    'ntd' => isset($page_options['nth_blog_v_size']) ? $page_options['nth_blog_v_size'] : '',
                                                    'desc' => esc_html__("This use only for Blog Grid page template", 'omeo')
                                                ),
                                                array(
                                                    'type' => 'number',
                                                    'label' => esc_html__('Post per page', 'omeo'),
                                                    'name' => 'page_temp_per_page',
                                                    'ntd' => isset($page_options['page_temp_per_page']) ? $page_options['page_temp_per_page'] : ''
                                                )
                                            )
                                        ),
                                        array(
                                            'id' => 'subtab_albumtemplare',
                                            'title' => esc_html__('Album Grid', 'omeo'),
                                            'pagram' => array(
                                                array(
                                                    'type' => 'select',
                                                    'label' => esc_html__('Album Style', 'omeo'),
                                                    'name' => 'album_style',
                                                    'ntd' => isset($page_options['album_style']) ? $page_options['album_style'] : '',
                                                    'value' => array(
                                                        '' => esc_html__('Style 1', 'omeo'),
                                                        'style-2' => esc_html__('Style 2', 'omeo'),
                                                    )
                                                ),

                                            )
                                        )
                                    )
                                )
                            ),
                        ),
                    ),
                ),
                array(
                    'type' => 'wp_nonce_field',
                    'key' => 'yeti_nonce_page_options',
                    'value' => '_UPDATE_PAGE_OPTION_',
                ),
            );

            $this->set_TmpOptions($tmp_options);
            $this->createTmp();
        }

        public function post_options()
        {
            global $post;
            $post_options = unserialize(get_post_meta($post->ID, 'yesshop_post_options', true));

            $tmp_options = array(
                array(
                    'type' => 'tabs',
                    'pagram' => array(
                        array(
                            'id' => 'tab-layout',
                            'title' => esc_html__('Layout', 'omeo'),
                            'class' => "dashicons-before dashicons-align-right",
                            'pagram' => array(
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Layout', 'omeo'),
                                    'name' => 'blog_layout',
                                    'class' => 'yeti-field-hr',
                                    'ntd' => isset($post_options['blog_layout']) ? $post_options['blog_layout'] : 'def',
                                    'value' => array(
                                        '' => esc_attr__('-- Inherit --', 'omeo'),
                                        '0-0' => esc_attr__('Full width', 'omeo'),
                                        '1-0' => esc_attr__('Left sidebar', 'omeo'),
                                        '0-1' => esc_attr__('Right Sidebar', 'omeo'),
                                        '1-1' => esc_attr__('Left & Right Sidebar', 'omeo'),
                                    ),
                                    'desc' => esc_attr__('By default, it will apply the choice from Theme Options', 'omeo')
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Left sidebar', 'omeo'),
                                    'name' => 'post_leftsidebar',
                                    'ntd' => isset($post_options['post_leftsidebar']) ? $post_options['post_leftsidebar'] : '',
                                    'value' => $this->get_allSidebar(array('' => esc_attr__('--Inherit--', 'omeo'))),
                                    'desc' => esc_attr__('By default, it will apply the choice from Theme Options', 'omeo')
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Right sidebar', 'omeo'),
                                    'name' => 'post_rightsidebar',
                                    'ntd' => isset($post_options['post_rightsidebar']) ? $post_options['post_rightsidebar'] : '',
                                    'value' => $this->get_allSidebar(array('' => esc_attr__('--Inherit--', 'omeo'))),
                                    'desc' => esc_attr__('By default, it will apply the choice from Theme Options', 'omeo')
                                ),
                            ),
                        ),
                        array(
                            'id' => 'tab-shortcdoe',
                            'class' => "dashicons-before dashicons-admin-post",
                            'title' => esc_html__('Shortcode', 'omeo'),
                            'pagram' => array(
                                array(
                                    'type' => 'textarea',
                                    'label' => esc_html__('Thumbnail Shortcode', 'omeo'),
                                    'name' => 'post_shortcode',
                                    'holder' => "",
                                    'desc' => sprintf(esc_html__('Please enter your shortcode content as slider shortcode...', 'omeo'), '<a href="https://soundcloud.com/" target="_blank">', '</a>'),
                                    'ntd' => isset($post_options['post_shortcode']) ?
                                        stripslashes(htmlspecialchars_decode($post_options['post_shortcode'])) : '',
                                ),

                            ),
                        ),
                        array(
                            'id' => 'tab-2',
                            'class' => "dashicons-before dashicons-format-video",
                            'title' => esc_html__('Video', 'omeo'),
                            'pagram' => array(
                                array(
                                    'type' => 'select',
                                    'label' => esc_html__('Source', 'omeo'),
                                    'name' => 'source_type',
                                    'ntd' => isset($post_options['source_type']) ? $post_options['source_type'] : '',
                                    'class' => 'yeti-field-hr',
                                    'value' => array(
                                        'local' => "Local",
                                        'online' => "Online",
                                    ),
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => esc_html__('Url', 'omeo'),
                                    'name' => 'online_url',
                                    'class' => 'yeti-field-hr',
                                    'holder' => "https://www.youtube...",
                                    'desc' => esc_html__('Support youtube, vimeo.', 'omeo'),
                                    'ntd' => isset($post_options['online_url']) ? $post_options['online_url'] : '',
                                ),
                                array(
                                    'type' => 'media',
                                    'label' => esc_html__('Mp4 Url', 'omeo'),
                                    'name' => 'mp4_url',
                                    'ntd' => isset($post_options['mp4_url']) ? $post_options['mp4_url'] : '',
                                ),
                                array(
                                    'type' => 'media',
                                    'label' => esc_html__('Ogg Url', 'omeo'),
                                    'name' => 'ogg_url',
                                    'ntd' => isset($post_options['ogg_url']) ? $post_options['ogg_url'] : '',
                                ),
                                array(
                                    'type' => 'media',
                                    'label' => esc_html__('Webm Url', 'omeo'),
                                    'name' => 'webm_url',
                                    'ntd' => isset($post_options['webm_url']) ? $post_options['webm_url'] : '',
                                ),
                            ),
                        ),

                        array(
                            'id' => 'tab-audio',
                            'class' => "dashicons-before dashicons-format-audio",
                            'title' => esc_html__('Audio', 'omeo'),
                            'pagram' => array(
                                array(
                                    'type' => 'textarea',
                                    'label' => esc_html__('Audio Embed', 'omeo'),
                                    'name' => 'audio_embed',
                                    'holder' => "Soundclound iframe...",
                                    'desc' => sprintf(esc_html__('Please enter embed code for audio (you can use %1$ssoundcloud.com%2$s)', 'omeo'), '<a href="https://soundcloud.com/" target="_blank">', '</a>'),
                                    'ntd' => isset($post_options['audio_embed']) ?
                                        stripslashes(htmlspecialchars_decode($post_options['audio_embed'])) : '',
                                ),

                            ),
                        )
                    ),
                ),
                array(
                    'type' => 'wp_nonce_field',
                    'key' => 'nth_nonce_post_options',
                    'value' => '_UPDATE_POST_OPTION_',
                ),
            );

            $this->set_TmpOptions($tmp_options);
            $this->createTmp();

        }

        public function member_options()
        {
            global $post;

            $team_options = unserialize(get_post_meta($post->ID, 'nth_team_options', true));
            $tmp_options = array(
                array(
                    'type' => 'tabs',
                    'pagram' => array(
                        array(
                            'id' => 'tab-general',
                            'title' => esc_html__('General', 'omeo'),
                            'class' => "dashicons-before dashicons-admin-home",
                            'pagram' => array(
                                array(
                                    'type' => 'text',
                                    'label' => esc_html__('Role', 'omeo'),
                                    'name' => 'role',
                                    'class' => 'yeti-field-hr',
                                    'holder' => "administrator",
                                    'ntd' => isset($team_options['role']) ? $team_options['role'] : '',
                                ),
                                array(
                                    'type' => 'email',
                                    'label' => esc_html__('Email', 'omeo'),
                                    'name' => 'email',
                                    'class' => '',
                                    'holder' => "yourmail@example.com",
                                    'ntd' => isset($team_options['email']) ? $team_options['email'] : '',
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => esc_html__('Phone', 'omeo'),
                                    'name' => 'phone',
                                    'holder' => "+(00) 123456789",
                                    'ntd' => isset($team_options['phone']) ? $team_options['phone'] : '',
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => esc_html__('Profile Link', 'omeo'),
                                    'name' => 'pr_link',
                                    'holder' => "#",
                                    'ntd' => isset($team_options['pr_link']) ? $team_options['pr_link'] : '',
                                ),
                            ),
                        ),
                        array(
                            'id' => 'tab-social',
                            'class' => "dashicons-before dashicons-admin-site",
                            'title' => esc_html__('Social network', 'omeo'),
                            'pagram' => array(
                                array(
                                    'type' => 'url',
                                    'label' => esc_html__('Facebook link', 'omeo'),
                                    'name' => 'fb_link',
                                    'class' => 'yeti-field-hr',
                                    'holder' => "",
                                    'ntd' => isset($team_options['fb_link']) ? $team_options['fb_link'] : '',
                                ),
                                array(
                                    'type' => 'url',
                                    'label' => esc_html__('Twitter link', 'omeo'),
                                    'name' => 'tw_link',
                                    'class' => 'yeti-field-hr',
                                    'holder' => "",
                                    'ntd' => isset($team_options['tw_link']) ? $team_options['tw_link'] : '',
                                ),
                                array(
                                    'type' => 'url',
                                    'label' => esc_html__('Google+ link', 'omeo'),
                                    'name' => 'goo_link',
                                    'class' => 'yeti-field-hr',
                                    'holder' => "",
                                    'ntd' => isset($team_options['goo_link']) ? $team_options['goo_link'] : '',
                                ),
                                array(
                                    'type' => 'url',
                                    'label' => esc_html__('Pinterest link', 'omeo'),
                                    'name' => 'pin_link',
                                    'class' => 'yeti-field-hr',
                                    'holder' => "",
                                    'ntd' => isset($team_options['pin_link']) ? $team_options['pin_link'] : '',
                                ),
                                array(
                                    'type' => 'url',
                                    'label' => esc_html__('Instagram link', 'omeo'),
                                    'name' => 'inst_link',
                                    'holder' => "",
                                    'class' => 'yeti-field-hr',
                                    'ntd' => isset($team_options['inst_link']) ? $team_options['inst_link'] : '',
                                ),
                                array(
                                    'type' => 'url',
                                    'label' => esc_html__('LinkedIn link', 'omeo'),
                                    'name' => 'in_link',
                                    'class' => 'yeti-field-hr',
                                    'holder' => "",
                                    'ntd' => isset($team_options['in_link']) ? $team_options['in_link'] : '',
                                ),
                                array(
                                    'type' => 'url',
                                    'label' => esc_html__('Dribbble link', 'omeo'),
                                    'name' => 'drib_link',
                                    'class' => '',
                                    'holder' => "",
                                    'ntd' => isset($team_options['drib_link']) ? $team_options['drib_link'] : '',
                                ),
                            ),
                        ),

                    ),
                ),
                array(
                    'type' => 'wp_nonce_field',
                    'key' => 'nth_nonce_team_options',
                    'value' => '_UPDATE_TEAM_OPTION_',
                ),
            );

            $this->set_TmpOptions($tmp_options);
            $this->createTmp();

        }

        public function portfolio_options(){
            global $post;

            $_options = get_post_meta($post->ID, 'yeti_portfolio_options', true);
            $tmp_options = array(
                array(
                    'type' => 'tabs',
                    'pagram' => array(
                        array(
                            'id' => 'tab-general',
                            'title' => esc_html__('General', 'omeo'),
                            'class' => "dashicons-before dashicons-admin-home",
                            'pagram' => array(
                                array(
                                    'type' => 'text',
                                    'label' => esc_html__('Customer', 'omeo'),
                                    'name' => 'customer',
                                    'class' => 'yeti-field-hr',
                                    'ntd' => isset($_options['customer']) ? $_options['customer'] : '',
                                ),
                            ),
                        ),
                    ),
                ),
                array(
                    'type' => 'wp_nonce_field',
                    'key' => 'yeti_nonce_options',
                    'value' => '_UPDATE_PAGE_OPTION_',
                ),
            );

            $this->set_TmpOptions($tmp_options);
            $this->createTmp();
        }

        public function save_options($post_id)
        {
            $post_type = get_post_type($post_id);
            if (empty($post_type)) return;
            switch ($post_type) {
                case 'page':
                    if (isset($_POST['yeti_nonce_page_options']) && wp_verify_nonce($_POST['yeti_nonce_page_options'], '_UPDATE_PAGE_OPTION_')) {
                        $data = array(
                            'page_show_title' => isset($_POST['page_show_title']) ? $_POST['page_show_title'] : 0,
                            'page_show_vert_menu' => isset($_POST['page_show_vert_menu']) ? $_POST['page_show_vert_menu'] : 0,
                            'page_show_breadcrumb' => isset($_POST['page_show_breadcrumb']) ? $_POST['page_show_breadcrumb'] : 0,
                            'one_page' => isset($_POST['one_page']) ? $_POST['one_page'] : 0,
                            'page_layout' => isset($_POST['page_layout']) ? $_POST['page_layout'] : '0-0',
                            'page_leftsidebar' => isset($_POST['page_leftsidebar']) ? $_POST['page_leftsidebar'] : '',
                            'page_rightsidebar' => isset($_POST['page_rightsidebar']) ? $_POST['page_rightsidebar'] : '',
                            'slider_type' => isset($_POST['slider_type']) ? $_POST['slider_type'] : '',
                            'meta_slider' => isset($_POST['meta_slider']) ? $_POST['meta_slider'] : '',
                            'rev_slider' => isset($_POST['rev_slider']) ? $_POST['rev_slider'] : '',
                            'slider_swap' => isset($_POST['slider_swap']) ? $_POST['slider_swap'] : ''
                        );
                        if (isset($_POST['yeti_blog_columns']) && strlen($_POST['yeti_blog_columns']) > 0)
                            $data['yeti_blog_columns'] = absint($_POST['yeti_blog_columns']);
                        if (isset($_POST['nth_blog_v_size']) && is_array($_POST['nth_blog_v_size'])) {
                            if (!empty($_POST['nth_blog_v_size']['width']) && !empty($_POST['nth_blog_v_size']['height'])) {
                                $data['nth_blog_v_size'] = $_POST['nth_blog_v_size'];
                            }
                        }
                        if (isset($_POST['page_temp_per_page']) && strlen($_POST['page_temp_per_page']) > 0)
                            $data['page_temp_per_page'] = absint($_POST['page_temp_per_page']);
                        if (isset($_POST['album_style']) && strlen($_POST['album_style']) > 0)
                            $data['album_style'] = esc_attr($_POST['album_style']);

                        update_post_meta($post_id, 'yesshop_page_options', serialize($data));
                    }
                    break;
                case 'post':
                    if (isset($_POST['nth_nonce_post_options']) && wp_verify_nonce($_POST['nth_nonce_post_options'], '_UPDATE_POST_OPTION_')) {

                        $data = array(
                            "blog_layout" => isset($_POST['blog_layout']) ? $_POST['blog_layout'] : '',
                            "post_leftsidebar" => isset($_POST['post_leftsidebar']) ? $_POST['post_leftsidebar'] : '',
                            "post_rightsidebar" => isset($_POST['post_rightsidebar']) ? $_POST['post_rightsidebar'] : '',
                            "source_type" => isset($_POST['source_type']) ? $_POST['source_type'] : 'local',
                            "online_url" => isset($_POST['online_url']) ? $_POST['online_url'] : '',
                            "mp4_url" => isset($_POST['mp4_url']) ? $_POST['mp4_url'] : '',
                            "ogg_url" => isset($_POST['ogg_url']) ? $_POST['ogg_url'] : '',
                            "webm_url" => isset($_POST['webm_url']) ? $_POST['webm_url'] : '',
                            "audio_embed" => isset($_POST['audio_embed']) ? esc_html($_POST['audio_embed']) : '',
                            "post_shortcode" => isset($_POST['post_shortcode']) ? esc_html($_POST['post_shortcode']) : '',

                        );

                        update_post_meta($post_id, 'yesshop_post_options', wp_slash(serialize($data)));
                    }
                    break;
                case 'team':
                    if (isset($_POST['nth_nonce_team_options']) && wp_verify_nonce($_POST['nth_nonce_team_options'], '_UPDATE_TEAM_OPTION_')) {

                        $data = array(
                            "role" => isset($_POST['role']) ? $_POST['role'] : '',
                            "email" => isset($_POST['email']) ? $_POST['email'] : '',
                            "phone" => isset($_POST['phone']) ? $_POST['phone'] : '',
                            "pr_link" => isset($_POST['pr_link']) ? $_POST['pr_link'] : '#',
                            "fb_link" => isset($_POST['fb_link']) ? $_POST['fb_link'] : '',
                            "tw_link" => isset($_POST['tw_link']) ? $_POST['tw_link'] : '',
                            "goo_link" => isset($_POST['goo_link']) ? $_POST['goo_link'] : '',
                            "inst_link" => isset($_POST['inst_link']) ? $_POST['inst_link'] : '',
                            "in_link" => isset($_POST['in_link']) ? $_POST['in_link'] : '',
                            "drib_link" => isset($_POST['drib_link']) ? $_POST['drib_link'] : '',
                            "pin_link" => isset($_POST['pin_link']) ? $_POST['pin_link'] : ''
                        );

                        update_post_meta($post_id, 'nth_team_options', serialize($data));
                    }
                    break;
            }

        }

    }
}