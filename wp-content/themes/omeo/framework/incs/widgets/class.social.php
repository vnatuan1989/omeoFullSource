<?php
// **********************************************************************// 
// ! Register Yeti Widgets
// **********************************************************************// 

class Yesshop_Social_Widget extends Yesshop_Widget
{

    public function __construct()
    {
        $this->widget_cssclass = 'yeti-social';
        $this->widget_description = esc_html__("Build a social network shortcode", 'omeo');
        $this->widget_id = 'yesshop_social';
        $this->widget_name = esc_html__('Social Network', 'omeo');

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'omeo'),
            ),
            'social_items' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_html__('Datas', 'omeo'),
            ),
        );
        parent::__construct();
    }

    function widget($args, $instance)
    {
        extract($args);

        ob_start();
        $this->widget_start($args, $instance);

        echo do_shortcode('[yesshop_social items="' . esc_attr($instance['social_items']) . '" tt_location="bottom" color_hover="1"]');

        $this->widget_end($args);
        echo ob_get_clean();
    }
}
