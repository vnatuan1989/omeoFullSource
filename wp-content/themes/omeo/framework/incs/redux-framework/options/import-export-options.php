<?php
$_admin_dummny_url = add_query_arg(array(
    'page' => 'yetithemes-importer',
), get_admin_url('admin.php'));


Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Import / Export', 'omeo'),
    'id' => 'improt_export',
    'desc' => '',
    'icon' => 'el el-refresh',
    'class' => 'color8'
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Theme Options', 'omeo'),
    'id' => 'redux_import_export',
    'icon' => 'fa fa-sliders',
    'subsection' => true,
    'customizer' => false,
    'fields' => array(
        array(
            'id' => 'redux_import_export',
            'type' => 'import_export',
            'full_width' => true,
        )
    ),
));

Redux::setSection($this->opt_name, array(
    'title' => esc_html__('Dummy content', 'omeo'),
    'id' => 'dummy_import_export',
    'icon' => 'fa fa-download',
    'subsection' => true,
    'customizer' => false,
    'fields' => array(
        array(
            'id' => 'dummy_import_link',
            'type' => 'info',
            'style' => 'info',
            'class' => 'yeti-info',
            'title' => esc_attr__('Import Base Demo Content.', 'omeo'),
            'desc' => wp_kses_post(sprintf(__('Please go to <a href="%s" title="Yeti importer">Yeti Extra > Importer</a> to import Base demo data', 'omeo'), add_query_arg(array('page' => 'yetithemes-importer'), admin_url())))
        ),
    ),
));
