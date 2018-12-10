<?php
/**
 *    Template Name: Albums Grid
 */

if (!class_exists('Yetithemes_Gallery') || !function_exists('Yetithemes_Gallery')) return '';

get_header();

$sidebar_data = Yesshop_Functions()->pages_sidebar_act();
extract($sidebar_data);

$datas = array(
    'show_bcrumb' => $_show_breadcrumb,
);

do_action('yesshop_breadcrumb', $datas);
?>

<div id="container" class="galleries-template">

    <div class="nth-content-main">

        <div class="container">
            <?php if ($_show_title): ?>
                <h1 class="page-title"><?php the_title(); ?></h1>
            <?php endif; ?>
        </div>

        <?php
        $class = array('nth-portfolio-container');
        if (!empty($_album_style)) $class[] = $_album_style;
        ?>

        <div class="nth-portfolios-wrapper">
            <div class="<?php echo esc_attr(implode(' ', $class)) ?>">
                <div class="nth-portfolio-filters-wrap container">
                    <?php Yetithemes_Gallery()->getFilters(); ?>
                </div>

                <div class="nth-fullwidth">
                    <div class="nth-portfolio-content">
                        <?php Yetithemes_Gallery()->getContent(); ?>
                    </div>
                </div>

            </div>

            <div class="container">
                <?php yesshop_paging_nav(); ?>
            </div>

        </div>

    </div>

</div>

<?php get_footer(); ?>
