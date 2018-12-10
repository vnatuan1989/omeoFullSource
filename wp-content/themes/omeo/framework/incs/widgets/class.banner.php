<?php
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Yesshop_Banner_Widget extends Yesshop_Widget
{

    public function __construct()
    {
        $this->widget_cssclass = 'nth-banner';
        $this->widget_description = esc_html__("Build a banner shortcode", 'omeo');
        $this->widget_id = 'yesshop_banner';
        $this->widget_name = esc_html__('Banner', 'omeo');

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'omeo'),
            ),
            'bg_image' => array(
                'type' => 'attach_image',
                'std' => '',
                'label' => esc_html__('Background image', 'omeo'),
            ),
            'bn_content' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_html__('Banner content', 'omeo'),
            ),
        );
        parent::__construct();
    }

    function widget($args, $instance)
    {
        extract($args);

        ob_start();
        $this->widget_start($args, $instance);

        $attrs = '';
        if (isset($instance['bg_image']) && strlen(trim($instance['bg_image'])) > 0) {
            $attrs .= ' bg_image="' . esc_attr($instance['bg_image']) . '"';
        }

        echo do_shortcode("[yesshop_banner{$attrs}]{$instance['bn_content']}[/yesshop_banner]");

        $this->widget_end($args);
        echo ob_get_clean();
    }
}
