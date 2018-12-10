<?php
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Yesshop_Brand_Single_Widget extends Yesshop_Widget
{

    public function __construct()
    {
        $this->widget_cssclass = 'brand_single_widget';
        $this->widget_description = esc_html__("Get Woocommerce single brand attribute", 'omeo');
        $this->widget_id = 'yesshop_brand_single';
        $this->widget_name = esc_html__('Woocommerce Brand - Single', 'omeo');

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
                'std' => 'Sold by',
                'label' => esc_html__('Title', 'omeo')
            ),
        );
    }

    public function widget($args, $instance)
    {
        extract($args);

        if (class_exists('Yesshop_WooAttrBrand')) {
            global $product;
            $attributes = $product->get_attributes();
            $terms = array();
            foreach ($attributes as $attribute_name => $options) {
                if ($attribute_name === 'pa_brand' && is_array($options) && taxonomy_exists($attribute_name)) {
                    $terms = wc_get_product_terms($product->get_id(), $attribute_name, array('fields' => 'all'));
                    break;
                } else continue;
            }
            if (!empty($terms[0])) {
                $this->widget_start($args, $instance);

                $thumbnail_id = get_woocommerce_term_meta($terms[0]->term_id, '_pa_brand_data', true);

                if ($thumbnail_id) {
                    echo '<div class="text-center">';
                    echo wp_get_attachment_image($thumbnail_id, 'full');
                    echo '</div>';
                }

                if (!empty($terms[0]->description)) {
                    echo '<p>' . esc_html($terms[0]->description) . '</p>';
                }

                $this->widget_end($args);
            }
        }
    }
}
