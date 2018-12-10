<?php
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Yesshop_WoocommerceProducts_Widget extends Yesshop_Widget
{

    public function __construct()
    {
        $this->widget_cssclass = 'yeti-widgets woo-products-widget';
        $this->widget_description = esc_html__("Display a list of your products on your site.", 'omeo');
        $this->widget_id = 'yesshop_woo_products';
        $this->widget_name = esc_html__('WooCommerce Products', 'omeo');

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => esc_html__('Products', 'omeo'),
                'label' => esc_html__('Title', 'omeo')
            ),

            'number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 5,
                'label' => esc_html__('Number of products to show', 'omeo')
            ),
            'show' => array(
                'type' => 'select',
                'std' => '',
                'label' => esc_html__('Show', 'omeo'),
                'options' => array(
                    '' => esc_html__('All Products', 'omeo'),
                    'featured' => esc_html__('Featured Products', 'omeo'),
                    'onsale' => esc_html__('On-sale Products', 'omeo'),
                )
            ),
            'orderby' => array(
                'type' => 'select',
                'std' => 'date',
                'label' => esc_html__('Order by', 'omeo'),
                'options' => array(
                    'date' => esc_html__('Date', 'omeo'),
                    'price' => esc_html__('Price', 'omeo'),
                    'rand' => esc_html__('Random', 'omeo'),
                    'sales' => esc_html__('Sales', 'omeo'),
                )
            ),
            'order' => array(
                'type' => 'select',
                'std' => 'desc',
                'label' => esc_attr_x('Order', 'Sorting order', 'omeo'),
                'options' => array(
                    'asc' => esc_html__('ASC', 'omeo'),
                    'desc' => esc_html__('DESC', 'omeo'),
                )
            ),
            'num_order' => array(
                'type' => 'checkbox',
                'std' => 0,
                'label' => esc_html__('Show products numberical', 'omeo')
            ),
            'hide_free' => array(
                'type' => 'checkbox',
                'std' => 0,
                'label' => esc_html__('Hide free products', 'omeo')
            ),
            'show_hidden' => array(
                'type' => 'checkbox',
                'std' => 0,
                'label' => esc_html__('Show hidden products', 'omeo')
            )
        );

        parent::__construct();
    }

    public function widget($args, $instance)
    {
        if ($this->get_cached_widget($args)) return;

        ob_start();
        $this->widget_start($args, $instance);

        if (empty($instance['show_hidden'])) $instance['show_hidden'] = '0';
        if (empty($instance['num_order'])) $instance['num_order'] = '0';
        if (empty($instance['hide_free'])) $instance['hide_free'] = '0';
        if (empty($instance['show'])) $instance['show'] = '';

        switch ($instance['show']) {
            case 'featured':
                echo do_shortcode('[yesshop_featured_products columns="1" per_page="' . absint($instance['number']) . '" orderby="' . esc_attr($instance['orderby']) . '" order="' . esc_attr($instance['order']) . '" as_widget="1" hide_free="' . absint($instance['hide_free']) . '" show_hidden="' . absint($instance['show_hidden']) . '" num_order="'.absint($instance['num_order']).'"]');
                break;
            case 'onsale':
                echo do_shortcode('[yesshop_sale_products columns="1" per_page="' . absint($instance['number']) . '" orderby="' . esc_attr($instance['orderby']) . '" order="' . esc_attr($instance['order']) . '" as_widget="1" hide_free="' . absint($instance['hide_free']) . '" show_hidden="' . absint($instance['show_hidden']) . '" num_order="'.absint($instance['num_order']).'"]');
                break;
            default:
                echo do_shortcode('[yesshop_recent_products columns="1" per_page="' . absint($instance['number']) . '" orderby="' . esc_attr($instance['orderby']) . '" order="' . esc_attr($instance['order']) . '" as_widget="1" hide_free="' . absint($instance['hide_free']) . '" show_hidden="' . absint($instance['show_hidden']) . '" num_order="'.absint($instance['num_order']).'"]');
        }

        $this->widget_end($args);

        echo $this->cache_widget($args, ob_get_clean());
    }
}
