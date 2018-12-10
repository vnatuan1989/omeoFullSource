<?php

if (!defined('ABSPATH')) exit;

class Yetithemes_Product_Gift
{

    function __construct()
    {
        //backend callback
        add_action('woocommerce_product_options_related', array($this, 'backend_options'));
        add_action('woocommerce_process_product_meta', array($this, 'save_data'), 10, 2);

        add_action('woocommerce_add_to_cart', array($this, 'add_gift_to_cart'), 50, 6);
        add_action('woocommerce_cart_item_removed', array($this, 'remove_cart_item'), 10, 2);
        add_action('woocommerce_single_product_summary', array($this, 'single_product_gift'), 20);
    }

    public function single_product_gift()
    {
        global $post;
        $product_ids = array_filter(array_map('absint', (array)get_post_meta($post->ID, '_productgift_ids', true)));

        if (empty($product_ids)) return;
        echo '<div class="single-product-gifts-wrapper">';
        /*echo '<h4>'.esc_html__('Promotion gift', 'yetithemes').'</h4>';*/

        echo '<ul class="product_list_widget single-product-gifts">';
        foreach ($product_ids as $product_id) :
            $product = new WC_Product($product_id);
            ?>

            <li>
                <a class="product-image" href="<?php echo esc_url(get_permalink($product->get_id())); ?>"
                   title="<?php echo esc_attr($product->get_title()); ?>">
                    <?php echo $product->get_image(); ?>
                </a>
                <div class="product-detail">
                    <span class="gift-label"><?php esc_html_e('Free gift', 'yetithemes') ?></span>
                    <a class="product-title" href="<?php echo esc_url(get_permalink($product->get_id())); ?>"
                       title="<?php echo esc_attr($product->get_title()); ?>"><?php echo $product->get_title(); ?></a>
                    <?php if (!empty($show_rating)) {
                        echo wc_get_rating_html( $product->get_average_rating() );
                    } ?>
                    <?php echo $product->get_price_html(); ?>
                </div>
            </li>
            <?php

        endforeach;

        echo '</ul></div>';
    }

    public function backend_options()
    {
        global $post;
        ?>
        <div class="options_group">

            <p class="form-field">
                <label for="grouped_products"><?php _e( 'Gift product items', 'yetithemes' ); ?></label>
                <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="productgift_ids" name="productgift_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'yetithemes' ); ?>"
                        data-action="woocommerce_json_search_products" data-exclude="<?php echo intval( $post->ID ); ?>">
                    <?php
                    $product_ids = array_filter(array_map('absint', (array)get_post_meta($post->ID, '_productgift_ids', true)));

                    foreach ( $product_ids as $product_id ) {
                        $product = wc_get_product( $product_id );
                        if ( is_object( $product ) ) {
                            echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
                        }
                    }
                    ?>
                </select> <?php echo wc_help_tip( __( 'This lets you choose which products are part of this group.', 'yetithemes' ) ); ?>
            </p>

        </div>
        <?php
    }

    public function save_data($post_id, $post)
    {
        $accessory_ids = isset($_POST['productgift_ids']) ? (array) $_POST['productgift_ids'] : array();
        update_post_meta($post_id, '_productgift_ids', $accessory_ids);
    }

    public function add_gift_to_cart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data)
    {
        $gift_ids = array_filter(array_map('absint', (array)get_post_meta($product_id, '_productgift_ids', true)));


        if (!empty($gift_ids)) {
            foreach ($gift_ids as $gift_id) {
                $product_status = get_post_status($gift_id);
                $gift_variation_id = $this->create_gift_variation($gift_id);

                if (false !== WC()->cart->add_to_cart($gift_id, $quantity, $gift_variation_id, array(__('Type', 'yetithemes') => __('Free gift', 'yetithemes')), array('gift_for' => $product_id, 'gift_for_item' => $cart_item_key)) && 'publish' === $product_status) {
                    do_action('woocommerce_ajax_added_to_cart', $gift_id);

                    if (get_option('woocommerce_cart_redirect_after_add') == 'yes') {
                        wc_add_to_cart_message(array($gift_id => $quantity), true);
                    }
                }
            }
        }
    }

    public function remove_cart_item($cart_item_key_removed, $cart)
    {
        //cart_contents
        foreach ($cart->cart_contents as $cart_item_key => $cart_item) {
            if (isset($cart_item['gift_for_item']) && $cart_item_key_removed === $cart_item['gift_for_item']) {
                $cart->remove_cart_item($cart_item_key);
            }
        }
    }

    private function create_gift_variation($product_id)
    {
        //check variation product exist
        $product_variation = get_posts(array(
            'post_parent' => $product_id,
            's' => 'yeti_product_gift_item',
            'post_type' => 'product_variation',
            'posts_per_page' => 1
        ));

        if (!empty($product_variation)) {
            $this->update_gift_metadata($product_variation[0]->ID, $product_id);
            return $product_variation[0]->ID;
        }

        $author = get_users(array(
            'orderby' => 'nicename',
            'role' => 'administrator',
            'number' => 1
        ));

        $variation = array(
            'post_author' => $author[0]->ID,
            'post_status' => 'publish',
            'post_name' => 'product-gift-variation-' . absint($product_id),
            'post_parent' => $product_id,
            'post_title' => 'yeti_product_gift_item',
            'post_type' => 'product_variation',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
        );

        $_gift_id = wp_insert_post($variation);

        $this->update_gift_metadata($_gift_id, $product_id);

        return $_gift_id;
    }

    private function update_gift_metadata($gift_id, $product_id)
    {
        update_post_meta($gift_id, '_price', 0);
        update_post_meta($gift_id, '_sale_price', 0);
        update_post_meta($gift_id, '_regular_price', get_post_meta($product_id, '_regular_price', true));
        update_post_meta($gift_id, '_virtual', get_post_meta($product_id, '_virtual', true));
        //update_post_meta( $gift_id, '_sold_individually', 'yes');
    }

}

new Yetithemes_Product_Gift();