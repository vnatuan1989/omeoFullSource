<?php
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Yesshop_ProductCategory_Widget extends Yesshop_Widget
{

    public function __construct()
    {
        $this->widget_cssclass = 'yeti-widgets product-category-widget';
        $this->widget_description = esc_html__("Display a list of your products of a category.", 'omeo');
        $this->widget_id = 'yesshop_product_category';
        $this->widget_name = esc_html__('Product Category', 'omeo');

        parent::__construct();
    }

    public function form($instance)
    {
        $this->init_settings();
        parent::form($instance);
    }

    public function update($new_instance, $old_instance)
    {
        $this->init_settings();
        return parent::update($new_instance, $old_instance);
    }


    public function init_settings()
    {
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
                'max' => 20,
                'std' => 5,
                'label' => esc_html__('Number of products to show', 'omeo')
            ),
            'category' => array(
                'type' => 'select',
                'std' => '',
                'label' => esc_html__('Category', 'omeo'),
                'options' => $this->get_productCat(),
            ),
            'orderby' => array(
                'type' => 'select',
                'std' => 'date',
                'label' => esc_html__('Order by', 'omeo'),
                'options' => $this->getOrderby(),
            ),
            'order' => array(
                'type' => 'select',
                'std' => 'desc',
                'label' => esc_html_x('Order', 'Sorting order', 'omeo'),
                'options' => $this->getOrder(),
            )
        );
    }

    public function widget($args, $instance)
    {
        if ($this->get_cached_widget($args)) return;

        ob_start();
        $this->widget_start($args, $instance);

        echo do_shortcode('[yesshop_products_category columns="1" category="' . esc_attr($instance['category']) . '" per_page="' . absint($instance['number']) . '" orderby="' . esc_attr($instance['orderby']) . '" order="' . esc_attr($instance['order']) . '" as_widget="1"]');

        $this->widget_end($args);

        echo $this->cache_widget($args, ob_get_clean());
    }
}
