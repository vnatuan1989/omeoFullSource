<?php
/**
 * The template for displaying all single posts
 *
 */

if (class_exists('Yetithemes_Gallery') && function_exists('Yetithemes_Gallery')) :

    get_header();

    ?>
    <div class="content-wrapper gallery-single-content col-sm-24">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();

                $galleries = Yetithemes_Gallery()->get_galleries_data(get_the_ID());

                ?>
                <div <?php post_class("single-post"); ?>>

                    <?php
                    $style = empty($galleries['g_style']) ? '1': $galleries['g_style'];
                    get_template_part('single', 'gallery-' . $style);
                    ?>

                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php get_footer(); endif; ?>