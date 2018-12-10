<?php

if (!class_exists('Yetithemes_StaticBlock')) {

    class Yetithemes_StaticBlock
    {

        private $post_type = 'static_block';
        public static $instance = null;

        public static function get_instance()
        {
            if (self::$instance === null) {
                self::$instance = new Yetithemes_StaticBlock();
            }

            return self::$instance;
        }

        public function init()
        {
            add_action('init', array($this, 'register_postType'));

            add_action('save_post', array($this, 'save_options'));
            add_action( 'wp_head', array($this, 'addFrontCss'), 1100 );
        }

        public function register_postType()
        {
            $labels = array(
                'name' => _x('Static blocks', 'post type general name', 'yetithemes'),
                'singular_name' => _x('Block', 'post type singular name', 'yetithemes'),
                'menu_name' => _x('YETI Blocks', 'admin menu', 'yetithemes'),
                'name_admin_bar' => _x('Block', 'add new on admin bar', 'yetithemes'),
                'add_new' => _x('Add New', 'static block', 'yetithemes'),
                'add_new_item' => __('Add New Static Blocks', 'yetithemes'),
                'new_item' => __('New Block', 'yetithemes'),
                'edit_item' => __('Edit Block', 'yetithemes'),
                'view_item' => __('View Block', 'yetithemes'),
                'all_items' => __('Static Blocks', 'yetithemes'),
                'search_items' => __('Search Static Blocks', 'yetithemes'),
                'parent_item_colon' => __('Parent Static Blocks:', 'yetithemes'),
                'not_found' => __('No Static blocks found.', 'yetithemes'),
                'not_found_in_trash' => __('No Static blocks found in Trash.', 'yetithemes')
            );


            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => $this->post_type),
                'capability_type' => 'post',
                'has_archive' => 'staticblocks',
                'hierarchical' => false,
                'menu_icon' => "dashicons-welcome-widgets-menus",
                'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')
            );
            register_post_type($this->post_type, $args);
        }

        public function getArgs($empty_item = false)
        {
            $res_args = wp_cache_get('static_blocks', 'yetithemes');

            if ($res_args === false) {
                $res_args = array();
                $args = array(
                    'post_type' => $this->post_type,
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                );
                $blocks = get_posts($args);
                foreach ($blocks as $block) {
                    $data = array(
                        'title' => $block->post_title,
                        'id' => $block->ID,
                        'slug' => $block->post_name
                    );
                    array_push($res_args, $data);
                }
                wp_cache_add('static_blocks', $res_args, 'yetithemes');
            }

            if ($empty_item) {
                array_unshift($res_args, array(
                    'title' => esc_html__('- Select a Static block -', 'yetithemes'),
                    'id' => 0,
                    'slug' => ''
                ));
            }

            return $res_args;
        }

        public function getSelected($id, $class = 'static-block-select', $vaule = '')
        {
            if (empty($id)) return;
            $_static_arg = $this->getArgs();
            if (!empty($_static_arg)) {
                printf('<select id="%1$s" name="%1$s" class="%2$s">', esc_attr($id), esc_attr($class));
                echo '<option value="">' . esc_html__('&mdash; Select a Static block &mdash;', 'yetithemes') . '</option>';
                foreach ($_static_arg as $key) {
                    echo '<option value="' . esc_attr($key['id']) . '" ' . selected($vaule, $key['id']) . '>' . esc_html($key['title']) . '</option>';
                }
                echo '</select>';
            } else {
                $_edit_url = admin_url('post-new.php?post_type=' . esc_attr($this->post_type), is_ssl() ? 'https' : 'http');
                echo wp_kses_post(sprintf(__('<em>Please create an <a href="%1$s">Static Block</a>, then come back here to selected</em>', 'yetithemes'), esc_url($_edit_url)));
            }

        }

        public function getImage($id = false, $size = 'full')
        {
            if (!$id) return;
            if (has_post_thumbnail($id)) {
                echo get_the_post_thumbnail($id, $size);
            }
        }

        public function getContentByID($id = false, $return = false)
        {
            if (!$id) return;

            global $yesshop_datas;

            $output = wp_cache_get($id, 'yeti_static_block');

            if ($output === false) {

                if (is_ajax() && class_exists('WPBMap')) {
                    WPBMap::addAllMappedShortcodes();
                }

                if (is_numeric($id))
                    $blocks = get_post($id);
                else
                    $blocks = get_posts(array('name' => $id, 'post_type' => 'static_block', 'posts_per_page' => 1));

                $output = '';
                if (!empty($blocks)) {
                    if (is_array($blocks)) {
                        $blocks = $blocks[0];
                    }

                    wp_enqueue_script('wpb_composer_front_js');
                    wp_enqueue_style('js_composer_front');

                    if(isset($yesshop_datas['static_block_global_css']) && absint($yesshop_datas['static_block_global_css']) == 0) {
                        $shortcodes_custom_css = get_post_meta($blocks->ID, '_wpb_shortcodes_custom_css', true);
                        if (!empty($shortcodes_custom_css)) {
                            $output .= '<style type="text/css" scoped data-type="vc_staticblock-custom-css-' . $blocks->ID . '">';
                            $output .= $shortcodes_custom_css;
                            $output .= '</style>';
                        }
                    }

                    remove_filter('the_content', 'wptexturize');
                    $output .= apply_filters('the_content', $blocks->post_content);
                    add_filter('the_content', 'wptexturize');
                }
                wp_cache_add($id, $output, 'yeti_static_block');
            }

            if ($return) return $output; else echo $output;
        }

        public function save_options($post_id){
            $post_type = get_post_type($post_id);
            if (empty($post_type)) return;
            if (strcmp($post_type, $this->post_type) !== 0) return;

            $_shortcode_css = get_option('_yeti_static_block_css', '');

            if(function_exists('visual_composer')) {
                $_post = get_post($post_id);
                $_shortcode_css .= visual_composer()->parseShortcodesCustomCss($_post->post_content);
            }

            YetiThemes_Extra()->update_options('_yeti_static_block_css', $_shortcode_css);

        }

        public function addFrontCss(){
            $_shortcode_css = get_option('_yeti_static_block_css');

            if(isset($_shortcode_css) && strlen($_shortcode_css) > 0 ) {
                $_shortcode_css = strip_tags( $_shortcode_css );
                echo '<style type="text/css" data-type="yeti_shortcodes-custom-css">';
                echo $_shortcode_css;
                echo '</style>';
            }
        }

    }

    if (!function_exists('Yetithemes_StaticBlock')) {
        function Yetithemes_StaticBlock()
        {
            return Yetithemes_StaticBlock::get_instance();
        }
    }

    Yetithemes_StaticBlock()->init();
}