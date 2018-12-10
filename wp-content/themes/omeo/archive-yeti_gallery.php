<?php
/**
 *    Template Name: Albums Grid
 */

if (!class_exists('Yetithemes_Gallery') || !function_exists('Yetithemes_Gallery')) return '';

get_header();

?>


<div id="container" class="content-wrapper galleries-template">
    <div id="main" class="site-main content" role="main">

        <div class="yeti-galleries-wrap">
            <div class="galleries-filters-wrap container">
                <?php Yetithemes_Gallery()->getFilters(); ?>
            </div>

            <div class="galleries-content">
                <?php Yetithemes_Gallery()->getContent(); ?>
            </div>

        </div>

        <div class="container">
            <?php Yesshop_Functions()->paging_nav(); ?>
        </div>

    </div>
</div><!--.content-wrapper-->

<?php get_footer(); ?>
