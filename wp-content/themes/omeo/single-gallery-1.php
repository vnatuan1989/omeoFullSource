<?php
/**
 * Package: yesshop.
 */
if (class_exists('Yetithemes_Gallery') && function_exists('Yetithemes_Gallery')):

    $galleries = Yetithemes_Gallery()->get_galleries_data(get_the_ID());
    $k = 25;
    ?>

    <div class="gallery-content" data-max="<?php echo absint(count($galleries['thumb_ids'])) ?>"
         data-k="<?php echo esc_attr($k) ?>" data-number="16" data-post_id="<?php echo absint(get_the_ID()) ?>">


        <div class="yeti-isotope">

            <?php
            if (!empty($galleries['att_img']) || !empty($galleries['v_link'])):

                $thumb_ids = $galleries['thumb_ids'];
                array_splice($thumb_ids, $k);

                foreach ($thumb_ids as $att_el):
                    $class = '';

                    if (is_array($att_el)) {
                        $attachment_id = $att_el[1];
                        $class .= ' gallery-video';
                        $image_link = $att_el[0];
                        $_gall_class_a = 'btn_zoom mfp-iframe';
                        $img_icon = true;
                    } else {
                        $attachment_id = $att_el;
                        $image_link = wp_get_attachment_url($attachment_id);
                        $img_icon = false;
                        $_gall_class_a = 'btn_zoom';
                    }

                    if (!$image_link)
                        continue;

                    $image_title = esc_attr(get_the_title($attachment_id));

                    ?>

                    <div class="gallery-image-item yeti-images-gallery mass-images-gallery<?php echo esc_attr($class) ?>">
                        <a href="<?php echo esc_url($image_link); ?>" class="<?php echo esc_attr($_gall_class_a) ?>"
                           title="<?php echo esc_attr($image_title); ?>">
                            <?php if ($img_icon) :
                                Yesshop_Functions()->getImage(array(
                                    'alt' => esc_attr__('Media icon image', 'omeo'),
                                    'src' => esc_url(THEME_IMG_URI . 'media_icon.png'),
                                    'class' => 'media_icon'
                                ));
                                ?>
                            <?php endif; ?>
                            <?php echo wp_get_attachment_image($attachment_id, 'gallery_thumb_auto', 0, $attr = array(
                                'title' => $image_title,
                                'alt' => $image_title
                            )); ?>
                        </a>
                    </div>

                    <?php

                endforeach;
            endif;
            ?>

        </div>

        <?php if (absint(count($galleries['thumb_ids'])) >= $k): ?>

            <div class="text-center">
                <?php
                yesshop_loadmore_btn('fa fa-refresh', 'button', array(
                    'class' => 'nth_gallery_load_more button'
                ));
                ?>
            </div>

        <?php endif; ?>

    </div>

<?php endif; ?>