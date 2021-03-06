<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $yith_woocompare, $product;

if (!empty($products)) : ?>

    <div class="table-responsive yeti-compare-wrapper">
        <table class="table table-compare compare-list">
            <tbody>
            <tr>
                <th>&nbsp;</th>
                <?php foreach ($products as $key => $product) : ?>
                    <td class="text-center product_<?php echo esc_attr($product->get_id()) ?>">
                        <a class="yeti-compare-remove"
                           href="<?php echo esc_url($yith_woocompare->obj->remove_product_url($product->get_id())); ?>"
                           data-product_id="<?php echo $product->get_id(); ?>"><span class="text-danger"><i
                                        class="fa fa-times" aria-hidden="true"></i></span></a>
                    </td>
                <?php endforeach; ?>
            </tr>

            <?php
            $_showed = array('image', 'title');
            if (isset($fields['image']) && isset($fields['title'])) : ?>
                <tr>
                    <th><?php echo esc_html__('Product', 'yetithemes'); ?></th>
                    <?php foreach ($products as $key => $product) : ?>
                        <td class="text-center product_<?php echo esc_attr($product->get_id()) ?>">
                            <div class="product-image">
                                <?php
                                if (has_post_thumbnail($product->post->ID)) {
                                    echo get_the_post_thumbnail($product->post->ID, 'shop_catalog');
                                } elseif (wc_placeholder_img_src()) {
                                    echo wc_placeholder_img_src('shop_catalog');
                                }
                                ?>
                            </div>
                            <div class="product-info">
					<span class="product-title"><a href="<?php echo get_permalink($product->post->ID); ?>"
                                                   class="product">
						<?php echo esc_html($product->fields['title']); ?>
					</a></span>
                                <?php wc_get_template('loop/rating.php', array('product', $product)); ?>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endif; ?>

            <?php foreach ($fields as $field => $name) : if (in_array($field, $_showed)) continue; ?>
                <tr class="<?php echo $field ?>">
                    <th>
                        <?php echo esc_html($name); ?>
                        <?php if ($field == 'image') echo '<div class="fixed-th"></div>'; ?>
                    </th>
                    <?php foreach ($products as $i => $product) : ?>
                        <td class="text-center product_<?php echo esc_attr($product->get_id()) ?>">
                            <?php
                            switch ($field) {

                                case 'image':
                                    echo '<div class="image-wrap">' . wp_get_attachment_image($product->fields[$field], 'yith-woocompare-image') . '</div>';
                                    break;

                                case 'add-to-cart':
                                    woocommerce_template_loop_add_to_cart();
                                    break;

                                default:
                                    echo empty($product->fields[$field]) ? '&nbsp;' : $product->fields[$field];
                                    break;
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>

            <?php if ($repeat_price == 'yes' && isset($fields['price'])) : ?>
                <tr class="text-center price repeated">
                    <th><?php echo $fields['price'] ?></th>

                    <?php foreach ($products as $i => $product) : ?>
                        <td class="product_<?php echo esc_attr($product->get_id()) ?>"><?php echo $product->fields['price'] ?></td>
                    <?php endforeach; ?>

                </tr>
            <?php endif; ?>

            <?php if ($repeat_add_to_cart == 'yes' && isset($fields['add-to-cart'])) : ?>
                <tr class="text-center add-to-cart repeated">
                    <th><?php echo $fields['add-to-cart'] ?></th>

                    <?php foreach ($products as $i => $product) : ?>
                        <td class="product_<?php echo esc_attr($product->get_id()) ?>"><?php woocommerce_template_loop_add_to_cart(); ?></td>
                    <?php endforeach; ?>

                </tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>

<?php else: ?>

    <p><?php esc_html_e('No products were added to the compare table', 'yetithemes') ?></p>

    <a class="btn" href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"
       title="<?php esc_html_e('Return to shop', 'yetithemes') ?>"><i class="fa fa-reply"
                                                                      aria-hidden="true"></i><?php esc_html_e('Return to shop', 'yetithemes') ?>
    </a>

<?php endif; ?>
