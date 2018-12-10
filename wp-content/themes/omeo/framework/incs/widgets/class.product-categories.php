<?php
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Yesshop_ProductCategories_Widget extends Yesshop_Widget
{

    /**
     * Category ancestors.
     *
     * @var array
     */
    public $cat_ancestors;

    /** widget style widget */
    public $widget_cssclass;

    /**
     * Current Category.
     *
     * @var bool
     */
    public $current_cat;

    public function __construct()
    {
        $this->widget_cssclass = 'widget yeti-widgets widget_product_categories';
        $this->widget_description = esc_html__("Display a list of your products of a category.", 'omeo');
        $this->widget_id = 'yesshop_product_categories';
        $this->widget_name = esc_html__('Product Categories', 'omeo');
        $this->init_settings();

        parent::__construct();
    }

    public function init_settings()
    {
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => esc_attr__('Product Categories', 'omeo'),
                'label' => esc_attr__('Title', 'omeo')
            ),
            'style' => array(
                'type' => 'select',
                'std' => 'style-1',
                'label' => esc_attr__('Choose Style', 'omeo'),
                'options' => array(
                    'style-1' => esc_attr__('Style 1', 'omeo'),
                    'style-2' => esc_attr__('Style 2', 'omeo')
                )
            ),
            'orderby' => array(
                'type' => 'select',
                'std' => 'name',
                'label' => esc_attr__('Order by', 'omeo'),
                'options' => array(
                    'order' => esc_attr__('Category Order', 'omeo'),
                    'name' => esc_attr__('Name', 'omeo')
                )
            ),
            'dropdown' => array(
                'type' => 'checkbox',
                'std' => 0,
                'label' => esc_attr__('Show as dropdown', 'omeo')
            ),
            'count' => array(
                'type' => 'checkbox',
                'std' => 0,
                'label' => esc_attr__('Show product counts', 'omeo')
            ),
            'hierarchical' => array(
                'type' => 'checkbox',
                'std' => 1,
                'label' => esc_attr__('Show hierarchy', 'omeo')
            ),
            'show_children_only' => array(
                'type' => 'checkbox',
                'std' => 0,
                'label' => esc_attr__('Only show children of the current category', 'omeo')
            ),
            'hide_empty' => array(
                'type' => 'checkbox',
                'std' => 0,
                'label' => esc_attr__('Hide empty categories', 'omeo')
            )
        );
    }

    protected function categories_Select($args = array())
    {
        global $wp_query;

        $current_product_cat = isset($wp_query->query_vars['product_cat']) ? $wp_query->query_vars['product_cat'] : '';
        $defaults = array(
            'pad_counts' => 1,
            'show_count' => 1,
            'hierarchical' => 1,
            'hide_empty' => 1,
            'show_uncategorized' => 1,
            'orderby' => 'name',
            'selected' => $current_product_cat,
            'menu_order' => false
        );

        $args = wp_parse_args($args, $defaults);

        if ($args['orderby'] == 'order') {
            $args['menu_order'] = 'asc';
            $args['orderby'] = 'name';
        }

        $terms = get_terms('product_cat', apply_filters('wc_product_dropdown_categories_get_terms_args', $args));

        if (empty($terms)) {
            return;
        }

        if (empty($current_product_cat)) {
            $_curr_text = esc_attr__('Select a category', 'omeo');
        } else {
            $_curr_text = esc_attr__('Select a category', 'omeo');
            foreach ($terms as $term) {
                if ($term->slug === $current_product_cat) {
                    $_curr_text = $term->name;
                }
            }
        }

        ?>

        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="true">
                <span class="dropdown-text"><?php echo esc_html($_curr_text); ?></span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                <?php foreach ($terms as $term): ?>
                    <li>
                        <a href="<?php echo esc_url(get_term_link($term->term_id)) ?>"><?php echo esc_html($term->name) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }

    public function widget($args, $instance)
    {
        global $wp_query, $post;

        $count = isset($instance['count']) ? $instance['count'] : $this->settings['count']['std'];
        $hierarchical = isset($instance['hierarchical']) ? $instance['hierarchical'] : $this->settings['hierarchical']['std'];
        $show_children_only = isset($instance['show_children_only']) ? $instance['show_children_only'] : $this->settings['show_children_only']['std'];
        $dropdown = isset($instance['dropdown']) ? $instance['dropdown'] : $this->settings['dropdown']['std'];
        $orderby = isset($instance['orderby']) ? $instance['orderby'] : $this->settings['orderby']['std'];
        $hide_empty = isset($instance['hide_empty']) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];
        $style = isset($instance['style']) ? $instance['style'] : $this->settings['style']['std'];
        $dropdown_args = array('hide_empty' => $hide_empty);
        $list_args = array('show_count' => $count, 'hierarchical' => $hierarchical, 'taxonomy' => 'product_cat', 'hide_empty' => $hide_empty);

        // Widget Style
        if ($style == 'style-2') {
            $custom_class = 'widget yeti-widgets widget_product_categories style-2';
        } else {
            $custom_class = 'widget yeti-widgets widget_product_categories style-1';
        }
        $args['before_widget'] = '<li id="'. $args['widget_id'] .'" class="' . $custom_class . '" >';
        $this->widget_options['classname'].= ' style-2';

        // Menu Order
        $list_args['menu_order'] = false;
        if ($orderby == 'order') {
            $list_args['menu_order'] = 'asc';
        } else {
            $list_args['orderby'] = 'title';
        }

        // Setup Current Category
        $this->current_cat = false;
        $this->cat_ancestors = array();

        if (is_tax('product_cat')) {

            $this->current_cat = $wp_query->queried_object;
            $this->cat_ancestors = get_ancestors($this->current_cat->term_id, 'product_cat');

        } elseif (is_singular('product')) {

            $product_category = wc_get_product_terms($post->ID, 'product_cat', apply_filters('woocommerce_product_categories_widget_product_terms_args', array('orderby' => 'parent')));

            if (!empty($product_category)) {
                $this->current_cat = end($product_category);
                $this->cat_ancestors = get_ancestors($this->current_cat->term_id, 'product_cat');
            }

        }

        // Show Siblings and Children Only
        if ($show_children_only && $this->current_cat) {

            // Top level is needed
            $top_level = get_terms(
                'product_cat',
                array(
                    'fields' => 'ids',
                    'parent' => 0,
                    'hierarchical' => true,
                    'hide_empty' => false
                )
            );

            // Direct children are wanted
            $direct_children = get_terms(
                'product_cat',
                array(
                    'fields' => 'ids',
                    'parent' => $this->current_cat->term_id,
                    'hierarchical' => true,
                    'hide_empty' => false
                )
            );

            // Gather siblings of ancestors
            $siblings = array();
            if ($this->cat_ancestors) {
                foreach ($this->cat_ancestors as $ancestor) {
                    $ancestor_siblings = get_terms(
                        'product_cat',
                        array(
                            'fields' => 'ids',
                            'parent' => $ancestor,
                            'hierarchical' => false,
                            'hide_empty' => false
                        )
                    );
                    $siblings = array_merge($siblings, $ancestor_siblings);
                }
            }

            if ($hierarchical) {
                $include = array_merge($top_level, $this->cat_ancestors, $siblings, $direct_children, array($this->current_cat->term_id));
            } else {
                $include = array_merge($direct_children);
            }

            $dropdown_args['include'] = implode(',', $include);
            $list_args['include'] = implode(',', $include);

            if (empty($include)) {
                return;
            }

        } elseif ($show_children_only) {
            $dropdown_args['depth'] = 1;
            $dropdown_args['child_of'] = 0;
            $dropdown_args['hierarchical'] = 1;
            $list_args['depth'] = 1;
            $list_args['child_of'] = 0;
            $list_args['hierarchical'] = 1;
        }

        $this->widget_start($args, $instance);

        // Dropdown
        if ($dropdown) {
            $dropdown_defaults = array(
                'show_count' => $count,
                'hierarchical' => $hierarchical,
                'show_uncategorized' => 0,
                'orderby' => $orderby,
                'selected' => $this->current_cat ? $this->current_cat->slug : ''
            );
            $dropdown_args = wp_parse_args($dropdown_args, $dropdown_defaults);

            $this->categories_Select($dropdown_args);

            // List
        } else {

            include_once(dirname(dirname(__FILE__)). '/class.woo_product_cat_walker.php');

            $list_args['walker'] = new Yeti_Product_Cat_Walker;
            $list_args['title_li'] = '';
            $list_args['pad_counts'] = 1;
            $list_args['show_option_none'] = esc_attr__('No product categories exist.', 'omeo');
            $list_args['current_category'] = ($this->current_cat) ? $this->current_cat->term_id : '';
            $list_args['current_category_ancestors'] = $this->cat_ancestors;

            echo '<ul class="product-categories">';

            wp_list_categories(apply_filters('woocommerce_product_categories_widget_args', $list_args));

            echo '</ul>';
        }

        $this->widget_end($args);
    }
}
