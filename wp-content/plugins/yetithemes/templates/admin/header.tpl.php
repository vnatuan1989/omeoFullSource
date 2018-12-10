<?php
$_available_version = Yetithemes_Envato_Api()->checkUpdate();

$header_tab_args = array(
    'yetithemes' => array(
        'title' => __("About", "yetithemes"),
        'icon' => 'fa fa-info-circle',
        'class' => 'color1'
    ),
    'yetithemes-support' => array(
        'title' => __("Support", "yetithemes"),
        'icon' => 'fa fa-life-ring',
        'class' => 'color2'
    ),
    'yetithemes-features' => array(
        'title' => __("Features", "yetithemes"),
        'icon' => 'fa fa-toggle-on',
        'class' => 'color2'
    ),
    'yetithemes-importer' => array(
        'title' => __("Importer", "yetithemes"),
        'icon' => 'fa fa-cloud-download',
        'class' => 'color3'
    ),
    'yetithemes-items' => array(
        'title' => __("Our Items", "yetithemes"),
        'icon' => 'fa fa-list',
        'class' => 'color4'
    ),
    'yetithemes-sys' => array(
        'title' => __("System Status", "yetithemes"),
        'icon' => 'fa fa-cogs',
        'class' => 'color5'
    ),
);

if ($_available_version) {
    $header_tab_args['yetithemes-update'] = array(
        'title' => __("Available Update", "yetithemes"),
        'icon' => 'fa fa-download',
        'class' => 'color6'
    );
}

?>
<h1><?php printf(__("Welcome to %s!", "yetithemes"), $theme_info->get('Name')); ?></h1>

<div class="about-text">
    <?php echo $theme_info->get('Description') ?>
</div>
<div class="wp-badge yeti-page-logo">
    <span class="yesshop-version"><?php echo __("Version", "yetithemes"); ?><?php echo $theme_info->get('Version'); ?></span>
</div>

<h2 class="nav-tab-wrapper">
    <?php
    //nav-tab-active
    foreach ($header_tab_args as $slug => $tt) {
        $tab_class = array('nav-tab');
        if (!empty($tt['class'])) $tab_class[] = esc_attr($tt['class']);
        $tab_class[] = $slug;
        if (strcmp($slug, trim($_GET['page'])) === 0) {
            $tab_class[] = 'nav-tab-active';
        }
        if (!empty($tt['title'])) {
            $title = $tt['title'];
            printf('<a href="%s" class="%s"><i class="%s"></i> %s</a>', admin_url('admin.php?page=' . $slug), esc_attr(implode(' ', $tab_class)), esc_attr($tt['icon']), $title);
        }
    }
    ?>
</h2>