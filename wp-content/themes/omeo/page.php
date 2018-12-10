<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 */

get_header();

$_main_content_class = apply_filters('yesshop_main_content_class', array('content-wrapper page-content'), null);

?>
    <div id="container" class="<?php echo esc_attr(implode(' ', $_main_content_class)) ?>">
        <div id="main" class="site-main content" role="main">

            <?php
            while (have_posts()) : the_post();
                get_template_part('content', 'page');

                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            endwhile;
            ?>
        </div>
    </div><!--.content-wrapper-->
<?php

get_sidebar();

get_footer();
