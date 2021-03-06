<?php
/**
 * The Template for displaying all single projects.
 *
 * Override this template by copying it to yourtheme/projects/single-project.php
 *
 * @author        WooThemes
 * @package    Projects/Templates
 * @version     1.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

get_header();

$_main_content_class = apply_filters('yesshop_main_content_class', array('content-wrapper page-content'), null);
?>

    <div id="container" class="container single-post">

        <div id="content" class="site-content row" role="main">

            <div class="yeti-content-main col-sm-24">

                <?php
                /**
                 * projects_before_main_content hook
                 *
                 * @hooked projects_output_content_wrapper - 10 (outputs opening divs for the content)
                 */
                do_action('projects_before_main_content');
                ?>

                <?php while (have_posts()) : the_post(); ?>

                    <div class="post-content">
                        <?php the_content(); ?>
                    </div><!-- .post-content -->

                <?php endwhile; // end of the loop. ?>

                <?php
                /**
                 * projects_after_main_content hook
                 *
                 * @hooked projects_output_content_wrapper_end - 10 (outputs closing divs for the content)
                 */
                do_action('projects_after_main_content');
                ?>

            </div>

        </div>
    </div>


<?php get_footer('projects');