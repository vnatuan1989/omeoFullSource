<?php

if (!defined('ABSPATH')) exit;

class Yetithemes_Advanced_Review
{

    public function __construct()
    {
        add_filter('yesshop_advanced_reviews_imput_html', array($this, 'input_html'));
        if (class_exists('WC_Comments')) {
            remove_action('comment_post', array('WC_Comments', 'add_comment_rating'), 1);
            add_action('comment_post', array($this, 'add_comment_rating'), 1);
        }
    }

    public function input_html($html = '')
    {
        ob_start();
        ?>
        <div class="form-group comment-form-rating yeti-comment-form-rating">
            <label for="rating_quality" class="control-label"><?php esc_html_e('Your Rating', 'yetithemes') ?></label>
            <div class="row">
                <div class="col-sm-14">
                    <div class="row">
                        <div class="col-sm-6 text-right"><?php esc_html_e('Quality', 'yetithemes') ?></div>
                        <div class="col-sm-18">
                            <div class="yeti-rating">
                                <div class="yeti-stars">
                                    <ul class="list-inline list-unstyles">
                                        <li><a href="#" data-val="1"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="2"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="3"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="4"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <select name="yeti_rating[quality]" class="hidden" id="rating_quality" aria-required="true" required>
                                    <option value=""><?php esc_attr_e('Rate&hellip;', 'yetithemes') ?></option>
                                    <option value="5"><?php esc_attr_e('Perfect', 'yetithemes') ?></option>
                                    <option value="4"><?php esc_attr_e('Good', 'yetithemes') ?></option>
                                    <option value="3"><?php esc_attr_e('Average', 'yetithemes') ?></option>
                                    <option value="2"><?php esc_attr_e('Not that bad', 'yetithemes') ?></option>
                                    <option value="1"><?php esc_attr_e('Very Poor', 'yetithemes') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right"><?php esc_html_e('Value', 'yetithemes') ?></div>
                        <div class="col-sm-18">
                            <div class="yeti-rating">
                                <div class="yeti-stars">
                                    <ul class="list-inline list-unstyles">
                                        <li><a href="#" data-val="1"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="2"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="3"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="4"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <select name="yeti_rating[value]" class="hidden" id="rating_value" aria-required="true"
                                        required>
                                    <option value=""><?php esc_attr_e('Rate&hellip;', 'yetithemes') ?></option>
                                    <option value="5"><?php esc_attr_e('Perfect', 'yetithemes') ?></option>
                                    <option value="4"><?php esc_attr_e('Good', 'yetithemes') ?></option>
                                    <option value="3"><?php esc_attr_e('Average', 'yetithemes') ?></option>
                                    <option value="2"><?php esc_attr_e('Not that bad', 'yetithemes') ?></option>
                                    <option value="1"><?php esc_attr_e('Very Poor', 'yetithemes') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right"><?php esc_html_e('Price', 'yetithemes') ?></div>
                        <div class="col-sm-18">
                            <div class="yeti-rating">
                                <div class="yeti-stars">
                                    <ul class="list-inline list-unstyles">
                                        <li><a href="#" data-val="1"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="2"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="3"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="4"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                        <li><a href="#" data-val="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <select name="yeti_rating[price]" class="hidden" id="rating_price" aria-required="true"
                                        required>
                                    <option value=""><?php esc_attr_e('Rate&hellip;', 'yetithemes') ?></option>
                                    <option value="5"><?php esc_attr_e('Perfect', 'yetithemes') ?></option>
                                    <option value="4"><?php esc_attr_e('Good', 'yetithemes') ?></option>
                                    <option value="3"><?php esc_attr_e('Average', 'yetithemes') ?></option>
                                    <option value="2"><?php esc_attr_e('Not that bad', 'yetithemes') ?></option>
                                    <option value="1"><?php esc_attr_e('Very Poor', 'yetithemes') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 advanced-rating-wrap">
                    <span class="rating-text">0.0</span>
                    <input type="hidden" name="rating" aria-required="true" required>
                </div>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }

    public function add_comment_rating($comment_id)
    {
        if (isset($_POST['rating']) && 'product' === get_post_type($_POST['comment_post_ID'])) {
            if (!$_POST['rating'] || $_POST['rating'] > 5 || $_POST['rating'] < 0) {
                return;
            }
            add_comment_meta($comment_id, 'rating', round(esc_attr($_POST['rating'])), true);

            if (isset($_POST['yeti_rating']) && !empty($_POST['yeti_rating'])) {
                add_comment_meta($comment_id, 'yeti_ratings', $_POST['yeti_rating'], true);
            }
        }
    }

}

new Yetithemes_Advanced_Review();