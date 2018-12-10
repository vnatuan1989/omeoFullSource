<?php

if (!class_exists("Yesshop_VC_Autocomplete") && class_exists('Yesshop_VC_Autocomplete_Query')) {

    class Yesshop_VC_Autocomplete extends Yesshop_VC_Autocomplete_Query
    {

        private $shortcode_base;
        private $param_args = array();

        public function __construct($ops = array())
        {
            if (count($ops) > 0) {
                if (isset($ops['base'])) $this->shortcode_base = $ops['base'];
                if (isset($ops['params'])) $this->param_args = $ops['params'];
                $this->add_autocompleteField();
            }

        }

        public function createAutoComplete($ops = array()) {
            if (empty($ops['params']) || !is_array($ops['params']) || empty($ops['base'])) return;

            foreach ($ops['params'] as $param) {
                if (method_exists($this, "{$ops['base']}_{$param}_callback")) {
                    add_filter("vc_autocomplete_{$ops['base']}_{$param}_callback", array($this, "{$ops['base']}_{$param}_callback"), 10, 1);
                }

                if (method_exists($this, "{$ops['base']}_{$param}_render")) {
                    add_filter("vc_autocomplete_{$ops['base']}_{$param}_render", array($this, "{$ops['base']}_{$param}_render"));
                }
            }
        }


        public function yesshop_recent_products_category_callback($query){
            return $this->get_productCat_callback($query);
        }

        public function yesshop_recent_products_category_render($query){
            return $this->get_productCat_render($query);
        }

        public function yesshop_featured_products_category_callback($query){
            return $this->get_productCat_callback($query);
        }

        public function yesshop_featured_products_category_render($query){
            return $this->get_productCat_render($query);
        }

        public function yesshop_best_selling_products_category_callback($query){
            return $this->get_productCat_callback($query);
        }

        public function yesshop_best_selling_products_category_render($query){
            return $this->get_productCat_render($query);
        }

        public function yesshop_top_rated_products_category_callback($query){
            return $this->get_productCat_callback($query);
        }

        public function yesshop_top_rated_products_category_render($query){
            return $this->get_productCat_render($query);
        }

        public function yesshop_sale_products_category_callback($query){
            return $this->get_productCat_callback($query);
        }

        public function yesshop_sale_products_category_render($query){
            return $this->get_productCat_render($query);
        }

        public function yesshop_product_tags_tags_callback($query)
        {
            return $this->get_term_by_callback($query, 'product_tag', 'slug');
        }

        public function yesshop_product_tags_tags_render($query)
        {
            return $this->get_term_by_render($query, 'product_tag', 'slug');
        }

        public function yesshop_product_cats_cats_callback($query)
        {
            return $this->get_productCat_callback($query);
        }

        public function yesshop_product_cats_cats_render($query)
        {
            return $this->get_productCat_render($query);
        }

        public function yesshop_products_category_category_callback($query) {
            return $this->get_productCat_callback($query);
        }

        public function yesshop_products_category_category_render($query) {
            return $this->get_productCat_render($query);
        }

        public function yesshop_products_category_sect_category_callback($query){
            return $this->get_productCat_callback($query);
        }

        public function yesshop_products_category_sect_category_render($query){
            return $this->get_productCat_render($query);
        }

        public function yesshop_teams_ids_callback($query)
        {
            return $this->get_postType_id_callback($query, 'team');
        }

        public function yesshop_teams_ids_render($query)
        {
            return $this->get_postType_id_render($query, 'team');
        }

        public function yesshop_testimonials_ids_callback($query)
        {
            return $this->get_postType_id_callback($query, 'testimonial');
        }

        public function yesshop_testimonials_ids_render($query)
        {
            return $this->get_postType_id_render($query, 'testimonial');
        }

        public function yesshop_products_cats_tabs_category_callback($query)
        {
            return $this->get_productCat_callback($query);
        }

        public function yesshop_products_cats_tabs_category_render($query)
        {
            return $this->get_productCat_render($query);
        }

        public function yesshop_product_category_icon_cats_cat_callback($query)
        {
            return $this->get_productCat_callback($query);
        }

        public function yesshop_product_category_icon_cats_cat_render($query)
        {
            return $this->get_productCat_render($query);
        }

        public function yesshop_features_id_callback($query)
        {
            return $this->get_postType_id_callback($query, 'feature');
        }

        public function yesshop_features_id_render($query)
        {
            return $this->get_postType_id_render($query, 'feature');
        }

        public function yesshop_products_ids_callback($query)
        {
            return $this->get_postType_id_callback($query, 'product');
        }

        public function yesshop_products_ids_render($query)
        {
            return $this->get_postType_id_render($query, 'product');
        }

        public function yesshop_product_subcaterories_cat_group_slug_callback($query)
        {
            return $this->get_productCat_callback($query);
        }

        public function yesshop_product_subcaterories_cat_group_slug_render($query)
        {
            return $this->get_productCat_render($query);
        }

        public function yesshop_featured_prod_cats_cats_group_slug_callback($query)
        {
            return $this->get_productCat_callback($query);
        }

        public function yesshop_featured_prod_cats_cats_group_slug_render($query)
        {
            return $this->get_productCat_render($query);
        }

        public function yesshop_woo_single_cat_slug_callback($query)
        {
            return $this->get_productCat_callback($query);
        }

        public function yesshop_woo_single_cat_slug_render($query)
        {
            return $this->get_productCat_render($query);
        }

        public function yesshop_woo_cats_cats_group_slug_callback($query)
        {
            return $this->get_productCat_callback($query);
        }

        public function yesshop_woo_cats_cats_group_slug_render($query)
        {
            return $this->get_productCat_render($query);
        }

        public function yesshop_trending_section_products_prod_group_id_callback($query)
        {
            return $this->get_postType_id_callback($query, 'product');
        }

        public function yesshop_trending_section_products_prod_group_id_render($query)
        {
            return $this->get_postType_id_render($query, 'product');
        }

        public function yesshop_portfolio_cats_callback($query)
        {
            return $this->get_term_by_callback($query, 'portfolio_cat', 'slug');
        }

        public function yesshop_portfolio_cats_render($query)
        {
            return $this->get_term_by_render($query, 'portfolio_cat', 'slug');
        }

        public static function getOrderBy($unset = array())
        {
            $orderBy = array(
                '',
                esc_html__('Date', 'omeo') => 'date',
                esc_html__('ID', 'omeo') => 'ID',
                esc_html__('Author', 'omeo') => 'author',
                esc_html__('Title', 'omeo') => 'title',
                esc_html__('Modified', 'omeo') => 'modified',
                esc_html__('Random', 'omeo') => 'rand',
                esc_html__('Comment count', 'omeo') => 'comment_count',
                esc_html__('Menu order', 'omeo') => 'menu_order',
            );
            if (count($unset) > 0) {
                foreach ($orderBy as $key => $val) {
                    if (in_array($val, $unset)) unset($orderBy[$key]);
                }
            }

            return $orderBy;
        }

        public static function getOrder()
        {
            return array(
                '',
                esc_html__('Descending', 'omeo') => 'DESC',
                esc_html__('Ascending', 'omeo') => 'ASC',
            );
        }

        public static function getColors($custom = false)
        {
            $colors = array(
                esc_html__('Blue', 'omeo') => 'blue',
                esc_html__('Turquoise', 'omeo') => 'turquoise',
                esc_html__('Pink', 'omeo') => 'pink',
                esc_html__('Violet', 'omeo') => 'violet',
                esc_html__('Peacoc', 'omeo') => 'peacoc',
                esc_html__('Chino', 'omeo') => 'chino',
                esc_html__('Mulled Wine', 'omeo') => 'mulled_wine',
                esc_html__('Vista Blue', 'omeo') => 'vista_blue',
                esc_html__('Black', 'omeo') => 'black',
                esc_html__('Grey', 'omeo') => 'grey',
                esc_html__('Orange', 'omeo') => 'orange',
                esc_html__('Sky', 'omeo') => 'sky',
                esc_html__('Green', 'omeo') => 'green',
                esc_html__('Juicy pink', 'omeo') => 'juicy_pink',
                esc_html__('Sandy brown', 'omeo') => 'sandy_brown',
                esc_html__('Purple', 'omeo') => 'purple',
                esc_html__('White', 'omeo') => 'white',
                esc_html__('Success', 'omeo') => 'success'
            );

            if ($custom) $colors = array_merge($colors, array(esc_html__('Custom color', 'omeo') => 'custom'));

            return $colors;
        }

        public static function list_taxonomies()
        {
            $tag_taxonomies = array();
            if ('vc_edit_form' === vc_post_param('action') && vc_verify_admin_nonce()) {
                $taxonomies = get_taxonomies();
                if (is_array($taxonomies) && !empty($taxonomies)) {
                    foreach ($taxonomies as $taxonomy) {
                        $tax = get_taxonomy($taxonomy);
                        if ((is_object($tax) && (!$tax->show_tagcloud || empty($tax->labels->name))) || !is_object($tax)) {
                            continue;
                        }
                        $tag_taxonomies[$tax->labels->name] = esc_attr($taxonomy);
                    }
                }
            }

            return $tag_taxonomies;
        }

        public static function getVars($key = '')
        {
            $_vars = array(
                'rf' => '',
                'c1' => 'ThemeYeti - Woo',
                'c2' => 'ThemeYeti',
                'c3' => 'Filters',
                'woo' => array(
                    'columns_txt' => esc_html__('If you use slider, This column number will response respectively with 1200px', 'omeo'),
                    'autocomplete' => esc_html__('Type product name, slug or id.', 'omeo')
                ),
                'css_editor' => array(
                    'type' => 'css_editor',
                    'heading' => esc_html__('Css', 'omeo'),
                    'param_name' => 'css',
                    'group' => esc_html__('Design options', 'omeo'),
                ),
                'el_class' => array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra class name', 'omeo'),
                    'param_name' => 'el_class',
                    'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'omeo'),
                )
            );

            if (strlen($key) > 0)
                return $_vars[$key];
            else return $_vars;
        }

    }

}
