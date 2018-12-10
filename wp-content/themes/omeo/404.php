<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

get_header();

?>

    <div id="container" class="content-wrapper page-404 container">
        <div id="main" class="site-main content" role="main">

            <?php if($_404_id = Yesshop_Functions()->getThemeData('404page-stblock') && absint($_404_id) > 0): ?>
                <?php Yesshop_Functions()->get_404_content()?>
            <?php else : ?>
                <div class="row">
                    <div class="col-sm-24 text-center">
                        <figure class="figure-404"><?php Yesshop_Functions()->get_404_img();?></figure>
                        <p class="heading-404-info"><?php esc_html_e('The link you followed probably broken, or the page has been removed.', 'omeo')?></p>
                        <p class="return-home"><?php printf('%sReturn to homepage%s', '<a href="'.esc_url(get_home_url()).'" title="'.esc_attr__('Return to homepage', 'omeo').'">', '</a>')?></p>
                    </div>
                </div>
            <?php endif;?>

            
            <?php Yesshop_Functions()->search_form('non-cat'); ?>
            

        </div>
    </div>

<?php get_footer(); ?>