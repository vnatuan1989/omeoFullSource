<?php

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Header', 'omeo'),
    'id' => 'header',
    'desc' => '',
    'icon' => 'fa fa-arrow-circle-up',
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('General', 'omeo'),
    'id' => 'header-general',
    'subsection' => true,
    'fields' => array()
));

