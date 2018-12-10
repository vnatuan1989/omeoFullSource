<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage YetiThemes
 * @since Yesshop 1.0
 *
 * Template Name: Page Demo
 */

get_header();


$menus = wp_get_nav_menus();

echo '<pre>';
foreach ($menus as $menu) {
    if($menu->name === 'All Departments 2') {

        $menu_items = get_posts(array(
            'post_type' => 'nav_menu_item',
            'posts_per_page'    => -1,
            'post_status'   => 'publish',
            'tax_query'     => array(
                array(
                    'taxonomy'  => 'nav_menu',
                    'field'     => 'id',
                    'terms'     => absint($menu->term_id)
                )
            )
        ));
        print_r($menu_items);
    }
}
echo '</pre>';

get_footer();
