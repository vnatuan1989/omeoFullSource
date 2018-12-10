<?php
/**
 * Package: yesshop.
 */

if (class_exists('Yetithemes_Gallery') && function_exists('Yetithemes_Gallery')):
    $galleries = Yetithemes_Gallery()->get_galleries_data(get_the_ID());
    ?>


    <div class="gallery-content gallery-style-2">

        <?php if (!empty($galleries['att_img']) || !empty($galleries['v_link'])): ?>
            <?php
            $class = array('gallery-image-item');
            $thumb_ids = $galleries['thumb_ids'];

            $rol_options = apply_filters('yetithemes_gallery_royaloptions', array(
                'autoScaleSliderWidth' => 1170,
                'autoScaleSliderHeight' => 670
            ));
            ?>

            <div id="yeti_galleries" class="galleries-wrapper royalSlider rsDefault"
                 data-options="<?php echo esc_attr(wp_json_encode($rol_options)) ?>">

                <?php Yetithemes_Gallery()->renderRoyol_Images($thumb_ids); ?>

            </div>

        <?php endif; ?>

    </div>


<?php endif; ?>