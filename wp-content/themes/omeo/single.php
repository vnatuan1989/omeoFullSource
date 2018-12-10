<?php
/**
 * The template for displaying all single posts
 *
 */

get_header();

$_main_content_class = apply_filters('yesshop_main_content_class', array('content-wrapper single-content'), 'blog');

?>

    <div class="<?php echo esc_attr(implode(' ', $_main_content_class)); ?>">

        <div class="content-inner">

            <?php if (have_posts()): ?>
            <?php while (have_posts()) :
            the_post(); ?>

            <div <?php post_class("single-post"); ?>>

                <?php
                switch (get_post_format()) {

                    case "video":
                        $post_options = Yesshop_Functions()->getOptions('post_options');
                        if (isset($post_options['source_type'])):
                            if (strcmp(trim($post_options['source_type']), 'online') == 0):?>
                                <div class="post-thumbnail post-video">
                                    <?php Yesshop_Functions()->video_player(array('url' => trim($post_options['online_url']))); ?>
                                </div>
                            <?php else: ?>
                                <div class="post-thumbnail post-video">
                                    <?php
                                    $local_args = array();
                                    if (isset($post_options['mp4_url'])) $local_args['mp4'] = trim($post_options['mp4_url']);
                                    if (isset($post_options['ogg_url'])) $local_args['ogg'] = trim($post_options['ogg_url']);
                                    if (isset($post_options['webm_url'])) $local_args['webm'] = trim($post_options['webm_url']);
                                    Yesshop_Functions()->video_local_player($local_args);
                                    ?>
                                </div>
                                <?php
                            endif;
                        endif;
                        break;
                    case "audio":
                        $post_data = Yesshop_Functions()->getOptions('post_options');

                        if (isset($post_data['audio_embed']) && strlen($post_data['audio_embed']) > 0): ?>
                            <div class="post-thumbnail post-audio">
                                <?php echo stripslashes(htmlspecialchars_decode($post_data['audio_embed'])); ?>
                            </div>
                        <?php endif;
                        break;
                    default:
                        $post_data = Yesshop_Functions()->getOptions('post_options');
                        if (!empty($post_data['post_shortcode'])) : ?>
                            <div class="post-thumbnail">
                                <?php echo do_shortcode(stripslashes(htmlspecialchars_decode($post_data['post_shortcode']))); ?>
                            </div>
                        <?php elseif (has_post_thumbnail()): ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('full', array('class' => 'post-thumbnail')); ?>
								<div class="entry-date">
									<span class="entry-day"><?php echo get_the_date('d') ?></span>
									<span class="entry-month"><?php echo get_the_date('M') ?></span>
								</div>
                            </div>
                        <?php endif;
                }
                ?>

                <div class="post-heading">
                    <?php edit_post_link(esc_html__('Edit', 'omeo'), '<span class="nth-edit-link hidden-phone">', '</span>'); ?>

                    <div class="post-meta">
                        <div class="author"><?php esc_html_e('By', 'omeo'); ?><?php the_author_posts_link(); ?></div>
                        <div class="categories"><?php echo get_the_category_list(', '); ?></div>
                    </div>
                </div>

                <div class="post-content">
                    <?php the_content(); ?>

                    <?php
                    wp_link_pages( array(
                        'before'      => '<div class="page-numbers">' . esc_attr__( 'Pages:', 'omeo' ),
                        'after'       => '</div>',
                        'link_before' => '<span class="page-number">',
                        'link_after'  => '</span>',
                    ) );
                    ?>
                </div><!-- .post-content -->

                <div class="post-meta-bottom">

                    <?php if (is_object_in_taxonomy(get_post_type(), 'post_tag')) : ?>
                        <?php $tags_list = get_the_tag_list('', ', ', ''); ?>
                        <?php if ($tags_list): ?>
                            <div class="tags">
                                <?php printf(wp_kses_post(__('<strong class="%1$s">Tags:</strong> %2$s', 'omeo')), 'post-tags tag-links', $tags_list); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php do_action('yesshop_single_post_meta_bottom'); ?>
                </div>

            </div><!-- .post class -->

            <?php
            $author_name = get_the_author_posts_link();
            $author_meta = get_the_author_meta('description');

            if(!empty($author_name) && !empty($author_meta)): ?>

                <div class="author-info">
                    <div class="author-inner">
                        <div id="author-avatar" class="author-avatar">
                            <?php echo get_avatar(get_the_author_meta('user_email'), 120, '', esc_html__('avatar image', 'omeo')); ?>
                        </div>
                        <div class="author-desc">
                            <h3 class="author-detail"><?php the_author_posts_link(); ?></h3>
                            <p><?php the_author_meta('description'); ?></p>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <?php get_template_part('related-posts'); ?>

        </div>

        <?php comments_template('', true); ?>

        <div class="navi">
            <div class="navi-next"><?php next_post_link('%link');?></div>
            <div class="navi-prev"><?php previous_post_link('%link'); ?></div>
        </div>

        <?php endwhile; ?>
        <?php endif; ?>

    </div><!-- .nth-content-main -->

<?php
get_sidebar('blog');
get_footer(); ?>