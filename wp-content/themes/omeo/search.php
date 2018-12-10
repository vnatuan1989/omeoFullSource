<?php
/**
 * The template for displaying search results pages
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_header();

$_main_content_class = apply_filters('yesshop_main_content_class', array('content-wrapper page-content'), null);
?>

<div class="search-page search-page-wapper">
    <div id="container" class="<?php echo esc_attr(implode(' ', $_main_content_class)) ?>">
        <div id="main" class="site-main content" role="main">

            <?php if (have_posts()) :
                $_blog_type = Yesshop_Functions()->getThemeData('blog-type');
                $_list_post_class = ' post-style-' . $_blog_type;
                $isotope_data = array();
                if ($_blog_type === 'masonry') {
                    $_list_post_class .= ' yeti-isotope-act';
                    $isotope_data = array(
                        'itemSelector' => ".post-item",
                        'layoutMode' => "masonry"
                    );
                }
                ?>

                <ul class="list-posts row<?php echo esc_attr($_list_post_class) ?>"
                    data-params="<?php echo esc_attr(json_encode($isotope_data)) ?>">
                    <?php
                    while (have_posts()): the_post();
                        get_template_part('content', get_post_format());
                    endwhile;
                    ?>
                </ul>

                <?php yesshop_paging_nav(); ?>

            <?php else :
                get_template_part('content', 'none');

            endif; ?>

        </div><!-- .site-main -->
    </div><!-- .content-area -->

    <?php get_sidebar('blog'); ?>
</div>

<?php get_footer(); ?>
