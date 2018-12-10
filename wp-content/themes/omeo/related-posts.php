<?php
$categories = get_the_category(get_the_ID());
if (empty($categories)) return;

$cat_ids = array();
foreach ($categories as $term) {
    $cat_ids[] = $term->term_id;
}
$args = array(
    'post_type' => get_post_type(),
    'post__not_in' => array(get_the_ID()),
    'posts_per_page' => 3,
    'category__in' => $cat_ids
);

$related = new WP_Query($args);
$cout = 0;
$i = 0;

if ($related->have_posts()) : ?>

    <div class="related_post related">

        <h3 class="heading-title"><?php esc_html_e('Related posts', 'omeo'); ?></h3>

        <?php

        echo '<ul class="list-post-widget">';

        set_query_var('excerpt_words', 20);

        while ($related->have_posts()) : $related->the_post();

            get_template_part('content', 'widget');

        endwhile;

        echo '</ul>';

        wp_reset_postdata();

        ?>

    </div>

<?php endif;