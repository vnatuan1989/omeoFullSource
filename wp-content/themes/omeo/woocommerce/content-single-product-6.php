<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="product-image-summary-wrap row">
        <?php
        /**
         * woocommerce_before_single_product_summary hook.
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */

        $columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
        $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
        $full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
        $thumbnail_post    = get_post( $post_thumbnail_id );
        $image_title       = get_post_field( 'post_excerpt', $post_thumbnail_id );
        $placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
        $wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
            'woocommerce-product-gallery',
            'woocommerce-product-gallery--' . $placeholder,
            'woocommerce-product-gallery--columns-' . absint( $columns ),
            'images',
        ) );

        $_slider_wrap = array('p_image');

        $attachment_ids = apply_filters('yesshop_include_thumb_id', $product->get_gallery_image_ids());

        ?>
        <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">

            <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $_slider_wrap ) ) ); ?>">

                <figure class="woocommerce-product-gallery__wrapper">
                    <?php
                    $attributes = array(
                        'title'                   => $image_title,
                        'data-src'                => $full_size_image[0],
                        'data-large_image'        => $full_size_image[0],
                        'data-large_image_width'  => $full_size_image[1],
                        'data-large_image_height' => $full_size_image[2],
                    );

                    if ( has_post_thumbnail() && $attachment_ids ) {

                        foreach ( $attachment_ids as $attachment_id ) {
                            $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
                            $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
                            $thumbnail_post   = get_post( $attachment_id );
                            $image_title      = get_post_field( 'post_excerpt', $attachment_id );;

                            $attributes = array(
                                'title'                   => $image_title,
                                'data-src'                => $full_size_image[0],
                                'data-large_image'        => $full_size_image[0],
                                'data-large_image_width'  => $full_size_image[1],
                                'data-large_image_height' => $full_size_image[2],
                            );

                            $html  = '<div data-id="'.esc_attr($attachment_id).'" data-thumb="' . esc_url( $thumbnail[0] ) . '" class="gallery__image"><a class="product-image" href="' . esc_url( $full_size_image[0] ) . '">';
                            $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
                            $html .= '</a></div>';

                            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
                        }
                    } else {
                        $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                        $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'omeo' ) );
                        $html .= '</div>';

                        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
                    }
                    ?>
                </figure>

            </div>
        </div>

        <div class="summary entry-summary">

            <?php
            /**
             * woocommerce_single_product_summary hook.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */
            do_action( 'woocommerce_single_product_summary' );

            woocommerce_output_product_data_tabs();
            ?>

        </div><!-- .summary -->
    </div>


    <div class="container">
        <?php
        /**
         * woocommerce_after_single_product_summary hook.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        do_action( 'woocommerce_after_single_product_summary' );
        ?>
    </div>


</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
