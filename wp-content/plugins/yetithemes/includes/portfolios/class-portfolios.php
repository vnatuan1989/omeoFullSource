<?php
/**
 * @package yeti-portfolios
 */

if (!class_exists('Yetithemes_Portfolio')) {

    class Yetithemes_Portfolio
    {

        protected $post_type = 'portfolio';

        protected $tax_cat = 'portfolio_cat';

        protected $tax_tag = 'portfolio_tag';

        function __construct()
        {
            add_action('init', array($this, 'registerPostType'));
            /*add_action('init', array($this,'addImageSize') );*/
        }

        public function registerPostType()
        {
            $labels = array(
                'name' => _x('Portfolios', 'post type general name', 'yetithemes'),
                'singular_name' => _x('Portfolio', 'post type singular name', 'yetithemes'),
                'menu_name' => _x('YETI Portfolios', 'admin menu', 'yetithemes'),
                'name_admin_bar' => _x('Portfolio', 'add new on admin bar', 'yetithemes'),
                'add_new' => _x('Add New', 'Portfolio', 'yetithemes'),
                'add_new_item' => __('Add New Portfolio', 'yetithemes'),
                'new_item' => __('New Portfolio', 'yetithemes'),
                'edit_item' => __('Edit Portfolio', 'yetithemes'),
                'view_item' => __('View Portfolio', 'yetithemes'),
                'all_items' => __('All Portfolios', 'yetithemes'),
                'search_items' => __('Search Portfolios', 'yetithemes'),
                'parent_item_colon' => __('Parent Portfolios:', 'yetithemes'),
                'not_found' => __('No Portfolios found.', 'yetithemes'),
                'not_found_in_trash' => __('No Portfolios found in Trash.', 'yetithemes')
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'project'),
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'can_export' => true,
                'exclude_from_search' => false,
                'taxonomies' => array($this->tax_cat, $this->tax_tag),
                'menu_icon' => "dashicons-portfolio",
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields')
            );

            register_post_type($this->post_type, $args);

            flush_rewrite_rules();

            $this->registerCategoryTax();
        }

        public function registerCategoryTax()
        {
            $labels = array(
                'name' => _x('Categories', 'taxonomy general name', 'yetithemes'),
                'singular_name' => _x('Category', 'taxonomy singular name', 'yetithemes'),
                'search_items' => __('Search Categories', 'yetithemes'),
                'popular_items' => __('Popular Categories', 'yetithemes'),
                'all_items' => __('All Categories', 'yetithemes'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Category', 'yetithemes'),
                'update_item' => __('Update Category', 'yetithemes'),
                'add_new_item' => __('Add New Category', 'yetithemes'),
                'new_item_name' => __('New Category Name', 'yetithemes'),
                'separate_items_with_commas' => __('Separate Categories with commas', 'yetithemes'),
                'add_or_remove_items' => __('Add or remove Categories', 'yetithemes'),
                'choose_from_most_used' => __('Choose from the most used Categories', 'yetithemes'),
                'not_found' => __('No Categories found.', 'yetithemes'),
                'menu_name' => __('Categories', 'yetithemes'),
            );

            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                //'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'rewrite' => array('slug' => $this->tax_cat),
            );

            register_taxonomy($this->tax_cat, $this->post_type, $args);

            $labels = array(
                'name' => _x('Tags', 'taxonomy general name', 'yetithemes'),
                'singular_name' => _x('Tag', 'taxonomy singular name', 'yetithemes'),
                'search_items' => __('Search Tags', 'yetithemes'),
                'popular_items' => __('Popular Tags', 'yetithemes'),
                'all_items' => __('All Tags', 'yetithemes'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Tag', 'yetithemes'),
                'update_item' => __('Update Tag', 'yetithemes'),
                'add_new_item' => __('Add New Tag', 'yetithemes'),
                'new_item_name' => __('New Tag Name', 'yetithemes'),
                'separate_items_with_commas' => __('Separate tags with commas', 'yetithemes'),
                'add_or_remove_items' => __('Add or remove tags', 'yetithemes'),
                'choose_from_most_used' => __('Choose from the most used tags', 'yetithemes'),
                'not_found' => __('No tags found.', 'yetithemes'),
                'menu_name' => __('Tags', 'yetithemes'),
            );

            $args = array(
                'hierarchical' => false,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                //'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'rewrite' => array('slug' => $this->tax_tag),
            );

            register_taxonomy($this->tax_tag, $this->post_type, $args);
        }

    }
}
