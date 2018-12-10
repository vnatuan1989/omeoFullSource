<?php
$_create_block_uri = add_query_arg(array(
    'post_type' => 'static_block'
), get_admin_url(null, 'post-new.php'));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Footer', 'omeo'),
    'id' => 'footer',
    'icon' => 'fa fa-arrow-circle-down',
    'fields' => array(

        array(
            'id' => 'footer-stblock',
            'type' => 'select',
            'title' => 'Static block',
            'subtitle' => wp_kses_post(sprintf(__("If don't have your choice in this select field, please create a new %sstatic block%s, then come back to select here", 'omeo'), '<a href="' . esc_url($_create_block_uri) . '">', '</a>')),
            'data' => 'posts',
            'args' => array(
                'post_type' => 'static_block',
                'posts_per_page' => -1
            )
        ),
    )
));