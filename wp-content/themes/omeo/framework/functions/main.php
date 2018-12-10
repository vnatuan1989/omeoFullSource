<?php

if (!function_exists('yesshop_list_comments')) {

    function yesshop_list_comments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) {
            case 'pingback':
                ?>
                <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment', $comment ); ?>>
                    <div class="comment-body">
                        <?php esc_attr_e( 'Pingback:', 'omeo' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'omeo' ), ' ', '' ); ?>
                    </div>
                </li>
                <?php
                break;
            default :
                ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">

                    <div class="comment-author vcard">
                        <?php echo get_avatar($comment, 70); ?>
                    </div><!-- .comment-author .vcard -->

                    <?php if ($comment->comment_approved == '0') : ?>
                        <em class="comment-awaiting-moderation bg-warning"><?php esc_html_e('Your comment is awaiting moderation.', 'omeo'); ?></em>
                        <br/>
                    <?php endif; ?>

                    <div class="comment-meta commentmetadata">
                        <h3 class="comment-author"><span><?php echo get_comment_author_link(); ?></span></h3>
                        <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                            <?php printf(esc_html__('%1$s at %2$s', 'omeo'), get_comment_date(), get_comment_time()); ?></a><?php edit_comment_link(esc_html__('(Edit)', 'omeo'), '  ', ''); ?>

                        <div class="pull-right">
                            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<i class="fa fa-reply"></i> ' . esc_html__('Reply', 'omeo')))); ?>
                        </div>
                    </div>
                    <div class="comment-text">
                        <?php comment_text(); ?>
                    </div>

                    <div class="clearfix"></div>

                </div><!-- #comment-##  -->
                <?php
                break;
        }
    }

}

if (!function_exists('yesshop_newsletter_popup_callback')) {

    function yesshop_newsletter_popup_callback()
    {
        global $yesshop_datas;

        if (!isset($yesshop_datas['newsletter-popup']) || absint($yesshop_datas['newsletter-popup']) == 0) return '';
        if (empty($yesshop_datas['newsletter-popup-content'])) return '';
        if (!class_exists('Yetithemes_StaticBlock')) return '';

        $_widht = !empty($yesshop_datas['newsletter-popup-width']) ? absint($yesshop_datas['newsletter-popup-width']) : 800;
        $_link = admin_url('admin-ajax.php') . "?ajax=true&action=yesshop_get_newsletter_popup&id=" . esc_attr($yesshop_datas['newsletter-popup-content']);

        echo '<a href="' . esc_url($_link) . '" title="Newsletter popup"  data-mgf_width="' . absint($_widht) . '" class="hidden" id="yeti_newsletter_popup_open">open popup</a>';
    }

}

function yesshop_compare_popup(){
    if(!class_exists('YITH_Woocompare') || !function_exists('yesshop_woocompare_view_table_url')) return;
    ?>
    <div class="yeti-compare-popup animated bounceInRight">
        <a class="yeti-close" href="#" title="Close">close</a>
        <ul class="products-list list-unstyled"></ul>
        <a href="<?php echo yesshop_woocompare_view_table_url();?>" class="compared-link btn"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php esc_attr_e('Go to compare table', 'omeo')?></a>
    </div>
    <?php
}

/**
 * Add term and condition field in register form - hook woocommerce_register_form
 * @param void
 * @return html
 */
if(!function_exists('yeti_register_term_condition_field'))
{
    function yeti_register_term_condition_field()
    {
        $term_page_id = get_option('woocommerce_terms_page_id');
        if($term_page_id):
        $term_page = get_post( absint($term_page_id) ); ?>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="agree_with_term" type="checkbox">
                <?php printf( __('<span>I accept the terms and conditions, including <a title="%s" href="%s" target="_blank">the Privacy Policy</a></span> <span class="required">*</span>', 'omeo'), esc_attr( $term_page->post_title ), esc_url( get_the_permalink( $term_page_id ) ) ); ?>
            </label>
        </p>
    <?php endif;
    }
}

/**
 * Validate term and condition in register form - hook woocommerce_registration_errors
 * @param $errors, $sanitized_user_login, $user_email
 * @return object $errors
 */
if(!function_exists('yeti_register_term_condition'))
{
    function yeti_register_term_condition( $errors, $sanitized_user_login, $user_email )
    {
        $term_page_id = get_option('woocommerce_terms_page_id');
        if($term_page_id) {
            if (empty($_POST['agree_with_term'])) {
                $errors->add('agree_with_term_error', __('You don\'t accept with our terms and condition!', 'omeo'));
            }
        }

        return $errors;
    }
}
