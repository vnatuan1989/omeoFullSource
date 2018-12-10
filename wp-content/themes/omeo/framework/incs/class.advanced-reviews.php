<?php

if (!defined('ABSPATH')) exit;

class Yesshop_Advanced_Review
{

    private static $instance = null;

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init()
    {
        global $yesshop_datas;

        add_filter('comments_template', array($this, 'comments_template_loader'), 55);

        if (!isset($yesshop_datas['product-advanced-rating']) || absint($yesshop_datas['product-advanced-rating']) === 1) {
            add_filter('yesshop_advanced_reviews_imput_html', array($this, 'input_html'));
            if (class_exists('WC_Comments')) {
                remove_action('comment_post', array('WC_Comments', 'add_comment_rating'), 1);
                add_action('comment_post', array($this, 'add_comment_rating'), 1);
            }
        }
    }

    public function comments_template_loader($template)
    {
        if (get_post_type() !== 'product') {
            return $template;
        }

        $check_dirs = array(
            trailingslashit(get_stylesheet_directory()) . WC()->template_path(),
            trailingslashit(get_template_directory()) . WC()->template_path(),
            trailingslashit(get_stylesheet_directory()),
            trailingslashit(get_template_directory())
        );

        if (WC_TEMPLATE_DEBUG_MODE) {
            $check_dirs = array(array_pop($check_dirs));
        }

        foreach ($check_dirs as $dir) {
            if (file_exists(trailingslashit($dir) . 'single-product-advanced-reviews.php')) {
                return trailingslashit($dir) . 'single-product-advanced-reviews.php';
            }
        }
    }

    public function input_html($html = '')
    {
        ob_start();
        ?>
        <div class="form-group comment-form-rating yeti-comment-form-rating">
            <label for="rating_quality" class="control-label"><?php esc_html_e('Your Rating', 'omeo') ?></label>
            <div class="row">
                <div class="col-sm-14">
                    <div class="row">
                        <div class="col-sm-6 text-right"><?php esc_html_e('Quality', 'omeo') ?></div>
                        <div class="col-sm-18">
                            <div class="yeti-rating input">
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
                                <select name="yeti_rating[quality]" class="hidden" id="rating_quality"
                                        aria-required="true" required>
                                    <option value=""><?php esc_attr_e('Rate&hellip;', 'omeo') ?></option>
                                    <option value="5"><?php esc_attr_e('Perfect', 'omeo') ?></option>
                                    <option value="4"><?php esc_attr_e('Good', 'omeo') ?></option>
                                    <option value="3"><?php esc_attr_e('Average', 'omeo') ?></option>
                                    <option value="2"><?php esc_attr_e('Not that bad', 'omeo') ?></option>
                                    <option value="1"><?php esc_attr_e('Very Poor', 'omeo') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right"><?php esc_html_e('Value', 'omeo') ?></div>
                        <div class="col-sm-18">
                            <div class="yeti-rating input">
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
                                    <option value=""><?php esc_attr_e('Rate&hellip;', 'omeo') ?></option>
                                    <option value="5"><?php esc_attr_e('Perfect', 'omeo') ?></option>
                                    <option value="4"><?php esc_attr_e('Good', 'omeo') ?></option>
                                    <option value="3"><?php esc_attr_e('Average', 'omeo') ?></option>
                                    <option value="2"><?php esc_attr_e('Not that bad', 'omeo') ?></option>
                                    <option value="1"><?php esc_attr_e('Very Poor', 'omeo') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right"><?php esc_html_e('Price', 'omeo') ?></div>
                        <div class="col-sm-18">
                            <div class="yeti-rating input">
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
                                    <option value=""><?php esc_attr_e('Rate&hellip;', 'omeo') ?></option>
                                    <option value="5"><?php esc_attr_e('Perfect', 'omeo') ?></option>
                                    <option value="4"><?php esc_attr_e('Good', 'omeo') ?></option>
                                    <option value="3"><?php esc_attr_e('Average', 'omeo') ?></option>
                                    <option value="2"><?php esc_attr_e('Not that bad', 'omeo') ?></option>
                                    <option value="1"><?php esc_attr_e('Very Poor', 'omeo') ?></option>
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

    public function get_rating_counts()
    {
        global $wpdb, $product;

        $result = $wpdb->get_results(
            $wpdb->prepare("
			SELECT `meta_value`, COUNT(*) as `count` FROM $wpdb->commentmeta LEFT JOIN $wpdb->comments
			ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_id
			WHERE `meta_key` = 'rating'
			AND `comment_post_ID` = %d
			AND `comment_approved` = '1'
			AND `meta_value` > 0
			GROUP BY `meta_value`
			", $product->get_id())
        );

        $res = array();
        foreach ($result as $count) {
            $res[$count->meta_value] = $count->count;
        }

        return $res;
    }
}

function Yesshop_Advanced_Review()
{
    return Yesshop_Advanced_Review::get_instance();
}

Yesshop_Advanced_Review()->init();