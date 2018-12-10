<?php

/**
 * Package: yesshop.
 * User: kinhdon
 * Date: 11/10/2015
 * Vertion: 1.0
 */

if (!class_exists('Yetithemes_Gallery')) {
    class Yetithemes_Gallery
    {

        protected $post_type = 'yeti_gallery';

        protected $tax_cat = 'yeti_gallery_cat';

        function __construct()
        {
        }

        public function init()
        {
            add_action('init', array($this, 'registerPostType'));
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action('save_post', array($this, 'save_options'));
            add_action('init', array($this, 'ajax_hook'));
        }

        public function ajax_hook()
        {
            add_action('wp_ajax_yeti_gallery_content', array($this, 'ajax_getContent'));
            add_action('wp_ajax_nopriv_yeti_gallery_content', array($this, 'ajax_getContent'));

            add_action('wp_ajax_yeti_gallery_items', array($this, 'ajax_gallery_items'));
            add_action('wp_ajax_nopriv_yeti_gallery_items', array($this, 'ajax_gallery_items'));
        }

        public function registerPostType()
        {
            $labels = array(
                'name' => _x('Galleries', 'post type general name', 'yetithemes'),
                'singular_name' => _x('Gallery', 'post type singular name', 'yetithemes'),
                'menu_name' => _x('YETI Galleries', 'admin menu', 'yetithemes'),
                'name_admin_bar' => _x('Gallery', 'add new on admin bar', 'yetithemes'),
                'add_new' => _x('Add New', 'Gallery', 'yetithemes'),
                'add_new_item' => __('Add New Gallery', 'yetithemes'),
                'new_item' => __('New Gallery', 'yetithemes'),
                'edit_item' => __('Edit Gallery', 'yetithemes'),
                'view_item' => __('View Gallery', 'yetithemes'),
                'all_items' => __('All Galleries', 'yetithemes'),
                'search_items' => __('Search Galleries', 'yetithemes'),
                'parent_item_colon' => __('Parent Galleries:', 'yetithemes'),
                'not_found' => __('No Gallery found.', 'yetithemes'),
                'not_found_in_trash' => __('No Gallery found in Trash.', 'yetithemes')
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'galleries'),
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'can_export' => true,
                'exclude_from_search' => false,
                'taxonomies' => array($this->tax_cat),
                'menu_icon' => "dashicons-admin-media",
                'supports' => array('title', 'excerpt', 'thumbnail', 'custom-fields')
            );

            register_post_type($this->post_type, $args);

            $this->registerCategoryTax();

        }

        public function registerCategoryTax()
        {
            $labels = array(
                'name' => _x('Categories', 'taxonomy general name', 'yetithemes'),
                'singular_name' => _x('Category', 'taxonomy singular name', 'yetithemes'),
                'search_items' => __('Search Categories', 'yetithemes'),
                'popular_items' => __('Popular Categories', 'yetithemes'),
                'all_items' => __('All Categories', 'yetithemes'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Category', 'yetithemes'),
                'update_item' => __('Update Category', 'yetithemes'),
                'add_new_item' => __('Add New Category', 'yetithemes'),
                'new_item_name' => __('New Category Name', 'yetithemes'),
                'separate_items_with_commas' => __('Separate Categories with commas', 'yetithemes'),
                'add_or_remove_items' => __('Add or remove Categories', 'yetithemes'),
                'choose_from_most_used' => __('Choose from the most used Categories', 'yetithemes'),
                'not_found' => __('No Categories found.', 'yetithemes'),
                'menu_name' => __('Categories', 'yetithemes'),
            );

            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                //'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'rewrite' => array('slug' => $this->tax_cat),
            );

            register_taxonomy($this->tax_cat, $this->post_type, $args);
        }

        public function add_meta_boxes()
        {
            add_meta_box('yeti-gallery-images',
                __('Gallery Images / Videos', 'yetithemes'),
                array($this, 'metaOutput'),
                $this->post_type, 'normal', 'high');
        }

        public function metaOutput($post)
        {
            $_image_gallery = '';
            $_video_gallery = array();
            $data = $this->get_galleries_data($post->ID);

            if (is_array($data)) {
                $_image_gallery = !empty($data['att_img']) ? $data['att_img'] : '';
                $_video_gallery = !empty($data['v_link']) ? $data['v_link'] : array();
                $_g_style = !empty($data['g_style']) ? $data['g_style'] : '';
            }

            $attachments = array_filter(explode(',', $_image_gallery));
            ?>
            <div id="yeti_galleries_container">

                <div class="galleries_general yeti-form-row yeti-field-hr">
                    <label for="gallery_style"><?php _e('Gallery style', 'yetithemes'); ?></label>
                    <select name="gallery_style" id="gallery_style">
                        <option value="1"<?php selected($_g_style, '1') ?>><?php _e('Style 1') ?></option>
                        <option value="2"<?php selected($_g_style, '2') ?>><?php _e('Style 2') ?></option>
                    </select>
                </div>

                <div class="galleries_images">

                    <ul class="gallery-images">
                        <?php
                        if (!empty($attachments)) {
                            foreach ($attachments as $attachment_id) {
                                echo '<li class="image" data-attachment_id="' . esc_attr($attachment_id) . '">
								' . wp_get_attachment_image($attachment_id, 'thumbnail') . '
								<ul class="actions">
									<li><a href="#" class="delete" title="' . esc_attr__('Delete image', 'yetithemes') . '">' . __('&times;', 'yetithemes') . '</a></li>
								</ul>
							</li>';
                            }
                        }
                        ?>
                    </ul>

                    <input type="hidden" id="nth_gallery_image_id" name="nth_gallery_image_id"
                           value="<?php echo esc_attr($_image_gallery) ?>"/>

                    <p class="add_gallery_images hide-if-no-js">
                        <a href="#" class="button"
                           data-choose="<?php esc_attr_e('Add Images to Gallery', 'yetithemes'); ?>"
                           data-update="<?php esc_attr_e('Add to gallery', 'yetithemes'); ?>"
                           data-delete="<?php esc_attr_e('Delete image', 'yetithemes'); ?>"
                           data-text="&times;"><?php _e('Add gallery images', 'yetithemes'); ?></a>
                    </p>
                </div>

                <div class="galleries_videos">
                    <?php
                    $tbody = '';
                    $tr_class = '';
                    if (!empty($_video_gallery)) {
                        foreach ($_video_gallery as $video) {
                            $args = explode('|', $video);
                            if (!isset($args[2])) $args[2] = '&mdash;';
                            $hidden = '<input type="hidden" name="nth_gallery_video[]" value="' . $video . '" />';
                            $image = wp_get_attachment_image_src($args[1], 'thumbnail');

                            $tbody .= '<tr>';
                            $tbody .= '<td><img src="' . esc_url($image[0]) . '" width="28" height="28" /></td>';
                            $tbody .= '<td>' . $args[0] . $hidden . '</td>';
                            $tbody .= '<td>' . $args[2] . '</td>';
                            $tbody .= '<td><a href="#" class="dashicons-before dashicons-trash remove"></a></td>';
                            $tbody .= '</tr>';
                        }
                        $tr_class = 'hidden';
                    }
                    ?>
                    <table class="gallery-videos wp-list-table widefat">
                        <thead>
                        <tr>
                            <th width="34"></th>
                            <th><?php _e('Video Link', 'yetithemes'); ?></th>
                            <th><?php _e('Position', 'yetithemes'); ?></th>
                            <th width="32"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="no_item <?php echo esc_attr($tr_class); ?>">
                            <td colspan="2">
                                <small><?php _e("No single tab found!", 'yetithemes'); ?></small>
                            </td>
                        </tr>
                        <?php echo $tbody; ?>
                        </tbody>
                    </table>


                    <div id="yeti-dialog-form" title="<?php _e('Add gallery video'); ?>">

                        <form>

                            <table class="form-table">
                                <tbody>

                                <tr>
                                    <th scope="row">
                                        <label for="link"><?php _e('Video thumb'); ?></label>
                                    </th>
                                    <td>
                                        <?php
                                        $image = THEME_BACKEND_URI . "images/placeholder.png";
                                        $dis_none_remove = "display: none;";
                                        ?>
                                        <div class="nth_upload_image"
                                             data-f_title="<?php _e('Choose an image', 'yetithemes'); ?>"
                                             data-f_btext="<?php _e('Use image', 'yetithemes'); ?>">
                                            <div class="nth_thumbnail" style="float:left;margin-right:10px;"><img
                                                        src="<?php echo $image; ?>" width="28px" height="28px"/></div>
                                            <div style="line-height:28px;">
                                                <input type="hidden" class="nth_image_id" name="thumbnail_id"
                                                       id="thumbnail_id" value=""/>
                                                <button type="submit"
                                                        class="nth_upload_image_button button"><?php _e('Add image', 'yetithemes'); ?></button>
                                                <button type="submit" style="<?php echo esc_attr($dis_none_remove); ?>"
                                                        class="nth_remove_image_button button"><?php _e('Remove', 'yetithemes'); ?></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="75">
                                        <label for="link"><?php _e('Video link'); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="link" id="link" value="" class="text">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="pos"><?php _e('Position'); ?></label>
                                    </th>
                                    <td>
                                        <input type="number" name="pos" id="pos" value="" class="text">
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <button type="submit" id="yeti-add-gallery-video"
                                    class="button"><?php _e('Add gallery video'); ?></button>
                        </form>

                    </div>


                </div>


            </div>
            <?php
        }

        public function save_options($post_id)
        {
            $post_type = get_post_type($post_id);
            if (empty($post_type)) return;

            if (strcmp($post_type, $this->post_type) == 0) {
                $attachment_ids = isset($_POST['nth_gallery_image_id']) ?
                    array_unique(explode(',', $_POST['nth_gallery_image_id'])) : array();
                $video_links = isset($_POST['nth_gallery_video']) && is_array($_POST['nth_gallery_video']) ?
                    $_POST['nth_gallery_video'] : array();
                $gallery_style = isset($_POST['gallery_style']) ? $_POST['gallery_style'] : '';
                $data = array(
                    'att_img' => implode(',', $attachment_ids),
                    'v_link' => $video_links,
                    'g_style' => $gallery_style
                );
                update_post_meta($post_id, '_yeti_gallery_images', serialize($data));
            }
        }

        private $tmp_datas = array();

        public function get_galleries_data($post_id)
        {
            $data = array();
            $thumb_ids = array();
            if (metadata_exists('post', $post_id, '_yeti_gallery_images')) {
                $datas = get_post_meta($post_id, '_yeti_gallery_images', false);

                $data = array();
                foreach ($datas as $value) {
                    $value = maybe_unserialize($value);
                    if(!empty($value['att_img'])) {
                        $data = $value;
                        break;
                    }
                }

                if (!empty($data['att_img']))
                    $thumb_ids = array_filter(explode(',', $data['att_img']));
                if (!empty($data['v_link'])) {
                    foreach ($data['v_link'] as $v_link) {
                        $videos = explode('|', $v_link);
                        if (!isset($videos[2]) || absint($videos[2]) >= count($thumb_ids)) $videos[2] = -1;
                        array_splice($thumb_ids, (int)$videos[2] - 1, 0, array($videos));
                    }
                }
                $data['thumb_ids'] = $thumb_ids;
            }
            return $data;
        }

        public function ajax_getContent()
        {
            $termID = isset($_REQUEST['term_id']) ? esc_attr($_REQUEST['term_id']) : '';
            $orderby = isset($_REQUEST['orderby']) ? esc_attr($_REQUEST['orderby']) : 'date';
            $order = isset($_REQUEST['order']) ? esc_attr($_REQUEST['order']) : 'DESC';
            $paged = isset($_REQUEST['paged']) ? esc_attr($_REQUEST['paged']) : '1';
            $this->getContent(array(
                'term_id' => $termID,
                'orderby' => $orderby,
                'order' => $order,
                'paged' => $paged
            ));

            wp_die();
        }

        public function ajax_gallery_items()
        {
            $atts = $_REQUEST;
            if (empty($atts['post_id'])) wp_die();

            $res = array();

            $att_ids = $this->get_galleries_data($atts['post_id']);

            $att_ids = array_slice($att_ids['thumb_ids'], $atts['k'], $atts['l']);

            ob_start();
            foreach ($att_ids as $att_el):
                $class = array('gallery-image-item');

                if (is_array($att_el)) {
                    $attachment_id = $att_el[1];
                    $class[] = 'gallery-video';
                    $image_link = $att_el[0];
                } else {
                    $attachment_id = $att_el;
                    $image_link = wp_get_attachment_url($attachment_id);

                }

                if (!$image_link)
                    continue;

                $image_title = esc_attr(get_the_title($attachment_id));

                $image = wp_get_attachment_image($attachment_id, 'gallery_thumb_auto', 0, $attr = array(
                    'title' => $image_title,
                    'alt' => $image_title
                ));

                ?>
                <div class="<?php echo esc_attr(implode(' ', $class)); ?>">
                    <?php
                    printf('<a href="%s" class="yeti-pretty-photo" title="%s" data-rel="nth_prettyPhoto[gallery-image]">%s</a>', $image_link, $image_title, $image);
                    ?>
                </div>
                <?php

            endforeach;

            //echo ob_get_clean();
            $res['element'] = ob_get_clean();
            $res['k'] = absint($atts['k']) + absint($atts['l']);
            echo wp_json_encode($res);
            wp_die();
        }

        public function getFilters()
        {
            $args = array(
                'hide_empty' => true,
                'orderby' => 'title',
                'order' => 'ASC',
                'post_type' => 'yeti_gallery',
            );
            $terms = get_terms('yeti_gallery_cat', $args);

            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $output = '<div class="row"><div class="col-sm-24 col-md-24"><ul class="list-inline list-nostyle gallery-filters ajax_filter tabs text-center" data-paged="' . absint($paged) . '">';
            $output .= '<li id="all" class="active yeti-tabitem"><a href="javascript:void(0)" id="all_a" data-termid="0" class="filter active">' . __('View All', 'yetithemes') . '</a></li>';
            foreach ($terms as $cat) {
                $output .= '<li id="' . esc_html($cat->slug) . '" class="yeti-tabitem"><a href="#" data-termid="' . esc_html($cat->term_id) . '" id="' . esc_html($cat->slug) . '_a" class="filter-portfoio">' . esc_html($cat->name) . '</a></li>';
            }
            $output .= '</ul></div>';

            $output .= '<div class="col-sm-24 col-md-24 text-right hide"><form method="post" class="order-form">';
            $output .= '<label>' . __('Sort by', 'yetithemes') . '</label>';
            $output .= '<select name="orderby">';
            $output .= '<option value="date">' . __('Date', 'yetithemes') . '</option>';
            $output .= '<option value="title">' . __('Title', 'yetithemes') . '</option>';
            $output .= '<option value="rand">' . __('Random', 'yetithemes') . '</option>';
            $output .= '</select>';
            $output .= '<label>' . __('Sort', 'yetithemes') . '</label>';
            $output .= '<select name="order">';
            $output .= '<option value="DESC">' . __('DESC', 'yetithemes') . '</option>';
            $output .= '<option value="ASC">' . __('ASC', 'yetithemes') . '</option>';
            $output .= '</select>';
            $output .= '</form></div></div>';

            echo $output;
        }

        public function getContent($atts = array())
        {
            $atts = wp_parse_args($atts, array(
                'term_id' => '0',
                'orderby' => 'title',
                'order' => 'DESC',
                'limit' => -1,
                'paged' => 1,
                'is_slider' => 0,
            ));

            $args = array(
                'post_type' => 'yeti_gallery',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'orderby' => $atts['orderby'],
                'order' => $atts['order'],
                'posts_per_page' => $atts['limit'],
                'paged' => get_query_var('paged') ? get_query_var('paged') : absint($atts['paged'])
            );

            if (strlen($atts['term_id']) > 0 && absint($atts['term_id']) > 0) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'yeti_gallery_cat',
                        'terms' => explode(',', $atts['term_id']),
                        'field' => 'term_id',
                        'operator' => 'IN'
                    )
                );
            }

            query_posts($args);


            if(empty($atts['columns'])) {
                $atts['columns'] = apply_filters('yetithemes_galleries_columns', 4);
            }

            if (have_posts()) {
                $_is_slider = absint($atts['is_slider']);
                if($_is_slider) {
                    $options = array(
                        'items' => absint($atts['columns']),
                    );
                    $options = YetiThemes_Extra()->get_owlResponsive($options);
                    printf('<div class="yeti-owlCarousel yeti-loading light" data-options="%1$s" data-base="1">', esc_attr(json_encode($options)));
                    YetiThemes_Extra()->get_yetiLoadingIcon();
                    echo '<div class="yeti-owl-slider">';
                }

                while (have_posts()) {
                    the_post();
                    global $post;
                    $class = array();
                    $class[] = 'col-lg-' . round(24 / absint($atts['columns']));
                    $class[] = 'col-md-' . round(24 / (1 + round(absint($atts['columns']) * 992 / 1170)));
                    $class[] = 'col-sm-' . round(24 / (round(absint($atts['columns']) * 768 / 1170)));
                    $class[] = 'col-xs-' . round(24 / (round(absint($atts['columns']) * 480 / 1170)));
                    $class[] = 'col-mb-24';

                    $cats = wp_get_post_terms($post->ID, 'yeti_gallery_cat', array("fields" => "slugs"));
                    $galleries = $this->get_galleries_data($post->ID);

                    $atts2 = array(
                        'class' => $class,
                        'cats' => $cats,
                        'post_type' => 'yeti_gallery',
                        'tax_cat' => 'yeti_gallery_cat',
                        'galleries' => $galleries
                    );

                    YetiThemes_Extra()->get_template('album-gallery.tpl.php', $atts2);
                }

                if($_is_slider) {
                    echo '</div></div>';
                }
            }
        }

        public static function renderFE_Images($thumb_ids = array(), $img = true)
        {
            if (count($thumb_ids) == 0) return;
            foreach ($thumb_ids as $att_el) {
                $image = '';
                if (is_array($att_el)) {
                    $attachment_id = $att_el[1];
                    $class[] = 'gallery-video';
                    if (function_exists('yesshop_video_player')) {
                        $params = array(
                            'url' => $att_el[0],
                            'width' => '1170',
                            'height' => '865'
                        );
                        ob_start();
                        yesshop_video_player($params);
                        $image = ob_get_clean();
                    }
                } else {
                    $attachment_id = $att_el;
                }

                $image_meta = get_post($attachment_id);
                $image_title = esc_attr($image_meta->post_title);
                $image_desc = $image_meta->post_content;

                if ($img) {
                    ?>
                    <li class="item-<?php echo esc_attr($attachment_id) ?>">
                        <?php echo wp_get_attachment_image($attachment_id, 'yesshop_blog_single', 0, $attr = array(
                            'title' => $image_title,
                            'alt' => $image_title
                        )); ?>
                        <?php echo esc_html($image_desc); ?>
                    </li>
                    <?php
                } else {
                    ?>
                    <a href="#" title="<?php echo esc_attr($image_title); ?>">
                        <?php echo wp_get_attachment_image($attachment_id, 'gallery_thumb_auto_width', 0, $attr = array(
                            'title' => $image_title,
                            'alt' => $image_title
                        )); ?>
                    </a>
                    <?php
                }
            }
        }

        public function renderRoyol_Images($thumb_ids = array())
        {
            if (count($thumb_ids) == 0) return;
            foreach ($thumb_ids as $att_el) {
                $_thumb_class = 'rsTmb';
                if (is_array($att_el)) {
                    $attachment_id = $att_el[1];
                    $class[] = 'gallery-video';
                    $_rol_str = '<a class="item-%1$s rsImg" data-rsVideo="%5$s" href="%3$s">%4$s</a>';
                    $_thumb_class .= ' video';
                } else {
                    $attachment_id = $att_el;
                    $_rol_str = '<a class="item-%1$s rsImg" data-rsBigImg="%2$s" href="%3$s">%4$s</a>';
                }

                $image_meta = get_post($attachment_id);
                $image_title = isset($image_meta->post_title)? esc_attr($image_meta->post_title): 'Gallery image';

                $_big_img = wp_get_attachment_url($attachment_id);
                $_gl_image = wp_get_attachment_image_src($attachment_id, 'yesshop_blog_single');
                $_thumb = wp_get_attachment_image($attachment_id, 'gallery_thumb_auto_width', 0, $attr = array(
                    'title' => $image_title,
                    'alt' => $image_title,
                    'class' => $_thumb_class,
                ));

                printf($_rol_str, esc_attr($attachment_id), esc_url($_big_img), esc_url($_gl_image[0]), $_thumb, $att_el[0]);

            }
        }

    }

    if (!function_exists('Yetithemes_Gallery')) {
        function Yetithemes_Gallery()
        {
            return new Yetithemes_Gallery();
        }
    }

    Yetithemes_Gallery()->init();
}

