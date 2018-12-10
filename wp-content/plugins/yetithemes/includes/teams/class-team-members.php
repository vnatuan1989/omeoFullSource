<?php


if (!class_exists('Yetithemes_TeamMembers')) {

    class Yetithemes_TeamMembers
    {

        protected $post_type = 'team';

        public function __construct()
        {
            add_action('init', array($this, 'registerPostType'));
        }

        public function registerPostType()
        {
            $labels = array(
                'name' => _x('Team Members', 'post type general name', 'yetithemes'),
                'singular_name' => _x('Team Member', 'post type singular name', 'yetithemes'),
                'menu_name' => _x('YETI Members', 'admin menu', 'yetithemes'),
                'name_admin_bar' => _x('Team Members', 'add new on admin bar', 'yetithemes'),
                'add_new' => _x('Add New', 'Team Member', 'yetithemes'),
                'add_new_item' => __('Add New Member', 'yetithemes'),
                'new_item' => __('New Member', 'yetithemes'),
                'edit_item' => __('Edit Member', 'yetithemes'),
                'view_item' => __('View Member', 'yetithemes'),
                'all_items' => __('All Members', 'yetithemes'),
                'search_items' => __('Search Members', 'yetithemes'),
                'parent_item_colon' => __('Parent Member:', 'yetithemes'),
                'not_found' => __('No Members found.', 'yetithemes'),
                'not_found_in_trash' => __('No Members found in Trash.', 'yetithemes')
            );

            $args = array(
                'labels' => $labels,
                'public' => false,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => false,
                'rewrite' => array('slug' => $this->post_type),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'menu_position' => null,
                'can_export' => true,
                'exclude_from_search' => false,
                'menu_icon' => "dashicons-admin-users",
                'show_in_nav_menus' => false,
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields')
            );

            register_post_type($this->post_type, $args);
        }

    }

}