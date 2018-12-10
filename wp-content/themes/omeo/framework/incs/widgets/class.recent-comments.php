<?php
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Yesshop_RecentComments_Widget extends Yesshop_Widget
{

    public function __construct()
    {
        $this->widget_cssclass = 'yeti-widgets recent-comments-widget';
        $this->widget_description = esc_html__("Your site's most recent comments.", 'omeo');
        $this->widget_id = 'yesshop_recent_comments';
        $this->widget_name = esc_html__('Recent Comments', 'omeo');

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => esc_html__('Recent Comments', 'omeo'),
                'label' => esc_html__('Title', 'omeo')
            ),
            'number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => 150,
                'std' => 5,
                'label' => esc_html__('Number of post to show', 'omeo')
            ),

            'excerpt_words' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => 255,
                'std' => 15,
                'label' => esc_html__('Excerpt words', 'omeo')
            )
        );

        parent::__construct();
    }

    public function widget($args, $instance)
    {
        if ($this->get_cached_widget($args)) return;

        $instance['number'] = isset($instance['number']) ? $instance['number'] : 5;
        $instance['excerpt_words'] = isset($instance['excerpt_words']) ? $instance['excerpt_words'] : 15;

        ob_start();

        $this->widget_start($args, $instance);

        echo do_shortcode('[yesshop_recent_comments limit="' . absint($instance['number']) . '" excerpt_words="' . esc_attr($instance['excerpt_words']) . '" as_widget="1"]');

        $this->widget_end($args);

        echo $this->cache_widget($args, ob_get_clean());
    }
}
