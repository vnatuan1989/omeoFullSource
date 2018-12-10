<?php
/**
 * Package: yesshop.
 * User: kinhdon
 * Vertion: 1.0
 */
if($products->have_posts()):

?>

    <?php
    $class1 = 'yeti-woo-shortcode trainding-products-section';
    $options = array(
        'items' => 1,
        'responsive' => array(
            0 => array(
                'items' => 1,
                'loop' => true
            )
        ),
    );

    $_trending_style = explode(' ', $style);
    $_thumb_style = $_trending_style[0];
    if(count($_trending_style) > 2) {
        $_thumb_style_3 = $_trending_style[2];
    }
    unset($_trending_style[0]);


    $class1 .= ' '. implode(' ', $_trending_style);

    if($is_slider) {
        $options = YetiThemes_Extra()->get_owlResponsive($options);
        printf('<div class="%2$s yeti-owlCarousel yeti-loading light" data-options="%1$s" data-base="1">', esc_attr(json_encode($options)), $class1);
        YetiThemes_Extra()->get_yetiLoadingIcon();
    } else {
        printf('<div class="%1$s">', $class1);
    }

    ?>

    <?php if(!empty($title)): ?><h3 class="heading-title"><?php echo esc_html($title)?></h3><?php endif;?>

    <div class="yeti-owl-slider products">

    <?php while ($products->have_posts()) : $products->the_post(); global $product;?>

        <?php

        $attachment_ids = array();
        if(!empty($prod_group)) {
            if(!empty($_trending_style) && $_thumb_style === 'gallery') {
                $post_thumbnail_id = get_post_thumbnail_id( $product->get_id() );
                $image = wp_get_attachment_image( $post_thumbnail_id , 'shop_single', false );
                $attachment_ids = apply_filters('yesshop_include_thumb_id', $product->get_gallery_image_ids());

            } else {
                $_thumb_id = 0;
                foreach ($prod_group as $data) {
                    if(!empty($data['id']) && absint($data['id']) === $product->get_id()) {
                        $_thumb_id = absint($data['thumb']);
                    }
                }
                if($_thumb_id) {
                    $image = wp_get_attachment_image($_thumb_id, 'full');
                } else {
                    $post_thumbnail_id = get_post_thumbnail_id( $product->get_id() );
                    $image = wp_get_attachment_image( $post_thumbnail_id , 'shop_single', false );
                }
            }

        } else {
            $post_thumbnail_id = get_post_thumbnail_id( $product->get_id() );
            $image = wp_get_attachment_image( $post_thumbnail_id , 'shop_single', false );
            $attachment_ids = apply_filters('yesshop_include_thumb_id', $product->get_gallery_image_ids());
        }

        ?>

        <div class="product">
            <?php if(!empty($_trending_style) && $_thumb_style === 'overlay-style-1') { ?>
                <div class="product-image <?php echo esc_attr($_thumb_style)?>-style">
                    <?php echo $image;?>
                </div>
                <div class="yt-trending-content">
                    <div class="container">
                        <div class="row">
                            <div class="mixin-wp_table">
                                <div class="mixin-wp_tablecell">
                                    <div class="col-sm-10">
                                        <div class="block-title">
                                            <h3><?php echo $title; ?></h3>
                                            <small><?php echo $sub_title; ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-14">
                                        <div class="product-summary">
                                            <div class="inner">
                                                <a class="yt-product-title" href="<?php echo get_the_permalink();?>"><?php woocommerce_template_loop_product_title()?></a>

                                                <?php yesshop_woocommerce_loop_excerpt($words);?>

                                                <?php Yesshop_CountDown::countdown_render(); ?>

                                                <div class="product-buttons">
                                                    <?php woocommerce_template_loop_add_to_cart();?>
                                                </div>
                                                <div class="yt-price-wrap">
                                                    <?php woocommerce_template_loop_price(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else if(!empty($_trending_style) && $_thumb_style === 'overlay-style-2') { ?>
                <div class="product-image <?php echo esc_attr($_thumb_style)?>-style">
                    <?php echo $image;?>
                </div>
                <div class="yt-trending-content">
                    <div class="container">
                        <div class="row">
                            <div class="mixin-wp_table">
                                <div class="mixin-wp_tablecell">
                                    <div class="col-sm-8">
                                        <div class="yt-price-wrap">
                                            <?php woocommerce_template_loop_price(); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-16">
                                        <div class="product-summary">
                                            <div class="inner">
                                                <div class="block-title">
                                                    <small><?php echo $sub_title; ?></small>
                                                    <h3><?php echo $title; ?></h3>

                                                </div>
                                                <a class="yt-product-title" href="<?php echo get_the_permalink();?>"><?php woocommerce_template_loop_product_title()?></a>

                                                <?php yesshop_woocommerce_loop_excerpt($words);?>

                                                <?php Yesshop_CountDown::countdown_render(); ?>

                                                <div class="product-buttons">
                                                    <?php woocommerce_template_loop_add_to_cart();?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else if(!empty($_trending_style) && $_thumb_style_3 === 'yt-thumbnail-right') { ?>
                <div class="container">
                <div class="row">
                    <div class="product-summary col-lg-12 col-md-24">
                        <div class="inner">
                            <a class="yt-product-title" href="<?php echo get_the_permalink(); ?>"><?php woocommerce_template_loop_product_title(); ?></a>
                            <?php yesshop_woocommerce_loop_excerpt($words); ?>
                            <?php Yesshop_CountDown::countdown_render(); ?>
                            <div class="product-buttons">
                                <?php woocommerce_template_loop_add_to_cart(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="product-image <?php echo esc_attr($_thumb_style_3); ?>-style col-lg-12 hidden-xs">
                        <div class="inner">
                            <?php woocommerce_template_loop_price(); ?>
                            <div class="yt-product-img">
                                <?php echo $image; ?>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <?php } else { ?>
            <div class="container">
                <div class="row">
                    <div class="product-image <?php echo esc_attr($_thumb_style)?>-style col-lg-12 hidden-xs">
                        <div class="inner">
                            <?php woocommerce_template_loop_price(); ?>
                            <div class="yt-product-img">
                                <?php echo $image;?>
                            </div>
                        </div>
                    </div>
                    <div class="product-summary col-lg-12 col-md-24">
                        <div class="inner">

                            <a class="yt-product-title" href="<?php echo get_the_permalink();?>"><?php woocommerce_template_loop_product_title()?></a>

                            <?php yesshop_woocommerce_loop_excerpt($words);?>

                            <?php Yesshop_CountDown::countdown_render(); ?>

                            <div class="product-buttons">
                                <?php woocommerce_template_loop_add_to_cart();?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

    <?php endwhile;?>

    </div>

    </div>
<script type="text/javascript">
    jQuery(window).load(function() {
        setHeight()
    })

    jQuery(window).resize(function(){
        setHeight()
    })

    function setHeight() {
        if(jQuery('.yt-trending-overlay .product .product-image').length > 0) {
            jQuery('.yt-trending-overlay .product .product-image').each(function() {
                $_height = jQuery(this).height();
                $_parent = jQuery(this).parent();
                $_parent.find('.mixin-wp_table .mixin-wp_tablecell').css('height', $_height + 'px');
            })
        }
    }
</script>
<?php

endif;