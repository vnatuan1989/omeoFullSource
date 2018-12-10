<?php
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Yesshop_RecentPosts_Widget extends Yesshop_Widget
{

    public function __construct()
    {
        $this->widget_cssclass = 'yeti-widgets recent-posts-widget';
        $this->widget_description = esc_html__("Your site's most recent Posts.", 'omeo');
        $this->widget_id = 'yesshop_recent_posts';
        $this->widget_name = esc_html__('Recent Posts', 'omeo');

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => esc_html__('Recent posts', 'omeo'),
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
            ),
            'hidden_date' => array(
                'type' => 'checkbox',
                'std' => '0',
                'label' => esc_html__('Hidden posted time.', 'omeo'),
            )

        );

        parent::__construct();
    }

    public function widget($args, $instance)
    {
        if ($this->get_cached_widget($args)) return;

        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $excerpt_words = isset($instance['excerpt_words']) ? absint($instance['excerpt_words']) : 15;
        $hidden_date = isset($instance['hidden_date']) ? esc_attr($instance['hidden_date']) : 0;

        ob_start();
        $this->widget_start($args, $instance);

        echo do_shortcode('[yesshop_recent_posts limit="' . absint($number) . '" excerpt_words="' . esc_attr($excerpt_words) . '" as_widget="1" hidden_date="' . $hidden_date . '"]');

        $this->widget_end($args);

        echo $this->cache_widget($args, ob_get_clean());
    }
}
