<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.3.2
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

if (!comments_open()) {
    return;
}

$count = $product->get_review_count();
$reivew_counts = array();
if (class_exists('Yesshop_Advanced_Review')) {
    $reivew_counts = Yesshop_Advanced_Review()->get_rating_counts();
}
?>
<div id="reviews" class="woocommerce-Reviews yeti-advanced-review-wrap">

    <div class="row yeti-reviews-wrap">
        <div class="col-sm-12">
            <h2 class="woocommerce-Reviews-title"><?php
                if (get_option('woocommerce_enable_review_rating') === 'yes' && $count)
                    printf(_n('Based on %s reviews', 'Based on %s review', $count, 'omeo'), $count);
                else
                    esc_attr_e('Reviews', 'omeo');
                ?></h2>

            <div class="yeti-rating-chart">

                <div class="overall-review">
                    <span class="rating-avg-label"><?php echo esc_html(number_format($product->get_average_rating(), 1)) ?></span>
                    <span>overall</span>
                </div>

                <div class="progress-wrap">
                    <?php for ($star = 5; $star > 0; $star--) : ?>
                        <?php
                        $rating_percentage = 0;
                        $rating_counts = 0;
                        if (isset($reivew_counts[$star])) {
                            $rating_percentage = round($reivew_counts[$star] / $count, 2) * 100;
                            $rating_counts = absint($reivew_counts[$star]);
                        }
                        ?>
                        <div class="rating-bar">
                            <div class="row">
                                <div class="star-txt col-sm-9">
                                    <div class="yeti-rating">
                                        <div class="yeti-stars selected">
                                            <ul class="list-inline list-unstyles">
                                                <?php for ($i = 1; $i < 6; $i++) :
                                                    if($i === $star) : ?>
                                                        <li class="active"><a href="#" data-val="<?php echo absint($i)?>"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
                                                    <?php else: ?>
                                                        <li><a href="#" data-val="<?php echo absint($i)?>"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-15">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo esc_attr($rating_percentage)?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($rating_percentage)?>%;">
                                            <span class="sr-only"><?php echo esc_attr($rating_percentage)?>%</span>
                                        </div>
                                    </div>
                                    <span class="rate-count"><?php echo absint($rating_counts) ?></span>
                                </div>

                            </div>


                        </div>
                    <?php endfor; ?>
                </div>

            </div>
        </div>

        <div class="col-sm-12">
            <?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) : ?>

                <div id="review_form_wrapper">
                    <div id="review_form">
                        <?php
                        $commenter = wp_get_current_commenter();

                        $comment_form = array(
                            'title_reply' => have_comments() ? esc_attr__('Add a review', 'omeo') : sprintf(__('Be the first to review &ldquo;%s&rdquo;', 'omeo'), get_the_title()),
                            'title_reply_to' => esc_attr__('Leave a Reply to %s', 'omeo'),
                            'comment_notes_after' => '',
                            'fields' => array(
                                'author' => '<div class="form-group comment-form-author">' . '<label for="author" class="control-label">' . esc_attr__('Name', 'omeo') . ' <span class="required">*</span></label> ' .
                                    '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" aria-required="true" required /></div>',
                                'email' => '<div class="form-group comment-form-email"><label for="email" class="control-label">' . esc_attr__('Email', 'omeo') . ' <span class="required">*</span></label> ' .
                                    '<input class="form-control" id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" aria-required="true" required /></div>',
                            ),
                            'label_submit' => esc_attr__('Submit', 'omeo'),
                            'logged_in_as' => '',
                            'comment_field' => '',
                        );

                        if ($account_page_url = wc_get_page_permalink('myaccount')) {
                            $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a review.', 'omeo'), esc_url($account_page_url)) . '</p>';
                        }

                        if (get_option('woocommerce_enable_review_rating') === 'yes') {
                            ob_start();
                            ?>
                            <div class="form-group comment-form-rating">
                                <label for="rating"
                                       class="control-label"><?php esc_html_e('Your Rating', 'omeo') ?></label>
                                <select name="rating" id="rating" aria-required="true" required>
                                    <option value=""><?php esc_attr_e('Rate&hellip;', 'omeo') ?></option>
                                    <option value="5"><?php esc_attr_e('Perfect', 'omeo') ?></option>
                                    <option value="4"><?php esc_attr_e('Good', 'omeo') ?></option>
                                    <option value="3"><?php esc_attr_e('Average', 'omeo') ?></option>
                                    <option value="2"><?php esc_attr_e('Not that bad', 'omeo') ?></option>
                                    <option value="1"><?php esc_attr_e('Very Poor', 'omeo') ?></option>
                                </select>
                            </div>
                            <?php
                            $comment_form['comment_field'] = apply_filters('yesshop_advanced_reviews_imput_html', ob_get_clean());
                        }

                        $comment_form['comment_field'] .= '<div class="form-group comment-form-comment"><label for="comment" class="control-label">' . esc_attr__('Your Review', 'omeo') . ' <span class="required">*</span></label><textarea class="form-control" id="comment" name="comment" cols="45" rows="3" aria-required="true" required></textarea></div>';

                        comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
                        ?>
                    </div>
                </div>

            <?php else : ?>

                <p class="woocommerce-verification-required"><?php esc_attr_e('Only logged in customers who have purchased this product may leave a review.', 'omeo'); ?></p>

            <?php endif; ?>
        </div>
    </div>

    <div id="comments">

        <?php if (have_comments()) : ?>

            <ol class="commentlist">
                <?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'woocommerce_comments'))); ?>
            </ol>

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) :
                echo '<nav class="woocommerce-pagination">';
                paginate_comments_links(apply_filters('woocommerce_comment_pagination_args', array(
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                    'type' => 'list',
                )));
                echo '</nav>';
            endif; ?>

        <?php else : ?>

            <p class="woocommerce-noreviews"><?php esc_attr_e('There are no reviews yet.', 'omeo'); ?></p>

        <?php endif; ?>
    </div>


</div>
