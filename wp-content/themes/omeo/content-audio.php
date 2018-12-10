<?php
/**
 * The template used for displaying page content
 */
if (!isset($__post_datas)) {
    $__post_datas = array('is_shortcode' => 0);
} else {
    $__post_datas['is_shortcode'] = 1;
}

$post_options = Yesshop_Functions()->get_post_options(get_the_ID());

$_class = array('post-item');

Yesshop_Functions()->archive_item_action($__post_datas, $_class);

$_use_comment = $_use_author = $_use_tags = true;

?>

<li <?php post_class(implode(' ', $_class)); ?>>
    <div class="post-item-content">

        <?php if (isset($__post_datas['s_thumb']) && absint($__post_datas['s_thumb']) === 1): ?>

            <?php if (has_post_thumbnail()): ?>
                <div class="post-thumbnail">
                    <a class="nth-thumbnail" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail($__post_datas['thumb_size'], array('class' => 'thumbnail-blog')); //blog_thumb ?>
                    </a>
                    <div class="entry-date">
                        <span class="entry-day"><?php echo get_the_date('d') ?></span>
                        <span class="entry-month"><?php echo get_the_date('M') ?></span>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <?php if (isset($post_options['audio_embed'])): ?>

                <div class="post-thumbnail">
                    <?php echo stripslashes(htmlspecialchars_decode($post_options['audio_embed'])); ?>
                    <div class="entry-date">
                        <span class="entry-day"><?php echo get_the_date('d') ?></span>
                        <span class="entry-month"><?php echo get_the_date('M') ?></span>
                    </div>
                </div>

            <?php endif; ?>

        <?php endif; ?>

        <div class="post-content">

            <?php if (is_sticky()): ?>

                <span class="nth-post-icon fa fa-thumb-tack"></span>

            <?php endif; ?>

            <div class="post-heading">
                <ul class="list-inline">
                    <?php if ($_use_author): ?>
                        <li>
                            <div class="author"><?php esc_html_e('By', 'omeo'); ?> <?php the_author_posts_link(); ?></div>
                        </li>
                    <?php endif; ?>
                    <?php if (!isset($__post_datas['s_cats']) || absint($__post_datas['s_cats']) === 1): ?>
                        <li>
                            <div class="categories"><?php echo get_the_category_list(', '); ?></div>
                        </li>
                    <?php endif; ?>
                </ul>
                <h3 class="post-title"><a class="post-title-a" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php edit_post_link('<i class="fa fa-pencil"></i>', '<span class="wd-edit-link hidden-phone">', '</span>'); ?>
            </div>

            <?php if (!isset($__post_datas['s_excerpt']) || absint($__post_datas['s_excerpt']) === 1): ?>
                <div class="short-content"><?php echo get_the_excerpt(); ?></div>
            <?php endif; ?>

            <div class="post-footer">

                <a class="post-title-a" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'omeo');?></a>

            </div>

        </div>
    </div>
</li>