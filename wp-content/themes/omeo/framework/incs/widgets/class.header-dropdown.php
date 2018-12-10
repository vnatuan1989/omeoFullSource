<?php
// **********************************************************************// 
// ! Register Yeti Widgets
// **********************************************************************// 

class Yesshop_Header_Dropdown extends Yesshop_Widget
{

    public function __construct()
    {
        $this->widget_cssclass = 'yeti-social';
        $this->widget_description = esc_html__("Build a social network shortcode", 'omeo');
        $this->widget_id = 'yesshop_header_dropdown';
        $this->widget_name = esc_html__('Header Dropdown', 'omeo');

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'omeo'),
            ),
            'shortcode' => array(
                'type' => 'select',
                'std' => 'yesshop_head_top_login',
                'label' => esc_html__('Featured', 'omeo'),
                'options' => array(
                    'yesshop_head_top_login'    => esc_attr__('Header top login', 'omeo'),
                    'yesshop_head_top_cart'     => esc_attr__('Header top cart', 'omeo'),
                    'yesshop_currency_switcher' => esc_attr__('Currency switcher', 'omeo'),
                    'yesshop_multi_language'    => esc_attr__('Language switcher', 'omeo'),
                    'yesshop_social'            => esc_attr__('Social network', 'omeo'),
                ),
            ),
            'datas' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_html__('Datas', 'omeo'),
            ),
            'position' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Position', 'omeo'),
                'options' => array(
                    'left'    => esc_attr__('Left', 'omeo'),
                    'right'    => esc_attr__('Right', 'omeo'),
                    'top'    => esc_attr__('Top', 'omeo'),
                    'bottom'    => esc_attr__('Bottom', 'omeo'),
                ),
            ),
        );
        parent::__construct();
    }

    function widget($args, $instance)
    {
        extract($args);

        ob_start();
        $this->widget_start($args, $instance);

        $shortc_attr = array(
            'popup' => esc_attr($instance['position'])
        );

        switch ($instance['shortcode']) {
            case 'yesshop_currency_switcher':
                if(!empty($instance['datas'])) {
                    $shortc_attr['currency'] = esc_attr($instance['datas']);
                }
                break;
            case 'yesshop_multi_language':
                if(!empty($instance['datas'])) {
                    $shortc_attr['languages'] = esc_attr($instance['datas']);
                }
                break;
            case 'yesshop_social':
                if(!empty($instance['datas'])) {
                    $shortc_attr['items'] = esc_attr($instance['datas']);
                }
                if(!empty($instance['position'])) {
                    $shortc_attr['tt_location'] = esc_attr($instance['position']);
                }
                $shortc_attr['color_hover'] = 1;
                break;
        }

        $shortc = '['.esc_attr($instance['shortcode']);

        foreach ($shortc_attr as $k => $v) {
            $shortc .= ' ' . esc_attr($k) . '="'.esc_attr($v).'"';
        }

        $shortc .= ']';

        echo do_shortcode(wp_kses_post($shortc));

        $this->widget_end($args);
        echo ob_get_clean();
    }
}
