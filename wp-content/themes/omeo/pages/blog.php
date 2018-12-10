<?php
/**
 *    Template Name: Blog default
 */
get_header();

$_main_content_class = apply_filters('yesshop_main_content_class', array('content-wrapper page-content'), null);
?>

    <div id="container" class="<?php echo esc_attr(implode(' ', $_main_content_class)) ?>">
        <div id="main" class="site-main content" role="main">

            <?php if ($_show_title): ?>
                <h1 class="page-title"><?php the_title(); ?></h1>
            <?php endif; ?>

            <?php
            query_posts('post_type=post' . '&paged=' . get_query_var('paged'));
            if (have_posts()) :
                ?>
                <ul class="list-posts row">
                <?php
                while (have_posts()): the_post();
                    get_template_part('content', get_post_format());
                endwhile;
                ?></ul><?php
            endif;
            ?>

            <?php
            yesshop_paging_nav();
            wp_reset_query();
            ?>

        </div>
    </div>

<?php

get_sidebar();

get_footer(); ?>