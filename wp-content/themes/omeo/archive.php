<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_header();

$_main_content_class = apply_filters('yesshop_main_content_class', array('content-wrapper archive-content'), 'blog');

?>

    <div id="container" class="<?php echo esc_attr(implode(' ', $_main_content_class)) ?>">
        <div id="main" class="site-main content" role="main">
            <?php if (have_posts()) : ?>

                <ul class="list-posts row">

                    <?php while (have_posts()): the_post(); ?>

                        <?php get_template_part('content', get_post_format()); ?>

                    <?php endwhile; ?>

                </ul>

            <?php else :

                get_template_part('content', 'none');

            endif; ?>

            <?php yesshop_paging_nav(); ?>

        </div>
    </div>

<?php get_sidebar('blog'); ?>

<?php get_footer(); ?>