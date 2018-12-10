<?php
/**
 * The template part for displaying a message that posts cannot be found
 */
?>
<h1 class="heading-title page-title"><?php esc_html_e('Nothing Found', 'omeo'); ?></h1>

<div class="result-content">

    <?php if (is_home() && current_user_can('publish_posts')) : ?>

        <p><?php printf(wp_kses(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'omeo'), array('a' => array('title' => array(), 'href' => array()))), esc_url(admin_url('post-new.php'))); ?></p>

    <?php elseif (is_search()) : ?>

        <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'omeo'); ?></p>
        <?php get_search_form(); ?>

    <?php else : ?>

        <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'omeo'); ?></p>
        <?php get_search_form(); ?>

    <?php endif; ?>

</div>
