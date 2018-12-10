<?php
/**
 *    Template Name: Albums Grid
 */

if (!class_exists('Yetithemes_Gallery') || !function_exists('Yetithemes_Gallery')) return '';

get_header();

if (class_exists('Yetithemes_Portfolio_Front')):
    ?>

    <div id="container" class="content-wrapper portfolio-template">
        <div id="main" class="site-main content" role="main">

            <?php echo do_shortcode(); ?>

        </div>
    </div><!--.content-wrapper-->

<?php endif; ?>

<?php get_footer(); ?>
