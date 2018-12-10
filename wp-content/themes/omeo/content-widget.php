<?php
/**
 * The template used for displaying page content
 *
 */

$_thumb_size = 'yesshop_blog_thumb_widget';
$__post_data = isset($__post_data) ? $__post_data : array(
    'hidden_date' => 0
);
extract($__post_data);

$is_thumb = false;
$_is_excerpt = false;

?>

<li <?php post_class("post-item"); ?>>

    <?php if (has_post_thumbnail() && $is_thumb) : ?>
        <div class="post-thumbnail">
            <a class="nth-thumbnail" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail($_thumb_size, array('class' => 'thumbnail-blog')); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="entry-date">
        <span class="entry-day"><?php echo get_the_date('d') ?></span>
        <span class="entry-month"><?php echo get_the_date('M') ?></span>
    </div>
    <div class="post-content">
        <h3 class="post-title"><a title="<?php the_title(); ?>" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>

        <?php if ($_is_excerpt) : ?><p class="short-content"><?php yesshop_the_excerpt($excerpt_words); ?></p><?php endif; ?>

        <div class="post-meta">
            <a href="<?php echo get_permalink(); ?>" title="<?php esc_attr_e('Read more', 'omeo'); ?>"><?php esc_attr_e('Read more', 'omeo'); ?></a>
        </div>
    </div>

</li>