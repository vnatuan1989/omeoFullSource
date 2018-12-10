<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    <?php
    wp_head();
    ?>

</head>

<body <?php body_class(); ?>>

<?php do_action('yesshop_before_main_content'); ?>

<div id="body-wrapper" class="o-wrapper">

    <?php do_action('yesshop_header_init'); ?>

    <div class="body-wrapper">

        <?php Yesshop_Functions()->pageSlider() ?>

        <?php do_action('yesshop_breadcrumb'); ?>

        <?php
        $_main_container = apply_filters('yesshop_main_container', 'container');
        ?>

        <div class="<?php echo esc_attr($_main_container)?>">
            <div class="row">