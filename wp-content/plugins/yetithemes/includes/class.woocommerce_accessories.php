<?php

if (!defined('ABSPATH')) exit;

class Yetithemes_Product_Accessories {

    function __construct() {

        if(is_admin()) {
            add_action('woocommerce_product_options_related', array($this, 'backend_options'));
            add_action('woocommerce_process_product_meta', array($this, 'save_data'), 10, 2);
        } else {
            add_filter('woocommerce_product_tabs', array($this, 'woocommere_accessories_tabs'));
        }


        //add_action('woocommerce_add_to_cart', array($this, 'add_gift_to_cart'), 50, 6);
       // add_action('woocommerce_cart_item_removed', array($this, 'remove_cart_item'), 10, 2);
        //add_action('woocommerce_single_product_summary', array($this, 'single_product_gift'), 20);
    }

    public function backend_options()
    {
        global $post;
        ?>
        <div class="options_group">

            <p class="form-field">
                <label for="grouped_products"><?php _e( 'Accessories', 'yetithemes' ); ?></label>
                <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="accessory_ids" name="accessory_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'yetithemes' ); ?>"
                        data-action="woocommerce_json_search_products" data-exclude="<?php echo intval( $post->ID ); ?>">
                    <?php
                    $product_ids = array_filter(array_map('absint', (array)get_post_meta($post->ID, '_accessory_ids', true)));

                    foreach ( $product_ids as $product_id ) {
                        $product = wc_get_product( $product_id );
                        if ( is_object( $product ) ) {
                            echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
                        }
                    }
                    ?>
                </select> <?php echo wc_help_tip( __( 'Accessories are products which you recommend to be bought along with this product.', 'yetithemes' ) ); ?>
            </p>

        </div>
        <?php
    }

    public function save_data($post_id, $post){
        $accessory_ids = isset($_POST['accessory_ids'])? (array) $_POST['accessory_ids'] : array();
        update_post_meta($post_id, '_accessory_ids', $accessory_ids);
    }

    public function woocommere_accessories_tabs( $tabs = array() ) {
        global $product;

        $accessories = Yesshop_WC_Helper()->get_accessories($product);

        if (sizeof($accessories) > 0 && $product->is_type(array('simple', 'variable'))) {

            $tabs['accessories'] = array(
                'title' => esc_html__('Accessories', 'yesshop'),
                'priority' => 5,
                'callback' => array($this, 'get_template'),
            );
        }
        return $tabs;
    }

    public function get_template(){
        wc_get_template('single-product/tabs/accessories.php');
    }

}

new Yetithemes_Product_Accessories();