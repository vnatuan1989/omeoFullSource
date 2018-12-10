<?php
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Yesshop_StaticBlock_Widget extends Yesshop_Widget
{

    public function __construct()
    {
        $this->widget_cssclass = 'static_block_widget';
        $this->widget_description = esc_html__("Get Static block content", 'omeo');
        $this->widget_id = 'yesshop_stblock';
        $this->widget_name = esc_html__('Static Blocks', 'omeo');

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
        $blocks = array();
        if (function_exists('Yetithemes_StaticBlock')) {
            $static_blocks = Yetithemes_StaticBlock()->getArgs();
            foreach ($static_blocks as $data) {
                $blocks[$data['slug']] = $data['title'];
            }
        }
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'omeo')
            ),
            'block_id' => array(
                'type' => 'select',
                'std' => '',
                'label' => esc_html__('Static block', 'omeo'),
                'options' => $blocks,
            )
        );
    }

    public function widget($args, $instance)
    {
        extract($args);
        $block_id = $instance['block_id'];

        if (function_exists('Yetithemes_StaticBlock')) {
            $this->widget_start($args, $instance);
            Yetithemes_StaticBlock()->getContentByID($block_id);
            $this->widget_end($args);
        }
    }
}
